@extends('layouts.app')

@section('title', 'Ringkasan Per Donatur')
@section('page-title', 'Ringkasan Per Donatur')
@section('page-subtitle', 'Total kontribusi donasi dikelompokkan per donatur')

@section('content')

{{-- Summary Cards --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
        <p class="text-slate-500 text-xs font-semibold uppercase tracking-wider mb-1">Donatur Terdaftar</p>
        <p class="text-3xl font-bold text-blue-600">{{ $memberDonors->count() }}</p>
        <p class="text-xs text-slate-400 mt-1">Total: Rp {{ number_format($memberDonors->sum('total_valid'), 0, ',', '.') }}</p>
    </div>
    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
        <p class="text-slate-500 text-xs font-semibold uppercase tracking-wider mb-1">Donatur Publik</p>
        <p class="text-3xl font-bold text-slate-600">{{ $publicDonors->count() }}</p>
        <p class="text-xs text-slate-400 mt-1">Total: Rp {{ number_format($publicDonors->sum('total_valid'), 0, ',', '.') }}</p>
    </div>
    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
        <p class="text-slate-500 text-xs font-semibold uppercase tracking-wider mb-1">Grand Total Donasi Masuk</p>
        <p class="text-xl font-bold text-slate-800">Rp {{ number_format($grandTotal, 0, ',', '.') }}</p>
        <p class="text-xs text-slate-400 mt-1">Hanya donasi terverifikasi</p>
    </div>
</div>

{{-- Nav back + link --}}
<div class="mb-4 flex items-center gap-3">
    <a href="{{ route('donasi.index') }}" class="flex items-center gap-2 px-4 py-2 bg-slate-100 text-slate-600 rounded-lg text-sm font-medium hover:bg-slate-200 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Kembali ke Manajemen Donasi
    </a>
</div>

{{-- Tabel Donatur Terdaftar --}}
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-8">
    <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-3">
        <span class="inline-block w-3 h-3 bg-blue-500 rounded-full"></span>
        <h2 class="font-semibold text-slate-800 text-sm">Donatur Terdaftar (Akun Aktif)</h2>
        <span class="ml-auto text-xs text-slate-400">{{ $memberDonors->count() }} donatur</span>
    </div>
    @if($memberDonors->count() > 0)
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama Donatur</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Email</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">No. HP</th>
                    <th class="px-5 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Jml. Transaksi</th>
                    <th class="px-5 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Donasi</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Donasi Terakhir</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($memberDonors as $donor)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-5 py-4">
                        <div class="font-semibold text-slate-800">{{ $donor->nama }}</div>
                        <span class="inline-block mt-0.5 px-2 py-0.5 bg-blue-50 text-blue-700 border border-blue-100 rounded text-[10px] font-bold uppercase">Terdaftar</span>
                    </td>
                    <td class="px-5 py-4 text-slate-600 text-xs">{{ $donor->email }}</td>
                    <td class="px-5 py-4 text-slate-500 text-xs">{{ $donor->no_hp ?? '-' }}</td>
                    <td class="px-5 py-4 text-right">
                        <span class="inline-flex items-center justify-center min-w-8 h-7 px-2 bg-slate-100 text-slate-700 rounded-full text-xs font-bold">
                            {{ $donor->jumlah_donasi }}
                        </span>
                    </td>
                    <td class="px-5 py-4 text-right font-bold text-slate-800 whitespace-nowrap">
                        Rp {{ number_format($donor->total_valid, 0, ',', '.') }}
                    </td>
                    <td class="px-5 py-4 text-slate-500 text-xs whitespace-nowrap">
                        {{ $donor->terakhir_donasi ? \Carbon\Carbon::parse($donor->terakhir_donasi)->translatedFormat('j M Y') : '-' }}
                    </td>
                    <td class="px-5 py-4">
                        <a href="{{ route('donasi.index', ['type' => 'member', 'donatur_id' => $donor->id_user]) }}"
                           class="inline-flex items-center gap-1 px-3 py-1.5 bg-slate-800 text-white rounded-lg text-xs font-semibold hover:bg-slate-700 transition">
                            Lihat Donasi
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="py-12 text-center text-slate-400">
        <p class="font-medium">Belum ada donatur terdaftar</p>
    </div>
    @endif
</div>

{{-- Tabel Donatur Publik --}}
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-3">
        <span class="inline-block w-3 h-3 bg-slate-400 rounded-full"></span>
        <h2 class="font-semibold text-slate-800 text-sm">Donatur Publik (Belum Memiliki Akun)</h2>
        <span class="ml-auto text-xs text-slate-400">{{ $publicDonors->count() }} donatur</span>
    </div>
    @if($publicDonors->count() > 0)
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama Donatur</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Email</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">No. HP</th>
                    <th class="px-5 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Jml. Transaksi</th>
                    <th class="px-5 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Donasi</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Donasi Terakhir</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($publicDonors as $donor)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-5 py-4">
                        <div class="font-semibold text-slate-800">{{ $donor->nama }}</div>
                        <span class="inline-block mt-0.5 px-2 py-0.5 bg-slate-100 text-slate-600 border border-slate-200 rounded text-[10px] font-bold uppercase">Publik</span>
                    </td>
                    <td class="px-5 py-4 text-slate-600 text-xs">{{ $donor->email ?? '-' }}</td>
                    <td class="px-5 py-4 text-slate-500 text-xs">{{ $donor->no_hp ?? '-' }}</td>
                    <td class="px-5 py-4 text-right">
                        <span class="inline-flex items-center justify-center min-w-8 h-7 px-2 bg-slate-100 text-slate-700 rounded-full text-xs font-bold">
                            {{ $donor->jumlah_donasi }}
                        </span>
                    </td>
                    <td class="px-5 py-4 text-right font-bold text-slate-800 whitespace-nowrap">
                        Rp {{ number_format($donor->total_valid, 0, ',', '.') }}
                    </td>
                    <td class="px-5 py-4 text-slate-500 text-xs whitespace-nowrap">
                        {{ $donor->terakhir_donasi ? \Carbon\Carbon::parse($donor->terakhir_donasi)->translatedFormat('j M Y') : '-' }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="py-12 text-center text-slate-400">
        <p class="font-medium">Belum ada donasi publik</p>
    </div>
    @endif
</div>

@endsection
