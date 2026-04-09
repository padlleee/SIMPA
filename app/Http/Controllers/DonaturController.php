<?php

namespace App\Http\Controllers;

use App\Models\Donasi;
use App\Models\Donatur;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DonaturController extends Controller
{
    public function dashboard()
    {
        $user    = Auth::user();
        $donatur = $user->donatur;

        $donasi = $donatur
            ? Donasi::where('id_donatur', $donatur->id_donatur)->latest('tanggal_donasi')->paginate(10)
            : collect();

        $totalDonasi = $donatur
            ? Donasi::where('id_donatur', $donatur->id_donatur)->valid()->sum('nominal')
            : 0;

        return view('donatur.dashboard', compact('user', 'donatur', 'donasi', 'totalDonasi'));
    }

    public function profile()
    {
        $user    = Auth::user();
        $donatur = $user->donatur;
        return view('donatur.profile', compact('user', 'donatur'));
    }

    public function profileUpdate(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'username'     => 'required|string|max:50|unique:users,username,' . $user->id_user . ',id_user',
            'nama_donatur' => 'nullable|string|max:100',
            'email'        => 'nullable|email|max:100',
            'no_hp'        => 'nullable|string|max:20',
            'alamat'       => 'nullable|string',
            'password'     => 'nullable|string|min:8|confirmed',
        ]);

        $user->update(['username' => $request->username]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        if ($user->donatur) {
            $user->donatur->update([
                'nama_donatur' => $request->nama_donatur,
                'email'        => $request->email,
                'no_hp'        => $request->no_hp,
                'alamat'       => $request->alamat,
            ]);
        }

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
