<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Perpustakaan;

class LandingController extends Controller
{
    /**
     * Show the public landing page with the 3 most recent blog posts.
     */
    public function index()
    {
        // 3 artikel terbaru untuk blog preview section
        $recent_posts = Article::latest()->take(3)->get();

        // ── Buku Kurasi Landing Page ────────────────────────────
        // Ambil semua buku yang difeatured, kelompokkan per kategori_landing
        $featured = Perpustakaan::where('is_featured', true)
                        ->whereNotNull('kategori_landing')
                        ->get();

        $bukuSeringDipinjam = $featured->where('kategori_landing', 'sering_dipinjam')->take(4)->values();
        $bukuBaru           = $featured->where('kategori_landing', 'buku_baru')->take(4)->values();
        $bukuUnik           = $featured->where('kategori_landing', 'buku_unik')->take(4)->values();

        // ── Statistik Dampak Nyata ──────────────────────────────────
        $anakAktifCount = \App\Models\AnakAsuh::aktif()->count();
        $statAnakAktif  = $anakAktifCount > 100 ? 100 : $anakAktifCount;

        $alumniCount = \App\Models\AnakAsuh::alumni()->count();
        $statAlumni  = $alumniCount > 100 ? 100 : $alumniCount;

        $donaturCount = \App\Models\User::where('role', 'Donatur')->count();
        $statDonatur  = $donaturCount > 50 ? 50 : $donaturCount;

        // Yayasan berdiri tahun 1992, kelipatan 5
        $years = date('Y') - 1992;
        $statTahun = floor($years / 5) * 5;

        return view('landing', compact(
            'recent_posts',
            'bukuSeringDipinjam',
            'bukuBaru',
            'bukuUnik',
            'statAnakAktif',
            'statAlumni',
            'statDonatur',
            'statTahun'
        ));
    }
}
