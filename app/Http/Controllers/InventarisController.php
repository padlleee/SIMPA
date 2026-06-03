<?php

namespace App\Http\Controllers;

use App\Models\InventarisPeralatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InventarisController extends Controller
{
    public function index(Request $request)
    {
        $query = InventarisPeralatan::selectRaw('nama_kategori, sum(jumlah) as total_jumlah, MAX(satuan) as satuan, COUNT(*) as total_entri');

        if ($request->filled('search')) {
            $query->where('nama_kategori', 'like', '%' . $request->search . '%')
                  ->orWhere('nama_barang', 'like', '%' . $request->search . '%')
                  ->orWhere('kode_barang',  'like', '%' . $request->search . '%');
        }

        $inventaris = $query->groupBy('nama_kategori')
                            ->orderBy('nama_kategori')
                            ->paginate(15)
                            ->withQueryString();

        return view('inventaris.index', compact('inventaris'));
    }

    public function show($nama_kategori)
    {
        $items = InventarisPeralatan::where('nama_kategori', $nama_kategori)
                    ->orderBy('nama_barang')
                    ->get();
        return view('inventaris.show', compact('nama_kategori', 'items'));
    }

    public function create()
    {
        $lastItem = InventarisPeralatan::orderBy('id_aset', 'desc')->first();
        if ($lastItem && preg_match('/MT-(\d+)/', $lastItem->kode_barang, $matches)) {
            $nextNumber = intval($matches[1]) + 1;
        } else {
            $nextNumber = $lastItem ? $lastItem->id_aset + 1 : 1;
        }
        $newKodeBarang = 'MT-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        // Daftar kategori yang sudah ada (untuk dropdown)
        $kategoriList = InventarisPeralatan::select('nama_kategori')
            ->distinct()
            ->orderBy('nama_kategori')
            ->pluck('nama_kategori')
            ->filter()
            ->values();

        // Data barang per-kategori untuk autofill satuan
        $existingBarang = InventarisPeralatan::select('nama_kategori', 'satuan')
            ->groupBy('nama_kategori', 'satuan')
            ->get();

        return view('inventaris.create', compact('newKodeBarang', 'kategoriList', 'existingBarang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang'           => 'required|string|max:255',
            'nama_kategori'         => 'required|string|max:255',
            'nama_kategori_lainnya' => 'required_if:nama_kategori,Lainnya|nullable|string|max:255',
            'jumlah'                => 'required|integer|min:1',
            'satuan'                => 'required|string|max:50',
            'satuan_lainnya'        => 'required_if:satuan,Lainnya|nullable|string|max:50',
            'kode_barang'           => 'nullable|string|max:100',
            'lokasi'                => 'required|string|max:255',
            'kondisi'               => 'required|in:Baik,Rusak',
            'gambar'                => 'nullable|image|max:2048',
            'keterangan'            => 'nullable|string',
        ]);

        // Tentukan nama_kategori akhir
        $namaKategori = $request->nama_kategori === 'Lainnya'
            ? $request->nama_kategori_lainnya
            : $request->nama_kategori;
            
        // Tentukan satuan akhir
        $satuan = $request->satuan === 'Lainnya'
            ? $request->satuan_lainnya
            : $request->satuan;

        // Cek duplikat: nama_barang + lokasi + kondisi
        $exists = InventarisPeralatan::where('nama_barang', $request->nama_barang)
            ->where('lokasi', $request->lokasi)
            ->where('kondisi', $request->kondisi)
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors([
                'lokasi' => 'Peralatan dengan nama dan lokasi + kondisi yang sama sudah ada. Silakan update jumlah pada data yang sudah ada.'
            ]);
        }

        $data = $request->except(['nama_kategori_lainnya', 'satuan_lainnya']);
        $data['nama_kategori'] = $namaKategori;
        $data['satuan'] = $satuan;

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('inventaris', 'public');
        }

        InventarisPeralatan::create($data);
        return redirect()->route('inventaris.show', ['nama_kategori' => $namaKategori])
                         ->with('success', 'Aset peralatan berhasil ditambahkan ke kategori ' . $namaKategori . '.');
    }

    public function edit(InventarisPeralatan $inventari)
    {
        $kategoriList = InventarisPeralatan::select('nama_kategori')
            ->distinct()
            ->orderBy('nama_kategori')
            ->pluck('nama_kategori')
            ->filter()
            ->values();

        return view('inventaris.edit', [
            'inventaris'   => $inventari,
            'kategoriList' => $kategoriList,
        ]);
    }

    public function update(Request $request, InventarisPeralatan $inventari)
    {
        $request->validate([
            // nama_barang (nama spesifik) boleh diubah, tapi nama_kategori dikunci ke kolom kategori
            'nama_barang'           => 'required|string|max:255',
            'nama_kategori'         => 'required|string|max:255',
            'nama_kategori_lainnya' => 'required_if:nama_kategori,Lainnya|nullable|string|max:255',
            'jumlah'                => 'required|integer|min:1',
            'satuan'                => 'required|string|max:50',
            'satuan_lainnya'        => 'required_if:satuan,Lainnya|nullable|string|max:50',
            'kode_barang'           => 'nullable|string|max:100',
            'lokasi'                => 'required|string|max:255',
            'kondisi'               => 'required|in:Baik,Rusak',
            'gambar'                => 'nullable|image|max:2048',
            'keterangan'            => 'nullable|string',
        ]);

        $namaKategori = $request->nama_kategori === 'Lainnya'
            ? $request->nama_kategori_lainnya
            : $request->nama_kategori;
            
        $satuan = $request->satuan === 'Lainnya'
            ? $request->satuan_lainnya
            : $request->satuan;

        // Cek duplikat (kecuali dirinya sendiri)
        $exists = InventarisPeralatan::where('nama_barang', $request->nama_barang)
            ->where('lokasi', $request->lokasi)
            ->where('kondisi', $request->kondisi)
            ->where('id_aset', '!=', $inventari->id_aset)
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors([
                'lokasi' => 'Peralatan dengan nama dan lokasi + kondisi yang sama sudah ada.'
            ]);
        }

        $data = $request->except(['nama_kategori_lainnya', 'satuan_lainnya']);
        $data['nama_kategori'] = $namaKategori;
        $data['satuan'] = $satuan;

        if ($request->hasFile('gambar')) {
            if ($inventari->gambar) {
                Storage::disk('public')->delete($inventari->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('inventaris', 'public');
        }

        $inventari->update($data);
        return redirect()->route('inventaris.show', ['nama_kategori' => $namaKategori])
                         ->with('success', 'Data aset berhasil diperbarui.');
    }

    public function destroy(InventarisPeralatan $inventari)
    {
        $kategori = $inventari->nama_kategori;
        if ($inventari->gambar) {
            Storage::disk('public')->delete($inventari->gambar);
        }
        $inventari->delete();
        return back()->with('success', 'Aset berhasil dihapus.');
    }
}
