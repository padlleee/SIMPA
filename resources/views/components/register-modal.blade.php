<!-- Register Modal Component -->
<div id="registerModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4 animate-fade-in">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full max-h-[90vh] overflow-y-auto">
        <!-- Modal Header with Close Button -->
        <div class="sticky top-0 bg-gradient-to-r from-slate-50 to-white border-b border-slate-200 p-6 flex items-center justify-between z-10">
            <div class="flex items-center gap-3">
                <img src="/storage/img/logo-panti-single.png" alt="Logo Panti Asuhan Amaliya" class="w-10 h-10 rounded-lg object-cover">
                <span class="text-lg font-bold text-slate-800">Daftar Donatur</span>
            </div>
            <button onclick="closeRegisterModal()" class="text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="p-8">
            <p class="text-slate-600 text-sm mb-6">Isi formulir di bawah untuk mengajukan permintaan akun. Admin kami akan meninjau dan menghubungi Anda melalui email.</p>

            <!-- Form Card -->
            <form id="modalRegisterForm" action="{{ route('account-request.store') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Nama Lengkap -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required
                           placeholder="Nama lengkap Anda"
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 transition @error('nama_lengkap') border-red-400 @enderror">
                    @error('nama_lengkap')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           placeholder="contoh@email.com"
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 transition @error('email') border-red-400 @enderror">
                    @if($errors->has('email') && (old('nama_lengkap') !== null || $errors->has('nama_lengkap')))
                        <p class="text-red-500 text-sm mt-1">{{ $errors->first('email') }}</p>
                    @endif
                </div>

                <!-- No HP -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        No. HP / WhatsApp <span class="text-slate-400 font-normal">(Opsional)</span>
                    </label>
                    <input type="tel" name="no_hp" value="{{ old('no_hp') }}"
                           placeholder="08xxxxxxxxxx"
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 transition">
                </div>

                <!-- Pesan -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Pesan / Alasan Bergabung <span class="text-slate-400 font-normal">(Opsional)</span>
                    </label>
                    <textarea name="pesan" rows="3" maxlength="500"
                              placeholder="Ceritakan motivasi Anda ingin menjadi donatur..."
                              class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 transition resize-none">{{ old('pesan') }}</textarea>
                </div>

                <!-- Info Box -->
                <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 flex gap-3">
                    <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-blue-700 text-xs leading-relaxed">Setelah disetujui, akun akan dikirimkan melalui email beserta password sementara.</p>
                </div>

                <!-- Submit -->
                <button type="submit"
                        class="w-full bg-slate-800 text-white py-3.5 rounded-xl font-semibold hover:bg-slate-700 transition-colors mt-2">
                    Kirim Permintaan
                </button>
            </form>

            <!-- Footer -->
            <p class="text-center text-slate-400 text-xs mt-6 space-y-1">
                <span class="block">
                    Sudah punya akun?
                    <button type="button" onclick="closeRegisterModal(); openLoginModal();" class="text-slate-600 font-medium hover:underline">Masuk di sini</button>
                </span>
            </p>
        </div>
    </div>
</div>

<!-- Scripts -->
<script>
    function openRegisterModal() {
        document.getElementById('registerModal').classList.remove('hidden');
        document.querySelector('#modalRegisterForm input[name="nama_lengkap"]').focus();
    }

    function closeRegisterModal() {
        document.getElementById('registerModal').classList.add('hidden');
    }

    // Close modal when clicking outside
    document.getElementById('registerModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeRegisterModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeRegisterModal();
        }
    });

    // Open modal if requested via session
    @if(session('showRegisterModal'))
        openRegisterModal();
    @endif

    // Open modal if there are validation errors specific to the register form
    @php
        $isRegisterError = $errors->has('nama_lengkap') || old('nama_lengkap') !== null;
    @endphp
    @if($isRegisterError && $errors->any())
        openRegisterModal();
    @endif
</script>
