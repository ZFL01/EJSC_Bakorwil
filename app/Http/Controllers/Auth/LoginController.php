<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Menampilkan halaman login.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('public.index');
        }

        return view('auth.login');
    }


    /**
     * Proses login.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => [
                'required',
                'email',
            ],

            'password' => [
                'required',
                'string',
                'min:4',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Cek Email & Password
        |--------------------------------------------------------------------------
        */

        if (!Auth::attempt(
            $request->only('email', 'password'),
            $request->filled('remember')
        )) {

            return back()
                ->withErrors([
                    'email' => 'Email atau password salah.'
                ])
                ->onlyInput('email');
        }


        /*
        |--------------------------------------------------------------------------
        | Cek Status Akun
        |--------------------------------------------------------------------------
        */

        $user = Auth::user();

        if ($user->status !== 'aktif') {

            Auth::logout();

            $pesan = $user->status === 'pending'
                ? 'Akun Anda masih MENUNGGU PERSETUJUAN ADMIN. Silakan coba login lagi nanti.'
                : 'Akun belum aktif.';

            return back()
                ->withErrors([
                    'email' => $pesan
                ])
                ->onlyInput('email');
        }


        /*
        |--------------------------------------------------------------------------
        | Regenerate Session
        |--------------------------------------------------------------------------
        */

        $request->session()->regenerate();


        /*
        |--------------------------------------------------------------------------
        | Simpan Last Login
        |--------------------------------------------------------------------------
        */

        $user->update([
            'last_login' => now(),
        ]);


        /*
        |--------------------------------------------------------------------------
        | SEMUA USER MASUK KE HOME
        |--------------------------------------------------------------------------
        |
        | Admin, Mentor, Talenta, dan Client
        | semuanya masuk ke home.blade.php setelah login.
        |
        */

        return redirect()->route('public.index');
    }


    /**
     * Logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('public.index');
    }
}