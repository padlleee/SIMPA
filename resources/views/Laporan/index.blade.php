@extends('layouts.app')

@section('title', 'Laporan Keuangan')
@section('page-title', 'Laporan Keuangan')
@section('page-subtitle', 'Rekapitulasi donasi dan pengeluaran secara otomatis')

@push('styles')
<style>
@media print {
    /* Sembunyikan elemen UI yang tidak perlu */
    #sidebar,
    nav,
    .topbar-area,
    .no-print,
    .pagination,
    nav[aria-label="Pagination Navigation"] { display: none !important; }

    /* Reset layout agar konten memenuhi halaman */
    body { background: white !important; }
    .flex.h-screen { display: block !important; }
    .ml-64 { margin-left: 0 !important; }
    main { padding: 0 !important; overflow: visible !important; }

    /* Header print */
    .print-header { display: block !important; }

    /* Pastikan semua tabel dan kartu tercetak penuh */
    * { -webkit-print-color-adjust: exact; print-color-adjust: exact; }

    /* Cegah potong di tengah baris tabel */
    tr { page-break-inside: avoid; }
    thead { display: table-header-group; }
}
</style>
@endpush

@section('content')

{{-- Print Header (hanya muncul saat print) --}}
<div class="print-header hidden mb-6 pb-4 border-b-2 border-slate-800">
    <h1 class="text-xl font-bold text-slate-800">Laporan Keuangan – Yayasan Amaliya Subang</h1>
    <p class="text-sm text-slate-500 mt-1">
        Dicetak pada: {{ now()->locale('id')->translatedFormat('j F Y, H:i') }}
        @if(request('dari_tanggal') || request('sampai_tanggal'))
            &nbsp;·&nbsp; Periode:
            {{ request('dari_tanggal') ? \Carbon\Carbon::parse(request('dari_tanggal'))->locale('id')->translatedFormat('j F Y') : '—' }}
            s.d.
            {{ request('sampai_tanggal') ? \Carbon\Carbon::parse(request('sampai_tanggal'))->locale('id')->translatedFormat('j F Y') : 'sekarang' }}
        @endif
    </p>
</div>

{{-- Filter + Tombol Print --}}
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 mb-6 no-print">
    <form method="GET" class="grid gap-4 xl:grid-cols-[1fr_auto] items-end">
        <div class="grid gap-4 lg:grid-cols-3">
            <div class="flex-1 min-w-[140px]">
                <label class="block text-xs font-semibold text-slate-500 uppercase mb-1">Dari Tanggal</label>
                <input type="date" name="dari_tanggal" value="{{ request('dari_tanggal') }}" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm">
            </div>
            <div class="flex-1 min-w-[140px]">
                <label class="block text-xs font-semibold text-slate-500 uppercase mb-1">Sampai Tanggal</label>
                <input type="date" name="sampai_tanggal" value="{{ request('sampai_tanggal') }}" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm">
            </div>
            <div class="flex-1 min-w-[140px]">
                <label class="block text-xs font-semibold text-slate-500 uppercase mb-1">Jenis Laporan</label>
                <div class="px-3 py-2 border border-slate-300 rounded-lg text-sm text-slate-600 bg-slate-50">Donasi terverifikasi dan seluruh pengeluaran</div>
            </div>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="px-5 py-2 bg-slate-800 text-white rounded-lg text-sm hover:bg-slate-700 transition">Filter</button>
            <a href="{{ route('laporan.index') }}" class="px-5 py-2 bg-slate-100 text-slate-700 rounded-lg text-sm hover:bg-slate-200 transition">Reset</a>
        </div>
    </form>
</div>

<div class="grid gap-4 grid-cols-1 lg:grid-cols-3 mb-6">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex flex-col justify-between min-h-[170px]">
        <div>
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Total Donasi</p>
            <p class="text-3xl font-bold text-emerald-600">Rp {{ number_format($totalDonasi, 0, ',', '.') }}</p>
        </div>
        <p class="text-sm text-slate-500 mt-4">Hanya donasi yang sudah terverifikasi</p>
    </div>
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex flex-col justify-between min-h-[170px]">
        <div>
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Total Pengeluaran</p>
            <p class="text-3xl font-bold text-rose-600">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
        </div>
        <p class="text-sm text-slate-500 mt-4">Semua pengeluaran tercatat</p>
    </div>
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex flex-col justify-between min-h-[170px]">
        <div>
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Saldo Bersih</p>
            <p class="text-3xl font-bold {{ $saldoBersih >= 0 ? 'text-slate-800' : 'text-red-600' }}">Rp {{ number_format($saldoBersih, 0, ',', '.') }}</p>
        </div>
        <p class="text-sm text-slate-500 mt-4">Selisih donasi dikurangi pengeluaran</p>
    </div>
</div>

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="bg-slate-50 border-b border-slate-200 px-5 py-4 flex items-center justify-between">
        <h2 class="text-sm font-semibold uppercase text-slate-500">Detail Transaksi</h2>
        {{-- Tombol Print --}}
        <a href="{{ route('laporan.print', request()->query()) }}"
           target="_blank"
           class="no-print inline-flex items-center gap-2 px-4 py-2 bg-slate-800 text-white rounded-lg text-sm font-semibold hover:bg-slate-700 active:scale-95 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
            Cetak / Print
        </a>
    </div>
    @if($paginated->count())
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Keterangan</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Jenis</th>
                        <th class="px-5 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Pemasukan</th>
                        <th class="px-5 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Pengeluaran</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($paginated as $item)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-5 py-4 text-slate-500 text-xs whitespace-nowrap">{{ optional($item['tanggal'])->translatedFormat('j M Y') ?? '-' }}</td>
                            <td class="px-5 py-4 text-slate-700">{{ $item['keterangan'] }}</td>
                            <td class="px-5 py-4 text-slate-500 uppercase tracking-wider">{{ $item['jenis'] }}</td>
                            <td class="px-5 py-4 text-right font-semibold text-slate-800">{{ $item['pemasukan'] ? 'Rp ' . number_format($item['pemasukan'], 0, ',', '.') : '-' }}</td>
                            <td class="px-5 py-4 text-right font-semibold text-slate-800">{{ $item['pengeluaran'] ? 'Rp ' . number_format($item['pengeluaran'], 0, ',', '.') : '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="border-t-2 border-slate-300 bg-slate-50">
                    <tr>
                        <td colspan="3" class="px-5 py-3 text-xs font-bold text-slate-600 uppercase">Total Keseluruhan</td>
                        <td class="px-5 py-3 text-right font-bold text-emerald-700">Rp {{ number_format($totalDonasi, 0, ',', '.') }}</td>
                        <td class="px-5 py-3 text-right font-bold text-rose-700">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="px-5 py-4 border-t border-slate-100 no-print">
            {{ $paginated->links('pagination::tailwind') }}
        </div>
    @else
        <div class="py-16 text-center text-slate-400">
            <div class="text-5xl mb-4">📭</div>
            <p class="font-medium text-slate-500">Tidak ada transaksi untuk rentang tanggal ini</p>
        </div>
    @endif
</div>
@endsection
