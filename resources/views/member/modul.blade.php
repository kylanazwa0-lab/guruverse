@extends('layouts.member')

@section('title', ucwords(str_replace('_', ' ', 'modul')))

@section('content')

<div class="page active" id="page-modul">

<!-- ═══════════════════════════════════════════════════════════
     EMPTY STATE
═══════════════════════════════════════════════════════════ -->
<div id="coursePlayerEmpty" class="gvcp-empty">
  <div class="gvcp-empty-icon">
    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
  </div>
  <h2 class="gvcp-empty-title">Pemutar Modul Belajar</h2>
  <p class="gvcp-empty-desc">Pilih kelas dari menu <strong>Kelas Saya</strong> atau <strong>Dashboard</strong> untuk mulai belajar.</p>
  <div class="gvcp-empty-btns">
    <button class="btn btn-primary" onclick="window.location.href='/kelas'">Ke Kelas Saya</button>
    <button class="btn btn-outline" onclick="window.location.href='/dashboard'">Dashboard</button>
  </div>
</div>

<!-- ═══════════════════════════════════════════════════════════
     COURSE PLAYER
═══════════════════════════════════════════════════════════ -->
<div id="coursePlayerContent" style="display:none; width:100%; min-width:0; box-sizing:border-box;">

  <!-- COURSE BANNER -->
  <div class="gvcp-banner" id="gvcpBanner">
    <div class="gvcp-banner-body">
      <button class="gvcp-back" onclick="window.location.href='/kelas'">
        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
        Kembali ke Kelas
      </button>
      <h1 id="cpCourseTitle" class="gvcp-banner-title">Memuat...</h1>
      <div class="gvcp-banner-meta">
        <span id="cpCourseMentor" class="gvcp-meta-chip">
          <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
          Mentor: —
        </span>
        <span id="cpCourseDuration" class="gvcp-meta-chip">
          <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
          — Jam
        </span>
        <span id="cpCourseTotalModules" class="gvcp-meta-chip">
          <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/></svg>
          — Modul
        </span>
        <span id="cpStatusBadge" class="gvcp-status-badge">Sedang Dipelajari</span>
      </div>
      <!-- Progress inline di banner -->
      <div class="gvcp-banner-prog">
        <div class="gvcp-banner-prog-bar"><div id="gvcpBannerBar" style="width:0%"></div></div>
        <span id="gvcpBannerPct">0%</span>
      </div>
    </div>
  </div>

  <!-- MAIN GRID -->
  <div class="gvcp-grid">

    <!-- ─── LEFT: Daftar Modul + Widget ─────────────────────── -->
    <aside class="gvcp-aside">

      <!-- Module List -->
      <div class="gvcp-card gvcp-modlist-card">
        <div class="gvcp-card-hd">
          <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/></svg>
          Daftar Modul
        </div>
        <div id="cpModuleList" class="gvcp-modlist"></div>
      </div>

      <!-- Progress Card -->
      <div class="gvcp-card gvcp-prog-card">
        <div class="gvcp-prog-top">
          <div>
            <div class="gvcp-prog-label">Progress Belajar</div>
            <div id="cpCourseModText" class="gvcp-prog-subtext">Selesai 0 dari 0 modul</div>
          </div>
          <div id="cpCoursePct" class="gvcp-prog-pct">0%</div>
        </div>
        <div class="gvcp-prog-track">
          <div id="cpCourseBar" class="gvcp-prog-fill" style="width:0%"></div>
        </div>
      </div>

      <!-- Promo -->
      <div class="gvcp-card gvcp-promo-card">
        <div class="gvcp-promo-deco"></div>
        <div class="gvcp-promo-body">
          <div class="gvcp-promo-title">🎁 Ajak Rekan Guru</div>
          <p class="gvcp-promo-desc">Dapatkan benefit menarik setiap kali referral Anda berhasil bergabung!</p>
          <button class="gvcp-promo-btn">Ajak Sekarang</button>
        </div>
      </div>

      <!-- Help -->
      <div class="gvcp-card gvcp-help-card">
        <div class="gvcp-help-icon">💬</div>
        <div class="gvcp-help-title">Butuh Bantuan?</div>
        <p class="gvcp-help-desc">Tanyakan ke forum diskusi atau hubungi mentor secara langsung.</p>
        <button class="btn btn-outline btn-sm" style="width:100%;" onclick="window.location.href='/diskusi'">Forum Diskusi</button>
      </div>

    </aside>

    <!-- ─── RIGHT: Video + Materi + Resources ───────────────── -->
    <div class="gvcp-main" style="min-width:0;">

      <!-- Complete Banner -->
      <div id="cpCourseCompleteBanner" class="gvcp-complete" style="display:none;">
        <div style="font-size:52px;margin-bottom:12px;">🎓</div>
        <h2 class="gvcp-complete-title">Selamat! Kelas Selesai!</h2>
        <p class="gvcp-complete-desc">Sertifikat resmi Anda telah diterbitkan. Unduh sebagai bukti kompetensi profesional.</p>
        <button class="btn" style="background:#fff;color:#059669;font-weight:800;font-size:13px;padding:10px 28px;border-radius:10px;border:none;cursor:pointer;" onclick="window.location.href='/sertifikat'">Lihat Sertifikat &rarr;</button>
      </div>

      <!-- Video Panel -->
      <div class="gvcp-card gvcp-video-panel">
        <!-- Module Title inside video panel -->
        <div class="gvcp-mod-info">
          <div class="gvcp-mod-badge" id="gvcpModBadge">Modul 1</div>
          <h2 id="cpModTitle" class="gvcp-mod-title">Memuat...</h2>
          <div id="cpModSubtitle" class="gvcp-mod-sub">Sesi — dari —</div>
        </div>

        <!-- Video -->
        <div class="gvcp-video-wrap" id="gvcpVideoWrap">
          <iframe id="cpModIframe" src="" title="Video Pembelajaran"
            frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            allowfullscreen style="width:100%;height:100%;border:none;display:block;"></iframe>
        </div>
        <!-- No-video placeholder -->
        <div class="gvcp-no-video" id="gvcpNoVideo" style="display:none;">
          <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.3)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg>
          <p style="color:rgba(255,255,255,0.4);font-size:13px;margin-top:12px;">Tidak ada video untuk modul ini</p>
        </div>

        <!-- Ringkasan Materi -->
        <div class="gvcp-materi">
          <div class="gvcp-materi-hd">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            Ringkasan Materi
          </div>
          <div id="cpModDesc" class="gvcp-materi-body">
            <p style="color:var(--c-text-muted);">Materi belum tersedia.</p>
          </div>
        </div>

        <!-- Navigation -->
        <div class="gvcp-nav">
          <button class="btn btn-outline gvcp-nav-btn" id="cpBtnPrev" onclick="cpNavMod(-1)">
            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
            Sebelumnya
          </button>
          <div id="gvcpNavDots" class="gvcp-nav-dots"></div>
          <button class="btn btn-primary gvcp-nav-btn" id="cpBtnNext" onclick="cpNavMod(1)">
            Selanjutnya
            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
          </button>
        </div>
      </div>

      <!-- Resources Row: Quiz + Diskusi + Catatan -->
      <div class="gvcp-resources">

        <!-- QUIZ -->
        <div class="gvcp-card gvcp-res-card gvcp-quiz-card">
          <div class="gvcp-res-icon-wrap" style="background:linear-gradient(135deg,var(--c-primary),var(--c-primary-light));">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
          </div>
          <div class="gvcp-res-body">
            <h3 class="gvcp-res-title" id="cpQuizTitle">Quiz Modul <span id="cpQuizModName"></span></h3>
            <p class="gvcp-res-sub">Kerjakan quiz untuk lanjut ke modul berikutnya</p>
          </div>
          <div class="gvcp-quiz-soal">
            <span id="gvcpQuizCount" style="font-size:20px;font-weight:900;color:var(--c-primary);line-height:1;">5</span>
            <span style="font-size:9px;color:var(--c-text-muted);font-weight:700;">Soal</span>
          </div>
          <button id="cpQuizBtn" class="btn btn-primary btn-sm gvcp-quiz-btn" onclick="startCpQuiz()">Kerjakan Quiz</button>
        </div>

        <!-- DISKUSI -->
        <div class="gvcp-card gvcp-res-card">
          <div class="gvcp-res-icon-wrap" style="background:linear-gradient(135deg,#3b82f6,#60a5fa);">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
          </div>
          <div class="gvcp-res-body">
            <h3 class="gvcp-res-title">Diskusi Modul</h3>
            <p class="gvcp-res-sub">Tanyakan & diskusikan materi bersama peserta lain</p>
          </div>
          <!-- Sample diskusi item -->
          <div class="gvcp-diskusi-item">
            <div class="gvcp-diskusi-av">B</div>
            <div class="gvcp-diskusi-content">
              <div class="gvcp-diskusi-meta">
                <span class="gvcp-diskusi-name">Budi Santoso</span>
                <span class="gvcp-diskusi-tag">Pertanyaan</span>
              </div>
              <div class="gvcp-diskusi-time">2 jam yang lalu</div>
              <p class="gvcp-diskusi-text">Bagaimana cara mengatasi siswa yang pasif dalam diskusi kelompok?</p>
            </div>
          </div>
          <a href="/diskusi" class="gvcp-link">
            Lihat Diskusi Lainnya
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
          </a>
        </div>

        <!-- CATATAN -->
        <div class="gvcp-card gvcp-res-card">
          <div class="gvcp-res-icon-wrap" style="background:linear-gradient(135deg,#10b981,#34d399);">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
          </div>
          <div class="gvcp-res-body">
            <h3 class="gvcp-res-title">Catatan Saya</h3>
            <p class="gvcp-res-sub">Simpan poin penting dari materi ini</p>
          </div>
          <textarea id="cpNotesInput" class="gvcp-notes-ta" placeholder="Tulis catatan pribadi...&#10;&#10;💡 Tip: Catatan tersimpan otomatis di browser."></textarea>
          <button class="btn btn-outline btn-sm" style="width:100%;font-weight:700;" onclick="cpSaveNotes()">
            Simpan Catatan
          </button>
        </div>

      </div><!-- /gvcp-resources -->

    </div><!-- /gvcp-main -->
  </div><!-- /gvcp-grid -->
</div><!-- /coursePlayerContent -->

</div><!-- /page-modul -->

<!-- ═══════════════════════════════════════════════════════════
     STYLES
═══════════════════════════════════════════════════════════ -->
<style>
/* ── Reset & Container ─────────────────────────────────────── */
#page-modul {
  width: 100%;
  min-width: 0;
  box-sizing: border-box;
}
#coursePlayerContent,
#page-modul .gvcp-grid,
#page-modul .gvcp-main,
  #page-modul .gvcp-aside {
    min-width: 0;
    box-sizing: border-box;
  }
  
  #page-modul .gvcp-main {
    display: flex;
    flex-direction: column;
    gap: 24px;
  }

/* ── Empty State ───────────────────────────────────────────── */
.gvcp-empty {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  min-height: 72vh;
  text-align: center;
  padding: 40px 24px;
}
.gvcp-empty-icon {
  width: 88px; height: 88px;
  border-radius: 28px;
  background: var(--c-primary-pale);
  color: var(--c-primary);
  display: flex; align-items: center; justify-content: center;
  margin-bottom: 24px;
  box-shadow: 0 12px 32px rgba(108,92,231,0.14);
}
.gvcp-empty-title { font-size: 24px; font-weight: 800; color: var(--c-text); margin-bottom: 10px; }
.gvcp-empty-desc  { font-size: 14px; color: var(--c-text-muted); margin-bottom: 28px; max-width: 380px; line-height: 1.65; }
.gvcp-empty-btns  { display: flex; gap: 12px; flex-wrap: wrap; justify-content: center; }

/* ── Course Banner ─────────────────────────────────────────── */
.gvcp-banner {
  background: linear-gradient(120deg, #1e1b4b 0%, #312e81 50%, #4c1d95 100%);
  border-radius: 20px;
  padding: 28px 32px 22px;
  margin-bottom: 24px;
  position: relative;
  overflow: hidden;
  box-shadow: 0 8px 32px rgba(49,46,129,0.25);
}
.gvcp-banner::before {
  content: '';
  position: absolute; top: -60px; right: -40px;
  width: 280px; height: 280px;
  background: radial-gradient(circle, rgba(167,139,250,0.18) 0%, transparent 70%);
  border-radius: 50%; pointer-events: none;
}
.gvcp-back {
  display: inline-flex; align-items: center; gap: 5px;
  background: rgba(255,255,255,0.1);
  border: 1px solid rgba(255,255,255,0.15);
  color: rgba(255,255,255,0.75);
  font-size: 11px; font-weight: 700;
  padding: 5px 12px; border-radius: 20px; cursor: pointer;
  font-family: inherit;
  margin-bottom: 14px;
  transition: all .2s;
}
.gvcp-back:hover { background: rgba(255,255,255,0.18); color: #fff; }
.gvcp-banner-title {
  font-size: 26px; font-weight: 900;
  color: #fff;
  margin: 0 0 12px;
  line-height: 1.25;
  word-break: break-word;
}
.gvcp-banner-meta {
  display: flex; flex-wrap: wrap; gap: 8px;
  margin-bottom: 16px;
}
.gvcp-meta-chip {
  display: inline-flex; align-items: center; gap: 5px;
  background: rgba(255,255,255,0.1);
  border: 1px solid rgba(255,255,255,0.12);
  color: rgba(255,255,255,0.82);
  font-size: 12px; font-weight: 600;
  padding: 4px 12px; border-radius: 20px;
}
.gvcp-status-badge {
  display: inline-flex; align-items: center; gap: 5px;
  background: rgba(167,139,250,0.25);
  border: 1px solid rgba(167,139,250,0.4);
  color: #c4b5fd;
  font-size: 11px; font-weight: 700;
  padding: 4px 12px; border-radius: 20px;
}
.gvcp-status-badge::before {
  content: ''; width: 6px; height: 6px;
  background: #a78bfa; border-radius: 50%;
  animation: gvcpPulse 2s ease-in-out infinite;
}
@keyframes gvcpPulse {
  0%,100% { opacity: 1; transform: scale(1); }
  50%      { opacity: .5; transform: scale(.7); }
}
/* Banner progress bar */
.gvcp-banner-prog {
  display: flex; align-items: center; gap: 12px;
}
.gvcp-banner-prog-bar {
  flex: 1; height: 5px;
  background: rgba(255,255,255,0.15);
  border-radius: 99px; overflow: hidden;
}
.gvcp-banner-prog-bar > div {
  height: 100%;
  background: linear-gradient(90deg, #a78bfa, #7c3aed);
  border-radius: 99px;
  transition: width .5s cubic-bezier(.4,0,.2,1);
}
.gvcp-banner-prog > span {
  font-size: 13px; font-weight: 800; color: #a78bfa; flex-shrink: 0;
}

/* ── Grid ──────────────────────────────────────────────────── */
.gvcp-grid {
  display: grid;
  grid-template-columns: 256px 1fr;
  gap: 20px;
  align-items: start;
  width: 100%;
}

/* ── Aside ─────────────────────────────────────────────────── */
.gvcp-aside {
  display: flex; flex-direction: column; gap: 14px;
  position: sticky;
  top: calc(var(--topbar-h, 64px) + 20px);
}

/* ── Card Base ─────────────────────────────────────────────── */
.gvcp-card {
  background: var(--c-card);
  border: 1px solid var(--c-border);
  border-radius: 16px;
  padding: 18px;
  box-shadow: var(--shadow-card);
  min-width: 0;
  box-sizing: border-box;
}

/* ── Module List Card ──────────────────────────────────────── */
.gvcp-card-hd {
  display: flex; align-items: center; gap: 7px;
  font-size: 13px; font-weight: 800; color: var(--c-text);
  margin-bottom: 14px;
  padding-bottom: 12px;
  border-bottom: 1px solid var(--c-border);
}
.gvcp-card-hd svg { color: var(--c-primary); flex-shrink: 0; }
.gvcp-modlist { display: flex; flex-direction: column; gap: 4px; }

/* Module item */
.gvcp-mod-item {
  display: flex; align-items: center; gap: 10px;
  padding: 10px 10px;
  border-radius: 10px;
  cursor: pointer;
  transition: all .18s;
  position: relative;
}
.gvcp-mod-item:hover:not(.gvcp-mod-locked) { background: var(--c-primary-pale); }
.gvcp-mod-item.gvcp-mod-active {
  background: var(--c-primary-pale);
  border-left: 3px solid var(--c-primary);
}
.gvcp-mod-item.gvcp-mod-locked { opacity: .5; cursor: not-allowed; }

.gvcp-mod-num {
  width: 28px; height: 28px; border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  font-size: 11px; font-weight: 800; flex-shrink: 0;
}
.gvcp-mod-num-done   { background: var(--c-success-pale); color: var(--c-success); }
.gvcp-mod-num-active { background: var(--c-primary); color: #fff; box-shadow: 0 4px 12px rgba(108,92,231,.35); }
.gvcp-mod-num-idle   { background: var(--c-border); color: var(--c-text-muted); }
.gvcp-mod-num-locked { background: var(--c-border); color: var(--c-text-muted); }

.gvcp-mod-info-wrap { flex: 1; min-width: 0; }
.gvcp-mod-name {
  font-size: 12px; font-weight: 700;
  white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.gvcp-mod-name.active { color: var(--c-primary); }
.gvcp-mod-name.idle   { color: var(--c-text); }
.gvcp-mod-dur { font-size: 10px; color: var(--c-text-muted); margin-top: 2px; }

.gvcp-mod-status { font-size: 14px; flex-shrink: 0; }

/* ── Progress Card ─────────────────────────────────────────── */
.gvcp-prog-card { padding: 18px 18px 16px; }
.gvcp-prog-top  { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px; }
.gvcp-prog-label { font-size: 11px; font-weight: 700; color: var(--c-text-muted); text-transform: uppercase; letter-spacing: .5px; }
.gvcp-prog-subtext { font-size: 11px; color: var(--c-text-muted); margin-top: 4px; }
.gvcp-prog-pct { font-size: 28px; font-weight: 900; color: var(--c-primary); line-height: 1; }
.gvcp-prog-track { height: 6px; background: var(--c-border-light); border-radius: 99px; overflow: hidden; }
.gvcp-prog-fill  { height: 100%; background: linear-gradient(90deg, var(--c-primary), var(--c-primary-light)); border-radius: 99px; transition: width .5s cubic-bezier(.4,0,.2,1); }

/* ── Promo Card ────────────────────────────────────────────── */
.gvcp-promo-card {
  background: linear-gradient(135deg, #6c5ce7, #a78bfa);
  border: none; position: relative; overflow: hidden; padding: 20px;
}
.gvcp-promo-deco {
  position: absolute; top: -30px; right: -30px;
  width: 110px; height: 110px;
  background: rgba(255,255,255,0.1);
  border-radius: 50%;
}
.gvcp-promo-deco::after {
  content: ''; position: absolute;
  width: 70px; height: 70px;
  background: rgba(255,255,255,0.08);
  border-radius: 50%;
  top: 30px; left: 30px;
}
.gvcp-promo-body { position: relative; z-index: 1; }
.gvcp-promo-title { font-size: 13px; font-weight: 800; color: #fff; margin-bottom: 6px; }
.gvcp-promo-desc  { font-size: 11px; color: rgba(255,255,255,.85); margin-bottom: 14px; line-height: 1.5; }
.gvcp-promo-btn   {
  width: 100%; background: rgba(255,255,255,0.2);
  border: 1px solid rgba(255,255,255,0.3);
  color: #fff; font-weight: 700; font-size: 12px;
  padding: 8px; border-radius: 10px; cursor: pointer;
  font-family: inherit; transition: all .2s;
}
.gvcp-promo-btn:hover { background: rgba(255,255,255,0.3); }

/* ── Help Card ─────────────────────────────────────────────── */
.gvcp-help-card { text-align: center; padding: 20px 18px; }
.gvcp-help-icon  { font-size: 28px; margin-bottom: 8px; }
.gvcp-help-title { font-size: 13px; font-weight: 800; color: var(--c-text); margin-bottom: 6px; }
.gvcp-help-desc  { font-size: 11px; color: var(--c-text-muted); margin-bottom: 14px; line-height: 1.5; }

/* ── Video Panel ───────────────────────────────────────────── */
.gvcp-video-panel { padding: 0; overflow: hidden; }
.gvcp-mod-info { padding: 24px 28px 20px; }
.gvcp-mod-badge {
  display: inline-flex; align-items: center;
  font-size: 11px; font-weight: 800;
  color: var(--c-primary);
  background: var(--c-primary-pale);
  padding: 3px 10px; border-radius: 20px;
  margin-bottom: 8px;
}
.gvcp-mod-title {
  font-size: 22px; font-weight: 800;
  color: var(--c-text);
  line-height: 1.3;
  margin: 0 0 6px;
  word-break: break-word;
}
.gvcp-mod-sub { font-size: 12px; color: var(--c-text-muted); font-weight: 600; }

/* Video wrapper */
.gvcp-video-wrap {
  position: relative;
  width: 100%;
  padding-bottom: 56.25%; /* 16:9 */
  background: #020617;
  overflow: hidden;
}
.gvcp-video-wrap iframe {
  position: absolute; top: 0; left: 0;
  width: 100% !important; height: 100% !important;
}
.gvcp-no-video {
  position: absolute; inset: 0;
  display: flex; flex-direction: column;
  align-items: center; justify-content: center;
  background: linear-gradient(135deg, #0f172a, #020617);
}

/* Materi */
.gvcp-materi { padding: 24px 28px; border-top: 1px solid var(--c-border); }
.gvcp-materi-hd {
  display: flex; align-items: center; gap: 7px;
  font-size: 14px; font-weight: 800; color: var(--c-text);
  margin-bottom: 14px;
}
.gvcp-materi-hd svg { color: var(--c-primary); }
.gvcp-materi-body { font-size: 14px; color: var(--c-text-muted); line-height: 1.75; }
.gvcp-materi-body p { margin-bottom: 10px; }

/* Navigation */
.gvcp-nav {
  display: flex; justify-content: space-between; align-items: center;
  padding: 16px 28px 24px;
  border-top: 1px solid var(--c-border);
  gap: 12px;
}
.gvcp-nav-btn { display: inline-flex; align-items: center; gap: 6px; font-size: 13px; font-weight: 700; }
.gvcp-nav-dots { display: flex; gap: 6px; align-items: center; }
.gvcp-nav-dot {
  width: 8px; height: 8px; border-radius: 50%;
  background: var(--c-border);
  transition: all .25s;
  cursor: pointer;
}
.gvcp-nav-dot.active {
  width: 20px; border-radius: 4px;
  background: var(--c-primary);
}

/* ── Resources Row ─────────────────────────────────────────── */
.gvcp-resources {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 24px;
}

/* Resource Card */
.gvcp-res-card {
  display: flex; flex-direction: column; gap: 12px;
}
.gvcp-res-icon-wrap {
  width: 44px; height: 44px; border-radius: 14px;
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
  box-shadow: 0 4px 14px rgba(0,0,0,0.12);
}
.gvcp-res-body { flex: 1; }
.gvcp-res-title { font-size: 14px; font-weight: 800; color: var(--c-text); margin: 0 0 4px; }
.gvcp-res-sub   { font-size: 11px; color: var(--c-text-muted); line-height: 1.4; }

/* Quiz specific */
.gvcp-quiz-card { }
.gvcp-quiz-soal {
  display: flex; flex-direction: column; align-items: center; justify-content: center;
  width: 54px; height: 54px;
  border-radius: 50%;
  border: 3px solid var(--c-primary-pale);
  background: var(--c-primary-pale);
  flex-shrink: 0;
  align-self: flex-end;
}
.gvcp-quiz-btn { width: 100%; margin-top: auto; }

/* Diskusi */
.gvcp-diskusi-item { display: flex; gap: 10px; margin-top: 4px; }
.gvcp-diskusi-av {
  width: 34px; height: 34px; border-radius: 50%;
  background: linear-gradient(135deg, #6c5ce7, #a78bfa);
  color: #fff; display: flex; align-items: center; justify-content: center;
  font-size: 14px; font-weight: 800; flex-shrink: 0;
}
.gvcp-diskusi-content { flex: 1; min-width: 0; }
.gvcp-diskusi-meta   { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2px; flex-wrap: wrap; gap: 4px; }
.gvcp-diskusi-name   { font-size: 12px; font-weight: 800; color: var(--c-text); }
.gvcp-diskusi-tag    { font-size: 9px; color: var(--c-primary); background: var(--c-primary-pale); padding: 2px 7px; border-radius: 4px; font-weight: 700; }
.gvcp-diskusi-time   { font-size: 10px; color: var(--c-text-muted); margin-bottom: 5px; }
.gvcp-diskusi-text   { font-size: 12px; color: var(--c-text-muted); line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.gvcp-link {
  display: inline-flex; align-items: center; gap: 4px;
  font-size: 12px; font-weight: 700; color: var(--c-primary);
  text-decoration: none; margin-top: auto;
  transition: gap .2s;
}
.gvcp-link:hover { gap: 7px; }

/* Notes textarea */
.gvcp-notes-ta {
  width: 100%; min-height: 90px;
  border: 1px solid var(--c-border);
  border-radius: 10px;
  padding: 12px;
  font-size: 12px;
  font-family: inherit;
  resize: vertical;
  background: var(--c-bg);
  color: var(--c-text);
  outline: none;
  box-sizing: border-box;
  transition: border-color .2s, background .2s;
  line-height: 1.55;
  margin-top: auto;
}
.gvcp-notes-ta:focus { border-color: var(--c-primary); background: var(--c-card); }

/* ── Complete Banner ───────────────────────────────────────── */
.gvcp-complete {
  background: linear-gradient(135deg, #10b981, #059669);
  border-radius: 16px; padding: 36px 24px;
  text-align: center; margin-bottom: 20px;
  box-shadow: 0 8px 28px rgba(16,185,129,.22);
}
.gvcp-complete-title { font-size: 20px; font-weight: 800; color: #fff; margin-bottom: 8px; }
.gvcp-complete-desc  { font-size: 13px; color: rgba(255,255,255,.88); margin-bottom: 20px; line-height: 1.6; max-width: 480px; margin-left: auto; margin-right: auto; }

/* ── Responsive ────────────────────────────────────────────── */
@media (max-width: 1280px) {
  .gvcp-grid { grid-template-columns: 230px 1fr; }
}
@media (max-width: 1080px) {
  .gvcp-resources { grid-template-columns: 1fr 1fr; }
}
@media (max-width: 960px) {
  .gvcp-grid { grid-template-columns: 1fr; }
  .gvcp-aside { position: static; flex-direction: row; flex-wrap: wrap; }
  .gvcp-modlist-card { flex: 1; min-width: 240px; }
  .gvcp-prog-card { flex: 1; min-width: 200px; }
}
@media (max-width: 700px) {
  .gvcp-resources { grid-template-columns: 1fr; }
  .gvcp-banner { padding: 20px; }
  .gvcp-banner-title { font-size: 20px; }
  .gvcp-mod-info { padding: 18px 18px 14px; }
  .gvcp-materi  { padding: 18px; }
  .gvcp-nav     { padding: 14px 18px 18px; }
}
</style>

<!-- ═══════════════════════════════════════════════════════════
     JAVASCRIPT
═══════════════════════════════════════════════════════════ -->
<script>
/* ═══════════════════════════════════════════════════════════
   GURUVERSE COURSE PLAYER - FIXED VERSION
   ═══════════════════════════════════════════════════════════
   
   FIXES:
   1. Keyframe defined FIRST sebelum digunakan
   2. Loading state ditangani lebih baik
   3. Error handling yg proper memastikan spinner berhenti
   4. Display visibility logic jelas dan non-ambiguous
*/

/* ═══════════════════════════════════════════════════════════
   SETUP: Define CSS Keyframes IMMEDIATELY
═══════════════════════════════════════════════════════════ */
(function() {
  const s = document.createElement('style');
  s.textContent = '@keyframes gvcpSpin{to{transform:rotate(360deg)}}';
  document.head.appendChild(s);
})();

/* ── State ───────────────────────────────────────────────── */
let cpCurrentCourse  = null;
let cpModules        = [];
let cpCurrentModIdx  = 0;

/* ── Entry Point ─────────────────────────────────────────── */
function initCoursePlayer(course_id) {
  localStorage.setItem('cp_last_course_id', course_id);

  const emptyEl   = document.getElementById('coursePlayerEmpty');
  const contentEl = document.getElementById('coursePlayerContent');
  if (!emptyEl || !contentEl) return;

  // STEP 1: Hide content, show empty with spinner
  contentEl.style.display = 'none';
  emptyEl.style.display  = 'flex';
  emptyEl.innerHTML = `
    <div class="gvcp-empty">
      <div style="width:48px;height:48px;border:4px solid var(--c-border-light);border-top-color:var(--c-primary);
           border-radius:50%;animation:gvcpSpin .7s linear infinite;margin-bottom:16px;"></div>
      <p style="font-size:14px;color:var(--c-text-muted);font-weight:600;">Memuat kelas...</p>
    </div>`;

  // STEP 2: Fetch API with proper error handling
  fetch('/api/get-course-modules?course_id=' + course_id)
    .then(r => {
      // Check if response is ok (status 200-299)
      if (!r.ok) {
        throw new Error(`HTTP ${r.status}: ${r.statusText}`);
      }
      return r.json();
    })
    .then(res => {
      // Check if API returned success flag
      if (res && res.success === true) {
        cpCurrentCourse = res.course;
        cpModules       = res.modules || [];
        
        // Find active module (first uncompleted & unlocked)
        cpCurrentModIdx = 0;
        for (let i = 0; i < cpModules.length; i++) {
          if (!cpModules[i].is_locked && !cpModules[i].is_completed) {
            cpCurrentModIdx = i;
            break;
          }
        }
        
        _cpRenderShell();
        _cpLoadMod(cpCurrentModIdx);
      } else {
        // API returned but success=false
        _cpShowError(emptyEl, res?.message || 'Kelas tidak ditemukan.');
      }
    })
    .catch(error => {
      // Network error, JSON parse error, or fetch failed
      console.error('Course player error:', error);
      _cpShowError(emptyEl, 
        error.message?.includes('HTTP') 
          ? 'Server error: ' + error.message
          : 'Koneksi bermasalah. Coba muat ulang halaman.'
      );
    });
}

function _cpShowError(el, msg) {
  // CRITICAL: Clear spinner animation and show error
  el.innerHTML = `
    <div class="gvcp-empty">
      <div class="gvcp-empty-icon" style="background:rgba(239,68,68,.1);color:#ef4444;">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
      </div>
      <h2 class="gvcp-empty-title">Gagal Memuat</h2>
      <p class="gvcp-empty-desc">${msg}</p>
      <div class="gvcp-empty-btns">
        <button class="btn btn-primary" onclick="window.location.href='/kelas'">Kembali ke Kelas</button>
        <button class="btn btn-outline" onclick="location.reload()">Muat Ulang</button>
      </div>
    </div>`;
  
  // Ensure empty state is visible, content is hidden
  el.style.display = 'flex';
  const contentEl = document.getElementById('coursePlayerContent');
  if (contentEl) contentEl.style.display = 'none';
}

/* ── Render Shell (Banner + Status) ─────────────────────── */
function _cpRenderShell() {
  // CRITICAL: Hide empty, show content
  document.getElementById('coursePlayerEmpty').style.display  = 'none';
  document.getElementById('coursePlayerContent').style.display = 'block';

  const c   = cpCurrentCourse;
  const pct = Math.round(c.progress_percent || 0);

  /* Banner */
  document.getElementById('cpCourseTitle').textContent = c.title;
  _cpSetHTML('cpCourseMentor',
    `<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg> Mentor: ${c.mentor_name || 'Tim GuruVerse'}`);
  _cpSetHTML('cpCourseDuration',
    `<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg> ${c.duration_hours || 0} Jam`);
  _cpSetHTML('cpCourseTotalModules',
    `<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/></svg> ${cpModules.length} Modul`);

  /* Status badge */
  const isComplete = (c.completed_modules >= cpModules.length) || c.enrollment_status === 'completed';
  const badge      = document.getElementById('cpStatusBadge');
  if (badge) {
    badge.textContent = isComplete ? '✅ Selesai' : 'Sedang Dipelajari';
    if (isComplete) { 
      badge.style.background = 'rgba(16,185,129,.2)'; 
      badge.style.color = '#34d399'; 
      badge.style.borderColor = 'rgba(16,185,129,.4)'; 
    }
  }

  /* Banner progress */
  _cpSetText('gvcpBannerPct', pct + '%');
  const bbar = document.getElementById('gvcpBannerBar');
  if (bbar) bbar.style.width = pct + '%';

  /* Left progress */
  _cpSetText('cpCoursePct',    pct + '%');
  const bar = document.getElementById('cpCourseBar');
  if (bar) bar.style.width = pct + '%';
  _cpSetText('cpCourseModText', `Selesai ${c.completed_modules || 0} dari ${cpModules.length} modul`);
}

/* ── Render Module List ──────────────────────────────────── */
function _cpRenderModList(activeIdx) {
  const listEl = document.getElementById('cpModuleList');
  if (!listEl) return;

  let html = '';
  cpModules.forEach((m, i) => {
    const isActive = (i === activeIdx);
    const isDone   = m.is_completed && !isActive;
    const isLocked = m.is_locked;

    const cls     = 'gvcp-mod-item' + (isActive ? ' gvcp-mod-active' : '') + (isLocked ? ' gvcp-mod-locked' : '');
    const numCls  = 'gvcp-mod-num ' + (isActive ? 'gvcp-mod-num-active' : isDone ? 'gvcp-mod-num-done' : isLocked ? 'gvcp-mod-num-locked' : 'gvcp-mod-num-idle');
    const nameCol = isActive ? 'active' : 'idle';
    const icon    = isDone ? '✅' : isLocked ? '🔒' : isActive ? '▶' : '';
    const durText = isActive ? '<span style="color:var(--c-primary);font-weight:700;">Sedang Dipelajari</span>'
                             : (m.duration_minutes ? m.duration_minutes + ' mnt' : '');
    const onclick = isLocked ? '' : `onclick="cpLoadMod(${i})"`;

    html += `
      <div class="${cls}" ${onclick} title="${m.tandur_name}">
        <div class="${numCls}">${m.module_number}</div>
        <div class="gvcp-mod-info-wrap">
          <div class="gvcp-mod-name ${nameCol}">${m.tandur_name}</div>
          <div class="gvcp-mod-dur">${durText}</div>
        </div>
        ${icon ? `<span class="gvcp-mod-status">${icon}</span>` : ''}
      </div>`;
  });
  listEl.innerHTML = html;

  /* Nav dots */
  const dotsEl = document.getElementById('gvcpNavDots');
  if (dotsEl && cpModules.length <= 10) {
    dotsEl.innerHTML = cpModules.map((_, i) =>
      `<div class="gvcp-nav-dot ${i === activeIdx ? 'active' : ''}" onclick="cpLoadMod(${i})" title="Modul ${i+1}"></div>`
    ).join('');
  }
}

/* ── Load a Module ───────────────────────────────────────── */
function _cpLoadMod(index) {
  if (index < 0 || index >= cpModules.length) return;
  const mod = cpModules[index];
  if (mod.is_locked) {
    typeof gbShowAlert === 'function'
      ? gbShowAlert('Modul Terkunci 🔒', 'Kerjakan kuis modul sebelumnya terlebih dahulu untuk membuka modul ini.', 'info')
      : alert('Modul ini masih terkunci.');
    return;
  }
  cpCurrentModIdx = index;
  _cpRenderModList(index);

  /* Modul badge + judul */
  _cpSetText('gvcpModBadge', `Modul ${mod.module_number}`);
  _cpSetText('cpModTitle', `${mod.tandur_name}`);
  _cpSetText('cpModSubtitle', `Sesi ${mod.module_number} dari ${cpModules.length}`);

  /* Deskripsi */
  const descEl = document.getElementById('cpModDesc');
  if (descEl) descEl.innerHTML = mod.content || '<p style="color:var(--c-text-muted);">Materi belum tersedia.</p>';

  /* Video */
  const iframe  = document.getElementById('cpModIframe');
  const vidWrap = document.getElementById('gvcpVideoWrap');
  const noVid   = document.getElementById('gvcpNoVideo');
  if (iframe && vidWrap && noVid) {
    if (mod.video_url) {
      let url = mod.video_url;
      try {
        if (url.includes('youtube.com/watch')) {
          url = 'https://www.youtube.com/embed/' + new URL(url).searchParams.get('v');
        } else if (url.includes('youtu.be/')) {
          url = 'https://www.youtube.com/embed/' + url.split('youtu.be/')[1].split('?')[0];
        }
      } catch(e) {}
      iframe.src         = url;
      vidWrap.style.display = 'block';
      noVid.style.display   = 'none';
    } else {
      iframe.src         = '';
      vidWrap.style.display = 'none';
      noVid.style.display   = 'flex';
    }
  }

  /* Complete banner */
  const banner = document.getElementById('cpCourseCompleteBanner');
  if (banner) {
    const allDone = cpCurrentCourse.completed_modules >= cpModules.length || cpCurrentCourse.enrollment_status === 'completed';
    banner.style.display = (index === cpModules.length - 1 && allDone) ? 'block' : 'none';
  }

  /* Quiz */
  _cpSetText('cpQuizModName', mod.module_number);
  const quizBtn = document.getElementById('cpQuizBtn');
  if (quizBtn) {
    const hasScore = (mod.user_score !== null && mod.user_score !== undefined);
    quizBtn.textContent = hasScore ? `Kerjakan Ulang (Nilai: ${mod.user_score})` : 'Kerjakan Quiz';
    quizBtn.className   = 'btn btn-sm gvcp-quiz-btn ' + (hasScore ? 'btn-outline' : 'btn-primary');
    if (hasScore) {
      const pass = mod.user_score >= (mod.passing_score || 70);
      quizBtn.style.color       = pass ? 'var(--c-success)' : 'var(--c-danger)';
      quizBtn.style.borderColor = pass ? 'var(--c-success)' : 'var(--c-danger)';
    } else { quizBtn.style.color = ''; quizBtn.style.borderColor = ''; }
    const soalEl = document.getElementById('gvcpQuizCount');
    if (soalEl) soalEl.textContent = mod.question_count || 5;
  }

  /* Notes */
  const notesEl = document.getElementById('cpNotesInput');
  if (notesEl) {
    const lk = `gb_notes_${cpCurrentCourse.id}_${mod.module_number}`;
    notesEl.value = localStorage.getItem(lk) || '';
  }

  /* Nav buttons */
  const prev = document.getElementById('cpBtnPrev');
  const next = document.getElementById('cpBtnNext');
  if (prev) prev.style.visibility = index === 0                    ? 'hidden' : 'visible';
  if (next) next.style.visibility = index === cpModules.length - 1 ? 'hidden' : 'visible';

  /* Scroll to top of player */
  const banner2 = document.getElementById('gvcpBanner');
  if (banner2) banner2.scrollIntoView({ behavior: 'smooth', block: 'start' });
}

/* ── Public API ──────────────────────────────────────────── */
function cpLoadMod(index)  { _cpLoadMod(index); }
function cpNavMod(dir)     { _cpLoadMod(cpCurrentModIdx + dir); }

function cpSaveNotes() {
  const mod    = cpModules[cpCurrentModIdx];
  const lk     = `gb_notes_${cpCurrentCourse.id}_${mod.module_number}`;
  const notesEl = document.getElementById('cpNotesInput');
  if (!notesEl) return;
  localStorage.setItem(lk, notesEl.value);
  typeof gbShowAlert === 'function'
    ? gbShowAlert('Tersimpan ✅', 'Catatan berhasil disimpan di browser.', 'success')
    : alert('Catatan disimpan!');
}

function startCpQuiz() {
  const mod = cpModules[cpCurrentModIdx];
  if (!mod) return;
  if (mod.user_score !== null && mod.user_score !== undefined) {
    typeof gbShowConfirm === 'function'
      ? gbShowConfirm('Kerjakan Ulang?', `Nilai sebelumnya: <strong>${mod.user_score}</strong>. Lanjutkan?`, () => _doQuiz(mod))
      : (confirm('Kerjakan ulang?') && _doQuiz(mod));
  } else { _doQuiz(mod); }
}
function _doQuiz(mod) {
  window.location.href = `/quiz-take?course_id=${cpCurrentCourse.id}&module_number=${mod.module_number}`;
}

/* ── Helpers ─────────────────────────────────────────────── */
function _cpSetText(id, t) { const el = document.getElementById(id); if (el) el.textContent = t; }
function _cpSetHTML(id, h) { const el = document.getElementById(id); if (el) el.innerHTML   = h; }

/* ── Auto-load ───────────────────────────────────────────– */
document.addEventListener('DOMContentLoaded', function() {
  const params   = new URLSearchParams(window.location.search);
  const courseId = params.get('course_id') || localStorage.getItem('cp_last_course_id');
  if (courseId) initCoursePlayer(courseId);
});

</script>


@endsection
