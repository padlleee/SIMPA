@extends('layouts.app')

@section('title', 'Manajemen Peralatan')
@section('page-title', 'Manajemen Peralatan')
@section('page-subtitle', 'Rekapitulasi aset dan peralatan panti berdasarkan kategori')

@section('content')

<div class="flex flex-col sm:flex-row gap-4 mb-6">
    <form action="{{ route('inventaris.index') }}" method="GET" class="flex flex-wrap gap-3 flex-1">
        <div class="relative flex-1 min-w-[200px] max-w-sm">
            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kategori atau nama peralatan..."
                   class="w-full pl-10 pr-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-slate-800">
        </div>
        <div class="relative min-w-[180px]">
            <select name="ruangan" class="w-full pl-4 pr-10 py-2.5 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-slate-800 appearance-none bg-white">
                <option value="">Semua Ruangan</option>
                @foreach($ruanganList as $r)
                    <option value="{{ $r }}" {{ request('ruangan') == $r ? 'selected' : '' }}>{{ $r }}</option>
                @endforeach
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </div>
        </div>
        <button type="submit" class="bg-slate-800 text-white px-5 py-2.5 rounded-xl text-sm font-medium">Filter</button>
    </form>
    <div class="flex items-center gap-2">
        <button onclick="openImportModal('importInventaris')"
                class="inline-flex items-center gap-2 border border-emerald-600 text-emerald-700 px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-emerald-50 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
            </svg>
            Import Excel
        </button>
        <a href="{{ route('inventaris.create') }}" class="bg-slate-800 text-white px-5 py-2.5 rounded-xl text-sm font-medium hover:bg-slate-700 transition-colors flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Peralatan
        </a>
    </div>
</div>

@if(session('import_errors') && count(session('import_errors')) > 0)
<div class="mb-4 bg-amber-50 border border-amber-200 rounded-xl p-4">
    <p class="text-sm font-semibold text-amber-700 mb-2">⚠ Beberapa baris dilewati:</p>
    <ul class="text-xs text-amber-700 space-y-0.5 list-disc pl-4 max-h-32 overflow-y-auto">
        @foreach(session('import_errors') as $err)
            <li>{{ $err }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-100 bg-slate-50">
                    <th class="text-left px-6 py-4 font-semibold text-slate-600 whitespace-nowrap">Kategori Peralatan</th>
                    <th class="text-center px-4 py-4 font-semibold text-slate-600 whitespace-nowrap">Total Unit</th>
                    <th class="text-center px-4 py-4 font-semibold text-slate-600 whitespace-nowrap">Jumlah Entri</th>
                    <th class="text-left px-4 py-4 font-semibold text-slate-600 whitespace-nowrap">Satuan</th>
                    <th class="text-right px-6 py-4 font-semibold text-slate-600 whitespace-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
            @forelse($inventaris as $item)
            <tr class="hover:bg-slate-50 transition-colors">
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </div>
                        <span class="font-semibold text-slate-800">{{ $item->nama_kategori }}</span>
                    </div>
                </td>
                <td class="px-4 py-4 text-center font-bold text-slate-700 whitespace-nowrap">{{ $item->total_jumlah }}</td>
                <td class="px-4 py-4 text-center text-slate-500 whitespace-nowrap">
                    <span class="bg-slate-100 text-slate-600 text-xs font-semibold px-2.5 py-1 rounded-full">{{ $item->total_entri }} entri</span>
                </td>
                <td class="px-4 py-4 text-slate-600 whitespace-nowrap">{{ $item->satuan }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-right">
                    <a href="{{ route('inventaris.show', ['nama_kategori' => $item->nama_kategori, 'ruangan' => request('ruangan')]) }}"
                       class="inline-flex items-center gap-2 px-4 py-2 bg-slate-800 hover:bg-slate-700 text-white rounded-lg transition-colors text-xs font-semibold">
                        Lihat Detail
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-16 text-center text-slate-400">Belum ada data manajemen peralatan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    </div>
    @if($inventaris->hasPages())
    <div class="px-6 py-4 border-t border-slate-100">
        {{ $inventaris->links() }}
    </div>
    @endif
</div>

@include('components.import-modal', [
    'modalId'       => 'importInventaris',
    'importRoute'   => 'inventaris.import',
    'templateRoute' => 'inventaris.template',
    'title'         => 'Import Data Inventaris Peralatan',
    'columns'       => ['Nama Barang *', 'Nama Kategori *', 'Jumlah', 'Satuan', 'Kondisi (Baik/Rusak Ringan/Rusak Berat)', 'Ruangan', 'Lokasi Detail', 'Keterangan', 'Kode Barang'],
])

@endsection
