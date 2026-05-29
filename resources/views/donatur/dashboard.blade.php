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

    <!-- Left Column: Riwayat Donasi (Row Cards) -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex items-center justify-between">
                <h3 class="font-bold text-slate-700">Riwayat Donasi</h3>
                <a href="{{ route('donatur.laporan') }}" class="text-xs font-semibold text-slate-400 hover:text-slate-700 transition-colors flex items-center gap-1">
                    Lihat Laporan Lengkap
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            <div class="p-4 space-y-3" id="donation-list">

                @forelse($donasi as $index => $item)
                <div class="row-card {{ $index >= 5 ? 'hidden donation-extra' : '' }}">
                    {{-- Icon --}}
                    <div class="row-card-icon {{ $item->status_verifikasi === 'Valid' ? 'bg-emerald-50' : ($item->status_verifikasi === 'Tolak' ? 'bg-red-50' : 'bg-amber-50') }}">
                        @if($item->status_verifikasi === 'Valid')
                            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        @elseif($item->status_verifikasi === 'Tolak')
                            <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        @else
                            <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        @endif
                    </div>

                    {{-- Main Info --}}
                    <div class="row-card-main">
                        <div class="row-card-title">
                            {{ $item->metode_pembayaran ?? 'Donasi' }}
                        </div>
                        <div class="row-card-sub">
                            {{ $item->tanggal_donasi?->locale('id')->translatedFormat('j F Y') ?? '-' }}
                            @if($item->catatan_verifikasi)
                                &middot; <span class="italic">{{ Str::limit($item->catatan_verifikasi, 30) }}</span>
                            @endif
                        </div>
                    </div>

                    {{-- Right: Amount + Status + Kwitansi --}}
                    <div class="row-card-right">
                        <div class="row-card-amount">Rp {{ number_format($item->nominal, 0, ',', '.') }}</div>
                        <div class="row-card-status">
                            @if($item->status_verifikasi === 'Valid')
                                <span class="inline-flex items-center gap-1 text-emerald-600 font-semibold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 inline-block"></span> Terverifikasi
                                </span>
                            @elseif($item->status_verifikasi === 'Tolak')
                                <span class="inline-flex items-center gap-1 text-red-500 font-semibold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-400 inline-block"></span> Ditolak
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 text-amber-500 font-semibold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-400 inline-block"></span> Diproses
                                </span>
                            @endif
                        </div>
                        @if($item->status_verifikasi === 'Valid')
                        <div class="mt-1.5">
                            <a href="{{ route('donasi.receipt.download', $item->id_donasi) }}" target="_blank"
                               class="inline-flex items-center gap-1 text-xs font-semibold text-slate-500 hover:text-slate-800 border border-slate-200 hover:border-slate-300 px-2.5 py-1 rounded-lg transition-all">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                Kwitansi
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                @empty
                <div class="py-12 text-center text-slate-400">
                    <div class="text-4xl mb-3">💸</div>
                    <p class="font-medium">Belum ada riwayat donasi.</p>
                    <a href="{{ route('donatur.donasi.create') }}" class="mt-3 inline-block text-sm font-semibold text-slate-700 hover:text-slate-900 underline">Mulai Donasi Pertama Anda</a>
                </div>
                @endforelse

            </div>

            {{-- Show More / Show Less --}}
            @if($donasi->count() > 5)
            <div class="px-4 pb-4 text-center border-t border-slate-100 pt-4">
                <button id="show-more-btn" onclick="toggleMoreDonations()"
                        class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-slate-800 bg-slate-50 hover:bg-slate-100 border border-slate-200 px-5 py-2 rounded-xl transition-all">
                    <svg id="show-more-icon" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                    <span id="show-more-label">Tampilkan {{ $donasi->count() - 5 }} Transaksi Lainnya</span>
                </button>
            </div>
            @endif

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
                <a href="{{ route('blog.index') }}" class="text-xs font-semibold text-slate-400 hover:text-slate-800 transition-colors">Lihat Semua</a>
            </div>
            <div class="p-5 space-y-4">
                @forelse($latestArticles as $article)
                    <a href="{{ route('blog.show', $article->slug) }}" class="group flex gap-4 items-start hover:bg-slate-50 -mx-2 px-2 py-2 rounded-xl transition-colors">
                        @if($article->image)
                            <div class="w-14 h-14 rounded-xl overflow-hidden flex-shrink-0 bg-slate-100 border border-slate-200">
                                <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            </div>
                        @else
                            <div class="w-14 h-14 rounded-xl bg-slate-100 border border-slate-200 flex-shrink-0 flex items-center justify-center text-slate-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                            </div>
                        @endif
                        <div class="min-w-0">
                            <p class="text-xs font-bold text-slate-800 group-hover:text-slate-600 line-clamp-2 leading-snug mb-1 transition-colors">
                                {{ $article->title }}
                            </p>
                            <p class="text-xs text-slate-400">{{ $article->created_at->locale('id')->diffForHumans() }}</p>
                        </div>
                    </a>
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

@push('scripts')
<script>
    let showingMore = false;

    function toggleMoreDonations() {
        showingMore = !showingMore;
        const extras = document.querySelectorAll('.donation-extra');
        const label  = document.getElementById('show-more-label');
        const icon   = document.getElementById('show-more-icon');

        extras.forEach(function(el) {
            el.classList.toggle('hidden', !showingMore);
        });

        if (showingMore) {
            label.textContent = 'Tampilkan Lebih Sedikit';
            icon.style.transform = 'rotate(180deg)';
        } else {
            label.textContent = 'Tampilkan {{ $donasi->count() - 5 }} Transaksi Lainnya';
            icon.style.transform = '';
        }
    }
</script>
@endpush
