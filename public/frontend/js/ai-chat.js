(function () {
    const CSRF = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const panel = document.getElementById('ai-chat-panel');
    const toggle = document.getElementById('ai-chat-toggle');
    const messages = document.getElementById('ai-messages');
    const input = document.getElementById('ai-input');
    const sendBtn = document.getElementById('ai-send-btn');

    let chatHistory = [];
    let isOpen = false;

    // Tombol bulat → buka/tutup panel
    toggle.addEventListener('click', function () {
        isOpen = !isOpen;
        panel.classList.toggle('active', isOpen);
        if (isOpen) {
            setTimeout(() => input.focus(), 300);
            scrollToBottom();
        }
    });

    function scrollToBottom() {
        messages.scrollTop = messages.scrollHeight;
    }

    function getCurrentTime() {
        return new Date().toLocaleTimeString('id-ID', {
            hour: '2-digit',
            minute: '2-digit'
        });
    }

    function formatText(text) {
        return text
            .replace(/\[IMG:(https?:\/\/[^\]]+)\]/g, '___IMG___$1___END___')
            .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
            .replace(/\n/g, '<br>')
            .replace(/___IMG___(https?:\/\/[^_]+)___END___/g, function (match, url) {
                return `<div class="ai-img-wrapper">
                            <img src="${url}"
                                 alt="Ilustrasi Blender"
                                 class="ai-img"
                                 loading="lazy"
                                 onerror="this.parentElement.style.display='none'">
                        </div>`;
            });
    }

    function appendMessage(role, text) {
        const div = document.createElement('div');
        div.className = `ai-msg ai-msg--${role === 'user' ? 'user' : 'bot'}`;
        div.innerHTML = `
            <div class="ai-bubble">${formatText(text)}</div>
            <span class="ai-time">${getCurrentTime()}</span>
        `;
        messages.appendChild(div);
        scrollToBottom();
        return div;
    }

    function showTyping() {
        const div = document.createElement('div');
        div.className = 'ai-msg ai-msg--bot ai-typing';
        div.id = 'ai-typing-indicator';
        div.innerHTML = `
            <div class="ai-bubble">
                <span class="ai-typing-dot"></span>
                <span class="ai-typing-dot"></span>
                <span class="ai-typing-dot"></span>
            </div>
        `;
        messages.appendChild(div);
        scrollToBottom();
    }

    function removeTyping() {
        const t = document.getElementById('ai-typing-indicator');
        if (t) t.remove();
    }

    async function sendMessage() {
        const text = input.value.trim();
        if (!text) return;

        input.value = '';
        input.style.height = 'auto';
        sendBtn.disabled = true;

        appendMessage('user', text);
        chatHistory.push({ role: 'user', content: text });
        showTyping();

        try {
            const res = await fetch('/ai/chat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    message: text,
                    history: chatHistory.slice(0, -1),
                }),
            });

            const data = await res.json();
            removeTyping();

            const reply = data.reply || 'Maaf, tidak ada respons dari AI.';
            appendMessage('bot', reply);
            chatHistory.push({ role: 'assistant', content: reply });

            if (chatHistory.length > 20) {
                chatHistory = chatHistory.slice(-20);
            }

        } catch (err) {
            removeTyping();
            appendMessage('bot', 'Gagal terhubung ke server. Coba lagi ya! 🙏');
        }

        sendBtn.disabled = false;
        input.focus();
    }

    sendBtn.addEventListener('click', sendMessage);

    input.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendMessage();
        }
    });

    input.addEventListener('input', function () {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 100) + 'px';
    });

    messages.addEventListener('click', function (e) {
        if (e.target.classList.contains('ai-img')) {
            window.open(e.target.src, '_blank');
        }
    });

})();