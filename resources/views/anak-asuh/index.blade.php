@extends('layouts.app')

@section('title', 'Anak Asuh')
@section('page-title', 'Data Anak Asuh')
@section('page-subtitle', 'Daftar seluruh anak asuh panti')

@section('content')

<!-- Search & Actions -->
<div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 mb-6">
    <form action="{{ route('anak-asuh.index') }}" method="GET" class="flex gap-3 flex-1">
        <div class="relative flex-1 max-w-sm">
            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama/kata kunci..."
                   class="w-full pl-10 pr-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-slate-800">
        </div>
        <select name="status" class="border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-slate-800">
            <option value="">Semua Status</option>
            <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
            <option value="Alumni" {{ request('status') == 'Alumni' ? 'selected' : '' }}>Alumni</option>
        </select>
        <button type="submit" class="bg-slate-800 text-white px-5 py-2.5 rounded-xl text-sm font-medium hover:bg-slate-700 transition-colors">Filter</button>
    </form>
    <a href="{{ route('anak-asuh.create') }}" class="bg-slate-800 text-white px-5 py-2.5 rounded-xl text-sm font-medium hover:bg-slate-700 transition-colors flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Anak
    </a>
</div>

<!-- Table -->
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-100 bg-slate-50">
                    <th class="text-left px-6 py-4 font-semibold text-slate-600 whitespace-nowrap">Nama</th>
                    <th class="text-left px-4 py-4 font-semibold text-slate-600 whitespace-nowrap">Tgl Lahir</th>
                    <th class="text-left px-4 py-4 font-semibold text-slate-600 whitespace-nowrap">JK</th>
                    <th class="text-left px-4 py-4 font-semibold text-slate-600 whitespace-nowrap">Pendidikan</th>
                    <th class="text-left px-4 py-4 font-semibold text-slate-600 whitespace-nowrap">Tgl Masuk</th>
                    <th class="text-left px-4 py-4 font-semibold text-slate-600 whitespace-nowrap">Status</th>
                    <th class="text-right px-6 py-4 font-semibold text-slate-600 whitespace-nowrap">Aksi</th>
                </tr>
            </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($anakAsuh as $anak)
            <tr class="hover:bg-slate-50 transition-colors">
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-slate-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <div>
                            <div class="font-semibold text-slate-800">{{ $anak->nama_anak }}</div>
                            <div class="text-slate-400 text-xs">{{ $anak->tempat_lahir }}</div>
                        </div>
                    </div>
                </td>
                <td class="px-4 py-4 text-slate-600 whitespace-nowrap">{{ $anak->tanggal_lahir?->format('d/m/Y') }}</td>
                <td class="px-4 py-4 text-slate-600 whitespace-nowrap">{{ $anak->jenis_kelamin === 'L' ? 'L' : 'P' }}</td>
                <td class="px-4 py-4 text-slate-600 whitespace-nowrap">{{ $anak->pendidikan ?? '-' }}</td>
                <td class="px-4 py-4 text-slate-600 whitespace-nowrap">{{ $anak->tanggal_masuk?->format('d/m/Y') }}</td>
                <td class="px-4 py-4 whitespace-nowrap">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $anak->status_anak === 'Aktif' ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600' }}">
                        {{ $anak->status_anak }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center justify-end gap-2">
                        <!-- Toggle Status -->
                        <form id="toggleForm-{{ $anak->id_anak }}" action="{{ route('anak-asuh.toggle-status', $anak) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="button" class="text-xs px-3 py-1.5 rounded-lg border font-medium transition-colors {{ $anak->status_anak === 'Aktif' ? 'border-slate-300 text-slate-600 hover:bg-slate-100' : 'border-green-300 text-green-700 hover:bg-green-50' }}"
                                    onclick="simpaConfirm({ title:'Ubah Status', message:'Ubah status {{ addslashes($anak->nama_anak) }} menjadi {{ $anak->status_anak === 'Aktif' ? 'Alumni' : 'Aktif' }}?', confirmText:'Ya, Ubah', type:'default', onConfirm:()=>document.getElementById('toggleForm-{{ $anak->id_anak }}').submit() })">
                                {{ $anak->status_anak === 'Aktif' ? '→ Alumni' : '→ Aktif' }}
                            </button>
                        </form>
                        <a href="{{ route('anak-asuh.edit', $anak) }}" class="p-2 text-slate-500 hover:text-slate-800 hover:bg-slate-100 rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>
                        <form id="anakDel-{{ $anak->id_anak }}" action="{{ route('anak-asuh.destroy', $anak) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="button" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                    onclick="simpaConfirm({ title:'Hapus Data Anak', message:'Hapus data {{ addslashes($anak->nama_anak) }}? Tindakan ini tidak dapat dibatalkan.', confirmText:'Ya, Hapus', type:'danger', onConfirm:()=>document.getElementById('anakDel-{{ $anak->id_anak }}').submit() })">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-6 py-16 text-center text-slate-400">
                    <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <p class="font-medium">Tidak ada data anak asuh</p>
                    <a href="{{ route('anak-asuh.create') }}" class="mt-3 inline-block text-sm text-slate-700 underline">Tambah sekarang</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    </div>

    @if($anakAsuh->hasPages())
    <div class="px-6 py-4 border-t border-slate-100">
        {{ $anakAsuh->links() }}
    </div>
    @endif
</div>

@endsection
