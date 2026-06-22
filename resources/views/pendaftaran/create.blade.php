@extends('layouts.master')

@section('title', 'Pendaftaran Anak Asuh')
@section('meta-description', 'Formulir pendaftaran digital calon anak asuh Yayasan Panti Asuhan Amaliya Subang.')
@section('body-class', 'bg-white text-slate-800')

@section('body')
@include('layouts.navbar')

{{-- HEADER --}}
<section class="pt-32 pb-10 bg-gradient-to-b from-slate-50 to-white">
    <div class="max-w-2xl mx-auto px-6 text-center">
        <span class="inline-block text-xs font-semibold text-slate-500 uppercase tracking-widest bg-slate-100 px-4 py-1.5 rounded-full mb-5">Formulir Digital</span>
        <h1 class="text-3xl md:text-4xl font-bold text-slate-800 mb-4">Pendaftaran Calon Anak Asuh</h1>
        <p class="text-slate-500 text-sm leading-relaxed">
            Isi formulir di bawah ini dengan lengkap dan jujur. Tim kami akan menghubungi Anda dalam <strong>3–5 hari kerja</strong> setelah pengajuan diterima.
        </p>
    </div>
</section>

{{-- FLASH MESSAGE --}}
@if(session('success'))
<div class="max-w-2xl mx-auto px-6 mb-6">
    <div class="bg-green-50 border border-green-200 text-green-800 rounded-xl px-5 py-4 text-sm flex gap-3 items-start">
        <svg class="w-5 h-5 flex-shrink-0 text-green-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
        </svg>
        <p>{{ session('success') }}</p>
    </div>
</div>
@endif

{{-- INFO / ALERT SECTION --}}
<div class="max-w-2xl mx-auto px-6 mb-8 animate-on-scroll">
    <div class="bg-blue-50 border border-blue-200 rounded-2xl p-5 md:p-6 shadow-sm">
        <div class="flex gap-4">
            <div class="flex-shrink-0 mt-1">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <h3 class="text-sm font-bold text-slate-800 mb-2">Informasi Penting Sebelum Mendaftar</h3>
                <ul class="text-sm text-slate-600 space-y-2 list-disc pl-4 mb-4">
                    <li>Sebelum mendaftar, Anda dapat mengunjungi <a href="{{ route('info') }}" class="text-blue-600 font-semibold hover:underline">Halaman Pusat Informasi</a> untuk mengunduh dokumen pendaftaran.</li>
                    <li>Pastikan Anda mencantumkan <strong>nomor WhatsApp yang aktif</strong> pada formulir di bawah ini agar tim kami mudah menghubungi Anda.</li>
                </ul>
                <div class="mt-4 pt-4 border-t border-blue-200/60">
                    <p class="text-xs text-slate-500 mb-2">Untuk informasi lebih lanjut, silakan hubungi admin kami:</p>
                    @php
                        $waText = "Assalamualaikum, halo kak saya ingin daftar anak asuh...";
                    @endphp
                    <a href="https://wa.me/628119918090?text={{ urlencode($waText) }}" target="_blank" class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.125.558 4.12 1.532 5.849L.044 23.956 6.31 22.5A11.944 11.944 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22a9.956 9.956 0 01-5.195-1.453l-.371-.22-3.846.933.975-3.741-.242-.385A9.958 9.958 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
                        Hubungi via WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- FORM --}}
<section class="pb-24">
    <div class="max-w-2xl mx-auto px-6">
        <form action="{{ route('pendaftaran-anak.store') }}" method="POST" enctype="multipart/form-data"
              class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
            @csrf

            {{-- Section: Data Anak --}}
            <div class="border-b border-slate-100 bg-slate-50 px-6 py-4">
                <h2 class="font-semibold text-slate-700 text-sm uppercase tracking-wide">Data Anak</h2>
            </div>
            <div class="p-6 space-y-5">
                {{-- Nama Anak --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase mb-1.5" for="nama_anak">
                        Nama Lengkap Anak <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="nama_anak" name="nama_anak" value="{{ old('nama_anak') }}" required
                           class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-slate-400 @error('nama_anak') border-red-400 @enderror"
                           placeholder="Nama lengkap anak asuh">
                    @error('nama_anak')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Tanggal Lahir + Jenis Kelamin --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase mb-1.5" for="tanggal_lahir">
                            Tanggal Lahir <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir_raw', old('tanggal_lahir')) }}" required
                               placeholder="DD/MM/YYYY (Contoh: 24/05/2012)"
                               pattern="\d{2}/\d{2}/\d{4}"
                               title="Gunakan format Tanggal/Bulan/Tahun dengan garis miring (Contoh: 24/05/2012)"
                               class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-slate-400 @error('tanggal_lahir') border-red-400 @enderror">
                        @error('tanggal_lahir')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase mb-1.5" for="jenis_kelamin">
                            Jenis Kelamin <span class="text-red-500">*</span>
                        </label>
                        <select id="jenis_kelamin" name="jenis_kelamin" required
                                class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-slate-400 @error('jenis_kelamin') border-red-400 @enderror">
                            <option value="">Pilih...</option>
                            <option value="Laki-laki"  {{ old('jenis_kelamin') === 'Laki-laki'  ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan"  {{ old('jenis_kelamin') === 'Perempuan'  ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            {{-- Section: Data Wali --}}
            <div class="border-t border-b border-slate-100 bg-slate-50 px-6 py-4">
                <h2 class="font-semibold text-slate-700 text-sm uppercase tracking-wide">Data Wali / Orang Tua</h2>
            </div>
            <div class="p-6 space-y-5">
                {{-- Nama Wali --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase mb-1.5" for="nama_wali">
                        Nama Wali / Orang Tua <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="nama_wali" name="nama_wali" value="{{ old('nama_wali') }}" required
                           class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-slate-400 @error('nama_wali') border-red-400 @enderror"
                           placeholder="Nama lengkap orang tua/wali">
                    @error('nama_wali')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Kontak Wali --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase mb-1.5" for="kontak_wali">
                        Nomor HP / WhatsApp Wali <span class="text-red-500">*</span>
                    </label>
                    <input type="tel" id="kontak_wali" name="kontak_wali" value="{{ old('kontak_wali') }}" required
                           class="w-full px-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-slate-400 @error('kontak_wali') border-red-400 @enderror"
                           placeholder="0812xxxx (WhatsApp aktif)">
                    @error('kontak_wali')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Section: Alasan & Dokumen --}}
            <div class="border-t border-b border-slate-100 bg-slate-50 px-6 py-4">
                <h2 class="font-semibold text-slate-700 text-sm uppercase tracking-wide">Keterangan & Dokumen Pendukung</h2>
            </div>
            <div class="p-6 space-y-5">
                {{-- Alasan --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase mb-1.5" for="alasan_masuk">
                        Alasan / Latar Belakang Pengajuan <span class="text-red-500">*</span>
                    </label>
                    <textarea id="alasan_masuk" name="alasan_masuk" rows="5" required
                              class="w-full px-4 py-3 border border-slate-300 rounded-xl text-sm leading-relaxed focus:outline-none focus:ring-2 focus:ring-slate-400 resize-y @error('alasan_masuk') border-red-400 @enderror"
                              placeholder="Jelaskan alasan pengajuan...">{{ old('alasan_masuk') }}</textarea>
                    @error('alasan_masuk')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Dokumen Upload --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase mb-1.5" for="dokumen">
                        Dokumen Pendukung (PDF / ZIP)
                    </label>
                    <div class="border-2 border-dashed border-slate-300 rounded-xl p-5 text-center hover:border-slate-400 transition-colors">
                        <svg class="w-8 h-8 text-slate-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        <input type="file" id="dokumen" name="dokumen" accept=".pdf,.zip"
                               class="text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 transition-colors @error('dokumen') border-red-400 @enderror">
                        <p class="text-xs text-slate-400 mt-2">Gabungkan KK, SKTM, dan dokumen lain dalam satu file PDF atau ZIP. Maks. 10 MB.</p>
                    </div>
                    @error('dokumen')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Notice --}}
                <div class="bg-amber-50 border border-amber-200 rounded-xl px-4 py-3 text-xs text-amber-700 leading-relaxed">
                    <strong>Catatan:</strong> Pengajuan ini bersifat pendahuluan. Tim kami akan melakukan verifikasi dan kunjungan lapangan sebelum keputusan akhir diberikan.
                </div>
            </div>

            {{-- Submit --}}
            <div class="border-t border-slate-100 bg-slate-50 px-6 py-5 flex items-center justify-between">
                <a href="{{ route('landing') }}" class="text-sm text-slate-500 hover:text-slate-700 transition-colors">← Kembali ke Beranda</a>
                <button type="submit"
                        class="inline-flex items-center gap-2 bg-slate-800 text-white px-8 py-3 rounded-xl font-semibold text-sm hover:bg-slate-700 active:scale-95 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                    Kirim Formulir
                </button>
            </div>
        </form>
    </div>
</section>

@include('layouts.footer')

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const tglInput = document.getElementById('tanggal_lahir');
    if (tglInput) {
        tglInput.addEventListener('input', function (e) {
            // Jika menekan tombol backspace/delete, jangan auto-format agar bisa dihapus
            if (e.inputType === 'deleteContentBackward') return;
            
            let v = e.target.value.replace(/\D/g, ''); // Hapus semua selain angka
            if (v.length > 8) v = v.substring(0, 8); // Maksimal 8 digit angka

            if (v.length > 4) {
                e.target.value = v.substring(0, 2) + '/' + v.substring(2, 4) + '/' + v.substring(4);
            } else if (v.length > 2) {
                e.target.value = v.substring(0, 2) + '/' + v.substring(2);
            } else {
                e.target.value = v;
            }
        });
    }
});
</script>
@endpush

@endsection
