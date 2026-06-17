@extends('layouts.app')

@section('title', 'Edit Pengguna')
@section('page-title', 'Edit Pengguna')

@section('content')
<div class="max-w-xl">
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
    <form action="{{ route('users.update', $user) }}" method="POST" class="space-y-5">
        @csrf @method('PUT')
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Username</label>
            <input type="text" name="username" value="{{ old('username', $user->username) }}"
                   class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
        </div>
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                   class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
        </div>
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Role</label>
            <select name="role" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
                @if(auth()->user()->role === 'Ketua' || $user->role === 'Admin')
                    @if(auth()->user()->role === 'Ketua')
                        @if(\App\Models\User::where('role', 'Admin')->count() == 0 || $user->role === 'Admin')
                            <option value="Admin" {{ old('role', $user->role) == 'Admin' ? 'selected' : '' }}>Admin</option>
                        @endif
                    @elseif($user->role === 'Admin')
                        <option value="Admin" {{ old('role', $user->role) == 'Admin' ? 'selected' : '' }}>Admin</option>
                    @endif
                @endif
                @if(auth()->user()->role === 'Ketua' || $user->role === 'Ketua')
                    <option value="Ketua" {{ old('role', $user->role) == 'Ketua' ? 'selected' : '' }}>Ketua Yayasan</option>
                @endif
                <option value="Bendahara" {{ old('role', $user->role) == 'Bendahara' ? 'selected' : '' }}>Bendahara</option>
                <option value="Donatur"   {{ old('role', $user->role) == 'Donatur'   ? 'selected' : '' }}>Donatur</option>
            </select>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Password Baru</label>
                <input type="password" name="password" placeholder="Kosongkan jika tidak diubah"
                       class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Konfirmasi</label>
                <input type="password" name="password_confirmation"
                       class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
            </div>
        </div>
        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-slate-800 text-white px-8 py-3 rounded-xl font-semibold hover:bg-slate-700 transition-colors">Simpan</button>
            <a href="{{ route('users.index') }}" class="bg-slate-100 text-slate-700 px-8 py-3 rounded-xl font-semibold hover:bg-slate-200 transition-colors">Batal</a>
        </div>
    </form>
</div>
</div>
@endsection
