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
        $kategoriList = StokPanti::select('kategori_barang')
            ->whereNotNull('kategori_barang')
            ->where('kategori_barang', '!=', 'Lainnya')
            ->distinct()
            ->pluck('kategori_barang')
            ->toArray();
            
        $defaultKategori = ['Sembako', 'Logistik', 'Aset Tetap'];
        $kategoriList = array_unique(array_merge($defaultKategori, $kategoriList));
        
        return view('stok.create', compact('kategoriList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang'    => 'required|string|max:100|unique:stok_panti,nama_barang',
            'kategori_barang'=> 'nullable|string|max:100',
            'kategori_barang_lainnya' => 'nullable|string|max:100',
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

        $kategori = $request->kategori_barang;
        if ($kategori === 'Lainnya' && $request->filled('kategori_barang_lainnya')) {
            $kategori = $request->kategori_barang_lainnya;
        }

        $stokBaru = StokPanti::create([
            'nama_barang'    => $request->nama_barang,
            'kategori_barang'=> $kategori,
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
                'kategori_barang'=> $kategori,
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
                'kategori_barang'=> $kategori,
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
        $kategoriList = StokPanti::select('kategori_barang')
            ->whereNotNull('kategori_barang')
            ->where('kategori_barang', '!=', 'Lainnya')
            ->distinct()
            ->pluck('kategori_barang')
            ->toArray();
            
        $defaultKategori = ['Sembako', 'Logistik', 'Aset Tetap'];
        $kategoriList = array_unique(array_merge($defaultKategori, $kategoriList));

        // Cek apakah kategori stok saat ini ada di list, jika tidak, masukkan agar tetap bisa dipilih (atau tidak perlu karena sudah diambil di distinct)
        if (!in_array($stok->kategori_barang, $kategoriList) && $stok->kategori_barang != '') {
            $kategoriList[] = $stok->kategori_barang;
        }

        return view('stok.edit', compact('stok', 'kategoriList'));
    }

    public function update(Request $request, StokPanti $stok)
    {
        $request->validate([
            'nama_barang'    => 'required|string|max:100|unique:stok_panti,nama_barang,' . $stok->id_stok . ',id_stok',
            'kategori_barang'=> 'nullable|string|max:100',
            'kategori_barang_lainnya' => 'nullable|string|max:100',
            'satuan'         => 'nullable|string|max:20',
            'keterangan'     => 'nullable|string',
        ]);

        $kategori = $request->kategori_barang;
        if ($kategori === 'Lainnya' && $request->filled('kategori_barang_lainnya')) {
            $kategori = $request->kategori_barang_lainnya;
        }

        $stok->update([
            'nama_barang' => $request->nama_barang,
            'kategori_barang' => $kategori,
            'satuan' => $request->satuan,
            'keterangan' => $request->keterangan
        ]);

        return redirect()->route('stok.index')->with('success', 'Data barang berhasil diperbarui.');
    }

    public function transaksi(StokPanti $stok)
    {
        return view('stok.transaksi', compact('stok'));
    }

    public function storeTransaksi(Request $request, StokPanti $stok)
    {
        $request->validate([
            'barang_masuk'   => 'required|integer|min:0',
            'barang_keluar'  => 'required|integer|min:0',
            'keterangan'     => 'nullable|string',
        ]);

        $stok_awal = $stok->stok_akhir;
        $barang_masuk = $request->barang_masuk;
        $barang_keluar = $request->barang_keluar;
        $stok_akhir = $stok_awal + $barang_masuk - $barang_keluar;

        if ($barang_keluar > ($stok_awal + $barang_masuk)) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['barang_keluar' => 'Barang keluar melebihi stok yang tersedia.']);
        }

        // Perbarui tabel master dengan transaksi terakhir
        $stok->update([
            'stok_awal' => $stok_awal,
            'barang_masuk' => $barang_masuk,
            'barang_keluar' => $barang_keluar,
            'stok_akhir' => $stok_akhir,
        ]);

        // Log riwayat masuk jika ada perubahan masuk
        if ($barang_masuk > 0) {
            RiwayatStok::create([
                'id_stok'       => $stok->id_stok,
                'nama_barang'   => $stok->nama_barang,
                'kategori_barang'=> $stok->kategori_barang,
                'satuan'        => $stok->satuan,
                'jenis'         => 'Masuk',
                'jumlah'        => $barang_masuk,
                'stok_sebelum'  => $stok_awal,
                'stok_sesudah'  => $stok_awal + $barang_masuk,
                'keterangan'    => $request->keterangan,
                'id_admin'      => Auth::user()->id_user,
            ]);
        }

        // Log riwayat keluar jika ada
        if ($barang_keluar > 0) {
            RiwayatStok::create([
                'id_stok'       => $stok->id_stok,
                'nama_barang'   => $stok->nama_barang,
                'kategori_barang'=> $stok->kategori_barang,
                'satuan'        => $stok->satuan,
                'jenis'         => 'Keluar',
                'jumlah'        => $barang_keluar,
                'stok_sebelum'  => $stok_awal + $barang_masuk,
                'stok_sesudah'  => $stok_akhir,
                'keterangan'    => $request->keterangan,
                'id_admin'      => Auth::user()->id_user,
            ]);
        }

        return redirect()->route('stok.index')->with('success', 'Transaksi stok berhasil dicatat.');
    }

    public function destroy(StokPanti $stok)
    {
        $stok->delete();
        return redirect()->route('stok.index')->with('success', 'Barang berhasil dihapus.');
    }
}
