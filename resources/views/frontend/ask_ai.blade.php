@extends('admin.admin_master')

@section('page_title', 'Ask AI')

@push('css')
<style>
    .chat-container { height: calc(100vh - 280px); min-height: 400px; }
    .message-user { background: #004161; color: white; border-radius: 18px 18px 4px 18px; }
    .message-ai   { background: white; color: #1f2937; border-radius: 18px 18px 18px 4px; border: 1px solid #e5e7eb; }
    .typing-dot   { width: 8px; height: 8px; background: #99CC33; border-radius: 50%; animation: bounce 1.2s infinite; }
    .typing-dot:nth-child(2) { animation-delay: 0.2s; }
    .typing-dot:nth-child(3) { animation-delay: 0.4s; }
    @keyframes bounce { 0%,60%,100%{transform:translateY(0)} 30%{transform:translateY(-8px)} }
    pre { white-space: pre-wrap; word-wrap: break-word; font-family: inherit; }
</style>
@endpush

@section('admin')
<div class="p-6" x-data="askAi()">

    {{-- Header --}}
    <div class="mb-6 flex items-center gap-4">
        <div class="w-12 h-12 rounded-2xl bg-primary flex items-center justify-center shadow-lg">
            <i class="bi bi-stars text-accent text-2xl"></i>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-primary">Ask AI</h1>
            <p class="text-gray-500 text-sm">Weydii su'aasha xogta ganacsigaaga — Afsomali ama Ingiriis</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

        {{-- Chat panel --}}
        <div class="lg:col-span-3 bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col overflow-hidden" style="height: calc(100vh - 240px); min-height:500px;">

            {{-- Messages --}}
            <div id="chatMessages" class="flex-1 overflow-y-auto p-6 space-y-4">

                {{-- Welcome message --}}
                <div class="flex gap-3">
                    <div class="w-8 h-8 rounded-full bg-primary flex-shrink-0 flex items-center justify-center">
                        <i class="bi bi-stars text-accent text-sm"></i>
                    </div>
                    <div class="message-ai px-4 py-3 max-w-lg text-sm leading-relaxed">
                        <p class="font-semibold text-primary mb-1">Ahlan! 👋</p>
                        <p>Waxaan ahay AI-ga {{ $company->name ?? 'ganacsigaaga' }}. Weydii su'aasha xogta ganacsigaaga — Afsomali ama Ingiriis.</p>
                        <p class="mt-2 text-gray-500 text-xs">I am your business AI assistant. Ask me about your sales, expenses, inventory or profits.</p>
                    </div>
                </div>

                {{-- Typing indicator (hidden by default) --}}
                <div id="typingIndicator" class="flex gap-3 hidden">
                    <div class="w-8 h-8 rounded-full bg-primary flex-shrink-0 flex items-center justify-center">
                        <i class="bi bi-stars text-accent text-sm"></i>
                    </div>
                    <div class="message-ai px-4 py-3">
                        <div class="flex gap-1 items-center">
                            <div class="typing-dot"></div>
                            <div class="typing-dot"></div>
                            <div class="typing-dot"></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Input --}}
            <div class="border-t border-gray-100 p-4">
                <form @submit.prevent="sendMessage" class="flex gap-3">
                    <input
                        x-model="input"
                        type="text"
                        placeholder="Weydii su'aasha... e.g. Maxay tahay iibka bishaan? / What is total sales this month?"
                        class="flex-1 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition"
                        :disabled="loading"
                        @keydown.enter.prevent="sendMessage"
                    >
                    <button
                        type="submit"
                        :disabled="loading || !input.trim()"
                        class="bg-primary text-white px-5 py-3 rounded-xl font-semibold text-sm hover:bg-primary/90 transition disabled:opacity-40 disabled:cursor-not-allowed flex items-center gap-2">
                        <i class="bi bi-send" x-show="!loading"></i>
                        <i class="bi bi-hourglass-split animate-spin" x-show="loading"></i>
                        <span x-show="!loading">Send</span>
                    </button>
                </form>
            </div>
        </div>

        {{-- Example queries panel --}}
        <div class="space-y-4">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <h3 class="font-bold text-primary text-sm mb-3 flex items-center gap-2">
                    <i class="bi bi-lightbulb text-accent"></i> Tusaalooyin / Examples
                </h3>
                <div class="space-y-2">
                    @foreach([
                        'Maxay tahay iibka bishaan?',
                        'Waa meeqa faa\'iidada sanadkan?',
                        'Kharashka bishaan waa imisa?',
                        'Alaabta heerka hoose u jirta?',
                        'Alaabta ugu badan ee la iibsaday?',
                        'What is total sales this month?',
                        'Show me net profit for this year',
                        'Which products are low in stock?',
                        'Total expenses this month?',
                        'Give me a financial snapshot',
                    ] as $example)
                    <button
                        @click="useExample('{{ $example }}')"
                        class="w-full text-left text-xs px-3 py-2 rounded-lg bg-gray-50 hover:bg-primary/5 hover:text-primary text-gray-600 transition border border-transparent hover:border-primary/20">
                        {{ $example }}
                    </button>
                    @endforeach
                </div>
            </div>

            <div class="bg-primary/5 border border-primary/10 rounded-2xl p-4 text-xs text-gray-500">
                <i class="bi bi-info-circle text-primary mr-1"></i>
                AI wuxuu u jawaabaa luqadda aad ku qorto. Wuxuu isticmaalaa xogta dhabta ah ee ganacsigaaga.
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
function askAi() {
    return {
        input: '',
        loading: false,

        useExample(text) {
            this.input = text;
            this.$nextTick(() => document.querySelector('input[type=text]').focus());
        },

        async sendMessage() {
            const msg = this.input.trim();
            if (!msg || this.loading) return;

            this.input   = '';
            this.loading = true;

            this.appendMessage('user', msg);
            this.showTyping(true);

            try {
                const res = await fetch('{{ route('ask-ai.ask') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({ message: msg }),
                });

                const data = await res.json();
                this.showTyping(false);

                if (data.error) {
                    this.appendMessage('ai', '⚠️ ' + data.error);
                } else {
                    this.appendMessage('ai', data.reply);
                }
            } catch (e) {
                this.showTyping(false);
                this.appendMessage('ai', '⚠️ Xidhiidh khalad ah. Fadlan mar kale isku day. / Connection error, please try again.');
            }

            this.loading = false;
        },

        appendMessage(role, text) {
            const container = document.getElementById('chatMessages');
            const indicator = document.getElementById('typingIndicator');

            const div = document.createElement('div');
            div.className = 'flex gap-3' + (role === 'user' ? ' justify-end' : '');

            if (role === 'user') {
                div.innerHTML = `
                    <div class="message-user px-4 py-3 max-w-lg text-sm leading-relaxed">${this.escHtml(text)}</div>
                    <div class="w-8 h-8 rounded-full bg-gray-200 flex-shrink-0 flex items-center justify-center">
                        <i class="bi bi-person text-gray-600 text-sm"></i>
                    </div>`;
            } else {
                const formatted = this.escHtml(text).replace(/\n/g, '<br>');
                div.innerHTML = `
                    <div class="w-8 h-8 rounded-full bg-primary flex-shrink-0 flex items-center justify-center">
                        <i class="bi bi-stars text-accent text-sm"></i>
                    </div>
                    <div class="message-ai px-4 py-3 max-w-lg text-sm leading-relaxed">${formatted}</div>`;
            }

            container.insertBefore(div, indicator);
            container.scrollTop = container.scrollHeight;
        },

        showTyping(show) {
            const el = document.getElementById('typingIndicator');
            el.classList.toggle('hidden', !show);
            if (show) {
                const container = document.getElementById('chatMessages');
                container.scrollTop = container.scrollHeight;
            }
        },

        escHtml(text) {
            return text
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;');
        },
    };
}
</script>
@endpush
@endsection
