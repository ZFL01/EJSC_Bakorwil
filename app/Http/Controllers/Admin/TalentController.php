<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Talent;
use App\Models\Mentor;
use App\Models\User;
use App\Models\Wilayah;
use App\Models\AdminLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class TalentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Talent::class);

        $query = Talent::with('user', 'mentor');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'ILIKE', "%{$search}%")
                  ->orWhere('keahlian', 'ILIKE', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('status_pekerjaan')) {
            $query->where('status_pekerjaan', $request->status_pekerjaan);
        }

        if ($request->filled('mentor_id')) {
            $query->where('mentor_id', $request->mentor_id);
        }

        $talents = $query->latest()->paginate(15);
        $mentors = Mentor::active()->get();

        return view('admin.talents.index', compact('talents', 'mentors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Talent::class);
        
        $mentors = Mentor::active()->get();
        $wilayah = Wilayah::orderBy('nama_wilayah')->get();
        
        return view('admin.talents.create', compact('mentors', 'wilayah'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Talent::class);

        $validated = $request->validate([
            'user_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'nama' => 'required|string|max:255',
            'no_wa' => 'required|string|max:20',
            'alamat_lengkap' => 'required|string',
            'id_wilayah' => 'required|exists:wilayah,id_wilayah',
            'domisili' => 'required|string|max:255',
            'keahlian' => 'required|string|max:255',
            'pengalaman' => 'nullable|string',
            'skill_tags' => 'nullable|string',
            'mentor_id' => 'nullable|exists:mentor,id_mentor',
            'status_pekerjaan' => 'nullable|in:bekerja,belum bekerja,magang',
            'url_foto_ktp' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'url_cv' => 'nullable|mimes:pdf,doc,docx|max:5120',
            'url_butap' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required|in:aktif,tidak aktif',
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $validated['user_name'],
                'email' => $validated['email'],
                'password_hash' => Hash::make($validated['password']),
                'role' => 'talenta',
            ]);

            $ktpPath = $request->hasFile('url_foto_ktp') 
                ? $request->file('url_foto_ktp')->store('ktp', 'public') 
                : null;
            
            $cvPath = $request->hasFile('url_cv') 
                ? $request->file('url_cv')->store('cv', 'public') 
                : null;

            $butapPath = $request->hasFile('url_butap') 
                ? $request->file('url_butap')->store('butap', 'public') 
                : null;

            $skillTags = $validated['skill_tags'] 
                ? array_map('trim', explode(',', $validated['skill_tags'])) 
                : [];

            $talent = Talent::create([
                'id_user' => $user->id_user,
                'nama' => $validated['nama'],
                'no_wa' => $validated['no_wa'],
                'alamat_lengkap' => $validated['alamat_lengkap'],
                'id_wilayah' => $validated['id_wilayah'],
                'domisili' => $validated['domisili'],
                'keahlian' => $validated['keahlian'],
                'pengalaman' => $validated['pengalaman'],
                'skill_tags' => $skillTags,
                'mentor_id' => $validated['mentor_id'],
                'status_pekerjaan' => $validated['status_pekerjaan'],
                'url_ktp' => $ktpPath,
                'url_cv' => $cvPath,
                'url_butap' => $butapPath,
                'status' => $validated['status'],
                'created_by' => auth()->id(),
            ]);

            // Update mentor's mentee count
            if ($validated['mentor_id']) {
                Mentor::where('id_mentor', $validated['mentor_id'])
                    ->increment('jumlah_mentee');
            }

            AdminLog::log(
                auth()->id(),
                'create',
                'talenta',
                $talent->id_talenta,
                null,
                $talent->toArray()
            );

            DB::commit();

            return redirect()->route('admin.talents.index')
                ->with('success', 'Talent berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()->withInput()
                ->with('error', 'Gagal menambahkan talent: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Talent $talent)
    {
        $this->authorize('view', $talent);

        $talent->load('user', 'mentor', 'creator', 'updater');

        return view('admin.talents.show', compact('talent'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Talent $talent)
    {
        $this->authorize('update', $talent);

        $mentors = Mentor::active()->get();
        $wilayah = Wilayah::orderBy('nama_wilayah')->get();

        return view('admin.talents.edit', compact('talent', 'mentors', 'wilayah'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Talent $talent)
    {
        $this->authorize('update', $talent);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'no_wa' => 'required|string|max:20',
            'alamat_lengkap' => 'required|string',
            'keahlian' => 'required|string|max:255',
            'pengalaman' => 'nullable|string',
            'skill_tags' => 'nullable|string',
            'mentor_id' => 'nullable|exists:mentor,id_mentor',
            'status_pekerjaan' => 'nullable|in:bekerja,belum bekerja,magang',
            'url_foto_ktp' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'url_cv' => 'nullable|mimes:pdf,doc,docx|max:5120',
            'url_butap' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required|in:aktif,tidak aktif',
        ]);

        DB::beginTransaction();
        try {
            $oldValues = $talent->toArray();
            $oldMentorId = $talent->mentor_id;

            if ($request->hasFile('url_foto_ktp')) {
                if ($talent->url_ktp) {
                    Storage::disk('public')->delete($talent->url_ktp);
                }
                $validated['url_ktp'] = $request->file('url_foto_ktp')->store('ktp', 'public');
            }

            if ($request->hasFile('url_cv')) {
                if ($talent->url_cv) {
                    Storage::disk('public')->delete($talent->url_cv);
                }
                $validated['url_cv'] = $request->file('url_cv')->store('cv', 'public');
            }

            if ($request->hasFile('url_butap')) {
                if ($talent->url_butap) {
                    Storage::disk('public')->delete($talent->url_butap);
                }
                $validated['url_butap'] = $request->file('url_butap')->store('butap', 'public');
            }

            if (isset($validated['skill_tags'])) {
                $validated['skill_tags'] = array_map('trim', explode(',', $validated['skill_tags']));
            }

            $validated['updated_by'] = auth()->id();
            $talent->update($validated);

            // Update mentor's mentee count
            if ($oldMentorId !== $validated['mentor_id']) {
                if ($oldMentorId) {
                    Mentor::where('id_mentor', $oldMentorId)->decrement('jumlah_mentee');
                }
                if ($validated['mentor_id']) {
                    Mentor::where('id_mentor', $validated['mentor_id'])->increment('jumlah_mentee');
                }
            }

            AdminLog::log(
                auth()->id(),
                'update',
                'talenta',
                $talent->id_talenta,
                $oldValues,
                $talent->fresh()->toArray()
            );

            DB::commit();

            return redirect()->route('admin.talents.index')
                ->with('success', 'Talent berhasil diupdate.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()->withInput()
                ->with('error', 'Gagal mengupdate talent: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Talent $talent)
    {
        $this->authorize('delete', $talent);

        DB::beginTransaction();
        try {
            $oldValues = $talent->toArray();
            $talentId = $talent->id_talenta;
            $mentorId = $talent->mentor_id;

            if ($talent->url_ktp) {
                Storage::disk('public')->delete($talent->url_ktp);
            }
            if ($talent->url_cv) {
                Storage::disk('public')->delete($talent->url_cv);
            }
            if ($talent->url_butap) {
                Storage::disk('public')->delete($talent->url_butap);
            }

            $userId = $talent->id_user;
            $talent->delete();
            User::where('id_user', $userId)->delete();

            // Update mentor's mentee count
            if ($mentorId) {
                Mentor::where('id_mentor', $mentorId)->decrement('jumlah_mentee');
            }

            AdminLog::log(
                auth()->id(),
                'delete',
                'talenta',
                $talentId,
                $oldValues,
                null
            );

            DB::commit();

            return redirect()->route('admin.talents.index')
                ->with('success', 'Talent berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()->with('error', 'Gagal menghapus talent: ' . $e->getMessage());
        }
    }
}
