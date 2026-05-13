<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Donasi – Panti Asuhan Amaliya</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50">

<div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Formulir Donasi</h1>
            <p class="text-lg text-gray-600">Setiap donasi Anda adalah berkah bagi anak-anak asuh kami</p>
        </div>

        <!-- Bank Account Information -->
        <div class="bg-white rounded-lg shadow-md p-8 mb-8 border-l-4 border-gray-400">
            <h2 class="text-2xl font-semibold text-gray-900 mb-6">💳 Rekening Resmi Foundation</h2>

            <div class="grid md:grid-cols-2 gap-6">
                <!-- BRI Account -->
                <div class="bg-gray-50 p-6 rounded-lg">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center mr-4">
                            <span class="text-lg font-bold text-gray-700">BRI</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Bank BRI</h3>
                    </div>
                    <div class="space-y-3 text-sm">
                        <div>
                            <p class="text-gray-600 font-medium">No. Rekening</p>
                            <p class="text-gray-900 font-mono text-lg">
                                <span id="bri-account">012301002045309</span>
                                <button onclick="copyToClipboard('bri-account')" class="ml-2 text-blue-600 hover:text-blue-800" title="Salin">
                                    📋
                                </button>
                            </p>
                        </div>
                        <div>
                            <p class="text-gray-600 font-medium">Atas Nama</p>
                            <p class="text-gray-900">YAYASAN PANTI ASUHAN</p>
                        </div>
                    </div>
                </div>

                <!-- BJB Account -->
                <div class="bg-gray-50 p-6 rounded-lg">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center mr-4">
                            <span class="text-lg font-bold text-gray-700">BJB</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Bank BJB</h3>
                    </div>
                    <div class="space-y-3 text-sm">
                        <div>
                            <p class="text-gray-600 font-medium">No. Rekening</p>
                            <p class="text-gray-900 font-mono text-lg">
                                <span id="bjb-account">0987654321</span>
                                <button onclick="copyToClipboard('bjb-account')" class="ml-2 text-blue-600 hover:text-blue-800" title="Salin">
                                    📋
                                </button>
                            </p>
                        </div>
                        <div>
                            <p class="text-gray-600 font-medium">Atas Nama</p>
                            <p class="text-gray-900">YAYASAN PANTI ASUHAN</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded text-sm text-gray-700">
                <p><strong>⚠️ Catatan Penting:</strong> Pastikan nama pendonasi sesuai untuk verifikasi yang lebih cepat.</p>
            </div>
        </div>

        <!-- Donation Form -->
        <div class="bg-white rounded-lg shadow-md p-8">
            <form action="{{ route('donasi.publicStore') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Nama Donatur -->
                <div>
                    <label for="nama_donatur" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="nama_donatur"
                        name="nama_donatur"
                        value="{{ old('nama_donatur') }}"
                        placeholder="Nama sesuai rekening bank"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent @error('nama_donatur') border-red-500 @enderror"
                        required
                    >
                    @error('nama_donatur')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="email@example.com"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent @error('email') border-red-500 @enderror"
                        required
                    >
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- No. HP -->
                <div>
                    <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-2">
                        Nomor Telepon (Opsional)
                    </label>
                    <input
                        type="tel"
                        id="no_hp"
                        name="no_hp"
                        value="{{ old('no_hp') }}"
                        placeholder="08xxxxxxxxxx"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent"
                    >
                </div>

                <!-- Nominal -->
                <div>
                    <label for="nominal" class="block text-sm font-medium text-gray-700 mb-2">
                        Nominal Donasi (Rp) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-2 text-gray-600">Rp</span>
                        <input
                            type="number"
                            id="nominal"
                            name="nominal"
                            value="{{ old('nominal') }}"
                            placeholder="10000"
                            min="10000"
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent @error('nominal') border-red-500 @enderror"
                            required
                        >
                    </div>
                    @error('nominal')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-sm text-gray-500">Minimal donasi: Rp 10.000</p>
                </div>

                <!-- Metode Pembayaran -->
                <div>
                    <label for="metode" class="block text-sm font-medium text-gray-700 mb-2">
                        Metode Pembayaran <span class="text-red-500">*</span>
                    </label>
                    <select
                        id="metode"
                        name="metode"
                        onchange="showPaymentInfo(this.value)"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent @error('metode') border-red-500 @enderror"
                        required
                    >
                        <option value="">-- Pilih Metode --</option>
                        <option value="BJB" @selected(old('metode') === 'BJB')>Transfer Bank BJB</option>
                        <option value="BRI" @selected(old('metode') === 'BRI')>Transfer Bank BRI</option>
                        <option value="Transfer" @selected(old('metode') === 'Transfer')>Transfer Bank Lainnya</option>
                        <option value="QRIS" @selected(old('metode') === 'QRIS')>QRIS</option>
                        <option value="Tunai" @selected(old('metode') === 'Tunai')>Tunai</option>
                    </select>
                    @error('metode')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    {{-- Dynamic Info --}}
                    <div id="info-transfer" class="hidden mt-3 p-4 bg-blue-50 border border-blue-200 rounded-lg text-sm text-gray-700">
                        <p class="font-semibold">📌 Transfer ke salah satu rekening yang tertera di atas, lalu unggah bukti transfer.</p>
                    </div>
                    <div id="info-qris" class="hidden mt-3 text-center">
                        <p class="text-sm font-semibold text-gray-700 mb-2">Scan QRIS berikut untuk pembayaran:</p>
                        <img src="{{ asset('storage/img/qris.jpg') }}" alt="QRIS Panti Asuhan Amaliya"
                             class="mx-auto h-48 object-contain rounded-lg border border-gray-200 p-2 bg-white">
                    </div>
                    <div id="info-tunai" class="hidden mt-3 p-4 bg-amber-50 border border-amber-200 rounded-lg text-sm text-gray-700">
                        <p class="font-semibold">🏢 Donasi tunai diserahkan langsung ke kantor Yayasan Amaliya Subang.</p>
                    </div>
                </div>

                <!-- Bukti Pembayaran -->
                <div>
                    <label for="bukti_pembayaran" class="block text-sm font-medium text-gray-700 mb-2">
                        Bukti Pembayaran <span class="text-red-500">*</span>
                    </label>
                    <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-6 bg-gray-50 hover:bg-gray-100 transition">
                        <input
                            type="file"
                            id="bukti_pembayaran"
                            name="bukti_pembayaran"
                            accept=".jpg,.jpeg,.png,.pdf"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                            required
                        >
                        <div class="text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20a4 4 0 004 4h24a4 4 0 004-4V20" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M4 20h40" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                            <p class="mt-2 font-medium text-gray-900">Klik untuk upload atau drag & drop</p>
                            <p class="text-sm text-gray-500 mt-1">JPG, PNG, atau PDF (Maks. 2MB)</p>
                        </div>
                    </div>
                    @error('bukti_pembayaran')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <div id="file-info" class="mt-2 text-sm text-gray-600"></div>
                </div>

                <!-- Submit Button -->
                <div class="flex gap-4 pt-6">
                    <button
                        type="submit"
                        class="flex-1 bg-gray-900 text-white py-3 rounded-lg font-semibold hover:bg-gray-800 transition duration-200"
                    >
                        Kirim Donasi
                    </button>
                    <a
                        href="{{ url('/') }}"
                        class="flex-1 bg-gray-200 text-gray-900 py-3 rounded-lg font-semibold text-center hover:bg-gray-300 transition duration-200"
                    >
                        Batal
                    </a>
                </div>

                <!-- Disclaimer -->
                <div class="p-4 bg-gray-50 rounded-lg text-sm text-gray-600 border border-gray-200">
                    <p>✓ Semua data pribadi Anda dilindungi dan hanya digunakan untuk verifikasi donasi.</p>
                    <p>✓ Kwitansi digital akan dikirim ke email setelah donasi diverifikasi.</p>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function showPaymentInfo(val) {
        ['info-transfer','info-qris','info-tunai'].forEach(id => document.getElementById(id).classList.add('hidden'));
        if (['BJB','BRI','Transfer'].includes(val)) document.getElementById('info-transfer').classList.remove('hidden');
        if (val === 'QRIS') document.getElementById('info-qris').classList.remove('hidden');
        if (val === 'Tunai') document.getElementById('info-tunai').classList.remove('hidden');
    }

    // Update file info when file is selected
    document.getElementById('bukti_pembayaran').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const fileInfo = document.getElementById('file-info');
            const sizeMB = (file.size / (1024 * 1024)).toFixed(2);
            fileInfo.innerHTML = `✓ File terpilih: <strong>${file.name}</strong> (${sizeMB} MB)`;
            fileInfo.className = 'mt-2 text-sm text-green-600';
        }
    });

    // Copy to clipboard function
    function copyToClipboard(elementId) {
        const element = document.getElementById(elementId);
        navigator.clipboard.writeText(element.textContent.trim()).then(() => alert('Nomor rekening disalin!'));
    }

    // Restore dynamic info on validation error
    const oldMetode = '{{ old('metode') }}';
    if (oldMetode) showPaymentInfo(oldMetode);
</script>
</body>
</html>
