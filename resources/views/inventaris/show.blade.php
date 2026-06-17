@extends('layouts.app')

@section('title', 'Detail Kategori: ' . $nama_kategori)
@section('page-title', 'Detail: ' . $nama_kategori)
@section('page-subtitle', 'Rincian semua unit dalam kategori ini beserta lokasi, kondisi, dan keterangan')

@section('content')

<div class="mb-6 flex gap-3">
    <a href="{{ route('inventaris.index') }}" class="bg-slate-100 text-slate-700 px-5 py-2.5 rounded-xl text-sm font-medium hover:bg-slate-200 transition-colors flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Semua Kategori
    </a>
    <a href="{{ route('inventaris.create') }}" class="bg-slate-800 text-white px-5 py-2.5 rounded-xl text-sm font-medium hover:bg-slate-700 transition-colors flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Unit
    </a>
</div>

{{-- Summary cards --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
        <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider mb-1">Total Unit</p>
        <p class="text-3xl font-bold text-slate-800">{{ $items->sum('jumlah') }}</p>
    </div>
    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
        <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider mb-1">Entri Data</p>
        <p class="text-3xl font-bold text-slate-800">{{ $items->count() }}</p>
    </div>
    <div class="bg-green-50 rounded-2xl border border-green-200 p-5 shadow-sm">
        <p class="text-xs text-green-500 font-semibold uppercase tracking-wider mb-1">Kondisi Baik</p>
        <p class="text-3xl font-bold text-green-700">{{ $items->where('kondisi', 'Baik')->sum('jumlah') }}</p>
    </div>
    <div class="bg-red-50 rounded-2xl border border-red-200 p-5 shadow-sm">
        <p class="text-xs text-red-400 font-semibold uppercase tracking-wider mb-1">Kondisi Rusak</p>
        <p class="text-3xl font-bold text-red-600">{{ $items->where('kondisi', 'Rusak')->sum('jumlah') }}</p>
    </div>
</div>

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-100 bg-slate-50">
                    <th class="text-left px-6 py-4 font-semibold text-slate-600 whitespace-nowrap">Kode Unik</th>
                    <th class="text-left px-4 py-4 font-semibold text-slate-600 whitespace-nowrap">Nama Barang (Spesifik)</th>
                    <th class="text-left px-4 py-4 font-semibold text-slate-600 whitespace-nowrap">Lokasi, Ruangan & Foto</th>
                    <th class="text-center px-4 py-4 font-semibold text-slate-600 whitespace-nowrap">Kondisi</th>
                    <th class="text-left px-4 py-4 font-semibold text-slate-600 whitespace-nowrap">Keterangan</th>
                    <th class="text-right px-6 py-4 font-semibold text-slate-600 whitespace-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
            @forelse($items as $item)
            <tr class="hover:bg-slate-50 transition-colors">
                <td class="px-6 py-4 font-mono text-slate-800 font-semibold text-xs whitespace-nowrap">{{ $item->kode_unik_aset ?? $item->kode_barang }}</td>
                <td class="px-4 py-4 whitespace-nowrap">
                    <span class="font-semibold text-slate-800">{{ $item->nama_barang }}</span>
                    @if($item->nama_barang !== $item->nama_kategori)
                        <span class="block text-xs text-slate-400">{{ $item->nama_kategori }}</span>
                    @endif
                </td>
                <td class="px-4 py-4">
                    <div class="flex items-center gap-3">
                        @if($item->gambar)
                        <img src="{{ Storage::url($item->gambar) }}"
                             alt="Foto {{ $item->lokasi }}"
                             class="w-14 h-14 rounded-xl object-cover border border-slate-200 shadow-sm cursor-zoom-in img-zoom-trigger hover:scale-105 transition-transform flex-shrink-0"
                             data-src="{{ Storage::url($item->gambar) }}"
                             title="Klik untuk perbesar">
                        @else
                        <div class="w-14 h-14 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-300 flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        @endif
                        <div>
                            <span class="text-sm font-semibold text-slate-800 block">{{ $item->lokasi ?? '-' }}</span>
                            @if($item->ruangan)
                                <span class="text-xs text-slate-500 block mb-1">Ruangan: {{ $item->ruangan }}</span>
                            @endif
                            <span class="text-[10px] text-slate-400">{{ $item->gambar ? 'Klik foto untuk zoom' : 'Belum ada foto' }}</span>
                        </div>
                    </div>
                </td>
                <td class="px-4 py-4 text-center whitespace-nowrap">
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold {{ $item->kondisi === 'Baik' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">
                        @if($item->kondisi === 'Baik')
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        @else
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        @endif
                        {{ $item->kondisi }}
                    </span>
                </td>
                <td class="px-4 py-4 text-slate-500 text-xs max-w-xs">
                    <div class="line-clamp-2" title="{{ $item->keterangan }}">{{ $item->keterangan ?? '-' }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('inventaris.edit', $item) }}" class="p-2 text-slate-500 hover:text-slate-800 hover:bg-slate-100 rounded-lg transition-colors" title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>
                        <form id="invDel-{{ $item->id_aset }}" action="{{ route('inventaris.destroy', $item) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="button"
                                    class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors inv-del-btn"
                                    data-id="{{ $item->id_aset }}"
                                    data-name="{{ addslashes($item->nama_barang) }}"
                                    title="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-16 text-center text-slate-400">Belum ada data untuk kategori ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    </div>
</div>

{{-- Modal Zoom Gambar --}}
<div id="imgZoomModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/80 backdrop-blur-sm p-4" onclick="closeImgZoom()">
    <div class="relative max-w-4xl w-full" onclick="event.stopPropagation()">
        <button onclick="closeImgZoom()" class="absolute -top-10 right-0 text-white hover:text-slate-300 transition-colors flex items-center gap-2 text-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            Tutup (ESC)
        </button>
        <img id="imgZoomContent" src="" alt="Preview Gambar"
             class="w-full max-h-[80vh] object-contain rounded-2xl shadow-2xl border border-white/10">
    </div>
</div>

@push('scripts')
<script>
    function openImgZoom(src) {
        const modal = document.getElementById('imgZoomModal');
        document.getElementById('imgZoomContent').src = src;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeImgZoom() {
        const modal = document.getElementById('imgZoomModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeImgZoom();
    });

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.img-zoom-trigger').forEach(function (img) {
            img.addEventListener('click', function () {
                openImgZoom(this.dataset.src || this.src);
            });
        });

        document.querySelectorAll('.inv-del-btn').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const id   = this.dataset.id;
                const name = this.dataset.name;
                simpaConfirm({
                    title      : 'Hapus Data',
                    message    : 'Hapus data peralatan "' + name + '" ini?',
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
