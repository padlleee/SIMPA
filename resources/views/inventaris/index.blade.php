@extends('layouts.app')

@section('title', 'Inventaris Peralatan')
@section('page-title', 'Inventaris Peralatan')
@section('page-subtitle', 'Daftar aset dan peralatan panti')

@section('content')

<div class="flex flex-col sm:flex-row gap-4 mb-6">
    <form action="{{ route('inventaris.index') }}" method="GET" class="flex gap-3 flex-1">
        <div class="relative flex-1 max-w-sm">
            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari barang atau kode..."
                   class="w-full pl-10 pr-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-slate-800">
        </div>
        <select name="kondisi" class="border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-slate-800">
            <option value="">Semua Kondisi</option>
            <option value="Baik" {{ request('kondisi') == 'Baik' ? 'selected' : '' }}>Baik</option>
            <option value="Rusak" {{ request('kondisi') == 'Rusak' ? 'selected' : '' }}>Rusak</option>
        </select>
        <button type="submit" class="bg-slate-800 text-white px-5 py-2.5 rounded-xl text-sm font-medium">Filter</button>
    </form>
    <a href="{{ route('inventaris.create') }}" class="bg-slate-800 text-white px-5 py-2.5 rounded-xl text-sm font-medium hover:bg-slate-700 transition-colors flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Aset
    </a>
</div>

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-100 bg-slate-50">
                    <th class="text-left px-6 py-4 font-semibold text-slate-600 whitespace-nowrap">Nama Barang</th>
                    <th class="text-left px-4 py-4 font-semibold text-slate-600 whitespace-nowrap">Kode</th>
                    <th class="text-center px-4 py-4 font-semibold text-slate-600 whitespace-nowrap">Jumlah</th>
                    <th class="text-left px-4 py-4 font-semibold text-slate-600 whitespace-nowrap">Satuan</th>
                    <th class="text-left px-4 py-4 font-semibold text-slate-600 whitespace-nowrap">Lokasi</th>
                    <th class="text-center px-4 py-4 font-semibold text-slate-600 whitespace-nowrap">Kondisi</th>
                    <th class="text-right px-6 py-4 font-semibold text-slate-600 whitespace-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
            @forelse($inventaris as $item)
            <tr class="hover:bg-slate-50 transition-colors">
                <td class="px-6 py-4 font-semibold text-slate-800 whitespace-nowrap">{{ $item->nama_barang }}</td>
                <td class="px-4 py-4 font-mono text-slate-600 text-xs whitespace-nowrap">{{ $item->kode_barang ?? '-' }}</td>
                <td class="px-4 py-4 text-center text-slate-700 font-medium whitespace-nowrap">{{ $item->jumlah }}</td>
                <td class="px-4 py-4 text-slate-600 whitespace-nowrap">{{ $item->satuan }}</td>
                <td class="px-4 py-4 text-slate-600 text-xs whitespace-nowrap">{{ $item->lokasi ?? '-' }}</td>
                <td class="px-4 py-4 text-center whitespace-nowrap">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $item->kondisi === 'Baik' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">
                        {{ $item->kondisi }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('inventaris.edit', $item) }}" class="p-2 text-slate-500 hover:text-slate-800 hover:bg-slate-100 rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>
                        <form id="invDel-{{ $item->id }}" action="{{ route('inventaris.destroy', $item) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="button"
                                    class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors inv-del-btn"
                                    data-id="{{ $item->id }}"
                                    data-name="{{ addslashes($item->nama_barang) }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-6 py-16 text-center text-slate-400">Belum ada data inventaris peralatan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    </div>
    @if($inventaris->hasPages())
    <div class="px-6 py-4 border-t border-slate-100">{{ $inventaris->links() }}</div>
    @endif
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.inv-del-btn').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const id   = this.dataset.id;
                const name = this.dataset.name;
                simpaConfirm({
                    title      : 'Hapus Aset',
                    message    : 'Hapus aset "' + name + '" dari daftar inventaris?',
                    confirmText: 'Ya, Hapus',
                    type       : 'danger',
                    onConfirm  : function () {
                        document.getElementById('invDel-' + id).submit();
                    }
                });
            });
        });
    });
</script>
@endpush

@endsection

