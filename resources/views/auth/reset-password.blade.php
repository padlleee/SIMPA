<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password – SIMPA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md px-4 py-8">
        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-slate-800">Buat Password Baru</h1>
            <p class="text-slate-500 text-sm mt-2">Masukkan password baru untuk akun Anda</p>
        </div>

        @if($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 rounded-xl p-4 text-sm flex gap-3">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>{{ $errors->first() }}</span>
        </div>
        @endif

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8 mb-6">
            <form action="{{ route('password.update-reset') }}" method="POST" class="space-y-5">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                    <input type="email" name="email" value="{{ $email ?? old('email') }}" readonly required
                           class="w-full bg-slate-50 border border-slate-200 text-slate-500 cursor-not-allowed rounded-xl px-4 py-3 focus:outline-none transition">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Password Baru</label>
                    <input type="password" name="password" required autofocus
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition @error('password') border-red-400 @enderror"
                           placeholder="Min 8 karakter">
                    @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required
                           class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition @error('password_confirmation') border-red-400 @enderror"
                           placeholder="Ulangi kata sandi baru">
                    @error('password_confirmation')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white py-3.5 rounded-xl font-semibold hover:bg-blue-700 transition-colors mt-2">
                    Reset Password
                </button>
            </form>
        </div>
        
        <div class="text-center">
            <a href="{{ url('/') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-800 transition">
                &larr; Kembali ke halaman Login
            </a>
        </div>

    </div>

    <!-- Auto-inject Password Visibility Toggle -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const passwordInputs = document.querySelectorAll('input[type="password"]');
        passwordInputs.forEach(input => {
            if (input.parentElement && input.parentElement.classList.contains('password-wrapper')) return;
            
            const wrapper = document.createElement('div');
            wrapper.className = 'relative password-wrapper flex-1 w-full';
            input.parentNode.insertBefore(wrapper, input);
            wrapper.appendChild(input);
            input.classList.add('pr-12'); // Extra padding for the icon
            
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none transition-colors';
            btn.innerHTML = `
                <svg class="h-5 w-5 eye-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                <svg class="h-5 w-5 eye-slash-icon hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
            `;
            
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const isPassword = input.type === 'password';
                input.type = isPassword ? 'text' : 'password';
                btn.querySelector('.eye-icon').classList.toggle('hidden', isPassword);
                btn.querySelector('.eye-slash-icon').classList.toggle('hidden', !isPassword);
            });
            wrapper.appendChild(btn);
        });
    });
    </script>
</body>
</html>
