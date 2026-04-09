@extends('layouts.app')

@section('title', 'Perpustakaan')
@section('page-title', 'Perpustakaan')
@section('page-subtitle', 'Kelola koleksi buku dan peminjaman')

@section('content')

<!-- Search & Add -->
<div class="flex flex-col sm:flex-row gap-4 mb-6">
    <form action="{{ route('perpustakaan.index') }}" method="GET" class="flex gap-3 flex-1">
        <div class="relative flex-1 max-w-sm">
            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul, pengarang, kode..."
                   class="w-full pl-10 pr-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-slate-800">
        </div>
        <button type="submit" class="bg-slate-800 text-white px-5 py-2.5 rounded-xl text-sm font-medium hover:bg-slate-700">Cari</button>
    </form>
    <a href="{{ route('perpustakaan.create') }}" class="bg-slate-800 text-white px-5 py-2.5 rounded-xl text-sm font-medium hover:bg-slate-700 transition-colors flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Buku
    </a>
</div>

<!-- Book Table -->
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-8">
    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
        <h3 class="font-bold text-slate-700">Koleksi Buku</h3>
    </div>
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-slate-100">
                <th class="text-left px-6 py-3 font-semibold text-slate-500">Kode</th>
                <th class="text-left px-4 py-3 font-semibold text-slate-500">Judul Buku</th>
                <th class="text-left px-4 py-3 font-semibold text-slate-500">Pengarang</th>
                <th class="text-center px-4 py-3 font-semibold text-slate-500">Jumlah</th>
                <th class="text-center px-4 py-3 font-semibold text-slate-500">Dipinjam</th>
                <th class="text-right px-6 py-3 font-semibold text-slate-500">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($buku as $item)
            <tr class="hover:bg-slate-50 transition-colors">
                <td class="px-6 py-4 font-mono text-slate-600 text-xs">{{ $item->kode_buku }}</td>
                <td class="px-4 py-4 font-semibold text-slate-800">{{ $item->judul_buku }}</td>
                <td class="px-4 py-4 text-slate-600">{{ $item->pengarang }}</td>
                <td class="px-4 py-4 text-center text-slate-700">{{ $item->jumlah_buku }}</td>
                <td class="px-4 py-4 text-center">
                    @if($item->dipinjam_count > 0)
                    <span class="bg-amber-100 text-amber-700 text-xs font-semibold px-2.5 py-1 rounded-full">{{ $item->dipinjam_count }}</span>
                    @else
                    <span class="text-slate-400 text-xs">—</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center justify-end gap-2">
                        @if($item->dipinjam_count < $item->jumlah_buku)
                        <a href="{{ route('perpustakaan.pinjam', $item) }}" class="px-3 py-1.5 text-xs font-semibold bg-slate-800 text-white rounded-lg hover:bg-slate-700 transition-colors">
                            Pinjamkan
                        </a>
                        @else
                        <span class="px-3 py-1.5 text-xs font-semibold bg-slate-100 text-slate-400 rounded-lg">Habis</span>
                        @endif
                        <a href="{{ route('perpustakaan.edit', $item) }}" class="p-2 text-slate-500 hover:text-slate-800 hover:bg-slate-100 rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>
                        <form action="{{ route('perpustakaan.destroy', $item) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                    onclick="return confirm('Hapus buku ini?')">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-16 text-center text-slate-400">
                    <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13"/></svg>
                    <p>Belum ada koleksi buku</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @if($buku->hasPages())
    <div class="px-6 py-4 border-t border-slate-100">{{ $buku->links() }}</div>
    @endif
</div>

<!-- Active Loans Table -->
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex items-center justify-between">
        <h3 class="font-bold text-slate-700">Peminjaman Aktif</h3>
        <span class="bg-amber-100 text-amber-700 text-xs font-semibold px-2.5 py-1 rounded-full">{{ $peminjamanAktif->count() }} Dipinjam</span>
    </div>
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-slate-100">
                <th class="text-left px-6 py-3 font-semibold text-slate-500">Buku</th>
                <th class="text-left px-4 py-3 font-semibold text-slate-500">Peminjam</th>
                <th class="text-left px-4 py-3 font-semibold text-slate-500">Tgl Pinjam</th>
                <th class="text-left px-4 py-3 font-semibold text-slate-500">Batas Kembali</th>
                <th class="text-right px-6 py-3 font-semibold text-slate-500">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($peminjamanAktif as $pinjam)
            <tr class="hover:bg-slate-50 transition-colors {{ $pinjam->tanggal_kembali && $pinjam->tanggal_kembali->isPast() ? 'bg-red-50' : '' }}">
                <td class="px-6 py-4 font-semibold text-slate-800">{{ $pinjam->buku?->judul_buku ?? '-' }}</td>
                <td class="px-4 py-4 text-slate-600">{{ $pinjam->nama_peminjam }}</td>
                <td class="px-4 py-4 text-slate-600">{{ $pinjam->tanggal_pinjam?->format('d/m/Y') }}</td>
                <td class="px-4 py-4">
                    <span class="{{ $pinjam->tanggal_kembali && $pinjam->tanggal_kembali->isPast() ? 'text-red-600 font-semibold' : 'text-slate-600' }}">
                        {{ $pinjam->tanggal_kembali?->format('d/m/Y') ?? '-' }}
                        @if($pinjam->tanggal_kembali && $pinjam->tanggal_kembali->isPast())
                        <span class="text-xs ml-1">(Terlambat)</span>
                        @endif
                    </span>
                </td>
                <td class="px-6 py-4 text-right">
                    <form action="{{ route('peminjaman.kembalikan', $pinjam) }}" method="POST">
                        @csrf @method('PATCH')
                        <button type="submit" class="px-3 py-1.5 text-xs font-semibold bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors"
                                onclick="return confirm('Konfirmasi pengembalian buku?')">
                            ✓ Dikembalikan
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-10 text-center text-slate-400 text-sm">Tidak ada peminjaman aktif</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
