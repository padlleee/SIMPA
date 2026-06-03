@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('donasi.index') }}" class="text-blue-600 hover:text-blue-800">← Kembali ke Daftar Donasi</a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Donor Information -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Informasi Donatur</h2>

                    <div class="space-y-4">
                        <div class="border-b border-gray-200 pb-4">
                            <p class="text-sm text-gray-600 font-medium">Nama Donatur</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $donasi->nama_donatur_display }}</p>
                        </div>

                        <div class="border-b border-gray-200 pb-4">
                            <p class="text-sm text-gray-600 font-medium">Email</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $donasi->user->email ?? ($donasi->email_donatur_manual ?? 'Tidak tersedia') }}</p>
                        </div>

                        <div class="border-b border-gray-200 pb-4">
                            <p class="text-sm text-gray-600 font-medium">Nomor Telepon</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $donasi->user->donatur->no_hp ?? ($donasi->no_hp_donatur_manual ?? 'Tidak tersedia') }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-600 font-medium">Status Donatur</p>
                            @if($donasi->user)
                                <span class="inline-block mt-2 px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                                    Terdaftar
                                </span>
                            @else
                                <span class="inline-block mt-2 px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-sm font-medium">
                                    Donatur Umum
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Donation Details -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Detail Donasi</h2>

                    <div class="space-y-4">
                        <div class="border-b border-gray-200 pb-4">
                            <p class="text-sm text-gray-600 font-medium">Nominal Donasi</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $donasi->nominal_formatted }}</p>
                        </div>

                        <div class="border-b border-gray-200 pb-4">
                            <p class="text-sm text-gray-600 font-medium">Metode Pembayaran</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $donasi->metode_pembayaran }}</p>
                        </div>

                        <div class="border-b border-gray-200 pb-4">
                            <p class="text-sm text-gray-600 font-medium">Tanggal Donasi</p>
                            <p class="text-lg font-semibold text-gray-900">
                                {{ $donasi->tanggal_donasi->locale('id_ID')->translatedFormat('j F Y H:i') }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-600 font-medium">Status</p>
                            <div class="mt-2">
                                @if($donasi->status_verifikasi === 'Pending')
                                    <span class="inline-block px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium">
                                        ⏳ Menunggu Verifikasi
                                    </span>
                                @elseif($donasi->status_verifikasi === 'Valid')
                                    <span class="inline-block px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                                         Sudah Terverifikasi
                                    </span>
                                @else
                                    <span class="inline-block px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-medium">
                                         Ditolak
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Proof/Evidence -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Bukti Pembayaran</h2>

                    @if($donasi->bukti_pembayaran)
                        @php
                            $filePath = $donasi->bukti_pembayaran;
                            $fileExt = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                        @endphp

                        @if(in_array($fileExt, ['jpg', 'jpeg', 'png', 'gif']))
                            <img src="{{ asset('storage/' . $filePath) }}" alt="Bukti Pembayaran" class="w-full rounded-lg border border-gray-200">
                        @else
                            <div class="bg-gray-50 p-8 rounded-lg border border-gray-200 text-center">
                                <div class="text-6xl mb-4"></div>
                                <p class="text-gray-600 mb-4">Format File: <strong>.{{ $fileExt }}</strong></p>
                                <a href="{{ asset('storage/' . $filePath) }}" class="text-blue-600 hover:text-blue-800 font-medium" target="_blank">
                                    Buka File PDF
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="bg-gray-50 p-8 rounded-lg border border-gray-200 text-center">
                            <div class="text-6xl mb-4"></div>
                            <p class="text-gray-600">Tidak ada bukti pembayaran</p>
                        </div>
                    @endif
                </div>

                <!-- Verification History -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Riwayat Verifikasi</h2>

                    @if($donasi->isVerified() || $donasi->isRejected())
                        <div class="space-y-4">
                            <div class="border-l-4 {{ $donasi->isVerified() ? 'border-green-500' : 'border-red-500' }} pl-4 py-2">
                                <p class="text-sm text-gray-600 font-medium">Diverifikasi Oleh</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $donasi->bendahara->nama_lengkap ?? $donasi->bendahara->username ?? 'Admin' }}</p>
                            </div>

                            <div class="border-l-4 {{ $donasi->isVerified() ? 'border-green-500' : 'border-red-500' }} pl-4 py-2">
                                <p class="text-sm text-gray-600 font-medium">Tanggal Verifikasi</p>
                                <p class="text-lg font-semibold text-gray-900">
                                    {{ $donasi->tanggal_verifikasi->locale('id_ID')->translatedFormat('j F Y H:i') }}
                                </p>
                            </div>

                            @if($donasi->catatan_verifikasi)
                                <div class="border-l-4 {{ $donasi->isVerified() ? 'border-green-500' : 'border-red-500' }} pl-4 py-2">
                                    <p class="text-sm text-gray-600 font-medium">Catatan</p>
                                    <p class="text-gray-900 mt-2 p-3 bg-gray-50 rounded">{{ $donasi->catatan_verifikasi }}</p>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="bg-gray-50 p-8 rounded-lg border border-gray-200 text-center">
                            <p class="text-gray-600">Belum ada riwayat verifikasi</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar - Action Panel -->
            <div class="lg:col-span-1">
                <!-- Status Card -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Status Saat Ini</h3>

                    <div class="p-4 rounded-lg {{ $donasi->status_verifikasi === 'Pending' ? 'bg-yellow-50 border border-yellow-200' : ($donasi->status_verifikasi === 'Valid' ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200') }}">
                        @if($donasi->status_verifikasi === 'Pending')
                            <p class="text-sm font-semibold text-yellow-800">⏳ Menunggu Verifikasi</p>
                            <p class="text-xs text-yellow-600 mt-2">Donasi ini belum diverifikasi oleh bendahara.</p>
                        @elseif($donasi->status_verifikasi === 'Valid')
                            <p class="text-sm font-semibold text-green-800"> Sudah Terverifikasi</p>
                            <p class="text-xs text-green-600 mt-2">Donasi ini telah diverifikasi dan diterima.</p>
                        @else
                            <p class="text-sm font-semibold text-red-800"> Ditolak</p>
                            <p class="text-xs text-red-600 mt-2">Donasi ini telah ditolak oleh bendahara.</p>
                        @endif
                    </div>
                </div>

                <!-- Action Buttons -->
                @if($donasi->status_verifikasi === 'Pending')
                    <div class="space-y-3">
                        <!-- Verify Button -->
                        <button
                            onclick="showModal('verifyModal')"
                            class="w-full bg-green-600 text-white py-3 rounded-lg font-semibold hover:bg-green-700 transition"
                        >
                             Verifikasi Donasi
                        </button>

                        <!-- Reject Button -->
                        <button
                            onclick="showModal('rejectModal')"
                            class="w-full bg-red-600 text-white py-3 rounded-lg font-semibold hover:bg-red-700 transition"
                        >
                             Tolak Donasi
                        </button>
                    </div>
                @else
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <p class="text-sm text-gray-600 text-center">Donasi sudah diproses</p>
                    </div>
                @endif

                <!-- Print Receipt Button -->
                @if($donasi->isVerified())
                    <div class="mt-4">
                        <a
                            href="{{ route('donasi.receipt', $donasi) }}"
                            target="_blank"
                            class="w-full block text-center bg-gray-900 text-white py-2 rounded-lg font-semibold hover:bg-gray-800 transition text-sm"
                        >
                             Lihat Kwitansi
                        </a>
                    </div>
                @endif

                <div class="mt-4">
                    <form id="donasiDel" action="{{ route('donasi.destroy', $donasi) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button"
                                onclick="simpaConfirm({ title:'Hapus Donasi', message:'Yakin ingin menghapus donasi {{ $donasi->nominal_formatted }} ini secara permanen?', confirmText:'Ya, Hapus', type:'danger', onConfirm:()=>document.getElementById('donasiDel').submit() })"
                                class="w-full bg-gray-200 text-gray-900 py-2 rounded-lg font-semibold hover:bg-gray-300 transition text-sm">
                             Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Verify Modal -->
<div id="verifyModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
        <h3 class="text-xl font-bold text-gray-900 mb-4">Verifikasi Donasi</h3>

        <form action="{{ route('donasi.verify', $donasi) }}" method="POST">
            @csrf
            @method('PATCH')

            <p class="text-sm text-gray-600 mb-4">
                Verifikasi donasi sebesar <strong>{{ $donasi->nominal_formatted }}</strong> dari <strong>{{ $donasi->nama_donatur_display }}</strong>?
            </p>

            <div class="mb-4">
                <label for="catatan" class="block text-sm font-medium text-gray-700 mb-2">Catatan Verifikasi</label>
                <textarea
                    id="catatan"
                    name="catatan"
                    rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500"
                >Terima kasih banyak atas donasinya, {{ $donasi->nama_donatur_display }}. Donasi Anda telah kami verifikasi dan akan segera kami salurkan kepada anak asuh.</textarea>
            </div>

            <div class="flex gap-3">
                <button
                    type="button"
                    onclick="hideModal('verifyModal')"
                    class="flex-1 px-4 py-2 bg-gray-200 text-gray-900 rounded-lg hover:bg-gray-300 transition"
                >
                    Batal
                </button>
                <button
                    type="submit"
                    class="flex-1 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold"
                >
                    Ya, Verifikasi
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
        <h3 class="text-xl font-bold text-gray-900 mb-4">Tolak Donasi</h3>

        <form action="{{ route('donasi.reject', $donasi) }}" method="POST">
            @csrf
            @method('PATCH')

            <p class="text-sm text-gray-600 mb-4">
                Tolak donasi sebesar <strong>{{ $donasi->nominal_formatted }}</strong>?
            </p>

            <div class="mb-4">
                <label for="catatan_tolak" class="block text-sm font-medium text-gray-700 mb-2">Alasan Penolakan <span class="text-red-500">*</span></label>
                <textarea
                    id="catatan_tolak"
                    name="catatan"
                    rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500"
                    placeholder="Alasan penolakan..."
                    required
                ></textarea>
            </div>

            <div class="flex gap-3">
                <button
                    type="button"
                    onclick="hideModal('rejectModal')"
                    class="flex-1 px-4 py-2 bg-gray-200 text-gray-900 rounded-lg hover:bg-gray-300 transition"
                >
                    Batal
                </button>
                <button
                    type="submit"
                    class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-semibold"
                >
                    Ya, Tolak
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function showModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
    }

    function hideModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }

    // Close modal when clicking outside
    document.addEventListener('click', function(e) {
        if (e.target.id === 'verifyModal') hideModal('verifyModal');
        if (e.target.id === 'rejectModal') hideModal('rejectModal');
    });
</script>
@endsection
