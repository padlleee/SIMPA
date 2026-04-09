@extends('layouts.app')

@section('title', 'Stok Gudang')
@section('page-title', 'Gudang & Stok')
@section('page-subtitle', 'Manajemen persediaan sembako dan kebutuhan pokok')

@section('content')

<div class="flex flex-col sm:flex-row gap-4 mb-6">
    <form action="{{ route('stok.index') }}" method="GET" class="flex gap-3 flex-1">
        <div class="relative flex-1 max-w-sm">
            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama barang..."
                   class="w-full pl-10 pr-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-slate-800">
        </div>
        <button type="submit" class="bg-slate-800 text-white px-5 py-2.5 rounded-xl text-sm font-medium">Cari</button>
    </form>
    <a href="{{ route('stok.create') }}" class="bg-slate-800 text-white px-5 py-2.5 rounded-xl text-sm font-medium hover:bg-slate-700 transition-colors flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Barang
    </a>
</div>

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-slate-100 bg-slate-50">
                <th class="text-left px-6 py-4 font-semibold text-slate-600">Nama Barang</th>
                <th class="text-center px-4 py-4 font-semibold text-slate-600">Stok Awal</th>
                <th class="text-center px-4 py-4 font-semibold text-slate-600">Masuk</th>
                <th class="text-center px-4 py-4 font-semibold text-slate-600">Keluar</th>
                <th class="text-center px-4 py-4 font-semibold text-slate-600">Stok Akhir</th>
                <th class="text-left px-4 py-4 font-semibold text-slate-600">Keterangan</th>
                <th class="text-right px-6 py-4 font-semibold text-slate-600">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($stok as $item)
            <tr class="hover:bg-slate-50 transition-colors">
                <td class="px-6 py-4 font-semibold text-slate-800">{{ $item->nama_barang }}</td>
                <td class="px-4 py-4 text-center text-slate-600">{{ $item->stok_awal }}</td>
                <td class="px-4 py-4 text-center text-green-600 font-medium">+{{ $item->barang_masuk }}</td>
                <td class="px-4 py-4 text-center text-red-500 font-medium">-{{ $item->barang_keluar }}</td>
                <td class="px-4 py-4 text-center">
                    <span class="font-bold text-slate-800 {{ $item->stok_akhir <= 5 ? 'text-red-600' : '' }}">{{ $item->stok_akhir }}</span>
                </td>
                <td class="px-4 py-4 text-slate-500 text-xs truncate max-w-xs">{{ $item->keterangan ?? '-' }}</td>
                <td class="px-6 py-4">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('stok.edit', $item) }}" class="p-2 text-slate-500 hover:text-slate-800 hover:bg-slate-100 rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>
                        <form action="{{ route('stok.destroy', $item) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                    onclick="return confirm('Hapus barang ini?')">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-6 py-16 text-center text-slate-400">Belum ada data stok gudang.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @if($stok->hasPages())
    <div class="px-6 py-4 border-t border-slate-100">{{ $stok->links() }}</div>
    @endif
</div>
@endsection
