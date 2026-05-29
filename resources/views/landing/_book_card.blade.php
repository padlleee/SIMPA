{{--
    Partial: landing/_book_card.blade.php
    Book card component bergaya Image 3 – isolated white panel, badge di kanan atas, hover elevation.
    Variables: $buku (Perpustakaan model), $badge (string label), $badgeClass (Tailwind classes)
--}}
<a href="{{ route('perpustakaan.public.index') }}" class="book-card group">

    {{-- Cover Image – isolated panel style (Image 3) --}}
    <div class="book-card-cover">
        @if($buku->foto_buku && file_exists(public_path('storage/' . $buku->foto_buku)))
            <img src="{{ asset('storage/' . $buku->foto_buku) }}"
                 alt="{{ $buku->judul_buku }}">
        @else
            {{-- Placeholder dengan inisial judul --}}
            <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200 rounded-lg">
                <div class="text-5xl font-black text-slate-300 mb-2 select-none">
                    {{ strtoupper(substr($buku->judul_buku, 0, 1)) }}
                </div>
                <svg class="w-8 h-8 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                          d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
        @endif

        {{-- Badge top-right --}}
        <span class="book-card-badge {{ $badgeClass ?? 'bg-slate-800 text-white' }}">
            {{ $badge ?? '' }}
        </span>
    </div>

    {{-- Info --}}
    <div class="book-card-body">
        <h3 class="book-card-title">{{ $buku->judul_buku }}</h3>
        <p class="book-card-author">{{ $buku->pengarang }}</p>
        @if($buku->kategori_buku)
            <span class="book-card-genre">{{ $buku->kategori_buku }}</span>
        @endif
    </div>

</a>
