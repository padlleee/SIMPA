@extends('layouts.app')

@section('title', 'Catat Kas Masuk')
@section('page-title', 'Kas Masuk Tambahan')
@section('page-subtitle', 'Catat pemasukan non-donasi ke buku kas (hibah, infaq, penjualan, dll.)')

@section('content')
<div class="max-w-2xl">

    {{-- Back link --}}
    <a href="{{ route('laporan.index') }}"
       class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-slate-800 transition-colors mb-5">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali ke Laporan Keuangan
    </a>

    {{-- Info card --}}
    <div class="bg-blue-50 border border-blue-200 rounded-2xl px-5 py-4 flex gap-3 mb-6">
        <svg class="w-5 h-5 text-blue-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <div class="text-sm text-blue-700">
            <p class="font-semibold mb-0.5">Catatan Penting</p>
            <p>Form ini <strong>khusus</strong> untuk mencatat pemasukan yang <em>bukan berasal dari donasi</em>
               (misalnya dana hibah, infaq/sedekah, hasil penjualan karya, subsidi pemerintah, dll.)
               Donasi dicatat otomatis melalui form donasi.</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">

        @if(session('error'))
            <div class="mb-5 bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl px-4 py-3 flex items-center gap-2">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('laporan.kas-masuk.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid md:grid-cols-2 gap-6">

                {{-- Sumber Dana --}}
                <div class="md:col-span-2">
                    <label for="sumber_dana" class="block text-sm font-semibold text-slate-700 mb-2">
                        Sumber Dana <span class="text-red-500">*</span>
                    </label>
                    <select id="sumber_dana" name="sumber_dana"
                            class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 bg-white @error('sumber_dana') border-red-400 @enderror">
                        <option value="" disabled {{ old('sumber_dana') ? '' : 'selected' }}>-- Pilih Sumber Dana --</option>
                        @foreach($sumberDanaList as $sumber)
                            @if($sumber !== 'Donasi')
                                <option value="{{ $sumber }}" {{ old('sumber_dana') === $sumber ? 'selected' : '' }}>
                                    {{ $sumber }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                    @error('sumber_dana')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tanggal --}}
                <div>
                    <label for="tanggal" class="block text-sm font-semibold text-slate-700 mb-2">
                        Tanggal Penerimaan <span class="text-red-500">*</span>
                    </label>
                    <input type="date" id="tanggal" name="tanggal"
                           value="{{ old('tanggal', now()->format('Y-m-d')) }}"
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 @error('tanggal') border-red-400 @enderror">
                    @error('tanggal')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Jumlah --}}
                <div>
                    <label for="jumlah" class="block text-sm font-semibold text-slate-700 mb-2">
                        Jumlah (Rp) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-semibold text-sm pointer-events-none">Rp</span>
                        <input type="number" id="jumlah" name="jumlah"
                               value="{{ old('jumlah') }}"
                               min="1"
                               placeholder="0"
                               class="w-full border border-slate-300 rounded-xl pl-10 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 @error('jumlah') border-red-400 @enderror">
                    </div>
                    @error('jumlah')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    {{-- Preview format --}}
                    <p id="jumlah-preview" class="text-xs text-slate-400 mt-1 h-4"></p>
                </div>

                {{-- Keterangan --}}
                <div class="md:col-span-2">
                    <label for="keterangan" class="block text-sm font-semibold text-slate-700 mb-2">
                        Keterangan <span class="text-red-500">*</span>
                        <span class="font-normal text-slate-400">(deskripsi singkat sumber dana)</span>
                    </label>
                    <textarea id="keterangan" name="keterangan" rows="3"
                              maxlength="500"
                              placeholder="Contoh: Dana hibah dari PT. Maju Jaya untuk program pendidikan anak asuh tahun 2025..."
                              class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 resize-none @error('keterangan') border-red-400 @enderror">{{ old('keterangan') }}</textarea>
                    <div class="flex justify-between items-center mt-1">
                        @error('keterangan')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @else
                            <span></span>
                        @enderror
                        <span id="ket-counter" class="text-xs text-slate-400">0 / 500</span>
                    </div>
                </div>

            </div>

            {{-- Preview total --}}
            <div id="preview-box" class="hidden bg-emerald-50 border border-emerald-200 rounded-xl px-5 py-4">
                <p class="text-xs font-semibold text-emerald-600 uppercase tracking-wider mb-1">Ringkasan Entri</p>
                <div class="grid grid-cols-2 gap-2 text-sm text-emerald-800">
                    <span class="text-slate-500">Sumber:</span>
                    <span id="prev-sumber" class="font-semibold">—</span>
                    <span class="text-slate-500">Tanggal:</span>
                    <span id="prev-tanggal" class="font-semibold">—</span>
                    <span class="text-slate-500">Jumlah:</span>
                    <span id="prev-jumlah" class="font-bold text-emerald-600 text-base">—</span>
                </div>
            </div>

            <div class="flex gap-3 pt-4 border-t border-slate-100">
                <button type="submit"
                        class="bg-slate-800 text-white px-8 py-3 rounded-xl font-semibold hover:bg-slate-700 transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan ke Buku Kas
                </button>
                <a href="{{ route('laporan.index') }}"
                   class="bg-slate-100 text-slate-700 px-8 py-3 rounded-xl font-semibold hover:bg-slate-200 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    const sumberSel  = document.getElementById('sumber_dana');
    const tanggalIn  = document.getElementById('tanggal');
    const jumlahIn   = document.getElementById('jumlah');
    const ketArea    = document.getElementById('keterangan');
    const preview    = document.getElementById('preview-box');
    const prevSumber = document.getElementById('prev-sumber');
    const prevTgl    = document.getElementById('prev-tanggal');
    const prevJumlah = document.getElementById('prev-jumlah');
    const jumlahPrev = document.getElementById('jumlah-preview');
    const ketCounter = document.getElementById('ket-counter');

    function formatRp(n) {
        if (!n || isNaN(n)) return '';
        return 'Rp ' + Number(n).toLocaleString('id-ID');
    }

    function formatTgl(val) {
        if (!val) return '—';
        const d = new Date(val);
        const bulan = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        return d.getDate() + ' ' + bulan[d.getMonth()] + ' ' + d.getFullYear();
    }

    function updatePreview() {
        const s = sumberSel.value;
        const j = jumlahIn.value;
        const t = tanggalIn.value;

        jumlahPrev.textContent = j ? formatRp(j) : '';

        if (s && j > 0 && t) {
            prevSumber.textContent = s;
            prevTgl.textContent    = formatTgl(t);
            prevJumlah.textContent = formatRp(j);
            preview.classList.remove('hidden');
        } else {
            preview.classList.add('hidden');
        }
    }

    sumberSel.addEventListener('change', updatePreview);
    tanggalIn.addEventListener('change', updatePreview);
    jumlahIn.addEventListener('input', updatePreview);

    ketArea.addEventListener('input', function () {
        ketCounter.textContent = this.value.length + ' / 500';
    });
    // Init counter
    ketCounter.textContent = ketArea.value.length + ' / 500';

    // Init preview on page load (e.g. after validation error with old())
    updatePreview();
</script>
@endpush

@endsection
