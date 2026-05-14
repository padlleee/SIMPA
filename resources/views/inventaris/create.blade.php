@extends('layouts.app')

@section('title', 'Tambah Aset')
@section('page-title', 'Tambah Aset Peralatan')
@section('page-subtitle', 'Daftarkan peralatan baru')

@section('content')
<div class="max-w-xl">
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
    <form action="{{ route('inventaris.store') }}" method="POST" class="space-y-5">
        @csrf
        <div class="grid md:grid-cols-2 gap-5">
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Barang <span class="text-red-500">*</span></label>
                <input type="text" name="nama_barang" value="{{ old('nama_barang') }}"
                       class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 @error('nama_barang') border-red-400 @enderror">
                @error('nama_barang')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Kode Barang</label>
                <input type="text" name="kode_barang" value="{{ old('kode_barang', $newKodeBarang ?? '') }}" readonly
                       class="w-full border border-slate-300 bg-slate-50 text-slate-500 rounded-xl px-4 py-3 focus:outline-none cursor-not-allowed">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Jumlah <span class="text-red-500">*</span></label>
                <input type="number" name="jumlah" value="{{ old('jumlah', 1) }}" min="1"
                       class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Satuan <span class="text-red-500">*</span></label>
                <select name="satuan" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 @error('satuan') border-red-400 @enderror">
                    <option value="" disabled {{ old('satuan') ? '' : 'selected' }}>Pilih Satuan</option>
                    <option value="Unit" {{ old('satuan') === 'Unit' ? 'selected' : '' }}>Unit</option>
                    <option value="Buah" {{ old('satuan') === 'Buah' ? 'selected' : '' }}>Buah</option>
                    <option value="Set" {{ old('satuan') === 'Set' ? 'selected' : '' }}>Set</option>
                    <option value="Pcs" {{ old('satuan') === 'Pcs' ? 'selected' : '' }}>Pcs</option>
                    <option value="Lusin" {{ old('satuan') === 'Lusin' ? 'selected' : '' }}>Lusin</option>
                    <option value="Box" {{ old('satuan') === 'Box' ? 'selected' : '' }}>Box</option>
                    <option value="Lainnya" {{ old('satuan') === 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
                @error('satuan')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Lokasi</label>
                <input type="text" name="lokasi" value="{{ old('lokasi') }}" placeholder="cth: Kantor, Dapur"
                       class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Kondisi <span class="text-red-500">*</span></label>
                <select name="kondisi" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
                    <option value="Baik" {{ old('kondisi', 'Baik') === 'Baik' ? 'selected' : '' }}>Baik</option>
                    <option value="Rusak" {{ old('kondisi') === 'Rusak' ? 'selected' : '' }}>Rusak</option>
                </select>
            </div>
        </div>
        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-slate-800 text-white px-8 py-3 rounded-xl font-semibold hover:bg-slate-700 transition-colors">Simpan</button>
            <a href="{{ route('inventaris.index') }}" class="bg-slate-100 text-slate-700 px-8 py-3 rounded-xl font-semibold hover:bg-slate-200 transition-colors">Batal</a>
        </div>
    </form>
</div>
</div>
@endsection
