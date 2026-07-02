<?php
// ── Query Diskusi (hanya dimuat dari halaman ini) ─────────────────────────
$discussions = [];
$res = $conn->query("SELECT d.*, m.full_name as author_name
    FROM gb_discussions d
    LEFT JOIN members m ON d.user_id = m.id
    ORDER BY d.created_at DESC LIMIT 20");
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $discussions[] = $row;
    }
}
?>
<div class="page" id="page-diskusi">
<style>
/* ── Diskusi Page Styles ───────────────────── */
.diskusi-hero {
  background: linear-gradient(135deg, #1e1b4b 0%, #312e81 45%, #4c1d95 100%);
  border-radius: 20px;
  padding: 32px 36px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 24px;
  margin-bottom: 24px;
  position: relative;
  overflow: hidden;
}
.diskusi-hero::before {
  content: '';
  position: absolute;
  top: -60px; right: -40px;
  width: 220px; height: 220px;
  background: radial-gradient(circle, rgba(167,139,250,0.25) 0%, transparent 70%);
  pointer-events: none;
}
.diskusi-hero::after {
  content: '';
  position: absolute;
  bottom: -50px; left: 30%;
  width: 180px; height: 180px;
  background: radial-gradient(circle, rgba(99,102,241,0.2) 0%, transparent 70%);
  pointer-events: none;
}
.diskusi-hero-text { position: relative; z-index: 1; }
.diskusi-hero-text h1 { font-size: 26px; font-weight: 800; color: #fff; margin-bottom: 8px; letter-spacing: -0.4px; }
.diskusi-hero-text p  { font-size: 13px; color: rgba(255,255,255,0.72); line-height: 1.6; max-width: 400px; }
.diskusi-hero-stats {
  display: flex; gap: 20px; margin-top: 20px; position: relative; z-index: 1;
}
.diskusi-hero-stat {
  display: flex; align-items: center; gap: 8px;
  background: rgba(255,255,255,0.1);
  backdrop-filter: blur(8px);
  border: 1px solid rgba(255,255,255,0.15);
  border-radius: 50px;
  padding: 6px 14px;
  font-size: 12px; font-weight: 600; color: #fff;
}
.diskusi-hero-stat-dot { width: 7px; height: 7px; border-radius: 50%; }
.diskusi-hero-actions { position: relative; z-index: 1; flex-shrink: 0; display: flex; flex-direction: column; gap: 10px; align-items: flex-end; }

/* Filter Bar */
.diskusi-filter-bar {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 16px;
  flex-wrap: wrap;
  gap: 10px;
}
.diskusi-tabs { display: flex; gap: 4px; background: #f1f5f9; border-radius: 10px; padding: 4px; }
.diskusi-tab {
  padding: 6px 16px; border-radius: 8px; font-size: 13px; font-weight: 600;
  color: #64748b; cursor: pointer; transition: all 0.18s; border: none; background: transparent;
}
.diskusi-tab.active { background: var(--c-card); color: var(--c-primary); box-shadow: 0 1px 4px rgba(0,0,0,0.1); }
.diskusi-search-mini {
  display: flex; align-items: center; gap: 8px;
  background: var(--c-card); border: 1.5px solid var(--c-border); border-radius: 10px;
  padding: 7px 14px; font-size: 13px; color: var(--c-text-muted);
  transition: border-color 0.2s;
}
.diskusi-search-mini:focus-within { border-color: var(--c-primary-light); }
.diskusi-search-mini input { border: none; outline: none; font-size: 13px; color: var(--c-text); background: transparent; width: 160px; }

/* Topic Card */
.topic-list { display: flex; flex-direction: column; gap: 0; }
.topic-card {
  background: var(--c-card);
  border: 1px solid var(--c-border);
  border-radius: 0;
  padding: 16px 20px;
  display: flex;
  gap: 14px;
  cursor: pointer;
  transition: background 0.15s;
  border-bottom: none;
}
.topic-card:first-child { border-radius: 14px 14px 0 0; }
.topic-card:last-child  { border-radius: 0 0 14px 14px; border-bottom: 1px solid var(--c-border); }
.topic-card:only-child  { border-radius: 14px; border-bottom: 1px solid var(--c-border); }
.topic-card:hover { background: #f8faff; }
.topic-avatar {
  width: 38px; height: 38px; border-radius: 50%; flex-shrink: 0;
  background: linear-gradient(135deg, var(--c-primary), var(--c-primary-light));
  display: flex; align-items: center; justify-content: center;
  font-size: 13px; font-weight: 800; color: #fff;
}
.topic-body { flex: 1; min-width: 0; }
.topic-title {
  font-size: 14px; font-weight: 700; color: var(--c-text);
  margin-bottom: 4px; line-height: 1.4;
  white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.topic-excerpt { font-size: 12px; color: var(--c-text-muted); line-height: 1.5; margin-bottom: 8px; }
.topic-meta { display: flex; align-items: center; gap: 12px; font-size: 11px; color: var(--c-text-subtle); flex-wrap: wrap; }
.topic-meta-item { display: flex; align-items: center; gap: 4px; }
.topic-tag {
  padding: 2px 8px; border-radius: 20px; font-size: 10px; font-weight: 700;
  background: var(--c-primary-pale); color: var(--c-primary);
}
.topic-stats { display: flex; flex-direction: column; align-items: center; gap: 6px; flex-shrink: 0; text-align: center; }
.topic-reply-count { font-size: 18px; font-weight: 800; color: var(--c-primary); line-height: 1; }
.topic-reply-label { font-size: 10px; color: var(--c-text-subtle); font-weight: 500; }
.topic-pinned .topic-title::before {
  content: '📌 ';
}

/* Right Sidebar */
.diskusi-sidebar { display: flex; flex-direction: column; gap: 16px; }
.dsk-card { background: var(--c-card); border: 1px solid var(--c-border); border-radius: 16px; padding: 20px; }
.dsk-card-title { font-size: 13px; font-weight: 700; color: var(--c-text); margin-bottom: 14px; }

/* Tags */
.tag-cloud { display: flex; flex-wrap: wrap; gap: 6px; }
.tag-pill {
  padding: 4px 12px; border-radius: 50px; font-size: 11px; font-weight: 600;
  background: var(--c-bg); color: var(--c-text-muted); border: 1px solid var(--c-border);
  cursor: pointer; transition: all 0.15s;
}
.tag-pill:hover { background: var(--c-primary-pale); color: var(--c-primary); border-color: var(--c-primary-light); }

/* Modal */
.dsk-modal-overlay {
  display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.45);
  backdrop-filter: blur(4px); z-index: 1000; align-items: center; justify-content: center;
}
.dsk-modal-overlay.open { display: flex; }
.dsk-modal {
  background: var(--c-card); border-radius: 20px; width: 100%; max-width: 560px;
  padding: 28px; box-shadow: 0 20px 60px rgba(0,0,0,0.25);
  animation: modalIn 0.25s ease;
}
@keyframes modalIn { from { opacity:0; transform:translateY(20px) scale(0.97); } to { opacity:1; transform:none; } }
.dsk-modal-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
.dsk-modal-header h3 { font-size: 16px; font-weight: 800; }
.dsk-modal-close { width: 32px; height: 32px; border-radius: 8px; background: #f1f5f9; border: none; cursor: pointer; font-size: 16px; color: #64748b; display: flex; align-items: center; justify-content: center; }
.dsk-modal-close:hover { background: #e2e8f0; }
.dsk-form-group { margin-bottom: 16px; }
.dsk-form-label { font-size: 11px; font-weight: 700; color: var(--c-text-muted); text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 6px; }
.dsk-form-input {
  width: 100%; padding: 10px 14px; border: 1.5px solid var(--c-border); border-radius: 10px;
  font-size: 13px; font-family: var(--font); color: var(--c-text); outline: none; transition: all 0.2s;
}
.dsk-form-input:focus { border-color: var(--c-primary-light); box-shadow: 0 0 0 3px rgba(108,92,231,0.1); }
textarea.dsk-form-input { resize: vertical; min-height: 110px; }

/* Empty State */
.dsk-empty {
  text-align: center; padding: 60px 20px;
  background: var(--c-card); border: 2px dashed var(--c-border); border-radius: 16px;
}
.dsk-empty-icon {
  width: 64px; height: 64px; border-radius: 16px;
  background: linear-gradient(135deg, rgba(108,92,231,0.1), rgba(162,155,254,0.1));
  display: flex; align-items: center; justify-content: center;
  margin: 0 auto 20px; color: var(--c-primary);
}
</style>

<!-- ── Hero ─────────────────────────────────────── -->
<div class="diskusi-hero">
  <div class="diskusi-hero-text">
    <div style="display:inline-flex;align-items:center;gap:6px;background:rgba(255,255,255,0.12);border:1px solid rgba(255,255,255,0.2);border-radius:20px;padding:4px 14px;font-size:11px;font-weight:700;color:#fff;margin-bottom:14px;letter-spacing:.5px">
      <span style="width:6px;height:6px;border-radius:50%;background:#34d399;display:inline-block"></span>
      Komunitas Guru Aktif
    </div>
    <h1>Ruang Diskusi</h1>
    <p>Berbagi inspirasi, berdiskusi tentang metode mengajar, dan tumbuh bersama ribuan guru hebat dari seluruh Indonesia.</p>
    <div class="diskusi-hero-stats">
      <div class="diskusi-hero-stat">
        <span class="diskusi-hero-stat-dot" style="background:#60a5fa"></span>
        <?= count($discussions) ?> Topik
      </div>
      <div class="diskusi-hero-stat">
        <span class="diskusi-hero-stat-dot" style="background:#34d399"></span>
        Aktif Setiap Hari
      </div>
    </div>
  </div>
  <div class="diskusi-hero-actions">
    <button class="btn btn-white" onclick="openDiskusiModal()" style="font-size:13px;padding:10px 22px;border-radius:12px;font-weight:700;display:flex;align-items:center;gap:8px">
      <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      Buat Topik Baru
    </button>
  </div>
</div>

<!-- ── Main Content ──────────────────────────────── -->
<div style="display:grid;grid-template-columns:1fr 280px;gap:20px;align-items:start">

  <!-- Left: Topic Feed -->
  <div>
    <!-- Filter Bar -->
    <div class="diskusi-filter-bar">
      <div class="diskusi-tabs">
        <button class="diskusi-tab active" data-sort="semua">Semua</button>
        <button class="diskusi-tab" data-sort="terbaru">Terbaru</button>
        <button class="diskusi-tab" data-sort="populer">Populer</button>
      </div>
      <div class="diskusi-search-mini">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" placeholder="Cari topik diskusi..." id="diskusiSearch">
      </div>
    </div>

    <!-- Topic List -->
    <div class="topic-list" id="topicList">
      <?php if (empty($discussions)): ?>
        <div class="dsk-empty">
          <div class="dsk-empty-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
          </div>
          <h2 style="font-size:18px;font-weight:800;margin-bottom:10px;color:var(--c-text)">Belum ada diskusi</h2>
          <p style="font-size:13px;color:var(--c-text-muted);max-width:360px;margin:0 auto 24px;line-height:1.6">
            Jadilah yang pertama memulai percakapan! Bagikan pertanyaan atau pengalaman mengajar Anda dengan rekan guru lainnya.
          </p>
          <button class="btn btn-primary" onclick="openDiskusiModal()">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Mulai Diskusi Pertama
          </button>
        </div>
      <?php else: foreach ($discussions as $d): 
        $author_name = $d['author_name'] ?? 'Member';
        $parts = explode(' ', $author_name);
        $initials = strtoupper(substr($parts[0], 0, 1));
        if (count($parts) > 1) $initials .= strtoupper(substr($parts[1], 0, 1));
        $is_owner = ($d['user_id'] == $user_id);
      ?>
        <div class="topic-card" data-date="<?= $d['created_at'] ?>" data-replies="<?= intval($d['replies_count']) ?>" onclick="if(typeof openDiskusiDetail === 'function') openDiskusiDetail(<?= $d['id'] ?>)">
          <div class="topic-avatar"><?= $initials ?></div>
          <div class="topic-body">
            <div class="topic-title"><?= htmlspecialchars($d['title']) ?></div>
            <div class="topic-excerpt"><?= htmlspecialchars(substr($d['body'], 0, 120)) ?>...</div>
            <div class="topic-meta">
              <span class="topic-tag"><?= htmlspecialchars($d['category'] ?: 'Umum') ?></span>
              <div class="topic-meta-item">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                <?= htmlspecialchars($author_name) ?>
              </div>
              <div class="topic-meta-item">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                <?= date('d M Y', strtotime($d['created_at'])) ?>
              </div>
              
              <?php if ($is_owner): ?>
              <div class="topic-meta-item" onclick="event.stopPropagation(); deleteTopic(<?= $d['id'] ?>)" style="color:#ef4444;cursor:pointer;margin-left:auto;font-weight:700;display:flex;align-items:center;gap:4px">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
                Hapus
              </div>
              <?php endif; ?>
            </div>
          </div>
          <div class="topic-stats">
            <div class="topic-reply-count"><?= $d['replies_count'] ?></div>
            <div class="topic-reply-label">Balasan</div>
          </div>
        </div>
      <?php endforeach; endif; ?>
    </div>
  </div>

  <!-- Right Sidebar -->
  <div class="diskusi-sidebar">

    <!-- CTA: Buat Topik -->
    <div class="dsk-card" style="background:linear-gradient(135deg,#1e1b4b 0%,#4338ca 100%);border:none;text-align:center">
      <div style="width:48px;height:48px;background:rgba(255,255,255,0.15);border-radius:12px;display:flex;align-items:center;justify-content:center;margin:0 auto 12px">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
      </div>
      <h3 style="font-size:14px;font-weight:800;color:#fff;margin-bottom:6px">Mulai Diskusi</h3>
      <p style="font-size:11px;color:rgba(255,255,255,0.7);margin-bottom:16px;line-height:1.5">Bagikan pertanyaan atau pengalaman mengajar Anda.</p>
      <button class="btn btn-white btn-block btn-sm" onclick="openDiskusiModal()" style="font-weight:700">
        + Buat Topik Baru
      </button>
    </div>

    <!-- Panduan -->
    <div class="dsk-card">
      <div class="dsk-card-title">📋 Panduan Komunitas</div>
      <div style="display:flex;flex-direction:column;gap:10px">
        <?php foreach (['Gunakan bahasa yang sopan & positif', 'Saling menghargai setiap pendapat', 'Hindari konten SARA dan spam', 'Berikan sumber jika berbagi materi'] as $rule): ?>
          <div style="display:flex;align-items:flex-start;gap:8px;font-size:12px;color:var(--c-text-muted)">
            <div style="width:16px;height:16px;background:var(--c-success-pale);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px">
              <svg xmlns="http://www.w3.org/2000/svg" width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="var(--c-success)" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            <?= $rule ?>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Topik Populer Tags -->
    <div class="dsk-card">
      <div class="dsk-card-title">🏷️ Topik Populer</div>
      <div class="tag-cloud">
        <?php foreach (['Kurikulum Merdeka','RPP','P5','HOTS','Literasi Digital','Asesmen','Diferensiasi','Numerasi','PMM'] as $tag): ?>
          <span class="tag-pill" onclick="setDiskusiSearch('<?= $tag ?>')"><?= $tag ?></span>
        <?php endforeach; ?>
      </div>
    </div>

  </div>
</div>

<!-- ── Modal: Buat Topik ──────────────────────────── -->
<div class="dsk-modal-overlay" id="diskusiModal">
  <div class="dsk-modal">
    <div class="dsk-modal-header">
      <h3>💬 Buat Topik Diskusi Baru</h3>
      <button class="dsk-modal-close" onclick="closeDiskusiModal()">✕</button>
    </div>
    <form onsubmit="submitDiskusi(event)">
      <div class="dsk-form-group">
        <label class="dsk-form-label">Judul Topik</label>
        <input type="text" class="dsk-form-input" id="diskusiTitle" placeholder="Tulis judul topik yang menarik..." required>
      </div>
      <div class="dsk-form-group">
        <label class="dsk-form-label">Kategori</label>
        <select class="dsk-form-input" id="diskusiCategory">
          <option value="">Pilih Kategori</option>
          <option>Kurikulum Merdeka</option>
          <option>Metode Mengajar</option>
          <option>Asesmen & Evaluasi</option>
          <option>Teknologi Pendidikan</option>
          <option>Pengembangan Diri</option>
          <option>Lainnya</option>
        </select>
      </div>
      <div class="dsk-form-group">
        <label class="dsk-form-label">Isi Diskusi</label>
        <textarea class="dsk-form-input" id="diskusiContent" placeholder="Ceritakan pertanyaan atau pengalaman Anda secara detail..." required></textarea>
      </div>
      <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:4px">
        <button type="button" class="btn btn-ghost btn-sm" onclick="closeDiskusiModal()">Batal</button>
        <button type="submit" class="btn btn-primary btn-sm">
          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
          Kirim Topik
        </button>
      </div>
    </form>
  </div>
</div>

</div><!-- /page-diskusi -->

<script>
(function () {
  // ── Tabs with real sort logic ────────────────────────────────────
  document.querySelectorAll('#page-diskusi .diskusi-tab').forEach(function (tab) {
    tab.addEventListener('click', function () {
      document.querySelectorAll('#page-diskusi .diskusi-tab').forEach(function (t) { t.classList.remove('active'); });
      tab.classList.add('active');

      var sortBy = tab.dataset.sort || 'all';
      var list = document.getElementById('topicList');
      if (!list) return;
      var cards = Array.from(list.querySelectorAll('.topic-card'));

      cards.forEach(function(c) { c.style.display = ''; }); // show all first

      if (sortBy === 'terbaru') {
        cards.sort(function(a, b) {
          var da = a.dataset.date || '0';
          var db = b.dataset.date || '0';
          return db.localeCompare(da);
        });
        cards.forEach(function(c) { list.appendChild(c); });
      } else if (sortBy === 'populer') {
        cards.sort(function(a, b) {
          return parseInt(b.dataset.replies || 0) - parseInt(a.dataset.replies || 0);
        });
        cards.forEach(function(c) { list.appendChild(c); });
      }
    });
  });

  // ── Search ──────────────────────────────────
  var searchInput = document.getElementById('diskusiSearch');
  if (searchInput) {
    searchInput.addEventListener('input', function () {
      var q = this.value.toLowerCase();
      document.querySelectorAll('#topicList .topic-card').forEach(function (card) {
        var title = card.querySelector('.topic-title').textContent.toLowerCase();
        card.style.display = title.includes(q) ? '' : 'none';
      });
    });
  }
})();

function openDiskusiModal() {
  document.getElementById('diskusiModal').classList.add('open');
}
function closeDiskusiModal() {
  document.getElementById('diskusiModal').classList.remove('open');
  document.getElementById('diskusiTitle').value = '';
  document.getElementById('diskusiContent').value = '';
}

function setDiskusiSearch(keyword) {
  var searchInput = document.getElementById('diskusiSearch');
  if (searchInput) {
    searchInput.value = keyword;
    searchInput.dispatchEvent(new Event('input'));
  }
}

// Close modal on overlay click
document.getElementById('diskusiModal').addEventListener('click', function (e) {
  if (e.target === this) closeDiskusiModal();
});

function submitDiskusi(e) {
  e.preventDefault();
  var title    = document.getElementById('diskusiTitle').value.trim();
  var category = document.getElementById('diskusiCategory').value;
  var content  = document.getElementById('diskusiContent').value.trim();
  if (!title || !content) return;

  fetch('pages/Guru_Belajar/diskusi_submit.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: 'title=' + encodeURIComponent(title)
        + '&category=' + encodeURIComponent(category)
        + '&content=' + encodeURIComponent(content)
  })
  .then(function (r) { return r.json(); })
  .then(function (d) {
    if (d.success) {
      closeDiskusiModal();
      showPage('diskusi'); // reload the page section
    } else {
      alert(d.message || 'Gagal mengirim topik.');
    }
  })
  .catch(function () {
    // Fallback: close and refresh
    closeDiskusiModal();
    showPage('diskusi');
  });
}

function deleteTopic(id) {
  if (!confirm('Yakin ingin menghapus topik diskusi ini?')) return;
  
  fetch('pages/Guru_Belajar/diskusi_delete.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: 'id=' + id
  })
  .then(function (r) { return r.json(); })
  .then(function (d) {
    if (d.success) {
      showPage('diskusi'); // reload
    } else {
      alert(d.message || 'Gagal menghapus topik.');
    }
  })
  .catch(function () {
    showPage('diskusi');
  });
}
</script>
