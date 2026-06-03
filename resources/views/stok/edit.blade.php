@extends('layouts.app')

@section('title', 'Edit Stok')
@section('page-title', 'Edit Stok Barang')
@section('page-subtitle', 'Perbarui master data barang')

@section('content')
<div class="max-w-2xl">
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
    <form action="{{ route('stok.update', $stok) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        <div class="grid md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Barang <span class="text-red-500">*</span></label>
                <input type="text" name="nama_barang" value="{{ old('nama_barang', $stok->nama_barang) }}" required
                       placeholder="Contoh: Beras, Minyak Goreng..."
                       class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 @error('nama_barang') border-red-400 @enderror">
                @error('nama_barang')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Kategori Barang</label>
                <select id="kategori_barang" name="kategori_barang" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800" onchange="toggleKategoriLainnya(this.value)">
                    @foreach($kategoriList as $kat)
                        <option value="{{ $kat }}" {{ old('kategori_barang', $stok->kategori_barang) === $kat ? 'selected' : '' }}>{{ $kat }}</option>
                    @endforeach
                    <option value="Lainnya" {{ old('kategori_barang', $stok->kategori_barang) === 'Lainnya' ? 'selected' : '' }}>Kategori Lainnya...</option>
                </select>
                
                <div id="kategori_lainnya_container" class="mt-3 {{ old('kategori_barang', $stok->kategori_barang) === 'Lainnya' ? '' : 'hidden' }}">
                    <input type="text" id="kategori_barang_lainnya" name="kategori_barang_lainnya" value="{{ old('kategori_barang_lainnya') }}" 
                           placeholder="Masukkan nama kategori baru" 
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 @error('kategori_barang_lainnya') border-red-400 @enderror">
                    @error('kategori_barang_lainnya')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Satuan</label>
                <select name="satuan" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
                    @php $satuan = old('satuan', $stok->satuan); @endphp
                    <option value="" disabled {{ $satuan ? '' : 'selected' }}>Pilih Satuan</option>
                    <option value="Kg" {{ $satuan == 'Kg' ? 'selected' : '' }}>Kg (Kilogram)</option>
                    <option value="Liter" {{ $satuan == 'Liter' ? 'selected' : '' }}>Liter</option>
                    <option value="Pcs" {{ $satuan == 'Pcs' ? 'selected' : '' }}>Pcs (Pieces)</option>
                    <option value="Dus" {{ $satuan == 'Dus' ? 'selected' : '' }}>Dus / Karton</option>
                    <option value="Box" {{ $satuan == 'Box' ? 'selected' : '' }}>Box</option>
                    <option value="Karung" {{ $satuan == 'Karung' ? 'selected' : '' }}>Karung</option>
                    <option value="Lainnya" {{ !in_array($satuan, ['Kg', 'Liter', 'Pcs', 'Dus', 'Box', 'Karung', '']) ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Keterangan</label>
                <textarea name="keterangan" rows="2"
                       class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800"
                       placeholder="Keterangan spesifikasi...">{{ old('keterangan', $stok->keterangan) }}</textarea>
            </div>
        </div>
        
        <div class="flex gap-3 pt-4 border-t border-slate-100">
            <button type="submit" class="bg-slate-800 text-white px-8 py-3 rounded-xl font-semibold hover:bg-slate-700 transition-colors">Perbarui Data</button>
            <a href="{{ route('stok.index') }}" class="bg-slate-100 text-slate-700 px-8 py-3 rounded-xl font-semibold hover:bg-slate-200 transition-colors">Batal</a>
        </div>
    </form>
</div>
</div>

<script>
    function toggleKategoriLainnya(value) {
        const container = document.getElementById('kategori_lainnya_container');
        const input = document.getElementById('kategori_barang_lainnya');
        if (value === 'Lainnya') {
            container.classList.remove('hidden');
            input.required = true;
        } else {
            container.classList.add('hidden');
            input.required = false;
            input.value = ''; // Reset the value if they select something else
        }
    }
</script>
@endsection
