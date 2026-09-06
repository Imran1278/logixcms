<!-- Floating AI Chatbot Widget -->
<div id="aiChatbotWidget" class="position-fixed bottom-0 end-0 m-3 m-md-4" style="z-index: 1080;">
    
    <!-- Trigger Floating Button -->
    <button id="chatbotToggleBtn" class="btn rounded-circle shadow-lg d-flex align-items-center justify-content-center p-0 position-relative border-0" aria-label="Toggle AI Chatbot">
        <i class="fa-solid fa-robot fs-4 text-white" id="chatOpenIcon"></i>
        <i class="fa-solid fa-xmark fs-4 text-white d-none" id="chatCloseIcon"></i>
        <span class="online-indicator-dot"></span>
    </button>

    <!-- Chat Interface Container -->
    <div id="chatbotWindow" class="card border-0 shadow-2xl rounded-4 overflow-hidden d-none mt-3">
        
        <!-- Header -->
        <div class="card-header p-3 d-flex align-items-center justify-content-between border-0 chat-header-bg">
            <div class="d-flex align-items-center gap-3">
                <div class="bot-avatar-icon d-flex align-items-center justify-content-center rounded-circle">
                    <i class="fa-solid fa-robot fs-5"></i>
                </div>
                <div>
                    <h6 class="fw-bold mb-0 text-white font-heading">LOGIX AI Assistant</h6>
                    <small class="text-white-50 extra-small d-flex align-items-center gap-1">
                        <span class="status-pulse"></span> Online | Instant Support
                    </small>
                </div>
            </div>
            <button id="chatHeaderClose" class="btn-close btn-close-white opacity-75 shadow-none" aria-label="Close"></button>
        </div>

        <!-- Messages Area -->
        <div class="card-body p-3 overflow-y-auto d-flex flex-column gap-3 chat-messages-container" id="chatMessages">
            <div class="d-flex align-items-start gap-2">
                <div class="bot-chat-bubble p-3 rounded-4 bg-white text-dark fs-7 shadow-xs border">
                    Aoa! Main <strong>LOGIX AI Assistant</strong> hoon. LOGIX College ke courses, admissions, ya timing ke baare mein aap koi bhi sawal pooch sakte hain! 👋
                </div>
            </div>
        </div>

        <!-- Input Section -->
        <div class="card-footer bg-white border-top p-3">
            <form id="chatbotForm" class="d-flex gap-2 align-items-center">
                <input type="text" id="chatInput" class="form-control form-control-sm rounded-pill px-3 py-2 border-slate shadow-none font-body fs-7" placeholder="Ask your question here..." required autocomplete="off">
                <button type="submit" class="btn btn-send-gold rounded-circle p-0 d-flex align-items-center justify-content-center flex-shrink-0" aria-label="Send Message">
                    <i class="fa-solid fa-paper-plane fs-7"></i>
                </button>
            </form>
        </div>

    </div>
</div>

<style>
    :root {
        --bot-navy: #0B2545;
        --bot-navy-dark: #051329;
        --bot-gold: #D4AF37;
        --bot-teal: #00D2C4;
    }

    .fs-7 { font-size: 0.85rem; }
    .extra-small { font-size: 0.72rem; }

    /* Main Floating Trigger Button */
    #chatbotToggleBtn {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, var(--bot-navy) 0%, var(--bot-navy-dark) 100%);
        border: 2px solid var(--bot-gold) !important;
        transition: transform 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    #chatbotToggleBtn:hover {
        transform: scale(1.08);
    }

    .online-indicator-dot {
        position: absolute;
        top: 2px;
        right: 2px;
        width: 14px;
        height: 14px;
        background-color: #10B981;
        border: 2px solid #FFFFFF;
        border-radius: 50%;
    }

    /* Floating Chat Box Panel */
    #chatbotWindow {
        width: 360px;
        height: 500px;
        position: absolute;
        bottom: 75px;
        right: 0;
        background: #F8FAFC;
        animation: chatSlideUp 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes chatSlideUp {
        from { opacity: 0; transform: translateY(12px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 576px) {
        #chatbotWindow {
            width: calc(100vw - 32px);
            right: 0;
        }
    }

    .chat-header-bg {
        background: linear-gradient(135deg, var(--bot-navy) 0%, var(--bot-navy-dark) 100%);
    }

    .bot-avatar-icon {
        width: 38px;
        height: 38px;
        background: rgba(212, 175, 55, 0.2);
        border: 1px solid var(--bot-gold);
        color: var(--bot-gold);
    }

    .status-pulse {
        width: 7px;
        height: 7px;
        background-color: #10B981;
        border-radius: 50%;
        display: inline-block;
    }

    .chat-messages-container {
        height: 360px;
        background-color: #F8FAFC;
    }

    .bot-chat-bubble {
        max-width: 85%;
        border-top-left-radius: 4px !important;
        border-color: #E2E8F0 !important;
        line-height: 1.5;
    }

    .user-chat-bubble {
        max-width: 85%;
        background: var(--bot-navy);
        color: #FFFFFF;
        border-top-right-radius: 4px !important;
        line-height: 1.5;
    }

    .border-slate {
        border-color: #E2E8F0;
    }

    .btn-send-gold {
        width: 38px;
        height: 38px;
        background: linear-gradient(135deg, #EAD074 0%, #C49A21 100%);
        color: #FFFFFF;
        border: none;
        transition: transform 0.2s ease;
    }
    .btn-send-gold:hover {
        transform: scale(1.05);
    }
</style>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const toggleBtn = document.getElementById('chatbotToggleBtn');
    const chatWindow = document.getElementById('chatbotWindow');
    const headerClose = document.getElementById('chatHeaderClose');
    const openIcon = document.getElementById('chatOpenIcon');
    const closeIcon = document.getElementById('chatCloseIcon');
    const chatForm = document.getElementById('chatbotForm');
    const chatInput = document.getElementById('chatInput');
    const chatMessages = document.getElementById('chatMessages');

    function toggleChat() {
        chatWindow.classList.toggle('d-none');
        openIcon.classList.toggle('d-none');
        closeIcon.classList.toggle('d-none');
    }

    toggleBtn.addEventListener('click', toggleChat);
    if (headerClose) headerClose.addEventListener('click', toggleChat);

    chatForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const message = chatInput.value.trim();
        if (!message) return;

        appendMessage(message, 'user');
        chatInput.value = '';

        const loadingId = appendLoading();

        fetch("{{ route('student.chatbot') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ message: message })
        })
        .then(response => response.json())
        .then(data => {
            removeLoading(loadingId);
            if (data.status === 'success') {
                appendMessage(data.reply, 'bot');
            } else {
                appendMessage(data.reply || 'Mazaarat, abhi response process nahi ho saka.', 'bot');
            }
        })
        .catch(error => {
            removeLoading(loadingId);
            appendMessage('Network connection error. Please try again.', 'bot');
        });
    });

    function appendMessage(text, sender) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `d-flex align-items-start gap-2 ${sender === 'user' ? 'justify-content-end' : ''}`;
        
        const contentDiv = document.createElement('div');
        contentDiv.className = `p-3 rounded-4 fs-7 shadow-xs ${sender === 'user' ? 'user-chat-bubble' : 'bot-chat-bubble bg-white text-dark border'}`;
        contentDiv.innerText = text;

        messageDiv.appendChild(contentDiv);
        chatMessages.appendChild(messageDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function appendLoading() {
        const id = 'loading_' + Date.now();
        const loadingDiv = document.createElement('div');
        loadingDiv.id = id;
        loadingDiv.className = 'd-flex align-items-start gap-2';
        loadingDiv.innerHTML = `
            <div class="p-2 px-3 rounded-4 bg-white border text-muted fs-7 shadow-xs bot-chat-bubble">
                <span class="spinner-grow spinner-grow-sm me-1 text-warning" role="status"></span> Processing...
            </div>
        `;
        chatMessages.appendChild(loadingDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
        return id;
    }

    function removeLoading(id) {
        const element = document.getElementById(id);
        if (element) element.remove();
    }
});
</script>