<?php

namespace App\Http\Controllers;

use App\Models\AccountRequest;
use App\Models\Donatur;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\AccountApprovedMail;

class AccountRequestController extends Controller
{
    /**
     * Show the public account request form.
     */
    public function publicCreate()
    {
        return redirect()->route('landing')->with('showRegisterModal', true);
    }

    /**
     * Store a public account request.
     */
    public function publicStore(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:150',
            'email'        => 'required|email|max:150|unique:account_requests,email',
            'no_hp'        => 'nullable|string|max:20',
            'pesan'        => 'nullable|string|max:500',
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'email.required'        => 'Email wajib diisi.',
            'email.email'           => 'Format email tidak valid.',
            'email.unique'          => 'Email ini sudah pernah mengajukan permintaan akun.',
        ]);

        AccountRequest::create([
            'nama_lengkap' => $request->nama_lengkap,
            'email'        => $request->email,
            'no_hp'        => $request->no_hp,
            'pesan'        => $request->pesan,
        ]);

        return redirect()->route('landing')
            ->with('success', 'Permintaan akun Anda berhasil dikirim. Admin akan meninjau dan menghubungi Anda melalui email.');
    }

    /**
     * Admin: list all account requests.
     */
    public function index(Request $request)
    {
        $query = AccountRequest::latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $requests = $query->paginate(15)->withQueryString();
        $pendingCount = AccountRequest::where('status', 'pending')->count();

        return view('account-request.index', compact('requests', 'pendingCount'));
    }

    /**
     * Admin: approve a request — creates User + Donatur record.
     */
    public function approve(AccountRequest $accountRequest)
    {
        if (!$accountRequest->isPending()) {
            return back()->with('error', 'Permintaan ini sudah diproses sebelumnya.');
        }

        // Check email not already registered
        if (User::where('email', $accountRequest->email)->exists()) {
            $accountRequest->update([
                'status'      => 'approved',
                'reviewed_by' => Auth::id(),
                'reviewed_at' => now(),
            ]);
            return back()->with('info', 'Email sudah terdaftar. Status diperbarui ke approved.');
        }

        // Generate username from email prefix
        $baseUsername = Str::slug(explode('@', $accountRequest->email)[0], '.');
        $username = $baseUsername;
        $i = 1;
        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . $i;
            $i++;
        }

        // Generate a temporary password
        $tempPassword = Str::random(10);

        $user = User::create([
            'username'             => $username,
            'email'                => $accountRequest->email,
            'password'             => Hash::make($tempPassword),
            'role'                 => 'Donatur',
            'force_password_change'=> true,
        ]);

        Donatur::create([
            'id_user'      => $user->id_user,
            'nama_donatur' => $accountRequest->nama_lengkap,
            'email'        => $accountRequest->email,
            'no_hp'        => $accountRequest->no_hp ?? '-',
            'alamat'       => '-',
        ]);

        $accountRequest->update([
            'status'      => 'approved',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);

        try {
            Mail::to($accountRequest->email)->send(new AccountApprovedMail([
                'name'     => $accountRequest->nama_lengkap,
                'username' => $username,
                'password' => $tempPassword,
            ]));
            $msg = "Akun berhasil disetujui. Email berisi kredensial telah dikirim ke {$accountRequest->email}.";
        } catch (\Exception $e) {
            $msg = "Akun berhasil disetujui, namun gagal mengirim email. Username: {$username} | Password: {$tempPassword}";
        }

        return back()->with('success', $msg);
    }

    /**
     * Admin: reject a request.
     */
    public function reject(AccountRequest $accountRequest)
    {
        if (!$accountRequest->isPending()) {
            return back()->with('error', 'Permintaan ini sudah diproses sebelumnya.');
        }

        $accountRequest->update([
            'status'      => 'rejected',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);

        return back()->with('success', 'Permintaan akun telah ditolak.');
    }
}
