// assets/gamifikasi/js/gamifikasi.js

document.addEventListener('DOMContentLoaded', () => {
    const activityList = document.getElementById('activity-list');
    const activityDetail = document.getElementById('activity-detail');
    const btnBack = document.getElementById('btn-back');

    // Fetch catalog
    fetch('/guruverse/admin/api/gamification.php?action=list')
        .then(res => res.json())
        .then(data => {
            if(data.success && data.activities.length > 0) {
                renderList(data.activities);
                
                // Auto-open game if ?play=id is in URL
                const urlParams = new URLSearchParams(window.location.search);
                const playId = urlParams.get('play');
                if (playId) {
                    const targetAct = data.activities.find(a => a.id === playId);
                    if (targetAct) {
                        openDetail(targetAct);
                    }
                }
            } else {
                activityList.innerHTML = '<p>Belum ada data materi gamifikasi.</p>';
            }
        })
        .catch(err => {
            console.error(err);
            activityList.innerHTML = '<p style="color:red">Gagal memuat katalog.</p>';
        });

    function renderList(activities) {
        activityList.innerHTML = '';
        activities.forEach(act => {
            const card = document.createElement('div');
            card.className = 'activity-card';
            card.innerHTML = `
                <h3>${act.judul}</h3>
                <p>${act.deskripsi}</p>
                <div style="display:flex; justify-content:space-between; align-items:center; margin-top:15px;">
                    <span style="font-size:0.75rem; font-weight:bold; background:var(--color-primary); color:#fff; padding:4px 10px; border-radius:12px;">${act.kategori || 'Gamifikasi'}</span>
                    <button class="btn-buka-materi" style="background:var(--color-primary); color:#fff; border:none; padding:6px 12px; border-radius:6px; cursor:pointer;">Buka Materi</button>
                </div>
            `;
            card.addEventListener('click', () => openDetail(act));
            activityList.appendChild(card);
        });
    }

    function openDetail(act) {
        activityList.classList.add('hidden');
        activityDetail.classList.remove('hidden');
        
        // Hide the main page title
        const pageTitle = document.querySelector('.page-title');
        if(pageTitle) pageTitle.classList.add('hidden');

        document.getElementById('detail-title').textContent = act.judul;
        
        const viewerContainer = document.getElementById('viewer-container');
        viewerContainer.innerHTML = '';

        const ext = act.tipe ? act.tipe.toLowerCase() : '';
        
        if (ext === 'pdf') {
            // PDF can be viewed in browser iframe natively
            viewerContainer.innerHTML = `
                <iframe src="${act.path}" width="100%" height="600px" style="border:none; border-radius:8px;"></iframe>
            `;
        } else if (ext === 'pptx' || ext === 'ppt' || ext === 'docx' || ext === 'doc') {
            // Office files usually prompt download on local server
            viewerContainer.innerHTML = `
                <div style="text-align:center; padding: 50px 20px; background:rgba(139,47,201,0.1); border-radius:8px;">
                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="var(--color-primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom:20px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    <h2 style="margin-bottom:10px;">File Presentasi / Dokumen</h2>
                    <p style="margin-bottom:20px; color:var(--muted);">File ini berformat <strong>${ext.toUpperCase()}</strong>. Silakan unduh untuk menayangkannya di kelas Anda.</p>
                    <a href="${act.path}" download class="game-start-btn" style="text-decoration:none; display:inline-block; background-color: #8b2fc9;">Unduh Materi Sekarang</a>
                </div>
            `;
        } else if (ext === 'json') {
            // INTERACTIVE GAME ENGINE - WORDWALL STYLE
            viewerContainer.innerHTML = `
                <div id="game-canvas" class="ww-canvas">
                    <!-- UI Layer that will not overwrite decorations -->
                    <div id="game-ui" style="position: relative; z-index: 10; width: 100%; height: 100%; box-sizing: border-box; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                        <div id="game-loading" style="text-align:center;">Memuat Game...</div>
                    </div>
                </div>
            `;

            // ── Inject Space Decorations ──────────────────────────────────
            function injectSpaceDecorations(canvas) {

                // 1) STARFIELD
                const starsLayer = document.createElement('div');
                starsLayer.className = 'space-stars-layer';
                const starData = [
                    // [x%, y%, size px, dur s, delay s]
                    [5,10,2,2.1,0],[12,35,1.5,3.4,0.5],[20,55,2.5,2.8,1],[28,20,1,4,0.2],[35,70,2,3,0.8],
                    [42,15,1.5,2.5,0.3],[50,45,3,3.8,1.2],[58,80,1.5,2.2,0.7],[65,30,2,4.2,0],[72,60,1,2.9,0.4],
                    [80,18,2.5,3.1,0.9],[88,50,1.5,2.4,0.6],[93,75,2,3.6,0.1],[7,85,1,4.5,1.5],[15,65,2,2.7,0.3],
                    [25,40,1.5,3.3,0.8],[38,90,2.5,2.6,0.2],[55,10,1,4,1],[67,88,2,3.5,0.5],[77,42,1.5,2.1,0.7],
                    [90,22,2.5,3.9,1.1],[45,62,1,2.8,0.4],[62,48,2,3.2,0.9],[18,5,1.5,4.1,0.6],[84,68,2,2.3,0.1],
                    [31,55,3,3.7,0.8],[70,5,1.5,2.6,0.3],[52,28,2,4.4,0],[8,48,1,2.9,1.2],[96,38,2.5,3,0.5]
                ];
                starData.forEach(([x,y,sz,dur,delay]) => {
                    const star = document.createElement('div');
                    star.className = 'star-particle';
                    star.style.cssText = `left:${x}%;top:${y}%;width:${sz}px;height:${sz}px;--dur:${dur}s;--delay:${delay}s;`;
                    starsLayer.appendChild(star);
                });
                // Shooting stars
                [[10,25,1.8,4],[40,15,2.2,7],[70,30,1.5,11]].forEach(([x,y,dur,delay]) => {
                    const ss = document.createElement('div');
                    ss.className = 'shooting-star';
                    ss.style.cssText = `left:${x}%;top:${y}%;width:80px;--dur:${dur}s;--delay:${delay}s;`;
                    starsLayer.appendChild(ss);
                });
                canvas.appendChild(starsLayer);

                // 2) NEBULA RINGS
                [['-80px','-80px','250px','#8b2fc9',6,0],[null,'-60px','180px','#3b82f6',9,1]].forEach(([l,t,sz,clr,dur,dl]) => {
                    const ring = document.createElement('div');
                    ring.className = 'nebula-ring';
                    ring.style.cssText = `${l?'left:'+l:'right:-60px'};top:${t};width:${sz};height:${sz};background:radial-gradient(circle,${clr} 0%,transparent 70%);--dur:${dur}s;animation-delay:${dl}s;`;
                    canvas.appendChild(ring);
                });

                // 3) FLOATING PNG ICONS (Replaces SVG Planets & Astronaut)
                // 3) FLOATING PNG ICONS (Replaces SVG Planets & Astronaut)
                const floatingIcons = [
                    { src: '/guruverse/asset/img/astronot/1.png', css: 'top: 15px; right: 25px; width: 180px; --dur: 7s; --delay: 0s;' },
                    { src: '/guruverse/asset/img/astronot/2.png', css: 'top: 35px; left: 20px; width: 150px; --dur: 9s; --delay: 1.5s;' },
                    { src: '/guruverse/asset/img/astronot/3.png', css: 'bottom: 25px; left: 15px; width: 160px; --dur: 8s; --delay: 0.5s;' },
                    { src: '/guruverse/asset/img/astronot/4.png', css: 'bottom: 15px; right: 20px; width: 190px; --dur: 8.5s; --delay: 1.2s;' },
                    { src: '/guruverse/asset/img/astronot/5.png', css: 'top: 40%; left: -10px; width: 140px; --dur: 6s; --delay: 0.8s;' },
                    { src: '/guruverse/asset/img/astronot/6.png', css: 'top: 60%; right: -10px; width: 150px; --dur: 7.5s; --delay: 0.2s;' },
                    { src: '/guruverse/asset/img/astronot/8.png', css: 'top: 10%; left: 40%; width: 130px; --dur: 6.5s; --delay: 0.5s;' },
                    { src: '/guruverse/asset/img/astronot/9.png', css: 'bottom: 15%; right: 40%; width: 140px; --dur: 7.2s; --delay: 1.8s;' },
                    { src: '/guruverse/asset/img/astronot/10.png', css: 'top: 25%; left: 25%; width: 120px; --dur: 8.2s; --delay: 0.3s;' },
                    { src: '/guruverse/asset/img/astronot/11.png', css: 'top: 30%; right: 20%; width: 145px; --dur: 9.5s; --delay: 1.1s;' },
                    { src: '/guruverse/asset/img/astronot/12.png', css: 'bottom: 30%; left: 25%; width: 155px; --dur: 7.8s; --delay: 0.7s;' },
                    { src: '/guruverse/asset/img/astronot/13.png', css: 'bottom: 25%; right: 25%; width: 135px; --dur: 8.8s; --delay: 1.4s;' }
                ];

                floatingIcons.forEach(icon => {
                    const img = document.createElement('img');
                    img.src = icon.src;
                    img.className = 'space-planet planet-wobble';
                    img.style.cssText = `position: absolute; z-index: 1; filter: drop-shadow(0 15px 25px rgba(0,0,0,0.4)); ${icon.css}`;
                    canvas.appendChild(img);
                });

                // 5) Small floating stars / sparkles around astronaut
                const sparkles = [[82,92,'#fcd34d',1.2,0],[75,75,'#c084fc',0.9,0.5],[88,68,'#67e8f9',1.1,1]];
                sparkles.forEach(([x,y,clr,sz,dl]) => {
                    const sp = document.createElementNS('http://www.w3.org/2000/svg','svg');
                    sp.setAttribute('viewBox','0 0 20 20');
                    sp.setAttribute('width', `${sz*18}px`);
                    sp.setAttribute('height',`${sz*18}px`);
                    sp.className = 'space-planet planet-wobble';
                    sp.style.cssText = `left:${x}%;top:${y}%;--dur:${2+dl}s;--delay:${dl}s;opacity:0.9;`;
                    sp.innerHTML = `<polygon points="10,1 12.9,7 19.5,7.6 14.5,12 16.2,18.5 10,15 3.8,18.5 5.5,12 0.5,7.6 7.1,7" fill="${clr}" stroke="white" stroke-width="0.5"/>`;
                    canvas.appendChild(sp);
                });
            }

            fetch(act.path)
                .then(r => r.json())
                .then(game => {
                    const canvas = document.getElementById('game-canvas');
                    injectSpaceDecorations(canvas);
                    let currentQ = 0;
                    let score = 0;

                    let locked = false;

                    // Simple synthesized sounds
                    const AudioContext = window.AudioContext || window.webkitAudioContext;
                    const audioCtx = new AudioContext();
                    
                    function playSound(type) {
                        if (audioCtx.state === 'suspended') audioCtx.resume();
                        const osc = audioCtx.createOscillator();
                        const gain = audioCtx.createGain();
                        osc.connect(gain);
                        gain.connect(audioCtx.destination);
                        
                        if (type === 'correct') {
                            osc.type = 'sine';
                            osc.frequency.setValueAtTime(523.25, audioCtx.currentTime); // C5
                            osc.frequency.exponentialRampToValueAtTime(1046.50, audioCtx.currentTime + 0.1); // C6
                            gain.gain.setValueAtTime(0.5, audioCtx.currentTime);
                            gain.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.5);
                            osc.start();
                            osc.stop(audioCtx.currentTime + 0.5);
                        } else if (type === 'wrong') {
                            osc.type = 'sawtooth';
                            osc.frequency.setValueAtTime(150, audioCtx.currentTime);
                            osc.frequency.exponentialRampToValueAtTime(100, audioCtx.currentTime + 0.3);
                            gain.gain.setValueAtTime(0.5, audioCtx.currentTime);
                            gain.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.4);
                            osc.start();
                            osc.stop(audioCtx.currentTime + 0.4);
                        } else if (type === 'pop') {
                            osc.type = 'sine';
                            osc.frequency.setValueAtTime(800, audioCtx.currentTime);
                            gain.gain.setValueAtTime(0.3, audioCtx.currentTime);
                            gain.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.1);
                            osc.start();
                            osc.stop(audioCtx.currentTime + 0.1);
                        }
                    }

                    function showIntro() {
                        const ui = document.getElementById('game-ui');
                        ui.innerHTML = `
                            <div style="text-align:center; animation: ww-bounce-in 0.5s;">
                                <h1 style="font-size:3rem; margin-bottom:15px; color:#fff; text-shadow:3px 3px 0 #1e3a8a;">${game.judul}</h1>
                                <p style="font-size:1.2rem; margin-bottom:40px; text-shadow:1px 1px 0 #1e3a8a;">${game.deskripsi}</p>
                                <button id="btn-start-game" class="ww-btn-start">Mulai</button>
                            </div>
                        `;
                        document.getElementById('btn-start-game').addEventListener('click', () => {
                            playSound('pop');
                            setTimeout(playQuestion, 300);
                        });
                    }

                    function playQuestion() {
                        if (currentQ >= game.pertanyaan.length) return showResult();
                        
                        locked = false;
                        const q = game.pertanyaan[currentQ];
                        let optionsHtml = '';
                        
                        q.opsi.forEach((o, i) => {
                            const delay = i * 0.1; // staggered animation
                            optionsHtml += `
                                <div class="ww-option-btn" data-ans="${o}" style="animation-delay:${delay}s">
                                    <div class="ww-option-letter">${String.fromCharCode(65+i)}</div>
                                    ${o}
                                    <div class="ww-icon-feedback"></div>
                                </div>
                            `;
                        });

                        const ui = document.getElementById('game-ui');
                        ui.style.justifyContent = 'flex-start'; // Align to top for questions
                        ui.innerHTML = `
                            <div class="ww-header">
                                <div>${currentQ + 1} <span style="font-size:1rem;opacity:0.8">/ ${game.pertanyaan.length}</span></div>
                                <div>Skor: ${score}</div>
                            </div>
                            <div class="ww-question-box">${q.soal}</div>
                            <div class="ww-options-grid">${optionsHtml}</div>
                        `;

                        document.querySelectorAll('.ww-option-btn').forEach(btn => {
                            btn.addEventListener('click', function() {
                                if (locked) return;
                                locked = true; // prevent multiple clicks
                                
                                const ans = this.getAttribute('data-ans');
                                const feedbackIcon = this.querySelector('.ww-icon-feedback');
                                
                                if (ans === q.jawaban_benar) {
                                    score += 100;
                                    playSound('correct');
                                    this.classList.add('ww-opt-correct');
                                    feedbackIcon.innerHTML = '✔';
                                } else {
                                    playSound('wrong');
                                    this.classList.add('ww-opt-wrong');
                                    feedbackIcon.innerHTML = '✖';
                                    
                                    // Highlight the correct answer
                                    document.querySelectorAll('.ww-option-btn').forEach(b => {
                                        if (b.getAttribute('data-ans') === q.jawaban_benar) {
                                            b.classList.add('ww-opt-correct');
                                            b.querySelector('.ww-icon-feedback').innerHTML = '✔';
                                        }
                                    });
                                }
                                
                                // Lock all buttons
                                document.querySelectorAll('.ww-option-btn').forEach(b => b.classList.add('locked'));

                                // Wait 1.5 seconds before next question
                                setTimeout(() => { currentQ++; playQuestion(); }, 1500);
                            });
                        });
                    }

                    function showResult() {
                        const isPerfect = score === (game.pertanyaan.length * 100);
                        playSound(isPerfect ? 'correct' : 'pop');
                        
                        const ui = document.getElementById('game-ui');
                        ui.style.justifyContent = 'center'; // Center vertically again
                        ui.innerHTML = `
                            <div style="text-align:center; animation: ww-bounce-in 0.6s;">
                                <div style="font-size:5rem; margin-bottom:10px; text-shadow:0 10px 20px rgba(0,0,0,0.5);">${isPerfect ? '🏆' : '⭐'}</div>
                                <h1 style="font-size:3rem; margin-bottom:15px; text-shadow:3px 3px 0 #1e3a8a;">Papan Peringkat</h1>
                                <p style="font-size:1.5rem; margin-bottom:10px;">Skor Anda: <strong style="color:#f59e0b;font-size:2rem;text-shadow:2px 2px 0 #000;">${score}</strong></p>
                                <p style="margin-bottom:30px; opacity:0.9;">Menjawab ${score/100} benar dari ${game.pertanyaan.length} soal.</p>
                                <button id="btn-replay" class="ww-btn-start" style="font-size:1.2rem; padding:10px 30px;">Main Lagi 🔄</button>
                            </div>
                        `;
                        document.getElementById('btn-replay').addEventListener('click', () => {
                            playSound('pop');
                            currentQ = 0; score = 0; locked = false; showIntro();
                        });
                    }

                    showIntro();

                }).catch(err => {
                    document.getElementById('game-canvas').innerHTML = `<p style="color:#ef476f">Gagal memuat data game.</p>`;
                });
        } else {
            viewerContainer.innerHTML = `<p>Format file tidak didukung untuk pratinjau.</p>`;
        }
    }

    btnBack.addEventListener('click', () => {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('play')) {
            // Jika diakses langsung via ?play=, kembali ke halaman sebelumnya
            if (window.history.length > 1) {
                window.history.back();
            } else {
                window.location.href = '/guruverse/index.php';
            }
            return;
        }

        activityDetail.classList.add('hidden');
        activityList.classList.remove('hidden');
        
        // Restore page title
        const pageTitle = document.querySelector('.page-title');
        if(pageTitle) pageTitle.classList.remove('hidden');

        document.getElementById('viewer-container').innerHTML = '';
        document.getElementById('claim-msg').style.display = 'none';
        document.getElementById('btn-claim').style.display = 'inline-block';
    });

    document.getElementById('btn-claim').addEventListener('click', (e) => {
        e.target.style.display = 'none';
        const msg = document.getElementById('claim-msg');
        msg.style.display = 'block';
        msg.innerHTML = '🎉 Selamat! Anda mendapatkan <strong>+100 XP</strong> karena telah menggunakan materi ini di kelas!';
        // In real app, make API POST to update gb_mengajar_stats
    });
});
