<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /**
     * Role yang boleh dipilih saat pendaftaran manual.
     *
     * Admin TIDAK bisa mendaftar sendiri — akun admin hanya dibuat
     * oleh admin existing / seeder.
     */
    private const ALLOWED_ROLES = ['mentor', 'talenta', 'client'];

    /**
     * Key session penanda "baru selesai mendaftar" untuk halaman waiting.
     */
    private const SESSION_WAITING = 'register_waiting';

    /**
     * Tampilkan halaman pendaftaran.
     */
    public function showRegistrationForm()
    {
        if (Auth::check()) {
            return redirect()->route('public.index');
        }

        return view('auth.registrasi');
    }

    /**
     * Proses pendaftaran manual (email / password).
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'role' => ['required', 'in:'.implode(',', self::ALLOWED_ROLES)],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        /*
        |----------------------------------------------------------------------
        | Cegah email duplikat
        |----------------------------------------------------------------------
        */
        if (User::where('email', $validated['email'])->exists()) {
            return back()
                ->withErrors([
                    'email' => 'Email ini sudah terdaftar. Silakan login atau gunakan fitur Lupa Password.',
                ])
                ->onlyInput('email');
        }

        /*
        |----------------------------------------------------------------------
        | Simpan user baru dengan status PENDING (menunggu approval admin)
        |----------------------------------------------------------------------
        */
        User::create([
            'name' => $validated['name'],
            'username' => $this->makeUsername($validated['email']),
            'email' => $validated['email'],
            'password_hash' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'status' => 'pending',
        ]);

        /*
        |----------------------------------------------------------------------
        | Tandai sesi waiting
        |----------------------------------------------------------------------
        */
        $request->session()->put(self::SESSION_WAITING, [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
        ]);

        /*
        |----------------------------------------------------------------------
        | Kirim notifikasi email ke admin (tidak memblokir pendaftaran)
        |----------------------------------------------------------------------
        */
        $this->notifyAdmin($validated['name'], $validated['email'], $validated['role']);

        return redirect()->route('registrasi.waiting');
    }

    /**
     * Halaman "Menunggu Persetujuan Admin" setelah pendaftaran.
     */
    public function showWaiting(Request $request)
    {
        $data = $request->session()->get(self::SESSION_WAITING);

        if (! $data) {
            return redirect()->route('login');
        }

        return view('auth.registrasi-waiting', [
            'nama' => $data['name'],
            'email' => $data['email'],
            'role' => ucfirst($data['role']),
        ]);
    }

    /**
     * Buat username unik otomatis dari email.
     * Kolom users.username adalah NOT NULL + UNIQUE.
     */
    private function makeUsername(string $email): string
    {
        $base = Str::slug(explode('@', strtolower($email))[0], '') ?: 'user';
        $base = substr($base, 0, 90);

        $username = $base;
        $i = 1;
        while (User::where('username', $username)->exists()) {
            $username = $base.($i++);
        }

        return $username;
    }

    /**
     * Kirim email notifikasi ke admin bahwa ada pendaftar baru.
     */
    private function notifyAdmin(string $nama, string $email, string $role): void
    {
        $penerima = env('ADMIN_NOTIFY_EMAIL', 'admin@bakorwil.go.id');

        try {
            Mail::raw(
                "Ada pendaftar baru via email:\n\n"
                ."Nama   : {$nama}\n"
                ."Email  : {$email}\n"
                .'Peran  : '.ucfirst($role)."\n\n"
                ."Silakan tinjau dan setujui melalui panel admin:\n"
                .url('/admin/users/pending')."\n\n"
                .'— Sistem EJSC Bakorwil Jember (otomatis)',
                function ($message) use ($penerima, $nama) {
                    $message->to($penerima)
                        ->subject("Pendaftar Baru Menunggu Persetujuan: {$nama}");
                }
            );
        } catch (\Throwable $e) {
            report($e);
        }
    }
}
