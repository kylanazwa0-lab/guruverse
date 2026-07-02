<?php /* Detail Topik Forum Diskusi — Guru Inspira */ ?>
<div class="page" id="page-forum-thread" style="animation: fadeIn 0.3s ease-out;">

  <!-- Back Button -->
  <div class="mb-20">
    <button class="btn btn-ghost btn-sm" onclick="showPage('forum')">
      <i class="ti ti-arrow-left"></i> Kembali ke Forum
    </button>
  </div>

  <!-- Main Thread Card -->
  <div class="card mb-20">
    <div class="card-body-lg">

      <!-- Loading -->
      <div id="threadLoading" style="text-align:center; padding:40px;">
        <div class="spinner"></div>
      </div>

      <!-- Content -->
      <div id="threadContentContainer" style="display:none;">

        <!-- Header: Category badge + time -->
        <div class="flex items-center justify-between mb-16">
          <span id="threadCategory" class="badge badge-primary">Kategori</span>
          <span id="threadTime" class="t-xs t-muted flex items-center gap-4">
            <i class="ti ti-clock"></i> baru saja
          </span>
        </div>

        <!-- Title -->
        <h2 id="threadTitle" class="t-h1 fw-800" style="color:var(--c-text); margin-bottom:20px; line-height:1.4;">
          Judul Thread
        </h2>

        <!-- Author -->
        <div class="flex items-center gap-12 mb-24 pb-20" style="border-bottom:1px solid var(--c-border);">
          <div id="threadAuthorAvatar" class="avatar avatar-lg" style="background:linear-gradient(135deg, var(--c-primary), var(--c-primary-light)); color:#fff; font-size:16px;">
            US
          </div>
          <div>
            <div id="threadAuthorName" class="t-md fw-700" style="color:var(--c-text);">Nama Pengguna</div>
            <div class="t-xs t-muted">Penulis Topik</div>
          </div>
        </div>

        <!-- Body -->
        <div id="threadBody" class="t-body" style="color:var(--c-text); line-height:1.75; white-space:pre-wrap; font-size:15px;">
          Isi thread akan muncul di sini...
        </div>

      </div>
    </div>
  </div>

  <!-- Replies Section -->
  <div class="mb-20">
    <div class="section-head">
      <h3 class="t-h3 fw-800" style="color:var(--c-text);">
        Balasan (<span id="replyCount">0</span>)
      </h3>
    </div>

    <div id="threadRepliesList" style="display:flex; flex-direction:column; gap:12px;">
      <!-- Replies rendered by JS -->
    </div>
  </div>

  <!-- Write Reply Box -->
  <div class="card card-body">
    <h4 class="t-md fw-700 mb-12" style="color:var(--c-text);">Tulis Balasan</h4>
    <textarea id="replyContent" class="form-control mb-12" rows="4" placeholder="Tulis komentar atau jawaban Anda di sini..."></textarea>
    <div style="text-align:right;">
      <button class="btn btn-primary" onclick="submitReply()">
        <i class="ti ti-send"></i> Kirim Balasan
      </button>
    </div>
  </div>

</div>

<script>
function loadThreadDetail(threadId) {
    document.getElementById('threadContentContainer').style.display = 'none';
    document.getElementById('threadLoading').style.display = 'block';

    fetch('api_forum.php?action=get_thread_detail&id=' + threadId)
    .then(r => r.json())
    .then(res => {
        if(res.status === 'success') {
            const t = res.data.thread;
            const r = res.data.replies;

            document.getElementById('threadCategory').textContent = t.forum_name;
            document.getElementById('threadCategory').style.background = t.warna_bg;
            document.getElementById('threadTime').innerHTML = '<i class="ti ti-clock"></i> ' + t.time_ago;
            document.getElementById('threadTitle').textContent = t.judul;
            document.getElementById('threadAuthorAvatar').textContent = t.author_initials;
            document.getElementById('threadAuthorName').textContent = t.author_name;
            document.getElementById('threadBody').innerHTML = t.konten;
            document.getElementById('replyCount').textContent = r.length;

            const repliesList = document.getElementById('threadRepliesList');
            if(r.length === 0) {
                repliesList.innerHTML = `<div style="text-align:center; padding:32px; background:var(--c-bg); border-radius:12px; border:1px dashed var(--c-border);">
                    <div style="font-size:32px; margin-bottom:8px;">💬</div>
                    <div class="t-sm fw-700" style="color:var(--c-text); margin-bottom:4px;">Belum ada balasan</div>
                    <p class="t-xs t-muted">Jadilah yang pertama membalas topik ini!</p>
                </div>`;
            } else {
                let html = '';
                r.forEach(reply => {
                    html += `
                    <div class="card" style="padding:20px;">
                        <div class="flex items-start gap-12">
                            <div class="avatar avatar-md" style="background:var(--c-primary-pale); color:var(--c-primary); font-size:13px; font-weight:700; flex-shrink:0;">
                                ${reply.author_initials}
                            </div>
                            <div style="flex:1;">
                                <div class="flex items-center gap-8 mb-6">
                                    <span class="t-sm fw-700" style="color:var(--c-text);">${reply.author_name}</span>
                                    <span class="t-xs t-muted">${reply.time_ago}</span>
                                </div>
                                <div class="t-body" style="color:var(--c-text); line-height:1.65;">
                                    ${reply.konten}
                                </div>
                            </div>
                        </div>
                    </div>`;
                });
                repliesList.innerHTML = html;
            }

            document.getElementById('threadLoading').style.display = 'none';
            document.getElementById('threadContentContainer').style.display = 'block';
        } else {
            gbShowAlert('Error', 'Gagal memuat diskusi: ' + res.message, 'error');
            showPage('forum');
        }
    })
    .catch(err => console.error(err));
}

function submitReply() {
    const threadId = window.currentInspiraThreadId;
    const konten = document.getElementById('replyContent').value.trim();

    if(!konten) {
        gbShowAlert('Oopss', 'Komentar tidak boleh kosong', 'error');
        return;
    }

    const fd = new FormData();
    fd.append('thread_id', threadId);
    fd.append('konten', konten);

    fetch('api_forum.php?action=create_reply', {
        method: 'POST',
        body: fd
    }).then(r => r.json()).then(res => {
        if(res.status === 'success') {
            document.getElementById('replyContent').value = '';
            loadThreadDetail(threadId);
            gbShowAlert('Berhasil', 'Balasan Anda berhasil dikirim', 'success');
        } else {
            gbShowAlert('Error', res.message, 'error');
        }
    }).catch(err => console.error(err));
}
</script>
