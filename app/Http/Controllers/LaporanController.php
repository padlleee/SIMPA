<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Donasi;
use App\Models\Pengeluaran;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $donasiQuery = Donasi::valid();
        $pengeluaranQuery = Pengeluaran::query();

        if ($request->filled('dari_tanggal')) {
            $donasiQuery->whereDate('tanggal_donasi', '>=', $request->dari_tanggal);
            $pengeluaranQuery->whereDate('tanggal_pengeluaran', '>=', $request->dari_tanggal);
        }

        if ($request->filled('sampai_tanggal')) {
            $donasiQuery->whereDate('tanggal_donasi', '<=', $request->sampai_tanggal);
            $pengeluaranQuery->whereDate('tanggal_pengeluaran', '<=', $request->sampai_tanggal);
        }

        $totalDonasi = (clone $donasiQuery)->sum('nominal');
        $totalPengeluaran = (clone $pengeluaranQuery)->sum('nominal');
        $saldoBersih = $totalDonasi - $totalPengeluaran;

        $donasiEntries = $donasiQuery->get()->map(function ($item) {
            return [
                'tanggal' => $item->tanggal_donasi,
                'jenis' => 'Donasi',
                'keterangan' => $item->nama_donatur_display,
                'pemasukan' => $item->nominal,
                'pengeluaran' => 0,
            ];
        });

        $pengeluaranEntries = $pengeluaranQuery->get()->map(function ($item) {
            return [
                'tanggal' => $item->tanggal_pengeluaran,
                'jenis' => 'Pengeluaran',
                'keterangan' => trim($item->kategori_biaya . ' - ' . $item->keterangan),
                'pemasukan' => 0,
                'pengeluaran' => $item->nominal,
            ];
        });

        $merged = $donasiEntries->merge($pengeluaranEntries)->sortByDesc('tanggal')->values();

        $page = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 15;
        $paginated = new LengthAwarePaginator(
            $merged->slice(($page - 1) * $perPage, $perPage)->values(),
            $merged->count(),
            $perPage,
            $page,
            [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
                'query' => $request->query(),
            ]
        );

        return view('laporan.index', compact('paginated', 'totalDonasi', 'totalPengeluaran', 'saldoBersih'));
    }
}
