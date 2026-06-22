{{-- ============================================================
     Public Page: Pusat Informasi & Panduan
     @extends('layouts.master')
     ============================================================ --}}
@extends('layouts.master')

@section('title', 'Pusat Informasi')
@section('meta-description', 'Pusat informasi, panduan pendaftaran anak asuh, dan transparansi Yayasan Panti Asuhan Amaliya Subang.')
@section('body-class', 'bg-slate-50 text-slate-800')

@section('body')

@include('layouts.navbar')

{{-- PAGE HEADER --}}
<section class="pt-32 pb-12 bg-white border-b border-slate-200">
    <div class="max-w-6xl mx-auto px-6 text-center">
        <h1 class="text-3xl md:text-4xl font-bold text-slate-800 mb-4">Pusat Informasi & Transparansi</h1>
        <p class="text-slate-500 text-lg max-w-2xl mx-auto">
            Halaman ini memuat informasi resmi, panduan, dan data arsip untuk menjaga transparansi dan keamanan Yayasan Amaliya Subang.
        </p>
    </div>
</section>

{{-- MAIN CONTENT --}}
<section class="py-12">
    <div class="max-w-5xl mx-auto px-6 space-y-12">
        
        {{-- 1. FINANCIAL SECURITY & OFFICIAL ACCOUNTS --}}
        <div class="bg-slate-100 border border-slate-200 rounded-2xl p-8 shadow-sm relative overflow-hidden">
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-6">
                    <svg class="w-8 h-8 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    <h2 class="text-2xl font-bold text-slate-800">Keamanan Finansial & Rekening Resmi</h2>
                </div>
                
                <div class="grid md:grid-cols-2 gap-6 mb-6">
                    <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/9/97/Logo_BRI.png" alt="Bank BRI" class="h-6 mb-4 object-contain">
                        <div class="text-xl font-mono font-bold text-slate-800 mb-1">0123-01-002045-30-9</div>
                        <div class="text-sm text-slate-500">a.n. Yayasan Amaliya Subang</div>
                    </div>
                    <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
                        <img src="https://vectorlogo4u.com/wp-content/uploads/2018/11/bank-bjb-vector-logo.png" alt="Bank BJB" class="h-14 mb-0 -mt-4 object-contain object-left">
                        <div class="text-xl font-mono font-bold text-slate-800 mb-1">0115697889100</div>
                        <div class="text-sm text-slate-500">a.n. Yayasan Amaliya Subang</div>
                    </div>
                </div>
                
                <div class="bg-red-50 border border-red-100 rounded-xl p-4 flex gap-4">
                    <svg class="w-6 h-6 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <p class="text-sm text-red-700 leading-relaxed font-medium">
                        Waspada Penipuan! Yayasan Amaliya Subang hanya menerima donasi melalui rekening resmi di atas. Kami sangat disiplin dalam hal keamanan finansial dan tidak pernah menugaskan pihak ketiga atau perorangan manapun untuk melakukan pemungutan dana di jalan maupun door-to-door.
                    </p>
                </div>
            </div>
        </div>

        {{-- 2. ADMISSION & ENROLLMENT GUIDELINES --}}
        <div>
            <h2 class="text-2xl font-bold text-slate-800 mb-6">Panduan Pendaftaran Anak Asuh</h2>
            
            <div class="grid md:grid-cols-3 gap-6 mb-8 text-sm">
                {{-- Col 1 --}}
                <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm">
                    <h3 class="font-bold text-slate-800 mb-4 pb-3 border-b border-slate-100 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-xs">1</span>
                        Jalur Rujukan
                    </h3>
                    <ul class="space-y-3 text-slate-600">
                        <li class="flex gap-2"><span class="text-slate-300">▪</span> Keluarga / Kerabat</li>
                        <li class="flex gap-2"><span class="text-slate-300">▪</span> Anggota Komunitas</li>
                        <li class="flex gap-2"><span class="text-slate-300">▪</span> Kepolisian atau Dinas Sosial</li>
                        <li class="flex gap-2"><span class="text-slate-300">▪</span> LPA / LSM / Sekolah / Posyandu</li>
                        <li class="flex gap-2"><span class="text-slate-300">▪</span> Datang Sendiri (Mandiri)</li>
                    </ul>
                </div>
                
                {{-- Col 2 --}}
                <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm">
                    <h3 class="font-bold text-slate-800 mb-4 pb-3 border-b border-slate-100 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-xs">2</span>
                        Persyaratan Utama
                    </h3>
                    <ul class="space-y-3 text-slate-600">
                        <li class="flex gap-2"><span class="text-slate-300">▪</span> Beragama Islam</li>
                        <li class="flex gap-2"><span class="text-slate-300">▪</span> Yatim / Piatu / Dhuafa</li>
                        <li class="flex gap-2"><span class="text-slate-300">▪</span> Usia minimal 6 tahun</li>
                        <li class="flex gap-2"><span class="text-slate-300">▪</span> Sehat jasmani dan rohani</li>
                        <li class="flex gap-2"><span class="text-slate-300">▪</span> Bersedia menempuh sekolah formal</li>
                        <li class="flex gap-2"><span class="text-slate-300">▪</span> Memiliki kemauan berprestasi</li>
                        <li class="flex gap-2"><span class="text-slate-300">▪</span> Bersedia tinggal menetap di asrama</li>
                    </ul>
                </div>

                {{-- Col 3 --}}
                <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm">
                    <h3 class="font-bold text-slate-800 mb-4 pb-3 border-b border-slate-100 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-xs">3</span>
                        Dokumen Dibutuhkan
                    </h3>
                    <ul class="space-y-3 text-slate-600">
                        <li class="flex gap-2"><span class="text-slate-300">▪</span> Surat Kematian Orang Tua</li>
                        <li class="flex gap-2"><span class="text-slate-300">▪</span> SKTM dari Lurah/Desa</li>
                        <li class="flex gap-2"><span class="text-slate-300">▪</span> Fotokopi Akta Kelahiran</li>
                        <li class="flex gap-2"><span class="text-slate-300">▪</span> Fotokopi Kartu Keluarga (KK)</li>
                        <li class="flex gap-2"><span class="text-slate-300">▪</span> Fotokopi Raport Terakhir</li>
                        <li class="flex gap-2"><span class="text-slate-300">▪</span> Surat Keterangan Sehat Puskesmas</li>
                        <li class="flex gap-2"><span class="text-slate-300">▪</span> Pas Foto 4x6 (2 lembar)</li>
                        <li class="flex gap-2"><span class="text-slate-300">▪</span> Surat Permohonan Masuk Asrama</li>
                    </ul>
                </div>
            </div>
            
            <div class="text-center">
                <a href="{{ asset('dokumen/formulir-pendaftaran.pdf') }}" download class="inline-flex items-center gap-2 bg-white border border-slate-200 text-slate-700 px-6 py-2.5 rounded-xl text-sm font-semibold hover:bg-slate-50 hover:border-slate-300 transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    Unduh Dokumen Formulir Fisik
                </a>
            </div>
        </div>

        {{-- 3. OFFICIAL CHANNELS & SOCIAL MEDIA DIRECTORY --}}
        <div class="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden">
            <div class="p-8">
                <h2 class="text-xl font-bold text-slate-800 mb-6">Saluran Informasi & Media Sosial Resmi</h2>
                
                <div class="grid md:grid-cols-3 gap-6 mb-6 text-sm">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center text-blue-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                        </div>
                        <div>
                            <div class="text-slate-400 font-semibold uppercase tracking-wider text-[10px] mb-1">Website Handle</div>
                            <div class="font-medium text-slate-800">www.amaliyasubang.org</div>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-pink-50 rounded-lg flex items-center justify-center text-pink-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect width="14" height="14" x="5" y="5" rx="4" ry="4"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37zM17.5 6.5h.01"/></svg>
                        </div>
                        <div>
                            <div class="text-slate-400 font-semibold uppercase tracking-wider text-[10px] mb-1">Instagram</div>
                            <div class="font-medium text-slate-800">@amaliya_subang</div>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-indigo-50 rounded-lg flex items-center justify-center text-indigo-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <div class="text-slate-400 font-semibold uppercase tracking-wider text-[10px] mb-1">Facebook & YouTube</div>
                            <div class="font-medium text-slate-800">Yayasan Amaliya Subang</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-red-50 px-8 py-4 border-t border-red-100 flex items-start gap-3">
                <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <p class="text-sm text-red-700 font-medium leading-relaxed">
                    Waspadalah terhadap berbagai bentuk penipuan! Penggunaan akun sosial media selain yang tercantum di atas adalah BUKAN dari yayasan kami.
                </p>
            </div>
        </div>

        {{-- 4. ACCOUNTABILITY & HISTORICAL NON-ACTIVE ARCHIVE --}}
        <div>
            <h2 class="text-xl font-bold text-slate-800 mb-6">Arsip Non-Aktif & Akuntabilitas</h2>
            
            {{-- Expandable container --}}
            <div x-data="{ expanded: false }" class="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center justify-between cursor-pointer" @click="expanded = !expanded">
                        <div>
                            <h3 class="font-bold text-slate-800">Daftar Pengurus & Anak Asuh Non-Aktif</h3>
                            <p class="text-xs text-slate-500 mt-1">Klik untuk melihat arsip nama-nama yang sudah tidak menjadi bagian dari yayasan.</p>
                        </div>
                        <button class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center text-slate-500 hover:bg-slate-100 transition-colors">
                            <svg x-show="!expanded" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            <svg x-show="expanded" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
                        </button>
                    </div>
                    
                    {{-- Expanded Content --}}
                    <div x-show="expanded" x-transition x-cloak style="display: none;" class="mt-6 pt-6 border-t border-slate-100">
                        <div class="grid md:grid-cols-2 gap-8 text-sm">
                            {{-- Sub-Card A --}}
                            <div>
                                <h4 class="font-bold text-slate-800 mb-3 uppercase tracking-wider text-[11px]">Pengurus/Pelaksana Non-Aktif (sejak Oktober 2020)</h4>
                                <ul class="space-y-2 text-slate-600">
                                    @forelse($pengurusNonAktif as $pengurus)
                                    <li class="flex gap-2"><span class="text-slate-300">•</span> {{ $pengurus->nama }} {{ $pengurus->jabatan_terakhir ? '('.$pengurus->jabatan_terakhir.')' : '' }}</li>
                                    @empty
                                    <li class="text-slate-400 text-xs italic">Belum ada data</li>
                                    @endforelse
                                </ul>
                            </div>
                            
                            {{-- Sub-Card B --}}
                            <div>
                                <h4 class="font-bold text-slate-800 mb-3 uppercase tracking-wider text-[11px]">Alumni / Anak Asuh Non-Aktif ({{ $alumni->count() }} Orang)</h4>
                                <div class="grid grid-cols-2 gap-x-4 gap-y-2 text-slate-600">
                                    @forelse($alumni as $anak)
                                        <div class="flex gap-2 truncate" title="{{ $anak->nama_anak }}"><span class="text-slate-300">•</span> {{ $anak->nama_anak }}</div>
                                    @empty
                                        <div class="text-slate-400 text-xs italic col-span-2">Belum ada data</div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- Bottom Notice --}}
                <div class="bg-slate-50 px-6 py-4 border-t border-slate-100">
                    <p class="text-xs text-slate-600 leading-relaxed text-center">
                        <strong class="text-slate-800">Peringatan Akuntabilitas:</strong> 
                        Kami mengimbau kepada seluruh donatur dan mitra kerja untuk mengabaikan segala bentuk permintaan dana, bantuan, atau mengatasnamakan Yayasan Amaliya Subang dari nama-nama yang tercantum di atas, karena entitas tersebut sudah tidak memiliki kewenangan maupun ikatan apa pun dengan kami.
                    </p>
                </div>
            </div>
        </div>

    </div>
</section>

@include('layouts.footer')

{{-- Include Alpine.js for the expandable accordion --}}
@push('scripts')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush

@endsection
