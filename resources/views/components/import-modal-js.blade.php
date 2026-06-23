<script>
// ── Global Import Modal Helpers ─────────────────────────────────────────────

function openImportModal(modalId) {
    const modal  = document.getElementById(modalId);
    const dialog = document.getElementById(modalId + '-dialog');
    if (!modal || !dialog) return;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    requestAnimationFrame(() => {
        dialog.classList.remove('scale-95', 'opacity-0');
        dialog.classList.add('scale-100', 'opacity-100');
    });
}

function closeImportModal(modalId) {
    const modal  = document.getElementById(modalId);
    const dialog = document.getElementById(modalId + '-dialog');
    if (!modal || !dialog) return;
    dialog.classList.remove('scale-100', 'opacity-100');
    dialog.classList.add('scale-95', 'opacity-0');
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }, 180);
}

function handleImportFileChange(modalId, input) {
    const label      = document.getElementById(modalId + '-label');
    const submitBtn  = document.getElementById(modalId + '-submit-btn');
    const dropzone   = document.getElementById(modalId + '-dropzone');

    if (input.files && input.files[0]) {
        const file    = input.files[0];
        const sizeMB  = (file.size / (1024 * 1024)).toFixed(2);
        label.innerHTML = `<span class="font-semibold text-emerald-700">${file.name}</span> <span class="text-slate-400">(${sizeMB} MB)</span>`;
        dropzone.classList.add('border-emerald-400', 'bg-emerald-50');
        dropzone.classList.remove('border-slate-300');
        submitBtn.disabled = false;
    } else {
        label.innerHTML = '<span class="font-semibold">Klik untuk pilih file</span> atau seret ke sini';
        dropzone.classList.remove('border-emerald-400', 'bg-emerald-50');
        dropzone.classList.add('border-slate-300');
        submitBtn.disabled = true;
    }
}

function submitImportForm(modalId) {
    const form      = document.getElementById(modalId + '-form');
    const submitBtn = document.getElementById(modalId + '-submit-btn');
    const label     = document.getElementById(modalId + '-submit-label');
    if (!form || submitBtn.disabled) return;

    if (typeof simpaConfirm === 'function') {
        simpaConfirm({
            title: 'Verifikasi Akhir',
            message: 'Apakah Anda yakin template yang diunggah sudah benar dan sesuai dengan halaman ini?',
            confirmText: 'Ya, Proses Sekarang',
            type: 'warning',
            onConfirm: function() {
                label.textContent = 'Memproses...';
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-75');
                form.submit();
            }
        });
    } else {
        if (confirm('Apakah Anda yakin template yang diunggah sudah benar dan sesuai dengan halaman ini?')) {
            label.textContent = 'Memproses...';
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-75');
            form.submit();
        }
    }
}

// Close on Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        // Close any open import modal
        document.querySelectorAll('[id$="-dialog"]').forEach(dialog => {
            if (dialog.classList.contains('scale-100')) {
                const modalId = dialog.id.replace('-dialog', '');
                closeImportModal(modalId);
            }
        });
    }
});
</script>
