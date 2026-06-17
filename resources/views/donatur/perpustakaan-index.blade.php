{{-- ============================================================
     View: resources/views/donatur/perpustakaan-index.blade.php
     Donatur — browse & search book catalogue
     Route: GET /donatur/perpustakaan
     ============================================================ --}}
@extends('layouts.app')

@section('title', 'Perpustakaan')
@section('page-title', 'Perpustakaan')
@section('page-subtitle', 'Jelajahi koleksi buku & ajukan peminjaman')

@section('content')

{{-- Flash --}}
@include('layouts.partials.flash')

{{-- ── Search & Filter Bar ── --}}
<form method="GET" action="{{ route('donatur.perpustakaan.index') }}"
      class="bg-white rounded-2xl border border-slate-200 shadow-sm px-5 py-4 mb-6 flex flex-col sm:flex-row gap-3">
    <div class="relative flex-1">
        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Cari judul, penulis, atau kata kunci..."
               class="w-full pl-10 pr-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-slate-800">
    </div>
    <select name="kategori"
            class="border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-slate-800">
        <option value="">Semua Kategori</option>
        @foreach($kategoriList ?? [] as $k)
            <option value="{{ $k }}" {{ request('kategori') == $k ? 'selected' : '' }}>{{ $k }}</option>
        @endforeach
    </select>
    <select name="status_filter"
            class="border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-slate-800">
        <option value="">Semua Status</option>
        <option value="tersedia" {{ request('status_filter') === 'tersedia' ? 'selected' : '' }}>Tersedia</option>
        <option value="habis"    {{ request('status_filter') === 'habis'    ? 'selected' : '' }}>Habis Dipinjam</option>
    </select>
    <button type="submit"
            class="bg-slate-800 text-white px-6 py-2.5 rounded-xl text-sm font-semibold hover:bg-slate-700 transition-colors flex-shrink-0">
        Cari
    </button>
    @if(request()->anyFilled(['search','kategori','status_filter']))
    <a href="{{ route('donatur.perpustakaan.index') }}"
       class="text-slate-500 hover:text-slate-700 text-sm font-medium px-3 py-2.5 flex-shrink-0 transition-colors">
        Reset
    </a>
    @endif
</form>

{{-- ── Book Grid ── --}}
@if($buku->count())
<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 mb-6">
    @foreach($buku as $b)
    @php $sisa = max(0, $b->jumlah_buku - $b->peminjamanAktif()->count()); @endphp
    <a href="{{ route('donatur.perpustakaan.show', $b) }}"
       class="group bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 overflow-hidden flex flex-col">

        {{-- Cover --}}
        <div class="relative aspect-[2/3] bg-gradient-to-br from-slate-700 to-slate-500 overflow-hidden">
            @if($b->foto_buku && file_exists(public_path('storage/' . $b->foto_buku)))
                <img src="{{ asset('storage/' . $b->foto_buku) }}"
                     alt="{{ $b->judul_buku }}"
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
            @else
                <div class="w-full h-full flex items-center justify-center">
                    <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 17.477 5.754 17 7.5 17s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 17.477 18.247 17 16.5 17c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
            @endif

            {{-- Availability badge --}}
            <div class="absolute top-2 right-2">
                <span class="text-xs font-bold px-2 py-0.5 rounded-full {{ $sisa > 0 ? 'bg-green-500/90 text-white' : 'bg-red-500/90 text-white' }}">
                    {{ $sisa > 0 ? "✓ {$sisa}" : '✗ Habis' }}
                </span>
            </div>
        </div>

        {{-- Info --}}
        <div class="p-3 flex flex-col flex-1">
            <p class="text-xs font-semibold text-slate-400 truncate mb-0.5">{{ $b->penulis ?? '-' }}</p>
            <p class="text-sm font-bold text-slate-800 leading-tight line-clamp-2 flex-1">{{ $b->judul_buku }}</p>
            @if($b->kategori)
            <span class="inline-block text-xs text-slate-500 bg-slate-100 px-2 py-0.5 rounded-full mt-2 self-start">{{ $b->kategori }}</span>
            @endif
        </div>
    </a>
    @endforeach
</div>

{{-- Pagination --}}
{{ $buku->withQueryString()->links() }}

@else
<div class="text-center py-20 bg-white rounded-2xl border border-slate-200">
    <div class="text-5xl mb-4">📚</div>
    <p class="font-semibold text-slate-600">Tidak ada buku yang ditemukan.</p>
    <p class="text-slate-400 text-sm mt-2">Coba ubah filter pencarian Anda.</p>
</div>
@endif

@endsection
