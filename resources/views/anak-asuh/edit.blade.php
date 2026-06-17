@extends('layouts.app')

@section('title', 'Edit Anak Asuh')
@section('page-title', 'Edit Anak Asuh')
@section('page-subtitle', 'Perbarui data anak asuh')

@section('content')
<div class="max-w-4xl">
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
    <form action="{{ route('anak-asuh.update', $anakAsuh) }}" method="POST" class="space-y-8">
        @csrf
        @method('PUT')
        
        <div>
            <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider border-b border-slate-100 pb-2 mb-4">Informasi Dasar</h3>
            <div class="grid md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_anak" value="{{ old('nama_anak', $anakAsuh->nama_anak) }}"
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 @error('nama_anak') border-red-400 @enderror">
                    @error('nama_anak')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $anakAsuh->tempat_lahir) }}"
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 @error('tempat_lahir') border-red-400 @enderror">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Lahir <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $anakAsuh->tanggal_lahir?->format('Y-m-d')) }}"
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 @error('tanggal_lahir') border-red-400 @enderror">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Jenis Kelamin <span class="text-red-500">*</span></label>
                    <select name="jenis_kelamin" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
                        <option value="L" {{ old('jenis_kelamin', $anakAsuh->jenis_kelamin) === 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin', $anakAsuh->jenis_kelamin) === 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Pendidikan</label>
                    <select name="pendidikan" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
                        <option value="">Pilih Pendidikan...</option>
                        <option value="TK" {{ old('pendidikan', $anakAsuh->pendidikan) === 'TK' ? 'selected' : '' }}>TK</option>
                        <option value="SD" {{ old('pendidikan', $anakAsuh->pendidikan) === 'SD' ? 'selected' : '' }}>SD</option>
                        <option value="SMP" {{ old('pendidikan', $anakAsuh->pendidikan) === 'SMP' ? 'selected' : '' }}>SMP</option>
                        <option value="SMA/SMK" {{ old('pendidikan', $anakAsuh->pendidikan) === 'SMA/SMK' ? 'selected' : '' }}>SMA/SMK</option>
                        <option value="Kuliah" {{ old('pendidikan', $anakAsuh->pendidikan) === 'Kuliah' ? 'selected' : '' }}>Kuliah / Perguruan Tinggi</option>
                        <option value="Tidak/Belum Sekolah" {{ old('pendidikan', $anakAsuh->pendidikan) === 'Tidak/Belum Sekolah' ? 'selected' : '' }}>Tidak/Belum Sekolah</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Kelas / Tingkat</label>
                    <input type="text" name="kelas" value="{{ old('kelas', $anakAsuh->kelas) }}" placeholder="Contoh: Kelas 1 / Semester 3"
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Jenis Layanan</label>
                    <input type="text" name="jenis_layanan" value="{{ old('jenis_layanan', $anakAsuh->jenis_layanan) }}"
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
                </div>
            </div>
        </div>

        <div>
            <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider border-b border-slate-100 pb-2 mb-4">Alamat Lengkap</h3>
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Dusun / Jalan</label>
                    <input type="text" name="dusun" value="{{ old('dusun', $anakAsuh->dusun) }}"
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">RT</label>
                        <input type="text" name="rt" value="{{ old('rt', $anakAsuh->rt) }}"
                               class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">RW</label>
                        <input type="text" name="rw" value="{{ old('rw', $anakAsuh->rw) }}"
                               class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Desa / Kelurahan</label>
                    <input type="text" name="desa" value="{{ old('desa', $anakAsuh->desa) }}"
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Kecamatan</label>
                    <input type="text" name="kecamatan" value="{{ old('kecamatan', $anakAsuh->kecamatan) }}"
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
                </div>
            </div>
        </div>

        <div>
            <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider border-b border-slate-100 pb-2 mb-4">Status & Akademik</h3>
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Status <span class="text-red-500">*</span></label>
                    <select name="status_anak" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
                        <option value="Aktif" {{ old('status_anak', $anakAsuh->status_anak) === 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Alumni" {{ old('status_anak', $anakAsuh->status_anak) === 'Alumni' ? 'selected' : '' }}>Alumni</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Masuk</label>
                    <input type="date" name="tanggal_masuk" value="{{ old('tanggal_masuk', $anakAsuh->tanggal_masuk?->format('Y-m-d')) }}"
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Perkembangan Akademik</label>
                    <textarea name="perkembangan_akademik" rows="2"
                              class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">{{ old('perkembangan_akademik', $anakAsuh->perkembangan_akademik) }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Catatan Kesehatan</label>
                    <textarea name="catatan_kesehatan" rows="2"
                              class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800">{{ old('catatan_kesehatan', $anakAsuh->catatan_kesehatan) }}</textarea>
                </div>
            </div>
        </div>

        {{-- ============================================================
             SECTION: PRESTASI & PERKEMBANGAN ANAK
             Free-text achievement badges saved instantly via AJAX.
             ============================================================ --}}
        <div>
            <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider border-b border-slate-100 pb-2 mb-4">
                Label Perkembangan
                <span class="normal-case font-normal text-slate-400 text-xs ml-1">— catat prestasi & riwayat perkembangan anak</span>
            </h3>

            {{-- ── Input baru ── --}}
            <div class="bg-slate-50 rounded-2xl border border-slate-200 p-4 mb-5">
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">Tambah Catatan Baru</p>

                <div class="flex flex-col sm:flex-row gap-3">
                    {{-- Teks prestasi --}}
                    <div class="flex-1">
                        <input type="text"
                               id="input-prestasi"
                               maxlength="200"
                               placeholder="masukkan perkembangan anak asuh.."
                               class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-slate-800 bg-white"
                               autocomplete="off">
                    </div>

                    {{-- Tanggal (opsional) --}}
                    <div class="sm:w-44">
                        <input type="date"
                               id="input-tanggal"
                               value="{{ now()->format('Y-m-d') }}"
                               class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-slate-800 bg-white">
                    </div>

                    {{-- Tombol Tambah --}}
                    <button type="button"
                            id="btn-tambah-prestasi"
                            onclick="tambahPrestasi()"
                            class="inline-flex items-center gap-2 bg-slate-800 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-slate-700 active:scale-95 transition-all flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah
                    </button>
                </div>

                <p class="text-xs text-slate-400 mt-2">Tekan Enter atau klik Tambah untuk menyimpan. Setiap label tersimpan langsung ke database.</p>

                {{-- Status feedback --}}
                <div id="prestasi-status" class="hidden mt-2 text-xs font-medium"></div>
            </div>

            {{-- ── Existing Prestasi List ── --}}
            <div id="prestasi-container" class="space-y-2">
                @forelse($anakAsuh->prestasi as $p)
                    <div class="prestasi-tag group flex items-center gap-3 bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 transition-all hover:bg-slate-100"
                         data-id="{{ $p->id }}">
                        {{-- Warna stripe kiri --}}
                        <span class="flex-shrink-0 w-1 h-8 rounded-full" style="background-color: {{ $p->warna_hex }};"></span>

                        {{-- Tanggal --}}
                        <span class="flex-shrink-0 text-xs text-slate-400 font-medium w-24">
                            {{ $p->tanggal_dicatat ? $p->tanggal_dicatat->format('d M Y') : '—' }}
                        </span>

                        {{-- Teks Prestasi --}}
                        <span class="flex-1 text-sm font-semibold text-slate-800 break-words break-all min-w-0">{{ $p->teks_prestasi }}</span>

                        {{-- Hapus --}}
                        <button type="button"
                                onclick="hapusPrestasi(this, {{ $p->id }})"
                                class="flex-shrink-0 opacity-0 group-hover:opacity-100 p-1.5 rounded-lg text-slate-400 hover:text-red-500 hover:bg-red-50 transition-all focus:outline-none focus:opacity-100"
                                aria-label="Hapus prestasi">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                @empty
                    <p id="prestasi-empty-msg" class="text-slate-400 text-sm italic py-2">Belum ada catatan perkembangan.</p>
                @endforelse
            </div>
        </div>

        <div class="flex gap-3 pt-4 border-t border-slate-100">
            <button type="submit" class="bg-slate-800 text-white px-8 py-3 rounded-xl font-semibold hover:bg-slate-700 transition-colors">Perbarui Data</button>
            <a href="{{ route('anak-asuh.index') }}" class="bg-slate-100 text-slate-700 px-8 py-3 rounded-xl font-semibold hover:bg-slate-200 transition-colors">Batal</a>
        </div>
    </form>
</div>
</div>

@push('scripts')
<script>
// ─── Prestasi Anak — AJAX Label System ──────────────────────────────────────
const PRESTASI_ADD_URL    = "{{ route('anak-asuh.prestasi.add', $anakAsuh) }}";
const PRESTASI_DELETE_BASE = "/anak-asuh/{{ $anakAsuh->id_anak }}/prestasi/";
const CSRF_TOKEN          = "{{ csrf_token() }}";

const container  = document.getElementById('prestasi-container');
const statusBox  = document.getElementById('prestasi-status');
const inputTeks  = document.getElementById('input-prestasi');
const inputTgl   = document.getElementById('input-tanggal');
const btnTambah  = document.getElementById('btn-tambah-prestasi');

// Enter key support
inputTeks.addEventListener('keydown', function(e) {
    if (e.key === 'Enter') { e.preventDefault(); tambahPrestasi(); }
});

function showStatus(msg, ok = true) {
    statusBox.textContent = msg;
    statusBox.className   = 'mt-2 text-xs font-medium ' + (ok ? 'text-green-600' : 'text-red-500');
    statusBox.classList.remove('hidden');
    setTimeout(() => statusBox.classList.add('hidden'), 3000);
}

function removeEmptyMsg() {
    const msg = document.getElementById('prestasi-empty-msg');
    if (msg) msg.remove();
}

function maybeAddEmptyMsg() {
    if (document.querySelectorAll('.prestasi-tag').length === 0) {
        const msg = document.createElement('p');
        msg.id        = 'prestasi-empty-msg';
        msg.className = 'text-slate-400 text-sm italic py-2';
        msg.textContent = 'Belum ada catatan perkembangan.';
        container.appendChild(msg);
    }
}

function buildTag(id, teks, warna, tanggal) {
    const div = document.createElement('div');
    div.className  = 'prestasi-tag group flex items-center gap-3 bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 transition-all hover:bg-slate-100';
    div.dataset.id = id;

    // Format tanggal tampilan
    let tglDisplay = '—';
    if (tanggal) {
        const d = new Date(tanggal);
        if (!isNaN(d)) {
            const bulan = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
            tglDisplay = String(d.getDate()).padStart(2,'0') + ' ' + bulan[d.getMonth()] + ' ' + d.getFullYear();
        }
    }

    div.innerHTML = `
        <span class="flex-shrink-0 w-1 h-8 rounded-full" style="background-color: ${warna};"></span>
        <span class="flex-shrink-0 text-xs text-slate-400 font-medium w-24">${tglDisplay}</span>
        <span class="flex-1 text-sm font-semibold text-slate-800 break-words break-all min-w-0">${escHtml(teks)}</span>
        <button type="button"
                onclick="hapusPrestasi(this, ${id})"
                class="flex-shrink-0 opacity-0 group-hover:opacity-100 p-1.5 rounded-lg text-slate-400 hover:text-red-500 hover:bg-red-50 transition-all focus:outline-none focus:opacity-100"
                aria-label="Hapus prestasi">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    `;
    return div;
}

function escHtml(s) {
    return s.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

async function tambahPrestasi() {
    const teks = inputTeks.value.trim();
    if (!teks) { inputTeks.focus(); return; }

    btnTambah.disabled  = true;
    btnTambah.textContent = 'Menyimpan…';

    try {
        const res  = await fetch(PRESTASI_ADD_URL, {
            method : 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF_TOKEN, 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body   : JSON.stringify({ teks_prestasi: teks, tanggal_dicatat: inputTgl.value || null }),
        });
        const data = await res.json();

        if (data.success) {
            removeEmptyMsg();
            const tag = buildTag(data.id, data.teks, data.warna, data.tanggal);
            // animate in
            tag.style.opacity   = '0';
            tag.style.transform = 'translateY(-6px)';
            container.prepend(tag);
            requestAnimationFrame(() => {
                tag.style.transition = 'opacity 250ms ease, transform 250ms ease';
                tag.style.opacity    = '1';
                tag.style.transform  = 'translateY(0)';
            });
            inputTeks.value = '';
            showStatus('✓ Prestasi berhasil ditambahkan!', true);
        } else {
            showStatus('Gagal menyimpan. Coba lagi.', false);
        }
    } catch (e) {
        showStatus('Terjadi kesalahan jaringan.', false);
    } finally {
        btnTambah.disabled   = false;
        btnTambah.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg> Tambah`;
        inputTeks.focus();
    }
}

async function hapusPrestasi(btn, id) {
    const tag = btn.closest('.prestasi-tag');

    // Animate out
    tag.style.transition = 'opacity 150ms ease, transform 150ms ease';
    tag.style.opacity    = '0';
    tag.style.transform  = 'translateX(10px)';

    try {
        const res  = await fetch(PRESTASI_DELETE_BASE + id, {
            method : 'DELETE',
            headers: { 'X-CSRF-TOKEN': CSRF_TOKEN, 'Accept': 'application/json' },
        });
        const data = await res.json();

        if (data.success) {
            setTimeout(() => {
                tag.remove();
                maybeAddEmptyMsg();
            }, 160);
        } else {
            // Restore if failed
            tag.style.opacity   = '1';
            tag.style.transform = 'scale(1)';
            showStatus('Gagal menghapus. Coba lagi.', false);
        }
    } catch (e) {
        tag.style.opacity   = '1';
        tag.style.transform = 'scale(1)';
        showStatus('Terjadi kesalahan jaringan.', false);
    }
}
</script>
@endpush
@endsection
