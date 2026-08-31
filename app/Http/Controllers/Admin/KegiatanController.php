<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use App\Models\KegiatanParticipant;
use App\Models\AdminLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class KegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Kegiatan::class);

        $query = Kegiatan::with('organizer');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul_kegiatan', 'ILIKE', "%{$search}%")
                  ->orWhere('deskripsi', 'ILIKE', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('is_public')) {
            $query->where('is_public', $request->is_public === '1');
        }

        if ($request->filled('date_from')) {
            $query->where('tanggal_kegiatan', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('tanggal_kegiatan', '<=', $request->date_to);
        }

        $kegiatans = $query->latest('tanggal_kegiatan')->paginate(15);

        return view('admin.kegiatans.index', compact('kegiatans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Kegiatan::class);
        
        return view('admin.kegiatans.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Kegiatan::class);

        $validated = $request->validate([
            'judul_kegiatan' => 'required|string|max:255',
            'tanggal_kegiatan' => 'required|date|after_or_equal:today',
            'deskripsi' => 'nullable|string',
            'lokasi' => 'required|string|max:255',
            'max_participants' => 'nullable|integer|min:1',
            'is_public' => 'boolean',
            'gallery' => 'nullable|array',
            'gallery.*' => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Business rule: 1 kegiatan per day
        $existingKegiatan = Kegiatan::whereDate('tanggal_kegiatan', $validated['tanggal_kegiatan'])->exists();
        if ($existingKegiatan) {
            return back()->withInput()
                ->with('error', 'Sudah ada kegiatan pada tanggal tersebut. Hanya 1 kegiatan diperbolehkan per hari.');
        }

        DB::beginTransaction();
        try {
            // Handle gallery uploads
            $galleryPaths = [];
            if ($request->hasFile('gallery')) {
                foreach ($request->file('gallery') as $image) {
                    $galleryPaths[] = $image->store('kegiatan/gallery', 'public');
                }
            }

            $kegiatan = Kegiatan::create([
                'judul_kegiatan' => $validated['judul_kegiatan'],
                'tanggal_kegiatan' => $validated['tanggal_kegiatan'],
                'deskripsi' => $validated['deskripsi'],
                'lokasi' => $validated['lokasi'],
                'max_participants' => $validated['max_participants'],
                'is_public' => $validated['is_public'] ?? true,
                'gallery' => $galleryPaths,
                'organizer_id' => auth()->id(),
            ]);

            AdminLog::log(
                auth()->id(),
                'create',
                'kegiatan_ejsc',
                $kegiatan->id_kegiatan,
                null,
                $kegiatan->toArray()
            );

            DB::commit();

            return redirect()->route('admin.kegiatans.index')
                ->with('success', 'Kegiatan berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()->withInput()
                ->with('error', 'Gagal menambahkan kegiatan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Kegiatan $kegiatan)
    {
        $this->authorize('view', $kegiatan);

        $kegiatan->load(['organizer', 'participantRecords.user']);

        $stats = [
            'registered' => $kegiatan->participantRecords()->registered()->count(),
            'confirmed' => $kegiatan->participantRecords()->confirmed()->count(),
            'attended' => $kegiatan->participantRecords()->attended()->count(),
            'cancelled' => $kegiatan->participantRecords()->cancelled()->count(),
        ];

        return view('admin.kegiatans.show', compact('kegiatan', 'stats'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kegiatan $kegiatan)
    {
        $this->authorize('update', $kegiatan);

        return view('admin.kegiatans.edit', compact('kegiatan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kegiatan $kegiatan)
    {
        $this->authorize('update', $kegiatan);

        $validated = $request->validate([
            'judul_kegiatan' => 'required|string|max:255',
            'tanggal_kegiatan' => 'required|date',
            'deskripsi' => 'nullable|string',
            'lokasi' => 'required|string|max:255',
            'max_participants' => 'nullable|integer|min:1',
            'is_public' => 'boolean',
            'gallery' => 'nullable|array',
            'gallery.*' => 'image|mimes:jpg,jpeg,png|max:2048',
            'remove_gallery' => 'nullable|array',
        ]);

        // Business rule: 1 kegiatan per day (except for current kegiatan)
        $existingKegiatan = Kegiatan::whereDate('tanggal_kegiatan', $validated['tanggal_kegiatan'])
            ->where('id_kegiatan', '!=', $kegiatan->id_kegiatan)
            ->exists();
        
        if ($existingKegiatan) {
            return back()->withInput()
                ->with('error', 'Sudah ada kegiatan lain pada tanggal tersebut. Hanya 1 kegiatan diperbolehkan per hari.');
        }

        DB::beginTransaction();
        try {
            $oldValues = $kegiatan->toArray();
            $gallery = $kegiatan->gallery ?? [];

            // Remove selected gallery images
            if ($request->filled('remove_gallery')) {
                foreach ($request->remove_gallery as $imagePath) {
                    Storage::disk('public')->delete($imagePath);
                    $gallery = array_values(array_diff($gallery, [$imagePath]));
                }
            }

            // Add new gallery images
            if ($request->hasFile('gallery')) {
                foreach ($request->file('gallery') as $image) {
                    $gallery[] = $image->store('kegiatan/gallery', 'public');
                }
            }

            $validated['gallery'] = $gallery;
            $kegiatan->update($validated);

            AdminLog::log(
                auth()->id(),
                'update',
                'kegiatan_ejsc',
                $kegiatan->id_kegiatan,
                $oldValues,
                $kegiatan->fresh()->toArray()
            );

            DB::commit();

            return redirect()->route('admin.kegiatans.index')
                ->with('success', 'Kegiatan berhasil diupdate.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()->withInput()
                ->with('error', 'Gagal mengupdate kegiatan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kegiatan $kegiatan)
    {
        $this->authorize('delete', $kegiatan);

        DB::beginTransaction();
        try {
            $oldValues = $kegiatan->toArray();
            $kegiatanId = $kegiatan->id_kegiatan;

            // Delete gallery images
            if ($kegiatan->gallery) {
                foreach ($kegiatan->gallery as $imagePath) {
                    Storage::disk('public')->delete($imagePath);
                }
            }

            $kegiatan->delete();

            AdminLog::log(
                auth()->id(),
                'delete',
                'kegiatan_ejsc',
                $kegiatanId,
                $oldValues,
                null
            );

            DB::commit();

            return redirect()->route('admin.kegiatans.index')
                ->with('success', 'Kegiatan berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()->with('error', 'Gagal menghapus kegiatan: ' . $e->getMessage());
        }
    }

    /**
     * Manage participants for a kegiatan.
     */
    public function participants(Kegiatan $kegiatan)
    {
        $this->authorize('manageParticipants', $kegiatan);

        $participants = $kegiatan->participantRecords()
            ->with('user')
            ->latest()
            ->paginate(20);

        return view('admin.kegiatans.participants', compact('kegiatan', 'participants'));
    }

    /**
     * Update participant status.
     */
    public function updateParticipantStatus(Request $request, Kegiatan $kegiatan, KegiatanParticipant $participant)
    {
        $this->authorize('manageParticipants', $kegiatan);

        $validated = $request->validate([
            'status' => 'required|in:registered,confirmed,attended,cancelled',
            'notes' => 'nullable|string',
        ]);

        $oldStatus = $participant->status;
        $participant->update($validated);

        if ($validated['status'] === 'attended' && !$participant->attended_at) {
            $participant->update(['attended_at' => now()]);
        }

        AdminLog::log(
            auth()->id(),
            'update_participant_status',
            'kegiatan_participants',
            $participant->id_participant,
            ['status' => $oldStatus],
            ['status' => $validated['status']]
        );

        return back()->with('success', 'Status peserta berhasil diupdate.');
    }
}