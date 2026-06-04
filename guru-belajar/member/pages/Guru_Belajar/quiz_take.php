<div class="page" id="page-quiz-take" style="background:var(--c-bg); min-height:100vh; padding-top:0 !important;">
    <!-- Top Bar -->
    <div style="background:#5b6cf9; padding:16px 24px; display:flex; justify-content:space-between; align-items:center; color:#fff;">
        <div style="display:flex; align-items:center; gap:16px;">
            <button onclick="qtConfirmExit()" style="background:none; border:none; color:#fff; cursor:pointer; display:flex; align-items:center; gap:6px; font-weight:600; font-family:inherit; padding:6px; border-radius:6px; transition:background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.1)'" onmouseout="this.style.background='none'">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                Keluar
            </button>
            <div style="font-size:18px; font-weight:800; letter-spacing:1px; text-transform:uppercase; border-left:1px solid rgba(255,255,255,0.3); padding-left:16px;">SOAL UJIAN</div>
        </div>
        <div style="font-size:14px; font-weight:600; display:flex; align-items:center; gap:8px;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            <span id="qtTimer">0 Jam 45 Menit 00 Detik</span>
        </div>
    </div>

    <!-- Main Container -->
    <div style="max-width:1200px; margin:0 auto; padding:24px; display:flex; flex-wrap:wrap; gap:24px; align-items:flex-start;">
        
        <!-- Left Panel: Question -->
        <div style="flex:1; min-width:300px; background:var(--c-card); border-radius:12px; box-shadow:0 4px 16px rgba(0,0,0,0.05); padding:24px; border:1px solid var(--c-border);">
            
            <div style="display:flex; align-items:center; gap:12px; margin-bottom:20px; border-bottom:1px solid var(--c-border); padding-bottom:12px;">
                <span style="font-size:14px; font-weight:700; color:#5b6cf9;">SOAL NO</span>
                <div id="qtCurrentNumBadge" style="background:#5b6cf9; color:#fff; width:28px; height:28px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:14px; font-weight:800;">1</div>
            </div>

            <div id="qtQuestionText" style="font-size:15px; color:var(--c-text); line-height:1.6; margin-bottom:24px;">
                <!-- Question content injected via JS -->
                Memuat soal...
            </div>

            <div id="qtOptionsList" style="display:flex; flex-direction:column; gap:16px; margin-bottom:40px;">
                <!-- Options injected via JS -->
            </div>

            <!-- Action Buttons -->
            <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
                <button id="qtBtnPrev" class="btn" style="background:#5b6cf9; color:#fff; border:none; border-radius:6px; padding:10px 20px; font-weight:700; cursor:pointer;" onclick="qtPrev()">Sebelumnya</button>
                
                <label style="background:#fbbf24; color:#fff; border-radius:6px; padding:10px 20px; font-weight:700; cursor:pointer; display:flex; align-items:center; gap:8px;">
                    <input type="checkbox" id="qtCheckDoubtful" onchange="qtToggleDoubtful(this.checked)" style="accent-color:#fff; transform:scale(1.2);">
                    Ragu-Ragu
                </label>
                
                <button id="qtBtnNext" class="btn" style="background:#5b6cf9; color:#fff; border:none; border-radius:6px; padding:10px 20px; font-weight:700; cursor:pointer;" onclick="qtNext()">Selanjutnya</button>
            </div>
        </div>

        <!-- Right Panel: Navigation Grid -->
        <div style="width:300px; flex-shrink:0; background:var(--c-card); border-radius:12px; box-shadow:0 4px 16px rgba(0,0,0,0.05); padding:24px; border:1px solid var(--c-border);">
            
            <h3 style="font-size:14px; font-weight:700; color:#5b6cf9; margin-bottom:16px;">Navigasi Soal</h3>
            
            <div id="qtNavGrid" style="display:grid; grid-template-columns:repeat(4, 1fr); gap:12px; margin-bottom:24px;">
                <!-- Grid items injected via JS -->
            </div>

            <!-- Legend -->
            <div style="display:flex; flex-direction:column; gap:8px;">
                <div style="display:flex; align-items:center; gap:8px;">
                    <div style="width:16px; height:16px; background:#4ade80; border-radius:4px;"></div>
                    <span style="font-size:12px; font-weight:700; color:#4ade80;">Telah dijawab</span>
                </div>
                <div style="display:flex; align-items:center; gap:8px;">
                    <div style="width:16px; height:16px; background:#e2e8f0; border-radius:4px; border:1px solid #cbd5e1;"></div>
                    <span style="font-size:12px; font-weight:700; color:var(--c-text-muted);">Belum Dijawab</span>
                </div>
                <div style="display:flex; align-items:center; gap:8px;">
                    <div style="width:16px; height:16px; background:#fbbf24; border-radius:4px;"></div>
                    <span style="font-size:12px; font-weight:700; color:#fbbf24;">Ragu-Ragu</span>
                </div>
            </div>
            
            <hr style="border:none; border-top:1px solid var(--c-border); margin:20px 0;">
            <button class="btn btn-error" style="width:100%; font-weight:700;" onclick="qtConfirmSubmit()">Akhiri Ujian</button>

        </div>
    </div>
</div>

<style>
.qt-nav-btn {
    aspect-ratio: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    font-weight: 700;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
    color: #475569;
    background: #e2e8f0;
}
.qt-nav-btn:hover {
    filter: brightness(0.95);
}
.qt-nav-btn.answered {
    background: #4ade80;
    color: #fff;
}
.qt-nav-btn.doubtful {
    background: #fbbf24;
    color: #fff;
}
.qt-nav-btn.active-q {
    box-shadow: 0 0 0 2px #fff, 0 0 0 4px #5b6cf9;
}
.qt-opt-label {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    border: 1px solid var(--c-border);
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s;
}
.qt-opt-label:hover {
    background: rgba(91, 108, 249, 0.05);
}
.qt-opt-label.selected {
    border-color: #5b6cf9;
    background: rgba(91, 108, 249, 0.08);
}
.qt-opt-radio {
    accent-color: #5b6cf9;
    transform: scale(1.2);
}
</style>
