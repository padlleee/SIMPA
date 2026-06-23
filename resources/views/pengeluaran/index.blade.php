@extends('layouts.app')

@section('title', 'Pengeluaran')
@section('page-title', 'Pengeluaran')
@section('page-subtitle', 'Pencatatan pengeluaran operasional panti')

@section('content')

<div class="flex flex-col sm:flex-row gap-4 mb-6">
    <form action="{{ route('pengeluaran.index') }}" method="GET" class="flex gap-3 flex-1">
        <select name="bulan" class="border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-slate-800">
            <option value="">Semua Bulan</option>
            @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $i => $bulan)
            <option value="{{ $i+1 }}" {{ request('bulan') == $i+1 ? 'selected' : '' }}>{{ $bulan }}</option>
            @endforeach
        </select>
        <select name="tahun" class="border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-slate-800">
            <option value="">Semua Tahun</option>
            @for($year = date('Y'); $year >= date('Y') - 4; $year--)
            <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>{{ $year }}</option>
            @endfor
        </select>
        <button type="submit" class="bg-slate-800 text-white px-5 py-2.5 rounded-xl text-sm font-medium">Filter</button>
    </form>
    <a href="{{ route('pengeluaran.create') }}" class="bg-slate-800 text-white px-5 py-2.5 rounded-xl text-sm font-medium hover:bg-slate-700 transition-colors flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Catat Pengeluaran
    </a>
</div>

<div class="bg-slate-800 rounded-2xl p-6 mb-6 text-white">
    <p class="text-slate-400 text-sm">
        @if(request('bulan') || request('tahun'))
            Total Pengeluaran (Berdasarkan Filter)
        @else
            Total Seluruh Pengeluaran
        @endif
    </p>
    <p class="text-3xl font-bold mt-1">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
</div>

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-100 bg-slate-50">
                    <th class="text-left px-6 py-4 font-semibold text-slate-600 whitespace-nowrap">Tanggal</th>
                    <th class="text-left px-4 py-4 font-semibold text-slate-600 whitespace-nowrap">Kategori</th>
                    <th class="text-left px-4 py-4 font-semibold text-slate-600 whitespace-nowrap">Dicatat Oleh</th>
                    <th class="text-left px-4 py-4 font-semibold text-slate-600">Keterangan</th>
                    <th class="text-right px-4 py-4 font-semibold text-slate-600 whitespace-nowrap">Jumlah</th>
                    <th class="text-right px-6 py-4 font-semibold text-slate-600 whitespace-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
            @forelse($pengeluaran as $item)
            <tr class="hover:bg-slate-50 transition-colors">
                <td class="px-6 py-4 text-slate-600 whitespace-nowrap">
                    {{ \Carbon\Carbon::parse($item->tanggal_pengeluaran)->format('d M Y') }}
                </td>
                <td class="px-4 py-4 whitespace-nowrap">
                    <span class="bg-slate-100 text-slate-600 text-xs font-medium px-2.5 py-1 rounded-full">
                        {{ $item->kategori_biaya }}
                    </span>
                <td class="px-4 py-4 whitespace-nowrap">
                    <span class="text-slate-600 text-xs font-medium">
                        {{ $item->bendahara->username ?? '-' }}
                    </span>
                </td>
                <td class="px-4 py-4 text-slate-500 text-xs min-w-[200px]">{{ $item->keterangan ?? '-' }}</td>
                <td class="px-4 py-4 text-right font-bold text-slate-800 whitespace-nowrap">
                    Rp {{ number_format($item->nominal, 0, ',', '.') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('pengeluaran.show', $item) }}" class="p-2 text-slate-500 hover:text-slate-800 hover:bg-slate-100 rounded-lg transition-colors" title="Lihat Detail">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </a>
                        <form id="penDel-{{ $item->id_pengeluaran }}" action="{{ route('pengeluaran.destroy', $item) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="button" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                    onclick="simpaConfirm({ title:'Hapus Pengeluaran', message:'Hapus catatan pengeluaran Rp {{ number_format($item->nominal, 0, ',', '.') }} ini?', confirmText:'Ya, Hapus', type:'danger', onConfirm:()=>document.getElementById('penDel-{{ $item->id_pengeluaran }}').submit() })">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-12 text-center text-slate-400">Belum ada catatan pengeluaran.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    </div>
    @if($pengeluaran->hasPages())
    <div class="px-6 py-4 border-t border-slate-100">{{ $pengeluaran->links() }}</div>
    @endif
</div>
@endsection
