@extends('layouts.app')

@section('title', 'Manajemen Donasi')
@section('page-title', 'Manajemen Donasi')
@section('page-subtitle', 'Verifikasi dan kelola semua donasi masuk')

@section('content')

{{-- Statistics Cards --}}
@php $stats = (new \App\Http\Controllers\DonasiController)->getAdminStats(); @endphp
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
        <p class="text-slate-500 text-xs font-semibold uppercase tracking-wider mb-1">Menunggu</p>
        <p class="text-3xl font-bold text-amber-500">{{ $stats['pending'] }}</p>
    </div>
    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
        <p class="text-slate-500 text-xs font-semibold uppercase tracking-wider mb-1">Terverifikasi</p>
        <p class="text-3xl font-bold text-green-600">{{ $stats['verified'] }}</p>
    </div>
    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
        <p class="text-slate-500 text-xs font-semibold uppercase tracking-wider mb-1">Ditolak</p>
        <p class="text-3xl font-bold text-red-500">{{ $stats['rejected'] }}</p>
    </div>
    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
        <p class="text-slate-500 text-xs font-semibold uppercase tracking-wider mb-1">Total Saldo</p>
        <p class="text-xl font-bold text-slate-800">{{ $stats['totalDonations_formatted'] }}</p>
    </div>
</div>

{{-- Filter & Actions --}}
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 mb-6 flex flex-col xl:flex-row gap-4 justify-between items-start xl:items-end">
    <form method="GET" class="flex flex-wrap gap-4 items-end">
        <input type="hidden" name="type" value="{{ $type }}">
        <div class="flex-1 min-w-[140px]">
            <label class="block text-xs font-semibold text-slate-500 uppercase mb-1">Status</label>
            <select name="status" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-slate-500">
                <option value="">Semua Status</option>
                <option value="Pending" @selected(request('status') === 'Pending')>Menunggu</option>
                <option value="Valid" @selected(request('status') === 'Valid')>Terverifikasi</option>
                <option value="Tolak" @selected(request('status') === 'Tolak')>Ditolak</option>
            </select>
        </div>
        <div class="flex-1 min-w-[140px]">
            <label class="block text-xs font-semibold text-slate-500 uppercase mb-1">Dari Tanggal</label>
            <input type="date" name="dari_tanggal" value="{{ request('dari_tanggal') }}" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm">
        </div>
        <div class="flex-1 min-w-[140px]">
            <label class="block text-xs font-semibold text-slate-500 uppercase mb-1">Sampai Tanggal</label>
            <input type="date" name="sampai_tanggal" value="{{ request('sampai_tanggal') }}" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm">
        </div>
        <div class="flex gap-2">
            <button type="submit" class="px-5 py-2 bg-slate-800 text-white rounded-lg text-sm hover:bg-slate-700 transition">Filter</button>
            <a href="{{ route('donasi.index', ['type' => $type]) }}" class="px-5 py-2 bg-slate-100 text-slate-700 rounded-lg text-sm hover:bg-slate-200 transition">Reset</a>
        </div>
    </form>
    <a href="{{ route('donasi.adminCreate') }}" class="px-5 py-2.5 bg-green-600 text-white rounded-lg text-sm font-semibold hover:bg-green-700 transition flex items-center gap-2 whitespace-nowrap">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Donasi Tunai
    </a>
</div>

{{-- Tab Navigation --}}
<div class="flex gap-1 mb-0 bg-white rounded-t-2xl border border-b-0 border-slate-200 p-1">
    <a href="{{ route('donasi.index', array_merge(request()->except('type', 'page'), ['type' => 'all'])) }}"
       class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold transition
              {{ $type === 'all' ? 'bg-slate-800 text-white' : 'text-slate-500 hover:bg-slate-100' }}">
        Semua
        <span class="inline-flex items-center justify-center min-w-5 h-5 px-1.5 rounded-full text-xs {{ $type === 'all' ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-600' }}">
            {{ $memberCount + $publicCount }}
        </span>
    </a>
    <a href="{{ route('donasi.index', array_merge(request()->except('type', 'page'), ['type' => 'member'])) }}"
       class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold transition
              {{ $type === 'member' ? 'bg-blue-600 text-white' : 'text-slate-500 hover:bg-slate-100' }}">
        Donatur Terdaftar
        <span class="inline-flex items-center justify-center min-w-5 h-5 px-1.5 rounded-full text-xs {{ $type === 'member' ? 'bg-white/20 text-white' : 'bg-blue-100 text-blue-700' }}">
            {{ $memberCount }}
        </span>
    </a>
    <a href="{{ route('donasi.index', array_merge(request()->except('type', 'page'), ['type' => 'public'])) }}"
       class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold transition
              {{ $type === 'public' ? 'bg-slate-600 text-white' : 'text-slate-500 hover:bg-slate-100' }}">
        Donasi Publik
        <span class="inline-flex items-center justify-center min-w-5 h-5 px-1.5 rounded-full text-xs {{ $type === 'public' ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-600' }}">
            {{ $publicCount }}
        </span>
    </a>
</div>

{{-- Table --}}
<div class="bg-white rounded-b-2xl rounded-tr-2xl border border-slate-200 shadow-sm overflow-hidden">
    @if($donasi->count() > 0)
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider whitespace-nowrap">Donatur</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider whitespace-nowrap">Nominal</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider whitespace-nowrap">Metode</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider whitespace-nowrap">Tanggal</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider whitespace-nowrap">Status</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider whitespace-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($donasi as $item)
                <tr class="hover:bg-slate-50 transition-colors">
                    {{-- Donor Column --}}
                    <td class="px-5 py-4">
                        <div class="font-semibold text-slate-800">{{ $item->nama_donatur_display }}</div>
                        @if($item->user)
                            {{-- Registered Donor --}}
                            <div class="text-xs text-slate-400 mt-0.5">{{ $item->user->email ?? '-' }}</div>
                            @if($item->user->donatur?->no_hp)
                            <div class="text-xs text-slate-400">{{ $item->user->donatur->no_hp }}</div>
                            @endif
                            <span class="inline-block mt-1 px-2 py-0.5 bg-blue-50 text-blue-700 border border-blue-100 rounded text-[10px] font-bold uppercase">
                                Terdaftar
                            </span>
                        @else
                            {{-- Public Donor --}}
                            <div class="text-xs text-slate-400 mt-0.5">{{ $item->email_donatur_manual ?? '-' }}</div>
                            <span class="inline-block mt-1 px-2 py-0.5 bg-slate-100 text-slate-600 border border-slate-200 rounded text-[10px] font-bold uppercase">
                                Publik
                            </span>
                        @endif
                    </td>
                    {{-- Nominal --}}
                    <td class="px-5 py-4 font-bold text-slate-800 whitespace-nowrap">{{ $item->nominal_formatted }}</td>
                    {{-- Metode --}}
                    <td class="px-5 py-4 whitespace-nowrap">
                        <span class="inline-block px-2.5 py-1 bg-slate-100 text-slate-700 rounded-full text-xs font-medium">
                            {{ $item->metode_pembayaran }}
                        </span>
                    </td>
                    {{-- Tanggal --}}
                    <td class="px-5 py-4 text-slate-500 text-xs whitespace-nowrap">
                        {{ $item->tanggal_donasi?->locale('id_ID')?->translatedFormat('j M Y') ?? '-' }}
                    </td>
                    {{-- Status --}}
                    <td class="px-5 py-4 whitespace-nowrap">
                        @if($item->status_verifikasi === 'Pending')
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-semibold">⏳ Menunggu</span>
                        @elseif($item->status_verifikasi === 'Valid')
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold"> Terverifikasi</span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold"> Ditolak</span>
                        @endif
                    </td>
                    {{-- Aksi --}}
                    <td class="px-5 py-4 whitespace-nowrap">
                        <a href="{{ route('donasi.show', $item) }}"
                           class="inline-flex items-center gap-1 px-3 py-1.5 bg-slate-800 text-white rounded-lg text-xs font-semibold hover:bg-slate-700 transition">
                            Detail
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="px-5 py-4 border-t border-slate-100">
        {{ $donasi->links('pagination::tailwind') }}
    </div>
    @else
    <div class="py-16 text-center text-slate-400">
        <div class="text-5xl mb-4">📭</div>
        <p class="font-medium text-slate-500">Tidak ada donasi ditemukan</p>
        <p class="text-sm mt-1">Coba ubah filter atau tab yang dipilih.</p>
    </div>
    @endif
</div>

@endsection
