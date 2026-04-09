@extends('layouts.app')

@section('title', 'Detail Donasi')
@section('page-title', 'Detail Donasi')
@section('page-subtitle', 'Informasi lengkap donasi')

@section('content')
<div class="max-w-2xl">
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="p-8">
        <div class="flex items-center justify-between mb-8">
            <h3 class="text-lg font-bold text-slate-800">Donasi #{{ $donasi->id_donasi }}</h3>
            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold {{ $donasi->status_verifikasi === 'Success' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                {{ $donasi->status_verifikasi === 'Success' ? '✓ Terverifikasi' : '⏳ Menunggu Verifikasi' }}
            </span>
        </div>

        <div class="space-y-5">
            <div class="flex justify-between py-3 border-b border-slate-100">
                <span class="text-slate-500 text-sm">Donatur</span>
                <span class="font-semibold text-slate-800">{{ $donasi->donatur?->nama_donatur ?? '-' }}</span>
            </div>
            <div class="flex justify-between py-3 border-b border-slate-100">
                <span class="text-slate-500 text-sm">Nominal</span>
                <span class="font-bold text-slate-800 text-lg">Rp {{ number_format($donasi->nominal, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between py-3 border-b border-slate-100">
                <span class="text-slate-500 text-sm">Tanggal Donasi</span>
                <span class="font-medium text-slate-800">{{ $donasi->tanggal_donasi?->isoFormat('D MMMM Y') ?? '-' }}</span>
            </div>
            @if($donasi->bendahara)
            <div class="flex justify-between py-3 border-b border-slate-100">
                <span class="text-slate-500 text-sm">Diverifikasi oleh</span>
                <span class="font-medium text-slate-800">{{ $donasi->bendahara->username }}</span>
            </div>
            @endif
        </div>

        @if($donasi->bukti_pembayaran)
        <div class="mt-8">
            <p class="text-sm font-semibold text-slate-700 mb-3">Bukti Pembayaran</p>
            @php $ext = pathinfo($donasi->bukti_pembayaran, PATHINFO_EXTENSION); @endphp
            @if(in_array(strtolower($ext), ['jpg', 'jpeg', 'png']))
            <img src="{{ Storage::url($donasi->bukti_pembayaran) }}" alt="Bukti Pembayaran"
                 class="w-full max-w-sm rounded-xl border border-slate-200 shadow-sm">
            @else
            <a href="{{ Storage::url($donasi->bukti_pembayaran) }}" target="_blank"
               class="inline-flex items-center gap-2 text-slate-700 bg-slate-100 px-4 py-2.5 rounded-xl hover:bg-slate-200 transition-colors text-sm font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Lihat File PDF
            </a>
            @endif
        </div>
        @endif

        <div class="flex gap-3 mt-8">
            @if($donasi->status_verifikasi === 'Pending')
            <form action="{{ route('donasi.verify', $donasi) }}" method="POST">
                @csrf @method('PATCH')
                <button type="submit" class="bg-green-600 text-white px-6 py-2.5 rounded-xl font-semibold hover:bg-green-700 transition-colors"
                        onclick="return confirm('Verifikasi donasi ini?')">
                    ✓ Verifikasi Donasi
                </button>
            </form>
            @endif
            <a href="{{ route('donasi.index') }}" class="bg-slate-100 text-slate-700 px-6 py-2.5 rounded-xl font-semibold hover:bg-slate-200 transition-colors">Kembali</a>
        </div>
    </div>
</div>
</div>
@endsection
