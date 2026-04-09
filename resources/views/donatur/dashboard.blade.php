@extends('layouts.app')

@section('title', 'Dashboard Donatur')
@section('page-title', 'Dashboard Donatur')
@section('page-subtitle', 'Riwayat donasi dan informasi akun Anda')

@section('content')

<!-- Welcome Banner -->
<div class="bg-slate-800 rounded-2xl p-8 mb-8 text-white">
    <p class="text-slate-400 text-sm mb-1">Selamat datang kembali,</p>
    <h2 class="text-2xl font-bold">{{ $donatur?->nama_donatur ?? $user->username }}</h2>
    <div class="mt-6 flex items-center gap-6">
        <div class="bg-white/10 rounded-xl px-6 py-4">
            <div class="text-2xl font-bold">Rp {{ number_format($totalDonasi, 0, ',', '.') }}</div>
            <div class="text-slate-400 text-sm mt-0.5">Total Donasi Terverifikasi</div>
        </div>
        <div class="bg-white/10 rounded-xl px-6 py-4">
            <div class="text-2xl font-bold">{{ $donasi->total() }}</div>
            <div class="text-slate-400 text-sm mt-0.5">Total Transaksi</div>
        </div>
    </div>
</div>

<!-- Donation History -->
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex items-center justify-between">
        <h3 class="font-bold text-slate-700">Riwayat Donasi</h3>
    </div>
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-slate-100">
                <th class="text-left px-6 py-3 font-semibold text-slate-500">Tanggal</th>
                <th class="text-left px-4 py-3 font-semibold text-slate-500">Nominal</th>
                <th class="text-left px-4 py-3 font-semibold text-slate-500">Status</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($donasi as $item)
            <tr class="hover:bg-slate-50 transition-colors">
                <td class="px-6 py-4 text-slate-600">{{ $item->tanggal_donasi?->isoFormat('D MMMM Y') ?? '-' }}</td>
                <td class="px-4 py-4 font-bold text-slate-800">Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                <td class="px-4 py-4">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $item->status_verifikasi === 'Success' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                        {{ $item->status_verifikasi === 'Success' ? '✓ Terverifikasi' : '⏳ Diproses' }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="px-6 py-12 text-center text-slate-400">
                    <p>Belum ada riwayat donasi.</p>
                    <a href="{{ route('landing') }}#donasi" class="mt-2 inline-block text-slate-700 underline text-sm">Donasi sekarang</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @if(method_exists($donasi, 'hasPages') && $donasi->hasPages())
    <div class="px-6 py-4 border-t border-slate-100">{{ $donasi->links() }}</div>
    @endif
</div>

@endsection
