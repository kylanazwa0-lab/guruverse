<!-- Floating Chat Widget -->
<style>
#gbChatWidget { position: fixed; bottom: 24px; right: 24px; z-index: 10000; font-family: var(--font, 'Inter', sans-serif); }
#gbChatBtn { width: 56px; height: 56px; border-radius: 50%; background: linear-gradient(135deg, var(--c-primary, #6c5ce7), var(--c-primary-light, #a29bfe)); display: flex; align-items: center; justify-content: center; color: #fff; cursor: pointer; box-shadow: 0 10px 20px rgba(108,92,231,0.3); border: none; transition: transform 0.2s; }
#gbChatBtn:hover { transform: scale(1.05); }
#gbChatWindow { width: 340px; height: 520px; background: var(--c-card, #fff); border-radius: 16px; box-shadow: 0 15px 40px rgba(0,0,0,0.15); display: none; flex-direction: column; overflow: hidden; position: absolute; bottom: 70px; right: 0; border: 1px solid var(--c-border, #e2e8f0); }
#gbChatHeader { background: linear-gradient(135deg, var(--c-primary, #6c5ce7), var(--c-primary-light, #a29bfe)); padding: 16px; color: #fff; display: flex; align-items: center; justify-content: space-between; flex-shrink: 0; }
#gbChatBody { flex: 1; padding: 16px; overflow-y: auto; display: flex; flex-direction: column; gap: 10px; background: #f8fafc; }
/* Quick Reply Chips */
#gbQuickReplies { padding: 8px 12px 10px; background: var(--c-card, #fff); border-top: 1px solid #e2e8f0; flex-shrink: 0; display: flex; flex-wrap: wrap; gap: 6px; }
.gb-chip { background: #ede9fe; color: var(--c-primary, #6c5ce7); border: 1.5px solid #c4b5fd; border-radius: 20px; padding: 5px 12px; font-size: 11.5px; font-weight: 600; cursor: pointer; transition: all 0.15s; white-space: nowrap; line-height: 1.3; }
.gb-chip:hover { background: var(--c-primary, #6c5ce7); color: #fff; border-color: var(--c-primary, #6c5ce7); transform: translateY(-1px); }
/* Footer */
#gbChatFooter { padding: 10px 12px; border-top: 1px solid var(--c-border, #e2e8f0); display: flex; gap: 8px; background: var(--c-card, #fff); flex-shrink: 0; }
.gb-chat-msg { max-width: 85%; padding: 10px 14px; border-radius: 14px; font-size: 13px; line-height: 1.4; word-wrap: break-word; }
.gb-chat-msg.bot { background: #fff; color: #1e293b; align-self: flex-start; border-bottom-left-radius: 4px; border: 1px solid #e2e8f0; }
.gb-chat-msg.user { background: var(--c-primary, #6c5ce7); color: #fff; align-self: flex-end; border-bottom-right-radius: 4px; }
.gb-chat-msg.admin { background: #e0e7ff; color: #3730a3; align-self: flex-start; border-bottom-left-radius: 4px; border: 1px solid #c7d2fe; }
#gbChatInput { flex: 1; border: 1px solid #e2e8f0; border-radius: 20px; padding: 8px 14px; font-size: 13px; outline: none; background: #f8fafc; color: #1e293b; }
#gbChatInput:focus { border-color: var(--c-primary, #6c5ce7); background: #fff; }
#gbChatSend { background: var(--c-primary, #6c5ce7); border: none; color: #fff; width: 34px; height: 34px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; flex-shrink: 0; transition: opacity 0.15s; }
#gbChatSend:hover { opacity: 0.85; }
@keyframes gbDot { 0%,80%,100% { transform:scale(0.6); opacity:0.4; } 40% { transform:scale(1); opacity:1; } }
</style>

<div id="gbChatWidget">
  <div id="gbChatWindow">
    <div id="gbChatHeader">
      <div style="display:flex;align-items:center;gap:10px">
        <div style="width:32px;height:32px;background:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;">
          <img src="/guruverse/asset/img/logo guruverse FA.ai.png" style="width:18px;height:18px;object-fit:contain">
        </div>
        <div>
          <div style="font-weight:700;font-size:14px" id="gbChatTitle">Pusat Bantuan</div>
          <div style="font-size:11px;opacity:0.8" id="gbChatSubtitle">Tanya Guruverse</div>
        </div>
      </div>
      <button onclick="toggleGbChat()" style="background:transparent;border:none;color:#fff;cursor:pointer;font-size:16px;line-height:1">✕</button>
    </div>

    <div id="gbChatBody"></div>

    <!-- Quick Reply Suggestions -->
    <div id="gbQuickReplies">
      <div style="width:100%;font-size:10.5px;color:#94a3b8;font-weight:600;margin-bottom:2px;letter-spacing:.3px">💡 Pertanyaan cepat:</div>
      <button class="gb-chip" onclick="gbSendChip(this,'Bagaimana cara mendaftar kelas?')">📚 Cara daftar kelas</button>
      <button class="gb-chip" onclick="gbSendChip(this,'Kapan sertifikat saya bisa diunduh?')">🎓 Cek sertifikat</button>
      <button class="gb-chip" onclick="gbSendChip(this,'Saya lupa password akun saya')">🔑 Lupa password</button>
      <button class="gb-chip" onclick="gbSendChip(this,'Bagaimana cara mengerjakan quiz?')">📝 Cara kerjakan quiz</button>
      <button class="gb-chip" onclick="gbSendChip(this,'Ada masalah teknis di platform')">⚠️ Masalah teknis</button>
      <button class="gb-chip" onclick="gbSendChip(this,'Saya ingin berbicara dengan admin')">👤 Hubungi admin</button>
    </div>

    <div id="gbChatFooter">
      <input type="text" id="gbChatInput" placeholder="Ketik pesan..." onkeypress="if(event.key === 'Enter') sendGbChat()">
      <button id="gbChatSend" onclick="sendGbChat()">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
      </button>
    </div>
  </div>
  <button id="gbChatBtn" onclick="toggleGbChat()">
    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
  </button>
</div>

<script>
let gbChatSessionId = 0;
let gbChatLastId = 0;
let gbChatTimer = null;
let gbChatStatus = 'bot';
let gbUserHasChatted = false; // track if user has sent any message

function toggleGbChat() {
    const w = document.getElementById('gbChatWindow');
    if (w.style.display === 'flex') {
        w.style.display = 'none';
        if (gbChatTimer) { clearInterval(gbChatTimer); gbChatTimer = null; }
    } else {
        w.style.display = 'flex';
        if (!gbChatSessionId) {
            initGbChat();
        } else {
            if (gbChatTimer) clearInterval(gbChatTimer);
            gbChatTimer = setInterval(syncGbChat, 3000);
        }
        // Show chips only if user hasn't chatted yet
        updateChipsVisibility();
    }
}

function initGbChat() {
    if (gbChatTimer) { clearInterval(gbChatTimer); gbChatTimer = null; }
    fetch('api/chatbot.php?action=init')
      .then(r => r.json())
      .then(d => {
          if (d.success) {
              gbChatSessionId = d.session_id;
              gbChatStatus = d.status;
              syncGbChat();
              gbChatTimer = setInterval(syncGbChat, 3000);
          }
      });
}

function updateChipsVisibility() {
    const chips = document.getElementById('gbQuickReplies');
    if (!chips) return;
    // Hide chips once user has sent a message (or if in live admin mode)
    chips.style.display = (gbUserHasChatted || gbChatStatus === 'active') ? 'none' : 'flex';
}

function gbSendChip(btn, text) {
    // Fill input and send
    document.getElementById('gbChatInput').value = text;
    sendGbChat();
}

function renderGbChat(messages) {
    const body = document.getElementById('gbChatBody');

    messages.forEach(m => {
        if (m.id > gbChatLastId) {
            // Remove typing indicator if present
            const typing = body.querySelector('.gb-typing');
            if (typing) typing.remove();

            const div = document.createElement('div');
            div.className = 'gb-chat-msg ' + m.sender_type;
            div.innerHTML = m.message.replace(/\n/g, '<br>');
            body.appendChild(div);
            gbChatLastId = m.id;
        }
    });

    if (messages.length > 0) {
        body.scrollTop = body.scrollHeight;
    }
}

function showTypingIndicator() {
    const body = document.getElementById('gbChatBody');
    if (body.querySelector('.gb-typing')) return;
    const div = document.createElement('div');
    div.className = 'gb-chat-msg bot gb-typing';
    div.innerHTML = '<span style="display:inline-flex;gap:4px;align-items:center"><span style="width:6px;height:6px;border-radius:50%;background:#94a3b8;animation:gbDot 1.2s infinite 0s"></span><span style="width:6px;height:6px;border-radius:50%;background:#94a3b8;animation:gbDot 1.2s infinite 0.2s"></span><span style="width:6px;height:6px;border-radius:50%;background:#94a3b8;animation:gbDot 1.2s infinite 0.4s"></span></span>';
    body.appendChild(div);
    body.scrollTop = body.scrollHeight;
}

function syncGbChat() {
    if (!gbChatSessionId) return;
    fetch('api/chat_sync.php?session_id=' + gbChatSessionId + '&last_id=' + gbChatLastId)
      .then(r => r.json())
      .then(d => {
          if (d.success) {
              renderGbChat(d.messages);
              gbChatStatus = d.status;
              updateGbChatHeader();
              updateChipsVisibility();
          }
      });
}

function sendGbChat() {
    const inp = document.getElementById('gbChatInput');
    const msg = inp.value.trim();
    if (!msg) return;

    if (!gbChatSessionId) {
        // Session not yet initialized (API call still pending), try again in 300ms
        setTimeout(sendGbChat, 300);
        return;
    }

    inp.value = '';

    // Mark user has chatted → hide chips
    gbUserHasChatted = true;
    updateChipsVisibility();

    const body = document.getElementById('gbChatBody');
    const div = document.createElement('div');
    div.className = 'gb-chat-msg user';
    div.innerHTML = msg.replace(/\n/g, '<br>');
    body.appendChild(div);
    body.scrollTop = body.scrollHeight;
    showTypingIndicator();

    const fd = new FormData();
    fd.append('session_id', gbChatSessionId);
    fd.append('message', msg);

    fetch('api/chatbot.php?action=send', { method: 'POST', body: fd })
      .then(r => r.json())
      .then(() => { syncGbChat(); });
}

function updateGbChatHeader() {
    if (gbChatStatus === 'waiting_admin' || gbChatStatus === 'active') {
        document.getElementById('gbChatSubtitle').textContent = 'Live Chat: Admin';
    } else {
        document.getElementById('gbChatSubtitle').textContent = 'Tanya Guruverse';
    }
}
</script>
