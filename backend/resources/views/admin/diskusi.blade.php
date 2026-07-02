@extends('layouts.admin')

@section('title', 'Forum Diskusi')
@section('page_title', 'Forum Diskusi')

@section('content')

<style>
/* WhatsApp-like layout overrides */
.wa-layout { display: flex; height: calc(100vh - 120px); background: #fff; border-radius: 16px; border: 1px solid var(--border); overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.03); }
.wa-sidebar { width: 340px; border-right: 1px solid var(--border); display: flex; flex-direction: column; background: #fff; flex-shrink: 0; }
.wa-main { flex: 1; display: flex; flex-direction: column; background: #efeae2; position: relative; min-width: 0; } /* WhatsApp Web default background color */
.wa-main::before { content: ''; position: absolute; inset: 0; background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cpath d="M54.627 0l.83.83v58.34h-58.34v-.83l.83-.83L54.628 0zM27.5 38c0-1.933-1.567-3.5-3.5-3.5s-3.5 1.567-3.5 3.5 1.567 3.5 3.5 3.5 3.5-1.567 3.5-3.5zm20 0c0-1.933-1.567-3.5-3.5-3.5s-3.5 1.567-3.5 3.5 1.567 3.5 3.5 3.5 3.5-1.567 3.5-3.5zm-40 0c0-1.933-1.567-3.5-3.5-3.5s-3.5 1.567-3.5 3.5 1.567 3.5 3.5 3.5 3.5-1.567 3.5-3.5zm20-20c0-1.933-1.567-3.5-3.5-3.5s-3.5 1.567-3.5 3.5 1.567 3.5 3.5 3.5 3.5-1.567 3.5-3.5zm20 0c0-1.933-1.567-3.5-3.5-3.5s-3.5 1.567-3.5 3.5 1.567 3.5 3.5 3.5 3.5-1.567 3.5-3.5zm-40 0c0-1.933-1.567-3.5-3.5-3.5s-3.5 1.567-3.5 3.5 1.567 3.5 3.5 3.5 3.5-1.567 3.5-3.5z" fill="%23000000" fill-opacity="0.04" fill-rule="evenodd"/%3E%3C/svg%3E'); opacity: 0.6; z-index: 0; pointer-events: none; }

.wa-list-item { display: flex; gap: 12px; padding: 12px 16px; border-bottom: 1px solid #f1f5f9; cursor: pointer; text-decoration: none; transition: background 0.2s; align-items: center; }
.wa-list-item:hover { background: #f8fafc; }
.wa-list-item.active { background: #f1f5f9; }

.wa-bubble { max-width: 75%; padding: 8px 12px; border-radius: 8px; margin-bottom: 12px; position: relative; box-shadow: 0 1px 1px rgba(0,0,0,0.1); z-index: 1; font-size: 0.85rem; line-height: 1.5; color: var(--t); }
.wa-bubble.left { align-self: flex-start; background: #fff; border-top-left-radius: 0; }
.wa-bubble.right { align-self: flex-end; background: #dcf8c6; border-top-right-radius: 0; } /* WhatsApp Green */

/* Scrollbar styling for chat */
.wa-scroll::-webkit-scrollbar { width: 6px; }
.wa-scroll::-webkit-scrollbar-track { background: transparent; }
.wa-scroll::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.15); border-radius: 4px; }
.wa-scroll::-webkit-scrollbar-thumb:hover { background: rgba(0,0,0,0.25); }
</style>

<div class="wa-layout">
  
  <!-- LEFT SIDEBAR -->
  <div class="wa-sidebar">
    <!-- Header Left -->
    <div style="padding:14px 16px;background:#f0f2f5;display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid #e2e8f0;flex-shrink:0">
      <div style="font-weight:800;color:var(--t);font-size:1.1rem;display:flex;align-items:center;gap:8px">
         <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color:var(--v1)"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
         Diskusi
      </div>
      <button onclick="document.getElementById('modal-new-topic').style.display='flex'" style="background:var(--v1);color:#fff;border:none;border-radius:50%;width:36px;height:36px;display:flex;align-items:center;justify-content:center;cursor:pointer;box-shadow:0 2px 5px rgba(0,0,0,0.15)" title="Topik Baru">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      </button>
    </div>
    
    <!-- Search Box -->
    <div style="padding:8px 12px;background:#fff;border-bottom:1px solid #f1f5f9;flex-shrink:0">
      <form method="GET" style="position:relative;display:flex;align-items:center">
        <input type="hidden" name="mod" value="diskusi">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="position:absolute;left:12px"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" name="q" value="{{ htmlspecialchars($q) }}" placeholder="Cari atau mulai percakapan baru" style="width:100%;padding:10px 10px 10px 38px;background:#f0f2f5;border:none;border-radius:12px;font-size:0.8rem;outline:none" onchange="this.form.submit()">
      </form>
    </div>

    <!-- Contact / Topic List -->
    <div class="wa-scroll" style="flex:1;overflow-y:auto;background:#fff">
      @if (empty($disks))
        <div style="padding:2rem;text-align:center;color:var(--muted);font-size:0.8rem">Tidak ada percakapan.</div>
      @else
@foreach($disks as $d)
@php
        $isActive = $topic_id == $d['id'];
        $authorName = $d['user_id'] == 0 ? 'Admin Guruverse' : ($d['author_name'] ?? 'Anonim');
        $initials = substr($authorName, 0, 1);
        $avatarColors = ['#8b2fc9','#06d6a0','#f8961e','#4cc9f0','#ef233c'];
        $avatarBg = $avatarColors[crc32($authorName) % count($avatarColors)];
@endphp
        <a href="?mod=diskusi&topic_id={{ $d['id'] }}" class="wa-list-item {{ $isActive ? 'active' : '' }}" data-topic-id="{{ $d['id'] }}" data-replies="{{ $d['replies_count'] }}">
          <div style="width:46px;height:46px;border-radius:50%;background:{{ $avatarBg }};color:#fff;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:1.2rem;flex-shrink:0">
             {{ strtoupper($initials) }}
          </div>
          <div style="flex:1;min-width:0">
            <div style="display:flex;justify-content:space-between;margin-bottom:2px">
              <div style="font-weight:700;color:var(--t);font-size:0.9rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ htmlspecialchars($d['title']) }}</div>
              <div style="font-size:0.65rem;color:var(--muted2);white-space:nowrap;margin-left:8px">{{ date('H:i', strtotime($d['created_at'])) }}</div>
            </div>
            <div style="display:flex;justify-content:space-between;align-items:center">
              <div style="font-size:0.8rem;color:var(--muted);white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                <span style="font-weight:600;color:var(--t2)">{{ htmlspecialchars($authorName) }}:</span> 
                {{ htmlspecialchars(substr($d['body'], 0, 50)) }}...
              </div>
              @if ($d['replies_count'] > 0)
                 <span class="badge-count" style="display:none;align-items:center;justify-content:center;background:var(--v1);color:#fff;font-size:0.6rem;font-weight:800;height:18px;min-width:18px;padding:0 5px;border-radius:10px;margin-left:6px"></span>
              @endif
            </div>
          </div>
        </a>
      @endforeach 
 @endif
    </div>
    
    <script>
      // Real-time unread badge logic using LocalStorage
      document.addEventListener('DOMContentLoaded', () => {
        let readTopics = JSON.parse(localStorage.getItem('guruverse_read_topics') || '{}');
        
        @if ($active_topic)
          // Mark active topic as fully read
          readTopics['{{ $active_topic['id'] }}'] = {{ $active_topic['replies_count'] }};
          localStorage.setItem('guruverse_read_topics', JSON.stringify(readTopics));
        @endif

        document.querySelectorAll('.wa-list-item').forEach(item => {
          let tid = item.getAttribute('data-topic-id');
          let totalReplies = parseInt(item.getAttribute('data-replies') || '0');
          let badge = item.querySelector('.badge-count');
          
          if(badge) {
            let readCount = readTopics[tid] || 0;
            let unread = totalReplies - readCount;
            // OP doesn't count as a reply in the badge, but if unread is > 0 show it
            if(unread > 0 && !item.classList.contains('active')) {
              badge.textContent = unread;
              badge.style.display = 'inline-flex';
            } else {
              badge.style.display = 'none';
            }
          }
        });
      });
    </script>
  </div>

  <!-- RIGHT CHAT AREA -->
  <div class="wa-main">
    @if (!$active_topic)
      <!-- Empty State -->
      <div style="flex:1;display:flex;flex-direction:column;align-items:center;justify-content:center;color:var(--muted);z-index:1">
        <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom:1rem"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><line x1="9" y1="3" x2="9" y2="21"/></svg>
        <h2 style="font-weight:300;font-size:1.8rem;color:var(--muted);margin-bottom:8px">Guruverse Diskusi</h2>
        <p style="font-size:0.9rem">Pilih percakapan di sebelah kiri untuk mulai membaca dan membalas pesan.</p>
      </div>
    @php else: 
      $opName = $active_topic['user_id'] == 0 ? 'Admin Guruverse' : ($active_topic['author_name'] ?? 'Anonim');
      $opInitials = substr($opName, 0, 1);
      $opColor = ['#8b2fc9','#06d6a0','#f8961e','#4cc9f0','#ef233c'][crc32($opName) % 5]; @endphp
      <!-- Header Right -->
      <div style="padding:10px 16px;background:#f0f2f5;display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid #e2e8f0;flex-shrink:0;z-index:10">
        <div style="display:flex;align-items:center;gap:12px;flex:1;min-width:0">
           <div style="width:40px;height:40px;border-radius:50%;background:{{ $opColor }};color:#fff;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:1.1rem;flex-shrink:0">
             {{ strtoupper($opInitials) }}
           </div>
           <div style="min-width:0;flex:1">
             <div style="font-weight:700;color:var(--t);font-size:0.95rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ htmlspecialchars($active_topic['title']) }}</div>
             <div style="font-size:0.7rem;color:var(--muted);white-space:nowrap;overflow:hidden;text-overflow:ellipsis">dibuat oleh {{ htmlspecialchars($opName) }} • Kategori: {{ htmlspecialchars($active_topic['category']) }}</div>
           </div>
        </div>
        
        <!-- Kebab Menu for Topic Actions -->
        <div class="dropdown relative inline-flex" style="width:auto;flex-shrink:0">
          <button type="button" class="dropdown-toggle" style="background:transparent;border:none;color:var(--muted);padding:8px;cursor:pointer">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
          </button>
          <ul class="dropdown-menu" style="min-width:160px;right:0;left:auto;padding:6px;box-shadow:0 10px 25px -5px rgba(0,0,0,0.15);z-index:100">
            <li><a class="dropdown-item" href="#" onclick="showToast('URL Copied','success');return false;" style="color:var(--t);font-weight:600;padding:10px 12px;display:flex;align-items:center;gap:8px"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg> Salin Tautan</a></li>
            <li>
              <form method="POST" class="form-delete" data-confirm="Hapus seluruh percakapan ini?" style="margin:0;width:100%">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="{{ $active_topic['id'] }}">
                <button type="submit" class="dropdown-item" style="color:#ef4444;width:100%;text-align:left;background:transparent;border:none;font-weight:600;padding:10px 12px;display:flex;align-items:center;gap:8px">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg> Hapus Topik
                </button>
              </form>
            </li>
          </ul>
        </div>
      </div>

      <!-- Chat History -->
      <div class="wa-scroll" style="flex:1;overflow-y:auto;padding:1.5rem 5%;display:flex;flex-direction:column;z-index:1" id="chat-history-container">
         
         <div style="text-align:center;margin-bottom:1.5rem">
           <span style="background:rgba(0,0,0,0.06);color:var(--muted);font-size:0.65rem;font-weight:700;padding:4px 12px;border-radius:12px;text-transform:uppercase">{{ date('d F Y', strtotime($active_topic['created_at'])) }}</span>
         </div>

         <!-- OP Bubble -->
         <div class="wa-bubble {{ $active_topic['user_id'] == 0 ? 'right' : 'left' }}">
           @if ($active_topic['user_id'] != 0)
             <div style="font-size:0.75rem;font-weight:800;color:{{ $opColor }};margin-bottom:4px">{{ htmlspecialchars($opName) }}</div>
           @endif
           <div style="font-weight:700;margin-bottom:4px;color:var(--t)">{{ htmlspecialchars($active_topic['title']) }}</div>
           <div>{{ nl2br(htmlspecialchars($active_topic['body'])) }}</div>
           <div style="font-size:0.6rem;color:var(--muted);text-align:right;margin-top:4px">{{ date('H:i', strtotime($active_topic['created_at'])) }}</div>
         </div>

         <!-- Replies Bubbles -->
         @php foreach($replies as $r): 
           $isOp = $r['user_id'] == $active_topic['user_id'];
           $isAdmin = $r['user_id'] == 0;
           $isBot = $r['user_id'] == -99;
           
           if ($isBot) {
               $rName = 'Guruverse Bot 🤖';
               $rColor = '#3b82f6'; // Blue for bot
           } else {
               $rName = $isAdmin ? 'Admin Guruverse' : ($r['replier_name'] ?? 'Anonim');
               $rColor = ['#8b2fc9','#06d6a0','#f8961e','#4cc9f0','#ef233c'][crc32($rName) % 5];
           } @endphp
           <div class="wa-bubble {{ $isAdmin ? 'right' : 'left' }}" {{ $isBot ? 'style="background:#f0f9ff; border:1px solid #bae6fd"' : '' }}>
             @if (!$isAdmin)
               <div style="font-size:0.75rem;font-weight:800;color:{{ $rColor }};margin-bottom:4px;display:flex;align-items:center;gap:4px">
                  {{ htmlspecialchars($rName) }} 
                  {{ $isBot ? '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 8V4H8"/><rect x="4" y="8" width="16" height="12" rx="2"/><path d="M2 14h2"/><path d="M20 14h2"/><path d="M15 13v2"/><path d="M9 13v2"/></svg>' : '' }}
                  {{ $isOp && !$isBot ? '<span style="font-size:0.6rem;background:rgba(0,0,0,0.05);padding:1px 4px;border-radius:4px;color:var(--muted);margin-left:4px">OP</span>' : '' }}
               </div>
             @endif
             <div>{{ nl2br(htmlspecialchars($r['body'])) }}</div>
             @if (!empty($r['attachment_path']))
               <div style="margin-top:6px">
                 <a href="{{ htmlspecialchars($r['attachment_path']) }}" target="_blank" style="display:inline-flex;align-items:center;gap:6px;background:rgba(0,0,0,0.06);padding:6px 12px;border-radius:8px;text-decoration:none;font-size:0.75rem;color:var(--v1);font-weight:700">
                   <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>
                   Lihat Lampiran
                 </a>
               </div>
             @endif
             <div style="font-size:0.6rem;color:var(--muted);text-align:right;margin-top:4px">{{ date('H:i', strtotime($r['created_at'])) }}</div>
           </div>
         @endforeach
      </div>

      <!-- Input Area -->
      <div style="padding:12px 16px;background:#f0f2f5;border-top:1px solid #e2e8f0;flex-shrink:0;z-index:1">
        <form method="POST" enctype="multipart/form-data" style="display:flex;gap:12px;align-items:center">
          <input type="hidden" name="action" value="reply">
          <input type="hidden" name="discussion_id" value="{{ $active_topic['id'] }}">
          <input type="file" name="attachment" id="reply-attachment" style="display:none" onchange="document.getElementById('att-badge').style.display='flex'">
          <button type="button" onclick="document.getElementById('reply-attachment').click()" style="background:none;border:none;color:var(--muted);cursor:pointer;padding:8px;position:relative" title="Lampirkan File">
             <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>
             <span id="att-badge" style="display:none;position:absolute;top:2px;right:2px;width:10px;height:10px;background:#10b981;border-radius:50%;border:2px solid #f0f2f5"></span>
          </button>
          <input type="text" name="body" required placeholder="Ketik pesan sebagai Admin..." autocomplete="off" style="flex:1;padding:12px 16px;background:#fff;border:1px solid var(--border);border-radius:24px;font-size:0.9rem;outline:none;box-shadow:inset 0 1px 2px rgba(0,0,0,0.02)">
          <button type="submit" style="background:var(--v1);color:#fff;border:none;border-radius:50%;width:44px;height:44px;display:flex;align-items:center;justify-content:center;cursor:pointer;box-shadow:0 2px 5px rgba(0,0,0,0.15)">
             <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-left:-2px"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
          </button>
        </form>
      </div>

      <script>
         // Auto-scroll to bottom of chat
         const chatBox = document.getElementById('chat-history-container');
         if(chatBox) chatBox.scrollTop = chatBox.scrollHeight;
      </script>

    @endif
  </div>

</div>

<!-- Modal Tambah Topik Diskusi -->
<div class="overlay" id="modal-new-topic" style="display:none;z-index:9999" onclick="if(event.target===this)this.style.display='none'">
  <div class="modal modal-md">
    <div class="modal-head">
      <span class="modal-title">Buat Topik Baru</span>
      <button type="button" class="modal-close" onclick="document.getElementById('modal-new-topic').style.display='none'">×</button>
    </div>
    <form method="POST" class="modal-body">
      <input type="hidden" name="action" value="new_topic">
      <div class="fg">
        <label>Judul Topik</label>
        <input type="text" name="title" class="fi" required placeholder="Contoh: Info Pemeliharaan Sistem">
      </div>
      <div class="fg">
        <label>Kategori</label>
        <select name="category" class="fi">
          <option value="Informasi Umum">Informasi Umum</option>
          <option value="Pengumuman">Pengumuman</option>
          <option value="Tanya Jawab">Tanya Jawab</option>
        </select>
      </div>
      <div class="fg">
        <label>Pesan Pertama (Isi Topik)</label>
        <textarea name="body" class="fi" required placeholder="Tuliskan isi diskusi di sini..." style="min-height:100px;resize:vertical"></textarea>
      </div>
      <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:1.5rem">
        <button type="button" class="btn" style="background:#f1f5f9;color:#475569;border:none" onclick="document.getElementById('modal-new-topic').style.display='none'">Batal</button>
        <button type="submit" class="btn btn-primary">Mulai Diskusi</button>
      </div>
    </form>
  </div>
</div>

@endsection