<?php

namespace App\Http\Controllers;

use App\Models\RiwayatStok;
use App\Models\StokPanti;
use Illuminate\Http\Request;

class RiwayatStokController extends Controller
{
    public function index(Request $request)
    {
        $query = RiwayatStok::with('admin')->latest('created_at');

        if ($request->filled('search')) {
            $query->where('nama_barang', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }
        if ($request->filled('kategori')) {
            $query->where('kategori_barang', $request->kategori);
        }
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('created_at', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('created_at', '<=', $request->tanggal_sampai);
        }

        $riwayat = $query->paginate(20)->withQueryString();

        return view('stok.riwayat', compact('riwayat'));
    }
}
