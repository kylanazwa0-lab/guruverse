@extends('layouts.admin')

@section('title', 'Live Chat Admin')
@section('page_title', 'Live Chat Admin')

@section('content')
<div style="padding: 24px;">
    <h2>Live Chat (Pusat Bantuan)</h2>
    <div style="display:flex;gap:20px;margin-top:20px">
        <!-- List Sessions -->
        <div style="width:300px;background:var(--c-card,#1e293b);border-radius:12px;padding:16px;">
            <h3 style="font-size:16px;margin-bottom:12px">Antrean & Aktif</h3>
            <div id="adminChatList" style="display:flex;flex-direction:column;gap:8px;"></div>
        </div>
        
        <!-- Chat Window -->
        <div style="flex:1;background:var(--c-card,#1e293b);border-radius:12px;display:flex;flex-direction:column;height:500px">
            <div id="adminChatHeader" style="padding:16px;border-bottom:1px solid rgba(255,255,255,0.1);font-weight:bold">
                Pilih Chat...
            </div>
            <div id="adminChatBody" style="flex:1;overflow-y:auto;padding:16px;display:flex;flex-direction:column;gap:12px;">
                
            </div>
            <div style="padding:16px;border-top:1px solid rgba(255,255,255,0.1);display:flex;gap:10px">
                <input type="text" id="adminChatInput" placeholder="Balas pesan..." style="flex:1;padding:10px;border-radius:8px;border:none;outline:none;background:rgba(255,255,255,0.1);color:#fff" disabled onkeypress="if(event.key==='Enter') adminSendChat()">
                <button id="adminChatSendBtn" onclick="adminSendChat()" class="btn btn-primary" disabled>Kirim</button>
            </div>
        </div>
    </div>
</div>

<script>
let adminActiveSessionId = 0;
let adminLastMsgId = 0;

function loadAdminChatList() {
    fetch('api/chat_admin_api.php?action=list')
      .then(r=>r.json())
      .then(d=>{
          if(d.success) {
              let html = '';
              d.sessions.forEach(s => {
                  let badge = s.status === 'waiting_admin' ? '<span style="background:#ef4444;color:#fff;padding:2px 6px;border-radius:10px;font-size:10px">Baru</span>' : '';
                  html += `<div style="padding:10px;background:rgba(255,255,255,0.05);border-radius:8px;cursor:pointer;border-left:4px solid ${s.id===adminActiveSessionId ? '#3b82f6' : 'transparent'}" onclick="openAdminSession(${s.id}, '${s.full_name}')">
                    <div style="display:flex;justify-content:space-between">
                        <strong>${s.full_name}</strong>
                        ${badge}
                    </div>
                  </div>`;
              });
              document.getElementById('adminChatList').innerHTML = html;
          }
      });
}

function openAdminSession(id, name) {
    adminActiveSessionId = id;
    adminLastMsgId = 0;
    document.getElementById('adminChatHeader').textContent = 'Chat dengan: ' + name;
    document.getElementById('adminChatBody').innerHTML = '';
    document.getElementById('adminChatInput').disabled = false;
    document.getElementById('adminChatSendBtn').disabled = false;
    syncAdminChat();
    
    // tandai status jadi active jika waiting_admin
    fetch('api/chat_admin_api.php?action=activate&session_id=' + id);
    loadAdminChatList();
}

function syncAdminChat() {
    if(!adminActiveSessionId) return;
    fetch('api/chat_admin_api.php?action=sync&session_id=' + adminActiveSessionId + '&last_id=' + adminLastMsgId)
      .then(r=>r.json())
      .then(d=>{
          if(d.success) {
              const body = document.getElementById('adminChatBody');
              d.messages.forEach(m => {
                  if(m.id > adminLastMsgId) {
                      const div = document.createElement('div');
                      div.style.maxWidth = '80%';
                      div.style.padding = '8px 12px';
                      div.style.borderRadius = '8px';
                      div.style.fontSize = '13px';
                      if(m.sender_type === 'admin') {
                          div.style.background = '#3b82f6';
                          div.style.color = '#fff';
                          div.style.alignSelf = 'flex-end';
                      } else {
                          div.style.background = 'rgba(255,255,255,0.1)';
                          div.style.color = '#fff';
                          div.style.alignSelf = 'flex-start';
                      }
                      div.innerHTML = `<strong style="font-size:11px;opacity:0.7">${m.sender_type.toUpperCase()}:</strong><br>` + m.message.replace(/\n/g, '<br>');
                      body.appendChild(div);
                      adminLastMsgId = m.id;
                  }
              });
              if(d.messages.length > 0) {
                  body.scrollTop = body.scrollHeight;
              }
          }
      });
}

function adminSendChat() {
    const msg = document.getElementById('adminChatInput').value.trim();
    if(!msg || !adminActiveSessionId) return;
    document.getElementById('adminChatInput').value = '';
    
    const fd = new FormData();
    fd.append('session_id', adminActiveSessionId);
    fd.append('message', msg);
    fetch('api/chat_admin_api.php?action=send', {method:'POST', body:fd})
      .then(()=>syncAdminChat());
}

setInterval(() => {
    loadAdminChatList();
    syncAdminChat();
}, 3000);
loadAdminChatList();
</script>

@endsection