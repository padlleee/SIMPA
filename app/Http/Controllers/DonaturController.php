<?php

namespace App\Http\Controllers;

use App\Models\Donasi;
use App\Models\Donatur;
use App\Models\User;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DonaturController extends Controller
{
    public function dashboard()
    {
        $user    = Auth::user();
        $donatur = $user->donatur;

        // id_donatur in donasi table stores id_user directly
        $donasi = Donasi::where('id_donatur', $user->id_user)
            ->latest('tanggal_donasi')
            ->paginate(10);

        $totalDonasi = Donasi::where('id_donatur', $user->id_user)
            ->where('status_verifikasi', 'Valid')
            ->sum('nominal');

        $latestArticles = Article::latest()->take(3)->get();

        return view('donatur.dashboard', compact('user', 'donatur', 'donasi', 'totalDonasi', 'latestArticles'));
    }

    public function laporan(Request $request)
    {
        $user = Auth::user();

        $query = Donasi::where('id_donatur', $user->id_user);

        if ($request->filled('dari_tanggal')) {
            $query->whereDate('tanggal_donasi', '>=', $request->dari_tanggal);
        }

        if ($request->filled('sampai_tanggal')) {
            $query->whereDate('tanggal_donasi', '<=', $request->sampai_tanggal);
        }

        $totalDonasi          = (clone $query)->where('status_verifikasi', 'Valid')->sum('nominal');
        $totalTransaksi       = (clone $query)->count();
        $totalTerverifikasi   = (clone $query)->where('status_verifikasi', 'Valid')->count();

        $page    = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;
        $all     = $query->latest('tanggal_donasi')->get();

        $paginated = new LengthAwarePaginator(
            $all->slice(($page - 1) * $perPage, $perPage)->values(),
            $all->count(),
            $perPage,
            $page,
            [
                'path'  => LengthAwarePaginator::resolveCurrentPath(),
                'query' => $request->query(),
            ]
        );

        return view('donatur.laporan', compact(
            'user', 'paginated', 'totalDonasi', 'totalTransaksi', 'totalTerverifikasi'
        ));
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
            'email'        => 'nullable|email|max:100|unique:users,email,' . $user->id_user . ',id_user',
            'no_hp'        => 'nullable|string|max:20',
            'alamat'       => 'nullable|string',
            'password'     => 'nullable|string|min:8|confirmed',
        ]);

        // Sinkronkan data utama ke tabel users
        $user->update([
            'username' => $request->username,
            'email'    => $request->email,
        ]);

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
