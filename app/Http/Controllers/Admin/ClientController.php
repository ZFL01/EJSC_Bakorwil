<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\User;
use App\Models\AdminLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Client::class);

        $query = Client::with('user');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_ukm', 'ILIKE', "%{$search}%")
                  ->orWhere('nama_produk', 'ILIKE', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $clients = $query->latest()->paginate(15);

        return view('admin.clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Client::class);
        
        return view('admin.clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Client::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'nama_ukm' => 'required|string|max:255',
            'nama_produk' => 'required|string|max:255',
            'deskripsi_usaha' => 'nullable|string',
            'no_hp' => 'required|string|max:20',
            'alamat_lengkap' => 'required|string',
            'foto_logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required|in:aktif,tidak aktif',
        ]);

        DB::beginTransaction();
        try {
            // Create user account
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password_hash' => Hash::make($validated['password']),
                'role' => 'client',
            ]);

            // Handle file upload
            $logoPath = null;
            if ($request->hasFile('foto_logo')) {
                $logoPath = $request->file('foto_logo')->store('client/logo', 'public');
            }

            // Create client profile
            $client = Client::create([
                'id_user' => $user->id_user,
                'nama_ukm' => $validated['nama_ukm'],
                'nama_produk' => $validated['nama_produk'],
                'deskripsi_usaha' => $validated['deskripsi_usaha'],
                'no_hp' => $validated['no_hp'],
                'alamat_lengkap' => $validated['alamat_lengkap'],
                'foto_logo' => $logoPath,
                'status' => $validated['status'],
                'created_by' => auth()->id(),
            ]);

            // Log admin action
            AdminLog::log(
                auth()->id(),
                'create',
                'client',
                $client->id_client,
                null,
                $client->toArray()
            );

            DB::commit();

            return redirect()->route('admin.clients.index')
                ->with('success', 'Client berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()->withInput()
                ->with('error', 'Gagal menambahkan client: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        $this->authorize('view', $client);

        $client->load('user', 'creator', 'updater');

        return view('admin.clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        $this->authorize('update', $client);

        return view('admin.clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        $this->authorize('update', $client);

        $validated = $request->validate([
            'nama_ukm' => 'required|string|max:255',
            'nama_produk' => 'required|string|max:255',
            'deskripsi_usaha' => 'nullable|string',
            'no_hp' => 'required|string|max:20',
            'alamat_lengkap' => 'required|string',
            'foto_logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required|in:aktif,tidak aktif',
        ]);

        DB::beginTransaction();
        try {
            $oldValues = $client->toArray();

            // Handle file upload
            if ($request->hasFile('foto_logo')) {
                // Delete old file
                if ($client->foto_logo) {
                    Storage::disk('public')->delete($client->foto_logo);
                }
                $validated['foto_logo'] = $request->file('foto_logo')->store('client/logo', 'public');
            }

            $validated['updated_by'] = auth()->id();
            $client->update($validated);

            // Log admin action
            AdminLog::log(
                auth()->id(),
                'update',
                'client',
                $client->id_client,
                $oldValues,
                $client->fresh()->toArray()
            );

            DB::commit();

            return redirect()->route('admin.clients.index')
                ->with('success', 'Client berhasil diupdate.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()->withInput()
                ->with('error', 'Gagal mengupdate client: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $this->authorize('delete', $client);

        DB::beginTransaction();
        try {
            $oldValues = $client->toArray();
            $clientId = $client->id_client;

            // Delete associated file
            if ($client->foto_logo) {
                Storage::disk('public')->delete($client->foto_logo);
            }

            // Delete client and associated user
            $userId = $client->id_user;
            $client->delete();
            User::where('id_user', $userId)->delete();

            // Log admin action
            AdminLog::log(
                auth()->id(),
                'delete',
                'client',
                $clientId,
                $oldValues,
                null
            );

            DB::commit();

            return redirect()->route('admin.clients.index')
                ->with('success', 'Client berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()->with('error', 'Gagal menghapus client: ' . $e->getMessage());
        }
    }
}