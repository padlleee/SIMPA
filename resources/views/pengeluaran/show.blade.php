@extends('layouts.app')

@section('title', 'Detail Pengeluaran')
@section('page-title', 'Detail Pengeluaran')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-8 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <div>
                <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">Nominal Pengeluaran</p>
                <h2 class="text-3xl font-bold text-slate-900 mt-1">Rp {{ number_format($pengeluaran->nominal, 0, ',', '.') }}</h2>
            </div>
            <div class="bg-slate-100 text-slate-700 px-4 py-2 rounded-xl text-sm font-semibold border border-slate-200">
                {{ $pengeluaran->kategori_biaya }}
            </div>
        </div>

        <div class="p-8 space-y-6">
            <div class="grid md:grid-cols-2 gap-8">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Tanggal Pengeluaran</p>
                    <p class="text-slate-700 font-medium">{{ \Carbon\Carbon::parse($pengeluaran->tanggal_pengeluaran)->format('d F Y') }}</p>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Dicatat Oleh</p>
                    <p class="text-slate-700 font-medium">{{ $pengeluaran->bendahara->username ?? 'Sistem' }}</p>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-50">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Keterangan / Deskripsi</p>
                <div class="bg-slate-50 rounded-xl p-5 text-slate-600 leading-relaxed border border-slate-100 italic">
                    {{ $pengeluaran->keterangan ?? 'Tidak ada keterangan tambahan.' }}
                </div>
            </div>

            <div class="pt-8 flex gap-3">
                <a href="{{ route('pengeluaran.index') }}" class="flex-1 bg-slate-100 text-slate-700 px-6 py-3 rounded-xl font-semibold text-center hover:bg-slate-200 transition-colors">
                    Kembali
                </a>
                <form id="penShowDel" action="{{ route('pengeluaran.destroy', $pengeluaran) }}" method="POST" class="flex-1">
                    @csrf @method('DELETE')
                    <button type="button"
                            onclick="simpaConfirm({ title:'Hapus Catatan Pengeluaran', message:'Hapus permanen catatan pengeluaran Rp {{ number_format($pengeluaran->nominal, 0, ',', '.') }} ini? Data tidak dapat dikembalikan.', confirmText:'Ya, Hapus Permanen', type:'danger', onConfirm:()=>document.getElementById('penShowDel').submit() })"
                            class="w-full bg-red-50 text-red-600 px-6 py-3 rounded-xl font-semibold hover:bg-red-100 transition-colors border border-red-100">
                        Hapus Catatan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
