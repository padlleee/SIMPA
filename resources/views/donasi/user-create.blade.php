@extends('layouts.app')

@section('title', 'Form Donasi')
@section('page-title', 'Form Donasi')
@section('page-subtitle', 'Lakukan donasi Anda sebagai donatur terdaftar')

@push('styles')
<style>
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
</style>
@endpush

@section('content')

<div class="max-w-2xl mx-auto space-y-6">

    {{-- Info Donatur Banner --}}
    <div class="bg-slate-800 rounded-2xl p-6 text-white flex items-center gap-4">
        <div class="w-14 h-14 bg-white/10 rounded-xl flex items-center justify-center flex-shrink-0">
            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
        </div>
        <div>
            <p class="text-slate-400 text-sm">Donasi atas nama</p>
            <p class="font-bold text-lg">{{ $donatur?->nama_donatur ?? $user->username }}</p>
            <p class="text-slate-400 text-sm">{{ $user->email ?? ($donatur?->email ?? '-') }}</p>
        </div>
    </div>

    {{-- Rekening Resmi --}}
    <div class="bg-white rounded-2xl shadow-sm p-8 border border-slate-200">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
            </div>
            <h2 class="text-xl font-bold text-slate-800">Rekening Resmi Yayasan</h2>
        </div>

        <div class="grid md:grid-cols-2 gap-5">
            {{-- BRI Account --}}
            <div class="bg-slate-50 border border-slate-200 p-5 rounded-xl hover:border-blue-300 transition-colors">
                <div class="flex items-center gap-4 mb-4">
                    <div class="h-10 w-16 bg-white border border-slate-200 rounded flex items-center justify-center p-1.5 shrink-0">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/9/97/Logo_BRI.png" alt="BRI" class="h-full object-contain">
                    </div>
                    <h3 class="text-base font-bold text-slate-800">Bank BRI</h3>
                </div>
                <div class="space-y-2 text-sm">
                    <div class="flex items-center justify-between">
                        <p class="text-slate-500 font-medium">No. Rekening</p>
                        <div class="flex items-center gap-2">
                            <span id="bri-account" class="font-mono font-bold text-slate-900 tracking-wide">012301002045309</span>
                            <button type="button" onclick="copyToClipboard('bri-account')" class="text-blue-600 hover:text-blue-800 p-1.5 rounded-md hover:bg-blue-50 transition" title="Salin Rekening">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                            </button>
                        </div>
                    </div>
                    <div class="flex items-center justify-between border-t border-slate-200/60 pt-2">
                        <p class="text-slate-500 font-medium">Atas Nama</p>
                        <p class="text-slate-800 font-semibold text-right">YAYASAN PANTI ASUHAN AMALIYA</p>
                    </div>
                </div>
            </div>

            {{-- BJB Account --}}
            <div class="bg-slate-50 border border-slate-200 p-5 rounded-xl hover:border-blue-300 transition-colors">
                <div class="flex items-center gap-4 mb-4">
                    <div class="h-10 w-16 bg-white border border-slate-200 rounded flex items-center justify-center p-1.5 shrink-0">
                        <img src="https://vectorlogo4u.com/wp-content/uploads/2018/11/bank-bjb-vector-logo.png" alt="BJB" class="h-full object-contain">
                    </div>
                    <h3 class="text-base font-bold text-slate-800">Bank BJB</h3>
                </div>
                <div class="space-y-2 text-sm">
                    <div class="flex items-center justify-between">
                        <p class="text-slate-500 font-medium">No. Rekening</p>
                        <div class="flex items-center gap-2">
                            <span id="bjb-account" class="font-mono font-bold text-slate-900 tracking-wide">0987654321</span>
                            <button type="button" onclick="copyToClipboard('bjb-account')" class="text-blue-600 hover:text-blue-800 p-1.5 rounded-md hover:bg-blue-50 transition" title="Salin Rekening">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                            </button>
                        </div>
                    </div>
                    <div class="flex items-center justify-between border-t border-slate-200/60 pt-2">
                        <p class="text-slate-500 font-medium">Atas Nama</p>
                        <p class="text-slate-800 font-semibold text-right">YAYASAN PANTI ASUHAN AMALIYA</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 flex items-start gap-3 p-4 bg-amber-50 border border-amber-200 rounded-xl text-sm text-amber-800">
            <svg class="w-5 h-5 shrink-0 text-amber-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <p><strong>Catatan Penting:</strong> Mohon pastikan nama donatur yang dicantumkan pada form sesuai dengan nama pada rekening pengirim untuk mempercepat proses verifikasi oleh tim kami.</p>
        </div>
    </div>

    {{-- Donation Form --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">
        <div class="flex items-center gap-3 mb-6 pb-6 border-b border-slate-100">
            <div class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            </div>
            <h2 class="text-xl font-bold text-slate-800">Isi Data Donasi</h2>
        </div>

        <form action="{{ route('donatur.donasi.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- Read-only donor info --}}
            <div class="grid md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Donatur</label>
                    <input type="text" value="{{ $donatur?->nama_donatur ?? $user->username }}" disabled
                           class="w-full px-4 py-3 border border-slate-200 rounded-xl bg-slate-50 text-slate-500 cursor-not-allowed">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                    <input type="text" value="{{ $user->email ?? ($donatur?->email ?? '-') }}" disabled
                           class="w-full px-4 py-3 border border-slate-200 rounded-xl bg-slate-50 text-slate-500 cursor-not-allowed">
                </div>
            </div>
            @if($donatur?->no_hp && $donatur->no_hp !== '-')
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">No. Telepon</label>
                <input type="text" value="{{ $donatur->no_hp }}" disabled
                       class="w-full px-4 py-3 border border-slate-200 rounded-xl bg-slate-50 text-slate-500 cursor-not-allowed">
            </div>
            @endif

            {{-- Nominal --}}
            <div>
                <label for="nominal" class="block text-sm font-semibold text-slate-700 mb-2">
                    Nominal Donasi <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 font-semibold text-slate-500">Rp</span>
                    <input
                        type="text"
                        id="nominal"
                        name="nominal"
                        value="{{ old('nominal') }}"
                        placeholder="10000"
                        maxlength="12"
                        class="w-full pl-12 pr-4 py-3 border border-slate-300 rounded-xl font-bold text-lg focus:ring-2 focus:ring-slate-800 focus:border-slate-800 outline-none transition @error('nominal') border-red-500 @enderror"
                        required
                        oninvalid="this.setCustomValidity('Wajib diisi')"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 12); this.setCustomValidity('')"
                    >
                </div>
                <div class="flex items-center justify-between mt-2">
                    <p class="text-sm text-slate-500">Minimal: Rp 10.000</p>
                    @error('nominal')
                        <p class="text-sm text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Metode Pembayaran (Custom Dropdown) --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Metode Pembayaran <span class="text-red-500">*</span>
                </label>

                <div class="relative" id="custom-dropdown">
                    {{-- Hidden Real Input --}}
                    <input type="hidden" name="metode" id="metode" value="{{ old('metode') }}" required oninvalid="alert('Pilih metode pembayaran terlebih dahulu.')">

                    {{-- Dropdown Button --}}
                    <button type="button" id="dropdown-btn" class="w-full flex items-center justify-between px-4 py-3 border border-slate-300 rounded-xl bg-white hover:bg-slate-50 focus:ring-2 focus:ring-slate-800 focus:border-slate-800 transition outline-none @error('metode') border-red-500 @enderror">
                        <div class="flex items-center gap-3" id="dropdown-selected-content">
                            <span class="text-slate-400">Pilih Metode Pembayaran...</span>
                        </div>
                        <svg class="w-5 h-5 text-slate-400 transition-transform duration-200" id="dropdown-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>

                    {{-- Dropdown Menu --}}
                    <div id="dropdown-menu" class="absolute z-50 w-full mt-2 bg-white border border-slate-200 rounded-xl shadow-lg hidden max-h-60 overflow-y-auto custom-scrollbar">
                        <div class="p-2 space-y-1">
                            <button type="button" onclick="selectPayment('BRI', 'Bank BRI', 'https://upload.wikimedia.org/wikipedia/commons/9/97/Logo_BRI.png')" class="w-full flex items-center gap-4 p-3 rounded-lg hover:bg-slate-50 transition text-left">
                                <div class="w-14 h-8 bg-white border border-slate-200 rounded flex items-center justify-center p-1 shrink-0">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/9/97/Logo_BRI.png" alt="BRI" class="h-full object-contain">
                                </div>
                                <span class="font-semibold text-slate-700">Transfer Bank BRI</span>
                            </button>
                            <button type="button" onclick="selectPayment('BJB', 'Bank BJB', 'https://vectorlogo4u.com/wp-content/uploads/2018/11/bank-bjb-vector-logo.png')" class="w-full flex items-center gap-4 p-3 rounded-lg hover:bg-slate-50 transition text-left">
                                <div class="w-14 h-8 bg-white border border-slate-200 rounded flex items-center justify-center p-1 shrink-0">
                                    <img src="https://vectorlogo4u.com/wp-content/uploads/2018/11/bank-bjb-vector-logo.png" alt="BJB" class="h-full object-contain">
                                </div>
                                <span class="font-semibold text-slate-700">Transfer Bank BJB</span>
                            </button>
                            <button type="button" onclick="selectPayment('QRIS', 'QRIS (All Payment)', 'https://upload.wikimedia.org/wikipedia/commons/a/a2/Logo_QRIS.svg')" class="w-full flex items-center gap-4 p-3 rounded-lg hover:bg-slate-50 transition text-left">
                                <div class="w-14 h-8 bg-white border border-slate-200 rounded flex items-center justify-center p-1 shrink-0">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/a/a2/Logo_QRIS.svg" alt="QRIS" class="h-full object-contain">
                                </div>
                                <span class="font-semibold text-slate-700">QRIS (GoPay, OVO, Dana, dll)</span>
                            </button>
                            <button type="button" onclick="selectPayment('Transfer', 'Bank Lainnya', '')" class="w-full flex items-center gap-4 p-3 rounded-lg hover:bg-slate-50 transition text-left">
                                <div class="w-14 h-8 bg-slate-100 border border-slate-200 rounded flex items-center justify-center text-slate-500 shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                </div>
                                <span class="font-semibold text-slate-700">Transfer Bank Lainnya</span>
                            </button>
                        </div>
                    </div>
                </div>

                @error('metode')
                    <p class="mt-1.5 text-sm text-red-600 font-medium">{{ $message }}</p>
                @enderror

                {{-- Dynamic Payment Info Panels --}}
                <div id="info-transfer" class="hidden mt-4 flex items-start gap-3 p-4 bg-blue-50 border border-blue-200 rounded-xl text-sm text-blue-800">
                    <svg class="w-5 h-5 shrink-0 text-blue-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div>
                        <p class="font-semibold mb-1">Panduan Transfer</p>
                        <p class="text-blue-700/80">Silakan transfer nominal donasi ke salah satu rekening Yayasan di atas, kemudian unggah bukti transfer pada kolom di bawah.</p>
                    </div>
                </div>

                <div id="info-qris" class="hidden mt-4">
                    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
                        <div class="bg-slate-50 border-b border-slate-200 px-5 py-3 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                                <span class="font-bold text-slate-700">Scan QRIS Panti Asuhan Amaliya</span>
                            </div>
                        </div>
                        <div class="p-6 text-center bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-slate-50 to-white">
                            <img src="{{ asset('images/qris.jpg') }}" alt="QRIS Panti Asuhan Amaliya" class="mx-auto w-56 h-56 object-contain rounded-xl border border-slate-200 p-3 bg-white shadow-sm mb-5">
                            <a href="{{ asset('images/qris.jpg') }}" download="QRIS_Panti_Asuhan_Amaliya.jpg" class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-800 hover:bg-slate-700 text-white font-medium rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                Unduh QRIS
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bukti Pembayaran --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Unggah Bukti Pembayaran <span class="text-red-500">*</span>
                </label>
                <div class="relative border-2 border-dashed border-slate-300 rounded-xl p-8 bg-slate-50 hover:bg-slate-100 hover:border-slate-400 transition group">
                    <input
                        type="file"
                        id="bukti_pembayaran"
                        name="bukti_pembayaran"
                        accept=".jpg,.jpeg,.png,.pdf"
                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                        required
                        oninvalid="this.setCustomValidity('Wajib upload bukti pembayaran')" oninput="this.setCustomValidity('')"
                    >
                    <div class="text-center" id="upload-placeholder">
                        <div class="w-14 h-14 bg-white border border-slate-200 rounded-full flex items-center justify-center mx-auto mb-3 shadow-sm group-hover:scale-105 transition-transform">
                            <svg class="w-6 h-6 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                        </div>
                        <p class="font-bold text-slate-700">Pilih file atau drag & drop ke sini</p>
                        <p class="text-sm text-slate-500 mt-1">Format: JPG, PNG, atau PDF (Maks. 2MB)</p>
                    </div>
                    <div id="file-info" class="hidden mt-3 flex items-center gap-2 p-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span id="file-info-text"></span>
                    </div>
                </div>
                @error('bukti_pembayaran')
                    <p class="mt-1.5 text-sm text-red-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit Buttons --}}
            <div class="pt-6 border-t border-slate-100 flex gap-3">
                <button type="submit" class="flex-1 flex items-center justify-center gap-2 bg-slate-900 text-white py-4 rounded-xl font-bold text-lg hover:bg-slate-800 transition shadow-md hover:shadow-lg active:scale-[0.99]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    Kirim Konfirmasi Donasi
                </button>
                <a href="{{ route('donatur.dashboard') }}"
                   class="px-6 flex items-center justify-center bg-slate-100 text-slate-700 rounded-xl font-semibold hover:bg-slate-200 transition-colors">
                    Batal
                </a>
            </div>

            {{-- Disclaimer --}}
            <div class="flex items-start gap-2 text-xs text-slate-500">
                <svg class="w-4 h-4 shrink-0 mt-0.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                <p>Semua data pribadi dilindungi dengan aman. Tim kami akan memverifikasi bukti donasi dalam 1×24 jam. Kwitansi digital resmi akan dikirim ke email Anda.</p>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // --- Copy To Clipboard ---
    function copyToClipboard(elementId) {
        const element = document.getElementById(elementId);
        navigator.clipboard.writeText(element.textContent.trim()).then(() => {
            const btn = element.nextElementSibling;
            const originalHTML = btn.innerHTML;
            btn.innerHTML = `<svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>`;
            setTimeout(() => btn.innerHTML = originalHTML, 2000);
        });
    }

    // --- Custom Dropdown Logic ---
    const dropdownBtn    = document.getElementById('dropdown-btn');
    const dropdownMenu   = document.getElementById('dropdown-menu');
    const dropdownIcon   = document.getElementById('dropdown-icon');
    const hiddenMetode   = document.getElementById('metode');
    const selectedContent = document.getElementById('dropdown-selected-content');

    dropdownBtn.addEventListener('click', () => {
        dropdownMenu.classList.toggle('hidden');
        dropdownIcon.classList.toggle('rotate-180');
    });

    document.addEventListener('click', (e) => {
        if (!document.getElementById('custom-dropdown').contains(e.target)) {
            dropdownMenu.classList.add('hidden');
            dropdownIcon.classList.remove('rotate-180');
        }
    });

    function selectPayment(val, text, logoUrl) {
        hiddenMetode.value = val;

        if (logoUrl) {
            selectedContent.innerHTML = `
                <div class="h-6 w-10 bg-white border border-slate-200 rounded flex items-center justify-center p-0.5">
                    <img src="${logoUrl}" class="h-full object-contain">
                </div>
                <span class="font-bold text-slate-800">${text}</span>
            `;
        } else {
            selectedContent.innerHTML = `
                <div class="h-6 w-10 bg-slate-100 border border-slate-200 rounded flex items-center justify-center text-slate-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                </div>
                <span class="font-bold text-slate-800">${text}</span>
            `;
        }

        dropdownMenu.classList.add('hidden');
        dropdownIcon.classList.remove('rotate-180');
        showPaymentInfo(val);
    }

    function showPaymentInfo(val) {
        ['info-transfer', 'info-qris'].forEach(id => document.getElementById(id).classList.add('hidden'));
        if (['BJB', 'BRI', 'Transfer'].includes(val)) document.getElementById('info-transfer').classList.remove('hidden');
        if (val === 'QRIS') document.getElementById('info-qris').classList.remove('hidden');
    }

    // Restore on validation error
    const oldMetode = '{{ old('metode') }}';
    if (oldMetode) {
        const map = {
            'BRI':      ['Bank BRI',          'https://upload.wikimedia.org/wikipedia/commons/9/97/Logo_BRI.png'],
            'BJB':      ['Bank BJB',           'https://vectorlogo4u.com/wp-content/uploads/2018/11/bank-bjb-vector-logo.png'],
            'QRIS':     ['QRIS (All Payment)', 'https://upload.wikimedia.org/wikipedia/commons/a/a2/Logo_QRIS.svg'],
            'Transfer': ['Bank Lainnya',       ''],
        };
        if (map[oldMetode]) selectPayment(oldMetode, map[oldMetode][0], map[oldMetode][1]);
    }

    // --- File Input Display ---
    document.getElementById('bukti_pembayaran').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const fileInfo      = document.getElementById('file-info');
        const fileInfoText  = document.getElementById('file-info-text');
        const placeholder   = document.getElementById('upload-placeholder');

        if (file) {
            const sizeMB = (file.size / (1024 * 1024)).toFixed(2);
            fileInfoText.innerHTML = `<strong>${file.name}</strong> (${sizeMB} MB)`;
            fileInfo.classList.remove('hidden');
            fileInfo.classList.add('flex');
            placeholder.classList.add('hidden');
        } else {
            fileInfo.classList.add('hidden');
            fileInfo.classList.remove('flex');
            placeholder.classList.remove('hidden');
        }
    });
</script>
@endpush

@endsection
