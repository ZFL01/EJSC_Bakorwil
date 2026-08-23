<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect($this->redirectTo());
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:4',
        ]);

        if (!Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            return back()->withErrors([
                'email' => 'Email atau password salah.'
            ])->onlyInput('email');
        }

        $user = Auth::user();
        if ($user->status !== 'aktif') {
            Auth::logout();
            return back()->withErrors(['email' => 'Akun belum aktif.']);
        }

        $request->session()->regenerate();
        $user->update(['last_login' => now()]);

        return redirect($this->redirectTo());
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    private function redirectTo()
    {
        $user = Auth::user();
        if ($user && $user->isAdmin()) {
            return '/admin/dashboard';
        }

        return '/profile';
    }
}
