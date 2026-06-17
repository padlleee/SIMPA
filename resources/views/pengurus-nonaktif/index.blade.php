@extends('layouts.app')

@section('title', 'Arsip Pengurus')
@section('page-title', 'Arsip Pengurus Non-Aktif')
@section('page-subtitle', 'Daftar pengurus yang sudah tidak aktif / demisioner')

@section('content')

@if(session('success'))
<div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center justify-between">
    <div class="flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        <span class="text-sm font-medium">{{ session('success') }}</span>
    </div>
</div>
@endif

<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
    <div></div>
    <a href="{{ route('admin.pengurus-nonaktif.create') }}" class="bg-slate-800 text-white px-5 py-2.5 rounded-xl text-sm font-medium hover:bg-slate-700 transition-colors flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Data
    </a>
</div>

<!-- Tabel Daftar -->
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
        <h3 class="font-bold text-slate-800">Daftar Pengurus Non-Aktif</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-100 bg-slate-50">
                    <th class="text-left px-6 py-4 font-semibold text-slate-600 whitespace-nowrap">Nama Lengkap</th>
                    <th class="text-left px-4 py-4 font-semibold text-slate-600 whitespace-nowrap">Jabatan Terakhir</th>
                    <th class="text-left px-4 py-4 font-semibold text-slate-600 whitespace-nowrap">Thn Non-Aktif</th>
                    <th class="text-right px-6 py-4 font-semibold text-slate-600 whitespace-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($pengurus as $item)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4 font-medium text-slate-800 whitespace-nowrap">{{ $item->nama }}</td>
                    <td class="px-4 py-4 text-slate-600 whitespace-nowrap">{{ $item->jabatan_terakhir ?? '-' }}</td>
                    <td class="px-4 py-4 text-slate-600 whitespace-nowrap">{{ $item->tahun_nonaktif ?? '-' }}</td>
                    <td class="px-6 py-4 text-right whitespace-nowrap">
                        <form id="del-{{ $item->id }}" action="{{ route('admin.pengurus-nonaktif.destroy', $item->id) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="button" class="text-slate-400 hover:text-red-600 p-2 rounded-lg hover:bg-red-50 transition-colors"
                                onclick="simpaConfirm({ title:'Hapus Data', message:'Hapus {{ addslashes($item->nama) }} dari arsip?', confirmText:'Ya, Hapus', type:'danger', onConfirm:()=>document.getElementById('del-{{ $item->id }}').submit() })">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center text-slate-400">
                        <p>Belum ada data pengurus non-aktif.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
