@extends('layouts.app')

@section('title', 'Form Donasi')
@section('page-title', 'Form Donasi')
@section('page-subtitle', 'Lakukan donasi Anda sebagai donatur terdaftar')

@section('content')

<div class="max-w-3xl mx-auto space-y-8">

    {{-- Info Donatur --}}
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

    {{-- Rekening --}}
    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
        <h2 class="font-bold text-slate-800 text-lg mb-4">Rekening Resmi Yayasan</h2>
        <div class="grid md:grid-cols-2 gap-4">
            <div class="bg-slate-50 rounded-xl p-4">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 bg-slate-800 rounded-lg flex items-center justify-center">
                        <span class="text-white text-xs font-bold">BRI</span>
                    </div>
                    <p class="font-semibold text-slate-700">Bank BRI</p>
                </div>
                <p class="text-xs text-slate-500 mb-1">No. Rekening</p>
                <p class="font-mono font-bold text-slate-800"><span id="bri-no">012301002045309</span>
                    <button type="button" onclick="copyText('bri-no')" class="ml-2 text-slate-400 hover:text-slate-700" title="Salin">📋</button>
                </p>
                <p class="text-xs text-slate-500 mt-1">a.n. YAYASAN PANTI ASUHAN AMALIYA</p>
            </div>
            <div class="bg-slate-50 rounded-xl p-4">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 bg-slate-800 rounded-lg flex items-center justify-center">
                        <span class="text-white text-xs font-bold">BJB</span>
                    </div>
                    <p class="font-semibold text-slate-700">Bank BJB</p>
                </div>
                <p class="text-xs text-slate-500 mb-1">No. Rekening</p>
                <p class="font-mono font-bold text-slate-800"><span id="bjb-no">0987654321</span>
                    <button type="button" onclick="copyText('bjb-no')" class="ml-2 text-slate-400 hover:text-slate-700" title="Salin">📋</button>
                </p>
                <p class="text-xs text-slate-500 mt-1">a.n. YAYASAN PANTI ASUHAN AMALIYA</p>
            </div>
        </div>
    </div>

    {{-- Donation Form --}}
    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
        <h2 class="font-bold text-slate-800 text-lg mb-6">Formulir Donasi</h2>

        <form action="{{ route('donatur.donasi.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            {{-- Info read-only --}}
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nama Donatur</label>
                    <input type="text" value="{{ $donatur?->nama_donatur ?? $user->username }}" disabled
                           class="w-full px-4 py-2.5 border border-slate-200 rounded-lg bg-slate-50 text-slate-500 cursor-not-allowed">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                    <input type="text" value="{{ $user->email ?? ($donatur?->email ?? '-') }}" disabled
                           class="w-full px-4 py-2.5 border border-slate-200 rounded-lg bg-slate-50 text-slate-500 cursor-not-allowed">
                </div>
            </div>
            @if($donatur?->no_hp)
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">No. Telepon</label>
                <input type="text" value="{{ $donatur->no_hp }}" disabled
                       class="w-full px-4 py-2.5 border border-slate-200 rounded-lg bg-slate-50 text-slate-500 cursor-not-allowed">
            </div>
            @endif

            {{-- Nominal --}}
            <div>
                <label for="nominal" class="block text-sm font-medium text-slate-700 mb-1">
                    Nominal Donasi <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 font-medium">Rp</span>
                    <input type="text" id="nominal" name="nominal" value="{{ old('nominal') }}"
                           placeholder="10000" maxlength="12" required
                           oninvalid="this.setCustomValidity('Wajib diisi')"
                           oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 12); this.setCustomValidity('')"
                           class="w-full pl-12 pr-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-transparent @error('nominal') border-red-500 @enderror">
                </div>
                @error('nominal')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                <p class="mt-1 text-xs text-slate-500">Minimal donasi: Rp 10.000</p>
            </div>

            {{-- Metode --}}
            <div>
                <label for="metode" class="block text-sm font-medium text-slate-700 mb-1">
                    Metode Pembayaran <span class="text-red-500">*</span>
                </label>
                <select id="metode" name="metode" onchange="showPaymentInfo(this.value)" required
                        oninvalid="this.setCustomValidity('Wajib pilih metode pembayaran')" oninput="this.setCustomValidity('')"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-500 @error('metode') border-red-500 @enderror">
                    <option value="">-- Pilih Metode --</option>
                    <option value="BJB" @selected(old('metode') === 'BJB')>Transfer Bank BJB</option>
                    <option value="BRI" @selected(old('metode') === 'BRI')>Transfer Bank BRI</option>
                    <option value="Transfer" @selected(old('metode') === 'Transfer')>Transfer Bank Lainnya</option>
                    <option value="QRIS" @selected(old('metode') === 'QRIS')>QRIS</option>
                </select>
                @error('metode')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror

                {{-- Dynamic payment info --}}
                <div id="info-transfer" class="hidden mt-3 p-4 bg-blue-50 border border-blue-200 rounded-lg text-sm text-slate-700">
                    <p class="font-semibold mb-1">📌 Transfer ke salah satu rekening di atas, lalu unggah buktinya.</p>
                </div>
                <div id="info-qris" class="hidden mt-3 text-center">
                    <p class="text-sm font-semibold text-slate-700 mb-2">Scan QRIS berikut untuk melakukan pembayaran:</p>
                    <img src="{{ asset('/storage/img/qris.jpg') }}" alt="QRIS Panti Asuhan Amaliya"
                         class="mx-auto h-48 object-contain rounded-lg border border-slate-200 p-2 bg-white">
                </div>
            </div>

            {{-- Bukti Pembayaran --}}
            <div>
                <label for="bukti_pembayaran" class="block text-sm font-medium text-slate-700 mb-1">
                    Bukti Pembayaran <span class="text-red-500">*</span>
                </label>
                <div class="relative border-2 border-dashed border-slate-300 rounded-lg p-6 bg-slate-50 hover:bg-slate-100 transition cursor-pointer" onclick="document.getElementById('bukti_pembayaran').click()">
                    <input type="file" id="bukti_pembayaran" name="bukti_pembayaran"
                           accept=".jpg,.jpeg,.png,.pdf" class="hidden" required onchange="showFileName(this)"
                           oninvalid="this.setCustomValidity('Wajib upload bukti pembayaran')" oninput="this.setCustomValidity('')">
                    <div class="text-center" id="upload-placeholder">
                        <svg class="mx-auto h-10 w-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        <p class="mt-2 font-medium text-slate-600">Klik untuk upload</p>
                        <p class="text-xs text-slate-400 mt-1">JPG, PNG, atau PDF (Maks. 2MB)</p>
                    </div>
                    <div id="file-info" class="hidden text-center text-sm text-green-700 font-medium"></div>
                </div>
                @error('bukti_pembayaran')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            {{-- Buttons --}}
            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="flex-1 bg-slate-800 text-white py-3 rounded-xl font-semibold hover:bg-slate-700 transition-colors">
                    Kirim Donasi
                </button>
                <a href="{{ route('donatur.dashboard') }}"
                   class="flex-1 bg-slate-100 text-slate-700 py-3 rounded-xl font-semibold text-center hover:bg-slate-200 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function showPaymentInfo(val) {
    ['info-transfer', 'info-qris'].forEach(id => document.getElementById(id).classList.add('hidden'));
    if (['BJB','BRI','Transfer'].includes(val)) document.getElementById('info-transfer').classList.remove('hidden');
    if (val === 'QRIS') document.getElementById('info-qris').classList.remove('hidden');
}

function showFileName(input) {
    const placeholder = document.getElementById('upload-placeholder');
    const info = document.getElementById('file-info');
    if (input.files[0]) {
        const size = (input.files[0].size / 1048576).toFixed(2);
        placeholder.classList.add('hidden');
        info.classList.remove('hidden');
        info.textContent = '✓ ' + input.files[0].name + ' (' + size + ' MB)';
    }
}

function copyText(id) {
    const text = document.getElementById(id).textContent.trim();
    navigator.clipboard.writeText(text).then(() => alert('Nomor rekening disalin!'));
}

// Restore selection on validation error
const oldMetode = "{{ old('metode') }}";
if (oldMetode) showPaymentInfo(oldMetode);
</script>
@endpush

@endsection
