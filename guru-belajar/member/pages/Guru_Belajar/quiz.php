<div class="page" id="page-quiz" style="background:var(--c-bg); min-height:100vh; padding-top:0 !important;">
  <div style="max-width: 900px; margin: 0 auto; padding: 40px 24px;">
    <div style="margin-bottom: 32px;">
      <h1 style="font-size:24px; font-weight:800; color:var(--c-text); margin:0;">Evaluasi & Quiz</h1>
      <p style="color:var(--c-text-muted); font-size:14px; margin-top: 8px;">Daftar quiz dari modul yang telah atau sedang Anda pelajari.</p>
    </div>
    
    <div id="quizListContainer" style="display:flex; flex-direction:column; gap:16px;">
       <div style="text-align:center; padding: 40px; color:var(--c-text-muted);">
          Memuat data quiz...
       </div>
    </div>
  </div>
</div>

<script>
window.guruverseQuizData = {};

function loadQuizList() {
    const container = document.getElementById('quizListContainer');
    
    fetch('api/get_all_quizzes.php')
      .then(res => res.json())
      .then(res => {
        if (res.success && res.courses) {
          window.guruverseQuizData = {};
          let html = '<div style="display:grid;grid-template-columns:repeat(3, 1fr);gap:20px;">';
          let totalQuizzes = 0;
          
          res.courses.forEach(courseItem => {
              let course = courseItem.course;
              window.guruverseQuizData[course.id] = courseItem;
              let modules = courseItem.modules;
              let hasQuizInCourse = false;
              let courseQuizCount = 0;
              
              modules.forEach(mod => {
                  if (mod.quiz_data && mod.quiz_data.length > 0) {
                      hasQuizInCourse = true;
                      totalQuizzes++;
                      courseQuizCount++;
                  }
              });
              
              if (hasQuizInCourse) {
                  html += `
                  <div class="card p-0 overflow-hidden" style="display:flex;flex-direction:column;">
                    <div style="height:140px;background:linear-gradient(135deg,var(--c-primary-light),var(--c-primary));position:relative;">
                      <div style="position:absolute;top:12px;right:12px;background:rgba(255,255,255,0.2);backdrop-filter:blur(4px);color:#fff;font-size:10px;font-weight:800;padding:4px 10px;border-radius:20px;">
                        ${course.category || 'Kelas'}
                      </div>
                    </div>
                    <div style="padding:16px;flex:1;display:flex;flex-direction:column;">
                      <h3 style="font-size:15px;font-weight:800;margin-bottom:8px;line-height:1.4">${course.title}</h3>
                      <div style="font-size:12px;color:var(--c-text-muted);margin-bottom:16px;display:flex;gap:12px;">
                        <span style="display:flex;align-items:center;gap:4px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg> 
                            ${course.duration_hours || 0} Jam
                        </span>
                        <span style="display:flex;align-items:center;gap:4px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg> 
                            ${courseQuizCount} Evaluasi
                        </span>
                      </div>
                      <div style="margin-top:auto;">
                        <button class="btn btn-outline btn-sm" style="width:100%; cursor:pointer;" onclick="window.openQuizListPage('${course.id}')">Lihat Daftar Quiz</button>
                      </div>
                    </div>
                  </div>`;
              }
          });
          
          html += `</div>`;
          
          if (totalQuizzes === 0) {
              container.innerHTML = `<div style="text-align:center; padding: 40px; color:var(--c-text-muted);">Belum ada quiz yang tersedia untuk kelas yang Anda pelajari.</div>`;
          } else {
              container.innerHTML = html;
          }
        } else {
          container.innerHTML = `<div style="text-align:center; padding: 40px; color:var(--c-text-muted);">Gagal memuat data quiz.</div>`;
        }
      })
      .catch(err => {
          container.innerHTML = `<div style="text-align:center; padding: 40px; color:var(--c-text-muted);">Terjadi kesalahan koneksi.</div>`;
      });
}

window.openCoursePlayerAndStartQuiz = function(courseId, modIndex) {
    const courseItem = window.guruverseQuizData[courseId];
    if (!courseItem) {
        alert('Data kelas tidak ditemukan!');
        return;
    }
    
    cpCurrentCourse = courseItem.course;
    cpModules = courseItem.modules;
    cpCurrentModIndex = modIndex;
    startCpQuiz();
    return;
    
    // Fallback
    fetch('api/get_course_modules.php?course_id=' + courseId)
      .then(res => res.json())
      .then(res => {
          if (res.success) {
              cpCurrentCourse = res.course;
              cpModules = res.modules;
              cpCurrentModIndex = modIndex;
              startCpQuiz();
          } else {
              gbShowAlert('Gagal', 'Gagal memuat data kelas.', 'error');
          }
      })
      .catch(err => {
          gbShowAlert('Error', 'Gagal terhubung ke server.', 'error');
      });
}

window.showQuizResult = function(courseId, modNumber) {
    const courseItem = window.guruverseQuizData[courseId];
    if (!courseItem) {
        alert('Data kelas tidak ditemukan untuk ID: ' + courseId);
        return;
    }
    const mod = courseItem.modules.find(m => String(m.module_number) === String(modNumber));
    if (!mod || !mod.quiz_data) {
        alert('Data modul atau quiz tidak ditemukan untuk modul: ' + modNumber);
        return;
    }
    
    fetch(`api/get_quiz_result.php?course_id=${courseId}&module_number=${modNumber}`)
      .then(res => res.json())
      .then(res => {
          if (res.success) {
              window.renderQuizResultModal(res.score, res.answers, mod.quiz_data, courseId, modNumber, mod.title);
          } else {
              let html = `
              <div style="text-align:center; padding:10px 0;">
                  <div style="margin-bottom:24px; font-size:14px; color:var(--c-text-muted);">Anda belum memiliki hasil tersimpan untuk kuis ini.</div>
                  <button class="btn btn-primary" style="width:100%;" onclick="window.openCoursePlayerAndStartQuiz('${courseId}', ${modNumber - 1})">Kerjakan Quiz Sekarang</button>
              </div>`;
              document.getElementById('qr-content-container').innerHTML = html;
              document.getElementById('qr-module-title').innerText = mod.title || ('Modul ' + modNumber);
              
              const backBtn = document.getElementById('qr-btn-back');
              backBtn.onclick = function() {
                  window.openQuizListPage(courseId);
              };
              showPage('quiz-result');
          }
      })
      .catch(err => {
          alert('Terjadi kesalahan koneksi saat memuat hasil kuis.');
      });
}

window.renderQuizResultModal = function(score, userAnswers, quizData, courseId, modNumber, modTitle) {
    let html = `
    <div style="background:var(--c-card); border:1px solid var(--c-border); border-radius:12px; padding:32px 24px; margin-bottom:24px;">
        <div style="text-align:center; margin-bottom:32px;">
            <div style="font-size:56px; font-weight:900; color:${score >= 100 ? '#4ade80' : '#f87171'}; line-height:1;">${score}</div>
            <div style="font-size:12px; color:var(--c-text-muted); font-weight:700; letter-spacing:1px; margin-top:8px;">NILAI AKHIR</div>
        </div>
        
        <div style="display:flex; flex-direction:column; gap:16px;">`;
    
    quizData.forEach((q, idx) => {
        let userAns = userAnswers[idx];
        let isCorrect = userAns === q.answer;
        
        let optsHtml = '';
        q.options.forEach(opt => {
            let bg = 'transparent';
            let color = 'var(--c-text-muted)';
            let border = '1px solid var(--c-border)';
            let check = '';
            
            if (opt.id === q.answer) {
                bg = 'rgba(74, 222, 128, 0.1)';
                color = '#4ade80';
                border = '1px solid rgba(74, 222, 128, 0.5)';
                check = ' ✓';
            } else if (opt.id === userAns && !isCorrect) {
                bg = 'rgba(248, 113, 113, 0.1)';
                color = '#f87171';
                border = '1px solid rgba(248, 113, 113, 0.5)';
                check = ' ✗';
            }
            
            optsHtml += `<div style="padding:12px 16px; border-radius:8px; background:${bg}; border:${border}; color:${color}; font-size:13px; margin-bottom:8px;">${opt.text}${check}</div>`;
        });
        
        html += `
        <div style="background:var(--c-bg); border:1px solid var(--c-border); padding:20px; border-radius:12px;">
            <h4 style="font-size:14px; font-weight:700; margin:0 0 16px 0; color:var(--c-text);">Soal ${idx + 1}: ${q.question}</h4>
            ${optsHtml}
        </div>`;
    });
    
    html += `
        </div>
    </div>
    
    <div style="margin-top:24px; text-align:center;">
        <button class="btn btn-primary" style="padding:12px 32px; font-size:14px; border-radius:8px; font-weight:600;" onclick="window.openCoursePlayerAndStartQuiz('${courseId}', ${modNumber - 1})">Kerjakan Ulang Quiz</button>
    </div>`;
    
    document.getElementById('qr-content-container').innerHTML = html;
    document.getElementById('qr-module-title').innerText = modTitle || ('Modul ' + modNumber);
    
    // Set up back button
    const backBtn = document.getElementById('qr-btn-back');
    backBtn.onclick = function() {
        window.openQuizListPage(courseId);
    };
    
    // Show page
    showPage('quiz-result');
}

// Hook into page load
document.addEventListener('DOMContentLoaded', () => {
    const originalShowPage = window.showPage;
    window.showPage = function(name, updateHash = true) {
        originalShowPage(name, updateHash);
        if (name === 'quiz') {
            loadQuizList();
        }
    };
});
</script>
