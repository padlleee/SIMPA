@extends('layouts.app')

@section('title', 'Rekap Donasi Tunai')
@section('page-title', 'Rekap Donasi Tunai')
@section('page-subtitle', 'Masukkan data donasi tunai secara manual')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
        <form action="{{ route('donasi.adminStore') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="nama_donatur" class="block text-sm font-semibold text-slate-700 mb-2">Nama Donatur <span class="text-red-500">*</span></label>
                <input type="text" id="nama_donatur" name="nama_donatur" value="{{ old('nama_donatur') }}"
                       required oninvalid="this.setCustomValidity('Wajib diisi')" oninput="this.setCustomValidity('')"
                       placeholder="Contoh: Hamba Allah / Bapak Budi"
                       class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-slate-800 focus:border-transparent @error('nama_donatur') border-red-500 @enderror">
                @error('nama_donatur')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="nominal" class="block text-sm font-semibold text-slate-700 mb-2">Nominal Donasi <span class="text-red-500">*</span></label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 font-medium">Rp</span>
                    <input type="text" id="nominal" name="nominal" value="{{ old('nominal') }}"
                           required oninvalid="this.setCustomValidity('Wajib diisi')" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 12); this.setCustomValidity('')"
                           placeholder="50000" maxlength="12"
                           class="w-full pl-12 pr-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-slate-800 focus:border-transparent @error('nominal') border-red-500 @enderror">
                </div>
                @error('nominal')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="tanggal_donasi" class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Donasi <span class="text-red-500">*</span></label>
                <input type="date" id="tanggal_donasi" name="tanggal_donasi" value="{{ old('tanggal_donasi', date('Y-m-d')) }}"
                       required oninvalid="this.setCustomValidity('Wajib diisi')" oninput="this.setCustomValidity('')"
                       class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-slate-800 focus:border-transparent @error('tanggal_donasi') border-red-500 @enderror">
                @error('tanggal_donasi')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="pt-4 flex gap-3 border-t border-slate-100">
                <button type="submit" class="bg-slate-800 text-white px-8 py-3 rounded-xl font-semibold hover:bg-slate-700 transition-colors">Simpan Rekap</button>
                <a href="{{ route('donasi.index') }}" class="bg-slate-100 text-slate-700 px-8 py-3 rounded-xl font-semibold hover:bg-slate-200 transition-colors">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
