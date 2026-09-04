<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mentor;
use App\Models\Talent;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Daftar user yang menunggu persetujuan (status pending),
     * terutama hasil pendaftaran via Google.
     */
    public function pendingIndex()
    {
        $pendingUsers = User::whereIn('status', ['pending'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Semua akun non-admin untuk dikelola (aktif/nonaktif/hapus)
        $managedUsers = User::where('role', '!=', 'admin')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.users.pending', compact('pendingUsers', 'managedUsers'));
    }

    /**
     * Aktifkan kembali akun yang dinonaktifkan.
     */
    public function activate(Request $request, User $user)
    {
        if ($user->role === 'admin') {
            return back()->with('error', 'Akun admin tidak dapat dikelola dari sini.');
        }

        $user->update(['status' => 'aktif']);

        return back()->with('success', "Akun {$user->name} telah diaktifkan kembali.");
    }

    /**
     * Nonaktifkan akun (tidak bisa login, data tetap tersimpan).
     */
    public function deactivate(Request $request, User $user)
    {
        if ($user->role === 'admin') {
            return back()->with('error', 'Akun admin tidak dapat dikelola dari sini.');
        }

        $user->update(['status' => 'nonaktif']);

        return back()->with('success', "Akun {$user->name} telah dinonaktifkan.");
    }

    /**
     * Hapus permanen akun.
     */
    public function destroy(Request $request, User $user)
    {
        if ($user->role === 'admin') {
            return back()->with('error', 'Akun admin tidak dapat dihapus dari sini.');
        }

        if ($user->id_user === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        $nama = $user->name;

        $user->delete();

        return back()->with('success', "Akun {$nama} telah dihapus permanen.");
    }

    /**
     * Setujui user pending → status aktif.
     * Otomatis buat record di tabel mentor/talenta/client sesuai role.
     * Wilayah akan diisi nanti saat user mengisi profil.
     */
    public function approve(Request $request, User $user)
    {
        if ($user->status !== 'pending') {
            return back()->with('error', 'User ini tidak sedang menunggu persetujuan.');
        }

        DB::transaction(function () use ($user) {
            // Update status user jadi aktif
            $user->update([
                'status' => 'aktif',
            ]);

            // Buat record di tabel yang sesuai berdasarkan role
            // id_wilayah akan null sampai user mengisi profil
            $data = [
                'id_user' => $user->id_user,
                'id_wilayah' => null, // Akan diisi saat user mengisi profil
                'nama' => $user->name,
                'email' => $user->email,
                'status' => 'aktif',
                'is_public' => false,
            ];

            switch ($user->role) {
                case 'mentor':
                    Mentor::create($data);
                    break;
                case 'talenta':
                    Talent::create($data);
                    break;
                case 'client':
                    // Client menggunakan nama_ukm, bukan nama
                    $data['nama_ukm'] = $user->name;
                    Client::create($data);
                    break;
            }
        });

        return back()->with('success', "Akun {$user->name} ({$user->role}) telah disetujui dan kini aktif.");
    }

    /**
     * Tolak user pending → hapus akun.
     */
    public function reject(Request $request, User $user)
    {
        if ($user->status !== 'pending') {
            return back()->with('error', 'User ini tidak sedang menunggu persetujuan.');
        }

        $nama = $user->name;

        $user->delete();

        return back()->with('success', "Pendaftaran {$nama} telah ditolak dan akun dihapus.");
    }
}
