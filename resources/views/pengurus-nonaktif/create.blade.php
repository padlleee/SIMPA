@extends('layouts.app')

@section('title', 'Tambah Pengurus Non-Aktif')
@section('page-title', 'Tambah Data Pengurus')
@section('page-subtitle', 'Masukkan data pengurus yang sudah demisioner')

@section('content')

<div class="mb-6">
    <a href="{{ route('admin.pengurus-nonaktif.index') }}" class="text-slate-500 hover:text-slate-800 flex items-center gap-2 text-sm font-medium transition-colors w-fit">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali ke Daftar
    </a>
</div>

<div class="max-w-2xl bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
    <form action="{{ route('admin.pengurus-nonaktif.store') }}" method="POST" class="space-y-6">
        @csrf
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
            <input type="text" name="nama" required class="w-full px-4 py-3 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-slate-800 focus:outline-none" placeholder="Masukkan nama...">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Jabatan Terakhir</label>
            <input type="text" name="jabatan_terakhir" class="w-full px-4 py-3 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-slate-800 focus:outline-none" placeholder="Mis: Bendahara">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Tahun Non-Aktif</label>
            <input type="text" name="tahun_nonaktif" class="w-full px-4 py-3 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-slate-800 focus:outline-none" placeholder="Mis: 2023">
        </div>

        <div class="pt-4 border-t border-slate-100 flex justify-end">
            <button type="submit" class="bg-slate-800 text-white font-medium py-3 px-8 rounded-xl hover:bg-slate-700 transition-colors text-sm">Simpan Data</button>
        </div>
    </form>
</div>

@endsection
