<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Mail\ForgotPasswordMail;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('landing');
        }
        return redirect()->route('landing')->with('showLoginModal', true);
    }

    public function login(Request $request)
    {
        $request->validateWithBag('login', [
            'email'    => 'required|string|email',
            'password' => 'required',
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // Login with email
        $credentials = [
            'email'    => $request->email,
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

            return redirect()->route('landing');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ], 'login')->onlyInput('email');
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
     * Self-service: Donatur mengajukan permintaan reset password via email
     */
    public function requestPasswordReset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
        ]);

        $user = User::where('email', $request->email)->first();

        // Email tidak ditemukan di database
        if (!$user) {
            return response()->json([
                'status'  => 'not_found',
                'message' => 'Email tidak terdaftar di sistem SIMPA.',
            ]);
        }

        // Role bukan Donatur — arahkan ke admin langsung
        if ($user->role !== 'Donatur') {
            return response()->json([
                'status'  => 'not_allowed',
                'message' => 'Akun ini tidak dapat direset secara mandiri. Hubungi Admin SIMPA secara langsung.',
            ]);
        }

        // Generate token
        $token = Str::random(60);

        // Hapus token lama jika ada, lalu insert yang baru
        DB::table('password_resets')->where('email', $user->email)->delete();
        DB::table('password_resets')->insert([
            'email' => $user->email,
            'token' => Hash::make($token),
            'created_at' => Carbon::now()
        ]);

        try {
            Mail::to($user->email)->send(new ForgotPasswordMail([
                'name' => $user->donatur->nama_donatur ?? $user->username,
                'reset_url' => route('password.reset', ['token' => $token, 'email' => $user->email]),
            ]));
            
            return response()->json([
                'status'  => 'success',
                'message' => 'Link reset password telah dikirim ke email Anda. Silakan cek Inbox atau Spam.',
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send reset link: ' . $e->getMessage());
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal mengirim email reset. Coba lagi nanti.',
            ]);
        }
    }

    /**
     * Tampilkan form pengisian password baru setelah link dari email diklik
     */
    public function showResetForm(Request $request, $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    /**
     * Proses ubah password dari form reset
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        // Cek token
        $record = DB::table('password_resets')->where('email', $request->email)->first();

        if (!$record || !Hash::check($request->token, $record->token)) {
            return back()->withInput($request->only('email'))
                         ->withErrors(['email' => 'Token reset password tidak valid atau sudah kadaluarsa.']);
        }

        // Cek expired (misal 60 menit)
        if (Carbon::parse($record->created_at)->addMinutes(60)->isPast()) {
            DB::table('password_resets')->where('email', $request->email)->delete();
            return back()->withInput($request->only('email'))
                         ->withErrors(['email' => 'Link reset password sudah kadaluarsa. Silakan request ulang.']);
        }

        // Update password user
        $user = User::where('email', $request->email)->first();
        $user->update([
            'password' => Hash::make($request->password),
            'force_password_change' => false,
            'password_changed_at' => now(),
        ]);

        // Hapus token yang sudah terpakai
        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Password Anda berhasil direset! Silakan login dengan password baru.');
    }

    /**
     * Redirect user by role after login — all go to landing page
     * where the profile dropdown lets them navigate to their dashboard.
     */
    private function redirectByRole($user)
    {
        return redirect()->route('landing');
    }
}
