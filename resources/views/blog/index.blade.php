@extends('layouts.master')

@section('title', 'Blog & Kegiatan')
@section('meta-description', 'Berita dan dokumentasi kegiatan terkini Yayasan Panti Asuhan Amaliya Subang.')
@section('body-class', 'bg-white text-slate-800')

@section('body')
@include('layouts.navbar')

{{-- HEADER --}}
<section class="pt-32 pb-10 bg-gradient-to-b from-slate-50 to-white">
    <div class="max-w-5xl mx-auto px-6 text-center">
        <span class="inline-block text-xs font-semibold text-slate-500 uppercase tracking-widest bg-slate-100 px-4 py-1.5 rounded-full mb-5">Blog & Kegiatan</span>
        <h1 class="text-4xl font-bold text-slate-800 mb-4">Dokumentasi & Berita Terkini</h1>
        <p class="text-slate-500 max-w-xl mx-auto">Liputan kegiatan, program pembinaan, renovasi, dan momen bermakna bersama anak-anak asuh Yayasan Amaliya.</p>
    </div>
</section>

{{-- ARTICLE GRID --}}
<section class="pb-20">
    <div class="max-w-6xl mx-auto px-6">
        @if($articles->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7">
            @foreach($articles as $article)
            <a href="{{ route('blog.show', $article->slug) }}"
               class="group bg-white border border-slate-200 rounded-2xl overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                {{-- Image --}}
                <div class="w-full h-48 bg-slate-100 overflow-hidden relative">
                    @if($article->image)
                        <img src="{{ asset('storage/' . $article->image) }}"
                             alt="{{ $article->title }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    @endif
                </div>
                {{-- Content --}}
                <div class="p-5">
                    <div class="flex items-center gap-2 text-xs text-slate-400 mb-3">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ $article->created_at->locale('id')->translatedFormat('j F Y') }}
                        @if($article->author)
                            <span>·</span>
                            <span>{{ $article->author->username }}</span>
                        @endif
                    </div>
                    <h2 class="font-bold text-slate-800 text-base mb-2 leading-snug group-hover:text-slate-600 transition-colors line-clamp-2">
                        {{ $article->title }}
                    </h2>
                    <p class="text-slate-500 text-sm leading-relaxed line-clamp-3">{{ $article->excerpt }}</p>
                    <div class="mt-4 text-xs font-semibold text-slate-600 group-hover:text-slate-800 flex items-center gap-1 transition-colors">
                        Baca Selengkapnya
                        <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($articles->hasPages())
        <div class="mt-12 flex justify-center">
            {{ $articles->links() }}
        </div>
        @endif

        @else
        <div class="text-center py-24 text-slate-400">
            <div class="text-6xl mb-4">📝</div>
            <p class="font-semibold text-slate-500 text-lg">Belum ada artikel yang dipublikasikan</p>
            <p class="text-sm mt-2">Konten akan segera hadir. Pantau terus!</p>
        </div>
        @endif
    </div>
</section>

@include('layouts.footer')
@endsection
