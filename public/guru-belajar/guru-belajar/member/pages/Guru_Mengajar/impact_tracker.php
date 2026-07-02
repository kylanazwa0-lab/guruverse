<?php /* Impact Tracker — Guru Mengajar (System Feedback) */ 
$uid = (int)($_SESSION['member_int_id'] ?? 3);

// Ambil semua feedback
$feedbacks = [];
$total_rating = 0;
$rating_counts = [5=>0, 4=>0, 3=>0, 2=>0, 1=>0];

$res = $conn->query("SELECT f.*, m.full_name, m.institution 
                     FROM gb_mengajar_system_feedback f 
                     JOIN members m ON f.member_id = m.id 
                     ORDER BY f.created_at DESC");
if ($res) {
    while($r = $res->fetch_assoc()) {
        $feedbacks[] = $r;
        $total_rating += (int)$r['rating'];
        $rating_counts[(int)$r['rating']]++;
    }
}

$total_reviews = count($feedbacks);
$avg_rating = $total_reviews > 0 ? round($total_rating / $total_reviews, 1) : 0;
?>

<div class="page" id="page-impact">
  <div class="section-head mb-24">
    <h2>Impact Tracker: Feedback Sistem GuruVerse</h2>
    <span class="badge badge-green">Live Update</span>
  </div>

  <p style="color:#64748b; margin-top:0; margin-bottom:24px; font-size:0.95rem;">
      Pantau seberapa besar dampak dan kebermanfaatan platform GuruVerse bagi rekan-rekan pendidik di seluruh Indonesia. Berikan suara Anda!
  </p>

  <!-- STATS & RATING CHART -->
  <div style="display:grid; grid-template-columns: 1fr 3fr; gap:24px; margin-bottom:30px; align-items:start;">
      
      <!-- Average Score -->
      <div style="background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:16px; display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center;">
          <div style="font-size:3rem; font-weight:900; color:#0f172a; line-height:1;"><?= number_format($avg_rating, 1) ?></div>
          <div style="display:flex; gap:4px; margin:12px 0;">
              <?php for($i=1; $i<=5; $i++): ?>
              <svg width="20" height="20" viewBox="0 0 24 24" fill="<?= $i <= round($avg_rating) ? '#f59e0b' : '#e2e8f0' ?>" xmlns="http://www.w3.org/2000/svg"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
              <?php endfor; ?>
          </div>
          <div style="color:#64748b; font-size:0.8rem; font-weight:600;">Berbasis <?= $total_reviews ?> ulasan</div>
      </div>

      <!-- Rating Bars -->
      <div style="background:#fff; border:1px solid #e2e8f0; border-radius:16px; padding:24px;">
          <h3 style="margin:0 0 16px 0; font-size:1.1rem; color:#0f172a; font-weight:800;">Distribusi Penilaian</h3>
          <div style="display:flex; flex-direction:column; gap:12px;">
              <?php for($i=5; $i>=1; $i--): 
                  $count = $rating_counts[$i];
                  $pct = $total_reviews > 0 ? ($count / $total_reviews) * 100 : 0;
              ?>
              <div style="display:flex; align-items:center; gap:12px;">
                  <div style="font-size:0.85rem; font-weight:700; color:#475569; width:20px;"><?= $i ?> ★</div>
                  <div style="flex:1; height:8px; background:#f1f5f9; border-radius:4px; overflow:hidden;">
                      <div style="height:100%; background:#f59e0b; width:<?= $pct ?>%; border-radius:4px;"></div>
                  </div>
                  <div style="font-size:0.8rem; color:#64748b; width:30px; text-align:right;"><?= $count ?></div>
              </div>
              <?php endfor; ?>
          </div>
      </div>
  </div>

  <!-- LEAVE FEEDBACK & FEEDBACK WALL -->
  <div style="display:grid; grid-template-columns: 1fr 2fr; gap:24px;">
      
      <!-- Feedback Form -->
      <div>
          <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:16px; padding:24px; position:sticky; top:24px;">
              <h3 style="margin:0 0 8px 0; font-size:1.1rem; color:#0f172a; font-weight:800;">Bagaimana Pengalaman Anda?</h3>
              <p style="color:#64748b; font-size:0.85rem; margin-bottom:20px;">Bantu kami menjadi lebih baik dengan membagikan pendapat Anda.</p>
              
              <form onsubmit="submitSystemFeedback(event)">
                  <div style="margin-bottom:16px; text-align:center;">
                      <label style="display:block; font-size:0.85rem; font-weight:700; color:#475569; margin-bottom:8px; text-align:left;">Berikan Bintang</label>
                      <div id="star-selector" style="display:inline-flex; gap:8px; cursor:pointer;">
                          <?php for($i=1; $i<=5; $i++): ?>
                          <svg data-val="<?= $i ?>" onclick="selectStar(<?= $i ?>)" width="32" height="32" viewBox="0 0 24 24" fill="#e2e8f0" style="transition:all 0.2s;" xmlns="http://www.w3.org/2000/svg"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                          <?php endfor; ?>
                      </div>
                      <input type="hidden" id="feedback-rating" required>
                  </div>
                  <div style="margin-bottom:16px;">
                      <label style="display:block; font-size:0.85rem; font-weight:700; color:#475569; margin-bottom:8px;">Pilih Kategori</label>

                      <div id="dd-kategori-wrap" style="position:relative; width:100%;">
                        <!-- Tidak pakai class dropdown-toggle agar tidak konflik dengan style.css button reset -->
                        <button id="btn-kategori-dropdown" type="button"
                          style="width:100%; display:flex; align-items:center; justify-content:space-between; gap:8px;
                                 padding:10px 14px;
                                 background:#f8fafc; border:1.5px solid #cbd5e1; border-radius:8px;
                                 font-size:0.875rem; font-family:inherit;
                                 color:#64748b;
                                 cursor:pointer; text-align:left;
                                 transition:border-color .2s, box-shadow .2s;"
                          onclick="toggleKategoriDD()"
                          aria-haspopup="listbox"
                          aria-expanded="false">
                          <span id="kategori-label">-- Pilih Kategori --</span>
                          <svg id="kategori-chevron" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="#94a3b8" stroke-width="2.5"
                            stroke-linecap="round" stroke-linejoin="round"
                            style="flex-shrink:0; transition:transform .2s; pointer-events:none;">
                            <polyline points="6 9 12 15 18 9"/>
                          </svg>
                        </button>

                        <ul id="kategori-menu"
                          role="listbox"
                          style="display:none; position:absolute; top:calc(100% + 4px); left:0; right:0;
                                 background:#fff; border:1px solid #e2e8f0; border-radius:8px;
                                 box-shadow:0 8px 24px rgba(0,0,0,0.1); z-index:200;
                                 padding:4px; margin:0; list-style:none;">
                          <li><button type="button" onclick="pilihKategori('Fitur Gamifikasi')"     style="width:100%; text-align:left; padding:9px 12px; background:none; border:none; border-radius:6px; font-size:0.875rem; font-family:inherit; color:#334155; cursor:pointer;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='none'">Fitur Gamifikasi</button></li>
                          <li><button type="button" onclick="pilihKategori('Pelatihan Offline')"    style="width:100%; text-align:left; padding:9px 12px; background:none; border:none; border-radius:6px; font-size:0.875rem; font-family:inherit; color:#334155; cursor:pointer;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='none'">Pelatihan Offline</button></li>
                          <li><button type="button" onclick="pilihKategori('Modul / Perpustakaan')" style="width:100%; text-align:left; padding:9px 12px; background:none; border:none; border-radius:6px; font-size:0.875rem; font-family:inherit; color:#334155; cursor:pointer;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='none'">Modul / Perpustakaan</button></li>
                          <li><button type="button" onclick="pilihKategori('UI/UX &amp; Tampilan')" style="width:100%; text-align:left; padding:9px 12px; background:none; border:none; border-radius:6px; font-size:0.875rem; font-family:inherit; color:#334155; cursor:pointer;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='none'">UI/UX &amp; Tampilan</button></li>
                          <li><button type="button" onclick="pilihKategori('Lainnya')"              style="width:100%; text-align:left; padding:9px 12px; background:none; border:none; border-radius:6px; font-size:0.875rem; font-family:inherit; color:#334155; cursor:pointer;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='none'">Lainnya</button></li>
                        </ul>
                      </div>

                      <input type="hidden" id="feedback-kategori" required>

                      <script>
                      function toggleKategoriDD() {
                        const menu    = document.getElementById('kategori-menu');
                        const btn     = document.getElementById('btn-kategori-dropdown');
                        const chevron = document.getElementById('kategori-chevron');
                        const isOpen  = menu.style.display === 'block';
                        menu.style.display    = isOpen ? 'none' : 'block';
                        btn.setAttribute('aria-expanded', isOpen ? 'false' : 'true');
                        chevron.style.transform = isOpen ? 'rotate(0deg)' : 'rotate(180deg)';
                        if (!isOpen) {
                          btn.style.borderColor = '#4f46e5';
                          btn.style.boxShadow   = '0 0 0 3px rgba(79,70,229,0.12)';
                        } else {
                          btn.style.borderColor = '#cbd5e1';
                          btn.style.boxShadow   = 'none';
                        }
                      }

                      function pilihKategori(val) {
                        document.getElementById('feedback-kategori').value = val;
                        const lbl = document.getElementById('kategori-label');
                        lbl.textContent = val;
                        lbl.style.color = '#1e293b';
                        // tutup menu
                        document.getElementById('kategori-menu').style.display = 'none';
                        document.getElementById('btn-kategori-dropdown').setAttribute('aria-expanded','false');
                        document.getElementById('kategori-chevron').style.transform = 'rotate(0deg)';
                        document.getElementById('btn-kategori-dropdown').style.borderColor = '#cbd5e1';
                        document.getElementById('btn-kategori-dropdown').style.boxShadow   = 'none';
                      }

                      // Tutup jika klik di luar
                      document.addEventListener('click', function(e) {
                        const wrap = document.getElementById('dd-kategori-wrap');
                        if (wrap && !wrap.contains(e.target)) {
                          document.getElementById('kategori-menu').style.display = 'none';
                          document.getElementById('btn-kategori-dropdown').setAttribute('aria-expanded','false');
                          document.getElementById('kategori-chevron').style.transform = 'rotate(0deg)';
                          document.getElementById('btn-kategori-dropdown').style.borderColor = '#cbd5e1';
                          document.getElementById('btn-kategori-dropdown').style.boxShadow   = 'none';
                        }
                      });
                      </script>
                  </div>
                  <div style="margin-bottom:20px;">
                      <label style="display:block; font-size:0.85rem; font-weight:700; color:#475569; margin-bottom:8px;">Ceritakan Pengalaman Anda</label>
                      <textarea id="feedback-ulasan" required rows="4" placeholder="Misal: Saya sangat terbantu dengan fitur modul..." style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:8px; resize:vertical; font-family:inherit;"></textarea>
                  </div>
                  <button type="submit" id="btn-submit-fb" style="width:100%; background:#4f46e5; color:#fff; border:none; padding:12px; border-radius:8px; font-weight:800; cursor:pointer;">Kirim Ulasan</button>
              </form>
          </div>
      </div>

      <!-- Feedback Wall -->
      <div>
          <h3 style="margin:0 0 16px 0; font-size:1.2rem; color:#0f172a; font-weight:800;">Dinding Testimoni</h3>
          <div style="display:flex; flex-direction:column; gap:16px;">
              <?php if(empty($feedbacks)): ?>
              <div style="text-align:center; padding:40px; border:1px dashed #cbd5e1; border-radius:16px; color:#94a3b8;">Belum ada ulasan. Jadilah yang pertama!</div>
              <?php endif; ?>

              <?php foreach($feedbacks as $fb): ?>
              <div style="background:#fff; border:1px solid #e2e8f0; border-radius:16px; padding:20px; box-shadow:0 4px 6px rgba(0,0,0,0.02);">
                  <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:12px;">
                      <div style="display:flex; align-items:center; gap:12px;">
                          <div style="width:40px; height:40px; border-radius:50%; background:linear-gradient(135deg, #4f46e5, #8b2fc9); color:#fff; display:flex; align-items:center; justify-content:center; font-weight:800; font-size:1.1rem;">
                              <?= substr(htmlspecialchars($fb['full_name']), 0, 1) ?>
                          </div>
                          <div>
                              <div style="font-weight:800; color:#0f172a; font-size:0.95rem;"><?= htmlspecialchars($fb['full_name']) ?></div>
                              <div style="font-size:0.75rem; color:#64748b;"><?= htmlspecialchars($fb['institution']) ?></div>
                          </div>
                      </div>
                      <div style="display:flex; gap:2px;">
                          <?php for($i=1; $i<=5; $i++): ?>
                          <svg width="14" height="14" viewBox="0 0 24 24" fill="<?= $i <= $fb['rating'] ? '#f59e0b' : '#e2e8f0' ?>" xmlns="http://www.w3.org/2000/svg"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                          <?php endfor; ?>
                      </div>
                  </div>
                  <div style="font-size:0.75rem; font-weight:700; color:#4f46e5; text-transform:uppercase; margin-bottom:6px;"><?= htmlspecialchars($fb['kategori']) ?></div>
                  <p style="margin:0; font-size:0.9rem; color:#334155; line-height:1.6;">
                      "<?= nl2br(htmlspecialchars($fb['ulasan'])) ?>"
                  </p>
                  <div style="font-size:0.7rem; color:#94a3b8; margin-top:12px; text-align:right;">
                      <?= date('d M Y, H:i', strtotime($fb['created_at'])) ?>
                  </div>
              </div>
              <?php endforeach; ?>
          </div>
      </div>
  </div>
</div>

<script>
let currentStar = 0;
function selectStar(val) {
    currentStar = val;
    document.getElementById('feedback-rating').value = val;
    const stars = document.getElementById('star-selector').children;
    for(let i=0; i<stars.length; i++) {
        stars[i].setAttribute('fill', i < val ? '#f59e0b' : '#e2e8f0');
        stars[i].style.transform = i < val ? 'scale(1.1)' : 'scale(1)';
    }
    setTimeout(() => {
        for(let i=0; i<stars.length; i++) { stars[i].style.transform = 'scale(1)'; }
    }, 200);
}

async function submitSystemFeedback(e) {
    e.preventDefault();
    const rating = document.getElementById('feedback-rating').value;
    if(!rating || rating == 0) {
        alert('Mohon berikan rating (bintang) terlebih dahulu.');
        return;
    }

    const btn = document.getElementById('btn-submit-fb');
    btn.innerText = 'Mengirim...';
    btn.disabled = true;

    const fd = new FormData();
    fd.append('rating', rating);
    fd.append('kategori', document.getElementById('feedback-kategori').value);
    fd.append('ulasan', document.getElementById('feedback-ulasan').value);

    try {
        const res = await fetch('/guruverse/guru-belajar/member/pages/Guru_Mengajar/api_feedback.php?action=submit_feedback', {
            method: 'POST', body: fd
        });
        const data = await res.json();
        if(data.status === 'success') {
            alert(data.message);
            window.location.reload();
        } else {
            alert(data.message || 'Gagal mengirim ulasan.');
        }
    } catch (err) {
        alert('Kesalahan jaringan.');
    }
    btn.innerText = 'Kirim Ulasan';
    btn.disabled = false;
}
</script>