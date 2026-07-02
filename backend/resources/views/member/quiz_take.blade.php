@extends('layouts.member')

@section('title', ucwords(str_replace('_', ' ', 'quiz_take')))

@section('content')

<div class="page active" id="page-quiz-take" style="background:var(--c-bg); min-height:100vh; padding-top:0 !important;">
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
@endsection

@section('scripts')
<script>
  let cpCurrentCourse = null;
  let cpModules = [];
  let cpCurrentMod = null;
  let cpCurrentQuizData = [];
  let qtCurrentQIdx = 0;
  let qtUserAnswers = {};
  let qtDoubtful = {};
  let qtTimerInterval = null;
  let qtTimeLeft = 45 * 60; // 45 minutes

  function initQuizTake() {
      const params = new URLSearchParams(window.location.search);
      const courseId = params.get('course_id');
      const moduleNumber = parseInt(params.get('module_number') || 0);

      if (!courseId || !moduleNumber) {
          alert('Parameter kuis tidak valid!');
          window.location.href = '{{ route("member.kelas") }}';
          return;
      }

      fetch('/api/get_course_modules.php?course_id=' + courseId)
        .then(res => res.json())
        .then(res => {
            if (res.success) {
                cpCurrentCourse = res.course;
                cpModules = res.modules;
                cpCurrentMod = cpModules.find(m => parseInt(m.module_number) === moduleNumber);

                if (!cpCurrentMod || !cpCurrentMod.quiz_data || cpCurrentMod.quiz_data.length === 0) {
                    alert('Kuis tidak ditemukan atau kuis kosong!');
                    window.location.href = `/modul?course_id=${courseId}`;
                    return;
                }

                cpCurrentQuizData = cpCurrentMod.quiz_data;
                qtCurrentQIdx = 0;
                qtUserAnswers = {};
                qtDoubtful = {};
                qtTimeLeft = 45 * 60; // 45 minutes

                // Start timer
                if (qtTimerInterval) clearInterval(qtTimerInterval);
                qtUpdateTimerDisplay();
                qtTimerInterval = setInterval(() => {
                    qtTimeLeft--;
                    if (qtTimeLeft <= 0) {
                        clearInterval(qtTimerInterval);
                        alert('Waktu kuis habis! Jawaban Anda akan disubmit otomatis.');
                        submitCpQuizAnswers();
                    } else {
                        qtUpdateTimerDisplay();
                    }
                }, 1000);

                qtRenderGrid();
                qtRenderQuestion(0);
            } else {
                alert('Gagal memuat kuis: ' + res.message);
                window.location.href = '{{ route("member.kelas") }}';
            }
        })
        .catch(err => {
            alert('Kesalahan koneksi saat memuat kuis.');
            window.location.href = '{{ route("member.kelas") }}';
        });
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
          window.location.href = `/modul?course_id=${cpCurrentCourse.id}`;
      });
  }

  function submitCpQuizAnswers() {
      if(qtTimerInterval) clearInterval(qtTimerInterval);
      
      let correct = 0;
      let total = cpCurrentQuizData.length;
      
      cpCurrentQuizData.forEach((q, idx) => {
          let selectedId = qtUserAnswers[idx];
          if (selectedId === q.answer) correct++;
      });
      
      let score = Math.round((correct / total) * 100);
      
      submitCpQuizAPI(cpCurrentMod, score, qtUserAnswers);
  }

  function submitCpQuizAPI(mod, score = 100, answers = {}) {
      const formData = new FormData();
      formData.append('course_id', cpCurrentCourse.id);
      formData.append('module_number', mod.module_number);
      formData.append('score', score);
      formData.append('answers_json', JSON.stringify(answers));

      // Get CSRF Token from meta tag
      const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      
      fetch('/api/complete_module.php', {
          method: 'POST',
          headers: {
              'X-CSRF-TOKEN': csrfToken
          },
          body: formData
      }).then(res => res.json())
        .then(res => {
            if(res.success) {
                if (score >= 75) { 
                    gbShowAlert('Lulus! 🎉', `Selamat! Anda lulus dengan nilai ${score}. Modul berikutnya telah dibuka!`, 'success');
                } else {
                    gbShowAlert('Belum Lulus 😢', `Nilai Anda ${score}. Minimal kelulusan adalah 75. Silakan coba lagi.`, 'error');
                }
                
                // Redirect back to modul page after alert OK is clicked
                document.getElementById('gbModalOk').onclick = function() {
                    window.location.href = `/modul?course_id=${cpCurrentCourse.id}`;
                };
            } else {
                alert('Gagal menyimpan progress: ' + (res.message || 'Unknown error'));
            }
        })
        .catch(err => {
            console.error(err);
            alert('Kesalahan saat menyimpan progress kuis.');
        });
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

  // Load kuis when ready
  document.addEventListener('DOMContentLoaded', initQuizTake);
</script>
@endsection