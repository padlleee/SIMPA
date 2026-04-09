@extends('layouts.app')

@section('title', 'Tambah Stok')
@section('page-title', 'Tambah Stok Barang')
@section('page-subtitle', 'Tambahkan barang ke gudang')

@section('content')
<div class="max-w-2xl">
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
    <form action="{{ route('stok.store') }}" method="POST" class="space-y-6">
        @csrf
        <div class="grid md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Barang <span class="text-red-500">*</span></label>
                <input type="text" name="nama_barang" value="{{ old('nama_barang') }}" required
                       class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 @error('nama_barang') border-red-400 @enderror">
                @error('nama_barang')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Kategori Barang</label>
                <select name="kategori_barang" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
                    <option value="Sembako" {{ old('kategori_barang') === 'Sembako' ? 'selected' : '' }}>Sembako</option>
                    <option value="Logistik" {{ old('kategori_barang') === 'Logistik' ? 'selected' : '' }}>Logistik</option>
                    <option value="Aset Tetap" {{ old('kategori_barang') === 'Aset Tetap' ? 'selected' : '' }}>Aset Tetap</option>
                    <option value="Lainnya" {{ old('kategori_barang') === 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Satuan</label>
                <input type="text" name="satuan" value="{{ old('satuan') }}" placeholder="cth: Dus / Pcs / Kg"
                       class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Kondisi</label>
                <select name="kondisi" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
                    <option value="Baik" {{ old('kondisi') === 'Baik' ? 'selected' : '' }}>Baik</option>
                    <option value="Rusak" {{ old('kondisi') === 'Rusak' ? 'selected' : '' }}>Rusak</option>
                    <option value="Perlu Perbaikan" {{ old('kondisi') === 'Perlu Perbaikan' ? 'selected' : '' }}>Perlu Perbaikan</option>
                </select>
            </div>
            
            <div class="md:col-span-2 pt-4 border-t border-slate-100 grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Stok Awal <span class="text-red-500">*</span></label>
                    <input type="number" id="stok_awal" name="stok_awal" value="{{ old('stok_awal', 0) }}" min="0" required
                           class="calc-stok w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Barang Masuk <span class="text-red-500">*</span></label>
                    <input type="number" id="barang_masuk" name="barang_masuk" value="{{ old('barang_masuk', 0) }}" min="0" required
                           class="calc-stok w-full border flex-1 border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 border-green-300 bg-green-50">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Barang Keluar <span class="text-red-500">*</span></label>
                    <input type="number" id="barang_keluar" name="barang_keluar" value="{{ old('barang_keluar', 0) }}" min="0" required
                           class="calc-stok w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 border-red-300 bg-red-50">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Stok Akhir <span class="text-slate-400 font-normal">(Otomatis)</span></label>
                <input type="number" id="stok_akhir" name="stok_akhir" value="{{ old('stok_akhir', 0) }}" min="0" readonly
                       class="w-full bg-slate-100 text-slate-500 border border-slate-200 rounded-xl px-4 py-3 font-bold">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Keterangan</label>
                <textarea name="keterangan" rows="2"
                       class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800"
                       placeholder="Opsional">{{ old('keterangan') }}</textarea>
            </div>
        </div>
        
        <div class="flex gap-3 pt-4 border-t border-slate-100">
            <button type="submit" class="bg-slate-800 text-white px-8 py-3 rounded-xl font-semibold hover:bg-slate-700 transition-colors">Simpan Barang</button>
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
