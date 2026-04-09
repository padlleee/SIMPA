@extends('layouts.app')

@section('title', 'Donasi')
@section('page-title', 'Data Donasi')
@section('page-subtitle', 'Daftar semua donasi masuk dan status verifikasi')

@section('content')

<!-- Filter -->
<div class="flex flex-wrap gap-3 mb-6">
    <a href="{{ route('donasi.index') }}" class="px-5 py-2.5 rounded-xl text-sm font-medium transition-colors {{ !request('status') ? 'bg-slate-800 text-white' : 'bg-white border border-slate-300 text-slate-700 hover:bg-slate-50' }}">
        Semua
    </a>
    <a href="{{ route('donasi.index', ['status' => 'Pending']) }}" class="px-5 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request('status') == 'Pending' ? 'bg-slate-800 text-white' : 'bg-white border border-slate-300 text-slate-700 hover:bg-slate-50' }}">
        Pending
    </a>
    <a href="{{ route('donasi.index', ['status' => 'Success']) }}" class="px-5 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request('status') == 'Success' ? 'bg-slate-800 text-white' : 'bg-white border border-slate-300 text-slate-700 hover:bg-slate-50' }}">
        Terverifikasi
    </a>
</div>

<!-- Table -->
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-slate-100 bg-slate-50">
                <th class="text-left px-6 py-4 font-semibold text-slate-600">Donatur</th>
                <th class="text-left px-4 py-4 font-semibold text-slate-600">Nominal</th>
                <th class="text-left px-4 py-4 font-semibold text-slate-600">Tanggal</th>
                <th class="text-left px-4 py-4 font-semibold text-slate-600">Status</th>
                <th class="text-right px-6 py-4 font-semibold text-slate-600">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($donasi as $item)
            <tr class="hover:bg-slate-50 transition-colors">
                <td class="px-6 py-4 font-medium text-slate-800">{{ $item->donatur?->nama_donatur ?? '-' }}</td>
                <td class="px-4 py-4 font-semibold text-slate-800">Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                <td class="px-4 py-4 text-slate-600">{{ $item->tanggal_donasi?->format('d M Y') ?? '-' }}</td>
                <td class="px-4 py-4">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $item->status_verifikasi === 'Success' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                        {{ $item->status_verifikasi === 'Success' ? 'Terverifikasi' : 'Menunggu' }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('donasi.show', $item) }}" class="p-2 text-slate-500 hover:text-slate-800 hover:bg-slate-100 rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </a>
                        @if($item->status_verifikasi === 'Pending')
                        <form action="{{ route('donasi.verify', $item) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" class="px-3 py-1.5 text-xs font-semibold bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors"
                                    onclick="return confirm('Verifikasi donasi ini?')">
                                Verifikasi
                            </button>
                        </form>
                        @endif
                        <form action="{{ route('donasi.destroy', $item) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                    onclick="return confirm('Hapus donasi ini?')">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-16 text-center text-slate-400">
                    <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    <p class="font-medium">Belum ada donasi</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @if($donasi->hasPages())
    <div class="px-6 py-4 border-t border-slate-100">{{ $donasi->links() }}</div>
    @endif
</div>
@endsection
