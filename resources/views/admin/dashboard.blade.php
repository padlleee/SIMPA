@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan statistik dan tren keuangan panti')

@section('content')

<!-- Stat Cards Row -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Anak -->
    <div class="bg-white rounded-lg p-6 border border-slate-200 shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <div class="text-slate-500 text-sm font-medium">Total Anak Asuh</div>
            <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            </div>
        </div>
        <div>
            <div class="text-3xl font-bold text-slate-800">{{ $totalAnak }}</div>
            <div class="flex gap-2 mt-2 text-xs">
                <span class="text-emerald-600 font-medium bg-emerald-50 px-2 py-0.5 rounded">{{ $anakAktif }} Aktif</span>
                <span class="text-slate-500 bg-slate-100 px-2 py-0.5 rounded">{{ $anakAlumni }} Alumni</span>
            </div>
        </div>
    </div>

    <!-- Total Donasi -->
    <div class="bg-white rounded-lg p-6 border border-slate-200 shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <div class="text-slate-500 text-sm font-medium">Total Donasi</div>
            <div class="w-10 h-10 bg-emerald-50 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
        <div>
            <div class="text-3xl font-bold text-slate-800" title="Rp {{ number_format($totalDonasi, 0, ',', '.') }}">Rp {{ $totalDonasiAbbr }}</div>
            <div class="text-emerald-600 text-xs font-medium mt-2 flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Terverifikasi
            </div>
        </div>
    </div>

    <!-- Total Pengeluaran -->
    <div class="bg-white rounded-lg p-6 border border-slate-200 shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <div class="text-slate-500 text-sm font-medium">Total Pengeluaran</div>
            <div class="w-10 h-10 bg-red-50 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path></svg>
            </div>
        </div>
        <div>
            <div class="text-3xl font-bold text-slate-800" title="Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}">Rp {{ $totalPengeluaranAbbr }}</div>
            <div class="text-slate-400 text-xs mt-2">Seluruh pengeluaran tercatat</div>
        </div>
    </div>

    <!-- Saldo -->
    <div class="bg-slate-800 rounded-lg p-6 shadow-md flex flex-col justify-between hover:shadow-lg transition-shadow relative overflow-hidden">
        <div class="absolute top-0 right-0 -mr-4 -mt-4 w-24 h-24 rounded-full bg-white opacity-5"></div>
        <div class="absolute bottom-0 right-10 w-16 h-16 rounded-full bg-white opacity-5"></div>
        
        <div class="flex items-center justify-between mb-4 relative z-10">
            <div class="text-slate-300 text-sm font-medium">Estimasi Saldo</div>
            <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
            </div>
        </div>
        <div class="relative z-10">
            <div class="text-3xl font-bold text-white" title="Rp {{ number_format($saldo, 0, ',', '.') }}">Rp {{ $saldoAbbr }}</div>
            <div class="text-slate-400 text-xs mt-2">Dana tersedia</div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="grid lg:grid-cols-3 gap-6 mb-8">
    <!-- Combined Trend Chart (2/3 width) -->
    <div class="lg:col-span-2 bg-white rounded-lg border border-slate-200 shadow-sm p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="font-bold text-slate-800 text-lg">Tren Keuangan</h3>
                <p class="text-slate-500 text-sm mt-1">Donasi & pengeluaran 6 bulan terakhir</p>
            </div>
            <div class="flex items-center gap-4 text-sm font-medium">
                <span class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-slate-800 inline-block"></span>Donasi</span>
                <span class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-slate-300 inline-block"></span>Pengeluaran</span>
            </div>
        </div>
        <div class="relative w-full h-64">
            <canvas id="trendChart"></canvas>
        </div>
    </div>

    <!-- Donut Chart: Keseimbangan (1/3 width) -->
    <div class="bg-white rounded-lg border border-slate-200 shadow-sm p-6 flex flex-col">
        <div class="mb-6">
            <h3 class="font-bold text-slate-800 text-lg">Keseimbangan</h3>
            <p class="text-slate-500 text-sm mt-1">Komposisi rasio keuangan</p>
        </div>
        <div class="flex-1 flex items-center justify-center">
            <div class="relative w-48 h-48">
                <canvas id="donutChart"></canvas>
                <div class="absolute inset-0 flex flex-col items-center justify-center text-center pointer-events-none">
                    @php
                        $total = $totalDonasi + $totalPengeluaran;
                        $pctDonasi = $total > 0 ? round($totalDonasi / $total * 100) : 0;
                    @endphp
                    <div class="text-3xl font-bold text-slate-800">{{ $pctDonasi }}%</div>
                    <div class="text-sm text-slate-500 font-medium">Donasi</div>
                </div>
            </div>
        </div>
        <div class="mt-6 space-y-3">
            <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                <span class="flex items-center gap-3 text-sm font-medium text-slate-700">
                    <span class="w-3 h-3 rounded-full bg-slate-800 inline-block"></span>Donasi
                </span>
                <span class="font-bold text-slate-800">Rp {{ $totalDonasiAbbr }}</span>
            </div>
            <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                <span class="flex items-center gap-3 text-sm font-medium text-slate-700">
                    <span class="w-3 h-3 rounded-full bg-slate-300 inline-block"></span>Pengeluaran
                </span>
                <span class="font-bold text-slate-800">Rp {{ $totalPengeluaranAbbr }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Bottom Row: Recent Activity & Quick Actions -->
<div class="grid lg:grid-cols-3 gap-6">
    
    <!-- Recent Transactions Table (2/3 width) -->
    <div class="lg:col-span-2 bg-white rounded-lg border border-slate-200 shadow-sm overflow-hidden flex flex-col">
        <div class="p-6 border-b border-slate-200 flex justify-between items-center">
            <div>
                <h3 class="font-bold text-slate-800 text-lg">Transaksi Donasi Terbaru</h3>
                <p class="text-slate-500 text-sm mt-1">5 donasi terakhir yang masuk</p>
            </div>
            <a href="{{ route('donasi.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700 hover:underline">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                        <th class="p-4 font-semibold">Nama / Donatur</th>
                        <th class="p-4 font-semibold">Tanggal</th>
                        <th class="p-4 font-semibold text-right">Jumlah</th>
                        <th class="p-4 font-semibold text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($recentDonations as $donasi)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="p-4">
                            <div class="font-semibold text-slate-800">
                                {{ $donasi->id_donatur ? ($donasi->user->donatur->nama_donatur ?? $donasi->user->username) : ($donasi->nama_donatur_manual ?? 'Hamba Allah') }}
                            </div>
                            <div class="text-xs text-slate-500">{{ $donasi->id_donatur ? 'Donatur Tetap' : 'Publik' }}</div>
                        </td>
                        <td class="p-4 text-slate-600">
                            {{ \Carbon\Carbon::parse($donasi->tanggal_donasi)->format('d M Y') }}
                        </td>
                        <td class="p-4 font-bold text-slate-800 text-right">
                            @if(str_contains(strtolower($donasi->metode_pembayaran), 'sembako') || str_contains(strtolower($donasi->metode_pembayaran), 'barang') || $donasi->nominal == 0)
                                @php
                                    $catatan = $donasi->catatan_verifikasi ?? '';
                                    $detail  = str_replace('Donasi Sembako: ', '', $catatan);
                                    preg_match('/^(.+?)\s*\((.+?)\)(?:\s*—\s*(.+))?$/', $detail, $m);
                                    $namaBarang = trim($m[1] ?? $detail);
                                    $jumlah     = trim($m[2] ?? '');
                                @endphp
                                <span class="text-sm">{{ $namaBarang ?: 'Barang/Sembako' }}</span>
                                @if($jumlah)
                                <span class="text-xs text-slate-500 block font-normal">{{ $jumlah }}</span>
                                @endif
                            @else
                                Rp {{ number_format($donasi->nominal, 0, ',', '.') }}
                            @endif
                        </td>
                        <td class="p-4 text-center">
                            @if($donasi->status_verifikasi == 'Valid')
                                <span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-xs font-semibold">Valid</span>
                            @elseif($donasi->status_verifikasi == 'Pending')
                                <span class="bg-amber-100 text-amber-700 px-3 py-1 rounded-full text-xs font-semibold">Pending</span>
                            @else
                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">Ditolak</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-8 text-center text-slate-500">
                            <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 12H4M20 12l-6 6M20 12l-6-6"></path></svg>
                            <p>Belum ada transaksi donasi.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Quick Actions (1/3 width) -->
    <div class="bg-white rounded-lg border border-slate-200 shadow-sm p-6">
        <h3 class="font-bold text-slate-800 text-lg mb-1">Akses Cepat</h3>
        <p class="text-slate-500 text-sm mb-6">Jalan pintas ke fitur penting</p>
        
        <div class="space-y-3">
            @if($donasiPending > 0)
            <a href="{{ route('donasi.index', ['status' => 'Pending']) }}" class="flex items-center gap-4 p-4 rounded-lg border border-amber-200 bg-amber-50 hover:bg-amber-100 transition-colors group">
                <div class="w-10 h-10 rounded-full bg-amber-200 text-amber-700 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <h4 class="font-semibold text-amber-800 text-sm">Verifikasi Donasi</h4>
                    <p class="text-xs text-amber-700 mt-0.5">{{ $donasiPending }} donasi butuh verifikasi</p>
                </div>
            </a>
            @endif

            @if($pendingAccountRequests > 0)
            <a href="{{ route('account-request.index', ['status' => 'pending']) }}" class="flex items-center gap-4 p-4 rounded-lg border border-blue-200 bg-blue-50 hover:bg-blue-100 transition-colors group relative overflow-hidden">
                <div class="w-10 h-10 rounded-full bg-blue-200 text-blue-700 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                </div>
                <div>
                    <h4 class="font-semibold text-blue-800 text-sm">Permintaan Akun</h4>
                    <p class="text-xs text-blue-700 mt-0.5">{{ $pendingAccountRequests }} akun menunggu persetujuan</p>
                </div>
                <div class="absolute right-4 top-1/2 -translate-y-1/2 w-2 h-2 rounded-full bg-blue-500 animate-pulse"></div>
            </a>
            @endif

            <a href="{{ route('anak-asuh.create') }}" class="flex items-center gap-4 p-4 rounded-lg border border-slate-200 hover:border-slate-300 hover:bg-slate-50 transition-colors group">
                <div class="w-10 h-10 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center shrink-0 group-hover:bg-slate-800 group-hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                </div>
                <div>
                    <h4 class="font-semibold text-slate-800 text-sm">Tambah Anak Asuh</h4>
                    <p class="text-xs text-slate-500 mt-0.5">Daftarkan anak asuh baru</p>
                </div>
            </a>

            <a href="{{ route('pengeluaran.create') }}" class="flex items-center gap-4 p-4 rounded-lg border border-slate-200 hover:border-slate-300 hover:bg-slate-50 transition-colors group">
                <div class="w-10 h-10 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center shrink-0 group-hover:bg-slate-800 group-hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                </div>
                <div>
                    <h4 class="font-semibold text-slate-800 text-sm">Catat Pengeluaran</h4>
                    <p class="text-xs text-slate-500 mt-0.5">Input data pengeluaran panti</p>
                </div>
            </a>
            
            <a href="{{ route('perpustakaan.index') }}" class="flex items-center gap-4 p-4 rounded-lg border border-slate-200 hover:border-slate-300 hover:bg-slate-50 transition-colors group">
                <div class="w-10 h-10 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center shrink-0 group-hover:bg-slate-800 group-hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <div>
                    <h4 class="font-semibold text-slate-800 text-sm">Kelola Perpustakaan</h4>
                    <p class="text-xs text-slate-500 mt-0.5">Manajemen buku dan peminjaman</p>
                </div>
            </a>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    const labels = @json($bulanLabels);
    const donasiRaw       = @json($donasiChart);
    const pengeluaranRaw  = @json($pengeluaranChart);

    function buildData(raw) {
        return labels.map((label, i) => {
            const offset = 5 - i;
            const d = new Date();
            d.setMonth(d.getMonth() - offset);
            const m = d.getMonth() + 1;
            const y = d.getFullYear();
            const found = raw.find(r => parseInt(r.bulan) === m && parseInt(r.tahun) === y);
            return found ? parseFloat(found.total) : 0;
        });
    }

    const donasiData      = buildData(donasiRaw);
    const pengeluaranData = buildData(pengeluaranRaw);

    // ── Combined Area / Line Chart ──────────────────────────────────────────
    const trendCtx = document.getElementById('trendChart').getContext('2d');

    const gradDonasi = trendCtx.createLinearGradient(0, 0, 0, 300);
    gradDonasi.addColorStop(0,   'rgba(30,41,59,0.15)'); // slate-800
    gradDonasi.addColorStop(1,   'rgba(30,41,59,0)');

    const gradPengeluaran = trendCtx.createLinearGradient(0, 0, 0, 300);
    gradPengeluaran.addColorStop(0,   'rgba(203,213,225,0.3)'); // slate-300
    gradPengeluaran.addColorStop(1,   'rgba(203,213,225,0)');

    new Chart(trendCtx, {
        type: 'line',
        data: {
            labels,
            datasets: [
                {
                    label: 'Donasi',
                    data: donasiData,
                    borderColor: '#1e293b', // slate-800
                    backgroundColor: gradDonasi,
                    borderWidth: 3,
                    pointBackgroundColor: '#1e293b',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    tension: 0.4,
                    fill: true,
                },
                {
                    label: 'Pengeluaran',
                    data: pengeluaranData,
                    borderColor: '#cbd5e1', // slate-300
                    backgroundColor: gradPengeluaran,
                    borderWidth: 3,
                    pointBackgroundColor: '#cbd5e1',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    tension: 0.4,
                    fill: true,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#ffffff',
                    titleColor: '#1e293b',
                    bodyColor: '#475569',
                    borderColor: '#e2e8f0',
                    borderWidth: 1,
                    padding: 12,
                    cornerRadius: 8,
                    titleFont: { size: 14, weight: 'bold' },
                    bodyFont: { size: 13 },
                    callbacks: {
                        label: ctx => ` ${ctx.dataset.label}: Rp ${(ctx.parsed.y/1000000).toFixed(2)} Jt`
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { 
                        color: '#f1f5f9',
                        drawBorder: false,
                    },
                    ticks: {
                        color: '#94a3b8',
                        font: { size: 11 },
                        callback: v => 'Rp ' + (v >= 1000000 ? (v/1000000).toFixed(1)+'Jt' : (v/1000).toFixed(0)+'Rb'),
                        padding: 10
                    },
                    border: { display: false }
                },
                x: {
                    grid: { display: false },
                    ticks: { 
                        color: '#64748b',
                        font: { size: 12, weight: '500' }
                    },
                    border: { display: false }
                }
            }
        }
    });

    // ── Donut Chart ─────────────────────────────────────────────────────────
    const donutCtx = document.getElementById('donutChart').getContext('2d');
    const totalDonasi     = {{ $totalDonasi }};
    const totalPengeluaran= {{ $totalPengeluaran }};

    new Chart(donutCtx, {
        type: 'doughnut',
        data: {
            labels: ['Donasi', 'Pengeluaran'],
            datasets: [{
                data: [totalDonasi || 0, totalPengeluaran || 0],
                backgroundColor: ['#1e293b', '#cbd5e1'], // slate-800, slate-300
                hoverBackgroundColor: ['#0f172a', '#94a3b8'],
                borderWidth: 0,
                borderRadius: 4,
                spacing: 4,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '75%',
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#ffffff',
                    titleColor: '#1e293b',
                    bodyColor: '#475569',
                    borderColor: '#e2e8f0',
                    borderWidth: 1,
                    padding: 10,
                    cornerRadius: 8,
                    callbacks: {
                        label: ctx => ` Rp ${(ctx.parsed/1000000).toFixed(2)} Jt`
                    }
                }
            }
        }
    });
</script>
@endpush
