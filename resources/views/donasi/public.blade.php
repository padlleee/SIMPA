<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Donasi – Panti Asuhan Amaliya</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-slate-50 text-slate-800">

<!-- NAVBAR -->
<nav class="w-full bg-white border-b border-slate-200">
    <div class="max-w-4xl mx-auto px-6 py-4 flex items-center justify-between">
        <a href="{{ route('landing') }}" class="flex items-center gap-3">
            <div class="w-8 h-8 bg-slate-800 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            </div>
            <span class="text-lg font-bold text-slate-800">Panti Asuhan Amaliya</span>
        </a>
        <a href="{{ route('landing') }}" class="text-slate-500 hover:text-slate-800 text-sm font-medium transition-colors">
            &larr; Kembali
        </a>
    </div>
</nav>

<section class="min-h-screen py-16">
    <div class="max-w-3xl mx-auto px-6">
        <div class="text-center mb-10">
            <h1 class="text-4xl font-bold text-slate-800 mb-4">Mulai Berdonasi</h1>
            <p class="text-slate-600 text-lg">Donasi Anda akan sangat berarti bagi kelangsungan kesejahteraan dan pendidikan anak-anak kami.</p>
        </div>

        <!-- Himbauan Keamanan -->
        <div class="mb-10 bg-amber-50 border border-amber-200 rounded-2xl p-6 flex flex-col md:flex-row gap-5 items-center md:items-start shadow-sm">
            <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <div>
                <h3 class="font-bold text-amber-900 mb-2 text-lg">PENTING - Himbauan Keamanan Donasi</h3>
                <p class="text-amber-800 leading-relaxed text-sm">
                    Yayasan Amaliya Subang menghimbau kepada para donatur agar dapat menyalurkan donasinya melalui transfer ke rekening <strong>BRI 012301002045309</strong> dan <strong>BJB 0115697889100</strong> an. Yayasan Amaliya Subang. Hal ini kami terapkan demi ketertiban administrasi keuangan dan menghindari adanya penggelapan dana oleh pihak-pihak yang tidak bertanggung jawab.
                </p>
            </div>
        </div>

        @if(session('success'))
        <div class="mb-10 bg-green-50 border border-green-200 text-green-800 rounded-2xl p-5 flex items-start gap-4 shadow-sm">
            <div class="w-10 h-10 bg-green-100 text-green-600 rounded-full flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
            </div>
            <div class="pt-2 font-medium">
                {{ session('success') }}
            </div>
        </div>
        @endif

        <div class="bg-white rounded-3xl p-8 md:p-10 shadow-lg border border-slate-100">
            <form action="{{ route('donasi.public.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                
                <!-- Identitas -->
                <div>
                    <h3 class="text-lg font-bold text-slate-800 border-b border-slate-100 pb-3 mb-5">1. Identitas Donatur</h3>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_donatur" value="{{ old('nama_donatur') }}"
                                   class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 bg-slate-50 focus:bg-white transition-colors"
                                   placeholder="Fulan bin Fulan">
                            @error('nama_donatur')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">No. Handphone (Opsional)</label>
                            <input type="text" name="nomor_kontak" value="{{ old('nomor_kontak') }}"
                                   class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 bg-slate-50 focus:bg-white transition-colors"
                                   placeholder="08xxxxxxxxxx">
                        </div>
                    </div>
                </div>

                <!-- Rincian Donasi -->
                <div>
                    <h3 class="text-lg font-bold text-slate-800 border-b border-slate-100 pb-3 mb-5">2. Rincian Donasi</h3>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Nominal Donasi <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 font-medium">Rp</span>
                                <input type="number" name="nominal" value="{{ old('nominal') }}" min="10000"
                                       class="w-full border border-slate-300 rounded-xl pl-12 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 bg-slate-50 focus:bg-white transition-colors"
                                       placeholder="50000">
                            </div>
                            @error('nominal')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Metode Transfer <span class="text-red-500">*</span></label>
                            <select name="metode" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 bg-slate-50 focus:bg-white transition-colors">
                                <option value="Transfer" {{ old('metode') == 'Transfer' ? 'selected' : '' }}>Transfer Bank (BRI/BJB)</option>
                                <option value="QRIS" {{ old('metode') == 'QRIS' ? 'selected' : '' }}>QRIS</option>
                            </select>
                            @error('metode')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <!-- Bukti Transfer -->
                <div>
                    <h3 class="text-lg font-bold text-slate-800 border-b border-slate-100 pb-3 mb-5">3. Validasi</h3>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Unggah Bukti Transfer <span class="text-red-500">*</span></label>
                        <div class="border-2 border-dashed border-slate-300 rounded-2xl p-10 text-center bg-slate-50 hover:bg-slate-100 hover:border-slate-400 transition-colors">
                            <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" accept=".jpg,.jpeg,.png,.pdf" class="hidden"
                                   onchange="document.getElementById('file-label').textContent = this.files[0]?.name || 'Pilih file bukti ransfer'">
                            <svg class="w-12 h-12 text-slate-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            <label for="bukti_pembayaran" class="cursor-pointer text-slate-700 font-medium hover:text-slate-900 block text-lg mb-1">
                                <span id="file-label">Pilih file bukti transfer</span>
                            </label>
                            <p class="text-slate-500 text-sm">Format: JPG, PNG, atau PDF (maksimal 5MB)</p>
                        </div>
                        @error('bukti_pembayaran')<p class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="pt-6">
                    <button type="submit" class="w-full bg-slate-800 text-white py-4 rounded-xl font-bold text-lg hover:bg-slate-700 hover:shadow-lg transition-all">
                        Kirim Form Konfirmasi Donasi
                    </button>
                    <p class="text-center text-slate-500 text-sm mt-4">Dengan menekan tombol di atas, Anda telah mentransfer dana ke rekening resmi Yayasan.</p>
                </div>
            </form>
        </div>
    </div>
</section>

@include('layouts.footer')

</body>
</html>
