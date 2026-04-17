<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user());
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required',
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // Login with username (not email)
        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        // Do not use remember token as the schema lacks 'remember_token' column
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Update last login timestamp
            Auth::user()->update(['last_login_at' => now()]);

            // Check if this is the first login (force password change)
            if (Auth::user()->force_password_change) {
                return redirect()->route('password.change')
                    ->with('info', 'Silakan ubah password default Anda untuk melanjutkan.');
            }

            return $this->redirectByRole(Auth::user());
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('landing')->with('success', 'Berhasil keluar dari sistem.');
    }

    /**
     * Show password change form (on first login)
     */
    public function showChangePassword()
    {
        $user = Auth::user();

        // Check if not logged in
        if (!$user) {
            return redirect()->route('login');
        }

        return view('auth.password-change', compact('user'));
    }

    /**
     * Update password (on first login or user-initiated)
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/'],
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password minimal 8 karaktere.',
            'password.regex' => 'Password harus mengandung huruf besar, huruf kecil, dan angka.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = Auth::user();

        // Verify current password
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Password saat ini tidak sesuai.',
            ])->onlyInput('current_password');
        }

        // Update password and clear force change flag
        $user->update([
            'password' => Hash::make($request->password),
            'force_password_change' => false,
            'password_changed_at' => now(),
        ]);

        return redirect()->route('password.success')
            ->with('success', 'Password berhasil diubah. Silakan lanjutkan ke dashboard.');
    }

    /**
     * Show password change success
     */
    public function passwordChangeSuccess()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        return view('auth.password-change-success');
    }

    /**
     * Redirect user by role after login
     */
    private function redirectByRole($user)
    {
        if (in_array($user->role, ['Admin', 'Ketua', 'Bendahara'])) {
            return redirect()->route('dashboard');
        }
        if ($user->role === 'Donatur') {
            return redirect()->route('donatur.dashboard');
        }
        return redirect()->route('login');
    }
}
