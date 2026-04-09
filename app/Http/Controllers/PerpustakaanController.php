<?php

namespace App\Http\Controllers;

use App\Models\Perpustakaan;
use App\Models\PeminjamanBuku;
use Illuminate\Http\Request;

class PerpustakaanController extends Controller
{
    public function index(Request $request)
    {
        $query = Perpustakaan::withCount(['peminjamanAktif as dipinjam_count']);
        if ($request->filled('search')) {
            $query->where('judul_buku', 'like', '%' . $request->search . '%')
                  ->orWhere('pengarang', 'like', '%' . $request->search . '%')
                  ->orWhere('kode_buku', 'like', '%' . $request->search . '%');
        }
        $buku = $query->orderBy('judul_buku')->paginate(15)->withQueryString();

        $peminjamanAktif = PeminjamanBuku::dipinjam()->with('buku')->latest('tanggal_pinjam')->get();

        return view('perpustakaan.index', compact('buku', 'peminjamanAktif'));
    }

    public function create()
    {
        return view('perpustakaan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_buku'   => 'required|string|unique:perpustakaan,kode_buku',
            'judul_buku'  => 'required|string|max:255',
            'pengarang'   => 'required|string|max:255',
            'jumlah_buku' => 'required|integer|min:1',
            'kondisi_buku'=> 'nullable|string|max:50',
        ]);

        Perpustakaan::create($request->all());
        return redirect()->route('perpustakaan.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit(Perpustakaan $perpustakaan)
    {
        return view('perpustakaan.edit', compact('perpustakaan'));
    }

    public function update(Request $request, Perpustakaan $perpustakaan)
    {
        $request->validate([
            'kode_buku'   => 'required|string|unique:perpustakaan,kode_buku,' . $perpustakaan->id_buku . ',id_buku',
            'judul_buku'  => 'required|string|max:255',
            'pengarang'   => 'required|string|max:255',
            'jumlah_buku' => 'required|integer|min:1',
            'kondisi_buku'=> 'nullable|string|max:50',
        ]);

        $perpustakaan->update($request->all());
        return redirect()->route('perpustakaan.index')->with('success', 'Data buku berhasil diperbarui.');
    }

    public function destroy(Perpustakaan $perpustakaan)
    {
        $perpustakaan->delete();
        return redirect()->route('perpustakaan.index')->with('success', 'Buku berhasil dihapus.');
    }

    // Lending form
    public function pinjamCreate(Perpustakaan $perpustakaan)
    {
        return view('perpustakaan.pinjam', compact('perpustakaan'));
    }

    // Store lending
    public function pinjamStore(Request $request, Perpustakaan $perpustakaan)
    {
        $dipinjam = $perpustakaan->peminjamanAktif()->count();
        if ($dipinjam >= $perpustakaan->jumlah_buku) {
            return back()->with('error', 'Semua eksemplar buku sedang dipinjam.');
        }

        $request->validate([
            'nama_peminjam'   => 'required|string|max:255',
            'tanggal_pinjam'  => 'required|date',
            'tanggal_kembali' => 'required|date|after:tanggal_pinjam',
        ]);

        PeminjamanBuku::create([
            'id_buku'         => $perpustakaan->id_buku,
            'nama_peminjam'   => $request->nama_peminjam,
            'tanggal_pinjam'  => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status'          => 'Dipinjam',
        ]);

        return redirect()->route('perpustakaan.index')->with('success', "Buku \"{$perpustakaan->judul_buku}\" berhasil dipinjamkan.");
    }

    // Return book
    public function kembalikan(PeminjamanBuku $peminjaman)
    {
        $peminjaman->update(['status' => 'Dikembalikan']);
        return redirect()->route('perpustakaan.index')->with('success', 'Buku berhasil dikembalikan.');
    }
}
