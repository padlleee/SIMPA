<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Donasi;
use App\Models\KasMasuk;
use App\Models\Pengeluaran;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $donasiQuery = Donasi::valid()->where('metode_pembayaran', 'not like', '%Sembako%');
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

        // Also include non-donation income (kas_masuk non-donasi) in summary
        $kasMasukQuery = KasMasuk::where('sumber_dana', '!=', 'Donasi');
        if ($request->filled('dari_tanggal')) {
            $kasMasukQuery->whereDate('tanggal', '>=', $request->dari_tanggal);
        }
        if ($request->filled('sampai_tanggal')) {
            $kasMasukQuery->whereDate('tanggal', '<=', $request->sampai_tanggal);
        }
        $totalKasMasukLain = (clone $kasMasukQuery)->sum('jumlah');

        $totalPemasukan  = $totalDonasi + $totalKasMasukLain;
        $saldoBersih     = $totalPemasukan - $totalPengeluaran;

        $kasMasukEntries = $kasMasukQuery->get()->map(function ($item) {
            return [
                'tanggal'     => $item->tanggal,
                'jenis'       => $item->sumber_dana,
                'keterangan'  => $item->keterangan ?? $item->sumber_dana,
                'pemasukan'   => $item->jumlah,
                'pengeluaran' => 0,
            ];
        });

        $merged = $donasiEntries->merge($pengeluaranEntries)->merge($kasMasukEntries)
                                ->sortByDesc('tanggal')->values();

        $page = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 15;
        $paginated = new LengthAwarePaginator(
            $merged->slice(($page - 1) * $perPage, $perPage)->values(),
            $merged->count(),
            $perPage,
            $page,
            [
                'path'  => LengthAwarePaginator::resolveCurrentPath(),
                'query' => $request->query(),
            ]
        );

        return view('laporan.index', compact(
            'paginated', 'totalDonasi', 'totalPengeluaran', 'totalKasMasukLain', 'totalPemasukan', 'saldoBersih'
        ));
    }

    public function print(Request $request)
    {
        $donasiQuery      = Donasi::valid()->where('metode_pembayaran', 'not like', '%Sembako%');
        $pengeluaranQuery = Pengeluaran::query();
        $kasMasukQuery    = KasMasuk::where('sumber_dana', '!=', 'Donasi');

        if ($request->filled('dari_tanggal')) {
            $donasiQuery->whereDate('tanggal_donasi', '>=', $request->dari_tanggal);
            $pengeluaranQuery->whereDate('tanggal_pengeluaran', '>=', $request->dari_tanggal);
            $kasMasukQuery->whereDate('tanggal', '>=', $request->dari_tanggal);
        }

        if ($request->filled('sampai_tanggal')) {
            $donasiQuery->whereDate('tanggal_donasi', '<=', $request->sampai_tanggal);
            $pengeluaranQuery->whereDate('tanggal_pengeluaran', '<=', $request->sampai_tanggal);
            $kasMasukQuery->whereDate('tanggal', '<=', $request->sampai_tanggal);
        }

        $totalDonasi      = (clone $donasiQuery)->sum('nominal');
        $totalPengeluaran = (clone $pengeluaranQuery)->sum('nominal');
        $totalKasMasukLain= (clone $kasMasukQuery)->sum('jumlah');
        $totalPemasukan   = $totalDonasi + $totalKasMasukLain;
        $saldoBersih      = $totalPemasukan - $totalPengeluaran;

        $donasiEntries = $donasiQuery->get()->map(function ($item) {
            return [
                'tanggal'     => $item->tanggal_donasi,
                'keterangan'  => 'Pemasukan donasi dari ' . $item->nama_donatur_display,
                'pemasukan'   => $item->nominal,
                'pengeluaran' => 0,
            ];
        });

        $pengeluaranEntries = $pengeluaranQuery->get()->map(function ($item) {
            $ket = $item->keterangan ? $item->keterangan : $item->kategori_biaya;
            return [
                'tanggal'     => $item->tanggal_pengeluaran,
                'keterangan'  => 'Pengeluaran untuk ' . $ket,
                'pemasukan'   => 0,
                'pengeluaran' => $item->nominal,
            ];
        });

        $kasMasukEntries = $kasMasukQuery->get()->map(function ($item) {
            return [
                'tanggal'     => $item->tanggal,
                'keterangan'  => '[' . $item->sumber_dana . '] ' . ($item->keterangan ?? '-'),
                'pemasukan'   => $item->jumlah,
                'pengeluaran' => 0,
            ];
        });

        $transaksi = $donasiEntries->merge($pengeluaranEntries)->merge($kasMasukEntries)
                                   ->sortBy('tanggal')->values();

        return view('laporan.print', compact(
            'transaksi', 'totalDonasi', 'totalPengeluaran', 'totalKasMasukLain', 'totalPemasukan', 'saldoBersih'
        ));
    }

    // ─────────────────────────────────────────────────────────────────────
    //  STANDALONE NON-DONATION REVENUE INPUT
    // ─────────────────────────────────────────────────────────────────────

    /**
     * Show form to manually input non-donation income entries
     * (e.g. product sales, grants, subsidies).
     */
    public function createKasMasuk()
    {
        if (!in_array(Auth::user()->role, ['Admin', 'Ketua', 'Bendahara'])) {
            abort(403);
        }

        return view('laporan.kas-masuk-create', [
            'sumberDanaList' => KasMasuk::SUMBER_DANA,
        ]);
    }

    /**
     * Store a non-donation revenue entry into the kas_masuk ledger.
     *
     * Validates that the selected sumber_dana is not 'Donasi'
     * (donations are recorded automatically via DonasiController).
     * Wrapped in a DB transaction for safety.
     */
    public function storeKasMasuk(Request $request)
    {
        if (!in_array(Auth::user()->role, ['Admin', 'Ketua', 'Bendahara'])) {
            abort(403);
        }

        $request->validate([
            'sumber_dana' => ['required', 'string', 'in:' . implode(',', array_filter(KasMasuk::SUMBER_DANA, fn($s) => $s !== 'Donasi'))],
            'tanggal'     => 'required|date',
            'jumlah'      => 'required|numeric|min:1',
            'keterangan'  => 'required|string|max:500',
        ], [
            'sumber_dana.in'       => 'Sumber dana tidak valid. Donasi dicatat melalui form donasi.',
            'jumlah.min'           => 'Jumlah pemasukan minimal Rp 1.',
            'keterangan.required'  => 'Keterangan wajib diisi untuk entri kas masuk.',
        ]);

        DB::beginTransaction();
        try {
            KasMasuk::create([
                'sumber_dana'  => $request->sumber_dana,
                'tanggal'      => $request->tanggal,
                'jumlah'       => (int) $request->jumlah,
                'keterangan'   => $request->keterangan,
                'dicatat_oleh' => Auth::id(),
            ]);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('storeKasMasuk failed: ' . $e->getMessage());
            return redirect()->back()->withInput()
                             ->with('error', 'Gagal menyimpan entri kas masuk. Silakan coba lagi.');
        }

        return redirect()->route('laporan.index')
                         ->with('success', 'Pemasukan dari "' . $request->sumber_dana . '" berhasil dicatat ke dalam buku kas.');
    }

    /**
     * Destroy a non-donation kas masuk entry.
     * Donasi-linked entries cannot be deleted here.
     */
    public function destroyKasMasuk(KasMasuk $kasMasuk)
    {
        if (!in_array(Auth::user()->role, ['Admin', 'Ketua', 'Bendahara'])) {
            abort(403);
        }

        if ($kasMasuk->sumber_dana === 'Donasi') {
            return back()->with('error', 'Entri yang berasal dari Donasi tidak dapat dihapus di sini.');
        }

        $kasMasuk->delete();

        return back()->with('success', 'Entri kas masuk berhasil dihapus.');
    }
}
