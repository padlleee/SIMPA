@extends('layouts.app')

@section('title', 'Tambah Peralatan')
@section('page-title', 'Tambah Data Peralatan')
@section('page-subtitle', 'Daftarkan peralatan atau inventaris baru ke dalam kategori')

@section('content')
<div class="max-w-xl">
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
    <form action="{{ route('inventaris.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf
        <div class="grid md:grid-cols-2 gap-5">

            {{-- KATEGORI (Pengelompokan) --}}
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Kategori Peralatan <span class="text-red-500">*</span>
                    <span class="text-xs text-slate-400 font-normal ml-1">— Digunakan untuk pengelompokan (contoh: Kulkas, Meja, Kipas Angin)</span>
                </label>
                <select id="nama_kategori" name="nama_kategori"
                        class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 @error('nama_kategori') border-red-400 @enderror"
                        onchange="toggleKategoriLainnya(this.value)">
                    <option value="" disabled {{ old('nama_kategori') ? '' : 'selected' }}>Pilih Kategori</option>
                    @foreach($kategoriList as $kat)
                        <option value="{{ $kat }}" {{ old('nama_kategori') === $kat ? 'selected' : '' }}>{{ $kat }}</option>
                    @endforeach
                    <option value="Lainnya" {{ old('nama_kategori') === 'Lainnya' ? 'selected' : '' }}>Lainnyas</option>
                </select>

                {{-- Input kategori baru --}}
                <div id="kategori_lainnya_container" class="mt-3 {{ old('nama_kategori') === 'Lainnya' ? '' : 'hidden' }}">
                    <input type="text" id="nama_kategori_lainnya" name="nama_kategori_lainnya"
                           value="{{ old('nama_kategori_lainnya') }}"
                           placeholder="Masukkan nama kategori baru, contoh: Meja Tamu, Proyektor..."
                           class="w-full border border-indigo-300 bg-indigo-50 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('nama_kategori_lainnya') border-red-400 @enderror">
                    @error('nama_kategori_lainnya')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                @error('nama_kategori')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- NAMA BARANG (Spesifik) --}}
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Nama Barang Spesifik <span class="text-red-500">*</span>
                    <span class="text-xs text-slate-400 font-normal ml-1">— Nama unik per unit (contoh: Kulkas Sony 200L, Kulkas Polytron)</span>
                </label>
                <input type="text" name="nama_barang" id="nama_barang" value="{{ old('nama_barang') }}" required
                       placeholder="Contoh: Kulkas Sony 200L, Meja Tamu Kayu Jati..."
                       class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 @error('nama_barang') border-red-400 @enderror">
                @error('nama_barang')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- KODE BARANG --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Kode Barang</label>
                <input type="text" name="kode_barang" value="{{ old('kode_barang', $newKodeBarang ?? '') }}" readonly
                       class="w-full border border-slate-300 bg-slate-50 text-slate-500 rounded-xl px-4 py-3 focus:outline-none cursor-not-allowed">
            </div>

            {{-- JUMLAH --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Jumlah <span class="text-red-500">*</span></label>
                <input type="number" name="jumlah" value="{{ old('jumlah', 1) }}" min="1" required
                       class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 @error('jumlah') border-red-400 @enderror">
                @error('jumlah')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- SATUAN --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Satuan <span class="text-red-500">*</span></label>
                <select name="satuan" id="satuan" onchange="toggleSatuanLainnya(this.value)"
                        class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 @error('satuan') border-red-400 @enderror">
                    <option value="" disabled {{ old('satuan') ? '' : 'selected' }}>Pilih Satuan</option>
                    <option value="Unit" {{ old('satuan') === 'Unit' ? 'selected' : '' }}>Unit</option>
                    <option value="Buah" {{ old('satuan') === 'Buah' ? 'selected' : '' }}>Buah</option>
                    <option value="Set" {{ old('satuan') === 'Set' ? 'selected' : '' }}>Set</option>
                    <option value="Pasang" {{ old('satuan') === 'Pasang' ? 'selected' : '' }}>Pasang</option>
                    <option value="Lembar" {{ old('satuan') === 'Lembar' ? 'selected' : '' }}>Lembar</option>
                    <option value="Pak" {{ old('satuan') === 'Pak' ? 'selected' : '' }}>Pak</option>
                    <option value="Kotak" {{ old('satuan') === 'Kotak' ? 'selected' : '' }}>Kotak</option>
                    <option value="Rol" {{ old('satuan') === 'Rol' ? 'selected' : '' }}>Rol</option>
                    <option value="Lainnya" {{ old('satuan') === 'Lainnya' ? 'selected' : '' }}>Lainya</option>
                </select>
                
                {{-- Input satuan baru --}}
                <div id="satuan_lainnya_container" class="mt-3 {{ old('satuan') === 'Lainnya' ? '' : 'hidden' }}">
                    <input type="text" id="satuan_lainnya" name="satuan_lainnya"
                           value="{{ old('satuan_lainnya') }}"
                           placeholder="Masukkan satuan baru..."
                           class="w-full border border-indigo-300 bg-indigo-50 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('satuan_lainnya') border-red-400 @enderror">
                    @error('satuan_lainnya')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                @error('satuan')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- LOKASI --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Lokasi <span class="text-red-500">*</span></label>
                <input type="text" name="lokasi" value="{{ old('lokasi') }}" placeholder="Contoh: Gedung A, Lantai 1..." required
                       class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 @error('lokasi') border-red-400 @enderror">
                @error('lokasi')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- RUANGAN --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Ruangan</label>
                <select name="ruangan" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
                    <option value="">-- Tidak Spesifik --</option>
                    @foreach(\App\Models\InventarisPeralatan::RUANGAN_LIST as $ruang)
                        <option value="{{ $ruang }}" {{ old('ruangan') === $ruang ? 'selected' : '' }}>{{ $ruang }}</option>
                    @endforeach
                </select>
                @error('ruangan')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- KONDISI --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Kondisi <span class="text-red-500">*</span></label>
                <select name="kondisi" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
                    <option value="Baik" {{ old('kondisi', 'Baik') === 'Baik' ? 'selected' : '' }}>Baik</option>
                    <option value="Rusak" {{ old('kondisi') === 'Rusak' ? 'selected' : '' }}>Rusak</option>
                </select>
            </div>

            {{-- GAMBAR --}}
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Gambar / Foto Kondisi (Opsional)</label>
                <input type="file" name="gambar" accept="image/*"
                       class="w-full border border-slate-300 rounded-xl px-4 py-2.5 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-slate-50 file:text-slate-700 hover:file:bg-slate-100 cursor-pointer focus:outline-none focus:ring-2 focus:ring-slate-800">
                @error('gambar')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- KETERANGAN --}}
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Keterangan (Opsional)</label>
                <textarea name="keterangan" rows="3" placeholder="Catatan kondisi, spesifikasi, atau informasi tambahan..."
                          class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 resize-none">{{ old('keterangan') }}</textarea>
            </div>
        </div>

        <div class="flex gap-3 pt-4 border-t border-slate-100">
            <button type="submit" class="bg-slate-800 text-white px-8 py-3 rounded-xl font-semibold hover:bg-slate-700 transition-colors">Simpan</button>
            <a href="{{ route('inventaris.index') }}" class="bg-slate-100 text-slate-700 px-8 py-3 rounded-xl font-semibold hover:bg-slate-200 transition-colors">Batal</a>
        </div>
    </form>
</div>
</div>

@push('scripts')
<script>
    function toggleKategoriLainnya(value) {
        const container = document.getElementById('kategori_lainnya_container');
        const input     = document.getElementById('nama_kategori_lainnya');
        if (value === 'Lainnya') {
            container.classList.remove('hidden');
            input.required = true;
            input.focus();
        } else {
            container.classList.add('hidden');
            input.required = false;
            input.value = '';

            // Auto-fill satuan dari kategori yang dipilih
            const existing = @json($existingBarang);
            const match = existing.find(b => b.nama_kategori === value);
            if (match) {
                document.getElementById('satuan').value = match.satuan;
            }
        }
    }

    function toggleSatuanLainnya(value) {
        const container = document.getElementById('satuan_lainnya_container');
        const input     = document.getElementById('satuan_lainnya');
        if (value === 'Lainnya') {
            container.classList.remove('hidden');
            input.required = true;
            input.focus();
        } else {
            container.classList.add('hidden');
            input.required = false;
            input.value = '';
        }
    }

    // Inisiasi state saat halaman load (old value)
    document.addEventListener('DOMContentLoaded', function() {
        const selKat = document.getElementById('nama_kategori');
        if (selKat.value === 'Lainnya') {
            document.getElementById('kategori_lainnya_container').classList.remove('hidden');
            document.getElementById('nama_kategori_lainnya').required = true;
        }

        const selSat = document.getElementById('satuan');
        if (selSat.value === 'Lainnya') {
            document.getElementById('satuan_lainnya_container').classList.remove('hidden');
            document.getElementById('satuan_lainnya').required = true;
        }
    });
</script>
@endpush
@endsection
