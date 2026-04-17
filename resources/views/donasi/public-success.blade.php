@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
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
                    <p class="text-sm font-semibold text-gray-900 mb-2">📧 Notifikasi Email</p>
                    <p class="text-sm text-gray-700">Tim verifikasi kami akan menghubungi Anda melalui email setelah donasi diverifikasi. Pastikan email Anda dapat diterima notifikasi.</p>
                </div>

                <div class="p-4 bg-blue-50 border border-blue-200 rounded text-left">
                    <p class="text-sm font-semibold text-gray-900 mb-2">✓ Kwitansi Digital</p>
                    <p class="text-sm text-gray-700">Kwitansi donasi resmi akan dikirim ke email Anda setelah verifikasi selesai. Anda juga dapat mengunduhnya dari dashboard.</p>
                </div>

                <div class="p-4 bg-blue-50 border border-blue-200 rounded text-left">
                    <p class="text-sm font-semibold text-gray-900 mb-2">🙏 Doa Terbaik</p>
                    <p class="text-sm text-gray-700">Donasi Anda akan membantu anak-anak asuh kami mendapatkan pendidikan dan kehidupan yang lebih baik. Terima kasih atas kebaikan hati Anda.</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4">
                <a
                    href="{{ url('/') }}"
                    class="flex-1 bg-gray-900 text-white py-3 rounded-lg font-semibold text-center hover:bg-gray-800 transition"
                >
                    Kembali ke Beranda
                </a>
                <a
                    href="{{ route('donasi.publicCreate') }}"
                    class="flex-1 bg-gray-200 text-gray-900 py-3 rounded-lg font-semibold text-center hover:bg-gray-300 transition"
                >
                    Donasi Lagi
                </a>
            </div>

            <!-- FAQ Section -->
            <div class="mt-12 pt-8 border-t border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Pertanyaan Umum</h3>
                <div class="space-y-3 text-left">
                    <details class="bg-gray-50 p-4 rounded cursor-pointer">
                        <summary class="font-semibold text-gray-900">Berapa lama proses verifikasi?</summary>
                        <p class="mt-2 text-sm text-gray-600">Proses verifikasi donasi biasanya membutuhkan waktu 1 × 24 jam. Tim kami akan menghubungi Anda melalui email untuk konfirmasi.</p>
                    </details>

                    <details class="bg-gray-50 p-4 rounded cursor-pointer">
                        <summary class="font-semibold text-gray-900">Bagaimana jika donasi ditolak?</summary>
                        <p class="mt-2 text-sm text-gray-600">Jika ada masalah dengan donasi Anda, tim kami akan mengirimkan email penjelasan dan memberikan kesempatan untuk memperbaiki.</p>
                    </details>

                    <details class="bg-gray-50 p-4 rounded cursor-pointer">
                        <summary class="font-semibold text-gray-900">Bagaimana cara mendapatkan kwitansi?</summary>
                        <p class="mt-2 text-sm text-gray-600">Kwitansi akan dikirim otomatis ke email Anda setelah verifikasi selesai. Anda juga dapat mengunduhnya dari halaman riwayat donasi kami.</p>
                    </details>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
