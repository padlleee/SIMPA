@extends('layouts.app')

@section('title', 'Manajemen Pengguna')
@section('page-title', 'Manajemen Pengguna')
@section('page-subtitle', 'Kelola akun pengguna sistem')

@section('content')

{{-- ── Flash: Reset Password Info ─────────────────────────────────────── --}}
@if(session('reset_info'))
@php $ri = session('reset_info'); @endphp
<div id="resetInfoCard" class="mb-6 rounded-2xl p-5 flex gap-4 items-start shadow-sm
     {{ isset($ri['via_email']) && $ri['via_email'] ? 'bg-blue-50 border border-blue-300' : 'bg-amber-50 border border-amber-300' }}">
    <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0
         {{ isset($ri['via_email']) && $ri['via_email'] ? 'bg-blue-100' : 'bg-amber-100' }}">
        <svg class="w-5 h-5 {{ isset($ri['via_email']) && $ri['via_email'] ? 'text-blue-600' : 'text-amber-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
        </svg>
    </div>
    <div class="flex-1 min-w-0">
        <p class="font-bold text-sm mb-1 {{ isset($ri['via_email']) && $ri['via_email'] ? 'text-blue-800' : 'text-amber-800' }}">
            {{ isset($ri['via_email']) && $ri['via_email'] ? '📧 Password Direset & Siap Dikirim via Email' : 'Password Berhasil Direset' }}
        </p>
        <p class="text-sm mb-3 {{ isset($ri['via_email']) && $ri['via_email'] ? 'text-blue-700' : 'text-amber-700' }}">
            @if(isset($ri['via_email']) && $ri['via_email'])
                Password sementara untuk <strong>{{ $ri['username'] }}</strong> ({{ $ri['email'] }}) sudah digenerate.
                Saat integrasi email aktif, password ini akan dikirim otomatis ke email donatur.
            @else
                Sampaikan kredensial berikut kepada <strong>{{ $ri['username'] }}</strong>.
                Pengguna akan diminta mengganti password saat pertama kali masuk.
            @endif
        </p>
        <div class="bg-white border rounded-xl px-4 py-3 flex items-center justify-between gap-4
             {{ isset($ri['via_email']) && $ri['via_email'] ? 'border-blue-200' : 'border-amber-200' }}">
            <div>
                <span class="text-xs font-semibold uppercase tracking-wide
                     {{ isset($ri['via_email']) && $ri['via_email'] ? 'text-blue-500' : 'text-amber-500' }}">Password Sementara</span>
                <p id="tempPasswordText" class="text-lg font-bold text-slate-800 tracking-widest mt-0.5">{{ $ri['password'] }}</p>
            </div>
            <button onclick="copyTempPassword()" id="copyBtn"
                    class="shrink-0 font-semibold text-xs px-3 py-2 rounded-lg transition-colors flex items-center gap-1.5
                    {{ isset($ri['via_email']) && $ri['via_email'] ? 'bg-blue-100 hover:bg-blue-200 text-blue-700' : 'bg-amber-100 hover:bg-amber-200 text-amber-700' }}">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                </svg>
                Salin
            </button>
        </div>
        <p class="text-xs mt-2 {{ isset($ri['via_email']) && $ri['via_email'] ? 'text-blue-500' : 'text-amber-500' }}">⚠️ Tutup notifikasi ini setelah menyalin password.</p>
    </div>
    <button onclick="document.getElementById('resetInfoCard').remove()"
            class="transition-colors flex-shrink-0 mt-0.5 {{ isset($ri['via_email']) && $ri['via_email'] ? 'text-blue-400 hover:text-blue-600' : 'text-amber-400 hover:text-amber-600' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>
</div>
@endif

{{-- ── Banner: Permintaan Reset Password Pending ──────────────────────── --}}
@if($pendingResetCount > 0)
<div class="mb-6 bg-red-50 border border-red-200 rounded-2xl p-4 flex items-center gap-4">
    <div class="w-9 h-9 bg-red-100 rounded-xl flex items-center justify-center flex-shrink-0">
        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
        </svg>
    </div>
    <div class="flex-1">
        <p class="font-bold text-red-800 text-sm">
            🔔 {{ $pendingResetCount }} Permintaan Reset Password Menunggu
        </p>
        <p class="text-red-600 text-xs mt-0.5">Donatur berikut mengajukan reset password mandiri. Klik tombol 🔑 untuk memproses.</p>
    </div>
</div>
@endif

<div class="flex justify-end mb-6">
    <a href="{{ route('users.create') }}" class="bg-slate-800 text-white px-5 py-2.5 rounded-xl text-sm font-medium hover:bg-slate-700 transition-colors flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Buat Akun Baru
    </a>
</div>

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-100 bg-slate-50">
                    <th class="text-left px-6 py-4 font-semibold text-slate-600 whitespace-nowrap">Pengguna</th>
                    <th class="text-left px-4 py-4 font-semibold text-slate-600 whitespace-nowrap">Email</th>
                    <th class="text-left px-4 py-4 font-semibold text-slate-600 whitespace-nowrap">Role</th>
                    <th class="text-left px-4 py-4 font-semibold text-slate-600 whitespace-nowrap">Status</th>
                    <th class="text-right px-6 py-4 font-semibold text-slate-600 whitespace-nowrap">Aksi</th>
                </tr>
            </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($users as $user)
            <tr class="hover:bg-slate-50 transition-colors">
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-slate-100 rounded-full flex items-center justify-center flex-shrink-0 text-slate-600 font-semibold text-sm">
                            {{ strtoupper(substr($user->username, 0, 1)) }}
                        </div>
                        <span class="font-semibold text-slate-800">{{ $user->username }}</span>
                    </div>
                </td>
                <td class="px-4 py-4 text-slate-600 whitespace-nowrap">{{ $user->email }}</td>
                <td class="px-4 py-4 whitespace-nowrap">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                        {{ $user->role === 'Admin' ? 'bg-slate-800 text-white' : ($user->role === 'Ketua' ? 'bg-slate-200 text-slate-700' : 'bg-green-100 text-green-700') }}">
                        {{ $user->role }}
                    </span>
                </td>
                <td class="px-4 py-4 whitespace-nowrap">
                    @if($user->password_reset_requested_at)
                    {{-- Penanda ada permintaan reset mandiri --}}
                    <span class="inline-flex items-center gap-1 text-xs font-medium text-red-600 bg-red-50 px-2.5 py-1 rounded-full"
                          title="Permintaan reset dikirim: {{ $user->password_reset_requested_at->locale('id')->diffForHumans() }}">
                        <span class="relative flex w-2 h-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                        </span>
                        Minta Reset
                    </span>
                    @elseif($user->force_password_change)
                    <span class="inline-flex items-center gap-1 text-xs font-medium text-amber-600 bg-amber-50 px-2.5 py-1 rounded-full">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        Belum Ganti Password
                    </span>
                    @else
                    <span class="inline-flex items-center gap-1 text-xs font-medium text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        Aktif
                    </span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center justify-end gap-2">
                        {{-- Edit --}}
                        <a href="{{ route('users.edit', $user) }}"
                           class="p-2 text-slate-500 hover:text-slate-800 hover:bg-slate-100 rounded-lg transition-colors"
                           title="Edit pengguna">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </a>

                        @if($user->id_user !== auth()->id())
                        <form id="resetForm-{{ $user->id_user }}"
                              action="{{ route('users.reset-password', $user) }}" method="POST">
                            @csrf
                            <button type="button"
                                    onclick="simpaConfirm({
                                        title: '{{ $user->password_reset_requested_at ? '⚡ Proses Permintaan Reset' : 'Reset Password' }}',
                                        message: '{{ $user->password_reset_requested_at ? addslashes($user->username) . ' mengajukan reset password mandiri. Proses dan kirimkan password baru ke email ' . addslashes($user->email) . '?' : 'Reset password ' . addslashes($user->username) . ' ke password sementara?' }}',
                                        confirmText: 'Ya, Reset',
                                        type: 'warning',
                                        onConfirm: () => document.getElementById('resetForm-{{ $user->id_user }}').submit()
                                    })"
                                    class="p-2 rounded-lg transition-colors {{ $user->password_reset_requested_at ? 'text-red-500 hover:text-red-700 hover:bg-red-50 ring-1 ring-red-200' : 'text-amber-400 hover:text-amber-600 hover:bg-amber-50' }}"
                                    title="{{ $user->password_reset_requested_at ? '⚡ Ada permintaan reset! Klik untuk proses.' : 'Reset password' }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                </svg>
                            </button>
                        </form>

                        <form id="deleteForm-{{ $user->id_user }}"
                              action="{{ route('users.destroy', $user) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="button"
                                    onclick="simpaConfirm({
                                        title: 'Hapus Akun',
                                        message: 'Hapus akun {{ addslashes($user->username) }}? Tindakan ini tidak dapat dibatalkan.',
                                        confirmText: 'Ya, Hapus',
                                        type: 'danger',
                                        onConfirm: () => document.getElementById('deleteForm-{{ $user->id_user }}').submit()
                                    })"
                                    class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                    title="Hapus pengguna">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-12 text-center text-slate-400">Belum ada pengguna.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    </div>
    @if($users->hasPages())
    <div class="px-6 py-4 border-t border-slate-100">{{ $users->links() }}</div>
    @endif
</div>

@push('scripts')
<script>
function copyTempPassword() {
    const text = document.getElementById('tempPasswordText').textContent.trim();
    navigator.clipboard.writeText(text).then(function() {
        const btn = document.getElementById('copyBtn');
        btn.innerHTML = `<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Tersalin!`;
        btn.classList.add('bg-green-100', 'text-green-700');
        btn.classList.remove('bg-amber-100', 'text-amber-700');
        setTimeout(function() {
            btn.innerHTML = `<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg> Salin`;
            btn.classList.remove('bg-green-100', 'text-green-700');
            btn.classList.add('bg-amber-100', 'text-amber-700');
        }, 2500);
    }).catch(function() {
        // Fallback untuk browser lama
        const range = document.createRange();
        range.selectNode(document.getElementById('tempPasswordText'));
        window.getSelection().removeAllRanges();
        window.getSelection().addRange(range);
        document.execCommand('copy');
        window.getSelection().removeAllRanges();
    });
}
</script>
@endpush

@endsection
