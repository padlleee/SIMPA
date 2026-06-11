<?php

namespace App\Http\Controllers;

use App\Models\Donasi;
use App\Models\Donatur;
use App\Models\PeminjamanBukuDonatur;
use App\Models\Perpustakaan;
use App\Models\User;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

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

    public function printLaporan(Request $request)
    {
        $user = Auth::user();

        $query = Donasi::where('id_donatur', $user->id_user)
                       ->where('status_verifikasi', 'Valid');

        if ($request->filled('dari_tanggal')) {
            $query->whereDate('tanggal_donasi', '>=', $request->dari_tanggal);
        }

        if ($request->filled('sampai_tanggal')) {
            $query->whereDate('tanggal_donasi', '<=', $request->sampai_tanggal);
        }

        $allDonations = $query->latest('tanggal_donasi')->get();
        $totalDonasi  = $allDonations->sum('nominal');

        return view('donatur.print', compact(
            'user', 'allDonations', 'totalDonasi', 'request'
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

    // ────────────────────────────────────────────────────────
    //  PERPUSTAKAAN DONATUR
    // ────────────────────────────────────────────────────────

    /**
     * Browse the book catalogue (Donatur view).
     */
    public function perpustakaanIndex(Request $request)
    {
        $query = Perpustakaan::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('judul_buku', 'like', '%' . $request->search . '%')
                  ->orWhere('penulis', 'like', '%' . $request->search . '%');
            });
        }
        if ($request->filled('kategori')) {
            $query->where('kategori_buku', $request->kategori);
        }
        if ($request->filled('status_filter')) {
            if ($request->status_filter === 'tersedia') {
                $query->whereRaw('jumlah_buku > (SELECT COUNT(*) FROM peminjaman_buku_donatur WHERE buku_id = perpustakaan.id_buku AND status IN ("Pending","Dipinjam"))');
            } elseif ($request->status_filter === 'habis') {
                $query->whereRaw('jumlah_buku <= (SELECT COUNT(*) FROM peminjaman_buku_donatur WHERE buku_id = perpustakaan.id_buku AND status IN ("Pending","Dipinjam"))');
            }
        }

        $buku = $query->orderBy('judul_buku')->paginate(20)->withQueryString();

        $kategoriList = Perpustakaan::whereNotNull('kategori_buku')
            ->distinct()->pluck('kategori_buku');

        return view('donatur.perpustakaan-index', compact('buku', 'kategoriList'));
    }

    /**
     * Show book detail + checkout form for a Donatur.
     */
    public function perpustakaanShow(Perpustakaan $buku)
    {
        $donatur = Auth::user()->donatur;

        // Riwayat peminjaman donatur ini untuk buku ini
        $riwayatSaya = $donatur
            ? PeminjamanBukuDonatur::where('donatur_id', $donatur->id_donatur)
                                   ->where('buku_id', $buku->id_buku)
                                   ->latest('tanggal_pinjam')
                                   ->get()
            : collect();

        return view('donatur.perpustakaan-show', compact('buku', 'riwayatSaya'));
    }

    /**
     * Store a new loan request (checkout) from a Donatur.
     * Status starts as 'Pending' until admin confirms.
     */
    public function perpustakaanCheckout(Request $request, Perpustakaan $buku)
    {
        $donatur = Auth::user()->donatur;

        if (!$donatur) {
            return back()->with('error', 'Profil donatur belum lengkap. Silakan lengkapi profil terlebih dahulu.');
        }

        // Prevent duplicate active loan for the same book
        $existing = PeminjamanBukuDonatur::where('donatur_id', $donatur->id_donatur)
            ->where('buku_id', $buku->id_buku)
            ->whereIn('status', ['Pending', 'Dipinjam'])
            ->exists();

        if ($existing) {
            return back()->with('error', 'Anda sudah memiliki peminjaman aktif untuk buku ini.');
        }

        // Check availability
        $sisa = $buku->jumlah_buku - $buku->peminjamanAktifTotal();
        if ($sisa <= 0) {
            return back()->with('error', 'Maaf, semua eksemplar buku ini sedang dipinjam.');
        }

        $request->validate([
            'tanggal_kembali' => 'required|date|after:today|before_or_equal:' . now()->addDays(30)->format('Y-m-d'),
            'dana_jaminan'    => 'required|integer|min:5000',
            'catatan'         => 'nullable|string|max:500',
        ], [
            'tanggal_kembali.after'          => 'Tanggal kembali harus setelah hari ini.',
            'tanggal_kembali.before_or_equal'=> 'Maksimal peminjaman adalah 30 hari.',
            'dana_jaminan.min'               => 'Dana jaminan minimal Rp 5.000.',
        ]);

        DB::beginTransaction();
        try {
            PeminjamanBukuDonatur::create([
                'donatur_id'     => $donatur->id_donatur,
                'buku_id'        => $buku->id_buku,
                'tanggal_pinjam' => now()->toDateString(),
                'tanggal_kembali'=> $request->tanggal_kembali,
                'dana_jaminan'   => (int) $request->dana_jaminan,
                'status'         => 'Pending',
                'catatan'        => $request->catatan,
            ]);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('perpustakaanCheckout failed: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal mengajukan peminjaman. Silakan coba lagi.');
        }

        return redirect()->route('donatur.perpustakaan.show', $buku)
                         ->with('success', 'Peminjaman buku "' . $buku->judul_buku . '" berhasil diajukan. Tunggu konfirmasi dari petugas.');
    }
}
