<?php

namespace App\Http\Controllers;

use App\Models\InventarisPeralatan;
use App\Imports\InventarisImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InventarisController extends Controller
{
    public function index(Request $request)
    {
        $query = InventarisPeralatan::selectRaw('nama_kategori, sum(jumlah) as total_jumlah, MAX(satuan) as satuan, COUNT(*) as total_entri');

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama_kategori', 'like', '%' . $request->search . '%')
                  ->orWhere('nama_barang', 'like', '%' . $request->search . '%')
                  ->orWhere('kode_barang',  'like', '%' . $request->search . '%');
            });
        }
        
        if ($request->filled('ruangan')) {
            $query->where('ruangan', $request->ruangan);
        }

        $items = $query->groupBy('nama_kategori')
                       ->orderBy('nama_kategori')
                       ->get();
                       
        // Manual pagination
        $currentPage = \Illuminate\Pagination\Paginator::resolveCurrentPage();
        $perPage = 15;
        $currentItems = $items->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $inventaris = new \Illuminate\Pagination\LengthAwarePaginator($currentItems, count($items), $perPage, $currentPage, [
            'path' => \Illuminate\Pagination\Paginator::resolveCurrentPath(),
            'query' => $request->query()
        ]);
        
        $ruanganList = InventarisPeralatan::select('ruangan')->whereNotNull('ruangan')->distinct()->pluck('ruangan');

        return view('inventaris.index', compact('inventaris', 'ruanganList'));
    }

    public function show(Request $request, $nama_kategori)
    {
        $query = InventarisPeralatan::where('nama_kategori', $nama_kategori);
        
        if ($request->filled('ruangan')) {
            $query->where('ruangan', $request->ruangan);
        }

        $items = $query->orderBy('nama_barang')->get();
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
            'nama_kategori'         => 'required|string|max:255',
            'nama_kategori_lainnya' => 'required_if:nama_kategori,Lainnya|nullable|string|max:255',
            'jumlah'                => 'required|integer|min:1',
            'satuan'                => 'required|string|max:50',
            'satuan_lainnya'        => 'required_if:satuan,Lainnya|nullable|string|max:50',
            'kode_barang'           => 'nullable|string|max:100',
            
            // Array Validations
            'nama_barang'           => 'required|array|min:1',
            'nama_barang.*'         => 'required|string|max:255',
            'lokasi'                => 'required|array|min:1',
            'lokasi.*'              => 'required|string|max:255',
            'ruangan'               => 'nullable|array',
            'ruangan.*'             => 'nullable|string',
            'kondisi'               => 'required|array|min:1',
            'kondisi.*'             => 'required|in:Baik,Rusak',
            'gambar'                => 'nullable|array',
            'gambar.*'              => 'nullable|image|max:2048',
            'keterangan'            => 'nullable|array',
            'keterangan.*'          => 'nullable|string',
        ]);

        // Tentukan nama_kategori akhir
        $namaKategori = $request->nama_kategori === 'Lainnya'
            ? $request->nama_kategori_lainnya
            : $request->nama_kategori;
            
        // Tentukan satuan akhir
        $satuan = $request->satuan === 'Lainnya'
            ? $request->satuan_lainnya
            : $request->satuan;

        $jumlahInput = (int) $request->jumlah;
        $kodeBarang = $request->kode_barang ?? 'MT-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        
        $maxCode = InventarisPeralatan::where('kode_barang', $kodeBarang)
                    ->whereNotNull('kode_unik_aset')
                    ->orderBy('kode_unik_aset', 'desc')
                    ->first();
        
        $nextIdx = 1;
        if ($maxCode && preg_match('/-(\d+)$/', $maxCode->kode_unik_aset, $m)) {
            $nextIdx = intval($m[1]) + 1;
        }

        for ($i = 0; $i < $jumlahInput; $i++) {
            $gambarPath = null;
            if ($request->hasFile("gambar.{$i}")) {
                $gambarPath = $request->file("gambar.{$i}")->store('inventaris', 'public');
            }

            InventarisPeralatan::create([
                'kode_barang'   => $kodeBarang,
                'kode_unik_aset'=> $kodeBarang . '-' . str_pad($nextIdx + $i, 3, '0', STR_PAD_LEFT),
                'nama_kategori' => $namaKategori,
                'satuan'        => $satuan,
                'jumlah'        => 1, // Paksa jadi 1 baris = 1 aset
                'nama_barang'   => $request->nama_barang[$i] ?? '-',
                'lokasi'        => $request->lokasi[$i] ?? '-',
                'ruangan'       => $request->ruangan[$i] ?? null,
                'kondisi'       => $request->kondisi[$i] ?? 'Baik',
                'gambar'        => $gambarPath,
                'keterangan'    => $request->keterangan[$i] ?? null,
            ]);
        }
        
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
            'satuan'                => 'required|string|max:50',
            'satuan_lainnya'        => 'required_if:satuan,Lainnya|nullable|string|max:50',
            'kode_barang'           => 'nullable|string|max:100',
            'kode_unik_aset'        => 'nullable|string|max:150',
            'lokasi'                => 'required|string|max:255',
            'ruangan'               => 'nullable|string',
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

        $data = $request->except(['nama_kategori_lainnya', 'satuan_lainnya', 'jumlah']);
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

    // ── IMPORT EXCEL ────────────────────────────────────────────────────

    public function importExcel(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|file|mimes:xlsx,xls,csv|max:5120',
        ], [
            'file_excel.required' => 'Harap pilih file Excel.',
            'file_excel.mimes'    => 'File harus berformat .xlsx, .xls, atau .csv.',
            'file_excel.max'      => 'Ukuran file maksimal 5 MB.',
        ]);

        $path     = $request->file('file_excel')->store('imports/temp', 'local');
        $fullPath = storage_path('app/' . $path);

        $importer = new InventarisImport();
        $importer->import($fullPath);

        Storage::disk('local')->delete($path);

        $message = "Import selesai: {$importer->inserted} data berhasil ditambahkan.";
        if ($importer->skipped > 0) {
            $message .= " {$importer->skipped} baris dilewati.";
        }

        return redirect()->route('inventaris.index')
                         ->with('success', $message)
                         ->with('import_errors', $importer->errors);
    }

    public function downloadTemplate()
    {
        $path = public_path('templates/template_inventaris.xlsx');
        if (!file_exists($path)) {
            \Artisan::call('import:generate-templates');
        }
        return response()->download($path, 'Template_Import_Inventaris.xlsx');
    }
}
