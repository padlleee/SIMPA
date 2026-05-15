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
    <a href="{{ route('stok.riwayat') }}" class="bg-white border border-slate-300 text-slate-600 px-5 py-2.5 rounded-xl text-sm font-medium hover:bg-slate-50 transition-colors flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        Riwayat Stok
    </a>
    <a href="{{ route('stok.create') }}" class="bg-slate-800 text-white px-5 py-2.5 rounded-xl text-sm font-medium hover:bg-slate-700 transition-colors flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Barang
    </a>
</div>

@php
    $lowStockItems = \App\Models\StokPanti::where('stok_akhir', '<=', 5)->get();
@endphp

@if($lowStockItems->count() > 0)
<div id="stok-alert" class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4 flex gap-4 items-center relative">
    <div class="bg-red-100 p-2 rounded-lg text-red-600 shrink-0">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
    </div>
    <div class="flex-1">
        <h4 class="font-bold text-red-800">Perhatian! Terdapat {{ $lowStockItems->count() }} barang dengan stok menipis.</h4>
        <p class="text-sm text-red-700 mt-0.5">
            Harap segera lakukan pengecekan dan penambahan stok.
            <a href="{{ route('stok.index', ['filter' => 'menipis']) }}" class="text-red-600 font-bold hover:underline transition-colors">Lihat stok yang menipis</a>.
        </p>
    </div>
    @if(request()->anyFilled(['search', 'kategori', 'filter']))
    <div class="shrink-0">
        <a href="{{ route('stok.index') }}" title="Reset/Lihat Semua" class="p-2 bg-white rounded-lg border border-red-100 text-red-400 hover:text-red-600 hover:bg-red-50 transition-all shadow-sm flex items-center gap-2 group">
            <svg class="w-4 h-4 group-hover:rotate-180 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
        </a>
    </div>
    @endif
    {{-- Close Button --}}
    <button onclick="closeStokAlert()" title="Tutup peringatan" class="p-1.5 ml-1 text-red-300 hover:text-red-600 hover:bg-red-100 rounded-lg transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
    </button>
</div>

{{-- Re-open button when closed --}}
<button id="stok-alert-reopen" onclick="reopenStokAlert()" title="Lihat peringatan stok" class="hidden mb-6 w-full text-left bg-red-50 border border-red-200 rounded-xl px-4 py-2.5 flex items-center gap-2 text-red-700 text-sm font-medium hover:bg-red-100 transition-colors">
    <svg class="w-4 h-4 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
    {{ $lowStockItems->count() }} barang dengan stok menipis — <span class="underline ml-1">Tampilkan peringatan</span>
</button>

<script>
    (function() {
        const alert = document.getElementById('stok-alert');
        const reopen = document.getElementById('stok-alert-reopen');
        if (sessionStorage.getItem('stok-alert-closed') === '1') {
            if (alert) alert.classList.add('hidden');
            if (reopen) reopen.classList.remove('hidden');
        }
    })();

    function closeStokAlert() {
        document.getElementById('stok-alert').classList.add('hidden');
        document.getElementById('stok-alert-reopen').classList.remove('hidden');
        sessionStorage.setItem('stok-alert-closed', '1');
    }

    function reopenStokAlert() {
        document.getElementById('stok-alert').classList.remove('hidden');
        document.getElementById('stok-alert-reopen').classList.add('hidden');
        sessionStorage.removeItem('stok-alert-closed');
    }
</script>
@endif

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-100 bg-slate-50">
                    <th class="text-left px-6 py-4 font-semibold text-slate-600 whitespace-nowrap">Nama Barang</th>
                    <th class="text-center px-4 py-4 font-semibold text-slate-600 whitespace-nowrap">Stok Awal</th>
                    <th class="text-center px-4 py-4 font-semibold text-slate-600 whitespace-nowrap">Masuk</th>
                    <th class="text-center px-4 py-4 font-semibold text-slate-600 whitespace-nowrap">Keluar</th>
                    <th class="text-center px-4 py-4 font-semibold text-slate-600 whitespace-nowrap">Stok Akhir</th>
                    <th class="text-left px-4 py-4 font-semibold text-slate-600">Keterangan</th>
                    <th class="text-right px-6 py-4 font-semibold text-slate-600 whitespace-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
            @forelse($stok as $item)
            <tr class="hover:bg-slate-50 transition-colors">
                <td class="px-6 py-4 font-semibold text-slate-800 whitespace-nowrap">{{ $item->nama_barang }}</td>
                <td class="px-4 py-4 text-center text-slate-600 whitespace-nowrap">{{ $item->stok_awal }}</td>
                <td class="px-4 py-4 text-center text-green-600 font-medium whitespace-nowrap">+{{ $item->barang_masuk }}</td>
                <td class="px-4 py-4 text-center text-red-500 font-medium whitespace-nowrap">-{{ $item->barang_keluar }}</td>
                <td class="px-4 py-4 text-center whitespace-nowrap">
                    <span class="font-bold {{ $item->stok_akhir <= 5 ? 'text-red-600' : 'text-green-600' }}">{{ $item->stok_akhir }}</span>
                    @if($item->stok_akhir <= 5)
                        <div class="mt-1">
                            <span class="bg-red-100 text-red-600 text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider">Menipis</span>
                        </div>
                    @else
                        <div class="mt-1">
                            <span class="bg-green-100 text-green-700 text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider">Aman</span>
                        </div>
                    @endif
                </td>
                <td class="px-4 py-4 text-slate-500 text-xs min-w-[200px]">{{ $item->keterangan ?? '-' }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
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
    </div>
    @if($stok->hasPages())
    <div class="px-6 py-4 border-t border-slate-100">{{ $stok->links() }}</div>
    @endif
</div>
@endsection
