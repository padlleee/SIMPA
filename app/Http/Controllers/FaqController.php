<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    // ── KATEGORI KONSTANTA ─────────────────────────────────────────────────────

    private const KATEGORI = ['profil', 'donasi', 'akun', 'layanan'];

    // ── PUBLIC ─────────────────────────────────────────────────────────────────

    /**
     * Halaman publik /faq — ambil semua FAQ, groupBy kategori.
     */
    public function publicIndex()
    {
        $faqs = Faq::ordered()->get()->groupBy('kategori');
        return view('faq', compact('faqs'));
    }

    // ── ADMIN ──────────────────────────────────────────────────────────────────

    public function adminIndex()
    {
        $faqs   = Faq::ordered()->paginate(20);
        $labels = Faq::kategoriLabel();
        return view('admin.faq.index', compact('faqs', 'labels'));
    }

    public function create()
    {
        $faq    = null;
        $labels = Faq::kategoriLabel();
        return view('admin.faq.form', compact('faq', 'labels'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'pertanyaan' => 'required|string|max:500',
            'jawaban'    => 'required|string',
            'kategori'   => 'required|in:' . implode(',', self::KATEGORI),
            'urutan'     => 'nullable|integer|min:0|max:999',
        ]);

        $data['urutan'] = $data['urutan'] ?? 0;

        Faq::create($data);

        return redirect()->route('admin.faq.index')
                         ->with('success', 'FAQ berhasil ditambahkan.');
    }

    public function edit(Faq $faq)
    {
        $labels = Faq::kategoriLabel();
        return view('admin.faq.form', compact('faq', 'labels'));
    }

    public function update(Request $request, Faq $faq)
    {
        $data = $request->validate([
            'pertanyaan' => 'required|string|max:500',
            'jawaban'    => 'required|string',
            'kategori'   => 'required|in:' . implode(',', self::KATEGORI),
            'urutan'     => 'nullable|integer|min:0|max:999',
        ]);

        $data['urutan'] = $data['urutan'] ?? 0;

        $faq->update($data);

        return redirect()->route('admin.faq.index')
                         ->with('success', 'FAQ berhasil diperbarui.');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();

        return redirect()->route('admin.faq.index')
                         ->with('success', 'FAQ berhasil dihapus.');
    }
}
