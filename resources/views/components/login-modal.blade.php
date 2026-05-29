<!-- Login Modal Component -->
<!-- Include this in landing.blade.php or any public page where you want a login modal -->

<div id="loginModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4 animate-fade-in">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full max-h-[90vh] overflow-y-auto">
        <!-- Modal Header with Close Button -->
        <div class="sticky top-0 bg-gradient-to-r from-slate-50 to-white border-b border-slate-200 p-6 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <img src="/images/logo-panti-single.png" alt="Logo Panti Asuhan Amaliya" class="w-10 h-10 rounded-lg object-cover">
                <span class="text-lg font-bold text-slate-800">SIMPA</span>
            </div>
            <button onclick="closeLoginModal()" class="text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="p-8">
            <h2 class="text-xl font-bold text-slate-800 mb-2">Selamat Datang</h2>
            <p class="text-slate-600 text-sm mb-6">Masuk ke akun Anda untuk mengakses sistem manajemen panti asuhan.</p>

            <!-- Error Messages -->
            <div id="loginErrors" class="mb-5 hidden"></div>

            <!-- Login Form -->
            <form id="modalLoginForm" action="{{ route('login.post') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                    <input type="email" name="email" id="modalEmail" required autofocus
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 transition placeholder:text-slate-400"
                           placeholder="contoh@email.com">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
                    <input type="password" name="password" id="modalPassword" required
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 transition placeholder:text-slate-400"
                           placeholder="••••••••">
                </div>

                <button type="submit" class="w-full bg-slate-800 text-white py-3.5 rounded-xl font-semibold hover:bg-slate-700 transition-colors">
                    Masuk ke Sistem
                </button>

                {{-- Lupa Password --}}
                <div class="text-center">
                    <button type="button" onclick="toggleForgotPanel()"
                            class="text-sm text-slate-400 hover:text-slate-600 transition-colors">
                        Lupa password?
                    </button>
                </div>

                {{-- Panel Lupa Password (awalnya tersembunyi) --}}
                <div id="forgotPanel" class="hidden">
                    {{-- Separator --}}
                    <div class="border-t border-slate-100 pt-4">
                        <p class="text-sm font-semibold text-slate-700 mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                            </svg>
                            Lupa Password
                        </p>

                        {{-- Form Input Email --}}
                        <div id="forgotForm">
                            <p class="text-xs text-slate-500 mb-3">
                                Khusus donatur: masukkan email terdaftar Anda. Admin akan mengirimkan password baru.
                            </p>
                            <div class="flex gap-2">
                                <input type="email" id="forgotEmail"
                                       placeholder="email@terdaftar.com"
                                       class="flex-1 border border-slate-300 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-slate-800 transition placeholder:text-slate-400">
                                <button type="button" id="forgotSubmitBtn"
                                        onclick="submitForgotPassword()"
                                        class="bg-slate-800 text-white px-4 py-2.5 rounded-xl text-sm font-semibold hover:bg-slate-700 transition-colors whitespace-nowrap">
                                    Kirim
                                </button>
                            </div>
                            <p id="forgotEmailError" class="text-xs text-red-500 mt-1.5 hidden"></p>
                        </div>

                        {{-- Hasil AJAX (awalnya tersembunyi) --}}
                        <div id="forgotResult" class="hidden mt-3 rounded-xl p-3.5 text-sm"></div>

                        {{-- Tombol kembali ke form --}}
                        <button type="button" id="forgotRetryBtn"
                                onclick="resetForgotForm()"
                                class="hidden mt-2 text-xs text-slate-400 hover:text-slate-600 transition-colors">
                            ← Coba email lain
                        </button>
                    </div>
                </div>
            </form>

            <!-- Divider -->
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-slate-200"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-slate-500">atau</span>
                </div>
            </div>

            <!-- Info Section -->
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 space-y-3">
                <div class="flex gap-3">
                    <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="text-sm text-blue-700">
                        <p class="font-semibold mb-1">Akses Dibatasi</p>
                        <p>Hanya pengguna terdaftar yang dapat mengakses sistem ini. Hubungi admin untuk membuat akun baru.</p>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <p class="text-center text-slate-400 text-xs mt-6 space-y-1">
                <span class="block">
                    Belum punya akun?
                    <button type="button" onclick="closeLoginModal(); openRegisterModal();" class="text-slate-600 font-medium hover:underline">Daftar sebagai Donatur</button>
                </span>
                <button type="button" onclick="closeLoginModal()" class="hover:text-slate-600 transition-colors">
                    ← Kembali ke Beranda
                </button>
            </p>
        </div>
    </div>
</div>

{{-- Styles moved to public/css/simpa-style.css --}}

<!-- Scripts -->
<script>
    function openLoginModal() {
        document.getElementById('loginModal').classList.remove('hidden');
        document.getElementById('modalEmail').focus();
    }

    function closeLoginModal() {
        document.getElementById('loginModal').classList.add('hidden');
        // Clear errors
        document.getElementById('loginErrors').innerHTML = '';
        document.getElementById('loginErrors').classList.add('hidden');
        // Hide forgot panel
        const fp = document.getElementById('forgotPanel');
        if (fp) fp.classList.add('hidden');
    }

    function toggleForgotPanel() {
        const panel = document.getElementById('forgotPanel');
        if (panel) {
            panel.classList.toggle('hidden');
            // Reset ke form saat panel dibuka kembali
            if (!panel.classList.contains('hidden')) {
                resetForgotForm();
            }
        }
    }

    function resetForgotForm() {
        document.getElementById('forgotEmail').value    = '';
        document.getElementById('forgotEmailError').classList.add('hidden');
        document.getElementById('forgotResult').classList.add('hidden');
        document.getElementById('forgotRetryBtn').classList.add('hidden');
        document.getElementById('forgotForm').classList.remove('hidden');
    }

    async function submitForgotPassword() {
        const emailInput = document.getElementById('forgotEmail');
        const emailError = document.getElementById('forgotEmailError');
        const resultDiv  = document.getElementById('forgotResult');
        const submitBtn  = document.getElementById('forgotSubmitBtn');
        const retryBtn   = document.getElementById('forgotRetryBtn');
        const formDiv    = document.getElementById('forgotForm');
        const email      = emailInput.value.trim();

        // Validasi sederhana di client
        emailError.classList.add('hidden');
        if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            emailError.textContent = 'Masukkan alamat email yang valid.';
            emailError.classList.remove('hidden');
            return;
        }

        // Loading state
        submitBtn.disabled    = true;
        submitBtn.textContent = 'Mengirim...';

        try {
            // Ambil CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content
                           || document.querySelector('input[name="_token"]')?.value
                           || '';

            const res  = await fetch('{{ route("password.request-reset") }}', {
                method : 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept'      : 'application/json',
                },
                body: JSON.stringify({ email }),
            });

            const data = await res.json();

            // Konfigurasi tampilan per status
            const config = {
                success         : { bg: 'bg-green-50 border border-green-200 text-green-700',  icon: '✅' },
                already_requested: { bg: 'bg-amber-50 border border-amber-200 text-amber-700', icon: '⏳' },
                not_allowed     : { bg: 'bg-slate-50 border border-slate-200 text-slate-600',  icon: 'ℹ️' },
                not_found       : { bg: 'bg-red-50 border border-red-200 text-red-600',        icon: '❌' },
            };

            const cfg = config[data.status] || config.not_found;
            resultDiv.className = `mt-3 rounded-xl p-3.5 text-sm ${cfg.bg}`;
            resultDiv.innerHTML = `<span class="mr-1">${cfg.icon}</span>${data.message}`;

            // Tampilkan hasil, sembunyikan form
            formDiv.classList.add('hidden');
            resultDiv.classList.remove('hidden');
            retryBtn.classList.remove('hidden');

        } catch (err) {
            resultDiv.className = 'mt-3 rounded-xl p-3.5 text-sm bg-red-50 border border-red-200 text-red-600';
            resultDiv.innerHTML = '❌ Terjadi kesalahan. Silakan coba lagi.';
            resultDiv.classList.remove('hidden');
        } finally {
            submitBtn.disabled    = false;
            submitBtn.textContent = 'Kirim';
        }
    }

    // Close modal when clicking outside
    document.getElementById('loginModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeLoginModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeLoginModal();
        }
    });

    // Handle form submission with error display
    document.getElementById('modalLoginForm').addEventListener('submit', function(e) {
        // Clear previous errors
        document.getElementById('loginErrors').innerHTML = '';
        document.getElementById('loginErrors').classList.add('hidden');
    });

    // Open modal if requested via session
    @if(session('showLoginModal'))
        openLoginModal();
    @endif

    @php
        $isLoginError = $errors->any() && !$errors->has('nama_lengkap') && old('nama_lengkap') === null;
    @endphp

    // Display errors if any
    @if($isLoginError)
        openLoginModal();
        const errorsDiv = document.getElementById('loginErrors');
        @foreach($errors->all() as $error)
            const errorMsg = document.createElement('div');
            errorMsg.className = 'bg-red-50 border border-red-200 text-red-700 rounded-xl p-4 text-sm flex gap-3';
            errorMsg.innerHTML = `
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>{{ $error }}</span>
            `;
            errorsDiv.appendChild(errorMsg);
        @endforeach
        errorsDiv.classList.remove('hidden');
    @endif
</script>
