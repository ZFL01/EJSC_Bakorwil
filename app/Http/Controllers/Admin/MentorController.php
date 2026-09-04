<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mentor;
use App\Models\User;
use App\Models\Wilayah;
use App\Models\AdminLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class MentorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Mentor::class);

        $query = Mentor::with('user', 'talents');

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

        if ($request->filled('is_available')) {
            $query->where('is_available', $request->is_available === '1');
        }

        $mentors = $query->latest()->paginate(15);

        return view('admin.mentors.index', compact('mentors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Mentor::class);
        
        $wilayah = Wilayah::orderBy('nama_wilayah')->get();

        return view('admin.mentors.create', compact('wilayah'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Mentor::class);

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
            'expertise_tags' => 'nullable|string',
            'is_available' => 'boolean',
            'url_foto_ktp' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'url_cv' => 'nullable|mimes:pdf,doc,docx|max:5120',
            'status' => 'required|in:aktif,tidak aktif',
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $validated['user_name'],
                'email' => $validated['email'],
                'password_hash' => Hash::make($validated['password']),
                'role' => 'mentor',
            ]);

            $ktpPath = $request->hasFile('url_foto_ktp') 
                ? $request->file('url_foto_ktp')->store('ktp', 'public') 
                : null;
            
            $cvPath = $request->hasFile('url_cv') 
                ? $request->file('url_cv')->store('cv', 'public') 
                : null;

            $expertiseTags = $validated['expertise_tags'] 
                ? array_map('trim', explode(',', $validated['expertise_tags'])) 
                : [];

            $mentor = Mentor::create([
                'id_user' => $user->id_user,
                'nama' => $validated['nama'],
                'no_wa' => $validated['no_wa'],
                'alamat_lengkap' => $validated['alamat_lengkap'],
                'id_wilayah' => $validated['id_wilayah'],
                'domisili' => $validated['domisili'],
                'keahlian' => $validated['keahlian'],
                'pengalaman' => $validated['pengalaman'],
                'expertise_tags' => $expertiseTags,
                'is_available' => $validated['is_available'] ?? true,
                'jumlah_mentee' => 0,
                'url_ktp' => $ktpPath,
                'url_cv' => $cvPath,
                'status' => $validated['status'],
                'created_by' => auth()->id(),
            ]);

            AdminLog::log(
                auth()->id(),
                'create',
                'mentor',
                $mentor->id_mentor,
                null,
                $mentor->toArray()
            );

            DB::commit();

            return redirect()->route('admin.mentors.index')
                ->with('success', 'Mentor berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()->withInput()
                ->with('error', 'Gagal menambahkan mentor: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Mentor $mentor)
    {
        $this->authorize('view', $mentor);

        $mentor->load('user', 'talents', 'creator', 'updater');

        return view('admin.mentors.show', compact('mentor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mentor $mentor)
    {
        $this->authorize('update', $mentor);

        $wilayah = Wilayah::orderBy('nama_wilayah')->get();

        return view('admin.mentors.edit', compact('mentor', 'wilayah'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mentor $mentor)
    {
        $this->authorize('update', $mentor);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'no_wa' => 'required|string|max:20',
            'alamat_lengkap' => 'required|string',
            'id_wilayah' => 'required|exists:wilayah,id_wilayah',
            'domisili' => 'required|string|max:255',
            'keahlian' => 'required|string|max:255',
            'pengalaman' => 'nullable|string',
            'expertise_tags' => 'nullable|string',
            'is_available' => 'boolean',
            'url_foto_ktp' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'url_cv' => 'nullable|mimes:pdf,doc,docx|max:5120',
            'status' => 'required|in:aktif,tidak aktif',
        ]);

        DB::beginTransaction();
        try {
            $oldValues = $mentor->toArray();

            if ($request->hasFile('url_foto_ktp')) {
                if ($mentor->url_ktp) {
                    Storage::disk('public')->delete($mentor->url_ktp);
                }
                $validated['url_ktp'] = $request->file('url_foto_ktp')->store('ktp', 'public');
            }

            if ($request->hasFile('url_cv')) {
                if ($mentor->url_cv) {
                    Storage::disk('public')->delete($mentor->url_cv);
                }
                $validated['url_cv'] = $request->file('url_cv')->store('cv', 'public');
            }

            if (isset($validated['expertise_tags'])) {
                $validated['expertise_tags'] = array_map('trim', explode(',', $validated['expertise_tags']));
            }

            $validated['updated_by'] = auth()->id();
            $mentor->update($validated);

            AdminLog::log(
                auth()->id(),
                'update',
                'mentor',
                $mentor->id_mentor,
                $oldValues,
                $mentor->fresh()->toArray()
            );

            DB::commit();

            return redirect()->route('admin.mentors.index')
                ->with('success', 'Mentor berhasil diupdate.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()->withInput()
                ->with('error', 'Gagal mengupdate mentor: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mentor $mentor)
    {
        $this->authorize('delete', $mentor);

        DB::beginTransaction();
        try {
            $oldValues = $mentor->toArray();
            $mentorId = $mentor->id_mentor;

            if ($mentor->url_ktp) {
                Storage::disk('public')->delete($mentor->url_ktp);
            }
            if ($mentor->url_cv) {
                Storage::disk('public')->delete($mentor->url_cv);
            }

            $userId = $mentor->id_user;
            $mentor->delete();
            User::where('id_user', $userId)->delete();

            AdminLog::log(
                auth()->id(),
                'delete',
                'mentor',
                $mentorId,
                $oldValues,
                null
            );

            DB::commit();

            return redirect()->route('admin.mentors.index')
                ->with('success', 'Mentor berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()->with('error', 'Gagal menghapus mentor: ' . $e->getMessage());
        }
    }
}
