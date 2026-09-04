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

class LinkedinAuthController extends Controller
{
    /**
     * Role yang boleh dipilih saat pendaftaran via LinkedIn.
     *
     * Admin TIDAK bisa mendaftar lewat LinkedIn.
     */
    private const ALLOWED_ROLES = ['mentor', 'talenta', 'client'];

    /**
     * Key session untuk data sementara pendaftar LinkedIn.
     */
    private const SESSION_KEY = 'linkedin_register';

    /**
     * Key session penanda "baru selesai mendaftar".
     */
    private const SESSION_WAITING = 'linkedin_waiting';

    /**
     * Arahkan user ke halaman OAuth LinkedIn.
     */
    public function redirect()
    {
        return Socialite::driver('linkedin-openid')->redirect();
    }

    /**
     * Handle callback dari LinkedIn.
     */
    public function callback(Request $request)
    {
        try {
            /*
             * stateless() menghindari masalah verifikasi state
             * yang sering terjadi pada localhost.
             */
            $linkedinUser = Socialite::driver('linkedin-openid')->stateless()->user();

        } catch (\Throwable $e) {

            report($e);

            $pesan = 'Login dengan LinkedIn gagal atau dibatalkan. Silakan coba lagi.';

            if (str_contains($e->getMessage(), 'cURL error 60')) {
                $pesan = 'Login LinkedIn gagal: sertifikat SSL lokal (cacert.pem) belum dikonfigurasi. Cek storage/logs/laravel.log.';
            } elseif (str_contains($e->getMessage(), 'invalid_client')) {
                $pesan = 'Login LinkedIn gagal: Client ID / Client Secret tidak valid. Periksa file .env lalu jalankan "php artisan config:clear".';
            } elseif (str_contains($e->getMessage(), 'redirect_uri_mismatch')) {
                $pesan = 'Login LinkedIn gagal: Redirect URI tidak cocok dengan konfigurasi LinkedIn Developer Portal.';
            }

            return redirect()
                ->route('login')
                ->withErrors(['email' => $pesan]);
        }

        /*
        |--------------------------------------------------------------------------
        | Pastikan email tersedia
        |--------------------------------------------------------------------------
        */
        if (!$linkedinUser->getEmail()) {
            return redirect()
                ->route('login')
                ->withErrors([
                    'email' => 'Akun LinkedIn Anda tidak memiliki email yang dapat digunakan.'
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Cari user berdasarkan linkedin_id, lalu email
        |--------------------------------------------------------------------------
        */
        $user = User::where('linkedin_id', $linkedinUser->getId())
            ->orWhere('email', $linkedinUser->getEmail())
            ->first();

        /*
        |--------------------------------------------------------------------------
        | User baru → simpan data sementara → halaman pilih peran
        |--------------------------------------------------------------------------
        */
        if (!$user) {
            $request->session()->put(self::SESSION_KEY, [
                'linkedin_id' => $linkedinUser->getId(),
                'name' => $linkedinUser->getName()
                    ?: $linkedinUser->getNickname()
                    ?: 'Pengguna LinkedIn',
                'email' => $linkedinUser->getEmail(),
                'avatar' => $linkedinUser->getAvatar(),
                'linkedin_token' => $linkedinUser->token,
                'linkedin_refresh_token' => $linkedinUser->refreshToken,
                'headline' => $linkedinUser->user['headline'] ?? null,
            ]);

            return redirect()->route('linkedin.role');
        }

        /*
        |--------------------------------------------------------------------------
        | User sudah ada → cek status
        |--------------------------------------------------------------------------
        */
        if ($user->status === 'pending') {
            return redirect()
                ->route('login')
                ->withErrors([
                    'email' => 'Akun Anda terdaftar via LinkedIn namun masih MENUNGGU PERSETUJUAN ADMIN. Silakan coba lagi nanti.'
                ]);
        }

        if ($user->status !== 'aktif') {
            return redirect()
                ->route('login')
                ->withErrors([
                    'email' => 'Akun belum aktif.'
                ])
                ->onlyInput('email');
        }

        /*
        |--------------------------------------------------------------------------
        | Link akun lalu login
        |--------------------------------------------------------------------------
        */
        $user->update([
            'linkedin_id' => $user->linkedin_id ?: $linkedinUser->getId(),
            'linkedin_token' => $user->linkedin_token ?: $linkedinUser->token,
            'linkedin_refresh_token' => $user->linkedin_refresh_token ?: $linkedinUser->refreshToken,
            'profile_photo' => $user->profile_photo ?: $linkedinUser->getAvatar(),
            'email_verified_at' => $user->email_verified_at ?: now(),
            'last_login' => now(),
        ]);

        Auth::login($user, true);

        $request->session()->regenerate();

        return redirect()->route('public.index');
    }

    /**
     * Tampilkan halaman pilih peran.
     */
    public function showRoleSelection(Request $request)
    {
        if (!$request->session()->has(self::SESSION_KEY)) {
            return redirect()
                ->route('login')
                ->withErrors([
                    'email' => 'Sesi pendaftaran LinkedIn telah berakhir. Silakan coba lagi.'
                ]);
        }

        $linkedinData = $request->session()->get(self::SESSION_KEY);

        return view('auth.linkedin-role', [
            'linkedinName' => $linkedinData['name'],
            'linkedinEmail' => $linkedinData['email'],
            'linkedinAvatar' => $linkedinData['avatar'] ?? null,
            'linkedinHeadline' => $linkedinData['headline'] ?? null,
        ]);
    }

    /**
     * Buat username unik otomatis dari email LinkedIn.
     */
    private function makeUsername(string $email): string
    {
        $base = Str::slug(
            explode('@', strtolower($email))[0],
            ''
        ) ?: 'user';

        $base = substr($base, 0, 90);

        $username = $base;
        $i = 1;

        while (User::where('username', $username)->exists()) {
            $username = $base . ($i++);
        }

        return $username;
    }

    /**
     * Simpan user baru dengan peran terpilih.
     */
    public function completeRegistration(Request $request)
    {
        $data = $request->session()->get(self::SESSION_KEY);

        if (!$data) {
            return redirect()
                ->route('login')
                ->withErrors([
                    'email' => 'Sesi pendaftaran LinkedIn telah berakhir. Silakan coba lagi.'
                ]);
        }

        $validated = $request->validate([
            'role' => [
                'required',
                'in:' . implode(',', self::ALLOWED_ROLES)
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Cegah email duplikat
        |--------------------------------------------------------------------------
        */
        $existing = User::where('email', $data['email'])->first();

        if ($existing) {
            $request->session()->forget(self::SESSION_KEY);

            return redirect()
                ->route('login')
                ->withErrors([
                    'email' => 'Email ini sudah terdaftar. Silakan login dengan email & password Anda.'
                ]);
        }

        User::create([
            'name' => $data['name'],
            'username' => $this->makeUsername($data['email']),
            'email' => $data['email'],
            'password_hash' => Hash::make(Str::random(40)),
            'linkedin_id' => $data['linkedin_id'],
            'linkedin_token' => $data['linkedin_token'] ?? null,
            'linkedin_refresh_token' => $data['linkedin_refresh_token'] ?? null,
            'profile_photo' => $data['avatar'],
            'role' => $validated['role'],
            'status' => 'pending',
            'email_verified_at' => now(),
        ]);

        $request->session()->forget(self::SESSION_KEY);

        /*
        |--------------------------------------------------------------------------
        | Tandai sesi waiting
        |--------------------------------------------------------------------------
        */
        $request->session()->put(self::SESSION_WAITING, [
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $validated['role'],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Kirim notifikasi email ke admin
        |--------------------------------------------------------------------------
        */
        $this->notifyAdmin(
            $data['name'],
            $data['email'],
            $validated['role']
        );

        return redirect()->route('linkedin.waiting');
    }

    /**
     * Halaman Menunggu Persetujuan Admin.
     */
    public function showWaiting(Request $request)
    {
        $data = $request->session()->get(self::SESSION_WAITING);

        if (!$data) {
            return redirect()->route('login');
        }

        return view('auth.linkedin-waiting', [
            'nama' => $data['name'],
            'email' => $data['email'],
            'role' => ucfirst($data['role']),
        ]);
    }

    /**
     * Kirim email notifikasi ke admin.
     */
    private function notifyAdmin(string $nama, string $email, string $role): void
    {
        $penerima = env('ADMIN_NOTIFY_EMAIL', 'admin@bakorwil.go.id');

        try {
            Mail::raw(
                "Ada pendaftar baru via LinkedIn:\n\n"
                . "Nama   : {$nama}\n"
                . "Email  : {$email}\n"
                . "Peran  : " . ucfirst($role) . "\n\n"
                . "Silakan tinjau dan setujui melalui panel admin:\n"
                . url('/admin/users/pending') . "\n\n"
                . "— Sistem EJSC Bakorwil Jember (otomatis)",
                function ($message) use ($penerima, $nama) {
                    $message->to($penerima)->subject("Pendaftar Baru Menunggu Persetujuan (LinkedIn): {$nama}");
                }
            );
        } catch (\Throwable $e) {
            report($e);
        }
    }

    /**
     * Batalkan pendaftaran via LinkedIn.
     */
    public function cancelRegistration(Request $request)
    {
        $request->session()->forget(self::SESSION_KEY);

        return redirect()->route('login');
    }
}