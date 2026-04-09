<?php

namespace App\Http\Controllers;

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
            'kondisi'        => 'nullable|in:Baik,Rusak,Perlu Perbaikan',
            'keterangan'     => 'nullable|string',
        ]);

        StokPanti::create(array_merge($request->all(), ['id_admin' => Auth::user()->id_user]));
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
            'kondisi'        => 'nullable|in:Baik,Rusak,Perlu Perbaikan',
            'keterangan'     => 'nullable|string',
        ]);

        $stok->update($request->all());
        return redirect()->route('stok.index')->with('success', 'Data stok berhasil diperbarui.');
    }

    public function destroy(StokPanti $stok)
    {
        $stok->delete();
        return redirect()->route('stok.index')->with('success', 'Barang berhasil dihapus.');
    }
}
