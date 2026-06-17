@extends('layouts.app')

@section('title', 'Catat Donasi Manual')
@section('page-title', 'Catat Donasi Manual')
@section('page-subtitle', 'Masukkan data donasi tunai atau sembako secara manual')

@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
        <form action="{{ route('donasi.adminStore') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Jenis Donasi -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Jenis Donasi <span class="text-red-500">*</span></label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="cursor-pointer group">
                            <input type="radio" name="jenis_donasi" value="uang" class="peer sr-only" {{ old('jenis_donasi', 'uang') === 'uang' ? 'checked' : '' }}>
                            <div class="p-4 border-2 border-slate-200 rounded-xl peer-checked:border-slate-800 peer-checked:bg-slate-50 transition-all text-center group-hover:border-slate-300">
                                <svg class="w-6 h-6 mx-auto mb-2 text-slate-400 peer-checked:text-slate-800 group-hover:text-slate-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="font-semibold text-slate-500 peer-checked:text-slate-800 group-hover:text-slate-700 transition-colors">Donasi Tunai</span>
                            </div>
                        </label>
                        <label class="cursor-pointer group">
                            <input type="radio" name="jenis_donasi" value="sembako" class="peer sr-only" {{ old('jenis_donasi') === 'sembako' ? 'checked' : '' }}>
                            <div class="p-4 border-2 border-slate-200 rounded-xl peer-checked:border-emerald-600 peer-checked:bg-emerald-50 transition-all text-center group-hover:border-emerald-300">
                                <svg class="w-6 h-6 mx-auto mb-2 text-slate-400 peer-checked:text-emerald-600 group-hover:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                <span class="font-semibold text-slate-500 peer-checked:text-emerald-700 group-hover:text-emerald-600 transition-colors">Donasi Sembako</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Nama Donatur -->
                <div class="md:col-span-2">
                    <label for="nama_donatur" class="block text-sm font-semibold text-slate-700 mb-2">Nama Donatur <span class="text-red-500">*</span></label>
                    <input type="text" id="nama_donatur" name="nama_donatur" value="{{ old('nama_donatur') }}" required placeholder="Masukkan nama lengkap / instansi" class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-slate-800 @error('nama_donatur') border-red-500 @enderror">
                    @error('nama_donatur')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Tanggal Donasi -->
                <div class="md:col-span-2">
                    <label for="tanggal_donasi" class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Donasi <span class="text-red-500">*</span></label>
                    <input type="date" id="tanggal_donasi" name="tanggal_donasi" value="{{ old('tanggal_donasi', date('Y-m-d')) }}" required class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-slate-800 @error('tanggal_donasi') border-red-500 @enderror">
                    @error('tanggal_donasi')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <!-- Bagian Form Uang -->
            <div id="form-uang" class="space-y-6 pt-6 border-t border-slate-100">
                <h3 class="text-lg font-bold text-slate-800">Detail Donasi Tunai</h3>
                <div>
                    <label for="nominal" class="block text-sm font-semibold text-slate-700 mb-2">Nominal Donasi <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 font-medium">Rp</span>
                        <input type="number" id="nominal" name="nominal" value="{{ old('nominal') }}" placeholder="Contoh: 50000" class="w-full pl-12 pr-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-slate-800 @error('nominal') border-red-500 @enderror">
                    </div>
                    @error('nominal')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <!-- Bagian Form Sembako -->
            <div id="form-sembako" class="space-y-6 pt-6 border-t border-slate-100 hidden">
                <div class="flex items-center justify-between border-b border-emerald-100 pb-4 mb-4">
                    <h3 class="text-lg font-bold text-emerald-700">Detail Sembako</h3>
                    <span class="text-[10px] sm:text-xs bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full font-bold uppercase tracking-wider">Otomatis Masuk Gudang</span>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="nama_barang" class="block text-sm font-semibold text-slate-700 mb-2">Nama Barang <span class="text-red-500">*</span></label>
                        <input type="text" id="nama_barang" name="nama_barang" value="{{ old('nama_barang') }}" list="stok-list" placeholder="Contoh: Beras, Minyak Goreng..." class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-slate-800 @error('nama_barang') border-red-500 @enderror">
                        <datalist id="stok-list">
                            @if(isset($stokList))
                                @foreach($stokList as $stokId => $stokName)
                                    <option value="{{ $stokName }}">
                                @endforeach
                            @endif
                        </datalist>
                        <p class="text-xs text-slate-400 mt-1">Anda bisa memilih barang yang sudah ada di gudang atau mengetikkan nama barang baru.</p>
                        @error('nama_barang')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="jumlah" class="block text-sm font-semibold text-slate-700 mb-2">Jumlah Barang <span class="text-red-500">*</span></label>
                        <input type="number" id="jumlah" name="jumlah" value="{{ old('jumlah') }}" min="1" placeholder="Contoh: 10" class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-slate-800 @error('jumlah') border-red-500 @enderror">
                        @error('jumlah')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="satuan" class="block text-sm font-semibold text-slate-700 mb-2">Satuan <span class="text-red-500">*</span></label>
                        <select id="satuan" name="satuan" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 @error('satuan') border-red-500 @enderror">
                            <option value="" disabled {{ old('satuan') ? '' : 'selected' }}>Pilih Satuan</option>
                            <option value="Kg" {{ old('satuan') == 'Kg' ? 'selected' : '' }}>Kg (Kilogram)</option>
                            <option value="Liter" {{ old('satuan') == 'Liter' ? 'selected' : '' }}>Liter</option>
                            <option value="Pcs" {{ old('satuan') == 'Pcs' ? 'selected' : '' }}>Pcs (Pieces)</option>
                            <option value="Dus" {{ old('satuan') == 'Dus' ? 'selected' : '' }}>Dus / Karton</option>
                            <option value="Box" {{ old('satuan') == 'Box' ? 'selected' : '' }}>Box</option>
                            <option value="Karung" {{ old('satuan') == 'Karung' ? 'selected' : '' }}>Karung</option>
                            <option value="Lainnya" {{ old('satuan') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('satuan')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="merk" class="block text-sm font-semibold text-slate-700 mb-2">Merk / Merek <span class="font-normal text-slate-400">(opsional)</span></label>
                        <input type="text" id="merk" name="merk" value="{{ old('merk') }}" placeholder="Contoh: Bimoli, Rose Brand..." class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-slate-800 @error('merk') border-red-500 @enderror">
                        @error('merk')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="tanggal_kadaluarsa" class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Kadaluarsa <span class="font-normal text-slate-400">(opsional)</span></label>
                        <input type="date" id="tanggal_kadaluarsa" name="tanggal_kadaluarsa" value="{{ old('tanggal_kadaluarsa') }}" class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-slate-800 @error('tanggal_kadaluarsa') border-red-500 @enderror">
                        <p class="text-xs text-slate-400 mt-1">Kosongkan jika barang tidak memiliki kadaluarsa.</p>
                        @error('tanggal_kadaluarsa')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <div class="pt-6 flex gap-3 border-t border-slate-100">
                <button type="submit" class="bg-slate-800 text-white px-8 py-3 rounded-xl font-semibold hover:bg-slate-700 transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Simpan Donasi
                </button>
                <a href="{{ route('donasi.index') }}" class="bg-slate-100 text-slate-700 px-8 py-3 rounded-xl font-semibold hover:bg-slate-200 transition-colors">Batal</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const radios = document.querySelectorAll('input[name="jenis_donasi"]');
        const formUang = document.getElementById('form-uang');
        const formSembako = document.getElementById('form-sembako');

        // Input elements
        const nominalInput = document.getElementById('nominal');
        const barangInput = document.getElementById('nama_barang');
        const jumlahInput = document.getElementById('jumlah');
        const satuanInput = document.getElementById('satuan');

        function toggleForms() {
            const selectedRadio = document.querySelector('input[name="jenis_donasi"]:checked');
            if (!selectedRadio) return;
            const selected = selectedRadio.value;
            
            if (selected === 'uang') {
                formUang.classList.remove('hidden');
                formSembako.classList.add('hidden');
                
                // Set required
                nominalInput.required = true;
                
                // Unset required for sembako
                barangInput.required = false;
                jumlahInput.required = false;
                satuanInput.required = false;
                
            } else {
                formUang.classList.add('hidden');
                formSembako.classList.remove('hidden');
                
                // Unset required
                nominalInput.required = false;
                
                // Set required for sembako
                barangInput.required = true;
                jumlahInput.required = true;
                satuanInput.required = true;
            }
        }

        radios.forEach(radio => {
            radio.addEventListener('change', toggleForms);
        });

        // Initial call to set correct state
        toggleForms();
    });
</script>
@endpush
@endsection
