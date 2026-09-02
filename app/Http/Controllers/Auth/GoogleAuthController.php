<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    /**
     * Role yang boleh dipilih saat pendaftaran via Google.
     *
     * Admin TIDAK bisa mendaftar lewat Google — akun admin
     * hanya dibuat oleh admin existing / seeder.
     */
    private const ALLOWED_ROLES = ['mentor', 'talenta', 'client'];

    /**
     * Key session untuk data sementara pendaftar Google.
     */
    private const SESSION_KEY = 'google_register';

    /**
     * Key session penanda "baru selesai mendaftar" untuk halaman waiting.
     */
    private const SESSION_WAITING = 'google_waiting';

    /**
     * Arahkan user ke halaman OAuth Google.
     */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle callback dari Google.
     */
    public function callback(Request $request)
    {
        try {
            // stateless() menghindari InvalidStateException (kegagalan
            // verifikasi state session) yang sering terjadi di lokal.
            $googleUser = Socialite::driver('google')->stateless()->user();
        } catch (\Throwable $e) {
            // Catat penyebab asli ke storage/logs/laravel.log
            report($e);

            $pesan = 'Login dengan Google gagal atau dibatalkan. Silakan coba lagi.';

            // Detail tambahan untuk masalah umum (memudahkan debugging lokal)
            if (str_contains($e->getMessage(), 'cURL error 60')) {
                $pesan = 'Login Google gagal: sertifikat SSL lokal (cacert.pem) belum dikonfigurasi. Cek storage/logs/laravel.log.';
            } elseif (str_contains($e->getMessage(), 'invalid_client')) {
                $pesan = 'Login Google gagal: Client ID / Client Secret tidak valid. Periksa file .env lalu jalankan "php artisan config:clear".';
            } elseif (str_contains($e->getMessage(), 'redirect_uri_mismatch')) {
                $pesan = 'Login Google gagal: Redirect URI tidak cocok dengan Google Cloud Console.';
            }

            return redirect()
                ->route('login')
                ->withErrors(['email' => $pesan]);
        }

        if (!$googleUser->getEmail()) {
            return redirect()
                ->route('login')
                ->withErrors(['email' => 'Akun Google Anda tidak memiliki email yang dapat digunakan.']);
        }

        /*
        |----------------------------------------------------------------------
        | Cari user berdasarkan google_id, lalu email
        |----------------------------------------------------------------------
        */
        $user = User::where('google_id', $googleUser->getId())
            ->orWhere('email', $googleUser->getEmail())
            ->first();

        /*
        |----------------------------------------------------------------------
        | User baru → simpan data sementara → halaman pilih peran
        |----------------------------------------------------------------------
        */
        if (!$user) {
            $request->session()->put(self::SESSION_KEY, [
                'google_id' => $googleUser->getId(),
                'name'      => $googleUser->getName() ?: $googleUser->getNickname() ?: 'Pengguna Google',
                'email'     => $googleUser->getEmail(),
                'avatar'    => $googleUser->getAvatar(),
            ]);

            return redirect()->route('google.role');
        }

        /*
        |----------------------------------------------------------------------
        | User sudah ada → cek status
        |----------------------------------------------------------------------
        */
        if ($user->status === 'pending') {
            return redirect()
                ->route('login')
                ->withErrors([
                    'email' => 'Akun Anda terdaftar via Google namun masih MENUNGGU PERSETUJUAN ADMIN. Silakan coba lagi nanti.'
                ]);
        }

        if ($user->status !== 'aktif') {
            return redirect()
                ->route('login')
                ->withErrors(['email' => 'Akun belum aktif.'])
                ->onlyInput('email');
        }

        /*
        |----------------------------------------------------------------------
        | Link akun (simpan google_id bila belum ada) lalu login
        |----------------------------------------------------------------------
        */
        $user->update([
            'google_id'         => $user->google_id ?: $googleUser->getId(),
            'profile_photo'     => $user->profile_photo ?: $googleUser->getAvatar(),
            'email_verified_at' => $user->email_verified_at ?: now(),
            'last_login'        => now(),
        ]);

        Auth::login($user, true);

        $request->session()->regenerate();

        return redirect()->route('public.index');
    }

    /**
     * Tampilkan halaman pilih peran (mentor / talenta / client).
     */
    public function showRoleSelection(Request $request)
    {
        if (!$request->session()->has(self::SESSION_KEY)) {
            return redirect()
                ->route('login')
                ->withErrors(['email' => 'Sesi pendaftaran Google telah berakhir. Silakan coba lagi.']);
        }

        $googleData = $request->session()->get(self::SESSION_KEY);

        return view('auth.google-role', [
            'googleName'  => $googleData['name'],
            'googleEmail' => $googleData['email'],
        ]);
    }

    /**
     * Buat username unik otomatis dari email Google.
     * Kolom users.username adalah NOT NULL + UNIQUE.
     */
    private function makeUsername(string $email): string
    {
        $base = Str::slug(explode('@', strtolower($email))[0], '') ?: 'user';
        $base = substr($base, 0, 90);

        $username = $base;
        $i = 1;
        while (User::where('username', $username)->exists()) {
            $username = $base . ($i++);
        }

        return $username;
    }

    /**
     * Simpan user baru dengan peran terpilih, status PENDING.
     */
    public function completeRegistration(Request $request)
    {
        $data = $request->session()->get(self::SESSION_KEY);

        if (!$data) {
            return redirect()
                ->route('login')
                ->withErrors(['email' => 'Sesi pendaftaran Google telah berakhir. Silakan coba lagi.']);
        }

        $validated = $request->validate([
            'role' => ['required', 'in:' . implode(',', self::ALLOWED_ROLES)],
        ]);

        /*
        |----------------------------------------------------------------------
        | Cegah race condition: email sudah terdaftar di antara waktu
        | pilih peran. Bila terjadi, anggap sebagai akun existing.
        |----------------------------------------------------------------------
        */
        $existing = User::where('email', $data['email'])->first();

        if ($existing) {
            $request->session()->forget(self::SESSION_KEY);

            return redirect()
                ->route('login')
                ->withErrors(['email' => 'Email ini sudah terdaftar. Silakan login dengan email & password Anda.']);
        }

        User::create([
            'name'              => $data['name'],
            'username'          => $this->makeUsername($data['email']),
            'email'             => $data['email'],
            'password_hash'     => Hash::make(Str::random(40)),
            'google_id'         => $data['google_id'],
            'profile_photo'     => $data['avatar'],
            'role'              => $validated['role'],
            'status'            => 'pending',
            'email_verified_at' => now(),
        ]);

        $request->session()->forget(self::SESSION_KEY);

        // Tandai sesi "baru selesai mendaftar" untuk halaman waiting
        $request->session()->put(self::SESSION_WAITING, [
            'name'  => $data['name'],
            'email' => $data['email'],
            'role'  => $validated['role'],
        ]);

        // Kirim notifikasi email ke admin (tidak memblokir pendaftaran bila gagal)
        $this->notifyAdmin($data['name'], $data['email'], $validated['role']);

        return redirect()->route('google.waiting');
    }

    /**
     * Halaman "Menunggu Persetujuan Admin" setelah pendaftaran via Google.
     */
    public function showWaiting(Request $request)
    {
        $data = $request->session()->get(self::SESSION_WAITING);

        if (!$data) {
            return redirect()->route('login');
        }

        return view('auth.google-waiting', [
            'nama'  => $data['name'],
            'email' => $data['email'],
            'role'  => ucfirst($data['role']),
        ]);
    }

    /**
     * Kirim email notifikasi ke admin bahwa ada pendaftar baru.
     * Di lokal (MAIL_MAILER=log) email dicatat ke storage/logs/laravel.log.
     * Gagal kirim TIDAK menggagalkan pendaftaran.
     */
    private function notifyAdmin(string $nama, string $email, string $role): void
    {
        $penerima = env('ADMIN_NOTIFY_EMAIL', 'admin@bakorwil.go.id');

        try {
            Mail::raw(
                "Ada pendaftar baru via Google:\n\n"
                . "Nama   : {$nama}\n"
                . "Email  : {$email}\n"
                . "Peran  : " . ucfirst($role) . "\n\n"
                . "Silakan tinjau dan setujui melalui panel admin:\n"
                . url('/admin/users/pending') . "\n\n"
                . "— Sistem EJSC Bakorwil Jember (otomatis)",
                function ($message) use ($penerima, $nama) {
                    $message->to($penerima)
                        ->subject("Pendaftar Baru Menunggu Persetujuan: {$nama}");
                }
            );
        } catch (\Throwable $e) {
            report($e);
        }
    }

    /**
     * Batalkan pendaftaran via Google.
     */
    public function cancelRegistration(Request $request)
    {
        $request->session()->forget(self::SESSION_KEY);

        return redirect()->route('login');
    }
}
