@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Manajemen Donasi</h1>
            <p class="text-gray-600 mt-2">Verifikasi dan kelola semua donasi masuk</p>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            @php
                $stats = (new \App\Http\Controllers\DonasiController)->getAdminStats();
            @endphp

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Menunggu Verifikasi</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $stats['pending'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                        <span class="text-xl">⏳</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Terverifikasi</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $stats['verified'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <span class="text-xl">✓</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Ditolak</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $stats['rejected'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                        <span class="text-xl">✗</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Total Terverifikasi</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['totalDonations_formatted'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center">
                        <span class="text-xl">💰</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter & Search -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <form method="GET" class="flex flex-col md:flex-row gap-4">
                <!-- Status Filter -->
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500">
                        <option value="">Semua Status</option>
                        <option value="Pending" @selected(request('status') === 'Pending')>Menunggu Verifikasi</option>
                        <option value="Valid" @selected(request('status') === 'Valid')>Terverifikasi</option>
                        <option value="Tolak" @selected(request('status') === 'Tolak')>Ditolak</option>
                    </select>
                </div>

                <!-- Date Range -->
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Dari Tanggal</label>
                    <input type="date" name="dari_tanggal" value="{{ request('dari_tanggal') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>

                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sampai Tanggal</label>
                    <input type="date" name="sampai_tanggal" value="{{ request('sampai_tanggal') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-2 items-end">
                    <button type="submit" class="px-6 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition">
                        Filter
                    </button>
                    <a href="{{ route('donasi.index') }}" class="px-6 py-2 bg-gray-200 text-gray-900 rounded-lg hover:bg-gray-300 transition">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Donations Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            @if($donasi->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-100 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Nama Donatur</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Nominal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Metode</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($donasi as $item)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 text-sm">
                                        <div class="font-medium text-gray-900">{{ $item->nama_donatur_display }}</div>
                                        @if($item->donatur)
                                            <div class="text-xs text-gray-500">{{ $item->donatur->email ?? '-' }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                        {{ $item->nominal_formatted }}
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <span class="inline-block px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-medium">
                                            {{ $item->metode_pembayaran }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $item->tanggal_donasi->locale('id_ID')->translatedFormat('j F Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        @if($item->status_verifikasi === 'Pending')
                                            <span class="inline-block px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium">
                                                ⏳ Menunggu
                                            </span>
                                        @elseif($item->status_verifikasi === 'Valid')
                                            <span class="inline-block px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">
                                                ✓ Terverifikasi
                                            </span>
                                        @else
                                            <span class="inline-block px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-medium">
                                                ✗ Ditolak
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <a href="{{ route('donasi.show', $item) }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                        Tidak ada data donasi
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="bg-white px-6 py-4 border-t border-gray-200">
                    {{ $donasi->links('pagination::tailwind') }}
                </div>
            @else
                <div class="p-12 text-center">
                    <div class="text-6xl mb-4">📭</div>
                    <p class="text-gray-600 text-lg">Tidak ada data donasi</p>
                    <p class="text-gray-500 text-sm mt-2">Belum ada donasi yang masuk sesuai filter yang dipilih.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
