@extends('layouts.member')

@section('title', ucwords(str_replace('_', ' ', 'modul')))

@section('content')

<div class="page active" id="page-modul" style="background:var(--c-bg); min-height:100vh; padding-top:0 !important;">
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

@section('scripts')
<script>
  let cpCurrentCourse = null;
  let cpModules = [];
  let cpCurrentModIndex = 0;

  function openCoursePlayer(course_id) {
    localStorage.setItem('cp_last_course_id', course_id);
    
    // UI Loading state
    const emptyState = document.getElementById('coursePlayerEmpty');
    const contentState = document.getElementById('coursePlayerContent');
    if (emptyState) {
        emptyState.innerHTML = '<div style="padding:100px 20px"><div style="border: 4px solid #f3f3f3; border-top: 4px solid var(--c-primary); border-radius: 50%; width: 40px; height: 40px; animation: spin 1s linear infinite; margin: 0 auto;"></div><h2 style="margin-top:16px;font-size:18px">Memuat Kelas...</h2></div>';
        emptyState.style.display = 'block';
    }
    if (contentState) contentState.style.display = 'none';

    fetch('/api/get_course_modules.php?course_id=' + course_id)
      .then(res => res.json())
      .then(res => {
        if (res.success) {
          cpCurrentCourse = res.course;
          cpModules = res.modules;
          cpCurrentModIndex = 0;
          // find last active
          for (let i = 0; i < cpModules.length; i++) {
             if (!cpModules[i].is_completed && !cpModules[i].is_locked) {
                cpCurrentModIndex = i;
                break;
              }
          }
          cpRenderCourse();
        } else {
          if(emptyState) {
              emptyState.innerHTML = '<h2 style="margin-bottom:16px">Gagal memuat kelas</h2><p>' + res.message + '</p><button class="btn btn-primary" onclick="window.location.href=\'{{ route("member.kelas") }}\'">Kembali</button>';
          }
        }
      })
      .catch(e => {
          if(emptyState) emptyState.innerHTML = '<p>Terjadi kesalahan koneksi.</p>';
      });
  }

  function cpRenderCourse() {
     document.getElementById('coursePlayerEmpty').style.display = 'none';
     document.getElementById('coursePlayerContent').style.display = 'block';
     
     // Update Header
     document.getElementById('cpCourseTitle').textContent = cpCurrentCourse.title;
     document.getElementById('cpCourseMentor').innerHTML = '<div style="width:20px; height:20px; border-radius:50%; background:var(--c-primary); color:#fff; display:flex; align-items:center; justify-content:center; font-size:10px; font-weight:800"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></div> Mentor: ' + (cpCurrentCourse.mentor_name || 'Tim GuruVerse');
     document.getElementById('cpCourseDuration').innerHTML = '⏱ ' + (cpCurrentCourse.duration_hours || 0) + ' Jam';
     document.getElementById('cpCourseTotalModules').innerHTML = '📚 ' + cpModules.length + ' Modul';
     
     const isCourseComplete = (cpCurrentCourse.completed_modules >= cpModules.length) || (cpCurrentCourse.enrollment_status === 'completed');
     const badgeEl = document.querySelector('.cp-status-badge');
     if (badgeEl) {
          if (isCourseComplete) {
              badgeEl.textContent = 'Selesai';
              badgeEl.style.background = 'rgba(16, 185, 129, 0.15)'; 
              badgeEl.style.color = '#059669'; 
          } else {
              badgeEl.textContent = 'Sedang Dipelajari';
              badgeEl.style.background = 'rgba(124, 58, 237, 0.15)'; 
              badgeEl.style.color = '#7c3aed'; 
          }
     }
     
     const pct = cpCurrentCourse.progress_percent || 0;
     document.getElementById('cpCoursePct').textContent = Math.round(pct) + '%';
     document.getElementById('cpCourseBar').style.width = pct + '%';
     document.getElementById('cpCourseModText').textContent = 'Selesai ' + (cpCurrentCourse.completed_modules||0) + ' dari ' + cpModules.length + ' modul';

     cpLoadMod(cpCurrentModIndex);
  }

  function cpLoadMod(index) {
     if (index < 0 || index >= cpModules.length) return;
     const mod = cpModules[index];
     if (mod.is_locked) {
          gbShowAlert('Modul Terkunci 🔒', 'Modul ini masih terkunci! Silakan kerjakan kuis pada modul saat ini terlebih dahulu untuk melanjutkan.', 'info');
          return;
     }
     cpCurrentModIndex = index;
     
     // Update Sidebar List
     const listDiv = document.getElementById('cpModuleList');
     let html = '';
     cpModules.forEach((m, i) => {
          const isActive = (i === index);
          const isCompleted = m.is_completed && !isActive;
          const isLocked = m.is_locked;
          
          let cls = 'cp-mod-item';
          if (isActive) cls += ' active';
          if (isLocked) cls += ' locked';
          
          let numCls = 'cp-mod-num';
          if (isActive) numCls += ' cp-mod-num-active';
          else if (isCompleted) numCls += ' cp-mod-num-done';
          else numCls += ' cp-mod-num-locked';
          
          let icon = '';
          if (isCompleted) icon = '<span style="color:var(--c-success)">✅</span>';
          else if (isLocked) icon = '<span style="color:var(--c-text-muted)">🔒</span>';
          else if (isActive) icon = '<span style="color:var(--c-primary)">▶️</span>';
          else icon = '<span style="color:var(--c-border)">⚪</span>';
          
          html += `
          <div class="${cls}" onclick="if(!${isLocked}) cpLoadMod(${i})">
             <div style="display:flex; gap:12px; align-items:center; flex:1">
                <div class="${numCls}">${m.module_number}</div>
                <div>
                  <div style="font-size:13px; font-weight:700; color:${isActive ? 'var(--c-primary)' : 'var(--c-text)'}">${m.tandur_name}</div>
                  <div style="font-size:11px; color:var(--c-text-muted); margin-top:2px">${isActive ? 'Sedang Dipelajari' : (m.duration_minutes ? m.duration_minutes+' menit' : '')}</div>
                </div>
             </div>
             ${icon}
          </div>`;
     });
     listDiv.innerHTML = html;
     
     // Update Main Content
     document.getElementById('cpModTitle').textContent = `Modul ${mod.module_number}: ${mod.tandur_name}`;
     document.getElementById('cpModSubtitle').textContent = `Sesi ${mod.module_number} dari ${cpModules.length}`;
     
     document.getElementById('cpModDesc').innerHTML = mod.content || '<p>Materi belum tersedia.</p>';
     const iframe = document.getElementById('cpModIframe');
     if (iframe) {
          if (mod.video_url) {
              iframe.src = mod.video_url;
              iframe.parentElement.style.display = 'block';
          } else {
              iframe.src = '';
              iframe.parentElement.style.display = 'none';
          }
     }
     
     // Course Completion Banner Check
     const banner = document.getElementById('cpCourseCompleteBanner');
     if (banner) {
          if (index === cpModules.length - 1 && cpCurrentCourse.completed_modules >= cpModules.length) {
              banner.style.display = 'block';
          } else {
              banner.style.display = 'none';
          }
     }

     // Update Quiz name
     document.getElementById('cpQuizModName').textContent = mod.module_number;
     
     // Update Notes
     const lsKey = 'gb_notes_course_' + cpCurrentCourse.id + '_mod_' + mod.module_number;
     document.getElementById('cpNotesInput').value = localStorage.getItem(lsKey) || '';

     // Update Buttons
     const quizBtn = document.getElementById('cpQuizBtn');
     if (quizBtn) {
          if (mod.user_score !== undefined && mod.user_score !== null) {
              quizBtn.textContent = 'Kerjakan Ulang (Nilai: ' + mod.user_score + ')';
              quizBtn.className = 'btn btn-outline btn-sm';
              if (mod.user_score >= 100) {
                  quizBtn.style.color = 'var(--c-success)';
                  quizBtn.style.borderColor = 'var(--c-success)';
              } else {
                  quizBtn.style.color = 'var(--c-error, #f87171)';
                  quizBtn.style.borderColor = 'var(--c-error, #f87171)';
              }
          } else {
              quizBtn.textContent = 'Kerjakan Quiz';
              quizBtn.className = 'btn btn-primary btn-sm';
              quizBtn.style.color = '';
              quizBtn.style.borderColor = '';
          }
     }
     document.getElementById('cpBtnPrev').style.visibility = (index === 0) ? 'hidden' : 'visible';
     document.getElementById('cpBtnNext').style.visibility = (index === cpModules.length - 1) ? 'hidden' : 'visible';
  }

  function cpNavMod(dir) {
      cpLoadMod(cpCurrentModIndex + dir);
  }

  function cpSaveNotes() {
      const val = document.getElementById('cpNotesInput').value;
      const mod = cpModules[cpCurrentModIndex];
      const lsKey = 'gb_notes_course_' + cpCurrentCourse.id + '_mod_' + mod.module_number;
      localStorage.setItem(lsKey, val);
      gbShowAlert('Berhasil', 'Catatan berhasil disimpan ke browser Anda!', 'success');
  }

  function startCpQuiz() {
      const mod = cpModules[cpCurrentModIndex];
      if (mod.user_score !== undefined && mod.user_score !== null) {
          gbShowConfirm('Kerjakan Ulang?', 'Anda sudah pernah mengerjakan kuis ini dengan nilai ' + mod.user_score + '. Apakah Anda ingin mengulanginya?', () => {
              _actuallyStartQuiz(mod);
          });
          return;
      }
      _actuallyStartQuiz(mod);
  }

  function _actuallyStartQuiz(mod) {
      window.location.href = `/quiz-take?course_id=${cpCurrentCourse.id}&module_number=${mod.module_number}`;
  }

  function gbShowAlert(title, message, type = 'info', width = '400px') {
      const modal = document.getElementById('gbCustomModal');
      if (!modal) {
          alert(title + ": " + message);
          return;
      }
      modal.style.display = 'flex';
      document.getElementById('gbModalContainer').style.maxWidth = width;
      document.getElementById('gbModalTitle').textContent = title;
      document.getElementById('gbModalBody').innerHTML = message;
      document.getElementById('gbModalCancel').style.display = 'none';
      
      const okBtn = document.getElementById('gbModalOk');
      okBtn.textContent = 'OK';
      okBtn.onclick = function() {
          gbCloseModal();
      };
  }

  function gbShowConfirm(title, message, onConfirm) {
      const modal = document.getElementById('gbCustomModal');
      if (!modal) {
          if (confirm(title + "\n\n" + message)) onConfirm();
          return;
      }
      modal.style.display = 'flex';
      document.getElementById('gbModalContainer').style.maxWidth = '400px';
      document.getElementById('gbModalTitle').textContent = title;
      document.getElementById('gbModalBody').innerHTML = message;
      document.getElementById('gbModalCancel').style.display = 'inline-flex';
      
      const okBtn = document.getElementById('gbModalOk');
      okBtn.textContent = 'Lanjutkan';
      
      okBtn.onclick = function() {
          gbCloseModal();
          if (onConfirm) onConfirm();
      };
  }

  function gbCloseModal() {
      document.getElementById('gbCustomModal').style.display = 'none';
  }

  // Auto-load course when DOM is ready
  document.addEventListener('DOMContentLoaded', () => {
      const params = new URLSearchParams(window.location.search);
      const courseId = params.get('course_id');
      if (courseId) {
          openCoursePlayer(courseId);
      } else {
          const lastCourse = localStorage.getItem('cp_last_course_id');
          if (lastCourse) {
              openCoursePlayer(lastCourse);
          }
      }
  });
</script>

<style>
@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
@endsection