{{-- ============================================================
     FAQ Page: resources/views/faq.blade.php
     Halaman FAQ interaktif dengan accordion Vanilla JS
     4 kategori: Profil Panti, Donasi, Keanggotaan, Relawan
     ============================================================ --}}
@extends('layouts.master')

@section('title', 'FAQ – Pertanyaan yang Sering Diajukan')
@section('meta-description', 'Temukan jawaban atas pertanyaan umum seputar Yayasan Panti Asuhan Amaliya Subang – donasi, keanggotaan, dan program relawan.')
@section('body-class', 'bg-white text-slate-800')

@push('styles')
<style>
    .faq-answer {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.35s cubic-bezier(0.4, 0, 0.2, 1), padding 0.25s ease;
    }
    .faq-answer.open {
        max-height: 600px;
    }
    .faq-icon {
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        flex-shrink: 0;
    }
    .faq-btn[aria-expanded="true"] .faq-icon {
        transform: rotate(45deg);
    }
    .faq-btn:hover .faq-question-text {
        color: #1e293b;
    }
    .category-tab.active {
        background-color: #1e293b;
        color: #fff;
        border-color: #1e293b;
    }
</style>
@endpush

@section('body')
@include('layouts.navbar')

{{-- PAGE HEADER --}}
<section class="pt-32 pb-12 bg-gradient-to-b from-slate-50 to-white">
    <div class="max-w-4xl mx-auto px-6 text-center">
        <span class="inline-block text-xs font-bold text-slate-500 uppercase tracking-widest bg-slate-100 px-4 py-1.5 rounded-full mb-5">FAQ · Pertanyaan Umum</span>
        <h1 class="text-4xl md:text-5xl font-bold text-slate-800 mb-5 leading-tight">
            Pertanyaan yang<br>Sering Diajukan
        </h1>
        <p class="text-slate-500 max-w-2xl mx-auto text-[15px] leading-relaxed">
            Kami telah menyiapkan jawaban atas pertanyaan-pertanyaan yang paling sering muncul dari para donatur, calon relawan, dan masyarakat umum yang ingin berkontribusi.
        </p>
    </div>
</section>

{{-- CATEGORY NAVIGATION --}}
<section class="sticky top-16 z-40 bg-white/95 backdrop-blur-sm border-b border-slate-200 shadow-sm">
    <div class="max-w-4xl mx-auto px-6">
        <div class="flex gap-2 py-4 overflow-x-auto scrollbar-hide">
            <button onclick="scrollToCategory('profil')"
                    id="tab-profil"
                    class="category-tab flex-shrink-0 px-5 py-2.5 rounded-xl text-sm font-semibold border border-slate-200 text-slate-600 hover:border-slate-400 hover:text-slate-800 transition-all duration-200">
                Profil Panti
            </button>
            <button onclick="scrollToCategory('donasi')"
                    id="tab-donasi"
                    class="category-tab flex-shrink-0 px-5 py-2.5 rounded-xl text-sm font-semibold border border-slate-200 text-slate-600 hover:border-slate-400 hover:text-slate-800 transition-all duration-200">
                Sistem Donasi
            </button>
            <button onclick="scrollToCategory('keanggotaan')"
                    id="tab-keanggotaan"
                    class="category-tab flex-shrink-0 px-5 py-2.5 rounded-xl text-sm font-semibold border border-slate-200 text-slate-600 hover:border-slate-400 hover:text-slate-800 transition-all duration-200">
                Keanggotaan Donatur
            </button>
            <button onclick="scrollToCategory('relawan')"
                    id="tab-relawan"
                    class="category-tab flex-shrink-0 px-5 py-2.5 rounded-xl text-sm font-semibold border border-slate-200 text-slate-600 hover:border-slate-400 hover:text-slate-800 transition-all duration-200">
                Relawan &amp; Beasiswa
            </button>
        </div>
    </div>
</section>

{{-- FAQ CONTENT --}}
<main class="py-16">
    <div class="max-w-4xl mx-auto px-6 space-y-14">

        {{-- ====================================================== --}}
        {{-- KATEGORI 1: VALIDITAS & PROFIL PANTI                   --}}
        {{-- ====================================================== --}}
        <div id="profil" class="scroll-mt-36">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-10 h-10 bg-slate-800 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Kategori 1</p>
                    <h2 class="text-2xl font-bold text-slate-800">Validitas &amp; Profil Panti</h2>
                    <p class="text-slate-500 text-sm mt-0.5">Membangun Kepercayaan &amp; Transparansi</p>
                </div>
            </div>

            <div class="space-y-3">
                @php $profilFaqs = $faqs->get('profil', collect()); @endphp
                
                @if($profilFaqs->count() > 0)
                    @foreach($profilFaqs as $item)
                    <div class="faq-item border border-slate-200 rounded-2xl overflow-hidden hover:border-slate-300 transition-colors duration-200">
                        <button class="faq-btn w-full flex items-center justify-between gap-4 p-6 text-left"
                                aria-expanded="false"
                                onclick="toggleFaq(this)">
                            <span class="faq-question-text font-semibold text-slate-700 text-[15px] leading-snug transition-colors">{{ $item->pertanyaan }}</span>
                            <svg class="faq-icon w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </button>
                        <div class="faq-answer">
                            <div class="px-6 pb-6 pt-0">
                                <div class="h-px bg-slate-100 mb-4"></div>
                                <p class="text-slate-600 text-sm leading-relaxed whitespace-pre-line">{{ $item->jawaban }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="text-center py-8 text-slate-400">Belum ada FAQ untuk kategori ini.</div>
                @endif
            </div>
        </div>

        {{-- ====================================================== --}}
        {{-- KATEGORI 2: SISTEM DONASI PUBLIK                       --}}
        {{-- ====================================================== --}}
        <div id="donasi" class="scroll-mt-36">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-10 h-10 bg-slate-700 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Kategori 2</p>
                    <h2 class="text-2xl font-bold text-slate-800">Sistem Donasi Publik</h2>
                    <p class="text-slate-500 text-sm mt-0.5">Transparansi Uang &amp; Barang</p>
                </div>
            </div>

            <div class="space-y-3">
                @php $donasiFaqs = $faqs->get('donasi', collect()); @endphp
                
                @if($donasiFaqs->count() > 0)
                    @foreach($donasiFaqs as $item)
                    <div class="faq-item border border-slate-200 rounded-2xl overflow-hidden hover:border-slate-300 transition-colors duration-200">
                        <button class="faq-btn w-full flex items-center justify-between gap-4 p-6 text-left"
                                aria-expanded="false"
                                onclick="toggleFaq(this)">
                            <span class="faq-question-text font-semibold text-slate-700 text-[15px] leading-snug transition-colors">{{ $item->pertanyaan }}</span>
                            <svg class="faq-icon w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </button>
                        <div class="faq-answer">
                            <div class="px-6 pb-6 pt-0">
                                <div class="h-px bg-slate-100 mb-4"></div>
                                <p class="text-slate-600 text-sm leading-relaxed whitespace-pre-line">{{ $item->jawaban }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="text-center py-8 text-slate-400">Belum ada FAQ untuk kategori ini.</div>
                @endif
            </div>
        </div>

        {{-- ====================================================== --}}
        {{-- KATEGORI 3: KEANGGOTAAN DONATUR TETAP                  --}}
        {{-- ====================================================== --}}
        <div id="keanggotaan" class="scroll-mt-36">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-10 h-10 bg-slate-600 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Kategori 3</p>
                    <h2 class="text-2xl font-bold text-slate-800">Keanggotaan Donatur Tetap</h2>
                    <p class="text-slate-500 text-sm mt-0.5">Akun Sistem &amp; Keuntungan Donatur Terdaftar</p>
                </div>
            </div>

            <div class="space-y-3">
                @php $akunFaqs = $faqs->get('akun', collect()); @endphp
                
                @if($akunFaqs->count() > 0)
                    @foreach($akunFaqs as $item)
                    <div class="faq-item border border-slate-200 rounded-2xl overflow-hidden hover:border-slate-300 transition-colors duration-200">
                        <button class="faq-btn w-full flex items-center justify-between gap-4 p-6 text-left"
                                aria-expanded="false"
                                onclick="toggleFaq(this)">
                            <span class="faq-question-text font-semibold text-slate-700 text-[15px] leading-snug transition-colors">{{ $item->pertanyaan }}</span>
                            <svg class="faq-icon w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </button>
                        <div class="faq-answer">
                            <div class="px-6 pb-6 pt-0">
                                <div class="h-px bg-slate-100 mb-4"></div>
                                <p class="text-slate-600 text-sm leading-relaxed whitespace-pre-line">{{ $item->jawaban }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="text-center py-8 text-slate-400">Belum ada FAQ untuk kategori ini.</div>
                @endif
            </div>
        </div>

        {{-- ====================================================== --}}
        {{-- KATEGORI 4: RELAWAN & BEASISWA                         --}}
        {{-- ====================================================== --}}
        <div id="relawan" class="scroll-mt-36">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-10 h-10 bg-slate-500 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Kategori 4</p>
                    <h2 class="text-2xl font-bold text-slate-800">Layanan Pendaftaran &amp; Relawan</h2>
                    <p class="text-slate-500 text-sm mt-0.5">Program Beasiswa &amp; Kesukarelawanan</p>
                </div>
            </div>

            <div class="space-y-3">
                @php $layananFaqs = $faqs->get('layanan', collect()); @endphp
                
                @if($layananFaqs->count() > 0)
                    @foreach($layananFaqs as $item)
                    <div class="faq-item border border-slate-200 rounded-2xl overflow-hidden hover:border-slate-300 transition-colors duration-200">
                        <button class="faq-btn w-full flex items-center justify-between gap-4 p-6 text-left"
                                aria-expanded="false"
                                onclick="toggleFaq(this)">
                            <span class="faq-question-text font-semibold text-slate-700 text-[15px] leading-snug transition-colors">{{ $item->pertanyaan }}</span>
                            <svg class="faq-icon w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </button>
                        <div class="faq-answer">
                            <div class="px-6 pb-6 pt-0">
                                <div class="h-px bg-slate-100 mb-4"></div>
                                <p class="text-slate-600 text-sm leading-relaxed whitespace-pre-line">{{ $item->jawaban }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="text-center py-8 text-slate-400">Belum ada FAQ untuk kategori ini.</div>
                @endif
            </div>
        </div>

        {{-- STILL HAVE QUESTIONS? CTA --}}
        <div class="bg-slate-50 rounded-3xl border border-slate-200 p-10 text-center">
            <div class="w-14 h-14 bg-slate-800 rounded-2xl flex items-center justify-center mx-auto mb-6">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-slate-800 mb-3">Masih Punya Pertanyaan Lain?</h3>
            <p class="text-slate-500 mb-8 max-w-md mx-auto">Jangan ragu untuk menghubungi kami langsung. Tim pengurus Yayasan Amaliya siap membantu Anda.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="mailto:info.amaliyasubang@gmail.com"
                   class="inline-flex items-center justify-center gap-2 bg-slate-800 text-white px-8 py-3.5 rounded-xl font-semibold hover:bg-slate-700 hover:shadow-lg transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Kirim Email
                </a>
                <a href="https://wa.me/628119918090" target="_blank" rel="noopener noreferrer"
                   class="inline-flex items-center justify-center gap-2 border border-slate-300 text-slate-700 px-8 py-3.5 rounded-xl font-semibold hover:border-slate-800 hover:text-slate-800 transition-all duration-200">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                        <path d="M12 0C5.373 0 0 5.373 0 12c0 2.125.558 4.12 1.532 5.849L.044 23.956 6.31 22.5A11.944 11.944 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22a9.956 9.956 0 01-5.195-1.453l-.371-.22-3.846.933.975-3.741-.242-.385A9.958 9.958 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/>
                    </svg>
                    WhatsApp
                </a>
            </div>
        </div>

    </div>
</main>

@include('layouts.footer')
@endsection

@push('scripts')
<script>
    // ── ACCORDION TOGGLE ─────────────────────────────────────────
    function toggleFaq(btn) {
        const answer = btn.nextElementSibling;
        const isOpen = btn.getAttribute('aria-expanded') === 'true';

        // Close all others (optional: remove this block to allow multiple open)
        document.querySelectorAll('.faq-btn[aria-expanded="true"]').forEach(function(openBtn) {
            if (openBtn !== btn) {
                openBtn.setAttribute('aria-expanded', 'false');
                openBtn.nextElementSibling.classList.remove('open');
            }
        });

        // Toggle current
        if (isOpen) {
            btn.setAttribute('aria-expanded', 'false');
            answer.classList.remove('open');
        } else {
            btn.setAttribute('aria-expanded', 'true');
            answer.classList.add('open');
        }
    }

    // ── CATEGORY TAB SCROLL ──────────────────────────────────────
    function scrollToCategory(id) {
        const el = document.getElementById(id);
        if (!el) return;
        const offset = 140; // sticky nav height approx
        const top = el.getBoundingClientRect().top + window.scrollY - offset;
        window.scrollTo({ top: top, behavior: 'smooth' });
    }

    // ── ACTIVE TAB ON SCROLL ─────────────────────────────────────
    const sections = ['profil', 'donasi', 'keanggotaan', 'relawan'];
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                sections.forEach(function(s) {
                    document.getElementById('tab-' + s)?.classList.remove('active');
                });
                document.getElementById('tab-' + entry.target.id)?.classList.add('active');
            }
        });
    }, { rootMargin: '-30% 0px -60% 0px' });

    sections.forEach(function(id) {
        const el = document.getElementById(id);
        if (el) observer.observe(el);
    });
</script>
@endpush
