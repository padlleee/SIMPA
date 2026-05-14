<?php

namespace App\Http\Controllers;

use App\Models\RiwayatStok;
use App\Models\StokPanti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StokController extends Controller
{
    public function index(Request $request)
    {
        $query = StokPanti::query();
        if ($request->filled('search')) {
            $query->where('nama_barang', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('kategori')) {
            $query->where('kategori_barang', $request->kategori);
        }
        if ($request->filled('filter') && $request->filter == 'menipis') {
            $query->where('stok_akhir', '<=', 5);
        }
        $stok = $query->orderBy('nama_barang')->paginate(15)->withQueryString();
        return view('stok.index', compact('stok'));
    }

    public function create()
    {
        return view('stok.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang'    => 'required|string|max:100',
            'kategori_barang'=> 'nullable|in:Sembako,Logistik,Aset Tetap,Lainnya',
            'stok_awal'      => 'required|integer|min:0',
            'barang_masuk'   => 'required|integer|min:0',
            'barang_keluar'  => 'required|integer|min:0',
            'stok_akhir'     => 'required|integer|min:0',
            'satuan'         => 'nullable|string|max:20',
            'keterangan'     => 'nullable|string',
        ]);

        if ($request->barang_keluar > ($request->stok_awal + $request->barang_masuk)) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['barang_keluar' => 'Barang keluar melebihi stok yang tersedia.']);
        }

        $stokBaru = StokPanti::create([
            'nama_barang'    => $request->nama_barang,
            'kategori_barang'=> $request->kategori_barang,
            'satuan'         => $request->satuan,
            'stok_awal'      => $request->stok_awal,
            'barang_masuk'   => $request->barang_masuk,
            'barang_keluar'  => $request->barang_keluar,
            'stok_akhir'     => $request->stok_akhir,
            'keterangan'     => $request->keterangan,
            'id_admin'       => Auth::user()->id_user,
        ]);

        // Log riwayat stok masuk
        if ($request->barang_masuk > 0) {
            RiwayatStok::create([
                'id_stok'       => $stokBaru->id_stok,
                'nama_barang'   => $request->nama_barang,
                'kategori_barang'=> $request->kategori_barang,
                'satuan'        => $request->satuan,
                'jenis'         => 'Masuk',
                'jumlah'        => $request->barang_masuk,
                'stok_sebelum'  => $request->stok_awal,
                'stok_sesudah'  => $request->stok_awal + $request->barang_masuk,
                'keterangan'    => $request->keterangan,
                'id_admin'      => Auth::user()->id_user,
            ]);
        }

        // Log riwayat stok keluar
        if ($request->barang_keluar > 0) {
            RiwayatStok::create([
                'id_stok'       => $stokBaru->id_stok,
                'nama_barang'   => $request->nama_barang,
                'kategori_barang'=> $request->kategori_barang,
                'satuan'        => $request->satuan,
                'jenis'         => 'Keluar',
                'jumlah'        => $request->barang_keluar,
                'stok_sebelum'  => $request->stok_awal + $request->barang_masuk,
                'stok_sesudah'  => $request->stok_akhir,
                'keterangan'    => $request->keterangan,
                'id_admin'      => Auth::user()->id_user,
            ]);
        }

        return redirect()->route('stok.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function edit(StokPanti $stok)
    {
        return view('stok.edit', compact('stok'));
    }

    public function update(Request $request, StokPanti $stok)
    {
        $request->validate([
            'nama_barang'    => 'required|string|max:100',
            'kategori_barang'=> 'nullable|in:Sembako,Logistik,Aset Tetap,Lainnya',
            'stok_awal'      => 'required|integer|min:0',
            'barang_masuk'   => 'required|integer|min:0',
            'barang_keluar'  => 'required|integer|min:0',
            'stok_akhir'     => 'required|integer|min:0',
            'satuan'         => 'nullable|string|max:20',
            'keterangan'     => 'nullable|string',
        ]);

        if ($request->barang_keluar > ($request->stok_awal + $request->barang_masuk)) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['barang_keluar' => 'Barang keluar melebihi stok yang tersedia.']);
        }

        $stokLama = $stok->stok_akhir;
        $stok->update($request->only([
            'nama_barang', 'kategori_barang', 'satuan',
            'stok_awal', 'barang_masuk', 'barang_keluar', 'stok_akhir', 'keterangan',
        ]));

        // Log riwayat masuk jika ada perubahan masuk
        if ($request->barang_masuk > 0) {
            RiwayatStok::create([
                'id_stok'       => $stok->id_stok,
                'nama_barang'   => $request->nama_barang,
                'kategori_barang'=> $request->kategori_barang,
                'satuan'        => $request->satuan,
                'jenis'         => 'Masuk',
                'jumlah'        => $request->barang_masuk,
                'stok_sebelum'  => $request->stok_awal,
                'stok_sesudah'  => $request->stok_awal + $request->barang_masuk,
                'keterangan'    => '[Update] ' . ($request->keterangan ?? ''),
                'id_admin'      => Auth::user()->id_user,
            ]);
        }

        // Log riwayat keluar jika ada
        if ($request->barang_keluar > 0) {
            RiwayatStok::create([
                'id_stok'       => $stok->id_stok,
                'nama_barang'   => $request->nama_barang,
                'kategori_barang'=> $request->kategori_barang,
                'satuan'        => $request->satuan,
                'jenis'         => 'Keluar',
                'jumlah'        => $request->barang_keluar,
                'stok_sebelum'  => $request->stok_awal + $request->barang_masuk,
                'stok_sesudah'  => $request->stok_akhir,
                'keterangan'    => '[Update] ' . ($request->keterangan ?? ''),
                'id_admin'      => Auth::user()->id_user,
            ]);
        }

        return redirect()->route('stok.index')->with('success', 'Data stok berhasil diperbarui.');
    }

    public function destroy(StokPanti $stok)
    {
        $stok->delete();
        return redirect()->route('stok.index')->with('success', 'Barang berhasil dihapus.');
    }
}
