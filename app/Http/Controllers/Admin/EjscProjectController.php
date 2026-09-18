<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminLog;
use App\Models\EjscProject;
use App\Models\Mentor;
use App\Models\Talent;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EjscProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = EjscProject::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($builder) use ($search) {
                $builder->where('judul', 'ILIKE', "%{$search}%")
                    ->orWhere('ringkasan', 'ILIKE', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $projects = $query->orderBy('sort_order')->latest()->paginate(15);

        return view('admin.ejsc-projects.index', compact('projects'));
    }

    public function create()
    {
        return view('admin.ejsc-projects.create');
    }

    public function show(EjscProject $ejscProject)
    {
        $ejscProject->load(['talents', 'mentors', 'experts']);

        $talentOptions = Talent::active()
            ->whereNotIn('id_talenta', $ejscProject->talents->pluck('id_talenta'))
            ->orderBy('nama')
            ->get(['id_talenta', 'nama', 'keahlian']);
        $mentorOptions = Mentor::active()
            ->whereNotIn('id_mentor', $ejscProject->mentors->pluck('id_mentor'))
            ->orderBy('nama')
            ->get(['id_mentor', 'nama', 'keahlian']);

        return view('admin.ejsc-projects.show', compact('ejscProject', 'talentOptions', 'mentorOptions'));
    }

    public function attach(Request $request, EjscProject $ejscProject)
    {
        $data = $request->validate([
            'type' => ['required', 'in:talenta,mentor,tenaga_ahli'],
            'id' => ['nullable', 'integer'],
            'nama' => ['nullable', 'string', 'max:255'],
            'keahlian' => ['nullable', 'string', 'max:255'],
        ]);

        if ($data['type'] === 'talenta') {
            $ejscProject->talents()->syncWithoutDetaching([(int) $data['id']]);
            return back()->with('success', 'Talenta berhasil ditautkan.');
        }

        if ($data['type'] === 'mentor') {
            $ejscProject->mentors()->syncWithoutDetaching([(int) $data['id']]);
            return back()->with('success', 'Mentor berhasil ditautkan.');
        }

        if (blank($data['nama'])) {
            return back()->with('error', 'Nama tenaga ahli wajib diisi.');
        }

        $ejscProject->experts()->create([
            'nama' => $data['nama'],
            'keahlian' => $data['keahlian'] ?? null,
        ]);

        return back()->with('success', 'Tenaga ahli berhasil ditambahkan.');
    }

    public function detach(Request $request, EjscProject $ejscProject)
    {
        $data = $request->validate([
            'type' => ['required', 'in:talenta,mentor,tenaga_ahli'],
            'id' => ['required', 'integer'],
        ]);

        if ($data['type'] === 'talenta') {
            $ejscProject->talents()->detach($data['id']);
        } elseif ($data['type'] === 'mentor') {
            $ejscProject->mentors()->detach($data['id']);
        } else {
            $ejscProject->experts()->whereKey($data['id'])->delete();
        }

        return back()->with('success', 'Anggota berhasil dilepas dari projek.');
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $data['galeri'] = $this->storeGallery($request);
        $project = EjscProject::create($data);

        AdminLog::log(auth()->id(), 'create', 'ejsc_project', $project->id, null, $project->toArray());

        return redirect()->route('admin.ejsc-projects.index')
            ->with('success', 'Projek Kami berhasil ditambahkan.');
    }

    public function edit(EjscProject $ejscProject)
    {
        return view('admin.ejsc-projects.edit', ['project' => $ejscProject]);
    }

    public function update(Request $request, EjscProject $ejscProject)
    {
        $oldValues = $ejscProject->toArray();
        $data = $this->validatedData($request);

        $galeri = $ejscProject->galeri ?? [];
        foreach ($request->input('hapus_galeri', []) as $imagePath) {
            if (in_array($imagePath, $galeri, true)) {
                Storage::disk('public')->delete($imagePath);
                $galeri = array_values(array_diff($galeri, [$imagePath]));
            }
        }
        if ($request->hasFile('galeri')) {
            foreach ($request->file('galeri') as $image) {
                $galeri[] = $image->store('ejsc-projects/gallery', 'public');
            }
        }
        $data['galeri'] = array_values(array_unique($galeri));

        $ejscProject->update($data);

        AdminLog::log(auth()->id(), 'update', 'ejsc_project', $ejscProject->id, $oldValues, $ejscProject->fresh()->toArray());

        return redirect()->route('admin.ejsc-projects.index')
            ->with('success', 'Projek Kami berhasil diperbarui.');
    }

    public function destroy(EjscProject $ejscProject)
    {
        $oldValues = $ejscProject->toArray();
        foreach ($ejscProject->galeri ?? [] as $imagePath) {
            Storage::disk('public')->delete($imagePath);
        }
        $ejscProject->delete();

        AdminLog::log(auth()->id(), 'delete', 'ejsc_project', $ejscProject->id, $oldValues, null);

        return redirect()->route('admin.ejsc-projects.index')
            ->with('success', 'Projek Kami berhasil dihapus.');
    }

    private function validatedData(Request $request): array
    {
        $data = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'ringkasan' => ['nullable', 'string', 'max:500'],
            'deskripsi' => ['nullable', 'string'],
            'link' => ['nullable', 'url:http,https', 'max:2048'],
            'tahun' => ['nullable', 'integer', 'min:2000', 'max:2100'],
            'status' => ['required', 'in:rencana,berjalan,selesai'],
            'is_published' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'galeri' => ['nullable', 'array', 'max:12'],
            'galeri.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'hapus_galeri' => ['nullable', 'array'],
        ]);

        $data += [
            'is_published' => $request->boolean('is_published'),
            'sort_order' => (int) $request->input('sort_order', 0),
        ];

        return $data;
    }

    private function storeGallery(Request $request): array
    {
        $paths = [];

        foreach ($request->file('galeri', []) as $image) {
            $paths[] = $image->store('ejsc-projects/gallery', 'public');
        }

        return $paths;
    }

}
