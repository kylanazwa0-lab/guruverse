<div class="page" id="page-diskusi_detail">
<style>
/* ── Diskusi Detail Styles ── */
.dd-header {
  background: var(--c-card); border: 1px solid var(--c-border);
  border-radius: 16px; padding: 24px; margin-bottom: 20px;
  position: relative;
}
.dd-back-btn {
  display: inline-flex; align-items: center; gap: 8px;
  font-size: 13px; font-weight: 700; color: var(--c-text-muted);
  background: transparent; border: none; cursor: pointer;
  margin-bottom: 16px; transition: color 0.15s;
}
.dd-back-btn:hover { color: var(--c-primary); }
.dd-topic-title {
  font-size: 20px; font-weight: 800; color: var(--c-text);
  line-height: 1.4; margin-bottom: 12px;
}
.dd-topic-meta {
  display: flex; align-items: center; gap: 12px; flex-wrap: wrap;
  font-size: 12px; color: var(--c-text-muted); font-weight: 600;
  margin-bottom: 16px; padding-bottom: 16px; border-bottom: 1px solid var(--c-border-light);
}
.dd-topic-meta-item { display: flex; align-items: center; gap: 4px; }
.dd-topic-body {
  font-size: 14px; color: var(--c-text); line-height: 1.65;
  white-space: pre-wrap;
}

/* ── Comments Section ── */
.dd-replies-container {
  display: flex; flex-direction: column; gap: 16px;
  margin-bottom: 40px;
}
.dd-reply-card {
  background: var(--c-card); border: 1px solid var(--c-border);
  border-radius: 12px; padding: 16px;
  display: flex; gap: 16px;
}
.dd-reply-avatar {
  width: 40px; height: 40px; border-radius: 50%;
  background: linear-gradient(135deg, var(--c-primary), var(--c-primary-light));
  display: flex; align-items: center; justify-content: center;
  font-size: 14px; font-weight: 800; color: #fff; flex-shrink: 0;
}
.dd-reply-avatar img { width:100%; height:100%; object-fit:cover; border-radius:50%; }
.dd-reply-content { flex: 1; min-width: 0; }
.dd-reply-header {
  display: flex; justify-content: space-between; align-items: center;
  margin-bottom: 6px;
}
.dd-reply-author { font-size: 13px; font-weight: 700; color: var(--c-text); }
.dd-reply-time { font-size: 11px; font-weight: 600; color: var(--c-text-muted); }
.dd-reply-body {
  font-size: 13px; color: var(--c-text); line-height: 1.6;
  white-space: pre-wrap;
}
.dd-reply-empty {
  text-align: center; padding: 40px 20px; color: var(--c-text-muted);
  font-size: 14px; font-weight: 600;
  background: var(--c-card); border-radius: 12px; border: 1px dashed var(--c-border);
}

/* ── Reply Input Box ── */
.dd-input-box {
  background: var(--c-card); border: 1px solid var(--c-border);
  border-radius: 16px; padding: 20px;
  box-shadow: 0 4px 20px rgba(0,0,0,0.04);
}
.dd-input-textarea {
  width: 100%; border: 1.5px solid var(--c-border); border-radius: 12px;
  padding: 14px; font-size: 13px; font-family: var(--font);
  color: var(--c-text); resize: vertical; min-height: 100px;
  outline: none; transition: border-color 0.2s;
  margin-bottom: 12px;
  background: transparent;
}
.dd-input-textarea:focus {
  border-color: var(--c-primary-light);
  box-shadow: 0 0 0 3px rgba(108,92,231,0.1);
}
.dd-input-actions {
  display: flex; justify-content: flex-end;
}
</style>

<div style="max-width: 800px; margin: 0 auto; padding-bottom: 40px;">
    <!-- Topic Header -->
    <div class="dd-header">
        <button class="dd-back-btn" onclick="showPage('diskusi')">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Kembali ke Daftar Topik
        </button>
        <div id="ddTopicLoading" style="text-align:center; padding: 40px 0;">
            <div class="spinner-border text-primary" role="status"></div>
            <p style="margin-top: 10px; font-weight: 600; color: var(--c-text-muted)">Memuat diskusi...</p>
        </div>
        <div id="ddTopicContent" style="display: none;">
            <div class="topic-tag" id="ddTopicCategory" style="display:inline-block; margin-bottom: 10px;"></div>
            <h1 class="dd-topic-title" id="ddTopicTitle"></h1>
            <div class="dd-topic-meta">
                <div class="dd-topic-meta-item">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    <span id="ddTopicAuthor"></span>
                </div>
                <div class="dd-topic-meta-item">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    <span id="ddTopicDate"></span>
                </div>
            </div>
            <div class="dd-topic-body" id="ddTopicBody"></div>
        </div>
    </div>

    <!-- Replies List -->
    <h3 style="font-size: 16px; font-weight: 800; color: var(--c-text); margin-bottom: 16px;">
        Komentar & Balasan (<span id="ddReplyCount">0</span>)
    </h3>
    <div class="dd-replies-container" id="ddRepliesContainer">
        <!-- Injected via JS -->
    </div>

    <!-- Reply Input -->
    <div class="dd-input-box">
        <h4 style="font-size: 14px; font-weight: 700; margin-bottom: 12px; color: var(--c-text)">Tulis Balasan Anda</h4>
        <textarea class="dd-input-textarea" id="ddReplyInput" placeholder="Ketik jawaban atau pendapat Anda di sini..."></textarea>
        <div class="dd-input-actions">
            <button class="btn btn-primary" id="ddBtnSubmitReply" onclick="submitReply()">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right:8px"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                Kirim Balasan
            </button>
        </div>
    </div>
</div>
</div><!-- /page-diskusi_detail -->

<script>
let currentDiscussionId = null;

function getInitials(name) {
    if (!name) return 'U';
    const parts = name.split(' ');
    let init = parts[0].charAt(0).toUpperCase();
    if (parts.length > 1) {
        init += parts[1].charAt(0).toUpperCase();
    }
    return init;
}

function formatDateFull(dateStr) {
    if (!dateStr) return '';
    const d = new Date(dateStr);
    return d.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute:'2-digit' });
}

function openDiskusiDetail(topicId) {
    currentDiscussionId = topicId;
    
    // Switch to page
    showPage('diskusi_detail');
    
    // Reset UI
    document.getElementById('ddTopicLoading').style.display = 'block';
    document.getElementById('ddTopicContent').style.display = 'none';
    document.getElementById('ddRepliesContainer').innerHTML = '';
    document.getElementById('ddReplyInput').value = '';
    
    // Fetch data
    fetch('pages/Guru_Belajar/diskusi_detail_api.php?id=' + topicId)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                renderDiskusiDetail(data.topic, data.replies);
            } else {
                gbShowAlert('Gagal Memuat', data.message || 'Diskusi tidak ditemukan.', 'error');
                showPage('diskusi');
            }
        })
        .catch(err => {
            gbShowAlert('Error Koneksi', 'Gagal memuat detail diskusi.', 'error');
            showPage('diskusi');
        });
}

function renderDiskusiDetail(topic, replies) {
    document.getElementById('ddTopicLoading').style.display = 'none';
    document.getElementById('ddTopicContent').style.display = 'block';
    
    document.getElementById('ddTopicCategory').textContent = topic.category || 'Umum';
    document.getElementById('ddTopicTitle').textContent = topic.title;
    document.getElementById('ddTopicAuthor').textContent = topic.author_name || 'Member';
    document.getElementById('ddTopicDate').textContent = formatDateFull(topic.created_at);
    document.getElementById('ddTopicBody').textContent = topic.body;
    
    document.getElementById('ddReplyCount').textContent = replies.length;
    
    const container = document.getElementById('ddRepliesContainer');
    container.innerHTML = '';
    
    if (replies.length === 0) {
        container.innerHTML = `<div class="dd-reply-empty">Belum ada balasan untuk topik ini. Jadilah yang pertama berkomentar!</div>`;
        return;
    }
    
    let html = '';
    replies.forEach(r => {
        const author = r.replier_name || 'Member';
        let avatarHtml = '';
        if (r.photo_path) {
            avatarHtml = `<img src="../../${r.photo_path}" alt="Avatar">`;
        } else {
            avatarHtml = getInitials(author);
        }
        
        // Escape HTML for safety
        const safeBody = r.body.replace(/</g, "&lt;").replace(/>/g, "&gt;");
        
        html += `
        <div class="dd-reply-card">
            <div class="dd-reply-avatar">${avatarHtml}</div>
            <div class="dd-reply-content">
                <div class="dd-reply-header">
                    <span class="dd-reply-author">${author}</span>
                    <span class="dd-reply-time">${formatDateFull(r.created_at)}</span>
                </div>
                <div class="dd-reply-body">${safeBody}</div>
            </div>
        </div>`;
    });
    
    container.innerHTML = html;
}

function submitReply() {
    if (!currentDiscussionId) return;
    
    const bodyText = document.getElementById('ddReplyInput').value.trim();
    if (!bodyText) {
        gbShowAlert('Peringatan', 'Komentar tidak boleh kosong.', 'info');
        return;
    }
    
    const btn = document.getElementById('ddBtnSubmitReply');
    const originalText = btn.innerHTML;
    btn.innerHTML = 'Mengirim...';
    btn.disabled = true;
    
    const fd = new FormData();
    fd.append('discussion_id', currentDiscussionId);
    fd.append('body', bodyText);
    
    fetch('pages/Guru_Belajar/diskusi_reply_submit.php', {
        method: 'POST',
        body: fd
    })
    .then(res => res.json())
    .then(data => {
        btn.innerHTML = originalText;
        btn.disabled = false;
        if (data.success) {
            // Reload discussion to get new reply
            openDiskusiDetail(currentDiscussionId);
        } else {
            gbShowAlert('Gagal', data.message || 'Gagal mengirim komentar.', 'error');
        }
    })
    .catch(err => {
        btn.innerHTML = originalText;
        btn.disabled = false;
        gbShowAlert('Error Koneksi', 'Gagal mengirim komentar.', 'error');
    });
}
</script>
