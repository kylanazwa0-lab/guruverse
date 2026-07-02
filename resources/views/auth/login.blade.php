<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guruverse - Login</title>
    @vite('resources/css/app.css')
    <script>
        (function(){
            var saved = localStorage.getItem('guruverse_theme');
            var prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
            var theme = saved || (prefersDark ? 'dark' : 'light');
            document.documentElement.setAttribute('data-theme', theme);
            if(theme==='dark') document.documentElement.classList.add('dark');
        })();
    </script>
</head>
<body class="min-h-screen bg-slate-50 dark:bg-[#0f0c29] text-slate-900 dark:text-white flex items-center justify-center p-4">
    <!-- Starfield Background for Dark Mode -->
    <div class="fixed inset-0 z-0 hidden dark:block pointer-events-none" style="background: radial-gradient(ellipse at 20% 50%, rgba(109,40,217,.15) 0%, transparent 55%), radial-gradient(ellipse at 80% 20%, rgba(55,48,163,.2) 0%, transparent 50%);"></div>

    <div class="relative z-10 w-full max-w-md">
        <!-- Logo -->
        <div class="text-center mb-8">
            <a href="/" class="inline-flex items-center gap-2">
                <img src="{{ asset('asset/img/logo guruverse FA.ai.png') }}" alt="Guruverse" class="h-10">
                <span class="text-2xl font-black tracking-tight bg-clip-text text-transparent bg-gradient-to-r from-violet-600 to-indigo-600 dark:from-violet-400 dark:to-indigo-400">Guruverse</span>
            </a>
            <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">Selamat datang kembali! Silakan masuk ke akun Anda.</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white/80 dark:bg-white/5 backdrop-blur-xl border border-white/20 dark:border-white/10 shadow-2xl rounded-3xl p-8">
            <form method="POST" action="{{ url('/login') }}" class="space-y-5">
                @csrf

                @if ($errors->any())
                    <div class="p-4 bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 rounded-2xl">
                        <ul class="list-disc list-inside text-sm text-red-600 dark:text-red-400">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div>
                    <label for="login" class="block text-xs font-bold tracking-wider uppercase text-slate-500 dark:text-slate-400 mb-2">Username / Email / Member ID</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <input type="text" id="login" name="login" value="{{ old('login') }}" required autofocus
                            class="w-full pl-11 pr-4 py-3 bg-slate-100/50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition-all dark:text-white dark:placeholder-slate-500"
                            placeholder="Masukkan identitas Anda">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold tracking-wider uppercase text-slate-500 dark:text-slate-400 mb-2">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <input type="password" id="password" name="password" required
                            class="w-full pl-11 pr-4 py-3 bg-slate-100/50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition-all dark:text-white dark:placeholder-slate-500"
                            placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 text-violet-600 rounded border-slate-300 focus:ring-violet-500 dark:border-slate-600 dark:bg-slate-700">
                        <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Ingat Saya</span>
                    </label>
                    <a href="#" class="text-sm font-semibold text-violet-600 dark:text-violet-400 hover:text-violet-700 dark:hover:text-violet-300">Lupa Password?</a>
                </div>

                <button type="submit" class="w-full py-3 px-4 bg-gradient-to-r from-violet-600 to-indigo-600 hover:from-violet-500 hover:to-indigo-500 text-white font-bold rounded-xl shadow-lg shadow-violet-500/30 transition-all active:scale-[0.98]">
                    Masuk ke Sistem
                </button>
            </form>

            <div class="mt-8 text-center text-sm font-medium text-slate-600 dark:text-slate-400">
                Belum punya akun? 
                <a href="{{ url('/register') }}" class="text-violet-600 dark:text-violet-400 hover:underline">Daftar Sekarang</a>
            </div>
        </div>
    </div>
</body>
</html>
