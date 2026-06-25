<x-app-layout>
<x-slot name="header"></x-slot>

<style>
    body { overflow: hidden; }
    .py-12, .py-6 { padding-top: 0 !important; padding-bottom: 0 !important; }
    main > .max-w-7xl,
    main > .container { padding: 0 !important; max-width: 100% !important; }
</style>
<div class="chat-wrapper">
    {{-- Sidebar: liste des users --}}
    <aside class="chat-sidebar">
        <div class="sidebar-header">
            <span class="sidebar-title">{{ Auth::user()->name }}</span>
            <button class="icon-btn" title="Nouveau message">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
                </svg>
            </button>
        </div>

        <div class="sidebar-search">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="search-icon">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            <input type="text" placeholder="Rechercher" id="searchUsers" />
        </div>

        <ul class="user-list" id="userList">
            @foreach($users as $user)
                @if($user->id !== Auth::id())
                    @php
                        $lastMsg = $messages->where(function($m) use ($user) {
                            return ($m->sender_id === $user->id && $m->receiver_id === Auth::id())
                                || ($m->sender_id === Auth::id() && $m->receiver_id === $user->id);
                        })->sortByDesc('created_at')->first();
                    @endphp
                 <li class="user-item {{ request('user') == $user->id ? 'active' : '' }}" data-name="{{ strtolower($user->name) }}">
    <a href="{{ route('chat.index', ['user' => $user->id]) }}" class="flex items-center space-x-2 block px-3 py-2 rounded-md hover:bg-blue-100">
        <div class="avatar">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
        <div class="user-info">
            <span class="user-name">{{ $user->name }}</span>
            <span class="user-preview">
                {{ $lastMsg ? Str::limit($lastMsg->content, 28) : 'Démarrer une conversation' }}
            </span>
        </div>
    </a>
</li>


                @endif
            @endforeach
        </ul>
    </aside>

    {{-- Zone de conversation --}}
    <main class="chat-main">
        @if(request('user'))
            @php $chatUser = $users->find(request('user')); @endphp

            {{-- Header conversation --}}
            <div class="chat-header">
                <div class="avatar avatar-sm">
                    {{ strtoupper(substr($chatUser->name, 0, 1)) }}
                </div>
                <span class="chat-username">{{ $chatUser->name }}</span>
            </div>

            {{-- Messages --}}
            <div class="messages-area" id="messagesArea">
                @php
                    $conv = $messages->filter(function($m) use ($chatUser) {
                        return ($m->sender_id === $chatUser->id && $m->receiver_id === Auth::id())
                            || ($m->sender_id === Auth::id() && $m->receiver_id === $chatUser->id);
                    })->sortBy('created_at');
                @endphp

                @forelse($conv as $message)
                    <div class="message-row {{ $message->sender_id === Auth::id() ? 'mine' : 'theirs' }}">
                        @if($message->sender_id !== Auth::id())
                            <div class="avatar avatar-xs">
                                {{ strtoupper(substr($chatUser->name, 0, 1)) }}
                            </div>
                        @endif
                        <div class="bubble">
                            {{ $message->content }}
                        </div>
                    </div>
                @empty
                    <div class="empty-conv">
                        <div class="avatar avatar-lg">
                            {{ strtoupper(substr($chatUser->name, 0, 1)) }}
                        </div>
                        <p class="empty-name">{{ $chatUser->name }}</p>
                        <p class="empty-hint">Commencez à discuter avec {{ $chatUser->name }}</p>
                    </div>
                @endforelse
            </div>

            {{-- Input message --}}
            <div class="chat-input-area">
                <form id="msgForm" class="input-form">
                    @csrf
                    <input type="hidden" name="receiver_id" value="{{ $chatUser->id }}">
                    <button type="button" class="icon-btn" id="emojiBtn" title="Emoji">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/><path d="M8 13s1.5 2 4 2 4-2 4-2"/>
                            <line x1="9" y1="9" x2="9.01" y2="9"/><line x1="15" y1="9" x2="15.01" y2="9"/>
                        </svg>
                    </button>
                    <input type="text" name="content" id="msgContent" placeholder="Message..." autocomplete="off" />
                    <button type="submit" class="send-btn" id="sendBtn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/>
                        </svg>
                    </button>
                </form>
                
                {{-- Emoji Picker Container --}}
                <div id="emojiPickerContainer" class="emoji-picker-container" style="display: none;"></div>
            </div>

        @else
            {{-- Aucune conversation sélectionnée --}}
            <div class="no-conv">
                <div class="no-conv-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                    </svg>
                </div>
                <h3>Vos messages</h3>
                <p>Sélectionnez une conversation à gauche pour commencer.</p>
            </div>
        @endif
    </main>
</div>

<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

body { background: #fafafa; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; }

.chat-wrapper {
    display: flex;
    height: calc(100vh - 64px); /* 64px = hauteur navbar app layout */
    max-width: 960px;
    margin: 0 auto;
    background: #fff;
    border-left: 1px solid #dbdbdb;
    border-right: 1px solid #dbdbdb;
}

/* ── Sidebar ── */
.chat-sidebar {
    width: 360px;
    min-width: 360px;
    border-right: 1px solid #dbdbdb;
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

.sidebar-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 20px;
    border-bottom: 1px solid #dbdbdb;
}

.sidebar-title {
    font-size: 16px;
    font-weight: 600;
    color: #111;
}

.icon-btn {
    background: none;
    border: none;
    cursor: pointer;
    color: #111;
    display: flex;
    align-items: center;
    padding: 4px;
    border-radius: 6px;
    transition: background .15s;
}
.icon-btn:hover { background: #f0f0f0; }

.sidebar-search {
    position: relative;
    padding: 10px 14px;
    border-bottom: 1px solid #dbdbdb;
}
.search-icon {
    position: absolute;
    left: 26px;
    top: 50%;
    transform: translateY(-50%);
    color: #8e8e8e;
    pointer-events: none;
}
.sidebar-search input {
    width: 100%;
    background: #efefef;
    border: none;
    border-radius: 8px;
    padding: 8px 12px 8px 32px;
    font-size: 14px;
    color: #111;
    outline: none;
}
.sidebar-search input::placeholder { color: #8e8e8e; }

.user-list {
    list-style: none;
    overflow-y: auto;
    flex: 1;
}
.user-list::-webkit-scrollbar { width: 4px; }
.user-list::-webkit-scrollbar-thumb { background: #dbdbdb; border-radius: 4px; }

.user-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 16px;
    cursor: pointer;
    transition: background .12s;
}
.user-item:hover { background: #fafafa; }
.user-item.active { background: #f0f0f0; }

.user-info {
    display: flex;
    flex-direction: column;
    min-width: 0;
}
.user-name {
    font-size: 14px;
    font-weight: 600;
    color: #111;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.user-preview {
    font-size: 13px;
    color: #8e8e8e;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* ── Avatar ── */
.avatar {
    width: 44px;
    height: 44px;
    border-radius: 50%;
background: linear-gradient(135deg, #1e3c72, #2a5298);    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    font-weight: 600;
    color: #fff;
    flex-shrink: 0;
    letter-spacing: 0;
}
.avatar-sm { width: 32px; height: 32px; font-size: 13px; }
.avatar-xs { width: 28px; height: 28px; font-size: 11px; flex-shrink: 0; }
.avatar-lg { width: 72px; height: 72px; font-size: 28px; margin-bottom: 16px; }

/* ── Chat main ── */
.chat-main {
    flex: 1;
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

.chat-header {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 14px 20px;
    border-bottom: 1px solid #dbdbdb;
}
.chat-username {
    font-size: 15px;
    font-weight: 600;
    color: #111;
}

/* ── Messages ── */
.messages-area {
    flex: 1;
    overflow-y: auto;
    padding: 20px 16px;
    display: flex;
    flex-direction: column;
    gap: 6px;
}
.messages-area::-webkit-scrollbar { width: 4px; }
.messages-area::-webkit-scrollbar-thumb { background: #dbdbdb; border-radius: 4px; }

.message-row {
    display: flex;
    align-items: flex-end;
    gap: 8px;
}
.message-row.mine { justify-content: flex-end; }
.message-row.theirs { justify-content: flex-start; }

.bubble {
    max-width: 65%;
    padding: 10px 14px;
    border-radius: 22px;
    font-size: 14px;
    line-height: 1.45;
    word-break: break-word;
}
.mine .bubble {
    background: #111;
    color: #fff;
    border-bottom-right-radius: 6px;
}
.theirs .bubble {
    background: #efefef;
    color: #111;
    border-bottom-left-radius: 6px;
}

/* ── Empty states ── */
.empty-conv {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 40px 20px;
    text-align: center;
}
.empty-name {
    font-size: 15px;
    font-weight: 600;
    color: #111;
    margin-bottom: 6px;
}
.empty-hint {
    font-size: 13px;
    color: #8e8e8e;
}

.no-conv {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 12px;
    color: #8e8e8e;
    text-align: center;
    padding: 40px;
}
.no-conv-icon {
    width: 88px;
    height: 88px;
    border-radius: 50%;
    border: 2px solid #111;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #111;
    margin-bottom: 8px;
}
.no-conv h3 { font-size: 20px; font-weight: 300; color: #111; }
.no-conv p { font-size: 14px; }

/* ── Input ── */
.chat-input-area {
    border-top: 1px solid #dbdbdb;
    padding: 12px 16px;
}
.input-form {
    display: flex;
    align-items: center;
    gap: 8px;
    border: 1px solid #dbdbdb;
    border-radius: 24px;
    padding: 6px 10px 6px 14px;
}
.input-form input[type="text"] {
    flex: 1;
    border: none;
    outline: none;
    font-size: 14px;
    background: transparent;
    color: #111;
}
.input-form input::placeholder { color: #8e8e8e; }

.send-btn {
    background: none;
    border: none;
    cursor: pointer;
    color: #0095f6;
    display: flex;
    align-items: center;
    padding: 4px;
    border-radius: 50%;
    transition: opacity .15s;
}
.send-btn:hover { opacity: .7; }
.send-btn:disabled { opacity: .3; cursor: default; }

@media (max-width: 640px) {
    .chat-sidebar { width: 80px; min-width: 80px; }
    .sidebar-search, .user-info, .sidebar-title { display: none; }
    .sidebar-header { justify-content: center; }
    .user-item { justify-content: center; padding: 10px 0; }
}

/* ── Emoji Picker ── */
.emoji-picker-container {
    position: absolute;
    bottom: 70px;
    left: 16px;
    width: 352px;
    height: 415px;
    background: #fff;
    border: 1px solid #dbdbdb;
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    z-index: 1000;
    overflow: hidden;
    display: none !important;
}

.emoji-picker-container.active {
    display: block !important;
}

em-emoji-picker {
    width: 100% !important;
    height: 100% !important;
}

/* Personnalisation des styles emoji-mart */
:root {
    --em-rgb-accent: 0, 149, 246;
    --em-rgb-background: 255, 255, 255;
    --em-rgb-border: 219, 219, 219;
}

</style>

<script>
// Scroll to bottom on load
const area = document.getElementById('messagesArea');
if (area) area.scrollTop = area.scrollHeight;

// Recherche user
const search = document.getElementById('searchUsers');
if (search) {
    search.addEventListener('input', function() {
        const q = this.value.toLowerCase();
        document.querySelectorAll('.user-item').forEach(item => {
            item.style.display = item.dataset.name.includes(q) ? '' : 'none';
        });
    });
}

// Envoi message AJAX
const form = document.getElementById('msgForm');
if (form) {
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        const input = document.getElementById('msgContent');
        const content = input.value.trim();
        if (!content) return;

        const btn = document.getElementById('sendBtn');
        btn.disabled = true;

        try {
            const res = await fetch('{{ route("messages.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    receiver_id: form.querySelector('[name="receiver_id"]').value,
                    content: content
                })
            });

            if (res.ok) {
                const msg = await res.json();
                appendMessage(msg.content, true);
                input.value = '';
            }
        } catch(err) {
            console.error(err);
        } finally {
            btn.disabled = false;
            input.focus();
        }
    });
}

function appendMessage(content, isMine) {
    const area = document.getElementById('messagesArea');
    const empty = area.querySelector('.empty-conv');
    if (empty) empty.remove();

    const row = document.createElement('div');
    row.className = 'message-row ' + (isMine ? 'mine' : 'theirs');
    row.innerHTML = `<div class="bubble">${escapeHtml(content)}</div>`;
    area.appendChild(row);
    area.scrollTop = area.scrollHeight;
}

function escapeHtml(text) {
    return text.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
}


</script>
</x-app-layout>

<script type="module">
// Charger emoji-mart depuis CDN
import { Picker } from 'https://cdn.jsdelivr.net/npm/emoji-mart@latest/dist/index.mjs';

// Attendre que le DOM soit prêt
document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('emojiPickerContainer');
    const emojiBtn = document.getElementById('emojiBtn');
    const input = document.getElementById('msgContent');

    if (container && emojiBtn && input) {
        // Initialiser le picker
        const picker = new Picker({
            onEmojiSelect: (emoji) => {
                input.value += emoji.native;
                input.focus();
                container.classList.remove('active');
            },
            theme: 'light',
            native: true,
            previewPosition: 'none',
            searchPosition: 'sticky',
            maxFrequentRows: 3,
        });

        // Ajouter le picker au conteneur
        container.appendChild(picker);

        // Toggle emoji picker
        emojiBtn.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            container.classList.toggle('active');
        });

        // Fermer le picker en cliquant ailleurs
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.chat-input-area')) {
                container.classList.remove('active');
            }
        });

        // Empêcher la fermeture quand on clique dans le picker
        container.addEventListener('click', (e) => {
            e.stopPropagation();
        });
    }
});
</script>
