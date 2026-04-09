@extends('layouts.app')

@section('title', 'Edit Buku')
@section('page-title', 'Edit Buku')

@section('content')
<div class="max-w-xl">
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
    <form action="{{ route('perpustakaan.update', $perpustakaan) }}" method="POST" class="space-y-5">
        @csrf @method('PUT')
        <div class="grid md:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Kode Buku</label>
                <input type="text" name="kode_buku" value="{{ old('kode_buku', $perpustakaan->kode_buku) }}"
                       class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Jumlah Buku</label>
                <input type="number" name="jumlah_buku" value="{{ old('jumlah_buku', $perpustakaan->jumlah_buku) }}" min="1"
                       class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Judul Buku</label>
                <input type="text" name="judul_buku" value="{{ old('judul_buku', $perpustakaan->judul_buku) }}"
                       class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Pengarang</label>
                <input type="text" name="pengarang" value="{{ old('pengarang', $perpustakaan->pengarang) }}"
                       class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Kondisi Buku</label>
                <input type="text" name="kondisi_buku" value="{{ old('kondisi_buku', $perpustakaan->kondisi_buku) }}"
                       class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
            </div>
        </div>
        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-slate-800 text-white px-8 py-3 rounded-xl font-semibold hover:bg-slate-700 transition-colors">Simpan</button>
            <a href="{{ route('perpustakaan.index') }}" class="bg-slate-100 text-slate-700 px-8 py-3 rounded-xl font-semibold hover:bg-slate-200 transition-colors">Batal</a>
        </div>
    </form>
</div>
</div>
@endsection
