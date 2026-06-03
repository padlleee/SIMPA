@extends('layouts.app')

@section('title', 'Buat Akun')
@section('page-title', 'Buat Akun Baru')
@section('page-subtitle', 'Tambahkan pengguna ke sistem SIMPA')

@section('content')
<div class="max-w-xl">
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
    <form action="{{ route('users.store') }}" method="POST" class="space-y-5">
        @csrf
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Username <span class="text-red-500">*</span></label>
            <input type="text" name="username" value="{{ old('username') }}"
                   class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 @error('username') border-red-400 @enderror">
            @error('username')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Email <span class="text-red-500">*</span></label>
            <input type="email" name="email" value="{{ old('email') }}"
                   class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 @error('email') border-red-400 @enderror"
                   placeholder="Email resmi pengurus">
            @error('email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Role <span class="text-red-500">*</span></label>
            <select name="role" id="role-select" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
                @if(auth()->user()->role === 'Ketua')
                    @if(\App\Models\User::where('role', 'Admin')->count() == 0)
                        <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                    @endif
                    <option value="Ketua" {{ old('role') == 'Ketua' ? 'selected' : '' }}>Ketua Yayasan</option>
                @endif
                <option value="Bendahara"  {{ old('role') == 'Bendahara'  ? 'selected' : '' }}>Bendahara</option>
                <option value="Donatur"    {{ old('role') == 'Donatur'    ? 'selected' : '' }}>Donatur</option>
            </select>
            <p id="donatur-hint" class="text-blue-600 text-sm mt-2 hidden">
                💡 Profil Donatur akan dibuat otomatis saat role ini dipilih.
            </p>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Password <span class="text-red-500">*</span></label>
                <input type="password" name="password"
                       class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 @error('password') border-red-400 @enderror">
                @error('password')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Konfirmasi Password</label>
                <input type="password" name="password_confirmation"
                       class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
            </div>
        </div>
        <p class="text-xs text-slate-400">Pengguna baru akan diminta mengganti password saat pertama kali login.</p>
        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-slate-800 text-white px-8 py-3 rounded-xl font-semibold hover:bg-slate-700 transition-colors">Buat Akun</button>
            <a href="{{ route('users.index') }}" class="bg-slate-100 text-slate-700 px-8 py-3 rounded-xl font-semibold hover:bg-slate-200 transition-colors">Batal</a>
        </div>
    </form>
</div>
</div>

<script>
    const roleSelect = document.getElementById('role-select');
    const donaturHint = document.getElementById('donatur-hint');
    roleSelect.addEventListener('change', function() {
        donaturHint.classList.toggle('hidden', this.value !== 'Donatur');
    });
    // Trigger on load if old value is Donatur
    if (roleSelect.value === 'Donatur') donaturHint.classList.remove('hidden');
</script>
@endsection
