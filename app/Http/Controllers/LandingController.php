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

        return view('landing', compact(
            'recent_posts',
            'bukuSeringDipinjam',
            'bukuBaru',
            'bukuUnik'
        ));
    }
}
