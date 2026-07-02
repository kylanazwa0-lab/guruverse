    </div><!-- /content -->
  </div><!-- /main -->
</div><!-- /layout -->

<!-- TOAST -->
<div class="toast" id="toast" style="display:none;"></div>

<!-- GLOBAL DELETE CONFIRM MODAL -->
<div class="overlay" id="global-delete-modal" style="display:none;z-index:9999" onclick="if(event.target===this)this.style.display='none'">
  <div class="modal modal-md" style="max-width:380px;text-align:center;padding:2.5rem 1.5rem">
    <div style="width:64px;height:64px;border-radius:50%;background:rgba(239,68,68,0.1);color:#ef4444;display:flex;align-items:center;justify-content:center;margin:0 auto 1.25rem">
      <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2M10 11v6M14 11v6"/></svg>
    </div>
    <h3 style="font-size:1.15rem;font-weight:900;color:var(--t);margin-bottom:8px" id="delete-modal-title">Konfirmasi Hapus</h3>
    <p style="font-size:0.85rem;color:var(--muted);margin-bottom:2rem;line-height:1.5" id="delete-modal-text">Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.</p>
    <div style="display:flex;gap:12px;justify-content:center">
      <button type="button" class="btn-sm" onclick="document.getElementById('global-delete-modal').style.display='none'" style="background:#f1f5f9;color:#475569;border:none;padding:0.6rem 1.5rem;flex:1;font-weight:600">Batal</button>
      <button type="button" class="btn-sm" id="delete-modal-confirm" style="background:#ef4444;color:#fff;border:none;padding:0.6rem 1.5rem;flex:1;font-weight:600;box-shadow:0 4px 12px rgba(239,68,68,0.3)">Ya, Hapus</button>
    </div>
  </div>
</div>

<script>
// ── Clock ────────────────────────────────────────────────────────
(function(){
  const el = document.getElementById('clock');
  if (!el) return;
  const tick = () => { el.textContent = new Date().toLocaleTimeString('id-ID', {hour:'2-digit',minute:'2-digit'}); };
  tick(); setInterval(tick, 1000);
})();

// ── Sidebar mobile ───────────────────────────────────────────────
function openSidebar()  { document.getElementById('sidebar').classList.add('open');    document.getElementById('mob-overlay').classList.add('on'); }
function closeSidebar() { document.getElementById('sidebar').classList.remove('open'); document.getElementById('mob-overlay').classList.remove('on'); }

// ── Toast ────────────────────────────────────────────────────────
function showToast(msg, type='success') {
  const el = document.getElementById('toast');
  el.className = 'toast toast-' + type;
  el.textContent = msg;
  el.style.display = 'flex';
  clearTimeout(el._tid);
  el._tid = setTimeout(() => { el.style.display = 'none'; }, 3500);
}

// ── Global Delete Confirm ────────────────────────────────────────
let currentDeleteForm = null;
document.addEventListener('DOMContentLoaded', () => {
  document.addEventListener('click', (e) => {
    const submitBtn = e.target.closest('form.form-delete button[type="submit"]');
    if (submitBtn) {
      e.preventDefault();
      e.stopPropagation();
      currentDeleteForm = submitBtn.closest('form');
      const msg = currentDeleteForm.getAttribute('data-confirm') || 'Apakah Anda yakin ingin menghapus data ini?';
      const textEl = document.getElementById('delete-modal-text');
      if (textEl) textEl.innerText = msg;
      document.getElementById('global-delete-modal').style.display = 'flex';
    }
  });

  const confirmBtn = document.getElementById('delete-modal-confirm');
  if (confirmBtn) {
    confirmBtn.addEventListener('click', () => {
      if (currentDeleteForm) currentDeleteForm.submit();
    });
  }
});

// ── Action Dropdown (⋮ kebab) — handles FlyonUI .dropdown.relative pattern ──
// Menus use class "hidden" from Tailwind. We toggle it on click.
(function() {
  function closeAllActionMenus(except) {
    // Close .dropdown menus
    document.querySelectorAll('.dropdown .dropdown-menu, .dropdown ul[role="menu"]').forEach(m => {
      if (m !== except) m.classList.add('hidden');
    });
    // Close .action-dd menus (alternate pattern)
    document.querySelectorAll('.action-dd-menu').forEach(m => {
      if (m !== except) m.classList.add('hidden');
    });
  }

  // One delegated listener handles everything
  document.addEventListener('click', (e) => {
    // 1. FlyonUI Pattern: .dropdown > .dropdown-toggle
    const flyonToggle = e.target.closest('.dropdown .dropdown-toggle');
    if (flyonToggle) {
      e.stopPropagation();
      const parent = flyonToggle.closest('.dropdown');
      const menu = parent ? parent.querySelector('.dropdown-menu, ul[role="menu"]') : null;
      if (!menu) return;
      
      const isHidden = menu.classList.contains('hidden');
      closeAllActionMenus(menu);
      
      // Close other .open dropdowns
      document.querySelectorAll('.dropdown').forEach(d => {
        if (d !== parent) d.classList.remove('open');
      });

      if (isHidden) {
        menu.classList.remove('hidden');
        parent.classList.add('open');
      } else {
        menu.classList.add('hidden');
        parent.classList.remove('open');
      }
      return;
    }

    // 2. Alternate Pattern: .action-dd > [data-action-toggle]
    const toggleBtn = e.target.closest('[data-action-toggle]');
    if (toggleBtn) {
      e.stopPropagation();
      const menu = toggleBtn.closest('.action-dd').querySelector('.action-dd-menu');
      if (!menu) return;
      const isHidden = menu.classList.contains('hidden');
      closeAllActionMenus(menu);
      if (isHidden) menu.classList.remove('hidden');
      else menu.classList.add('hidden');
      return;
    }

    // 3. Click outside — close all
    if (!e.target.closest('.dropdown') && !e.target.closest('.action-dd')) {
      closeAllActionMenus(null);
      document.querySelectorAll('.dropdown').forEach(d => d.classList.remove('open'));
    }
  });
})();

// ── Custom Select (replaces <select class="fi">) ─────────────────
// Wraps each native select with a styled custom UI while keeping
// the real <select> in the DOM for proper form submission.
(function() {
  function buildCustomSelect(select) {
    if (select.dataset.csWrapped) return;
    select.dataset.csWrapped = '1';

    // Hide native select (keep in DOM for forms)
    Object.assign(select.style, {
      position: 'absolute', opacity: '0',
      pointerEvents: 'none', width: '0', height: '0'
    });

    const wrapper = document.createElement('div');
    wrapper.className = 'cs-wrap';
    Object.assign(wrapper.style, {
      position: 'relative', display: 'block', width: '100%'
    });

    const btn = document.createElement('button');
    btn.type = 'button';
    btn.className = 'fi cs-btn';
    Object.assign(btn.style, {
      width: '100%', textAlign: 'left', display: 'flex',
      alignItems: 'center', justifyContent: 'space-between', cursor: 'pointer'
    });

    const textSpan = document.createElement('span');
    textSpan.className = 'cs-text';
    textSpan.innerText = select.options[select.selectedIndex]?.text || 'Pilih...';
    btn.appendChild(textSpan);
    btn.insertAdjacentHTML('beforeend', `<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="flex-shrink:0"><polyline points="6 9 12 15 18 9"/></svg>`);

    const menu = document.createElement('ul');
    menu.className = 'cs-menu';
    Object.assign(menu.style, {
      display: 'none', position: 'absolute', top: '100%', left: '0', right: '0',
      zIndex: '9998', background: 'var(--card,#fff)', border: '1px solid var(--border,#e2e8f0)',
      borderRadius: '8px', boxShadow: '0 8px 24px rgba(0,0,0,0.12)',
      marginTop: '4px', maxHeight: '220px', overflowY: 'auto', padding: '4px 0'
    });

    function buildMenu() {
      menu.innerHTML = '';
      Array.from(select.options).forEach((opt, idx) => {
        const li = document.createElement('li');
        li.style.listStyle = 'none';
        const a = document.createElement('a');
        const isSelected = idx === select.selectedIndex;
        Object.assign(a.style, {
          display: 'block', padding: '8px 14px', fontSize: '.82rem',
          cursor: 'pointer', color: 'var(--t,#1e293b)',
          fontWeight: isSelected ? '700' : '400',
          background: isSelected ? 'var(--bg,#f8fafc)' : ''
        });
        a.innerText = opt.text;
        a.onmouseenter = () => a.style.background = 'var(--bg,#f8fafc)';
        a.onmouseleave = () => a.style.background = isSelected ? 'var(--bg,#f8fafc)' : '';
        a.onclick = (ev) => {
          ev.preventDefault();
          select.selectedIndex = idx;
          textSpan.innerText = opt.text;
          menu.style.display = 'none';
          select.dispatchEvent(new Event('change', { bubbles: true }));
          buildMenu();
        };
        li.appendChild(a);
        menu.appendChild(li);
      });
    }
    buildMenu();

    // Toggle menu on button click
    btn.onclick = (ev) => {
      ev.preventDefault();
      ev.stopPropagation();
      const isOpen = menu.style.display !== 'none';
      // Close all other custom select menus
      document.querySelectorAll('.cs-menu').forEach(m => { if (m !== menu) m.style.display = 'none'; });
      menu.style.display = isOpen ? 'none' : 'block';
    };

    // Sync display text when select changes externally
    select.addEventListener('change', () => {
      textSpan.innerText = select.options[select.selectedIndex]?.text || 'Pilih...';
      buildMenu();
    });

    // Patch select.value setter to sync UI
    const proto = Object.getOwnPropertyDescriptor(HTMLSelectElement.prototype, 'value');
    if (proto) {
      Object.defineProperty(select, 'value', {
        get() { return proto.get.call(this); },
        set(val) {
          proto.set.call(this, val);
          textSpan.innerText = this.options[this.selectedIndex]?.text || 'Pilih...';
          buildMenu();
        }
      });
    }

    wrapper.appendChild(btn);
    wrapper.appendChild(menu);
    select.parentNode.insertBefore(wrapper, select);
  }

  // Close custom select menus on outside click
  document.addEventListener('click', (e) => {
    if (!e.target.closest('.cs-wrap')) {
      document.querySelectorAll('.cs-menu').forEach(m => m.style.display = 'none');
    }
  });

  // Build all on DOM ready
  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('select.fi').forEach(buildCustomSelect);
  });

  // Public helper to re-sync a select's display after programmatic change
  window.syncSelectUI = function(selectEl) {
    if (!selectEl) return;
    const wrap = selectEl.parentNode ? selectEl.parentNode.querySelector('.cs-wrap') : null;
    if (!wrap) return;
    const textSpan = wrap.querySelector('.cs-text');
    if (textSpan && selectEl.options[selectEl.selectedIndex]) {
      textSpan.innerText = selectEl.options[selectEl.selectedIndex].text;
    }
  };
})();

// ── Notifications ────────────────────────────────────────────────
(function() {
  const btn = document.getElementById('notif-dropdown-btn');
  if (!btn) return;

  btn.onclick = (e) => {
    e.stopPropagation();
    const wrapper = btn.closest('.dropdown');
    const ul = wrapper ? wrapper.querySelector('.dropdown-menu, ul') : null;
    if (!ul) return;
    const isHidden = ul.classList.contains('hidden') || ul.style.display === 'none';
    // Close all notification / other dropdowns
    document.querySelectorAll('#notif-dropdown-btn').forEach(b => {
      const w = b.closest('.dropdown');
      const m = w ? w.querySelector('.dropdown-menu, ul') : null;
      if (m) { m.classList.add('hidden'); m.style.display = ''; }
    });
    if (isHidden) { ul.classList.remove('hidden'); ul.style.display = ''; }
  };

  document.addEventListener('click', (e) => {
    if (!e.target.closest('#notif-dropdown-btn') && !e.target.closest('#notif-dropdown-menu')) {
      const ul = document.getElementById('notif-dropdown-menu');
      if (ul) ul.classList.add('hidden');
    }
  });

  function fetchNotifications() {
    fetch('/guruverse/api/get_admin_notifications.php')
      .then(r => r.json())
      .then(data => {
        if (!data.success || !data.data) return;
        const list = document.getElementById('notif-list-container');
        const badge = document.getElementById('notif-badge');
        list.innerHTML = '';

        if (data.data.length === 0) {
          list.innerHTML = '<div style="padding:20px;text-align:center;color:var(--muted);font-size:0.8rem">Belum ada notifikasi</div>';
          badge.style.display = 'none';
          return;
        }

        let newCount = 0;
        const lastCheck = localStorage.getItem('last_notif_time') || '0';
        let latestTime = lastCheck;

        data.data.forEach(n => {
          if (n.created_at > lastCheck) {
            newCount++;
            if (n.created_at > latestTime) latestTime = n.created_at;
            if (lastCheck !== '0') showToast(`🔔 ${n.message}: ${n.title}`, 'success');
          }
          const dt = new Date(n.created_at).toLocaleDateString('id-ID', {hour:'2-digit', minute:'2-digit'});
          const icon = n.type === 'user'
            ? '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>'
            : '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>';

          list.innerHTML += `
            <div style="padding:16px;border-bottom:1px solid #f1f5f9;display:flex;gap:14px;align-items:flex-start">
              <div style="padding:10px;background:${n.type==='user'?'#eff6ff':'#ecfdf5'};border-radius:50%;flex-shrink:0;display:flex;align-items:center;justify-content:center">${icon}</div>
              <div style="flex:1;min-width:0">
                <div style="font-size:0.85rem;font-weight:800;color:var(--t);line-height:1.4;margin-bottom:4px;word-wrap:break-word">${n.title}</div>
                <div style="font-size:0.75rem;color:var(--muted);line-height:1.5;margin-bottom:6px">${n.message}</div>
                <div style="font-size:0.65rem;color:var(--muted2);font-weight:600">${dt}</div>
              </div>
            </div>`;
        });

        if (newCount > 0) {
          badge.innerText = newCount;
          badge.style.display = 'flex';
          localStorage.setItem('last_notif_time', latestTime);
        }
      })
      .catch(() => {}); // fail silently
  }

  fetchNotifications();
  setInterval(fetchNotifications, 30000);
})();
</script>
<script src="https://cdn.jsdelivr.net/npm/flyonui@1.0.0/dist/flyonui.js"></script>
</body>
</html>
