@extends('layouts.app')

@section('title', 'Riwayat Stok')
@section('page-title', 'Riwayat Stok Gudang')
@section('page-subtitle', 'Catatan keluar masuk barang gudang')

@section('content')

{{-- Filter Bar --}}
<form action="{{ route('stok.riwayat') }}" method="GET" class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 mb-6">
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3">
        {{-- Cari Nama Barang --}}
        <div class="relative lg:col-span-2">
            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama barang..."
                   class="w-full pl-10 pr-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-slate-800">
        </div>

        {{-- Filter Jenis --}}
        <select name="jenis" class="border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-slate-800">
            <option value="">Semua Jenis</option>
            <option value="Masuk" {{ request('jenis') == 'Masuk' ? 'selected' : '' }}>📦 Masuk</option>
            <option value="Keluar" {{ request('jenis') == 'Keluar' ? 'selected' : '' }}>📤 Keluar</option>
        </select>

        {{-- Filter Tanggal Dari --}}
        <input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}"
               class="border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-slate-800"
               title="Dari Tanggal">

        {{-- Filter Tanggal Sampai --}}
        <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}"
               class="border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-slate-800"
               title="Sampai Tanggal">
    </div>

    <div class="flex gap-3 mt-3">
        <button type="submit" class="bg-slate-800 text-white px-5 py-2.5 rounded-xl text-sm font-medium hover:bg-slate-700 transition-colors">
            Terapkan Filter
        </button>
        @if(request()->anyFilled(['search','jenis','tanggal_dari','tanggal_sampai']))
        <a href="{{ route('stok.riwayat') }}" class="bg-slate-100 text-slate-600 px-5 py-2.5 rounded-xl text-sm font-medium hover:bg-slate-200 transition-colors flex items-center gap-1.5">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
            Reset
        </a>
        @endif
        <a href="{{ route('stok.index') }}" class="ml-auto text-slate-500 hover:text-slate-700 text-sm flex items-center gap-1.5 font-medium">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Gudang
        </a>
    </div>
</form>

{{-- Ringkasan --}}
<div class="grid grid-cols-3 gap-4 mb-6">
    @php
        $totalMasuk  = $riwayat->getCollection()->where('jenis','Masuk')->sum('jumlah');
        $totalKeluar = $riwayat->getCollection()->where('jenis','Keluar')->sum('jumlah');
    @endphp
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex items-center gap-4">
        <div class="w-10 h-10 bg-slate-100 rounded-xl flex items-center justify-center">
            <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        </div>
        <div>
            <div class="text-2xl font-bold text-slate-800">{{ $riwayat->total() }}</div>
            <div class="text-xs text-slate-500 mt-0.5">Total Transaksi</div>
        </div>
    </div>
    <div class="bg-white rounded-2xl border border-green-100 shadow-sm p-5 flex items-center gap-4">
        <div class="w-10 h-10 bg-green-50 rounded-xl flex items-center justify-center">
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg>
        </div>
        <div>
            <div class="text-2xl font-bold text-green-600">+{{ $totalMasuk }}</div>
            <div class="text-xs text-slate-500 mt-0.5">Total Barang Masuk (halaman ini)</div>
        </div>
    </div>
    <div class="bg-white rounded-2xl border border-red-100 shadow-sm p-5 flex items-center gap-4">
        <div class="w-10 h-10 bg-red-50 rounded-xl flex items-center justify-center">
            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"/></svg>
        </div>
        <div>
            <div class="text-2xl font-bold text-red-500">-{{ $totalKeluar }}</div>
            <div class="text-xs text-slate-500 mt-0.5">Total Barang Keluar (halaman ini)</div>
        </div>
    </div>
</div>

{{-- Tabel Riwayat --}}
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-slate-100 bg-slate-50">
                <th class="text-left px-5 py-4 font-semibold text-slate-600 w-36">Tanggal</th>
                <th class="text-left px-5 py-4 font-semibold text-slate-600">Nama Barang</th>
                <th class="text-center px-4 py-4 font-semibold text-slate-600 w-24">Jenis</th>
                <th class="text-center px-4 py-4 font-semibold text-slate-600 w-20">Jumlah</th>
                <th class="text-center px-4 py-4 font-semibold text-slate-600 w-24">Sebelum</th>
                <th class="text-center px-4 py-4 font-semibold text-slate-600 w-24">Sesudah</th>
                <th class="text-left px-4 py-4 font-semibold text-slate-600">Keterangan</th>
                <th class="text-left px-5 py-4 font-semibold text-slate-600">Dicatat Oleh</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($riwayat as $item)
            <tr class="hover:bg-slate-50 transition-colors">
                <td class="px-5 py-4">
                    <div class="text-slate-800 font-medium">{{ $item->created_at->format('d M Y') }}</div>
                    <div class="text-xs text-slate-400">{{ $item->created_at->format('H:i') }}</div>
                </td>
                <td class="px-5 py-4">
                    <div class="font-semibold text-slate-800">{{ $item->nama_barang }}</div>
                    @if($item->kategori_barang)
                    <div class="text-xs text-slate-400">{{ $item->kategori_barang }}</div>
                    @endif
                </td>
                <td class="px-4 py-4 text-center">
                    @if($item->jenis === 'Masuk')
                        <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 font-semibold text-xs px-2.5 py-1 rounded-full">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg>
                            Masuk
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 bg-red-100 text-red-600 font-semibold text-xs px-2.5 py-1 rounded-full">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 13l-5 5m0 0l-5-5m5 5V6"/></svg>
                            Keluar
                        </span>
                    @endif
                </td>
                <td class="px-4 py-4 text-center font-bold {{ $item->jenis === 'Masuk' ? 'text-green-600' : 'text-red-500' }}">
                    {{ $item->jenis === 'Masuk' ? '+' : '-' }}{{ $item->jumlah }}
                    @if($item->satuan)
                    <span class="text-xs text-slate-400 font-normal ml-0.5">{{ $item->satuan }}</span>
                    @endif
                </td>
                <td class="px-4 py-4 text-center text-slate-500">{{ $item->stok_sebelum }}</td>
                <td class="px-4 py-4 text-center font-semibold text-slate-800">{{ $item->stok_sesudah }}</td>
                <td class="px-4 py-4 text-slate-500 text-xs max-w-xs truncate">{{ $item->keterangan ?? '-' }}</td>
                <td class="px-5 py-4">
                    <div class="flex items-center gap-2">
                        <div class="w-6 h-6 bg-slate-200 rounded-full flex items-center justify-center shrink-0">
                            <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <span class="text-slate-700 font-medium text-xs">{{ $item->admin?->username ?? '—' }}</span>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="px-6 py-16 text-center">
                    <svg class="w-12 h-12 mx-auto text-slate-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    <p class="text-slate-400 font-medium">Belum ada riwayat stok</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @if($riwayat->hasPages())
    <div class="px-6 py-4 border-t border-slate-100">{{ $riwayat->links() }}</div>
    @endif
</div>

@endsection
