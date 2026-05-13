@extends('layouts.app')

@section('title', 'Detail Anak Asuh')
@section('page-title', 'Detail Anak Asuh')
@section('page-subtitle', 'Informasi lengkap data anak asuh')

@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-6">
        <div class="p-8">
            <div class="flex items-start justify-between mb-8">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center flex-shrink-0 text-slate-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-slate-800">{{ $anakAsuh->nama_anak }}</h2>
                        <div class="flex items-center gap-3 mt-1">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $anakAsuh->status_anak === 'Aktif' ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600' }}">
                                {{ $anakAsuh->status_anak }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('anak-asuh.edit', $anakAsuh) }}" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-xl text-sm font-medium hover:bg-slate-200 transition-colors">
                        Edit Data
                    </a>
                </div>
            </div>

            <div class="grid sm:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-4">Informasi Dasar</h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-xs text-slate-500 mb-1">Tempat, Tanggal Lahir</p>
                            <p class="font-medium text-slate-800">{{ $anakAsuh->tempat_lahir ?? '-' }}, {{ $anakAsuh->tanggal_lahir?->isoFormat('D MMMM Y') ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 mb-1">Jenis Kelamin</p>
                            <p class="font-medium text-slate-800">{{ $anakAsuh->jenis_kelamin_label }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 mb-1">Pendidikan / Kelas</p>
                            <p class="font-medium text-slate-800">{{ $anakAsuh->pendidikan ?? '-' }} {{ $anakAsuh->kelas ? ' - ' . $anakAsuh->kelas : '' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 mb-1">Tanggal Masuk</p>
                            <p class="font-medium text-slate-800">{{ $anakAsuh->tanggal_masuk?->isoFormat('D MMMM Y') ?? '-' }}</p>
                        </div>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-4">Catatan Tambahan</h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-xs text-slate-500 mb-1">Perkembangan Akademik</p>
                            <p class="font-medium text-slate-800">{{ $anakAsuh->perkembangan_akademik ?? 'Belum ada catatan akademik' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 mb-1">Catatan Kesehatan</p>
                            <p class="font-medium text-slate-800">{{ $anakAsuh->catatan_kesehatan ?? 'Belum ada catatan kesehatan' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <a href="{{ route('anak-asuh.index') }}" class="text-slate-500 hover:text-slate-800 text-sm font-medium transition-colors">
        &larr; Kembali ke Daftar Anak Asuh
    </a>
</div>
@endsection
