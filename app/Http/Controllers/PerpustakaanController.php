<?php

namespace App\Http\Controllers;

use App\Models\Perpustakaan;
use App\Models\PeminjamanBuku;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

        $peminjamanAktif = PeminjamanBuku::dipinjam()
            ->with('buku')
            ->latest('tanggal_pinjam')
            ->get();

        return view('perpustakaan.index', compact('buku', 'peminjamanAktif'));
    }

    public function create()
    {
        $last = Perpustakaan::orderBy('id_buku', 'desc')->first();
        if ($last && preg_match('/BUK-(\d+)/', $last->kode_buku, $m)) {
            $next = intval($m[1]) + 1;
        } else {
            $next = $last ? $last->id_buku + 1 : 1;
        }
        $newKodeBuku = 'BUK-' . str_pad($next, 4, '0', STR_PAD_LEFT);

        return view('perpustakaan.create', compact('newKodeBuku'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_buku'        => 'required|string|unique:perpustakaan,kode_buku',
            'judul_buku'       => 'required|string|max:255',
            'pengarang'        => 'required|string|max:150',
            'penulis'          => 'nullable|string|max:150',
            'penerbit'         => 'nullable|string|max:150',
            'tahun_terbit'     => 'nullable|integer|min:1900|max:' . date('Y'),
            'isbn'             => 'nullable|string|max:30',
            'kategori_buku'    => 'nullable|string|max:80',
            'sinopsis'         => 'nullable|string',
            'foto_buku'        => 'nullable|image|max:2048',
            'jumlah_buku'      => 'required|integer|min:1',
            'kondisi_buku'     => 'nullable|string|max:50',
            'is_featured'      => 'nullable|boolean',
            'kategori_landing' => 'nullable|in:sering_dipinjam,buku_baru,buku_unik',
        ]);

        $data = $request->only([
            'kode_buku','judul_buku','pengarang','penulis','penerbit',
            'tahun_terbit','isbn','kategori_buku','sinopsis','jumlah_buku','kondisi_buku',
        ]);

        // Boolean checkbox: jika tidak dicentang, default false
        $data['is_featured']      = $request->boolean('is_featured');
        $data['kategori_landing'] = $request->input('kategori_landing');

        // Jika tidak featured, hapus kategori landing
        if (!$data['is_featured']) {
            $data['kategori_landing'] = null;
        }

        if ($request->hasFile('foto_buku')) {
            $uploadDir = public_path('storage/buku');
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
            $file     = $request->file('foto_buku');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            $data['foto_buku'] = 'buku/' . $filename;
        }

        Perpustakaan::create($data);
        return redirect()->route('perpustakaan.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function show(Perpustakaan $perpustakaan)
    {
        $perpustakaan->load('peminjaman');
        return view('perpustakaan.show', compact('perpustakaan'));
    }

    public function edit(Perpustakaan $perpustakaan)
    {
        return view('perpustakaan.edit', compact('perpustakaan'));
    }

    public function update(Request $request, Perpustakaan $perpustakaan)
    {
        $request->validate([
            'kode_buku'        => 'required|string|unique:perpustakaan,kode_buku,' . $perpustakaan->id_buku . ',id_buku',
            'judul_buku'       => 'required|string|max:255',
            'pengarang'        => 'required|string|max:150',
            'penulis'          => 'nullable|string|max:150',
            'penerbit'         => 'nullable|string|max:150',
            'tahun_terbit'     => 'nullable|integer|min:1900|max:' . date('Y'),
            'isbn'             => 'nullable|string|max:30',
            'kategori_buku'    => 'nullable|string|max:80',
            'sinopsis'         => 'nullable|string',
            'foto_buku'        => 'nullable|image|max:2048',
            'jumlah_buku'      => 'required|integer|min:1',
            'kondisi_buku'     => 'nullable|string|max:50',
            'is_featured'      => 'nullable|boolean',
            'kategori_landing' => 'nullable|in:sering_dipinjam,buku_baru,buku_unik',
        ]);

        $data = $request->only([
            'kode_buku','judul_buku','pengarang','penulis','penerbit',
            'tahun_terbit','isbn','kategori_buku','sinopsis','jumlah_buku','kondisi_buku',
        ]);

        // Boolean checkbox: jika tidak dicentang, default false
        $data['is_featured']      = $request->boolean('is_featured');
        $data['kategori_landing'] = $request->input('kategori_landing');

        // Jika tidak featured, hapus kategori landing
        if (!$data['is_featured']) {
            $data['kategori_landing'] = null;
        }

        if ($request->hasFile('foto_buku')) {
            $uploadDir = public_path('storage/buku');
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
            $file     = $request->file('foto_buku');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            // Delete old cover after new one is saved
            if ($perpustakaan->foto_buku && file_exists(public_path('storage/' . $perpustakaan->foto_buku))) {
                @unlink(public_path('storage/' . $perpustakaan->foto_buku));
            }
            $data['foto_buku'] = 'buku/' . $filename;
        }

        $perpustakaan->update($data);
        return redirect()->route('perpustakaan.index')->with('success', 'Data buku berhasil diperbarui.');
    }

    public function destroy(Perpustakaan $perpustakaan)
    {
        if ($perpustakaan->foto_buku) {
            Storage::disk('public')->delete($perpustakaan->foto_buku);
        }
        $perpustakaan->delete();
        return redirect()->route('perpustakaan.index')->with('success', 'Buku berhasil dihapus.');
    }

    // ===================== LENDING =====================

    public function pinjamCreate(Perpustakaan $perpustakaan)
    {
        return view('perpustakaan.pinjam', compact('perpustakaan'));
    }

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

    public function kembalikan(PeminjamanBuku $peminjaman)
    {
        $peminjaman->update([
            'status'               => 'Dikembalikan',
            'tanggal_dikembalikan' => now()->toDateString(), // record actual return date
        ]);
        return redirect()->route('perpustakaan.index')->with('success', 'Buku berhasil dikembalikan.');
    }

    // ===================== RIWAYAT =====================

    public function riwayat(Request $request)
    {
        $query = PeminjamanBuku::with('buku')->latest('updated_at');

        if ($request->filled('search')) {
            $query->where('nama_peminjam', 'like', '%' . $request->search . '%')
                  ->orWhereHas('buku', fn($q) => $q->where('judul_buku', 'like', '%' . $request->search . '%'));
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal_pinjam', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal_pinjam', '<=', $request->tanggal_sampai);
        }

        $riwayat = $query->paginate(20)->withQueryString();

        return view('perpustakaan.riwayat', compact('riwayat'));
    }

    // ===================== PUBLIC =====================

    public function publicIndex(Request $request)
    {
        $query = Perpustakaan::withCount(['peminjamanAktif as dipinjam_count']);

        if ($request->filled('search')) {
            $query->where('judul_buku', 'like', '%' . $request->search . '%')
                  ->orWhere('pengarang', 'like', '%' . $request->search . '%')
                  ->orWhere('kategori_buku', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('kategori')) {
            $query->where('kategori_buku', $request->kategori);
        }

        $buku       = $query->orderBy('judul_buku')->paginate(12)->withQueryString();
        $kategori   = Perpustakaan::whereNotNull('kategori_buku')->distinct()->pluck('kategori_buku');
        $totalBuku  = Perpustakaan::sum('jumlah_buku');
        $totalPinjam= PeminjamanBuku::dipinjam()->count();

        return view('perpustakaan.public-index', compact('buku', 'kategori', 'totalBuku', 'totalPinjam'));
    }
}
