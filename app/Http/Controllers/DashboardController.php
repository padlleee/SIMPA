<?php

namespace App\Http\Controllers;

use App\Models\AnakAsuh;
use App\Models\Donasi;
use App\Models\Pengeluaran;
use App\Models\AccountRequest;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalAnak        = AnakAsuh::count();
        $anakAktif        = AnakAsuh::aktif()->count();
        $anakAlumni       = AnakAsuh::alumni()->count();

        // Use real column names from actual schema
        $totalDonasi      = Donasi::valid()->sum('nominal');
        $donasiPending    = Donasi::pending()->count();
        $totalPengeluaran = Pengeluaran::sum('nominal');
        $saldo            = $totalDonasi - $totalPengeluaran;

        // Chart: Donasi per bulan (last 6 months) - tanggal_donasi is TIMESTAMP
        $donasiChart = Donasi::valid()
            ->selectRaw('MONTH(tanggal_donasi) as bulan, YEAR(tanggal_donasi) as tahun, SUM(nominal) as total')
            ->where('tanggal_donasi', '>=', now()->subMonths(6))
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun')
            ->orderBy('bulan')
            ->get();

        // Chart: Pengeluaran per bulan - tanggal_pengeluaran is DATE
        $pengeluaranChart = Pengeluaran::selectRaw('MONTH(tanggal_pengeluaran) as bulan, YEAR(tanggal_pengeluaran) as tahun, SUM(nominal) as total')
            ->where('tanggal_pengeluaran', '>=', now()->subMonths(6))
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun')
            ->orderBy('bulan')
            ->get();

        $bulanLabels = [];
        $namaBulan = ['','Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        for ($i = 5; $i >= 0; $i--) {
            $bulanLabels[] = $namaBulan[now()->subMonths($i)->month] . ' ' . now()->subMonths($i)->year;
        }

        $pendingAccountRequests = AccountRequest::where('status', 'pending')->count();

        $recentDonations = Donasi::with('user.donatur')
            ->orderBy('tanggal_donasi', 'desc')
            ->take(5)
            ->get();

        $totalDonasiAbbr = $this->formatAbbreviated($totalDonasi);
        $saldoAbbr       = $this->formatAbbreviated($saldo);
        $totalPengeluaranAbbr = $this->formatAbbreviated($totalPengeluaran);

        return view('admin.dashboard', compact(
            'totalAnak', 'anakAktif', 'anakAlumni',
            'totalDonasi', 'donasiPending', 'totalPengeluaran', 'saldo',
            'donasiChart', 'pengeluaranChart', 'bulanLabels',
            'pendingAccountRequests', 'recentDonations', 'totalDonasiAbbr', 'saldoAbbr', 'totalPengeluaranAbbr'
        ));
    }

    /**
     * Format number to abbreviated string (Rb, Jt, M)
     */
    private function formatAbbreviated($value)
    {
        if ($value >= 1000000000) {
            $formatted = round($value / 1000000000, 2);
            return rtrim(rtrim(number_format($formatted, 2, ',', '.'), '0'), ',') . ' M';
        } elseif ($value >= 1000000) {
            $formatted = round($value / 1000000, 2);
            return rtrim(rtrim(number_format($formatted, 2, ',', '.'), '0'), ',') . ' Jt';
        } elseif ($value >= 1000) {
            $formatted = round($value / 1000, 2);
            return rtrim(rtrim(number_format($formatted, 2, ',', '.'), '0'), ',') . ' Rb';
        }

        return number_format($value, 0, ',', '.');
    }
}
