@extends('layouts.app')

@section('title', 'Dashboard Donatur')
@section('page-title', 'Dashboard Donatur')
@section('page-subtitle', 'Riwayat donasi dan informasi terbaru dari yayasan')

@section('content')

<!-- Welcome Banner -->
<div class="bg-slate-800 rounded-2xl p-8 mb-6 text-white shadow-sm">
    <p class="text-slate-400 text-sm mb-1">Selamat datang kembali,</p>
    <h2 class="text-2xl font-bold">{{ $donatur?->nama_donatur ?? $user->username }}</h2>
    <div class="mt-6 flex flex-wrap items-center gap-4">
        <div class="bg-white/10 rounded-xl px-6 py-4">
            <div class="text-2xl font-bold">Rp {{ number_format($totalDonasi, 0, ',', '.') }}</div>
            <div class="text-slate-400 text-sm mt-0.5">Total Donasi Terverifikasi</div>
        </div>
        <div class="bg-white/10 rounded-xl px-6 py-4">
            <div class="text-2xl font-bold">{{ $donasi->total() }}</div>
            <div class="text-slate-400 text-sm mt-0.5">Total Transaksi</div>
        </div>
        <a href="{{ route('donatur.donasi.create') }}"
           class="ml-auto inline-flex items-center gap-2 bg-white text-slate-800 px-6 py-3 rounded-xl font-bold hover:bg-slate-100 transition-colors text-sm shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Donasi Sekarang
        </a>
    </div>
</div>

<!-- Main Layout Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <!-- Left Column: Riwayat Donasi -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex items-center justify-between">
                <h3 class="font-bold text-slate-700">Riwayat Donasi Terbaru</h3>
                <a href="{{ route('donatur.laporan') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-800 transition-colors">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm min-w-[600px]">
                    <thead>
                        <tr class="border-b border-slate-100">
                            <th class="text-left px-6 py-3 font-semibold text-slate-500">Tanggal</th>
                            <th class="text-left px-4 py-3 font-semibold text-slate-500">Nominal</th>
                            <th class="text-left px-4 py-3 font-semibold text-slate-500">Metode</th>
                            <th class="text-left px-4 py-3 font-semibold text-slate-500">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($donasi as $item)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 text-slate-600">{{ $item->tanggal_donasi?->locale('id')->translatedFormat('j M Y') ?? '-' }}</td>
                            <td class="px-4 py-4 font-bold text-slate-800">Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                            <td class="px-4 py-4">
                                <span class="inline-block px-2.5 py-1 bg-slate-100 text-slate-600 rounded-full text-xs font-medium">
                                    {{ $item->metode_pembayaran ?? '-' }}
                                </span>
                            </td>
                            <td class="px-4 py-4">
                                @if($item->status_verifikasi === 'Valid')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700 mb-2">✓ Terverifikasi</span>
                                    
                                    <a href="{{ route('donasi.receipt.download', $item->id_donasi) }}" target="_blank" class="flex items-center gap-1.5 bg-white border border-slate-200 hover:border-slate-300 hover:bg-slate-50 text-slate-700 px-3 py-1.5 rounded-lg text-xs font-semibold transition-all shadow-sm w-max">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                        Kwitansi
                                    </a>

                                    @if($item->catatan_verifikasi)
                                        <div class="mt-2 text-xs text-slate-600 bg-slate-50 p-2 rounded border border-slate-200">
                                            <span class="font-semibold block mb-0.5">Catatan Admin:</span>
                                            {{ $item->catatan_verifikasi }}
                                        </div>
                                    @endif
                                @elseif($item->status_verifikasi === 'Tolak')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">✗ Ditolak</span>
                                    @if($item->catatan_verifikasi)
                                        <div class="mt-2 text-xs text-red-600 bg-red-50 p-2 rounded border border-red-100">
                                            <span class="font-semibold block mb-0.5">Alasan:</span>
                                            {{ $item->catatan_verifikasi }}
                                        </div>
                                    @endif
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">⏳ Diproses</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-slate-400">
                                <p>Belum ada riwayat donasi.</p>
                                <a href="{{ route('donatur.donasi.create') }}" class="mt-2 inline-block text-slate-700 font-semibold text-sm">Mulai Donasi Pertama Anda &rarr;</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if(method_exists($donasi, 'hasPages') && $donasi->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">{{ $donasi->links() }}</div>
            @endif
        </div>
    </div>

    <!-- Right Column: Laporan & Artikel -->
    <div class="space-y-6">
        
        <!-- Laporan Transparansi Dana -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden p-6 relative">
            <div class="absolute top-0 left-0 w-full h-1 bg-slate-800"></div>
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6m4 6V7m4 10v-4M5 21h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800">Transparansi Dana</h3>
                    <p class="text-xs text-slate-500">Laporan Penggunaan Dana Yayasan</p>
                </div>
            </div>
            <p class="text-sm text-slate-600 mb-5 leading-relaxed">
                Sebagai wujud transparansi, kami mempublikasikan laporan tahunan yang dapat Anda unduh.
            </p>
            <button onclick="alert('File Laporan Tahunan saat ini sedang dalam penyusunan dan akan segera tersedia untuk diunduh.')" 
                    class="w-full flex items-center justify-center gap-2 bg-slate-50 border border-slate-200 text-slate-700 hover:bg-slate-100 hover:border-slate-300 font-semibold text-sm px-4 py-2.5 rounded-xl transition-colors">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Unduh Laporan 2026 (PDF)
            </button>
        </div>

        <!-- Perkembangan Terbaru -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex items-center justify-between">
                <h3 class="font-bold text-slate-700">Berita & Kegiatan</h3>
                <a href="{{ route('blog.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 transition-colors">Lihat Semua</a>
            </div>
            <div class="p-6 space-y-5">
                @forelse($latestArticles as $article)
                    <div class="group flex gap-4 items-start">
                        @if($article->image)
                            <div class="w-16 h-16 rounded-xl overflow-hidden flex-shrink-0 bg-slate-100 border border-slate-200">
                                <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            </div>
                        @else
                            <div class="w-16 h-16 rounded-xl bg-slate-100 border border-slate-200 flex-shrink-0 flex items-center justify-center text-slate-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                            </div>
                        @endif
                        <div>
                            <a href="{{ route('blog.show', $article->slug) }}" class="text-sm font-bold text-slate-800 hover:text-slate-600 line-clamp-2 leading-snug mb-1 transition-colors">
                                {{ $article->title }}
                            </a>
                            <p class="text-xs text-slate-400">{{ $article->created_at->locale('id')->diffForHumans() }}</p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4 text-slate-400 text-sm">
                        Belum ada pembaruan artikel.
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>

@endsection
