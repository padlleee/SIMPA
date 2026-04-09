<?php

namespace App\Http\Controllers;

use App\Models\InventarisPeralatan;
use Illuminate\Http\Request;

class InventarisController extends Controller
{
    public function index(Request $request)
    {
        $query = InventarisPeralatan::query();
        if ($request->filled('search')) {
            $query->where('nama_barang', 'like', '%' . $request->search . '%')
                  ->orWhere('kode_barang', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('kondisi')) {
            $query->where('kondisi', $request->kondisi);
        }
        $inventaris = $query->orderBy('nama_barang')->paginate(15)->withQueryString();
        return view('inventaris.index', compact('inventaris'));
    }

    public function create()
    {
        return view('inventaris.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'jumlah'      => 'required|integer|min:1',
            'satuan'      => 'required|string|max:50',
            'kode_barang' => 'nullable|string|max:100',
            'lokasi'      => 'nullable|string|max:255',
            'kondisi'     => 'required|in:Baik,Rusak',
        ]);

        InventarisPeralatan::create($request->all());
        return redirect()->route('inventaris.index')->with('success', 'Aset peralatan berhasil ditambahkan.');
    }

    public function edit(InventarisPeralatan $inventari)
    {
        return view('inventaris.edit', ['inventaris' => $inventari]);
    }

    public function update(Request $request, InventarisPeralatan $inventari)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'jumlah'      => 'required|integer|min:1',
            'satuan'      => 'required|string|max:50',
            'kode_barang' => 'nullable|string|max:100',
            'lokasi'      => 'nullable|string|max:255',
            'kondisi'     => 'required|in:Baik,Rusak',
        ]);

        $inventari->update($request->all());
        return redirect()->route('inventaris.index')->with('success', 'Data aset berhasil diperbarui.');
    }

    public function destroy(InventarisPeralatan $inventari)
    {
        $inventari->delete();
        return redirect()->route('inventaris.index')->with('success', 'Aset berhasil dihapus.');
    }
}
