<script>
document.addEventListener("DOMContentLoaded", function() {
    // Hindari eksekusi di dalam dashboard admin
    if (document.body.classList.contains('dashboard-body')) return;

    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.15
    };
    
    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('opacity-100', 'translate-y-0');
                entry.target.classList.remove('opacity-0', 'translate-y-10');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Selektor umum untuk berbagai jenis halaman publik
    const selectors = [
        'section:not(.hero-background) > div[class*="max-w-"] > *',
        'main > div[class*="max-w-"] > *',
        '.max-w-2xl > div',
        '.animate-on-scroll'
    ].join(', ');

    const elementsToAnimate = document.querySelectorAll(selectors);

    elementsToAnimate.forEach((el) => {
        // Jangan terapkan animasi pada elemen navbar, footer, modal, atau hero content
        if (el.closest('nav') || el.closest('footer') || el.closest('[id*="modal"]') || el.classList.contains('hero-content')) return;
        
        el.classList.add('transition-all', 'duration-1000', 'ease-out', 'opacity-0', 'translate-y-10');
        observer.observe(el);
    });
});
</script>
