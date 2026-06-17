<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Donatur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminResetPasswordMail;
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

        $authUser = auth()->user();

        // Proteksi Role
        if ($authUser->role !== 'Ketua' && in_array($request->role, ['Admin', 'Ketua'])) {
            return back()->withInput()->with('error', 'Anda tidak memiliki hak akses untuk membuat role Admin atau Ketua.');
        }

        if ($request->role === 'Admin') {
            $adminCount = User::where('role', 'Admin')->count();
            if ($adminCount >= 1) {
                return back()->withInput()->with('error', 'Sistem hanya diperbolehkan memiliki maksimal 1 Admin.');
            }
        }

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

        $authUser = auth()->user();

        // Proteksi Edit Akses
        if ($authUser->role === 'Admin') {
            if ($user->role === 'Ketua') {
                return back()->with('error', 'Admin tidak dapat mengubah data Ketua Yayasan.');
            }
            if ($user->role === 'Admin' && $user->id_user !== $authUser->id_user) {
                return back()->with('error', 'Admin tidak dapat mengubah data Admin lain.');
            }
        }

        // Proteksi Perubahan Role ke Admin/Ketua
        if ($authUser->role !== 'Ketua' && $request->role !== $user->role && in_array($request->role, ['Admin', 'Ketua'])) {
             return back()->with('error', 'Anda tidak berhak mengubah role menjadi Admin atau Ketua.');
        }

        // Proteksi Maksimal 1 Admin
        if ($request->role === 'Admin' && $user->role !== 'Admin') {
            $adminCount = User::where('role', 'Admin')->count();
            if ($adminCount >= 1) {
                return back()->with('error', 'Sistem hanya diperbolehkan memiliki maksimal 1 Admin.');
            }
        }

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
        $authUser = auth()->user();
        if ($user->id_user === $authUser->id_user) {
            return back()->with('error', 'Tidak dapat menghapus akun Anda sendiri.');
        }

        if ($authUser->role === 'Admin') {
            if ($user->role === 'Ketua') {
                return back()->with('error', 'Admin tidak dapat menghapus akun Ketua Yayasan.');
            }
            if ($user->role === 'Admin') {
                return back()->with('error', 'Admin tidak dapat menghapus akun Admin.');
            }
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
        $authUser = auth()->user();
        if ($user->id_user === $authUser->id_user) {
            return back()->with('error', 'Tidak dapat mereset password akun Anda sendiri.');
        }

        if ($authUser->role === 'Admin') {
            if ($user->role === 'Ketua') {
                return back()->with('error', 'Admin tidak dapat mereset password Ketua Yayasan.');
            }
            if ($user->role === 'Admin') {
                return back()->with('error', 'Admin tidak dapat mereset password Admin lain.');
            }
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

        try {
            Mail::to($user->email)->send(new AdminResetPasswordMail([
                'name' => $user->donatur->nama_donatur ?? $user->username,
                'username' => $user->username,
                'temp_password' => $tempPassword,
            ]));
            $emailSent = true;
        } catch (\Exception $e) {
            Log::error('Gagal mengirim email reset password oleh admin: ' . $e->getMessage());
            $emailSent = false;
        }

        $flashMessage = $emailSent 
            ? 'Password telah direset dan email pemberitahuan telah dikirim ke ' . $user->email . '.' 
            : 'Password telah direset namun GAGAL mengirim email. Berikan password berikut kepada pengguna secara manual.';

        return redirect()->route('users.index')
            ->with('reset_info', [
                'username'     => $user->username,
                'email'        => $user->email,
                'password'     => $tempPassword,
                'via_email'    => $isEmailReset,
                'extra_message'=> $flashMessage,
                'email_sent'   => $emailSent,
            ]);
    }
}
