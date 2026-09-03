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

class GithubAuthController extends Controller
{
    /**
     * Role yang boleh dipilih saat pendaftaran via GitHub.
     *
     * Admin TIDAK bisa mendaftar lewat GitHub — akun admin
     * hanya dibuat oleh admin existing / seeder.
     */
    private const ALLOWED_ROLES = ['mentor', 'talenta', 'client'];

    /**
     * Key session untuk data sementara pendaftar GitHub.
     */
    private const SESSION_KEY = 'github_register';

    /**
     * Key session penanda "baru selesai mendaftar" untuk halaman waiting.
     */
    private const SESSION_WAITING = 'github_waiting';

    /**
     * Arahkan user ke halaman OAuth GitHub.
     */
    public function redirect()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Handle callback dari GitHub.
     */
    public function callback(Request $request)
    {
        try {
            // stateless() menghindari InvalidStateException (kegagalan
            // verifikasi state session) yang sering terjadi di lokal.
            $githubUser = Socialite::driver('github')->stateless()->user();
        } catch (\Throwable $e) {
            // Catat penyebab asli ke storage/logs/laravel.log
            report($e);

            $pesan = 'Login dengan GitHub gagal atau dibatalkan. Silakan coba lagi.';

            // Detail tambahan untuk masalah umum (memudahkan debugging lokal)
            if (str_contains($e->getMessage(), 'cURL error 60')) {
                $pesan = 'Login GitHub gagal: sertifikat SSL lokal (cacert.pem) belum dikonfigurasi. Cek storage/logs/laravel.log.';
            } elseif (str_contains($e->getMessage(), 'invalid_client')) {
                $pesan = 'Login GitHub gagal: Client ID / Client Secret tidak valid. Periksa file .env lalu jalankan "php artisan config:clear".';
            } elseif (str_contains($e->getMessage(), 'redirect_uri_mismatch')) {
                $pesan = 'Login GitHub gagal: Redirect URI tidak cocok dengan GitHub OAuth Apps.';
            }

            return redirect()
                ->route('login')
                ->withErrors(['email' => $pesan]);
        }

        if (!$githubUser->getEmail()) {
            return redirect()
                ->route('login')
                ->withErrors(['email' => 'Akun GitHub Anda tidak memiliki email publik yang dapat digunakan.']);
        }

        /*
        |----------------------------------------------------------------------
        | Cari user berdasarkan github_id, lalu email
        |----------------------------------------------------------------------
        */
        $user = User::where('github_id', $githubUser->getId())
            ->orWhere('email', $githubUser->getEmail())
            ->first();

        /*
        |----------------------------------------------------------------------
        | User baru → simpan data sementara → halaman pilih peran
        |----------------------------------------------------------------------
        */
        if (!$user) {
            $request->session()->put(self::SESSION_KEY, [
                'github_id'       => $githubUser->getId(),
                'name'            => $githubUser->getName() ?: $githubUser->getNickname() ?: 'Pengguna GitHub',
                'email'           => $githubUser->getEmail(),
                'avatar'          => $githubUser->getAvatar(),
                'github_username' => $githubUser->getNickname(),
                'github_token'    => $githubUser->token,
                'github_refresh_token' => $githubUser->refreshToken,
            ]);

            return redirect()->route('github.role');
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
                    'email' => 'Akun Anda terdaftar via GitHub namun masih MENUNGGU PERSETUJUAN ADMIN. Silakan coba lagi nanti.'
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
        | Link akun (simpan github_id bila belum ada) lalu login
        |----------------------------------------------------------------------
        */
        $user->update([
            'github_id'         => $user->github_id ?: $githubUser->getId(),
            'github_username'   => $user->github_username ?: $githubUser->getNickname(),
            'github_token'      => $user->github_token ?: $githubUser->token,
            'github_refresh_token' => $user->github_refresh_token ?: $githubUser->refreshToken,
            'profile_photo'     => $user->profile_photo ?: $githubUser->getAvatar(),
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
                ->withErrors(['email' => 'Sesi pendaftaran GitHub telah berakhir. Silakan coba lagi.']);
        }

        $githubData = $request->session()->get(self::SESSION_KEY);

        return view('auth.github-role', [
            'githubName'  => $githubData['name'],
            'githubEmail' => $githubData['email'],
            'githubUsername' => $githubData['github_username'] ?? null,
            'githubAvatar' => $githubData['avatar'] ?? null,
            'githubBio' => $githubData['bio'] ?? null,
        ]);
    }

    /**
     * Buat username unik otomatis dari email GitHub.
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
                ->withErrors(['email' => 'Sesi pendaftaran GitHub telah berakhir. Silakan coba lagi.']);
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
            'github_id'         => $data['github_id'],
            'github_username'   => $data['github_username'] ?? null,
            'github_token'      => $data['github_token'] ?? null,
            'github_refresh_token' => $data['github_refresh_token'] ?? null,
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

        return redirect()->route('github.waiting');
    }

    /**
     * Halaman "Menunggu Persetujuan Admin" setelah pendaftaran via GitHub.
     */
    public function showWaiting(Request $request)
    {
        $data = $request->session()->get(self::SESSION_WAITING);

        if (!$data) {
            return redirect()->route('login');
        }

        return view('auth.github-waiting', [
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
                "Ada pendaftar baru via GitHub:\n\n"
                . "Nama   : {$nama}\n"
                . "Email  : {$email}\n"
                . "Peran  : " . ucfirst($role) . "\n\n"
                . "Silakan tinjau dan setujui melalui panel admin:\n"
                . url('/admin/users/pending') . "\n\n"
                . "— Sistem EJSC Bakorwil Jember (otomatis)",
                function ($message) use ($penerima, $nama) {
                    $message->to($penerima)
                        ->subject("Pendaftar Baru Menunggu Persetujuan (GitHub): {$nama}");
                }
            );
        } catch (\Throwable $e) {
            report($e);
        }
    }

    /**
     * Batalkan pendaftaran via GitHub.
     */
    public function cancelRegistration(Request $request)
    {
        $request->session()->forget(self::SESSION_KEY);

        return redirect()->route('login');
    }
}