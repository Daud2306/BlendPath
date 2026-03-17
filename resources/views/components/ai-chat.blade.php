{{-- AI Chat Sidebar Component --}}
<div id="ai-chat-wrapper">

    {{-- Toggle Button --}}
    <button id="ai-chat-toggle" title="BlendPath AI Assistant">
        <svg id="icon-chat" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
            viewBox="0 0 16 16">
            <path
                d="M8 1c-4.418 0-8 2.91-8 6.5 0 1.99 1.104 3.773 2.857 4.97L4 14l2.286-1.207A9.6 9.6 0 0 0 8 13c4.418 0 8-2.91 8-6.5S12.418 1 8 1z" />
        </svg>
        <svg id="icon-close" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
            viewBox="0 0 16 16" style="display:none">
            <path
                d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
        </svg>
        <span id="ai-badge" class="ai-notif-badge" style="display:none"></span>
    </button>

    {{-- Chat Panel --}}
    <div id="ai-chat-panel">
        {{-- Header --}}
        <div class="ai-chat-header">
            <div class="ai-avatar">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                    viewBox="0 0 16 16">
                    <path
                        d="M6 12.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5ZM3 8.062C3 6.76 4.235 5.765 5.53 5.886a26.58 26.58 0 0 0 4.94 0C11.765 5.765 13 6.76 13 8.062v1.157a.933.933 0 0 1-.765.935c-.845.147-2.34.346-4.235.346-1.895 0-3.39-.2-4.235-.346A.933.933 0 0 1 3 9.219V8.062Zm4.542-.827a.25.25 0 0 0-.217.068l-.92.9a24.767 24.767 0 0 1-1.871-.183.25.25 0 0 0-.068.495c.55.076 1.232.149 2.02.193a.25.25 0 0 0 .189-.071l.754-.736.847 1.71a.25.25 0 0 0 .404.062l.932-.97a25.286 25.286 0 0 0 1.922-.188.25.25 0 0 0-.068-.495c-.538.074-1.207.145-1.98.189a.25.25 0 0 0-.166.076l-.754.785-.842-1.7a.25.25 0 0 0-.182-.134Z" />
                    <path
                        d="M8.5 1.866a1 1 0 1 0-1 0V3h-2A4.5 4.5 0 0 0 1 7.5V8a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1v1a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-1a1 1 0 0 0 1-1V9a1 1 0 0 0-1-1v-.5A4.5 4.5 0 0 0 10.5 3h-2V1.866Z" />
                </svg>
            </div>
            <div class="ai-header-info">
                <span class="ai-name">BlendPath AI</span>
                <span class="ai-status"><span class="ai-dot"></span> Online</span>
            </div>
        </div>

        {{-- Messages --}}
        <div id="ai-messages" class="ai-messages">
            <div class="ai-msg ai-msg--bot">
                <div class="ai-bubble">
                    Halo, <strong>{{ Auth::user()->name }}</strong>! 👋<br>
                    Aku asisten AI BlendPath. Tanyakan apa saja seputar materi Blender!
                </div>
                <span class="ai-time">Sekarang</span>
            </div>
        </div>

        {{-- Input --}}
        <div class="ai-chat-input-area">
            <div class="ai-input-wrapper">
                <textarea id="ai-input" placeholder="Tanya seputar Blender..." rows="1" maxlength="1000"></textarea>
                <button id="ai-send-btn" title="Kirim">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                        viewBox="0 0 16 16">
                        <path
                            d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 3.178 4.995.002.002.26.41a.5.5 0 0 0 .886-.083l6-15Zm-1.833 1.89L6.637 10.07l-.215-.338a.5.5 0 0 0-.154-.154l-.338-.215 7.494-7.494 1.178-.471-.47 1.178Z" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>
