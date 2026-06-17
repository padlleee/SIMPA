@extends('layouts.app')

@section('title', 'Transaksi Stok')
@section('page-title', 'Transaksi Stok Barang')
@section('page-subtitle', 'Catat penambahan atau pengurangan stok barang')

@section('content')
<div class="max-w-2xl">
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
    <div class="mb-6 pb-6 border-b border-slate-100">
        <h3 class="text-lg font-bold text-slate-800">{{ $stok->nama_barang }}</h3>
        <p class="text-sm text-slate-500 mt-1">Kategori: {{ $stok->kategori_barang }} &nbsp;&bull;&nbsp; Satuan: {{ $stok->satuan }}</p>
    </div>

    <form action="{{ route('stok.storeTransaksi', $stok) }}" method="POST" class="space-y-6">
        @csrf
        
        <div class="grid md:grid-cols-2 gap-6">
            <div class="md:col-span-2 grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Stok Saat Ini (Awal)</label>
                    <input type="number" id="stok_awal" name="stok_awal" value="{{ old('stok_awal', $stok->stok_akhir) }}" readonly
                           class="w-full bg-slate-100 border border-slate-300 rounded-xl px-4 py-3 text-slate-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Barang Masuk</label>
                    <input type="number" id="barang_masuk" name="barang_masuk" value="{{ old('barang_masuk', 0) }}" min="0" required
                           class="calc-stok w-full border border-green-300 bg-green-50 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Barang Keluar</label>
                    <input type="number" id="barang_keluar" name="barang_keluar" value="{{ old('barang_keluar', 0) }}" min="0" required
                           class="calc-stok w-full border border-red-300 bg-red-50 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 @error('barang_keluar') border-red-500 @enderror">
                    @error('barang_keluar')<p class="text-red-600 text-xs mt-1 font-semibold">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Stok Akhir <span class="text-slate-400 font-normal">(Otomatis)</span></label>
                <input type="number" id="stok_akhir" name="stok_akhir" value="{{ old('stok_akhir', $stok->stok_akhir) }}" readonly
                       class="w-full bg-slate-100 text-slate-600 border border-slate-200 rounded-xl px-4 py-3 font-bold text-lg">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Keterangan Transaksi</label>
                <textarea name="keterangan" rows="2"
                       class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800"
                       placeholder="Contoh: Bantuan donatur, dipakai untuk masak harian...">{{ old('keterangan') }}</textarea>
            </div>
        </div>
        
        <div class="flex gap-3 pt-4 border-t border-slate-100">
            <button type="submit" class="bg-slate-800 text-white px-8 py-3 rounded-xl font-semibold hover:bg-slate-700 transition-colors">Simpan Transaksi</button>
            <a href="{{ route('stok.index') }}" class="bg-slate-100 text-slate-700 px-8 py-3 rounded-xl font-semibold hover:bg-slate-200 transition-colors">Batal</a>
        </div>
    </form>
</div>
</div>

<script>
    const inputs = document.querySelectorAll('.calc-stok');
    const out = document.getElementById('stok_akhir');
    
    function hitung() {
        const awal = parseInt(document.getElementById('stok_awal').value) || 0;
        const masuk = parseInt(document.getElementById('barang_masuk').value) || 0;
        const keluar = parseInt(document.getElementById('barang_keluar').value) || 0;
        out.value = awal + masuk - keluar;
    }
    
    inputs.forEach(input => input.addEventListener('input', hitung));
</script>
@endsection
