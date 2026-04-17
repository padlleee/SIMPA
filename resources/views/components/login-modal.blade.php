<!-- Login Modal Component -->
<!-- Include this in landing.blade.php or any public page where you want a login modal -->

<div id="loginModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4 animate-fade-in">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full max-h-[90vh] overflow-y-auto">
        <!-- Modal Header with Close Button -->
        <div class="sticky top-0 bg-gradient-to-r from-slate-50 to-white border-b border-slate-200 p-6 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-slate-800 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </div>
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
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Username</label>
                    <input type="text" name="username" id="modalUsername" required autofocus
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-800 transition placeholder:text-slate-400"
                           placeholder="Masukkan username">
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
            <p class="text-center text-slate-400 text-xs mt-6">
                <button type="button" onclick="closeLoginModal()" class="hover:text-slate-600 transition-colors">
                    = Kembali ke Beranda
                </button>
            </p>
        </div>
    </div>
</div>

<!-- Styles -->
<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    .animate-fade-in {
        animation: fadeIn 0.3s ease-out;
    }

    #loginModal:not(.hidden) {
        display: flex;
    }
</style>

<!-- Scripts -->
<script>
    function openLoginModal() {
        document.getElementById('loginModal').classList.remove('hidden');
        document.getElementById('modalUsername').focus();
    }

    function closeLoginModal() {
        document.getElementById('loginModal').classList.add('hidden');
        // Clear errors
        document.getElementById('loginErrors').innerHTML = '';
        document.getElementById('loginErrors').classList.add('hidden');
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

    // Display errors if any
    @if($errors->any())
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
