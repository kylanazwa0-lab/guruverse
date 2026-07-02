<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Anggota - Guruverse.id</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Hanya kartu yang dicetak saat print/save PDF */
        @media print {
            body > *:not(#print-area) { display: none !important; }
            #print-area { display: block !important; }
            .no-print { display: none !important; }
        }

        /* Shimmer loading skeleton */
        .skeleton {
            background: linear-gradient(90deg, #e0e7ff 25%, #c7d2fe 50%, #e0e7ff 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
            border-radius: 0.5rem;
        }
        @keyframes shimmer {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-indigo-100 to-purple-100 flex flex-col items-center justify-center p-6">

    <!-- Loading Skeleton -->
    <div id="skeleton" class="w-[400px] space-y-3">
        <div class="skeleton h-10 w-40 mx-auto mb-4"></div>
        <div class="skeleton h-[253px] w-full rounded-[2rem]"></div>
        <div class="skeleton h-12 w-full rounded-xl"></div>
    </div>

    <!-- Area Kartu (tersembunyi sampai data siap) -->
    <div id="card-container" class="hidden flex flex-col items-center gap-6">

        <!-- Judul -->
        <h1 class="text-2xl font-black text-indigo-800 uppercase tracking-widest">Kartu Anggota</h1>

        <!-- Kartu Digital -->
        <div id="print-area">
            <div class="relative w-[400px] rounded-[2rem] overflow-hidden text-white p-8 bg-indigo-900 shadow-2xl"
                 style="aspect-ratio: 1.58 / 1;">

                <!-- Background image kartu -->
                <img src="https://images.unsplash.com/photo-1614850715649-1d0106293bd1?q=80&w=2070"
                     class="absolute inset-0 w-full h-full object-cover opacity-40"
                     alt="">

                <!-- Konten kartu -->
                <div class="relative z-10 flex flex-col h-full">

                    <!-- Header kartu -->
                    <div class="flex justify-between items-start">
                        <h4 class="font-black italic text-lg tracking-widest">GURUVERSE.ID</h4>
                        <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center text-xs font-black">✦</div>
                    </div>

                    <!-- Info anggota -->
                    <div class="mt-auto flex items-center gap-4">
                        <img id="card-photo" src="" alt="Foto Profil"
                             class="w-20 h-20 rounded-2xl object-cover border-2 border-white shrink-0">
                        <div>
                            <h2 id="card-name" class="text-xl font-black uppercase leading-tight"></h2>
                            <p id="card-institution" class="text-xs opacity-80 mt-1"></p>
                        </div>
                    </div>

                    <!-- Footer kartu -->
                    <div class="mt-4 pt-4 border-t border-white/20 flex justify-between items-end">
                        <div>
                            <p class="text-[8px] font-black tracking-widest opacity-70">ID ANGGOTA</p>
                            <p id="card-member-id" class="font-mono text-lg font-black tracking-wider"></p>
                        </div>
                        <div class="text-[10px] bg-white/20 px-3 py-1 rounded-full font-semibold tracking-wide">
                            ✓ Verified
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="flex gap-3 no-print">
            <button onclick="window.print()"
                    class="bg-slate-900 hover:bg-slate-700 text-white px-8 py-3 rounded-xl font-black transition">
                🖨️ Simpan Kartu (PDF)
            </button>
            <a href="index.php"
               class="bg-indigo-100 hover:bg-indigo-200 text-indigo-700 px-6 py-3 rounded-xl font-black transition">
                ← Kembali
            </a>
        </div>

        <!-- Info anggota detail -->
        <div id="card-detail" class="no-print bg-white rounded-2xl shadow p-6 w-[400px] text-sm text-gray-700 space-y-2">
            <p><span class="font-bold">📧 Email:</span> <span id="detail-email"></span></p>
            <p><span class="font-bold">📱 WhatsApp:</span> <span id="detail-phone"></span></p>
            <p><span class="font-bold">📅 Bergabung:</span> <span id="detail-joined"></span></p>
        </div>

    </div>

    <!-- Pesan error jika ID tidak ditemukan -->
    <div id="error-box" class="hidden bg-red-100 text-red-700 border border-red-300 rounded-2xl p-8 text-center max-w-sm">
        <p class="text-3xl mb-3">❌</p>
        <p class="font-bold text-lg">Kartu tidak ditemukan</p>
        <p class="text-sm mt-1">ID anggota tidak valid atau data tidak tersedia.</p>
        <a href="index.php" class="inline-block mt-4 bg-indigo-600 text-white px-6 py-2 rounded-xl font-bold">Daftar Sekarang</a>
    </div>

    <script>
    // ============================================
    // STEP 1: Ambil member_id dari URL
    // ============================================
    const urlParams = new URLSearchParams(window.location.search);
    const memberId  = urlParams.get('id');

    if (!memberId) {
        showError();
    } else {
        // ============================================
        // STEP 2: Fetch data anggota via AJAX
        // ============================================
        fetch('/api/get_member?id=' + encodeURIComponent(memberId))
            .then(res => res.json())
            .then(data => {
                document.getElementById('skeleton').classList.add('hidden');

                if (data.success) {
                    renderCard(data.member);
                } else {
                    showError();
                }
            })
            .catch(() => showError());
    }

    // ============================================
    // STEP 3: Render kartu dengan data dari API
    // ============================================
    function renderCard(m) {
        document.getElementById('card-photo').src       = '/uploads/' + m.photo_path; // Legacy fallback, or use /storage/ if symlinked
        document.getElementById('card-name').textContent        = m.full_name;
        document.getElementById('card-institution').textContent = m.institution;
        document.getElementById('card-member-id').textContent   = m.member_id;

        document.getElementById('detail-email').textContent  = m.email;
        document.getElementById('detail-phone').textContent  = m.phone;
        document.getElementById('detail-joined').textContent = new Date(m.joined_at).toLocaleDateString('id-ID', {
            weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
        });

        document.getElementById('card-container').classList.remove('hidden');
    }

    function showError() {
        document.getElementById('skeleton').classList.add('hidden');
        document.getElementById('error-box').classList.remove('hidden');
    }
    </script>

</body>
</html>