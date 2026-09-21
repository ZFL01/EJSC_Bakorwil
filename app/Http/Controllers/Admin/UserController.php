<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Mentor;
use App\Models\Talent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

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

        /*
        |----------------------------------------------------------------------
        | TANPA auto-login: sesi admin TIDAK boleh digantikan oleh user
        | yang baru disetujui. Tetap di panel admin, tampilkan flash
        | sukses, dan daftar pending otomatis ter-update.
        |----------------------------------------------------------------------
        */
        return back()->with(
            'success',
            "Pendaftaran {$user->name} ({$user->role}) telah disetujui dan akun diaktifkan."
        );
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

    /*
    |--------------------------------------------------------------------------
    | Kelola Akun Admin
    |--------------------------------------------------------------------------
    |
    | Halaman Persetujuan User sengaja mengecualikan role `admin`, sehingga
    | akun admin tidak bisa dibuat/diubah dari sana. Method di bawah ini
    | khusus mengelola akun admin (daftar, tambah, ubah, hapus).
    |
    */

    /**
     * Daftar seluruh akun admin.
     */
    public function adminsIndex()
    {
        $admins = User::where('role', 'admin')
            ->orderBy('name')
            ->get();

        return view('admin.users.admins.index', compact('admins'));
    }

    /**
     * Form tambah akun admin.
     */
    public function adminsCreate()
    {
        return view('admin.users.admins.create');
    }

    /**
     * Simpan akun admin baru (langsung aktif, tidak lewat approval).
     */
    public function adminsStore(Request $request)
    {
        $validated = $request->validate(
            $this->adminRules(),
            $this->adminValidationMessages()
        );

        $user = User::create([
            'name' => $validated['name'],

            // Kosongkan bila tidak diisi → hook User::booted()
            // membuat username otomatis dari email.
            'username' => $validated['username'] ?: null,

            'email' => $validated['email'],
            'password_hash' => Hash::make($validated['password']),
            'role' => 'admin',
            'status' => $validated['status'],
            'email_verified_at' => now(),
        ]);

        return redirect()
            ->route('admin.users.admins.index')
            ->with('success', "Akun admin {$user->name} berhasil dibuat.");
    }

    /**
     * Form ubah akun admin.
     */
    public function adminsEdit(User $user)
    {
        $this->ensureAdminAccount($user);

        return view('admin.users.admins.edit', compact('user'));
    }

    /**
     * Perbarui akun admin.
     * Password hanya diubah bila field password diisi.
     */
    public function adminsUpdate(Request $request, User $user)
    {
        $this->ensureAdminAccount($user);

        $validated = $request->validate(
            $this->adminRules($user),
            $this->adminValidationMessages()
        );

        if (
            $validated['status'] === 'nonaktif' &&
            $this->isLastAdmin()
        ) {
            return back()->with(
                'error',
                'Minimal harus ada satu akun admin. Tambahkan admin lain sebelum menonaktifkan akun ini.'
            );
        }

        $data = [
            'name' => $validated['name'],
            'username' => $validated['username'] ?: $user->username,
            'email' => $validated['email'],
            'status' => $validated['status'],
        ];

        if (!empty($validated['password'])) {
            $data['password_hash'] = Hash::make($validated['password']);
        }

        $user->update($data);

        return redirect()
            ->route('admin.users.admins.index')
            ->with('success', "Akun admin {$user->name} berhasil diperbarui.");
    }

    /**
     * Hapus akun admin.
     * Akun sendiri dan admin terakhir tidak boleh dihapus.
     */
    public function adminsDestroy(Request $request, User $user)
    {
        $this->ensureAdminAccount($user);

        if ($user->id_user === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        if ($this->isLastAdmin()) {
            return back()->with(
                'error',
                'Minimal harus ada satu akun admin. Tambahkan admin lain sebelum menghapus akun ini.'
            );
        }

        $nama = $user->name;

        $user->delete();

        return back()->with('success', "Akun admin {$nama} telah dihapus.");
    }

    /**
     * Pastikan user yang diakses benar-benar akun admin.
     */
    private function ensureAdminAccount(User $user): void
    {
        abort_unless(
            $user->role === 'admin',
            404,
            'Akun admin tidak ditemukan.'
        );
    }

    /**
     * Cek apakah hanya tersisa satu akun admin.
     */
    private function isLastAdmin(): bool
    {
        return User::where('role', 'admin')->count() <= 1;
    }

    /**
     * Aturan validasi form akun admin (dipakai untuk tambah & ubah).
     * Password wajib hanya saat membuat akun baru.
     */
    private function adminRules(?User $user = null): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'username' => [
                'nullable',
                'string',
                'max:100',
                'regex:/^[A-Za-z0-9._-]+$/',
                Rule::unique('users', 'username')
                    ->ignore($user?->id_user, 'id_user'),
            ],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique('users', 'email')
                    ->ignore($user?->id_user, 'id_user'),
            ],

            'password' => $user
                ? ['nullable', 'string', 'min:8', 'confirmed']
                : ['required', 'string', 'min:8', 'confirmed'],

            'status' => [
                'required',
                'in:aktif,nonaktif',
            ],
        ];
    }

    /**
     * Pesan validasi form akun admin.
     */
    private function adminValidationMessages(): array
    {
        return [
            'name.required' => 'Nama admin wajib diisi.',
            'name.max' => 'Nama admin maksimal 255 karakter.',

            'username.max' => 'Username maksimal 100 karakter.',
            'username.regex' => 'Username hanya boleh berisi huruf, angka, titik, garis bawah, dan strip.',
            'username.unique' => 'Username ini sudah dipakai akun lain.',

            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email maksimal 255 karakter.',
            'email.unique' => 'Email ini sudah dipakai akun lain.',

            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sama.',

            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status tidak valid.',
        ];
    }
}
