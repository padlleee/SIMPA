@extends('layouts.app')

@section('title', 'Laporan Donasi Saya')
@section('page-title', 'Laporan Donasi Saya')
@section('page-subtitle', 'Ringkasan dan riwayat seluruh donasi yang telah Anda lakukan')

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

    /* Pastikan warna tercetak */
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
    <h1 class="text-xl font-bold text-slate-800">Laporan Donasi – {{ auth()->user()->donatur?->nama_donatur ?? auth()->user()->username }}</h1>
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

{{-- Filter --}}
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 mb-6 no-print">
    <form method="GET" action="{{ route('donatur.laporan') }}" class="grid gap-4 xl:grid-cols-[1fr_auto] items-end">
        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase mb-1">Dari Tanggal</label>
                <input type="date" name="dari_tanggal" value="{{ request('dari_tanggal') }}"
                       class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-slate-400">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase mb-1">Sampai Tanggal</label>
                <input type="date" name="sampai_tanggal" value="{{ request('sampai_tanggal') }}"
                       class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-slate-400">
            </div>
        </div>
        <div class="flex gap-2">
            <button type="submit"
                    class="px-5 py-2 bg-slate-800 text-white rounded-lg text-sm font-semibold hover:bg-slate-700 transition">
                Filter
            </button>
            <a href="{{ route('donatur.laporan') }}"
               class="px-5 py-2 bg-slate-100 text-slate-700 rounded-lg text-sm font-semibold hover:bg-slate-200 transition">
                Reset
            </a>
        </div>
    </form>
</div>

{{-- Summary Cards --}}
<div class="grid gap-4 grid-cols-1 sm:grid-cols-3 mb-6">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex flex-col justify-between min-h-[130px]">
        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Total Donasi Terverifikasi</p>
        <p class="text-2xl font-bold text-emerald-600">Rp {{ number_format($totalDonasi, 0, ',', '.') }}</p>
        <p class="text-xs text-slate-400 mt-2">Hanya donasi berstatus Valid</p>
    </div>
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex flex-col justify-between min-h-[130px]">
        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Total Transaksi</p>
        <p class="text-2xl font-bold text-slate-800">{{ $totalTransaksi }}</p>
        <p class="text-xs text-slate-400 mt-2">Semua status termasuk</p>
    </div>
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex flex-col justify-between min-h-[130px]">
        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Terverifikasi</p>
        <p class="text-2xl font-bold text-slate-800">{{ $totalTerverifikasi }}</p>
        <p class="text-xs text-slate-400 mt-2">Donasi sudah dikonfirmasi admin</p>
    </div>
</div>

{{-- Transaction Table --}}
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="bg-slate-50 border-b border-slate-200 px-5 py-4 flex items-center justify-between">
        <h2 class="text-sm font-semibold uppercase text-slate-500">Riwayat Donasi</h2>
        {{-- Tombol Print --}}
        <button onclick="window.print()"
                class="no-print inline-flex items-center gap-2 px-4 py-2 bg-slate-800 text-white rounded-lg text-sm font-semibold hover:bg-slate-700 active:scale-95 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
            Cetak / Print
        </button>
    </div>

    @if($paginated->count())
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Nominal</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Metode</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                    <th class="px-5 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider no-print">Kwitansi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($paginated as $item)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-5 py-4 text-slate-500 text-xs whitespace-nowrap">
                        {{ $item->tanggal_donasi?->locale('id')->translatedFormat('j F Y') ?? '-' }}
                    </td>
                    <td class="px-5 py-4 font-bold text-slate-800 whitespace-nowrap">
                        Rp {{ number_format($item->nominal, 0, ',', '.') }}
                    </td>
                    <td class="px-5 py-4">
                        <span class="inline-block px-2.5 py-1 bg-slate-100 text-slate-600 rounded-full text-xs font-medium">
                            {{ $item->metode_pembayaran ?? '-' }}
                        </span>
                    </td>
                    <td class="px-5 py-4">
                        @if($item->status_verifikasi === 'Valid')
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                 Terverifikasi
                            </span>
                        @elseif($item->status_verifikasi === 'Tolak')
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                 Ditolak
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">
                                ⏳ Diproses
                            </span>
                        @endif
                    </td>
                    <td class="px-5 py-4 text-center no-print">
                        @if($item->status_verifikasi === 'Valid')
                            <a href="{{ route('donasi.receipt.download', $item->id_donasi) }}" target="_blank"
                               class="inline-flex items-center gap-1.5 bg-white border border-slate-200 hover:border-blue-300 hover:bg-blue-50 text-blue-600 px-3 py-1.5 rounded-lg text-xs font-semibold transition-all shadow-sm">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                                Unduh
                            </a>
                        @else
                            <span class="text-slate-300 text-xs">—</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="border-t-2 border-slate-300 bg-slate-50">
                <tr>
                    <td class="px-5 py-3 text-xs font-bold text-slate-600 uppercase">Total Terverifikasi</td>
                    <td class="px-5 py-3 font-bold text-emerald-700">Rp {{ number_format($totalDonasi, 0, ',', '.') }}</td>
                    <td colspan="3" class="px-5 py-3 text-xs text-slate-400">{{ $totalTerverifikasi }} dari {{ $totalTransaksi }} transaksi terverifikasi</td>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="px-5 py-4 border-t border-slate-100 no-print">
        {{ $paginated->links() }}
    </div>
    @else
    <div class="py-16 text-center text-slate-400">
        <div class="text-5xl mb-4">📭</div>
        <p class="font-medium text-slate-500">Tidak ada donasi untuk rentang tanggal ini</p>
        <a href="{{ route('donatur.laporan') }}" class="mt-2 inline-block text-slate-600 underline text-sm">Tampilkan semua</a>
    </div>
    @endif
</div>

@endsection
