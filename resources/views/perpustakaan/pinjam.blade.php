@extends('layouts.app')

@section('title', 'Pinjamkan Buku')
@section('page-title', 'Form Peminjaman')
@section('page-subtitle', 'Pinjamkan buku kepada anggota')

@section('content')
<div class="max-w-xl">
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
    <div class="bg-slate-50 rounded-xl p-5 mb-6">
        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Buku yang Dipinjamkan</p>
        <p class="font-bold text-slate-800 text-lg">{{ $perpustakaan->judul_buku }}</p>
        <p class="text-slate-500 text-sm">{{ $perpustakaan->pengarang }} · {{ $perpustakaan->kode_buku }}</p>
    </div>

    <form action="{{ route('perpustakaan.pinjam.store', $perpustakaan) }}" method="POST" class="space-y-5">
        @csrf
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Peminjam <span class="text-red-500">*</span></label>
            <input type="text" name="nama_peminjam" value="{{ old('nama_peminjam') }}"
                   class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 @error('nama_peminjam') border-red-400 @enderror"
                   placeholder="Nama lengkap peminjam">
            @error('nama_peminjam')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Pinjam <span class="text-red-500">*</span></label>
                <input type="date" name="tanggal_pinjam" value="{{ old('tanggal_pinjam', date('Y-m-d')) }}"
                       class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Batas Kembali <span class="text-red-500">*</span></label>
                <input type="date" name="tanggal_kembali" value="{{ old('tanggal_kembali', date('Y-m-d', strtotime('+7 days'))) }}"
                       class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
            </div>
        </div>
        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-slate-800 text-white px-8 py-3 rounded-xl font-semibold hover:bg-slate-700 transition-colors">Pinjamkan</button>
            <a href="{{ route('perpustakaan.index') }}" class="bg-slate-100 text-slate-700 px-8 py-3 rounded-xl font-semibold hover:bg-slate-200 transition-colors">Batal</a>
        </div>
    </form>
</div>
</div>
@endsection
