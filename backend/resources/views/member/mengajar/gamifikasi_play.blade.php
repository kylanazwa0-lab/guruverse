<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ htmlspecialchars($title) }} - GuruVerse Play</title>
    <style>
        :root {
            --primary: #8b5cf6;
            --primary-hover: #7c3aed;
            --secondary: #3b82f6;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --bg: #0f172a;
            --text: #ffffff;
            --text-light: #94a3b8;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Nunito', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background: var(--bg); color: var(--text); overflow-x: hidden; min-height: 100vh; display: flex; flex-direction: column; }
        
        /* SHAPES BACKGROUND - SPACE THEME */
        .bg-shapes { position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; z-index: -1; overflow: hidden; pointer-events: none; background: radial-gradient(circle at 50% 50%, #1e293b 0%, #020617 100%); }
        .bg-shapes::before { content: ''; position: absolute; top:-50%; left:-50%; width: 200%; height: 200%; background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 50px 50px; opacity: 0.15; animation: starTwinkle 15s linear infinite; }
        .bg-shape { position: absolute; border-radius: 50%; opacity: 0.4; filter: blur(80px); animation: float 20s infinite alternate; }
        .shape-1 { width: 40vw; height: 40vw; background: #4c1d95; top: -10%; left: -10%; animation-delay: 0s; }
        .shape-2 { width: 30vw; height: 30vw; background: #1e3a8a; bottom: -5%; right: -5%; animation-delay: -5s; }
        .shape-3 { width: 25vw; height: 25vw; background: #064e3b; top: 40%; left: 40%; animation-delay: -10s; }

        @keyframes starTwinkle { 0% { transform: translateY(0) rotate(0deg); } 100% { transform: translateY(50px) rotate(2deg); } }
        @keyframes float {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(100px, 50px) scale(1.1); }
        }

        /* SCREENS */
        .screen { display: none; flex-direction: column; align-items: center; justify-content: center; min-height: 100vh; width: 100%; padding: 20px; text-align: center; animation: fadeIn 0.4s ease-out; }
        .screen.active { display: flex; }
        @keyframes fadeIn { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }

        /* START SCREEN */
        .game-title { font-size: 3.5rem; font-weight: 900; color: #ffffff; margin-bottom: 16px; text-shadow: 0 0 15px rgba(139, 92, 246, 0.8), 0 0 30px rgba(139, 92, 246, 0.5); line-height: 1.2; letter-spacing: 2px; }
        .game-desc { font-size: 1.2rem; color: #cbd5e1; max-width: 600px; margin-bottom: 40px; }
        .btn-play { background: linear-gradient(135deg, var(--primary), var(--secondary)); color: #fff; border: none; padding: 20px 48px; font-size: 1.5rem; font-weight: 800; border-radius: 99px; cursor: pointer; transition: all 0.2s; box-shadow: 0 0 25px rgba(139, 92, 246, 0.6); text-transform: uppercase; letter-spacing: 2px; }
        .btn-play:hover { transform: translateY(-4px) scale(1.05); box-shadow: 0 0 40px rgba(139, 92, 246, 0.8); }
        .btn-play:active { transform: translateY(2px) scale(0.98); }

        /* PLAY SCREEN */
        .top-bar { position: absolute; top: 0; left: 0; width: 100%; padding: 20px 40px; display: flex; justify-content: space-between; align-items: center; z-index: 10; }
        .question-counter { background: rgba(255,255,255,0.05); backdrop-filter: blur(10px); padding: 8px 16px; border-radius: 99px; font-weight: 800; color: #fff; box-shadow: 0 4px 12px rgba(0,0,0,0.2); font-size: 1.1rem; border: 1px solid rgba(255,255,255,0.1); }
        .score-display { background: rgba(255,255,255,0.05); backdrop-filter: blur(10px); padding: 8px 16px; border-radius: 99px; font-weight: 800; color: var(--warning); box-shadow: 0 4px 12px rgba(0,0,0,0.2); font-size: 1.1rem; display: flex; align-items: center; gap: 8px; border: 1px solid rgba(255,255,255,0.1); }
        
        .question-box { background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.1); padding: 40px; border-radius: 24px; box-shadow: 0 10px 40px rgba(0,0,0,0.5); max-width: 800px; width: 100%; margin-bottom: 40px; margin-top: 60px; }
        .question-text { font-size: 2rem; font-weight: 800; color: #f8fafc; line-height: 1.4; text-shadow: 0 2px 4px rgba(0,0,0,0.5); }

        .options-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; max-width: 800px; width: 100%; }
        .option-btn { background: rgba(30, 41, 59, 0.7); backdrop-filter: blur(10px); border: 2px solid rgba(255,255,255,0.1); border-radius: 16px; padding: 24px; font-size: 1.25rem; font-weight: 700; color: #f1f5f9; cursor: pointer; transition: all 0.2s; text-align: left; position: relative; overflow: hidden; display: flex; align-items: center; gap: 16px; width: 100%; }
        .option-btn:hover { border-color: var(--primary); transform: translateY(-4px); box-shadow: 0 10px 25px rgba(139, 92, 246, 0.3); background: rgba(30, 41, 59, 0.9); }
        .option-btn:active { transform: translateY(0); }
        
        .option-letter { display: flex; align-items: center; justify-content: center; width: 40px; height: 40px; border-radius: 10px; background: rgba(255,255,255,0.1); color: #fff; font-weight: 900; font-size: 1.2rem; flex-shrink: 0; }
        
        /* Kahoot Colors for Options - Modified for Dark Mode */
        .opt-0 .option-letter { background: rgba(239, 68, 68, 0.8); }
        .opt-1 .option-letter { background: rgba(59, 130, 246, 0.8); }
        .opt-2 .option-letter { background: rgba(245, 158, 11, 0.8); }
        .opt-3 .option-letter { background: rgba(16, 185, 129, 0.8); }

        .option-btn.correct { background: rgba(16, 185, 129, 0.3); border-color: var(--success); color: #fff; animation: pop 0.4s ease-out; box-shadow: 0 0 20px rgba(16, 185, 129, 0.4); }
        .option-btn.wrong { background: rgba(239, 68, 68, 0.3); border-color: var(--danger); color: #fff; animation: shake 0.4s ease-in-out; box-shadow: 0 0 20px rgba(239, 68, 68, 0.4); }
        .option-btn.disabled { opacity: 0.5; pointer-events: none; }
        .option-btn.correct.disabled { opacity: 1; } 

        @keyframes pop { 0% { transform: scale(1); } 50% { transform: scale(1.05); } 100% { transform: scale(1); } }
        @keyframes shake { 0%, 100% { transform: translateX(0); } 20%, 60% { transform: translateX(-8px); } 40%, 80% { transform: translateX(8px); } }

        /* RESULT SCREEN */
        .result-box { background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.1); padding: 60px 40px; border-radius: 32px; box-shadow: 0 20px 50px rgba(0,0,0,0.5); max-width: 600px; width: 100%; }
        .trophy-icon { font-size: 5rem; margin-bottom: 20px; animation: bounce 2s infinite; text-shadow: 0 0 20px rgba(245, 158, 11, 0.6); }
        .final-score { font-size: 4rem; font-weight: 900; color: #fff; margin-bottom: 8px; line-height: 1; text-shadow: 0 0 20px rgba(139, 92, 246, 0.8); }
        .score-label { font-size: 1.2rem; color: #cbd5e1; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 32px; }
        
        .stats-row { display: flex; justify-content: center; gap: 40px; margin-bottom: 40px; }
        .stat-col { display: flex; flex-direction: column; align-items: center; }
        .stat-num { font-size: 2rem; font-weight: 900; }
        .stat-num.correct-text { color: var(--success); text-shadow: 0 0 10px rgba(16, 185, 129, 0.5); }
        .stat-num.wrong-text { color: var(--danger); text-shadow: 0 0 10px rgba(239, 68, 68, 0.5); }
        .stat-name { font-size: 0.9rem; color: #94a3b8; font-weight: 700; text-transform: uppercase; margin-top: 4px; }

        .btn-restart { background: rgba(255,255,255,0.05); color: #fff; border: 2px solid rgba(255,255,255,0.2); padding: 16px 32px; font-size: 1.1rem; font-weight: 800; border-radius: 16px; cursor: pointer; transition: 0.2s; backdrop-filter: blur(10px); }
        .btn-restart:hover { background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.5); box-shadow: 0 0 15px rgba(255,255,255,0.2); }

        @keyframes bounce { 0%, 20%, 50%, 80%, 100% { transform: translateY(0); } 40% { transform: translateY(-20px); } 60% { transform: translateY(-10px); } }

        /* NEXT BUTTON */
        #btn-next { display: none; margin-top: 40px; background: var(--primary); color: #fff; border: none; padding: 16px 40px; font-size: 1.2rem; font-weight: 800; border-radius: 16px; cursor: pointer; transition: 0.2s; box-shadow: 0 8px 20px rgba(139, 92, 246, 0.4); }
        #btn-next:hover { background: var(--primary-hover); transform: translateY(-2px); box-shadow: 0 12px 25px rgba(139, 92, 246, 0.6); }

        /* Feedback Overlay */
        #feedback-overlay { position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; display: flex; align-items: center; justify-content: center; z-index: 100; pointer-events: none; opacity: 0; transition: opacity 0.3s; }
        .feedback-text { font-size: 6rem; font-weight: 900; color: #fff; text-shadow: 0 0 40px rgba(0,0,0,0.8); transform: scale(0.5); transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
        #feedback-overlay.show { opacity: 1; }
        #feedback-overlay.show .feedback-text { transform: scale(1) rotate(-5deg); }
    </style>
</head>
<body>

    <!-- Background -->
    <div class="bg-shapes">
        <div class="bg-shape shape-1"></div>
        <div class="bg-shape shape-2"></div>
        <div class="bg-shape shape-3"></div>
    </div>

    <!-- Screen 1: Start -->
    <div id="screen-start" class="screen active">
        <button onclick="window.history.back()" style="position:absolute; top:24px; left:24px; background:rgba(255,255,255,0.05); color:#fff; border:1px solid rgba(255,255,255,0.2); padding:10px 20px; border-radius:12px; cursor:pointer; font-weight:800; font-size:1rem; backdrop-filter:blur(10px); transition:all 0.2s; box-shadow:0 4px 12px rgba(0,0,0,0.2);" onmouseover="this.style.background='rgba(255,255,255,0.1)'" onmouseout="this.style.background='rgba(255,255,255,0.05)'">
            &larr; Keluar
        </button>
        <div class="game-title">{{ htmlspecialchars($title) }}</div>
        <div class="game-desc">{{ htmlspecialchars($desc) }}</div>
        <button class="btn-play" onclick="startGame()">Mulai Kuis</button>
    </div>

    <!-- Screen 2: Play -->
    <div id="screen-play" class="screen">
        <div class="top-bar">
            <div style="display:flex; align-items:center; gap:16px;">
                <button onclick="window.history.back()" style="background:rgba(239,68,68,0.15); color:#ef4444; border:1px solid rgba(239,68,68,0.3); padding:8px 16px; border-radius:99px; cursor:pointer; font-weight:800; font-size:1rem; backdrop-filter:blur(10px); transition:all 0.2s;" onmouseover="this.style.background='rgba(239,68,68,0.25)'" onmouseout="this.style.background='rgba(239,68,68,0.15)'">
                    &#10005; Keluar
                </button>
                <div class="question-counter"><span id="q-current">1</span> / <span id="q-total">10</span></div>
            </div>
            <div class="score-display">⭐ <span id="score-val">0</span></div>
        </div>
        
        <div class="question-box">
            <div class="question-text" id="question-text">Loading...</div>
        </div>

        <div class="options-grid" id="options-grid">
            <!-- Options injected by JS -->
        </div>

        <button id="btn-next" onclick="nextQuestion()">Selanjutnya &rarr;</button>
    </div>

    <!-- Screen 3: Result -->
    <div id="screen-result" class="screen">
        <div class="result-box">
            <div class="trophy-icon">🏆</div>
            <div class="final-score" id="final-score-val">0</div>
            <div class="score-label">Total Skor Akhir</div>
            
            <div class="stats-row">
                <div class="stat-col">
                    <div class="stat-num correct-text" id="final-correct">0</div>
                    <div class="stat-name">Benar</div>
                </div>
                <div class="stat-col">
                    <div class="stat-num wrong-text" id="final-wrong">0</div>
                    <div class="stat-name">Salah</div>
                </div>
            </div>

            <button class="btn-restart" onclick="location.reload()">Main Lagi</button>
            <button class="btn-restart" style="background:#0f172a; color:#fff; border:none; margin-left:12px;" onclick="window.history.back()">Kembali</button>
        </div>
    </div>

    <!-- Feedback Overlay -->
    <div id="feedback-overlay">
        <div class="feedback-text" id="feedback-text">BENAR!</div>
    </div>

    <!-- Audio Effects -->
    <script>
        // Simple synth for sound effects without needing audio files
        const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
        
        function playTone(freq, type, duration, vol=0.1) {
            if(audioCtx.state === 'suspended') audioCtx.resume();
            const osc = audioCtx.createOscillator();
            const gain = audioCtx.createGain();
            osc.type = type;
            osc.frequency.setValueAtTime(freq, audioCtx.currentTime);
            
            gain.gain.setValueAtTime(vol, audioCtx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + duration);
            
            osc.connect(gain);
            gain.connect(audioCtx.destination);
            osc.start();
            osc.stop(audioCtx.currentTime + duration);
        }

        function playCorrectSound() {
            playTone(523.25, 'sine', 0.1, 0.2); // C5
            setTimeout(() => playTone(659.25, 'sine', 0.2, 0.2), 100); // E5
            setTimeout(() => playTone(783.99, 'sine', 0.4, 0.2), 200); // G5
        }

        function playWrongSound() {
            playTone(300, 'sawtooth', 0.3, 0.1);
            setTimeout(() => playTone(250, 'sawtooth', 0.4, 0.1), 150);
        }
        
        function playWinSound() {
            playTone(523.25, 'triangle', 0.1, 0.2);
            setTimeout(() => playTone(659.25, 'triangle', 0.1, 0.2), 150);
            setTimeout(() => playTone(783.99, 'triangle', 0.1, 0.2), 300);
            setTimeout(() => playTone(1046.50, 'triangle', 0.6, 0.2), 450);
        }
    </script>

    <!-- Game Logic -->
    <script>
        const questions = {!! $jsonQuestions !!};
        
        let currentQuestionIndex = 0;
        let score = 0;
        let correctAnswersCount = 0;
        let wrongAnswersCount = 0;
        let answered = false;

        const letters = ['A', 'B', 'C', 'D'];

        function startGame() {
            if(audioCtx.state === 'suspended') audioCtx.resume();
            document.getElementById('screen-start').classList.remove('active');
            document.getElementById('screen-play').classList.add('active');
            document.getElementById('q-total').innerText = questions.length;
            loadQuestion();
        }

        function loadQuestion() {
            answered = false;
            document.getElementById('btn-next').style.display = 'none';
            document.getElementById('q-current').innerText = currentQuestionIndex + 1;
            
            const q = questions[currentQuestionIndex];
            document.getElementById('question-text').innerText = q.soal;
            
            const grid = document.getElementById('options-grid');
            grid.innerHTML = '';
            
            q.opsi.forEach((opt, index) => {
                const btn = document.createElement('button');
                btn.className = `option-btn opt-${index}`;
                btn.innerHTML = `
                    <div class="option-letter">${letters[index]}</div>
                    <div class="option-text">${opt}</div>
                `;
                btn.onclick = () => selectOption(btn, opt, q.jawaban_benar);
                grid.appendChild(btn);
            });
        }

        function selectOption(btn, selectedOpt, correctOpt) {
            if (answered) return;
            answered = true;

            const buttons = document.querySelectorAll('.option-btn');
            const isCorrect = selectedOpt === correctOpt;

            buttons.forEach(b => {
                b.classList.add('disabled');
                const optText = b.querySelector('.option-text').innerText;
                if (optText === correctOpt) {
                    b.classList.add('correct');
                }
            });

            const overlay = document.getElementById('feedback-overlay');
            const overlayText = document.getElementById('feedback-text');

            if (isCorrect) {
                btn.classList.add('correct');
                btn.classList.remove('disabled');
                correctAnswersCount++;
                score = Math.round((correctAnswersCount / questions.length) * 100);
                document.getElementById('score-val').innerText = score;
                playCorrectSound();
                
                overlayText.innerText = "BENAR!";
                overlayText.style.color = "#10b981";
            } else {
                btn.classList.add('wrong');
                btn.classList.remove('disabled');
                wrongAnswersCount++;
                playWrongSound();
                
                overlayText.innerText = "SALAH!";
                overlayText.style.color = "#ef4444";
            }

            overlay.classList.add('show');
            setTimeout(() => {
                overlay.classList.remove('show');
                nextQuestion(); // Otomatis lanjut ke soal berikutnya
            }, 1500);
        }

        function nextQuestion() {
            currentQuestionIndex++;
            if (currentQuestionIndex < questions.length) {
                loadQuestion();
            } else {
                showResult();
            }
        }

        function showResult() {
            document.getElementById('screen-play').classList.remove('active');
            document.getElementById('screen-result').classList.add('active');
            
            document.getElementById('final-score-val').innerText = score;
            document.getElementById('final-correct').innerText = correctAnswersCount;
            document.getElementById('final-wrong').innerText = wrongAnswersCount;
            
            playWinSound();
            confettiEffect();

            // Save score to backend
            const gameId = new URLSearchParams(window.location.search).get('file') || 'Game';
            fetch('{{ route('member.mengajar.gamifikasi.save-score') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    score: score,
                    game_id: gameId
                })
            })
            .then(res => res.json())
            .then(data => {
                if(data.success && data.earned_points > 0) {
                    const alertDiv = document.createElement('div');
                    alertDiv.style.position = 'fixed';
                    alertDiv.style.bottom = '40px';
                    alertDiv.style.left = '50%';
                    alertDiv.style.transform = 'translateX(-50%)';
                    alertDiv.style.background = '#10b981';
                    alertDiv.style.color = '#fff';
                    alertDiv.style.padding = '12px 24px';
                    alertDiv.style.borderRadius = '99px';
                    alertDiv.style.fontWeight = '800';
                    alertDiv.style.boxShadow = '0 10px 25px rgba(16, 185, 129, 0.4)';
                    alertDiv.style.zIndex = '9999';
                    alertDiv.innerHTML = `🌟 Kamu mendapatkan +${data.earned_points} Poin Gamifikasi!`;
                    document.body.appendChild(alertDiv);
                    
                    setTimeout(() => { alertDiv.remove(); }, 5000);
                }
            })
            .catch(err => console.error('Error saving score:', err));
        }

        function confettiEffect() {
            const colors = ['#4f46e5', '#ec4899', '#10b981', '#f59e0b', '#3b82f6'];
            for(let i=0; i<100; i++) {
                const conf = document.createElement('div');
                conf.style.position = 'fixed';
                conf.style.width = '10px';
                conf.style.height = '10px';
                conf.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                conf.style.top = '-10px';
                conf.style.left = Math.random() * 100 + 'vw';
                conf.style.zIndex = '999';
                conf.style.borderRadius = Math.random() > 0.5 ? '50%' : '0';
                conf.style.transform = `rotate(${Math.random() * 360}deg)`;
                document.body.appendChild(conf);

                const duration = Math.random() * 2 + 1;
                conf.animate([
                    { transform: `translate(0, 0) rotate(0deg)`, opacity: 1 },
                    { transform: `translate(${Math.random()*200 - 100}px, 100vh) rotate(${Math.random()*720}deg)`, opacity: 0 }
                ], {
                    duration: duration * 1000,
                    easing: 'cubic-bezier(.37,0,.63,1)',
                    fill: 'forwards'
                });

                setTimeout(() => conf.remove(), duration * 1000);
            }
        }
    </script>
</body>
</html>
