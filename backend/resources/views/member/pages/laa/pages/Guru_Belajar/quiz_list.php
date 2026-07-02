<div class="page" id="page-quiz-list" style="background:var(--c-bg); min-height:100vh; padding-top:0 !important;">
  <div style="max-width: 900px; margin: 0 auto; padding: 40px 24px;">
  <div style="display:flex; align-items:flex-start; gap:16px; margin-bottom:32px; flex-wrap:wrap;">
    <button class="btn btn-outline" onclick="showPage('quiz')" style="display:inline-flex; align-items:center; gap:8px; padding:10px 16px; border-radius:8px; flex-shrink:0;">
      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5"/><polyline points="12 19 5 12 12 5"/></svg>
      Kembali
    </button>
    <div style="flex:1; min-width:250px;">
      <h1 class="t-h2" id="ql-course-title" style="margin:0 0 4px 0; font-size:24px; font-weight:800; color:var(--c-text); line-height:1.3;">Daftar Evaluasi & Quiz</h1>
      <p class="t-body t-muted" id="ql-course-category" style="margin:0; font-size:14px; font-weight:600;">Kategori Kelas</p>
    </div>
  </div>

  <div id="ql-modules-container" style="display:flex; flex-direction:column; gap:16px;">
    <!-- Modules will be injected here via JS -->
  </div>
  </div>
</div>

<script>
window.openQuizListPage = function(courseId) {
    const courseItem = window.guruverseQuizData[courseId];
    if (!courseItem) {
        const availableIds = Object.keys(window.guruverseQuizData).join(', ');
        alert(`Terjadi kesalahan: Data kelas tidak ditemukan.\nMencari ID: ${courseId}\nID yang tersedia: ${availableIds}`);
        return;
    }
    
    // Update Header Text
    document.getElementById('ql-course-title').innerText = courseItem.course.title;
    document.getElementById('ql-course-category').innerText = courseItem.course.category || 'Kelas';
    
    const container = document.getElementById('ql-modules-container');
    let html = '';
    
    let hasQuiz = false;
    courseItem.modules.forEach(mod => {
        if (mod.quiz_data && mod.quiz_data.length > 0) {
            hasQuiz = true;
            const isLocked = mod.is_locked;
            const isCompleted = mod.is_completed;
            
            let statusBadge = '';
            let btnHtml = '';
            
            if (isCompleted) {
                statusBadge = '<span style="font-size:12px; padding:4px 10px; border-radius:20px; background:rgba(74, 222, 128, 0.15); color:#4ade80; font-weight:700; border:1px solid rgba(74, 222, 128, 0.3);">Selesai</span>';
                btnHtml = `<button class="btn btn-outline" style="font-size:13px; padding:8px 24px; border-radius:8px;" onclick="window.showQuizResult('${courseItem.course.id}', '${mod.module_number}')">Lihat Hasil</button>`;
            } else if (isLocked) {
                statusBadge = '<span style="font-size:12px; padding:4px 10px; border-radius:20px; background:rgba(156, 163, 175, 0.15); color:var(--c-text-muted); font-weight:700; border:1px solid rgba(156, 163, 175, 0.3);">Terkunci</span>';
                btnHtml = `<button class="btn btn-outline" disabled style="font-size:13px; padding:8px 24px; border-radius:8px; opacity:0.5; cursor:not-allowed;">Kerjakan</button>`;
            } else {
                statusBadge = '<span style="font-size:12px; padding:4px 10px; border-radius:20px; background:rgba(91, 108, 249, 0.15); color:var(--c-primary); font-weight:700; border:1px solid rgba(91, 108, 249, 0.3);">Tersedia</span>';
                btnHtml = `<button class="btn btn-primary" style="font-size:13px; padding:8px 24px; border-radius:8px;" onclick="window.openCoursePlayerAndStartQuiz('${courseItem.course.id}', '${mod.module_number - 1}')">Kerjakan</button>`;
            }
            
            html += `
            <div style="background:var(--c-card); border:1px solid var(--c-border); border-radius:12px; padding:20px 24px; display:flex; flex-direction:row; align-items:center; justify-content:space-between; gap:16px; margin-bottom:12px; transition:all 0.3s ease;">
               <div style="display:flex; flex-direction:column; gap:8px; text-align:left;">
                  <h3 style="font-size:16px; font-weight:700; color:var(--c-text); margin:0; line-height:1.4;">${mod.title || 'Modul ' + mod.module_number}</h3>
                  <div style="display:flex;">
                    ${statusBadge}
                  </div>
               </div>
               <div style="flex-shrink:0;">
                  ${btnHtml}
               </div>
            </div>`;
        }
    });
    
    if (!hasQuiz) {
        html = `<div style="text-align:center; padding: 40px; color:var(--c-text-muted); border:1px solid var(--c-border); border-radius:12px;">Belum ada evaluasi untuk kelas ini.</div>`;
    }
    
    container.innerHTML = html;
    
    // Switch to page
    showPage('quiz-list');
};
</script>
