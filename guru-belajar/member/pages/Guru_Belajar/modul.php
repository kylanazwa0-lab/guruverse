<div class="page" id="page-modul" style="background:var(--c-bg); min-height:100vh; padding-top:0 !important;">
  <div id="coursePlayerEmpty" style="padding:100px 20px; text-align:center; display:block;">
     <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--c-border)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom:16px"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
     <h2 style="font-size:20px; font-weight:800; color:var(--c-text); margin-bottom:8px">Pemutar Modul Belajar</h2>
     <p style="color:var(--c-text-muted); font-size:14px;">Silakan pilih kelas yang sedang Anda pelajari dari menu <b>Kelas Saya</b> atau <b>Dashboard</b>.</p>
     <br><br>
     <button class="btn btn-primary" onclick="showPage('kelas')">Ke Kelas Saya</button>
  </div>
  
  <div id="coursePlayerContent" class="cp-layout" style="display:none;">
    <!-- Top Bar -->
    <div class="cp-header">
      <div>
         <button class="btn btn-ghost btn-sm" onclick="showPage('kelas')" style="margin-bottom:12px; border:none; padding-left:0; color:var(--c-text-muted);">
            &larr; Kembali ke Kelas
         </button>
         <h1 id="cpCourseTitle" class="cp-title">Judul Kelas</h1>
         <div class="cp-meta">
            <span id="cpCourseMentor" class="cp-meta-item">
               <div style="width:20px; height:20px; border-radius:50%; background:var(--c-primary); color:#fff; display:flex; align-items:center; justify-content:center; font-size:10px; font-weight:800"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></div> Mentor: ...
            </span>
            <span id="cpCourseDuration" class="cp-meta-item"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg> 0 Jam</span>
            <span id="cpCourseTotalModules" class="cp-meta-item"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/></svg> 0 Modul</span>
            <span class="cp-status-badge">Sedang Dipelajari</span>
         </div>
      </div>
    </div>

    <!-- 3 Columns Layout -->
    <div class="cp-grid">
      
      <!-- Left: Modules -->
      <div class="cp-panel-sticky" style="display:flex; flex-direction:column; gap:24px;">
         
         <div class="cp-panel">
            <h3 class="cp-section-title">Daftar Modul</h3>
            <div id="cpModuleList" style="display:flex; flex-direction:column; gap:12px;">
               <!-- Modules injected by JS -->
            </div>
         </div>

         <div class="cp-progress-card" style="min-width:0; width:100%;">
            <div style="font-size:12px; font-weight:700; color:var(--c-text-muted); margin-bottom:8px">Progress Belajar</div>
            <div id="cpCoursePct" style="font-size:28px; font-weight:800; color:var(--c-text); margin-bottom:12px">0%</div>
            <div style="height:6px; background:var(--c-border-light); border-radius:99px; overflow:hidden; margin-bottom:8px;">
               <div id="cpCourseBar" style="width:0%; height:100%; background:var(--c-primary); border-radius:99px; transition:width 0.3s"></div>
            </div>
            <div id="cpCourseModText" style="font-size:11px; color:var(--c-text-muted)">Selesai 0 dari 0 modul</div>
         </div>

         <div class="cp-widget-promo" style="margin-top:0;">
           <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" style="position:absolute; top:-10px; right:-10px; opacity:0.1"><polyline points="20 12 20 22 4 22 4 2 8 2"/><path d="M14 2l6 6"/><path d="M14 2v6h6"/><circle cx="10" cy="13" r="2"/></svg>
           <div style="font-weight:800; font-size:14px; margin-bottom:8px; position:relative; z-index:1">Ajak rekan guru</div>
           <p style="font-size:11px; opacity:0.9; margin-bottom:16px; position:relative; z-index:1">Dapatkan benefit menarik!</p>
           <button class="btn btn-sm" style="width:100%; font-size:11px; background:#fff; color:var(--c-primary); position:relative; z-index:1; font-weight:700">Ajak Sekarang</button>
         </div>
         
         <div class="cp-widget-help" style="margin-top:0;">
           <div style="font-weight:700; font-size:12px; margin-bottom:8px; color:var(--c-text)">Butuh Bantuan?</div>
           <p style="font-size:11px; color:var(--c-text-muted); margin-bottom:12px">Kunjungi forum diskusi atau hubungi mentor.</p>
           <button class="btn btn-outline btn-sm" style="width:100%; font-size:11px" onclick="showPage('diskusi')">Ke Forum Diskusi</button>
         </div>
      </div>

      <!-- Right Column: Video & Resources -->
      <div style="display:flex; flex-direction:column; gap:24px; min-width:0;">
         
         <!-- Main: Video & Content -->
         <div class="cp-panel cp-panel-main">
          <div id="cpCourseCompleteBanner" style="display:none; background:linear-gradient(135deg, #10b981, #059669); border-radius:12px; padding:24px; color:#fff; margin-bottom:24px; text-align:center; box-shadow:0 8px 16px rgba(16,185,129,0.2);">
            <div style="font-size:48px; margin-bottom:12px">🎓</div>
            <h2 style="font-size:20px; font-weight:800; margin-bottom:8px">Selamat! Anda telah menyelesaikan kelas ini!</h2>
            <p style="font-size:14px; opacity:0.9; margin-bottom:20px; max-width:500px; margin-left:auto; margin-right:auto">Sertifikat kelulusan resmi Anda kini telah diterbitkan. Anda dapat mengunduhnya sebagai bukti kompetensi.</p>
            <button class="btn" style="background:#fff; color:#059669; font-weight:800; padding:10px 24px; border:none; border-radius:8px; cursor:pointer" onclick="showPage('sertifikat')">Lihat Sertifikat &rarr;</button>
          </div>

          <div style="margin-bottom:24px;">
            <h2 id="cpModTitle" style="font-size:22px; font-weight:800; color:var(--c-text); margin-bottom:6px">Memuat...</h2>
            <div id="cpModSubtitle" style="font-size:13px; color:var(--c-text-muted); font-weight:600;">Sesi ...</div>
          </div>
         
          <div class="cp-video-container">
            <iframe id="cpModIframe" width="100%" height="100%" src="" title="Video Pembelajaran" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen style="border:none;"></iframe>
          </div>

         <h3 class="cp-section-title-lg">Ringkasan Materi</h3>
         <div id="cpModDesc" style="font-size:14px; color:var(--c-text-muted); line-height:1.7; margin-bottom:32px">
           <!-- Content -->
         </div>

         <!-- Unduhan Materi dipindah ke dalam Ringkasan Materi -->

         <div style="display:flex; justify-content:space-between; border-top:1px solid var(--c-border); padding-top:24px;">
            <button class="btn btn-outline" id="cpBtnPrev" onclick="cpNavMod(-1)">&larr; Sebelumnya</button>
            <button class="btn btn-primary" id="cpBtnNext" onclick="cpNavMod(1)">Selanjutnya &rarr;</button>
         </div>
      </div>

      <!-- Bottom Resources Grid -->
      <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px;">
         
         <!-- Quiz -->
         <div class="cp-panel">
           <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
             <div>
               <h3 id="cpQuizTitle" style="font-size:15px; font-weight:800; margin-bottom:4px; color:var(--c-text)">Quiz <span id="cpQuizModName">Modul</span></h3>
               <p style="font-size:11px; color:var(--c-text-muted)">Kerjakan quiz untuk lanjut</p>
             </div>
             <div class="cp-quiz-circle" style="margin-bottom:0">
               <div style="display:flex; flex-direction:column; align-items:center; justify-content:center;">
                  <span style="font-size:16px; font-weight:800; color:var(--c-primary); line-height:1">5</span>
                  <span style="font-size:9px; color:var(--c-text-muted); font-weight:700; margin-top:2px">Soal</span>
               </div>
             </div>
           </div>
            <button id="cpQuizBtn" class="btn btn-primary btn-sm" style="width:100%" onclick="startCpQuiz()">Kerjakan Quiz</button>
         </div>

         <!-- Diskusi -->
         <div class="cp-panel">
           <h3 class="cp-section-title-lg">Diskusi Modul</h3>
           <div style="display:flex; gap:12px; margin-bottom:16px">
             <div style="width:36px; height:36px; border-radius:50%; background:var(--c-primary); color:#fff; display:flex; align-items:center; justify-content:center; font-size:16px; font-weight:800"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></div>
             <div>
               <div style="display:flex; justify-content:space-between; align-items:center; width:100%">
                 <div style="font-size:12px; font-weight:800; color:var(--c-text)">Budi Santoso</div>
                 <div style="font-size:9px; color:var(--c-primary); background:var(--c-primary-pale); padding:3px 8px; border-radius:4px; font-weight:700">Pertanyaan</div>
               </div>
               <div style="font-size:10px; color:var(--c-text-muted); margin-bottom:6px; margin-top:2px">2 jam yang lalu</div>
               <p style="font-size:12px; line-height:1.5; color:var(--c-text-muted)">Bagaimana cara mengatasi siswa yang pasif dalam diskusi kelompok?</p>
             </div>
           </div>
           <a href="#" onclick="showPage('diskusi'); return false;" style="font-size:12px; color:var(--c-primary); text-decoration:none; font-weight:700;">Lihat Diskusi Lainnya &rarr;</a>
         </div>

         <!-- Catatan -->
         <div class="cp-panel">
           <h3 class="cp-section-title-lg">Catatan Saya</h3>
           <textarea id="cpNotesInput" class="cp-textarea" placeholder="Tulis catatan pribadi untuk materi ini..."></textarea>
           <button class="btn btn-outline btn-sm" style="width:100%; font-weight:700" onclick="cpSaveNotes()">Simpan Catatan</button>
         </div>
          </div>
       </div> <!-- Tutup Bottom Resources Grid -->
      </div> <!-- Tutup Right Column wrapper -->
      
    </div>
  </div>
</div>
