@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan statistik dan tren keuangan panti')

@section('content')

<!-- Stat Cards Row 1 -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    <!-- Total Anak -->
    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <div class="w-11 h-11 bg-slate-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
        </div>
        <div class="text-3xl font-bold text-slate-800">{{ $totalAnak }}</div>
        <div class="text-slate-500 text-sm mt-1">Total Anak Asuh</div>
        <div class="flex gap-3 mt-3 text-xs text-slate-400">
            <span class="text-green-600 font-medium">{{ $anakAktif }} Aktif</span>
            <span>·</span>
            <span>{{ $anakAlumni }} Alumni</span>
        </div>
    </div>

    <!-- Total Donasi -->
    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <div class="w-11 h-11 bg-slate-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
            </div>
            @if($donasiPending > 0)
            <span class="bg-amber-100 text-amber-700 text-xs font-semibold px-2.5 py-1 rounded-full">{{ $donasiPending }} Pending</span>
            @endif
        </div>
        <div class="text-3xl font-bold text-slate-800" title="Rp {{ number_format($totalDonasi, 0, ',', '.') }}">Rp {{ $totalDonasiAbbr }}</div>
        <div class="text-slate-500 text-sm mt-1">Total Donasi Terverifikasi</div>
    </div>

    <!-- Total Pengeluaran -->
    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <div class="w-11 h-11 bg-slate-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/></svg>
            </div>
        </div>
        <div class="text-3xl font-bold text-slate-800" title="Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}">Rp {{ $totalPengeluaranAbbr }}</div>
        <div class="text-slate-500 text-sm mt-1">Total Pengeluaran</div>
    </div>

    <!-- Saldo -->
    <div class="bg-slate-800 rounded-2xl p-6 shadow-sm">
        <div class="w-11 h-11 bg-white/10 rounded-xl flex items-center justify-center mb-4">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
        </div>
        <div class="text-3xl font-bold text-white cursor-help" title="Rp {{ number_format($saldo, 0, ',', '.') }}">Rp {{ $saldoAbbr }}</div>
        <div class="text-slate-400 text-sm mt-1">Estimasi Saldo</div>
    </div>
</div>

<!-- Charts -->
<div class="grid lg:grid-cols-2 gap-6 mb-8">
    <!-- Donasi Chart -->
    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="font-bold text-slate-800">Tren Donasi</h3>
                <p class="text-slate-400 text-sm mt-0.5">6 bulan terakhir</p>
            </div>
        </div>
        <canvas id="donasiChart" height="200"></canvas>
    </div>

    <!-- Pengeluaran Chart -->
    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="font-bold text-slate-800">Tren Pengeluaran</h3>
                <p class="text-slate-400 text-sm mt-0.5">6 bulan terakhir</p>
            </div>
        </div>
        <canvas id="pengeluaranChart" height="200"></canvas>
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
    <h3 class="font-bold text-slate-800 mb-5">Akses Cepat</h3>
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        @if($donasiPending > 0)
        <a href="{{ route('donasi.index', ['status' => 'Pending']) }}" class="flex flex-col items-center gap-2 bg-amber-50 border border-amber-200 rounded-xl p-4 hover:bg-amber-100 transition-colors text-center">
            <svg class="w-7 h-7 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span class="text-sm font-medium text-amber-700">{{ $donasiPending }} Donasi Pending</span>
        </a>
        @endif
        @if($pendingAccountRequests > 0)
        <a href="{{ route('account-request.index', ['status' => 'pending']) }}" class="flex flex-col items-center gap-2 bg-blue-50 border border-blue-200 rounded-xl p-4 hover:bg-blue-100 transition-colors text-center relative">
            <div class="relative">
                <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center">{{ $pendingAccountRequests }}</span>
            </div>
            <span class="text-sm font-medium text-blue-700">Permintaan Akun</span>
        </a>
        @endif
        <a href="{{ route('anak-asuh.create') }}" class="flex flex-col items-center gap-2 bg-slate-50 border border-slate-200 rounded-xl p-4 hover:bg-slate-100 transition-colors text-center">
            <svg class="w-7 h-7 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
            <span class="text-sm font-medium text-slate-700">Tambah Anak</span>
        </a>
        <a href="{{ route('pengeluaran.create') }}" class="flex flex-col items-center gap-2 bg-slate-50 border border-slate-200 rounded-xl p-4 hover:bg-slate-100 transition-colors text-center">
            <svg class="w-7 h-7 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            <span class="text-sm font-medium text-slate-700">Catat Pengeluaran</span>
        </a>
        <a href="{{ route('perpustakaan.index') }}" class="flex flex-col items-center gap-2 bg-slate-50 border border-slate-200 rounded-xl p-4 hover:bg-slate-100 transition-colors text-center">
            <svg class="w-7 h-7 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            <span class="text-sm font-medium text-slate-700">Perpustakaan</span>
        </a>
    </div>
</div>

@endsection

@push('scripts')
<script>
    const labels = @json($bulanLabels);
    const namaBulan = ['','Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];

    // Build donasi data array
    const donasiRaw = @json($donasiChart);
    const pengeluaranRaw = @json($pengeluaranChart);

    function buildChartData(raw) {
        return labels.map((label, i) => {
            const month = new Date().getMonth() + 1 - (5 - i);
            const adjusted = month <= 0 ? month + 12 : month;
            const year = month <= 0 ? new Date().getFullYear() - 1 : new Date().getFullYear();
            const found = raw.find(d => parseInt(d.bulan) === adjusted && parseInt(d.tahun) === year);
            return found ? parseFloat(found.total) : 0;
        });
    }

    const chartDefaults = {
        borderWidth: 2,
        borderRadius: 8,
        borderSkipped: false,
    };

    new Chart(document.getElementById('donasiChart'), {
        type: 'bar',
        data: {
            labels,
            datasets: [{
                ...chartDefaults,
                label: 'Donasi (Rp)',
                data: buildChartData(donasiRaw),
                backgroundColor: '#e2e8f0',
                borderColor: '#475569',
                hoverBackgroundColor: '#475569',
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#f1f5f9' },
                    ticks: {
                        callback: v => 'Rp ' + (v/1000000).toFixed(1) + 'Jt',
                        color: '#94a3b8'
                    }
                },
                x: { grid: { display: false }, ticks: { color: '#94a3b8' } }
            }
        }
    });

    new Chart(document.getElementById('pengeluaranChart'), {
        type: 'bar',
        data: {
            labels,
            datasets: [{
                ...chartDefaults,
                label: 'Pengeluaran (Rp)',
                data: buildChartData(pengeluaranRaw),
                backgroundColor: '#e2e8f0',
                borderColor: '#94a3b8',
                hoverBackgroundColor: '#94a3b8',
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#f1f5f9' },
                    ticks: {
                        callback: v => 'Rp ' + (v/1000000).toFixed(1) + 'Jt',
                        color: '#94a3b8'
                    }
                },
                x: { grid: { display: false }, ticks: { color: '#94a3b8' } }
            }
        }
    });
</script>
@endpush
