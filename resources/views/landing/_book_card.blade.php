{{--
    Partial: landing/_book_card.blade.php
    Reusable book card component untuk 3 seksi kurasi landing page.
    Variables: $buku (Perpustakaan model), $badge (string label), $badgeClass (Tailwind classes)
--}}
<a href="{{ route('perpustakaan.public.index') }}"
   class="group flex flex-col bg-white rounded-2xl border border-slate-200 overflow-hidden hover:shadow-lg hover:-translate-y-1 transition-all duration-300">

    {{-- Cover Image --}}
    <div class="relative w-full aspect-[2/3] bg-slate-100 overflow-hidden">
        @if($buku->foto_buku && file_exists(public_path('storage/' . $buku->foto_buku)))
            <img src="{{ asset('storage/' . $buku->foto_buku) }}"
                 alt="{{ $buku->judul_buku }}"
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        @else
            {{-- Placeholder dengan inisial judul --}}
            <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200 p-4">
                <div class="text-4xl font-bold text-slate-300 mb-2">
                    {{ strtoupper(substr($buku->judul_buku, 0, 1)) }}
                </div>
                <svg class="w-8 h-8 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
        @endif

        {{-- Badge --}}
        <span class="absolute top-2 left-2 text-xs font-bold px-2.5 py-1 rounded-full shadow-sm {{ $badgeClass ?? 'bg-slate-800 text-white' }}">
            {{ $badge ?? '' }}
        </span>
    </div>

    {{-- Info --}}
    <div class="p-4 flex-1 flex flex-col">
        <h3 class="font-bold text-slate-800 text-sm leading-snug line-clamp-2 group-hover:text-slate-600 transition-colors mb-1">
            {{ $buku->judul_buku }}
        </h3>
        <p class="text-slate-400 text-xs">{{ $buku->pengarang }}</p>
        @if($buku->kategori_buku)
        <span class="mt-2 inline-block text-xs text-slate-500 bg-slate-50 border border-slate-200 px-2 py-0.5 rounded-full self-start">
            {{ $buku->kategori_buku }}
        </span>
        @endif
    </div>
</a>
