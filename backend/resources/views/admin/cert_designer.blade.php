
<!-- Visual Certificate Designer Modal -->
<div class="overlay" id="modal-cert-designer" style="display:none; z-index:9999;">
  <div class="modal" style="width: 90%; max-width: 1000px; padding: 0;">
    <div class="modal-header" style="padding: 1rem 1.5rem; border-bottom: 1px solid var(--border);">
      <div style="font-weight:900;font-size:1.1rem">Visual Certificate Designer</div>
      <button class="close-btn" onclick="closeCertDesigner()">✕</button>
    </div>
    
    <div style="display:flex; flex-direction:column; background:#f3f4f6;">
      <div style="padding:15px; display:flex; gap:10px; background:#fff; border-bottom:1px solid #e5e7eb;">
        <label style="font-size:12px; font-weight:700;"><input type="checkbox" id="cd-toggle-name" checked onchange="cdToggleElem('name')"> Tampilkan Nama</label>
        <label style="font-size:12px; font-weight:700;"><input type="checkbox" id="cd-toggle-no" checked onchange="cdToggleElem('no')"> Tampilkan Nomor</label>
        <label style="font-size:12px; font-weight:700;"><input type="checkbox" id="cd-toggle-date" checked onchange="cdToggleElem('date')"> Tampilkan Tanggal</label>
        <span style="font-size:12px; color:var(--muted); margin-left:auto;">*Geser kotak teks ke posisi yang Anda inginkan</span>
      </div>
      
      <div style="padding: 20px; overflow:auto; display:flex; justify-content:center; align-items:center; min-height:500px;">
         <div id="cd-canvas" style="position:relative; box-shadow:0 10px 25px rgba(0,0,0,0.1); background:#fff;">
            <img id="cd-img" src="" style="display:block; max-width:100%; height:auto;" draggable="false">
            
            <div id="cd-elem-name" class="cd-draggable" style="position:absolute; top:40%; left:25%; padding:10px 20px; border:2px dashed #3b82f6; background:rgba(59,130,246,0.1); color:#1d4ed8; font-weight:bold; font-size:24px; cursor:move; white-space:nowrap; transform:translate(-50%,-50%); user-select:none;">NAMA MEMBER</div>
            
            <div id="cd-elem-no" class="cd-draggable" style="position:absolute; top:75%; left:25%; padding:5px 10px; border:2px dashed #10b981; background:rgba(16,185,129,0.1); color:#047857; font-weight:bold; font-size:14px; cursor:move; white-space:nowrap; transform:translate(-50%,-50%); user-select:none;">Certificate No: GV-XXXX</div>
            
            <div id="cd-elem-date" class="cd-draggable" style="position:absolute; top:85%; left:75%; padding:5px 10px; border:2px dashed #f59e0b; background:rgba(245,158,11,0.1); color:#b45309; font-weight:bold; font-size:14px; cursor:move; white-space:nowrap; transform:translate(-50%,-50%); user-select:none;">May 29, 2026</div>
         </div>
      </div>
    </div>

    <div class="modal-footer" style="padding: 1rem 1.5rem; background:#fff; border-top: 1px solid var(--border);">
      <button type="button" class="btn-sm" onclick="closeCertDesigner()" style="background:rgba(255,255,255,.06);color:var(--muted);border:1px solid var(--border)">Batal</button>
      <button type="button" class="btn-sm" onclick="saveCertDesigner()" style="background:var(--v1);color:#fff;border:none;padding:.42rem 1.1rem">Terapkan Tata Letak</button>
    </div>
  </div>
</div>

<script>
let cdActiveConfigInput = null;
let cdIsDragging = false;
let cdCurrentElem = null;
let cdOffsetX = 0;
let cdOffsetY = 0;

function openCertDesigner(imgUrl, inputId) {
    if(!imgUrl) {
        alert("Silakan unggah dan simpan template terlebih dahulu sebelum mengatur tata letak.");
        return;
    }
    cdActiveConfigInput = document.getElementById(inputId);
    document.getElementById('cd-img').src = imgUrl;
    
    // Parse existing config if any
    let configStr = cdActiveConfigInput.value;
    let config = {
        name: {x: 50, y: 55, enabled: true},
        no: {x: 50, y: 75, enabled: true},
        date: {x: 75, y: 85, enabled: true}
    };
    if (configStr) {
        try { config = JSON.parse(configStr); } catch(e){}
    }
    
    applyCdConfigToUI(config);
    document.getElementById('modal-cert-designer').style.display = 'flex';
}

function applyCdConfigToUI(config) {
    const applyToElem = (key, conf) => {
        const el = document.getElementById('cd-elem-' + key);
        const cb = document.getElementById('cd-toggle-' + key);
        if(conf.enabled) {
            el.style.display = 'block';
            cb.checked = true;
            el.style.left = conf.x + '%';
            el.style.top = conf.y + '%';
        } else {
            el.style.display = 'none';
            cb.checked = false;
        }
    };
    if(config.name) applyToElem('name', config.name);
    if(config.no) applyToElem('no', config.no);
    if(config.date) applyToElem('date', config.date);
}

function cdToggleElem(key) {
    const el = document.getElementById('cd-elem-' + key);
    const cb = document.getElementById('cd-toggle-' + key);
    el.style.display = cb.checked ? 'block' : 'none';
}

function closeCertDesigner() {
    document.getElementById('modal-cert-designer').style.display = 'none';
}

function saveCertDesigner() {
    const canvas = document.getElementById('cd-canvas');
    const cw = canvas.offsetWidth;
    const ch = canvas.offsetHeight;
    
    const getConf = (key) => {
        const el = document.getElementById('cd-elem-' + key);
        const cb = document.getElementById('cd-toggle-' + key);
        if(!cb.checked) return {enabled: false, x: 0, y: 0};
        
        // Calculate center relative to canvas in percentages
        let leftPx = parseFloat(el.style.left); // it's already % but wait, if dragged it's in px
        let topPx = parseFloat(el.style.top);
        
        let xPct, yPct;
        if(el.style.left.includes('%')) {
            xPct = parseFloat(el.style.left);
            yPct = parseFloat(el.style.top);
        } else {
            xPct = (leftPx / cw) * 100;
            yPct = (topPx / ch) * 100;
        }
        
        // constrain
        xPct = Math.max(0, Math.min(100, xPct));
        yPct = Math.max(0, Math.min(100, yPct));
        
        return {
            enabled: true,
            x: Math.round(xPct * 100) / 100,
            y: Math.round(yPct * 100) / 100
        };
    };
    
    const config = {
        name: getConf('name'),
        no: getConf('no'),
        date: getConf('date')
    };
    
    cdActiveConfigInput.value = JSON.stringify(config);
    closeCertDesigner();
    alert("Tata letak sertifikat berhasil diterapkan! Jangan lupa klik 'Simpan Kelas'.");
}

// Drag logic
document.querySelectorAll('.cd-draggable').forEach(elem => {
    elem.addEventListener('mousedown', function(e) {
        cdIsDragging = true;
        cdCurrentElem = this;
        // Convert to absolute px for dragging
        let canvas = document.getElementById('cd-canvas');
        let rect = canvas.getBoundingClientRect();
        
        // Current position in px relative to canvas
        let elRect = this.getBoundingClientRect();
        let cx = elRect.left + elRect.width/2 - rect.left;
        let cy = elRect.top + elRect.height/2 - rect.top;
        
        this.style.left = cx + 'px';
        this.style.top = cy + 'px';
        
        cdOffsetX = e.clientX - elRect.left - elRect.width/2;
        cdOffsetY = e.clientY - elRect.top - elRect.height/2;
    });
});

document.addEventListener('mousemove', function(e) {
    if (!cdIsDragging || !cdCurrentElem) return;
    let canvas = document.getElementById('cd-canvas');
    let rect = canvas.getBoundingClientRect();
    
    let nx = e.clientX - rect.left - cdOffsetX;
    let ny = e.clientY - rect.top - cdOffsetY;
    
    // constrain inside canvas
    nx = Math.max(0, Math.min(rect.width, nx));
    ny = Math.max(0, Math.min(rect.height, ny));
    
    cdCurrentElem.style.left = nx + 'px';
    cdCurrentElem.style.top = ny + 'px';
});

document.addEventListener('mouseup', function() {
    cdIsDragging = false;
    cdCurrentElem = null;
});
</script>