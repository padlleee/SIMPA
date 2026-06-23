<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donasi Berhasil – Panti Asuhan Amaliya</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50">

<div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
        <!-- Success Card -->
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <!-- Success Icon -->
            <div class="mb-6 flex justify-center">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-900" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>

            <!-- Message -->
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Terima Kasih!</h1>
            <p class="text-xl text-gray-600 mb-8">Donasi Anda telah kami terima dengan baik</p>

            <!-- Details -->
            <div class="bg-gray-50 rounded-lg p-6 mb-8 text-left">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Status Donasi Anda</h2>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between border-b border-gray-200 pb-3">
                        <span class="text-gray-600">Status</span>
                        <span class="font-semibold">
                            <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs">Menunggu Verifikasi</span>
                        </span>
                    </div>
                    <div class="flex justify-between border-b border-gray-200 pb-3">
                        <span class="text-gray-600">Waktu Diterima</span>
                        <span class="font-semibold">{{ now()->locale('id_ID')->translatedFormat('j F Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Estimasi Verifikasi</span>
                        <span class="font-semibold">1 × 24 jam</span>
                    </div>
                </div>
            </div>

            <!-- Information -->
            <div class="space-y-4 mb-8">
                <div class="p-4 bg-blue-50 border border-blue-200 rounded text-left">
                    <p class="text-sm font-semibold text-gray-900 mb-2"> Informasi Verifikasi</p>
                    <p class="text-sm text-gray-700">Mohon simpan bukti transfer Anda. Tim admin kami akan memverifikasi donasi Anda dalam waktu operasional. Jika diperlukan, kami akan menghubungi kontak Anda.</p>
                </div>

                <div class="p-4 bg-blue-50 border border-blue-200 rounded text-left">
                    <p class="text-sm font-semibold text-gray-900 mb-2"> Kwitansi Transparan</p>
                    <p class="text-sm text-gray-700">Donasi yang terverifikasi akan tercatat secara transparan di sistem. Untuk dapat mengunduh kwitansi resmi, Anda disarankan mendaftar sebagai Donatur Tetap.</p>
                </div>

                <div class="p-4 bg-blue-50 border border-blue-200 rounded text-left">
                    <p class="text-sm font-semibold text-gray-900 mb-2"> Doa Terbaik</p>
                    <p class="text-sm text-gray-700">Donasi Anda akan membantu anak-anak asuh kami mendapatkan pendidikan dan kehidupan yang lebih baik. Terima kasih atas kebaikan hati Anda.</p>
                </div>
            </div>

            <!-- FAQ Section (Moved Up) -->
            <div class="mb-8 pt-8 border-t border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 text-left">Pertanyaan Umum</h3>
                <div class="space-y-3 text-left">
                    <details class="bg-gray-50 p-4 rounded cursor-pointer">
                        <summary class="font-semibold text-gray-900">Berapa lama proses verifikasi?</summary>
                        <p class="mt-2 text-sm text-gray-600">Proses verifikasi donasi biasanya membutuhkan waktu 1 × 24 jam pada hari kerja.</p>
                    </details>

                    <details class="bg-gray-50 p-4 rounded cursor-pointer">
                        <summary class="font-semibold text-gray-900">Bagaimana jika donasi ditolak?</summary>
                        <p class="mt-2 text-sm text-gray-600">Jika ada ketidaksesuaian (contoh: bukti transfer buram/kurang), admin kami akan mencoba menghubungi Anda melalui kontak yang Anda berikan.</p>
                    </details>

                    <details class="bg-gray-50 p-4 rounded cursor-pointer">
                        <summary class="font-semibold text-gray-900">Bagaimana cara mendapatkan kwitansi?</summary>
                        <p class="mt-2 text-sm text-gray-600">Kwitansi digital dapat diakses dan diunduh langsung dari sistem jika Anda memiliki akun dan mendaftar sebagai Donatur Tetap.</p>
                    </details>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4">
                <button
                    onclick="document.getElementById('ctaModal').classList.remove('hidden')"
                    class="flex-1 bg-gray-900 text-white py-3 rounded-lg font-semibold text-center hover:bg-gray-800 transition"
                >
                    Kembali ke Beranda
                </button>
                <a
                    href="{{ route('donasi.publicCreate') }}"
                    class="flex-1 bg-gray-200 text-gray-900 py-3 rounded-lg font-semibold text-center hover:bg-gray-300 transition"
                >
                    Donasi Lagi
                </a>
            </div>
        </div>
    </div>
</div>

<!-- CTA Modal (Berminat Jadi Donatur Tetap) -->
<div id="ctaModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full overflow-hidden relative">
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 p-8 text-center relative overflow-hidden">
            <div class="absolute -right-10 -top-10 opacity-20">
                <svg class="w-40 h-40 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
            </div>
            <div class="relative z-10">
                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4 backdrop-blur-md">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2">Berminat Jadi Donatur Tetap?</h3>
                <p class="text-blue-100 text-sm leading-relaxed">
                    Jadilah bagian dari keluarga besar Yayasan Amaliya. Dapatkan kemudahan melacak histori donasi dan laporan penyaluran dana secara transparan langsung dari dashboard Anda.
                </p>
            </div>
        </div>
        <div class="p-6 bg-slate-50">
            <div class="flex flex-col gap-3">
                <a href="{{ url('/') }}?register=true" class="w-full bg-blue-600 text-white py-3.5 rounded-xl font-semibold text-center hover:bg-blue-700 transition-colors shadow-sm flex items-center justify-center gap-2">
                    Daftar Menjadi Donatur Tetap
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
                <a href="{{ url('/') }}" class="w-full bg-white border border-slate-300 text-slate-700 py-3.5 rounded-xl font-semibold text-center hover:bg-slate-50 transition-colors">
                    Tidak, Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>

@include('components.scroll-reveal')
</body>
</html>
