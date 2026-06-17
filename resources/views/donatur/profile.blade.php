@extends('layouts.app')

@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')
@section('page-subtitle', 'Perbarui informasi akun Anda')

@section('content')
<div class="max-w-2xl">
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
    <form action="{{ route('donatur.profile.update') }}" method="POST" class="space-y-6">
        @csrf @method('PUT')

        <div class="border-b border-slate-100 pb-6 mb-6">
            <h3 class="text-base font-bold text-slate-700 mb-5">Informasi Akun</h3>
            <div class="grid md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Username <span class="text-red-500">*</span></label>
                    <input type="text" name="username" value="{{ old('username', $user->username) }}"
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 @error('username') border-red-400 @enderror">
                    @error('username')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 @error('email') border-red-400 @enderror">
                    @error('email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        @if($donatur)
        <div class="border-b border-slate-100 pb-6 mb-6">
            <h3 class="text-base font-bold text-slate-700 mb-5">Informasi Donatur</h3>
            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Donatur</label>
                    <input type="text" name="nama_donatur" value="{{ old('nama_donatur', $donatur->nama_donatur) }}"
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Alamat</label>
                    <textarea name="alamat" rows="2"
                              class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">{{ old('alamat', $donatur->alamat) }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nomor Kontak</label>
                    <input type="text" name="nomor_kontak" value="{{ old('nomor_kontak', $donatur->nomor_kontak) }}"
                           maxlength="15" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
                </div>
            </div>
        </div>
        @endif

        <div>
            <h3 class="text-base font-bold text-slate-700 mb-5">Ubah Password</h3>
            <div class="grid md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Password Baru</label>
                    <input type="password" name="password"
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800"
                           placeholder="Kosongkan jika tidak diubah">
                    @error('password')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation"
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800"
                           placeholder="Ulangi kata sandi baru">
                </div>
            </div>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-slate-800 text-white px-8 py-3 rounded-xl font-semibold hover:bg-slate-700 transition-colors">Simpan Perubahan</button>
        </div>
    </form>
</div>
</div>
@endsection
