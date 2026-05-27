{{--
    Partial: landing/_empty_books.blade.php
    Empty state untuk panel kurasi yang belum memiliki buku.
    Variables: $icon (emoji), $label (string kategori)
--}}
<div class="flex flex-col items-center justify-center py-16 text-center">
    <div class="text-5xl mb-4">{{ $icon ?? '📚' }}</div>
    <p class="font-semibold text-slate-500">Belum ada buku kurasi untuk "{{ $label ?? 'kategori ini' }}"</p>
    <p class="text-slate-400 text-sm mt-2 max-w-xs">
        Admin dapat menambahkan buku ke bagian ini melalui menu Perpustakaan di panel admin.
    </p>
    <a href="{{ route('perpustakaan.public.index') }}"
       class="mt-6 inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-slate-800 transition-colors">
        Lihat Semua Koleksi
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
    </a>
</div>
