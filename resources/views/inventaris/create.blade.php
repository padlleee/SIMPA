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
                    <option value="Lainnya" {{ old('nama_kategori') === 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
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

            {{-- KODE BARANG --}}
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Kode Barang</label>
                <input type="text" name="kode_barang" value="{{ old('kode_barang', $newKodeBarang ?? '') }}" readonly
                       class="w-full border border-slate-300 bg-slate-50 text-slate-500 rounded-xl px-4 py-3 focus:outline-none cursor-not-allowed">
            </div>

            {{-- JUMLAH --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Jumlah <span class="text-red-500">*</span></label>
                <input type="number" name="jumlah" id="jumlah_input" value="{{ old('jumlah', 1) }}" min="1" required
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
                    <option value="Lainnya" {{ old('satuan') === 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
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
        </div>

        <hr class="my-6 border-slate-200">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">
            <div>
                <h3 class="text-lg font-bold text-slate-800 mb-1">Rincian per Unit</h3>
                <p class="text-sm text-slate-500">Lengkapi detail untuk masing-masing unit berdasarkan jumlah yang Anda masukkan.</p>
            </div>
            <button type="button" onclick="copyFromFirstBlock()" class="text-sm bg-indigo-50 text-indigo-600 hover:bg-indigo-100 px-4 py-2 rounded-lg font-medium transition-colors border border-indigo-200 flex items-center gap-2 flex-shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                Salin Data #1 ke Semua
            </button>
        </div>

        <div id="dynamic-items-container" class="space-y-6">
            <!-- Dynamic forms will be appended here -->
        </div>

        <template id="item-template">
            <div class="item-block bg-slate-50 border border-slate-200 rounded-xl p-6 relative">
                <div class="absolute top-4 right-4 bg-slate-800 text-white text-xs font-bold px-3 py-1 rounded-full item-number">#1</div>
                
                <div class="grid md:grid-cols-2 gap-5 mt-2">
                    {{-- NAMA BARANG (Spesifik) --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Barang Spesifik <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_barang[]" required
                               placeholder="Contoh: Kulkas Sony 200L, Meja Tamu Kayu Jati..."
                               class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
                    </div>

                    {{-- LOKASI --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Lokasi <span class="text-red-500">*</span></label>
                        <input type="text" name="lokasi[]" placeholder="Contoh: Gedung A, Lantai 1..." required
                               class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
                    </div>

                    {{-- RUANGAN --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Ruangan</label>
                        <select name="ruangan[]" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
                            <option value="">-- Tidak Spesifik --</option>
                            @foreach(\App\Models\InventarisPeralatan::RUANGAN_LIST as $ruang)
                                <option value="{{ $ruang }}">{{ $ruang }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- KONDISI --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Kondisi <span class="text-red-500">*</span></label>
                        <select name="kondisi[]" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
                            <option value="Baik">Baik</option>
                            <option value="Rusak">Rusak</option>
                        </select>
                    </div>

                    {{-- GAMBAR --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Gambar / Foto Kondisi (Opsional)</label>
                        <input type="file" name="gambar[]" accept="image/*"
                               class="w-full border border-slate-300 rounded-xl px-4 py-2.5 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-slate-50 file:text-slate-700 hover:file:bg-slate-100 cursor-pointer focus:outline-none focus:ring-2 focus:ring-slate-800">
                    </div>

                    {{-- KETERANGAN --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Keterangan (Opsional)</label>
                        <textarea name="keterangan[]" rows="3" placeholder="Catatan kondisi, spesifikasi, atau informasi tambahan..."
                                  class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 resize-none"></textarea>
                    </div>
                </div>
            </div>
        </template>

        <div class="flex gap-3 pt-4 border-t border-slate-100">
            <button type="submit" class="bg-slate-800 text-white px-8 py-3 rounded-xl font-semibold hover:bg-slate-700 transition-colors">Simpan</button>
            <a href="{{ route('inventaris.index') }}" class="bg-slate-100 text-slate-700 px-8 py-3 rounded-xl font-semibold hover:bg-slate-200 transition-colors">Batal</a>
        </div>
    </form>
</div>
</div>

<!-- Toast Notification -->
<div id="toast-notification" class="fixed bottom-8 right-8 transform translate-y-12 opacity-0 transition-all duration-300 z-[70] pointer-events-none">
    <div class="bg-slate-800 text-white px-6 py-4 rounded-xl shadow-2xl flex items-center gap-3">
        <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <span id="toast-message" class="font-medium text-sm"></span>
    </div>
</div>

@push('scripts')
<script>
    function showToast(message) {
        const toast = document.getElementById('toast-notification');
        const toastMessage = document.getElementById('toast-message');
        
        toastMessage.textContent = message;
        
        // Tampilkan toast
        toast.classList.remove('translate-y-12', 'opacity-0');
        
        // Sembunyikan toast setelah 3 detik
        setTimeout(() => {
            toast.classList.add('translate-y-12', 'opacity-0');
        }, 3000);
    }

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

    function updateDynamicItems() {
        const container = document.getElementById('dynamic-items-container');
        const template = document.getElementById('item-template');
        let jumlah = parseInt(document.getElementById('jumlah_input').value) || 1;
        if (jumlah < 1) jumlah = 1;

        const currentBlocks = container.querySelectorAll('.item-block').length;

        // Add blocks if needed
        if (jumlah > currentBlocks) {
            // Dapatkan nilai dari blok pertama jika ada untuk autofill
            const block1 = container.querySelector('.item-block');
            let baseValues = null;
            if (block1) {
                baseValues = {
                    nama_barang: block1.querySelector('[name="nama_barang[]"]').value,
                    lokasi: block1.querySelector('[name="lokasi[]"]').value,
                    ruangan: block1.querySelector('[name="ruangan[]"]').value,
                    kondisi: block1.querySelector('[name="kondisi[]"]').value,
                    keterangan: block1.querySelector('[name="keterangan[]"]').value,
                };
            }

            for (let i = currentBlocks; i < jumlah; i++) {
                const clone = template.content.cloneNode(true);
                clone.querySelector('.item-number').textContent = '#' + (i + 1);
                
                // Autofill jika baseValues tersedia
                if (baseValues && i > 0) {
                    clone.querySelector('[name="nama_barang[]"]').value = baseValues.nama_barang;
                    clone.querySelector('[name="lokasi[]"]').value = baseValues.lokasi;
                    clone.querySelector('[name="ruangan[]"]').value = baseValues.ruangan;
                    clone.querySelector('[name="kondisi[]"]').value = baseValues.kondisi;
                    clone.querySelector('[name="keterangan[]"]').value = baseValues.keterangan;
                }

                container.appendChild(clone);
            }
        } 
        // Remove blocks if needed
        else if (jumlah < currentBlocks) {
            for (let i = currentBlocks; i > jumlah; i--) {
                container.lastElementChild.remove();
            }
        }
    }

    function copyFromFirstBlock() {
        const container = document.getElementById('dynamic-items-container');
        const blocks = container.querySelectorAll('.item-block');
        if (blocks.length <= 1) {
            showToast('Atur jumlah lebih dari 1 terlebih dahulu!');
            return;
        }

        const block1 = blocks[0];
        const baseValues = {
            nama_barang: block1.querySelector('[name="nama_barang[]"]').value,
            lokasi: block1.querySelector('[name="lokasi[]"]').value,
            ruangan: block1.querySelector('[name="ruangan[]"]').value,
            kondisi: block1.querySelector('[name="kondisi[]"]').value,
            keterangan: block1.querySelector('[name="keterangan[]"]').value,
        };

        for (let i = 1; i < blocks.length; i++) {
            blocks[i].querySelector('[name="nama_barang[]"]').value = baseValues.nama_barang;
            blocks[i].querySelector('[name="lokasi[]"]').value = baseValues.lokasi;
            blocks[i].querySelector('[name="ruangan[]"]').value = baseValues.ruangan;
            blocks[i].querySelector('[name="kondisi[]"]').value = baseValues.kondisi;
            blocks[i].querySelector('[name="keterangan[]"]').value = baseValues.keterangan;
        }
        
        showToast('Data teks dari form #1 berhasil disalin ke semua form!');
    }

    // Inisiasi state saat halaman load (old value)
    document.addEventListener('DOMContentLoaded', function() {
        const selKat = document.getElementById('nama_kategori');
        if (selKat && selKat.value === 'Lainnya') {
            document.getElementById('kategori_lainnya_container').classList.remove('hidden');
            document.getElementById('nama_kategori_lainnya').required = true;
        }

        const selSat = document.getElementById('satuan');
        if (selSat && selSat.value === 'Lainnya') {
            document.getElementById('satuan_lainnya_container').classList.remove('hidden');
            document.getElementById('satuan_lainnya').required = true;
        }

        // Initialize dynamic items
        const jumlahInput = document.getElementById('jumlah_input');
        if (jumlahInput) {
            jumlahInput.addEventListener('input', updateDynamicItems);
            updateDynamicItems();
        }
    });
</script>
@endpush
@endsection
