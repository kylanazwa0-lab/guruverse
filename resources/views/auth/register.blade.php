<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guruverse - Registrasi</title>
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

    <div class="relative z-10 w-full max-w-lg my-8">
        <!-- Logo -->
        <div class="text-center mb-6">
            <a href="/" class="inline-flex items-center gap-2">
                <img src="{{ asset('asset/img/logo guruverse FA.ai.png') }}" alt="Guruverse" class="h-8">
                <span class="text-xl font-black tracking-tight bg-clip-text text-transparent bg-gradient-to-r from-violet-600 to-indigo-600 dark:from-violet-400 dark:to-indigo-400">Guruverse</span>
            </a>
            <h1 class="mt-4 text-2xl font-black text-slate-800 dark:text-white">Daftar Akun Baru</h1>
            <p class="text-sm text-slate-600 dark:text-slate-400">Bergabunglah dengan ekosistem pendidikan terbesar di Indonesia.</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white/80 dark:bg-white/5 backdrop-blur-xl border border-white/20 dark:border-white/10 shadow-2xl rounded-3xl p-6 sm:p-8">
            <form method="POST" action="{{ url('/register') }}" class="space-y-4">
                @csrf

                @if ($errors->any())
                    <div class="p-4 bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 rounded-2xl mb-4">
                        <ul class="list-disc list-inside text-sm text-red-600 dark:text-red-400">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div>
                    <label for="full_name" class="block text-xs font-bold tracking-wider uppercase text-slate-500 dark:text-slate-400 mb-1">Nama Lengkap *</label>
                    <input type="text" id="full_name" name="full_name" value="{{ old('full_name') }}" required autofocus
                        class="w-full px-4 py-2.5 bg-slate-100/50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition-all dark:text-white dark:placeholder-slate-500"
                        placeholder="Cth: Budi Santoso">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="username" class="block text-xs font-bold tracking-wider uppercase text-slate-500 dark:text-slate-400 mb-1">Username *</label>
                        <input type="text" id="username" name="username" value="{{ old('username') }}" required
                            class="w-full px-4 py-2.5 bg-slate-100/50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition-all dark:text-white dark:placeholder-slate-500"
                            placeholder="Cth: budi123">
                    </div>
                    <div>
                        <label for="email" class="block text-xs font-bold tracking-wider uppercase text-slate-500 dark:text-slate-400 mb-1">Email *</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                            class="w-full px-4 py-2.5 bg-slate-100/50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition-all dark:text-white dark:placeholder-slate-500"
                            placeholder="Cth: budi@sekolah.id">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-xs font-bold tracking-wider uppercase text-slate-500 dark:text-slate-400 mb-1">Password *</label>
                        <input type="password" id="password" name="password" required minlength="8"
                            class="w-full px-4 py-2.5 bg-slate-100/50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition-all dark:text-white dark:placeholder-slate-500"
                            placeholder="Minimal 8 karakter">
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-xs font-bold tracking-wider uppercase text-slate-500 dark:text-slate-400 mb-1">Konfirmasi Password *</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                            class="w-full px-4 py-2.5 bg-slate-100/50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition-all dark:text-white dark:placeholder-slate-500"
                            placeholder="Ulangi password">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="institution" class="block text-xs font-bold tracking-wider uppercase text-slate-500 dark:text-slate-400 mb-1">Instansi / Sekolah</label>
                        <input type="text" id="institution" name="institution" value="{{ old('institution') }}"
                            class="w-full px-4 py-2.5 bg-slate-100/50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition-all dark:text-white dark:placeholder-slate-500"
                            placeholder="Cth: SMAN 1 Jakarta">
                    </div>
                    <div>
                        <label for="phone" class="block text-xs font-bold tracking-wider uppercase text-slate-500 dark:text-slate-400 mb-1">No. WhatsApp</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone') }}"
                            class="w-full px-4 py-2.5 bg-slate-100/50 dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition-all dark:text-white dark:placeholder-slate-500"
                            placeholder="Cth: 08123456789">
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-3 px-4 bg-gradient-to-r from-violet-600 to-indigo-600 hover:from-violet-500 hover:to-indigo-500 text-white font-bold rounded-xl shadow-lg shadow-violet-500/30 transition-all active:scale-[0.98]">
                        Daftar Akun Sekarang
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center text-sm font-medium text-slate-600 dark:text-slate-400">
                Sudah punya akun? 
                <a href="{{ url('/login') }}" class="text-violet-600 dark:text-violet-400 hover:underline">Masuk di sini</a>
            </div>
        </div>
    </div>
</body>
</html>
