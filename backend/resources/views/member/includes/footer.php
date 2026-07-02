<script>
/* ── Dark Mode Core ── */
// Apply saved theme BEFORE paint to avoid flash
(function() {
  var saved = localStorage.getItem('guruverse_theme');
  var prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
  var theme = saved || (prefersDark ? 'dark' : 'light');
  document.documentElement.setAttribute('data-theme', theme);
})();

function toggleDarkMode() {
  var html = document.documentElement;
  var current = html.getAttribute('data-theme');
  var next = (current === 'dark') ? 'light' : 'dark';
  html.setAttribute('data-theme', next);
  localStorage.setItem('guruverse_theme', next);
  // Sync settings page switch if open
  var sw = document.getElementById('settDarkModeSwitch');
  if (sw) sw.checked = (next === 'dark');
  // Sync preview label
  var lbl = document.getElementById('darkModePreviewLabel');
  if (lbl) lbl.textContent = (next === 'dark') ? 'Mode Gelap' : 'Mode Terang';
}
</script>
<script>
/* ── Navigation ── */

function showPage(name, updateHash = true) {
  try {
    // Auto-close chat widget on page navigation
    const gbWin = document.getElementById('gbChatWindow');
    if (gbWin && gbWin.style.display === 'flex') {
      gbWin.style.display = 'none';
      if (typeof gbChatTimer !== 'undefined' && gbChatTimer) {
        clearInterval(gbChatTimer);
        gbChatTimer = null;
      }
    }

    // 1. Hide all pages
    document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
    
    // 2. Show target page
    const page = document.getElementById('page-' + name);
    if (page) {
      page.classList.add('active');
    }

    // 3. Update sidebar active state
    const navItems = document.querySelectorAll('.nav-item');
    navItems.forEach(n => n.classList.remove('active'));
    
    navItems.forEach(n => {
      const oc = n.getAttribute('onclick');
      if (oc && (oc.indexOf("showPage('" + name + "')") !== -1 || oc.indexOf('showPage("' + name + '")') !== -1)) {
        n.classList.add('active');
      }
    });

    // 4. Close notification dropdown if open
    const notifDropdown = document.getElementById('notifDropdown');
    if (notifDropdown) {
      notifDropdown.classList.remove('open');
    }

    // 5. Scroll to top
    window.scrollTo(0, 0);

    // 6. Update URL Hash without reloading
    if (updateHash) {
      if (window.history && window.history.pushState) {
        window.history.pushState(null, null, '#' + name);
      } else {
        window.location.hash = name;
      }
    }

    // 7. Fire any specific page load events
    if (typeof window.updateDashboardCartCount === 'function') {
      window.updateDashboardCartCount();
    }
    if (name === 'cart' && typeof window.renderFullCart === 'function') {
      window.renderFullCart();
    }
    if (name === 'cart-gamifikasi' && typeof window.gvgRenderCart === 'function') {
      window.gvgRenderCart();
    }
  } catch(e) {
    console.error('Error in showPage:', e);
  }
}

// Show page based on URL hash on load
document.addEventListener('DOMContentLoaded', () => {
  const hash = window.location.hash.substring(1);
  if (hash && document.getElementById('page-' + hash)) {
    if (hash === 'modul') {
      const lastCourse = localStorage.getItem('cp_last_course_id');
      if (lastCourse) {
        openCoursePlayer(lastCourse);
      } else {
        showPage(hash, false);
      }
    } else {
      showPage(hash, false);
    }
  }
});

// Handle browser back/forward navigation to switch pages properly
window.addEventListener('popstate', () => {
  const hash = window.location.hash.substring(1);
  if (hash && document.getElementById('page-' + hash)) {
    if (hash === 'modul') {
      const lastCourse = localStorage.getItem('cp_last_course_id');
      if (lastCourse) {
        openCoursePlayer(lastCourse);
      } else {
        showPage(hash, false);
      }
    } else {
      showPage(hash, false);
    }
  } else {
    // default page if no hash
    showPage('dashboard', false);
  }
});

/* ── Notification dropdown ── */
function toggleNotif() {
  document.getElementById('notifDropdown').classList.toggle('open');
}

document.addEventListener('click', e => {
  const dd = document.getElementById('notifDropdown');
  const btn = document.querySelector('.notif-btn');
  if (!dd.contains(e.target) && !btn.contains(e.target)) {
    dd.classList.remove('open');
  }
});

/* ── Tab switching ── */
document.querySelectorAll('.tabs-underline').forEach(group => {
  group.querySelectorAll('.tab-underline').forEach(tab => {
    tab.addEventListener('click', () => {
      group.querySelectorAll('.tab-underline').forEach(t => t.classList.remove('active'));
      tab.classList.add('active');
    });
  });
});

document.querySelectorAll('.filter-tabs').forEach(group => {
  group.querySelectorAll('.filter-tab').forEach(tab => {
    tab.addEventListener('click', () => {
      group.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
      tab.classList.add('active');
    });
  });
});

document.querySelectorAll('.diskusi-cat-tabs').forEach(group => {
  group.querySelectorAll('.diskusi-cat-tab').forEach(tab => {
    tab.addEventListener('click', () => {
      group.querySelectorAll('.diskusi-cat-tab').forEach(t => t.classList.remove('active'));
      tab.classList.add('active');
    });
  });
});

/* ── Browser Notification System ── */
const NotifSystem = {
  apiUrl: 'api/notifications.php',
  pollInterval: 15000, // 15 detik
  timer: null,

  async init() {
    // Minta izin notifikasi browser
    if ('Notification' in window) {
      if (Notification.permission === 'default') {
        const perm = await Notification.requestPermission();
        if (perm === 'granted') {
          console.log('🔔 Notifikasi browser diizinkan');
        }
      }
      // Mulai polling
      this.poll();
      this.timer = setInterval(() => this.poll(), this.pollInterval);
      // Update badge count
      this.updateBadge();
    }
  },

  async poll() {
    try {
      const res = await fetch(this.apiUrl + '?action=unpushed');
      const data = await res.json();
      if (data.success && data.notifications.length > 0) {
        // Tampilkan notifikasi browser untuk setiap yang baru
        data.notifications.forEach(n => {
          this.showBrowserNotif(n);
        });
        // Tandai sebagai sudah di-push
        const ids = data.notifications.map(n => n.id);
        await fetch(this.apiUrl, {
          method: 'POST',
          headers: {'Content-Type': 'application/json'},
          body: JSON.stringify({ action: 'mark_pushed', ids: ids })
        });
        // Update badge
        this.updateBadge();
        // Update dropdown notifikasi di halaman
        this.updateDropdown();
      }
    } catch(e) {
      console.warn('Polling notifikasi gagal:', e);
    }
  },

  showBrowserNotif(notif) {
    if (Notification.permission !== 'granted') return;
    
    const iconMap = {
      'book': '📚', 'check': '✅', 'bell': '🔔', 
      'award': '🏆', 'message': '💬', 'info': 'ℹ️'
    };
    const emoji = iconMap[notif.icon] || '🔔';
    
    const n = new Notification(emoji + ' ' + notif.title, {
      body: notif.body,
      icon: '/asset/img/FA Logo Guruverse.ID - main.png',
      badge: '/asset/img/FA Logo Guruverse.ID - main.png',
      tag: 'gb-notif-' + notif.id,
      requireInteraction: false,
      silent: false
    });
    
    n.onclick = () => {
      window.focus();
      if (notif.link) {
        showPage(notif.link);
      }
      // Tandai dibaca
      fetch(this.apiUrl, {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({ action: 'mark_one_read', id: notif.id })
      });
      n.close();
      this.updateBadge();
    };
  },

  async updateBadge() {
    try {
      const res = await fetch(this.apiUrl + '?action=unread_count');
      const data = await res.json();
      const badge = document.querySelector('.notif-count');
      if (badge && data.success) {
        badge.textContent = data.count;
        badge.style.display = data.count > 0 ? '' : 'none';
      }
    } catch(e) {}
  },

  async updateDropdown() {
    try {
      const res = await fetch(this.apiUrl + '?action=all');
      const data = await res.json();
      if (!data.success) return;
      
      const dd = document.getElementById('notifDropdown');
      if (!dd) return;
      
      // Rebuild notification items
      const items = dd.querySelectorAll('.notif-item');
      // Keep the structure, just update if needed
    } catch(e) {}
  },

  async markAllRead() {
    try {
      await fetch(this.apiUrl, {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({ action: 'mark_read' })
      });
      this.updateBadge();
    } catch(e) {}
  }
};

// Inisialisasi notifikasi saat halaman siap
document.addEventListener('DOMContentLoaded', () => {
  NotifSystem.init();
  
  // URL query parameter router
  const params = new URLSearchParams(window.location.search);
  const pageParam = params.get('page');
  if (pageParam) {
    showPage(pageParam);
  }
});

// Hubungkan tombol "Tandai semua sudah dibaca"
document.addEventListener('DOMContentLoaded', () => {
  const markReadBtn = document.querySelector('.notif-dd-header .link-action');
  if (markReadBtn) {
    markReadBtn.addEventListener('click', () => {
      NotifSystem.markAllRead();
      // Visual feedback
      document.querySelectorAll('.notif-dot').forEach(d => d.style.display = 'none');
    });
  }
});

  /* ── Stagger animation on load ── */
  /* PENTING: Jangan tulis c.style.transition — itu override CSS dan membuat dark/light
     mode jadi patah-patah karena transition warna tidak bisa berjalan. */
  (function() {
    const cards = document.querySelectorAll('#page-dashboard .stat-card');
    cards.forEach((c, i) => {
      c.style.opacity = '0';
      c.style.transform = 'translateY(20px)';
      setTimeout(() => {
        c.style.opacity = '';
        c.style.transform = '';
      }, 80 + i * 60);
    });
  })();

  // Initialize FlyonUI components
  document.addEventListener('DOMContentLoaded', () => {
    if (window.HSStaticMethods) {
      HSStaticMethods.autoInit();
    }
  });

  /* ── Course Player LMS Logic ── */
  let cpCurrentCourse = null;
  let cpModules = [];
  let cpCurrentModIndex = 0;

  function openCoursePlayer(course_id) {
    localStorage.setItem('cp_last_course_id', course_id);
    // Show page first
    showPage('modul');
    
    // UI Loading state
    const emptyState = document.getElementById('coursePlayerEmpty');
    const contentState = document.getElementById('coursePlayerContent');
    if (emptyState) {
        emptyState.innerHTML = '<div style="padding:100px 20px"><div class="spinner-border text-primary" role="status"></div><h2 style="margin-top:16px;font-size:18px">Memuat Kelas...</h2></div>';
        emptyState.style.display = 'block';
    }
    if (contentState) contentState.style.display = 'none';

    fetch('api/get_course_modules.php?course_id=' + course_id)
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
              emptyState.innerHTML = '<h2 style="margin-bottom:16px">Gagal memuat kelas</h2><p>' + res.message + '</p><button class="btn btn-primary" onclick="showPage(\'kelas\')">Kembali</button>';
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
             badgeEl.style.background = 'rgba(16, 185, 129, 0.15)'; // var(--c-success-pale) fallback
             badgeEl.style.color = '#059669'; // var(--c-success) fallback
         } else {
             badgeEl.textContent = 'Sedang Dipelajari';
             badgeEl.style.background = 'rgba(124, 58, 237, 0.15)'; // var(--c-primary-pale) fallback
             badgeEl.style.color = '#7c3aed'; // var(--c-primary) fallback
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
         gbShowAlert('Modul Terkunci 🔒', 'Modul ini masih terkunci! Silakan kerjakan Quiz pada modul saat ini terlebih dahulu untuk melanjutkan.', 'info');
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

  let cpCurrentQuizData = null;
  let qtCurrentQIdx = 0;
  let qtUserAnswers = {};
  let qtDoubtful = {};
  let qtTimerInterval = null;
  let qtTimeLeft = 45 * 60; // 45 minutes

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
      if (!mod.quiz_data || mod.quiz_data.length === 0) {
          // Fallback auto-pass for modules without quiz data
          gbShowAlert('Kuis Disetujui ✅', 'Modul ini tidak memerlukan kuis (atau sedang disiapkan). Modul berikutnya otomatis terbuka.', 'success');
          submitCpQuizAPI(mod);
          return;
      }

      cpCurrentQuizData = mod.quiz_data;
      qtCurrentQIdx = 0;
      qtUserAnswers = {};
      qtDoubtful = {};
      qtTimeLeft = 45 * 60; // reset to 45 mins
      
      // show full page quiz take
      showPage('quiz-take');
      
      // setup timer
      if(qtTimerInterval) clearInterval(qtTimerInterval);
      qtUpdateTimerDisplay();
      qtTimerInterval = setInterval(() => {
          qtTimeLeft--;
          if (qtTimeLeft <= 0) {
              clearInterval(qtTimerInterval);
              gbShowAlert('Waktu Habis', 'Waktu Anda telah habis. Jawaban akan disubmit otomatis.', 'info');
              submitCpQuizAnswers();
          } else {
              qtUpdateTimerDisplay();
          }
      }, 1000);

      qtRenderGrid();
      qtRenderQuestion(0);
  }

  function qtUpdateTimerDisplay() {
      const h = Math.floor(qtTimeLeft / 3600);
      const m = Math.floor((qtTimeLeft % 3600) / 60);
      const s = qtTimeLeft % 60;
      document.getElementById('qtTimer').textContent = `${h} Jam ${m} Menit ${s} Detik`;
  }

  function qtRenderGrid() {
      let html = '';
      cpCurrentQuizData.forEach((q, idx) => {
          let cls = 'qt-nav-btn';
          if (idx === qtCurrentQIdx) cls += ' active-q';
          if (qtDoubtful[idx]) cls += ' doubtful';
          else if (qtUserAnswers[idx] !== undefined) cls += ' answered';
          
          let num = (idx + 1).toString().padStart(2, '0');
          html += `<button class="${cls}" onclick="qtGoTo(${idx})">${num}</button>`;
      });
      document.getElementById('qtNavGrid').innerHTML = html;
  }

  function qtRenderQuestion(idx) {
      qtCurrentQIdx = idx;
      const q = cpCurrentQuizData[idx];
      
      document.getElementById('qtCurrentNumBadge').textContent = (idx + 1);
      document.getElementById('qtQuestionText').innerHTML = q.question;
      
      let optsHtml = '';
      q.options.forEach(opt => {
          const isSelected = (qtUserAnswers[idx] === opt.id);
          optsHtml += `
          <label class="qt-opt-label ${isSelected ? 'selected' : ''}">
              <input type="radio" name="qt_q_${idx}" class="qt-opt-radio" value="${opt.id}" ${isSelected ? 'checked' : ''} onchange="qtSelectAnswer(${idx}, '${opt.id}')">
              <span style="font-size:14px; color:var(--c-text); flex:1;">${opt.text}</span>
          </label>`;
      });
      document.getElementById('qtOptionsList').innerHTML = optsHtml;
      
      // Update action buttons state
      document.getElementById('qtBtnPrev').style.visibility = (idx === 0) ? 'hidden' : 'visible';
      
      const nextBtn = document.getElementById('qtBtnNext');
      if (idx === cpCurrentQuizData.length - 1) {
          nextBtn.textContent = 'Selesai';
          nextBtn.style.background = '#4ade80'; // green for finish
          nextBtn.onclick = qtConfirmSubmit;
      } else {
          nextBtn.textContent = 'Selanjutnya';
          nextBtn.style.background = '#5b6cf9';
          nextBtn.onclick = qtNext;
      }
      
      document.getElementById('qtCheckDoubtful').checked = !!qtDoubtful[idx];
      
      // update active grid highlight
      qtRenderGrid();
  }

  function qtSelectAnswer(qIdx, optId) {
      qtUserAnswers[qIdx] = optId;
      qtRenderQuestion(qIdx); // re-render to update selected class and grid color
  }

  function qtToggleDoubtful(isChecked) {
      qtDoubtful[qtCurrentQIdx] = isChecked;
      qtRenderGrid();
  }

  function qtGoTo(idx) {
      qtRenderQuestion(idx);
  }

  function qtPrev() {
      if (qtCurrentQIdx > 0) qtRenderQuestion(qtCurrentQIdx - 1);
  }

  function qtNext() {
      if (qtCurrentQIdx < cpCurrentQuizData.length - 1) qtRenderQuestion(qtCurrentQIdx + 1);
  }

  function qtConfirmSubmit() {
      gbShowConfirm('Akhiri Ujian?', 'Apakah Anda yakin ingin menyelesaikan ujian ini? Pastikan semua soal telah terjawab.', submitCpQuizAnswers);
  }

  function qtConfirmExit() {
      gbShowConfirm('Keluar Ujian?', 'Apakah Anda yakin ingin keluar? Jawaban ujian Anda saat ini tidak akan disimpan dan Anda harus mengulang dari awal nanti.', function() {
          if(qtTimerInterval) clearInterval(qtTimerInterval);
          showPage('quiz');
      });
  }

  function submitCpQuizAnswers() {
      if(qtTimerInterval) clearInterval(qtTimerInterval);
      
      let correct = 0;
      let total = cpCurrentQuizData.length;
      let allAnswered = true;
      
      cpCurrentQuizData.forEach((q, idx) => {
          let selectedId = qtUserAnswers[idx];
          if (selectedId === undefined) allAnswered = false;
          else if (selectedId === q.answer) correct++;
      });
      
      let score = Math.round((correct / total) * 100);
      
      // Switch back to modul page
      showPage('modul');
      
      // Submit the quiz to record answers
      submitCpQuizAPI(cpModules[cpCurrentModIndex], score, qtUserAnswers);
      
      if (score >= 75) { 
          gbShowAlert('Lulus! 🎉', `Selamat! Anda lulus dengan nilai ${score}. Modul berikutnya telah dibuka!`, 'success');
      } else {
          gbShowAlert('Belum Lulus 😢', `Nilai Anda ${score}. Minimal kelulusan adalah 75. Silakan coba lagi.`, 'error');
      }
  }

  function submitCpQuizAPI(mod, score = 100, answers = {}) {
      const formData = new FormData();
      formData.append('course_id', cpCurrentCourse.id);
      formData.append('module_number', mod.module_number);
      formData.append('score', score);
      formData.append('answers_json', JSON.stringify(answers));
      
      fetch('api/complete_module.php', {
          method: 'POST',
          body: formData
      }).then(res => res.json())
        .then(res => {
            if(res.success) {
                openCoursePlayer(cpCurrentCourse.id);
            } else {
                gbShowAlert('Gagal', 'Gagal menyimpan progress: ' + (res.message || 'Unknown error'), 'error');
            }
        })
        .catch(err => {
            console.error(err);
            gbShowAlert('Error', 'Gagal terhubung ke server.', 'error');
        });
  }

function gbShowAlert(title, message, type = 'info', width = '400px') {
    document.getElementById('gbCustomModal').style.display = 'flex';
    document.getElementById('gbModalContainer').style.maxWidth = width;
    document.getElementById('gbModalTitle').textContent = title;
    document.getElementById('gbModalBody').innerHTML = message;
    document.getElementById('gbModalCancel').style.display = 'none';
    
    const okBtn = document.getElementById('gbModalOk');
    okBtn.textContent = 'OK';
    okBtn.className = (type === 'success') ? 'btn btn-primary' : (type === 'error' ? 'btn btn-error' : 'btn btn-primary');
    
    okBtn.onclick = function() {
        gbCloseModal();
    };
}

function gbShowConfirm(title, message, onConfirm) {
    document.getElementById('gbCustomModal').style.display = 'flex';
    document.getElementById('gbModalContainer').style.maxWidth = '400px';
    document.getElementById('gbModalTitle').textContent = title;
    document.getElementById('gbModalBody').innerHTML = message;
    document.getElementById('gbModalCancel').style.display = 'inline-flex';
    
    const okBtn = document.getElementById('gbModalOk');
    okBtn.textContent = 'Lanjutkan';
    okBtn.className = 'btn btn-primary';
    
    okBtn.onclick = function() {
        gbCloseModal();
        if (onConfirm) onConfirm();
    };
}

function viewCertificate(path) {
    const isPdf = path.toLowerCase().endsWith('.pdf');
    const url = '/uploads/certificates/' + path;
    let content = '';
    if (isPdf) {
        content = '<iframe src="' + url + '" style="width:100%; height:60vh; border:none; border-radius:8px;"></iframe>';
    } else {
        content = '<img src="' + url + '" style="width:100%; height:auto; border-radius:8px; box-shadow:0 4px 12px rgba(0,0,0,0.1);">';
    }
    content += '<div style="margin-top:16px"><a href="' + url + '" download class="btn btn-primary" style="text-decoration:none"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:8px"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg> Unduh File</a></div>';
    
    gbShowAlert('Sertifikat Anda', content, 'info', '700px');
}

function gbCloseModal() {
    document.getElementById('gbCustomModal').style.display = 'none';
}
</script>
<!-- FlyonUI JS -->
<!-- Custom Modal -->
<div id="gbCustomModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:9999; align-items:center; justify-content:center; padding:20px; box-sizing:border-box;">
   <div id="gbModalContainer" style="background:var(--c-card); border:1px solid var(--c-border); border-radius:12px; max-width:400px; width:100%; padding:24px; box-shadow:0 10px 30px rgba(0,0,0,0.3); text-align:center; max-height:90vh; overflow-y:auto;">
       <h3 id="gbModalTitle" style="font-size:18px; font-weight:800; color:var(--c-text); margin-bottom:12px;"></h3>
       <div id="gbModalBody" style="font-size:14px; color:var(--c-text-muted); line-height:1.6; margin-bottom:24px;"></div>
       <div id="gbModalActions" style="display:flex; justify-content:center; gap:12px;">
           <button id="gbModalCancel" class="btn btn-outline" style="display:none;" onclick="gbCloseModal()">Batal</button>
           <button id="gbModalOk" class="btn btn-primary" onclick="gbCloseModal()">OK</button>
       </div>
   </div>
</div>

<?php require_once __DIR__ . '/chat_widget.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/flyonui/dist/js/index.min.js"></script>
</body>
</html>
