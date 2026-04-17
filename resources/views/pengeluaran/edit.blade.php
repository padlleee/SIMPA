@extends('layouts.app')

@section('title', 'Edit Pengeluaran')
@section('page-title', 'Edit Pengeluaran')

@section('content')
<div class="max-w-xl">
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
    <form action="{{ route('pengeluaran.update', $pengeluaran) }}" method="POST" class="space-y-5">
        @csrf
        @method('PUT')

        <div class="grid md:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal</label>
                <input type="date" name="tanggal_pengeluaran"
                       value="{{ old('tanggal_pengeluaran', \Carbon\Carbon::parse($pengeluaran->tanggal_pengeluaran)->format('Y-m-d')) }}"
                       class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
                @error('tanggal_pengeluaran')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Kategori</label>
                <input type="text" name="kategori_biaya" value="{{ old('kategori_biaya', $pengeluaran->kategori_biaya) }}"
                       class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
                @error('kategori_biaya')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
        </div>
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Jumlah (Rp)</label>
            <div class="relative">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 font-medium">Rp</span>
                <input type="number" name="nominal" value="{{ old('nominal', $pengeluaran->nominal) }}" min="1"
                       class="w-full border border-slate-300 rounded-xl pl-12 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
            </div>
            @error('nominal')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Keterangan</label>
            <textarea name="keterangan" rows="2"
                      class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">{{ old('keterangan', $pengeluaran->keterangan) }}</textarea>
            @error('keterangan')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-slate-800 text-white px-8 py-3 rounded-xl font-semibold hover:bg-slate-700 transition-colors">Simpan Perubahan</button>
            <a href="{{ route('pengeluaran.index') }}" class="bg-slate-100 text-slate-700 px-8 py-3 rounded-xl font-semibold hover:bg-slate-200 transition-colors">Batal</a>
        </div>
    </form>
</div>
</div>
@endsection
