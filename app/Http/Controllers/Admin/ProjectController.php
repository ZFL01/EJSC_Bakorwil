<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminLog;
use App\Models\Client;
use App\Models\Mentor;
use App\Models\Project;
use App\Models\Talent;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Daftar project (dipakai Excel Export & peta GIS).
     */
    public function index(Request $request)
    {
        $query = Project::withCount(['mentors', 'talents', 'clients']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_project', 'ILIKE', "%{$search}%")
                    ->orWhere('opd', 'ILIKE', "%{$search}%")
                    ->orWhere('bidang', 'ILIKE', "%{$search}%");
            });
        }

        if ($request->filled('tahun')) {
            $query->where('tahun', (int) $request->tahun);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $projects = $query->orderByDesc('tahun')->orderBy('opd')->paginate(15);

        $tahunList = Project::query()
            ->select('tahun')
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun');

        return view('admin.projects.index', compact('projects', 'tahunList'));
    }

    /**
     * Form tambah project.
     */
    public function create()
    {
        return view('admin.projects.create');
    }

    /**
     * Simpan project baru.
     * Ada penjagaan duplikasi (tahun + OPD + bidang) supaya kejadian
     * data ganda seperti project 2026 tidak terulang.
     */
    public function store(Request $request)
    {
        $validated = $this->validateProject($request);

        if ($this->isDuplicate($validated)) {
            return back()->withInput()
                ->with('error', 'Sudah ada project dengan OPD dan bidang yang sama pada tahun tersebut.');
        }

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('projects', 'public');
        }

        $project = Project::create($validated);

        AdminLog::log(
            auth()->id(),
            'create',
            'project',
            $project->id_project,
            null,
            $project->toArray()
        );

        return redirect()
            ->route('admin.projects.show', $project->id_project)
            ->with('success', 'Project berhasil ditambahkan. Silakan tautkan mentor, talenta, dan client.');
    }

    /**
     * Detail project + penautan anggota (mentor/talenta/client).
     */
    public function show(Project $project)
    {
        $project->load(['mentors', 'talents', 'clients']);

        // Kandidat yang bisa ditautkan: status aktif & belum terhubung ke project ini
        $mentorOptions = Mentor::active()
            ->whereNotIn('id_mentor', $project->mentors->pluck('id_mentor'))
            ->orderBy('nama')
            ->get(['id_mentor', 'nama', 'keahlian']);

        $talentOptions = Talent::active()
            ->whereNotIn('id_talenta', $project->talents->pluck('id_talenta'))
            ->orderBy('nama')
            ->get(['id_talenta', 'nama', 'keahlian']);

        $clientOptions = Client::active()
            ->whereNotIn('id_client', $project->clients->pluck('id_client'))
            ->orderBy('nama_ukm')
            ->get(['id_client', 'nama_ukm', 'nama_produk']);

        return view('admin.projects.show', compact(
            'project',
            'mentorOptions',
            'talentOptions',
            'clientOptions'
        ));
    }

    /**
     * Form ubah project.
     */
    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    /**
     * Update project.
     */
    public function update(Request $request, Project $project)
    {
        $validated = $this->validateProject($request);

        if ($this->isDuplicate($validated, $project->id_project)) {
            return back()->withInput()
                ->with('error', 'Sudah ada project lain dengan OPD dan bidang yang sama pada tahun tersebut.');
        }

        $old = $project->toArray();
        if ($request->hasFile('gambar')) {
            if ($project->gambar) {
                Storage::disk('public')->delete($project->gambar);
            }

            $validated['gambar'] = $request->file('gambar')->store('projects', 'public');
        }

        $project->update($validated);

        AdminLog::log(
            auth()->id(),
            'update',
            'project',
            $project->id_project,
            $old,
            $project->fresh()->toArray()
        );

        return redirect()
            ->route('admin.projects.show', $project->id_project)
            ->with('success', 'Project berhasil diupdate.');
    }

    /**
     * Tautkan satu anggota (mentor/talenta/client) ke project.
     */
    public function attach(Request $request, Project $project)
    {
        $data = $request->validate([
            'type' => ['required', 'in:mentor,talenta,client'],
            'id' => ['required', 'integer'],
        ]);

        $config = $this->memberMap()[$data['type']];
        $model = $config['model']::findOrFail($data['id']);

        $sudah = DB::table($config['table'])
            ->where('id_project', $project->id_project)
            ->where($config['fk'], $model->getKey())
            ->exists();

        if ($sudah) {
            return back()->with('error', 'Anggota ini sudah tertaut ke project.');
        }

        try {
            DB::table($config['table'])->insert([
                'id_project' => $project->id_project,
                $config['fk'] => $model->getKey(),
            ]);
        } catch (QueryException $e) {
            if ((string) $e->getCode() === '23505') {
                return back()->with('error', 'Anggota ini sudah tertaut ke project.');
            }

            throw $e;
        }

        AdminLog::log(
            auth()->id(),
            'attach',
            $config['table'],
            $project->id_project,
            null,
            [$config['fk'] => $model->getKey()]
        );

        $label = $model->nama ?? $model->nama_ukm ?? ('#'.$model->getKey());

        return back()->with('success', ucfirst($data['type']).' "'.$label.'" berhasil ditautkan ke project.');
    }

    /**
     * Lepas tautan anggota dari project.
     */
    public function detach(Request $request, Project $project)
    {
        $data = $request->validate([
            'type' => ['required', 'in:mentor,talenta,client'],
            'id' => ['required', 'integer'],
        ]);

        $config = $this->memberMap()[$data['type']];

        $deleted = DB::table($config['table'])
            ->where('id_project', $project->id_project)
            ->where($config['fk'], $data['id'])
            ->delete();

        if (! $deleted) {
            return back()->with('error', 'Tautan tidak ditemukan.');
        }

        AdminLog::log(
            auth()->id(),
            'detach',
            $config['table'],
            $project->id_project,
            [$config['fk'] => (int) $data['id']],
            null
        );

        return back()->with('success', 'Tautan berhasil dilepas dari project.');
    }

    /**
     * Hapus project (beserta seluruh tautan anggotanya).
     */
    public function destroy(Project $project)
    {
        $old = $project->toArray();
        $id = $project->id_project;

        if ($project->gambar) {
            Storage::disk('public')->delete($project->gambar);
        }

        DB::transaction(function () use ($project) {
            // Lepas tautan dulu (tabel legacy tidak punya FK cascade)
            DB::table('project_mentor')->where('id_project', $project->id_project)->delete();
            DB::table('project_talenta')->where('id_project', $project->id_project)->delete();
            DB::table('project_client')->where('id_project', $project->id_project)->delete();

            $project->delete();
        });

        AdminLog::log(
            auth()->id(),
            'delete',
            'project',
            $id,
            $old,
            null
        );

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project berhasil dihapus.');
    }

    /**
     * Aturan validasi project.
     */
    private function validateProject(Request $request): array
    {
        return $request->validate([
            'tahun' => ['required', 'integer', 'min:2000', 'max:2100'],
            'nama_project' => ['required', 'string', 'max:255'],
            'opd' => ['required', 'string', 'max:255'],
            'bidang' => ['nullable', 'string', 'max:255'],
            'tanggal' => ['nullable', 'date'],
            'output_project' => ['nullable', 'string'],
            'status' => ['required', 'in:draft,berjalan,selesai,dibatalkan'],
            'link' => ['nullable', 'url:http,https', 'max:2048'],
            'gambar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);
    }

    /**
     * Cegah project duplikat: kombinasi tahun + OPD + bidang.
     */
    private function isDuplicate(array $validated, ?int $ignoreId = null): bool
    {
        return Project::where('tahun', $validated['tahun'])
            ->where('opd', $validated['opd'])
            ->where('bidang', $validated['bidang'] ?? '')
            ->when($ignoreId, fn ($q) => $q->where('id_project', '!=', $ignoreId))
            ->exists();
    }

    /**
     * Peta tipe anggota -> tabel pivot legacy.
     */
    private function memberMap(): array
    {
        return [
            'mentor' => ['model' => Mentor::class,  'fk' => 'id_mentor',  'table' => 'project_mentor'],
            'talenta' => ['model' => Talent::class,  'fk' => 'id_talenta', 'table' => 'project_talenta'],
            'client' => ['model' => Client::class,  'fk' => 'id_client',  'table' => 'project_client'],
        ];
    }
}
