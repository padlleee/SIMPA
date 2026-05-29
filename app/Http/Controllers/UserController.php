<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Donatur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('username')->paginate(15);
        // Hitung donatur yang sedang menunggu reset password diproses admin
        $pendingResetCount = User::whereNotNull('password_reset_requested_at')->count();
        return view('users.index', compact('users', 'pendingResetCount'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:50|unique:users,username',
            'email'    => 'required|email|max:150|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role'     => 'required|in:Admin,Ketua,Bendahara,Donatur',
        ], [
            'email.unique' => 'Email sudah terdaftar. Silakan gunakan email lain.',
            'username.unique' => 'Username sudah digunakan. Silakan pilih username lain.',
        ]);

        $user = User::create([
            'username'             => $request->username,
            'email'                => $request->email,
            'password'             => Hash::make($request->password),
            'role'                 => $request->role,
            'force_password_change'=> true,
        ]);

        if ($request->role === 'Donatur') {
            Donatur::create([
                'id_user'      => $user->id_user,
                'nama_donatur' => $request->username,
                'email'        => $request->email,   // wajib diisi, kolom NOT NULL di tabel donatur
                'no_hp'        => '-',
                'alamat'       => '-',
            ]);
        }

        return redirect()->route('users.index')->with('success', 'Akun pengguna berhasil dibuat.');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'username' => 'required|string|max:50|unique:users,username,' . $user->id_user . ',id_user',
            'email'    => 'required|email|max:150|unique:users,email,' . $user->id_user . ',id_user',
            'role'     => 'required|in:Admin,Ketua,Bendahara,Donatur',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = [
            'username' => $request->username,
            'email'    => $request->email,
            'role'     => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        return redirect()->route('users.index')->with('success', 'Akun pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id_user === auth()->id()) {
            return back()->with('error', 'Tidak dapat menghapus akun Anda sendiri.');
        }
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Akun pengguna berhasil dihapus.');
    }

    /**
     * Reset password pengguna ke password sementara (Admin only)
     * Jika ada flag reset_request, ini berarti donatur yang meminta via self-service
     */
    public function resetPassword(User $user)
    {
        if ($user->id_user === auth()->id()) {
            return back()->with('error', 'Tidak dapat mereset password akun Anda sendiri.');
        }

        // Generate password sementara yang mudah dibaca
        $tempPassword = 'Simpa' . rand(1000, 9999);
        $isEmailReset  = (bool) $user->password_reset_requested_at;

        $user->update([
            'password'                   => Hash::make($tempPassword),
            'force_password_change'      => true,
            'password_changed_at'        => null,
            'password_reset_requested_at'=> null, // Hapus flag permintaan
        ]);

        // Stub: log sebagai pengganti kirim email (siap diganti Mail::send)
        Log::info('[SIMPA] Admin telah mereset password pengguna', [
            'admin_id'      => auth()->id(),
            'target_user'   => $user->username,
            'target_email'  => $user->email,
            'temp_password' => $tempPassword, // HANYA untuk log dev, hapus saat production
            'via_request'   => $isEmailReset,
        ]);

        $flashMessage = $isEmailReset
            ? 'Password sementara telah digenerate. Dalam implementasi nyata, password akan dikirim ke email ' . $user->email . '.'
            : null;

        return redirect()->route('users.index')
            ->with('reset_info', [
                'username'     => $user->username,
                'email'        => $user->email,
                'password'     => $tempPassword,
                'via_email'    => $isEmailReset,
                'extra_message'=> $flashMessage,
            ]);
    }
}
