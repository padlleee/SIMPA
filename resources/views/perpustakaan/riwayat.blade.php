@extends('layouts.app')

@section('title', 'Riwayat Peminjaman')
@section('page-title', 'Riwayat Peminjaman Buku')
@section('page-subtitle', 'Catatan seluruh aktivitas peminjaman perpustakaan')

@section('content')

{{-- Filter Bar --}}
<form action="{{ route('perpustakaan.riwayat') }}" method="GET" class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 mb-6">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
        <div class="relative md:col-span-2">
            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama/kata kunci..."
                   class="w-full pl-10 pr-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-slate-800">
        </div>
        <select name="status" class="border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-slate-800">
            <option value="">Semua Status</option>
            <option value="Dipinjam" {{ request('status') == 'Dipinjam' ? 'selected' : '' }}>Dipinjam</option>
            <option value="Dikembalikan" {{ request('status') == 'Dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
        </select>
        <input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}"
               class="border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-slate-800" title="Dari Tanggal Pinjam">
    </div>
    <div class="flex gap-3 mt-3">
        <button type="submit" class="bg-slate-800 text-white px-5 py-2.5 rounded-xl text-sm font-medium hover:bg-slate-700 transition-colors">Terapkan</button>
        @if(request()->anyFilled(['search','status','tanggal_dari']))
        <a href="{{ route('perpustakaan.riwayat') }}" class="bg-slate-100 text-slate-600 px-5 py-2.5 rounded-xl text-sm font-medium hover:bg-slate-200 transition-colors">Reset</a>
        @endif
        <a href="{{ route('perpustakaan.index') }}" class="ml-auto text-slate-500 hover:text-slate-700 text-sm flex items-center gap-1.5 font-medium">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
    </div>
</form>

{{-- Summary Cards --}}
<div class="grid grid-cols-3 gap-4 mb-6">
    @php
        $col = $riwayat->getCollection();
        $jmlDipinjam   = $col->where('status','Dipinjam')->count();
        $jmlKembali    = $col->where('status','Dikembalikan')->count();
        $jmlTerlambat  = $col->where('status','Dipinjam')->filter(fn($r) => $r->terlambat)->count();
    @endphp
    <div class="bg-white rounded-2xl border border-amber-100 shadow-sm p-5 flex items-center gap-4">
        <div class="w-10 h-10 bg-amber-50 rounded-xl flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13"/></svg>
        </div>
        <div><div class="text-2xl font-bold text-amber-600">{{ $jmlDipinjam }}</div><div class="text-xs text-slate-500 mt-0.5">Sedang Dipinjam</div></div>
    </div>
    <div class="bg-white rounded-2xl border border-green-100 shadow-sm p-5 flex items-center gap-4">
        <div class="w-10 h-10 bg-green-50 rounded-xl flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        </div>
        <div><div class="text-2xl font-bold text-green-600">{{ $jmlKembali }}</div><div class="text-xs text-slate-500 mt-0.5">Dikembalikan</div></div>
    </div>
    <div class="bg-white rounded-2xl border border-red-100 shadow-sm p-5 flex items-center gap-4">
        <div class="w-10 h-10 bg-red-50 rounded-xl flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div><div class="text-2xl font-bold text-red-500">{{ $jmlTerlambat }}</div><div class="text-xs text-slate-500 mt-0.5">Terlambat (hal. ini)</div></div>
    </div>
</div>

{{-- Tabel --}}
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-slate-100 bg-slate-50">
                <th class="text-left px-5 py-4 font-semibold text-slate-600">Buku</th>
                <th class="text-left px-4 py-4 font-semibold text-slate-600">Peminjam</th>
                <th class="text-center px-4 py-4 font-semibold text-slate-600">Tgl Pinjam</th>
                <th class="text-center px-4 py-4 font-semibold text-slate-600">Batas Kembali</th>
                <th class="text-center px-4 py-4 font-semibold text-slate-600">Dikembalikan</th>
                <th class="text-center px-4 py-4 font-semibold text-slate-600">Sisa / Terlambat</th>
                <th class="text-center px-4 py-4 font-semibold text-slate-600">Status</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($riwayat as $item)
            @php
                $sisaHari = $item->sisa_hari;
                $terlambat = $item->terlambat;
            @endphp
            <tr class="hover:bg-slate-50 transition-colors {{ $terlambat ? 'bg-red-50/40' : '' }}">
                <td class="px-5 py-4">
                    <div class="font-semibold text-slate-800 text-sm">{{ $item->buku?->judul_buku ?? '—' }}</div>
                    <div class="text-xs text-slate-400 font-mono">{{ $item->buku?->kode_buku }}</div>
                </td>
                <td class="px-4 py-4">
                    <div class="text-slate-700 font-medium">{{ $item->nama_peminjam }}</div>
                    <span class="inline-flex items-center mt-1 px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider
                        {{ $item->tipe_peminjam === 'Anak Asuh' ? 'bg-indigo-50 text-indigo-600' : 
                           ($item->tipe_peminjam === 'Donatur' ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-500') }}">
                        {{ $item->tipe_peminjam }}
                    </span>
                </td>
                <td class="px-4 py-4 text-center text-slate-500 text-xs">{{ $item->tanggal_pinjam?->format('d M Y') }}</td>
                <td class="px-4 py-4 text-center text-xs {{ $terlambat ? 'text-red-600 font-semibold' : 'text-slate-500' }}">
                    {{ $item->tanggal_kembali?->format('d M Y') ?? '—' }}
                </td>
                <td class="px-4 py-4 text-center text-xs">
                    @if($item->tanggal_dikembalikan)
                        <span class="{{ $item->tanggal_dikembalikan->lte($item->tanggal_kembali) ? 'text-green-600 font-medium' : 'text-red-500 font-semibold' }}">
                            {{ $item->tanggal_dikembalikan->format('d M Y') }}
                        </span>
                    @else
                        <span class="text-slate-300">—</span>
                    @endif
                </td>
                <td class="px-4 py-4 text-center">
                    @if($item->status === 'Dipinjam')
                        @if($terlambat)
                            <span class="text-red-600 font-bold text-xs">{{ abs($sisaHari) }} hari terlambat</span>
                        @elseif($sisaHari === 0)
                            <span class="text-amber-600 font-semibold text-xs">Hari ini!</span>
                        @elseif($sisaHari <= 3)
                            <span class="text-amber-500 font-semibold text-xs">{{ $sisaHari }} hari lagi</span>
                        @else
                            <span class="text-slate-500 text-xs">{{ $sisaHari }} hari lagi</span>
                        @endif
                    @else
                        <span class="text-slate-300 text-xs">—</span>
                    @endif
                </td>
                <td class="px-4 py-4 text-center">
                    @if($item->status === 'Dipinjam')
                        @if($terlambat)
                            <span class="bg-red-100 text-red-600 text-xs font-bold px-2.5 py-1 rounded-full">Terlambat</span>
                        @else
                            <span class="bg-amber-100 text-amber-700 text-xs font-bold px-2.5 py-1 rounded-full">Dipinjam</span>
                        @endif
                    @else
                        <span class="bg-green-100 text-green-700 text-xs font-bold px-2.5 py-1 rounded-full">Selesai</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-6 py-16 text-center text-slate-400">
                    <svg class="w-12 h-12 mx-auto text-slate-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13"/></svg>
                    <p class="font-medium">Belum ada riwayat peminjaman</p>
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
