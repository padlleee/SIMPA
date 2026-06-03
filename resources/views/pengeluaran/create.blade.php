@extends('layouts.app')

@section('title', 'Catat Pengeluaran')
@section('page-title', 'Catat Pengeluaran')

@section('content')
<div class="max-w-xl">
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
    <form action="{{ route('pengeluaran.store') }}" method="POST" class="space-y-5">
        @csrf
        <div class="grid md:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal <span class="text-red-500">*</span></label>
                 <input type="date" name="tanggal_pengeluaran" value="{{ old('tanggal_pengeluaran', date('Y-m-d')) }}"
                       class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
                         @error('tanggal_pengeluaran')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                  <select name="kategori_biaya" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 @error('kategori_biaya') border-red-400 @enderror">
                      <option value="" disabled {{ old('kategori_biaya') ? '' : 'selected' }}>Pilih Kategori</option>
                      <option value="Makan" {{ old('kategori_biaya') == 'Makan' ? 'selected' : '' }}>Makan / Pangan</option>
                      <option value="Kesehatan" {{ old('kategori_biaya') == 'Kesehatan' ? 'selected' : '' }}>Kesehatan / Medis</option>
                      <option value="Pendidikan" {{ old('kategori_biaya') == 'Pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                      <option value="Pakaian" {{ old('kategori_biaya') == 'Pakaian' ? 'selected' : '' }}>Pakaian</option>
                      <option value="Operasional Panti" {{ old('kategori_biaya') == 'Operasional Panti' ? 'selected' : '' }}>Operasional Panti</option>
                      <option value="Transportasi" {{ old('kategori_biaya') == 'Transportasi' ? 'selected' : '' }}>Transportasi</option>
                      <option value="Lainnya" {{ old('kategori_biaya') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                  </select>
                @error('kategori_biaya')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
        </div>
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Jumlah (Rp) <span class="text-red-500">*</span></label>
            <div class="relative">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 font-medium">Rp</span>
                <input type="text" name="nominal" value="{{ old('nominal') }}" required
                       oninvalid="this.setCustomValidity('Wajib diisi')"
                       oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 12); this.setCustomValidity('')"
                       maxlength="12"
                       class="w-full border border-slate-300 rounded-xl pl-12 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 @error('nominal') border-red-400 @enderror">

            </div>
            @error('nominal')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Keterangan</label>
            <textarea name="keterangan" rows="2"
                      class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800"
                      placeholder="Tujuan & nomor nota...">{{ old('keterangan') }}</textarea>
                        @error('keterangan')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-slate-800 text-white px-8 py-3 rounded-xl font-semibold hover:bg-slate-700 transition-colors">Simpan</button>
            <a href="{{ route('pengeluaran.index') }}" class="bg-slate-100 text-slate-700 px-8 py-3 rounded-xl font-semibold hover:bg-slate-200 transition-colors">Batal</a>
        </div>
    </form>
</div>
</div>
@endsection
