{{-- ============================================================
     View: resources/views/donatur/perpustakaan-show.blade.php
     Donatur Book Detail & Loan Checkout Form
     Route: GET /donatur/perpustakaan/{buku}
     Controller: DonaturController@perpustakaanShow
     ============================================================ --}}
@extends('layouts.app')

@section('title', $buku->judul_buku)
@section('page-title', 'Detail Buku')
@section('page-subtitle', 'Informasi buku & formulir peminjaman')

@push('styles')
<style>
    /* ── Deposit Tier Selector ── */
    .deposit-option input[type="radio"] { display: none; }
    .deposit-option label {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 16px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        cursor: pointer;
        transition: border-color 0.15s, background 0.15s;
        font-size: 0.875rem;
        font-weight: 500;
        color: #475569;
    }
    .deposit-option input[type="radio"]:checked + label {
        border-color: #1e293b;
        background: #f8fafc;
        color: #0f172a;
    }
    .deposit-option label .radio-dot {
        width: 18px; height: 18px;
        border: 2px solid #cbd5e1;
        border-radius: 50%;
        flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        transition: border-color 0.15s;
    }
    .deposit-option input[type="radio"]:checked + label .radio-dot {
        border-color: #1e293b;
        background: #1e293b;
    }
    .deposit-option input[type="radio"]:checked + label .radio-dot::after {
        content: '';
        display: block;
        width: 7px; height: 7px;
        border-radius: 50%;
        background: white;
    }

    /* ── Status Badge ── */
    .badge-tersedia  { background: #dcfce7; color: #166534; }
    .badge-habis     { background: #fee2e2; color: #991b1b; }
    .badge-pending   { background: #fef9c3; color: #854d0e; }

    /* ── Sticky checkout panel ── */
    @media (min-width: 1024px) {
        .sticky-panel {
            position: sticky;
            top: 96px;
        }
    }

    /* ── Return date calendar style ── */
    input[type="date"]::-webkit-calendar-picker-indicator {
        opacity: 0.5;
        cursor: pointer;
    }
</style>
@endpush

@section('content')

{{-- ── Breadcrumb ── --}}
<div class="flex items-center gap-2 text-sm text-slate-400 mb-6">
    <a href="{{ route('donatur.dashboard') }}" class="hover:text-slate-700 transition-colors">Dashboard</a>
    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <a href="{{ route('donatur.perpustakaan.index') }}" class="hover:text-slate-700 transition-colors">Perpustakaan</a>
    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <span class="text-slate-600 font-medium truncate max-w-xs">{{ $buku->judul_buku }}</span>
</div>


{{-- ── Main Grid ── --}}
<div class="grid lg:grid-cols-3 gap-6 items-start">

    {{-- ============================================================ --}}
    {{-- LEFT COLUMN: Cover + Metadata + History                      --}}
    {{-- ============================================================ --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Book Detail Card --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="flex flex-col sm:flex-row gap-0">

                {{-- Cover --}}
                <div class="sm:w-52 flex-shrink-0">
                    @if($buku->foto_buku && file_exists(public_path('storage/' . $buku->foto_buku)))
                        <img src="{{ asset('storage/' . $buku->foto_buku) }}"
                             alt="{{ $buku->judul_buku }}"
                             class="w-full h-64 sm:h-full object-cover">
                    @else
                        <div class="w-full h-64 sm:h-full bg-gradient-to-br from-slate-700 to-slate-500 flex flex-col items-center justify-center min-h-[200px]">
                            <svg class="w-16 h-16 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 17.477 5.754 17 7.5 17s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 17.477 18.247 17 16.5 17c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            <span class="text-slate-400 text-sm mt-3">Tidak ada sampul</span>
                        </div>
                    @endif
                </div>

                {{-- Info --}}
                <div class="flex-1 p-6 sm:p-8">
                    {{-- Category + Availability --}}
                    <div class="flex flex-wrap items-center gap-2 mb-4">
                        @if($buku->kategori)
                            <span class="text-xs font-semibold text-slate-500 bg-slate-100 px-3 py-1 rounded-full uppercase tracking-wider">
                                {{ $buku->kategori }}
                            </span>
                        @endif
                        @php $tersedia = max(0, $buku->jumlah_buku - ($buku->peminjamanAktifTotal())); @endphp
                        <span class="text-xs font-semibold px-3 py-1 rounded-full {{ $tersedia > 0 ? 'badge-tersedia' : 'badge-habis' }}">
                            {{ $tersedia > 0 ? "Tersedia ({$tersedia} eks.)" : 'Semua Dipinjam' }}
                        </span>
                    </div>

                    {{-- Title --}}
                    <h1 class="text-2xl font-bold text-slate-800 leading-tight mb-1">
                        {{ $buku->judul_buku }}
                    </h1>
                    <p class="text-slate-500 text-sm mb-5">
                        {{ $buku->penulis ?? 'Penulis tidak diketahui' }}
                        @if($buku->penerbit) · <span class="italic">{{ $buku->penerbit }}</span>@endif
                        @if($buku->tahun_terbit) · {{ $buku->tahun_terbit }}@endif
                    </p>

                    {{-- Meta grid --}}
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mb-6">
                        <div class="bg-slate-50 rounded-xl px-4 py-3">
                            <div class="text-xs text-slate-400 mb-0.5">Total Eksemplar</div>
                            <div class="text-lg font-bold text-slate-800">{{ $buku->jumlah_buku }}</div>
                        </div>
                        <div class="bg-slate-50 rounded-xl px-4 py-3">
                            <div class="text-xs text-slate-400 mb-0.5">Sedang Dipinjam</div>
                            <div class="text-lg font-bold text-amber-600">{{ $buku->jumlah_buku - $tersedia }}</div>
                        </div>
                        <div class="bg-slate-50 rounded-xl px-4 py-3">
                            <div class="text-xs text-slate-400 mb-0.5">Tersedia</div>
                            <div class="text-lg font-bold {{ $tersedia > 0 ? 'text-green-600' : 'text-red-500' }}">{{ $tersedia }}</div>
                        </div>
                    </div>

                    {{-- Sinopsis / Deskripsi --}}
                    @if($buku->deskripsi)
                    <div>
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Sinopsis</p>
                        <p class="text-slate-600 text-sm leading-relaxed">{{ $buku->deskripsi }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ── Riwayat Peminjaman Saya ── --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-bold text-slate-800 text-base">Riwayat Peminjaman Saya</h2>
                <span class="text-xs text-slate-400 bg-slate-100 px-2.5 py-1 rounded-full font-semibold">
                    {{ $riwayatSaya->count() }} transaksi
                </span>
            </div>

            @forelse($riwayatSaya as $trx)
            <div class="flex items-center gap-4 py-3 {{ !$loop->last ? 'border-b border-slate-100' : '' }}">
                {{-- Status Icon --}}
                <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0
                    {{ $trx->status === 'Dipinjam' ? 'bg-blue-100' :
                       ($trx->status === 'Kembali'  ? 'bg-green-100' :
                       ($trx->status === 'Pending'  ? 'bg-amber-100' : 'bg-red-100')) }}">
                    @if($trx->status === 'Dipinjam')
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13"/>
                        </svg>
                    @elseif($trx->status === 'Kembali')
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    @elseif($trx->status === 'Pending')
                        <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    @else
                        <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    @endif
                </div>

                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2">
                        <span class="text-sm font-semibold text-slate-700">{{ $trx->status }}</span>
                        @if($trx->terlambat)
                            <span class="text-xs bg-red-100 text-red-700 font-semibold px-2 py-0.5 rounded-full">Terlambat</span>
                        @endif
                    </div>
                    <div class="text-xs text-slate-400 mt-0.5">
                        Pinjam: {{ $trx->tanggal_pinjam?->format('d M Y') ?? '-' }}
                        @if($trx->tanggal_kembali)
                            · Target kembali: {{ $trx->tanggal_kembali->format('d M Y') }}
                        @endif
                    </div>
                </div>

                <div class="text-right flex-shrink-0">
                    <div class="text-sm font-bold text-slate-700">Rp {{ number_format($trx->dana_jaminan, 0, ',', '.') }}</div>
                    <div class="text-xs text-slate-400">Dana Jaminan</div>
                </div>
            </div>
            @empty
            <div class="text-center py-8 text-slate-400">
                <svg class="w-10 h-10 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 17.477 5.754 17 7.5 17s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 17.477 18.247 17 16.5 17c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <p class="text-sm font-medium">Belum pernah meminjam buku ini.</p>
            </div>
            @endforelse
        </div>

    </div>

    {{-- ============================================================ --}}
    {{-- RIGHT COLUMN (STICKY): Checkout Form                         --}}
    {{-- ============================================================ --}}
    <div class="sticky-panel space-y-4">

        {{-- ── Status & CTA Card ── --}}
        @php
            $sedangPinjam = $riwayatSaya->whereIn('status', ['Pending','Dipinjam'])->first();
        @endphp

        @if($sedangPinjam)
        {{-- Already has active loan --}}
        <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5">
            <div class="flex items-start gap-3">
                <div class="w-9 h-9 bg-amber-100 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5">
                    <svg class="w-4.5 h-4.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-amber-800 text-sm">Anda sedang meminjam buku ini</p>
                    <p class="text-amber-700 text-xs mt-1">
                        Status: <span class="font-bold">{{ $sedangPinjam->status }}</span>
                        @if($sedangPinjam->tanggal_kembali)
                            · Kembalikan sebelum <span class="font-bold">{{ $sedangPinjam->tanggal_kembali->format('d M Y') }}</span>
                        @endif
                    </p>
                    @if($sedangPinjam->terlambat)
                    <p class="text-red-600 text-xs font-semibold mt-1.5">
                        ⚠ Peminjaman Anda sudah terlambat {{ abs($sedangPinjam->sisa_hari) }} hari!
                    </p>
                    @endif
                </div>
            </div>
        </div>

        @elseif($tersedia <= 0)
        {{-- Out of stock --}}
        <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5 text-center">
            <div class="w-12 h-12 bg-slate-200 rounded-full flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                </svg>
            </div>
            <p class="font-semibold text-slate-700 text-sm">Semua Eksemplar Dipinjam</p>
            <p class="text-slate-500 text-xs mt-1">Silakan coba kembali nanti.</p>
        </div>

        @else
        {{-- ── CHECKOUT FORM ── --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

            {{-- Header --}}
            <div class="bg-slate-800 px-5 py-4">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-white/15 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-white font-bold text-sm">Formulir Peminjaman</div>
                        <div class="text-slate-400 text-xs">Loan Request Form</div>
                    </div>
                </div>
            </div>

            {{-- Form --}}
            <form action="{{ route('donatur.perpustakaan.checkout', $buku) }}"
                  method="POST" id="checkout-form" class="p-5 space-y-5">
                @csrf

                {{-- Book summary row --}}
                <div class="flex items-center gap-3 bg-slate-50 rounded-xl px-4 py-3 border border-slate-200">
                    <div class="w-9 h-9 bg-slate-200 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 17.477 5.754 17 7.5 17s3.332.477 4.5 1.253"/>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-slate-800 truncate">{{ $buku->judul_buku }}</p>
                        <p class="text-xs text-slate-400 truncate">{{ $buku->penulis ?? '-' }}</p>
                    </div>
                </div>

                {{-- ── Tanggal Kembali Target ── --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2" for="tanggal_kembali">
                        Tanggal Target Kembali
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="date"
                           id="tanggal_kembali"
                           name="tanggal_kembali"
                           min="{{ now()->addDays(1)->format('Y-m-d') }}"
                           max="{{ now()->addDays(30)->format('Y-m-d') }}"
                           value="{{ old('tanggal_kembali', now()->addDays(7)->format('Y-m-d')) }}"
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-slate-800 transition @error('tanggal_kembali') border-red-400 @enderror"
                           required>
                    @error('tanggal_kembali')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-slate-400 mt-1.5">
                        Maksimal peminjaman 30 hari dari hari ini
                        <span id="duration-label" class="font-semibold text-slate-600"></span>
                    </p>
                </div>

                {{-- ── Dana Jaminan ── --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Dana Jaminan <span class="text-red-500">*</span>
                        <span class="font-normal text-slate-400 text-xs ml-1">— dikembalikan saat buku kembali</span>
                    </label>

                    {{-- Preset options --}}
                    <div class="space-y-2 mb-3">
                        @foreach([10000, 25000, 50000, 100000] as $nominal)
                        <div class="deposit-option">
                            <input type="radio"
                                   id="deposit_{{ $nominal }}"
                                   name="dana_jaminan_preset"
                                   value="{{ $nominal }}"
                                   {{ old('dana_jaminan', 25000) == $nominal ? 'checked' : '' }}
                                   onchange="setDeposit({{ $nominal }})">
                            <label for="deposit_{{ $nominal }}">
                                <span class="radio-dot"></span>
                                <span class="flex-1">Rp {{ number_format($nominal, 0, ',', '.') }}</span>
                                @if($nominal == 25000)
                                    <span class="text-xs bg-slate-800 text-white px-2 py-0.5 rounded-full font-semibold">Umum</span>
                                @elseif($nominal == 100000)
                                    <span class="text-xs bg-amber-100 text-amber-700 px-2 py-0.5 rounded-full font-semibold">Buku Langka</span>
                                @endif
                            </label>
                        </div>
                        @endforeach

                        {{-- Custom amount --}}
                        <div class="deposit-option">
                            <input type="radio"
                                   id="deposit_custom"
                                   name="dana_jaminan_preset"
                                   value="custom"
                                   onchange="setDeposit('custom')">
                            <label for="deposit_custom">
                                <span class="radio-dot"></span>
                                <span class="flex-1 italic text-slate-400">Jumlah lain...</span>
                            </label>
                        </div>
                    </div>

                    {{-- Custom input --}}
                    <div id="custom-amount-wrapper" class="hidden">
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm font-medium">Rp</span>
                            <input type="number"
                                   id="dana_jaminan_custom"
                                   min="5000"
                                   step="1000"
                                   placeholder="Contoh: 75000"
                                   class="w-full border border-slate-300 rounded-xl pl-10 pr-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-slate-800 transition"
                                   oninput="syncCustomDeposit(this.value)">
                        </div>
                        <p class="text-xs text-slate-400 mt-1">Minimal dana jaminan Rp 5.000</p>
                    </div>

                    {{-- Hidden real field that gets submitted --}}
                    <input type="hidden" id="dana_jaminan" name="dana_jaminan" value="{{ old('dana_jaminan', 25000) }}" required>
                    @error('dana_jaminan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- ── Catatan ── --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2" for="catatan">
                        Catatan <span class="text-slate-400 font-normal">(opsional)</span>
                    </label>
                    <textarea id="catatan" name="catatan" rows="2"
                              placeholder="Contoh: kondisi buku saat dipinjam, keperluan, dll."
                              class="w-full border border-slate-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-slate-800 resize-none transition @error('catatan') border-red-400 @enderror">{{ old('catatan') }}</textarea>
                    @error('catatan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- ── Summary Strip ── --}}
                <div class="bg-slate-50 rounded-xl px-4 py-3.5 border border-slate-200 space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-500">Durasi Peminjaman</span>
                        <span id="summary-durasi" class="font-semibold text-slate-800">7 hari</span>
                    </div>
                    <div class="flex justify-between text-sm border-t border-slate-200 pt-2">
                        <span class="text-slate-500">Dana Jaminan</span>
                        <span id="summary-jaminan" class="font-bold text-slate-800">Rp 25.000</span>
                    </div>
                    <p class="text-xs text-slate-400 pt-1">
                        Dana jaminan bersifat <strong>refundable</strong> — dikembalikan penuh saat buku dikembalikan tepat waktu dan dalam kondisi baik.
                    </p>
                </div>

                {{-- ── Submit ── --}}
                <button type="submit"
                        id="btn-checkout"
                        class="w-full bg-slate-800 text-white py-3.5 rounded-xl font-bold text-sm hover:bg-slate-700 active:bg-slate-900 transition-all flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Ajukan Peminjaman
                </button>
                <p class="text-xs text-slate-400 text-center">
                    Pengajuan akan diproses oleh petugas perpustakaan dalam 1×24 jam.
                </p>
            </form>
        </div>
        @endif

        {{-- ── Info Box ── --}}
        <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4 space-y-3">
            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Kebijakan Peminjaman</p>
            <ul class="space-y-2 text-xs text-slate-600">
                <li class="flex items-start gap-2">
                    <svg class="w-3.5 h-3.5 text-slate-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/>
                    </svg>
                    Maksimal durasi peminjaman <strong>30 hari</strong> per pengajuan.
                </li>
                <li class="flex items-start gap-2">
                    <svg class="w-3.5 h-3.5 text-slate-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/>
                    </svg>
                    Dana jaminan <strong>dikembalikan penuh</strong> jika buku kembali tepat waktu dan tidak rusak.
                </li>
                <li class="flex items-start gap-2">
                    <svg class="w-3.5 h-3.5 text-slate-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/>
                    </svg>
                    Keterlambatan > 7 hari, dana jaminan <strong>hangus</strong> sebagai denda.
                </li>
                <li class="flex items-start gap-2">
                    <svg class="w-3.5 h-3.5 text-slate-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/>
                    </svg>
                    Pengajuan dengan status <em>Pending</em> menunggu konfirmasi petugas.
                </li>
            </ul>
        </div>

    </div>
    {{-- END RIGHT COLUMN --}}

</div>

@endsection

@push('scripts')
<script>
    // ── Duration Calculator ──────────────────────────────────────────────
    const dateInput   = document.getElementById('tanggal_kembali');
    const durationLbl = document.getElementById('duration-label');
    const summaryDur  = document.getElementById('summary-durasi');

    function updateDuration() {
        if (!dateInput.value) return;
        const today  = new Date();
        const target = new Date(dateInput.value);
        const diff   = Math.ceil((target - today) / 86400000);
        const label  = diff > 0 ? `(${diff} hari)` : '';
        if (durationLbl) durationLbl.textContent = label;
        if (summaryDur)  summaryDur.textContent   = diff > 0 ? `${diff} hari` : '-';
    }
    dateInput?.addEventListener('change', updateDuration);
    updateDuration();

    // ── Deposit Logic ────────────────────────────────────────────────────
    const hiddenDeposit   = document.getElementById('dana_jaminan');
    const customWrapper   = document.getElementById('custom-amount-wrapper');
    const summaryJaminan  = document.getElementById('summary-jaminan');

    function setDeposit(value) {
        if (value === 'custom') {
            customWrapper.classList.remove('hidden');
            hiddenDeposit.value = '';
            updateSummaryJaminan('');
        } else {
            customWrapper.classList.add('hidden');
            hiddenDeposit.value = value;
            updateSummaryJaminan(value);
        }
    }

    function syncCustomDeposit(val) {
        hiddenDeposit.value = val;
        updateSummaryJaminan(val);
    }

    function updateSummaryJaminan(val) {
        if (!summaryJaminan) return;
        const num = parseInt(val, 10);
        summaryJaminan.textContent = isNaN(num) ? '-' : 'Rp ' + num.toLocaleString('id-ID');
    }

    // Init display from default selection
    const checkedPreset = document.querySelector('input[name="dana_jaminan_preset"]:checked');
    if (checkedPreset) setDeposit(checkedPreset.value);

    // ── Form Confirm ─────────────────────────────────────────────────────
    document.getElementById('checkout-form')?.addEventListener('submit', function(e) {
        const jaminan = parseInt(hiddenDeposit.value, 10);
        if (isNaN(jaminan) || jaminan < 5000) {
            e.preventDefault();
            alert('Jumlah dana jaminan minimal Rp 5.000. Silakan pilih atau masukkan nominal yang valid.');
            return;
        }
        const btn = document.getElementById('btn-checkout');
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = `
                <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
                </svg>
                Mengajukan...
            `;
        }
    });
</script>
@endpush
