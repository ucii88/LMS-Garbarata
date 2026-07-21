<x-app-layout>
    <style>
        /* Force text inside study rooms to be 14px instead of 12px due to database HTML having hardcoded class="text-xs" */
        .prose p.text-xs,
        .prose span.text-xs,
        .prose div.text-xs,
        .prose .text-xs {
            font-size: 0.875rem !important;
            line-height: 1.5rem !important;
        }
    </style>

    {{-- ========================================================= --}}
    {{-- GLOBAL TTS ENGINE (Web Speech API) — Bab 1 s.d. 5 saja   --}}
    {{-- ========================================================= --}}
    @if($chapter->order >= 1 && $chapter->order <= 5)
    <style>
        /* Highlight paragraf yang sedang dibacakan TTS */
        .tts-paragraph-highlight {
            background-color: #fef9c3 !important; /* amber/yellow-100 */
            border-left: 4px solid #f59e0b !important; /* amber-500 indicator bar */
            padding-left: 0.75rem !important;
            padding-top: 0.375rem !important;
            padding-bottom: 0.375rem !important;
            border-radius: 0.375rem !important;
            transition: all 0.25s ease-in-out !important;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05) !important;
        }

        /* Control Group Wrapper */
        .tts-controls-group {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 3px 4px;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
        }

        /* Tombol TTS Utama */
        .tts-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 700;
            cursor: pointer;
            border: 1px solid;
            transition: all 0.15s ease;
            user-select: none;
        }
        .tts-btn-idle {
            background: #eff6ff;
            color: #2563eb;
            border-color: #bfdbfe;
        }
        .tts-btn-idle:hover {
            background: #dbeafe;
        }
        .tts-btn-playing {
            background: #fef3c7;
            color: #b45309;
            border-color: #fcd34d;
            animation: tts-pulse 1.8s ease-in-out infinite;
        }
        .tts-btn-paused {
            background: #f0fdf4;
            color: #15803d;
            border-color: #bbf7d0;
        }
        .tts-btn-paused:hover {
            background: #dcfce7;
        }

        /* Tombol Speed Control & Navigasi */
        .tts-speed-btn,
        .tts-nav-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            padding: 5px 10px;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 700;
            color: #334155;
            background: #ffffff;
            border: 1px solid #cbd5e1;
            cursor: pointer;
            transition: all 0.15s ease;
            user-select: none;
        }
        .tts-speed-btn:hover,
        .tts-nav-btn:hover {
            background: #f1f5f9;
            border-color: #94a3b8;
            color: #0f172a;
        }
        .tts-nav-btn {
            padding: 5px 8px;
        }

        @keyframes tts-pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
    </style>
    <script>
        window.LmsTTS = (function () {
            const synth = window.speechSynthesis;
            let currentId          = null;   // Active module ID
            let currentUtt         = null;   // Active SpeechSynthesisUtterance
            let isPaused           = false;
            let currentRate        = 1.0;    // Playback rate: 0.75, 1.0, 1.25, 1.5, 2.0
            let currentParagraphs  = [];     // Array of { el: DOMElement, text: string }
            let currentIndex       = 0;      // Current paragraph index
            let currentCharIndex   = 0;      // Current character position inside paragraph

            const SVG_SPEAKER = `<svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>`;

            const SVG_PAUSE = `<svg class="w-4 h-4 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`;

            const SVG_PLAY = `<svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`;

            /* ── Ambil paragraf-paragraf dari container DOM ── */
            function getParagraphs(containerEl) {
                if (!containerEl) return [];

                const blockSelector = 'p, li, h1, h2, h3, h4, h5, h6, blockquote, td, th, div, section, aside, dt, dd';
                let nodes = Array.from(containerEl.querySelectorAll(blockSelector));

                // Ambil elemen yang memiliki teks dan tidak membungkus elemen blok lain yang ber-teks
                nodes = nodes.filter(el => {
                    const txt = (el.innerText || el.textContent || '').trim();
                    if (!txt) return false;

                    const hasTextBlockChild = Array.from(el.querySelectorAll(blockSelector)).some(child => {
                        return (child.innerText || child.textContent || '').trim().length > 0;
                    });

                    return !hasTextBlockChild;
                });

                // Fallback jika tidak ada elemen terpisah
                if (nodes.length === 0 && containerEl.innerText && containerEl.innerText.trim()) {
                    nodes = [containerEl];
                }

                return nodes.map(el => ({
                    el: el,
                    text: (el.innerText || el.textContent || '').trim()
                })).filter(item => item.text.length > 0);
            }

            /* ── Clear & Highlight per Paragraf ── */
            function clearHighlight() {
                document.querySelectorAll('.tts-paragraph-highlight').forEach(el => {
                    el.classList.remove('tts-paragraph-highlight');
                });
            }

            function highlightParagraph(el) {
                clearHighlight();
                if (!el) return;
                el.classList.add('tts-paragraph-highlight');
                el.scrollIntoView({ block: 'center', behavior: 'smooth' });
            }

            /* ── Update status tombol TTS di UI ── */
            function broadcastState(id, state /* 'idle'|'playing'|'paused' */) {
                document.querySelectorAll('[data-tts-id]').forEach(btn => {
                    const btnId = btn.getAttribute('data-tts-id');
                    const icon  = btn.querySelector('.tts-icon');
                    const label = btn.querySelector('.tts-label');
                    if (btnId === String(id) && state !== 'idle') {
                        if (state === 'playing') {
                            btn.className = 'tts-btn tts-btn-playing';
                            if (icon)  icon.innerHTML   = SVG_PAUSE;
                            if (label) label.textContent = 'Sedang Dibaca...';
                        } else {
                            btn.className = 'tts-btn tts-btn-paused';
                            if (icon)  icon.innerHTML   = SVG_PLAY;
                            if (label) label.textContent = 'Lanjutkan';
                        }
                    } else {
                        btn.className = 'tts-btn tts-btn-idle';
                        if (icon)  icon.innerHTML   = SVG_SPEAKER;
                        if (label) label.textContent = 'Dengarkan';
                    }
                });
            }

            /* ── Stop semua ── */
            function stop() {
                if (currentUtt) {
                    currentUtt.onend = null;
                    currentUtt.onerror = null;
                    currentUtt.onboundary = null;
                }
                synth.cancel();
                clearHighlight();
                const prevId = currentId;
                currentId         = null;
                currentUtt        = null;
                isPaused          = false;
                currentParagraphs = [];
                currentIndex      = 0;
                currentCharIndex  = 0;
                if (prevId !== null) broadcastState(prevId, 'idle');
            }

            /* ── Normalisasi teks agar Angka Romawi & Penomoran Ganda dibaca bersih oleh TTS ── */
            function cleanTextForSpeech(text) {
                if (!text) return '';

                const romanMap = {
                    'viii': '8', 'vii': '7', 'iii': '3', 'vi': '6',
                    'iv': '4', 'ix': '9', 'ii': '2', 'v': '5', 'x': '10', 'i': '1'
                };

                // Hapus penomoran ganda seperti "1. (a) ", "1. a) " -> "(a) ", "a) "
                let cleaned = text.replace(/^\d+\.\s+(\([a-z0-9]+\)|[a-z0-9]\))\s+/gi, '$1 ');

                cleaned = cleaned.replace(/\((viii|vii|iii|vi|iv|ix|ii|v|x|i)\)/gi, (match, roman) => {
                    const num = romanMap[roman.toLowerCase()];
                    return num ? `(${num})` : match;
                });

                cleaned = cleaned.replace(/(^|\n|\s)\b(viii|vii|iii|vi|iv|ix|ii|v|x|i)\.\s+/gi, (match, prefix, roman) => {
                    const num = romanMap[roman.toLowerCase()];
                    return num ? `${prefix}${num}. ` : match;
                });

                return cleaned;
            }

            /* ── Main Playback per Paragraf ── */
            function playCurrentParagraph(fromCharIndex = 0) {
                if (!currentParagraphs || currentIndex >= currentParagraphs.length) {
                    stop();
                    return;
                }

                const item = currentParagraphs[currentIndex];
                highlightParagraph(item.el);

                const fullText = item.text;
                const rawText = fromCharIndex > 0 ? fullText.substring(fromCharIndex) : fullText;
                const textToSpeak = cleanTextForSpeech(rawText);

                if (!textToSpeak.trim()) {
                    currentIndex++;
                    playCurrentParagraph(0);
                    return;
                }

                const utt = new SpeechSynthesisUtterance(textToSpeak);
                utt.lang  = 'id-ID';
                utt.rate  = currentRate;
                utt.pitch = 1;

                const voices = synth.getVoices();
                const idVoice = voices.find(v => v.lang === 'id-ID') ||
                                voices.find(v => v.lang.startsWith('id'));
                if (idVoice) utt.voice = idVoice;

                currentCharIndex = fromCharIndex;

                utt.onboundary = (event) => {
                    if (event.name === 'word') {
                        currentCharIndex = fromCharIndex + event.charIndex;
                    }
                };

                utt.onend = () => {
                    if (currentId !== null && !isPaused) {
                        currentCharIndex = 0;
                        currentIndex++;
                        playCurrentParagraph(0);
                    }
                };

                utt.onerror = (e) => {
                    console.warn('TTS Error:', e);
                    if (currentId !== null && !isPaused) {
                        currentCharIndex = 0;
                        currentIndex++;
                        playCurrentParagraph(0);
                    }
                };

                currentUtt = utt;
                synth.speak(utt);
            }

            /* ── Toggle Play / Pause / Resume ── */
            function toggle(moduleId, contentHtml, containerId) {
                const id = String(moduleId);

                // Jika modul yang sama
                if (currentId === id) {
                    if (isPaused) {
                        isPaused = false;
                        broadcastState(id, 'playing');
                        if (synth.paused) {
                            synth.resume();
                        } else {
                            playCurrentParagraph(currentCharIndex);
                        }
                    } else {
                        isPaused = true;
                        synth.pause();
                        broadcastState(id, 'paused');
                    }
                    return;
                }

                // Jika modul baru
                stop();

                const container = containerId ? document.getElementById(containerId) : null;
                if (!container) return;

                currentParagraphs = getParagraphs(container);
                if (currentParagraphs.length === 0) return;

                currentId        = id;
                currentIndex     = 0;
                currentCharIndex = 0;
                isPaused         = false;

                broadcastState(id, 'playing');
                playCurrentParagraph(0);
            }

            /* ── Navigasi Ke Paragraf Sebelumnya / Selanjutnya ── */
            function prevParagraph() {
                if (currentId === null || !currentParagraphs.length) return;
                if (currentIndex > 0) {
                    currentIndex--;
                }
                currentCharIndex = 0;
                if (currentUtt) {
                    currentUtt.onend = null;
                    currentUtt.onerror = null;
                    currentUtt.onboundary = null;
                }
                synth.cancel();
                isPaused = false;
                broadcastState(currentId, 'playing');
                playCurrentParagraph(0);
            }

            function nextParagraph() {
                if (currentId === null || !currentParagraphs.length) return;
                if (currentIndex < currentParagraphs.length - 1) {
                    currentIndex++;
                    currentCharIndex = 0;
                    if (currentUtt) {
                        currentUtt.onend = null;
                        currentUtt.onerror = null;
                        currentUtt.onboundary = null;
                    }
                    synth.cancel();
                    isPaused = false;
                    broadcastState(currentId, 'playing');
                    playCurrentParagraph(0);
                }
            }

            /* ── Update & Cycle Speed Rate ── */
            function setRate(newRate) {
                currentRate = parseFloat(newRate) || 1.0;
                document.querySelectorAll('.tts-speed-val').forEach(el => {
                    el.textContent = currentRate + 'x';
                });

                // Lanjutkan pembacaan dari kata posisi saat ini dengan kecepatan baru
                if (currentId !== null && !isPaused && synth.speaking) {
                    const resumeCharIndex = currentCharIndex;
                    if (currentUtt) {
                        currentUtt.onend = null;
                        currentUtt.onerror = null;
                        currentUtt.onboundary = null;
                    }
                    synth.cancel();
                    playCurrentParagraph(resumeCharIndex);
                }
            }

            function cycleRate() {
                const rates = [1, 1.25, 1.5, 2, 0.75];
                const idx = rates.indexOf(currentRate);
                const nextRate = rates[(idx + 1) % rates.length];
                setRate(nextRate);
            }

            return { toggle, stop, setRate, cycleRate, getRate: () => currentRate, prevParagraph, nextParagraph, isActive: () => currentId !== null };
        })();

        /* ── Helper: buat HTML tombol TTS (dipanggil dari inline onclick) ── */
        window.ttsToggle = function(moduleId, contentHtml, containerId) {
            window.LmsTTS.toggle(moduleId, contentHtml, containerId || null);
        };

        /* ── Keyboard Shortcuts (Panah Kanan/Kiri & Atas/Bawah) untuk Navigasi Paragraf TTS ── */
        document.addEventListener('keydown', function(e) {
            const activeEl = document.activeElement;
            if (activeEl && (['INPUT', 'TEXTAREA', 'SELECT'].includes(activeEl.tagName) || activeEl.isContentEditable)) {
                return;
            }

            if (window.LmsTTS && window.LmsTTS.isActive()) {
                if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') {
                    e.preventDefault();
                    window.LmsTTS.prevParagraph();
                } else if (e.key === 'ArrowRight' || e.key === 'ArrowDown') {
                    e.preventDefault();
                    window.LmsTTS.nextParagraph();
                }
            }
        });
    </script>
    @endif

    @if($chapter->order == 1)
        <script>
            window.chapterOneStudy = function (modules) {
                return {
                    modules,
                    completeUrlTemplate: @js(route('courses.modules.complete', [$course->id, $chapter->id, '__MODULE__'])),
                    csrfToken: @js(csrf_token()),
                    activeMechId: 'intro_mekanikal',
                    mechItems: [],
                    activeElecId: 'intro_elektrikal',
                    elecItems: [],

                    init() {
                        this.mechItems = [
                            {
                                id: 'intro_mekanikal',
                                title: '{{ __('Deskripsi Komponen Mekanikal') }}',
                                button_title: '{{ __('Pengantar') }}',
                                content: `<p class='mt-2'>{{ __('Garbarata merupakan sebuah jembatan elektromekanik yang menghubungkan bangunan Bandara dengan pesawat yang berfungsi sebagai media para penumpang untuk berpindah dari Pesawat menuju Bandara atau sebaliknya. Dengan menggunakan Garbarata, penumpang dapat terlindungi dari hujan, suara bising, angin debu dan berbagai macam hal lainnya yang dapat menciderai penumpang atau hal yang dapat mengganggu operasional Bandara.') }}</p><p class='mt-4'>{{ __('Garbarata menggunakan sistem elektromekanik yang dikendalikan melalui sebuah control console di cabin. Sistem kendali ini mengintegrasikan seluruh peralatan keselamatan dan sistem kendali elektronik. Sistem kendali elektronik menggunakan unit kendali yang disebut Programmable Logic Controller atau PLC.') }}</p>`,
                                image_path: null,
                            },
                            ...this.modules
                                .filter((module) => module.title.startsWith('1.'))
                                .map((module) => ({
                                    id: module.id,
                                    title: module.title,
                                    button_title: module.title,
                                    content: module.content,
                                    image_path: module.image_path,
                                })),
                        ];

                        this.elecItems = [
                            {
                                id: 'intro_elektrikal',
                                title: '{{ __('Deskripsi Komponen Elektrikal dan Sistem Kontrol') }}',
                                button_title: '{{ __('Pengantar') }}',
                                content: `<p class='mt-2'>{{ __('Bagian ini menjelaskan proses operasi system elektrikal Garbarata. Gambar skema detil terdapat pada gambar As-Built. Tenaga listrik didistribusikan dari bangunan bandara melalui Main Power Panel, Sub-Distribution Power Panel dan Console Desk. Dari komponen elektrik tersebut, energy listrik digunakan untuk menaktifkan actuator, sensor dan beberapa komponen elektrik pada Garbarata. Kontrol utama berada pada Console Desk yang menggunakan Control Face Plate dan Touchscreen sebagai interface operator. Operator juga dapat memeriksa kondisi komponen Garbarata jika terjadi kegagalan melalui monitor pada Console Desk.') }}</p>`,
                                image_path: null,
                            },
                            ...this.modules
                                .filter((module) => module.title.startsWith('2.'))
                                .map((module) => ({
                                    id: module.id,
                                    title: module.title,
                                    button_title: module.title,
                                    content: module.content,
                                    image_path: module.image_path,
                                })),
                        ];

                        // Auto-mark read using Intersection Observer as the user scrolls
                        this.$nextTick(() => {
                            const observerOptions = {
                                root: null,
                                rootMargin: '-20% 0px -50% 0px',
                                threshold: 0
                            };

                            const observer = new IntersectionObserver((entries) => {
                                entries.forEach(entry => {
                                    if (entry.isIntersecting) {
                                        const id = entry.target.dataset.moduleId;
                                        const type = entry.target.dataset.type;
                                        if (id) {
                                            if (type === 'mech') {
                                                this.activeMechId = isNaN(id) ? id : Number(id);
                                            } else if (type === 'elec') {
                                                this.activeElecId = isNaN(id) ? id : Number(id);
                                            }
                                            this.markModuleComplete(id);
                                        }
                                    }
                                });
                            }, observerOptions);

                            // Observe mechanical sections
                            this.mechItems.forEach(item => {
                                const el = document.getElementById('mech-module-' + item.id);
                                if (el) observer.observe(el);
                            });

                            // Observe electrical sections
                            this.elecItems.forEach(item => {
                                const el = document.getElementById('elec-module-' + item.id);
                                if (el) observer.observe(el);
                            });
                        });
                    },

                    setMechModule(moduleId) {
                        this.activeMechId = moduleId;
                        this.markModuleComplete(moduleId);
                        this.scrollToModule('mech-module-' + moduleId);
                    },

                    setElecModule(moduleId) {
                        this.activeElecId = moduleId;
                        this.markModuleComplete(moduleId);
                        this.scrollToModule('elec-module-' + moduleId);
                    },

                    markModuleComplete(moduleId) {
                        if (!Number.isInteger(Number(moduleId))) {
                            return;
                        }

                        fetch(this.completeUrlTemplate.replace('__MODULE__', moduleId), {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': this.csrfToken,
                                'Accept': 'application/json',
                            },
                        });
                    },

                    scrollToModule(elementId) {
                        this.$nextTick(() => {
                            const el = document.getElementById(elementId);
                            if (el) {
                                // Scroll element header minus topbar height
                                const y = el.getBoundingClientRect().top + window.pageYOffset - 100;
                                window.scrollTo({ top: y, behavior: 'smooth' });
                            }
                        });
                    }
                };
            };
        </script>

        <div class="py-6 select-none" x-data="chapterOneStudy(@js($modules->values()))">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">
                <!-- Navigation Back & Title Bar -->
                <div class="flex items-center justify-between">
                    <a href="{{ route('courses.show', $course->id) }}" class="inline-flex items-center text-sm font-bold text-gray-500 hover:text-blue-600 transition">
                        &larr; {{ __('Kembali ke Silabus Kursus') }}
                    </a>

                    <div class="flex items-center gap-2">
                        @if(auth()->user()->isInstruktur())
                            <a href="{{ route('modules.create', [$course->id, $chapter->id]) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg text-xs transition shadow-sm">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                </svg>
                                {{ __('Tambah Modul Baru') }}
                            </a>
                        @endif

                        <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-[9px] font-bold text-blue-600 border border-blue-100 uppercase tracking-wider">
                            {{ __('Bab') }} {{ $chapter->order }} {{ __('dari') }} {{ $chapters->count() }}
                        </span>
                    </div>
                </div>

                <!-- ================= BAGIAN 1: KOMPONEN MEKANIKAL ================= -->
                <section class="space-y-6">
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-6">
                    <div class="flex items-center space-x-3 border-b border-gray-100 pb-3">
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-blue-200 bg-white text-[10px] font-black text-blue-600">01</span>
                        <h2 class="text-base font-extrabold text-slate-800 uppercase tracking-wider">{{ __('Deskripsi Komponen Mekanikal') }}</h2>
                    </div>

                    <!-- Sub-Chapter Selector for Mechanical -->
                    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-3">
                        <div class="flex items-center space-x-2 shrink-0">
                            <span class="text-xs font-bold text-slate-500 uppercase tracking-wide">{{ __('Pilih Topik Mekanikal:') }}</span>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <template x-for="item in mechItems" :key="item.id">
                                <button
                                    @click="setMechModule(item.id)"
                                    class="px-4 py-2.5 rounded-lg text-sm font-bold transition text-left"
                                    :class="activeMechId === item.id ? 'bg-blue-600 text-white shadow-sm' : 'bg-slate-50 text-slate-600 hover:bg-slate-100 hover:text-slate-800 border border-slate-200'"
                                >
                                    <span x-text="item.button_title"></span>
                                </button>
                            </template>
                        </div>
                    </div>

                    <p class="text-[10px] font-semibold text-slate-400">
                        {{ __('Klik judul topik untuk membuka materi yang lebih lengkap.') }}
                    </p>

                    <!-- Interactive Diagram with Hotspots -->
                    @if($diagram)
                        <section class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm max-w-4xl mx-auto w-full"
                            x-data="{
                                editMode: false,
                                saving: false,
                                hotspots: @js($diagram->hotspots),
                                updateUrl: '{{ route('courses.diagram.hotspots.update', [$course->id, $chapter->id]) }}',
                                dragId: null,
                                dragStartX: 0,
                                dragStartY: 0,
                                startDrag(e, id) {
                                    if (!this.editMode) return;
                                    this.dragId = id;
                                    if (e.type === 'touchstart') {
                                        // prevent scroll on mobile when dragging
                                        // cannot preventDefault here passively, but we'll try
                                    } else {
                                        e.preventDefault();
                                    }
                                },
                                onDrag(e) {
                                    if (!this.editMode || !this.dragId) return;
                                    const rect = this.$refs.diagramContainer.getBoundingClientRect();
                                    
                                    const clientX = e.touches ? e.touches[0].clientX : e.clientX;
                                    const clientY = e.touches ? e.touches[0].clientY : e.clientY;

                                    let xPos = ((clientX - rect.left) / rect.width) * 100;
                                    let yPos = ((clientY - rect.top) / rect.height) * 100;
                                    
                                    xPos = Math.max(0, Math.min(100, xPos));
                                    yPos = Math.max(0, Math.min(100, yPos));
                                    
                                    const hotspot = this.hotspots.find(h => h.id === this.dragId);
                                    if (hotspot) {
                                        hotspot.x_percent = xPos;
                                        hotspot.y_percent = yPos;
                                    }
                                },
                                stopDrag() {
                                    this.dragId = null;
                                },
                                async saveHotspots() {
                                    this.saving = true;
                                    try {
                                        const payload = this.hotspots.map(h => ({id: h.id, x: h.x_percent, y: h.y_percent}));
                                        const res = await window.fetch(this.updateUrl, {
                                            method: 'PUT',
                                            headers: {
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                'Content-Type': 'application/json',
                                                'Accept': 'application/json'
                                            },
                                            body: JSON.stringify({ hotspots: payload })
                                        });
                                        if (res.ok) {
                                            this.editMode = false;
                                            alert('Posisi Hotspot berhasil disimpan.');
                                        } else {
                                            alert('Gagal menyimpan posisi.');
                                        }
                                    } catch (e) {
                                        alert('Terjadi kesalahan jaringan.');
                                    }
                                    this.saving = false;
                                }
                            }"
                            @mousemove.window="onDrag"
                            @mouseup.window="stopDrag"
                            @touchmove.window="onDrag"
                            @touchend.window="stopDrag"
                        >
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-base font-bold text-slate-700">Diagram Interaktif</h3>
                                @if(auth()->user()->isInstruktur())
                                    <div class="flex items-center gap-2">
                                        <button x-show="!editMode" @click="editMode = true" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg text-sm font-bold transition">
                                            ⚙️ Atur Posisi Hotspot
                                        </button>
                                        <button x-show="editMode" @click="editMode = false" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg text-sm font-bold transition">
                                            Batal
                                        </button>
                                        <button x-show="editMode" @click="saveHotspots()" :disabled="saving" class="px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-bold transition">
                                            <span x-show="!saving">💾 Simpan Posisi</span>
                                            <span x-show="saving">Menyimpan...</span>
                                        </button>
                                    </div>
                                @endif
                            </div>
                            
                            <div x-ref="diagramContainer" class="relative bg-white rounded-xl overflow-hidden aspect-[1755/896] w-full border border-gray-200 flex items-center justify-center shadow-sm"
                                :class="editMode ? 'ring-2 ring-blue-500 cursor-crosshair' : ''">
                                @if($diagram->image_path && file_exists(public_path($diagram->image_path)))
                                    <img src="{{ asset($diagram->image_path) }}" class="w-full h-full object-contain select-none" alt="Diagram {{ $chapter->title }}" draggable="false">
                                @endif
                                
                                <!-- Overlay Hotspots (Drag & Drop) -->
                                <template x-for="hotspot in hotspots" :key="hotspot.id">
                                    <button
                                        @click="!editMode && setMechModule(hotspot.target_module_id)"
                                        @mousedown="startDrag($event, hotspot.id)"
                                        @touchstart="startDrag($event, hotspot.id)"
                                        class="absolute z-20 group -translate-x-1/2 -translate-y-1/2 focus:outline-none select-none"
                                        :style="`left: ${hotspot.x_percent}%; top: ${hotspot.y_percent}%; cursor: ${editMode ? 'grab' : 'pointer'};`"
                                        :class="editMode && dragId === hotspot.id ? 'cursor-grabbing scale-125 z-50' : ''"
                                    >
                                        <span x-show="!editMode" class="absolute inline-flex h-8 w-8 rounded-full bg-[#0091ff] opacity-40 animate-ping -left-[4px] -top-[4px]"></span>
                                        <span class="relative inline-flex rounded-full h-6 w-6 bg-[#0091ff] border-2 border-white items-center justify-center shadow-md transition-all duration-150 group-hover:scale-110"
                                              :class="activeMechId === hotspot.target_module_id && !editMode ? 'bg-[#0070c6] scale-110 ring-4 ring-[#0091ff]/20' : ''">
                                            <span class="text-white text-[10px] font-bold" x-text="hotspots.findIndex(h => h.id === hotspot.id) + 1"></span>
                                        </span>
                                        <span x-show="!editMode" class="absolute left-1/2 -translate-x-1/2 bottom-7 bg-slate-900 text-white text-[10px] font-semibold px-2 py-0.5 rounded shadow transition-all duration-150 opacity-0 transform translate-y-1 group-hover:opacity-100 group-hover:translate-y-0 whitespace-nowrap z-30 pointer-events-none" x-text="hotspot.label">
                                        </span>
                                    </button>
                                </template>
                              </div>
                          </section>
                      @endif

                    </div>

                      <!-- Mechanical Reader Card -->
                      <div id="chapter1-reader" x-ref="mechReader" class="bg-white rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between min-h-[320px] w-full">
                          <div class="p-4 md:p-6 space-y-8">
                              <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                                  <span class="inline-flex h-8 items-center rounded-full border border-blue-200 bg-white px-3 text-[9px] font-bold text-blue-600 uppercase tracking-wider">
                                      {{ __('Modul Mekanikal') }}
                                  </span>
                              </div>

                              <div class="space-y-12">
                                  <template x-for="item in mechItems" :key="item.id">
                                      <div :id="'mech-module-' + item.id" :data-module-id="item.id" data-type="mech" class="space-y-4 pt-4 first:pt-0" :class="item.id !== 'intro_mekanikal' ? 'border-t border-gray-100' : ''">
                                          <h2 class="text-lg font-bold text-slate-800 leading-snug" x-text="item.title"></h2>

                                          {{-- TTS Button Chapter 1 Mekanikal --}}
                                          <div class="tts-controls-group">
                                              <button
                                                  type="button"
                                                  class="tts-nav-btn"
                                                  onclick="window.LmsTTS.prevParagraph()"
                                                  title="Paragraf Sebelumnya"
                                              >
                                                  <svg class="w-3.5 h-3.5 text-slate-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                              </button>
                                              <button
                                                  class="tts-btn tts-btn-idle"
                                                  :data-tts-id="'mech_' + item.id"
                                                  @click="window.ttsToggle('mech_' + item.id, item.content, 'mech-tts-content-' + item.id)"
                                                  title="Dengarkan Suara Subab"
                                              >
                                                  <span class="tts-icon">
                                                      <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
                                                  </span>
                                                  <span class="tts-label">Dengarkan</span>
                                              </button>
                                              <button
                                                  type="button"
                                                  class="tts-nav-btn"
                                                  onclick="window.LmsTTS.nextParagraph()"
                                                  title="Paragraf Selanjutnya"
                                              >
                                                  <svg class="w-3.5 h-3.5 text-slate-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                              </button>
                                              <button
                                                  type="button"
                                                  class="tts-speed-btn"
                                                  onclick="window.LmsTTS.cycleRate()"
                                                  title="Klik untuk mengubah kecepatan suara"
                                              >
                                                  <svg class="w-3.5 h-3.5 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                                  <span class="tts-speed-val">1x</span>
                                              </button>
                                          </div>

                                          <template x-if="item.image_path">
                                              <div class="rounded-xl border border-gray-200 bg-gray-50 p-2 shadow-xs my-3 mx-auto"
                                                   :class="item.title.startsWith('1.1') || item.title.startsWith('1.4') || item.title.startsWith('1.5') ? 'max-w-4xl' : 'max-w-xl'">
                                                  <img :src="'/' + item.image_path" class="w-full object-contain rounded-lg select-none"
                                                       :class="item.title.startsWith('1.1') || item.title.startsWith('1.4') || item.title.startsWith('1.5') ? 'max-h-[600px]' : 'max-h-64'"
                                                       :alt="item.title">
                                              </div>
                                          </template>

                                          <div :id="'mech-tts-content-' + item.id" class="text-base text-slate-600 leading-relaxed space-y-3.5 prose prose-slate max-w-none prose-sm" x-html="item.content"></div>

                                          @if(auth()->user()->isInstruktur())
                                              <template x-if="item.id !== 'intro_mekanikal'">
                                                  <div class="flex items-center gap-2 pt-4 border-t border-slate-100 mt-4">
                                                      <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + item.id + '/edit'" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-xs font-bold transition shadow-xs">
                                                          {{ __('Edit Modul') }}
                                                      </a>
                                                      <form :action="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + item.id" method="POST" onsubmit="return confirm('{{ __('Apakah Anda yakin ingin menghapus modul ini?') }}')">
                                                          @csrf
                                                          @method('DELETE')
                                                          <button type="submit" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-xs font-bold transition shadow-xs">
                                                              {{ __('Hapus') }}
                                                          </button>
                                                      </form>
                                                  </div>
                                              </template>
                                          @endif
                                      </div>
                                  </template>
                              </div>
                          </div>
                      </div>
                </section>

                  <!-- ================= BAGIAN 2: KOMPONEN ELEKTRIKAL & SISTEM KONTROL ================= -->
                  <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-6">
                      <div class="flex items-center space-x-3 border-b border-gray-100 pb-3">
                          <span class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-emerald-200 bg-white text-[10px] font-black text-emerald-600">02</span>
                          <h2 class="text-base font-extrabold text-slate-800 uppercase tracking-wider">{{ __('Deskripsi Komponen Elektrikal dan Sistem Kontrol') }}</h2>
                      </div>

                      <!-- Sub-Chapter Selector for Electrical -->
                      <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-3">
                          <div class="flex items-center space-x-2 shrink-0">
                              <span class="text-xs font-bold text-slate-500 uppercase tracking-wide">{{ __('Pilih Topik Elektrikal:') }}</span>
                          </div>
                          <div class="flex flex-wrap gap-2">
                              <template x-for="item in elecItems" :key="item.id">
                                  <button
                                      @click="setElecModule(item.id)"
                                      class="px-4 py-2.5 rounded-lg text-sm font-bold transition text-left"
                                      :class="activeElecId === item.id ? 'bg-emerald-600 text-white shadow-sm' : 'bg-slate-50 text-slate-600 hover:bg-slate-100 hover:text-slate-800 border border-slate-200'"
                                  >
                                      <span x-text="item.button_title"></span>
                                  </button>
                              </template>
                          </div>
                      </div>

                      <!-- Electrical Reader Card (Kotak Teks Baru) -->
                      <div class="bg-white rounded-2xl border border-slate-100 flex flex-col justify-between min-h-[320px] w-full">
                          <div class="p-4 md:p-6 space-y-8">
                              <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                                  <span class="inline-flex h-8 items-center rounded-full border border-emerald-200 bg-white px-3 text-[9px] font-bold text-emerald-600 uppercase tracking-wider">
                                      {{ __('Modul Elektrikal & Kontrol') }}
                                  </span>
                              </div>

                              <div class="space-y-12">
                                  <template x-for="item in elecItems" :key="item.id">
                                      <div :id="'elec-module-' + item.id" :data-module-id="item.id" data-type="elec" class="space-y-4 pt-4 first:pt-0" :class="item.id !== 'intro_elektrikal' ? 'border-t border-gray-100' : ''">
                                          <h2 class="text-lg font-bold text-slate-800 leading-snug" x-text="item.title"></h2>

                                          {{-- TTS Button Chapter 1 Elektrikal --}}
                                          <div class="tts-controls-group">
                                              <button
                                                  type="button"
                                                  class="tts-nav-btn"
                                                  onclick="window.LmsTTS.prevParagraph()"
                                                  title="Paragraf Sebelumnya"
                                              >
                                                  <svg class="w-3.5 h-3.5 text-slate-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                              </button>
                                              <button
                                                  class="tts-btn tts-btn-idle"
                                                  :data-tts-id="'elec_' + item.id"
                                                  @click="window.ttsToggle('elec_' + item.id, item.content, 'elec-tts-content-' + item.id)"
                                                  title="Dengarkan Suara Subab"
                                              >
                                                  <span class="tts-icon">
                                                      <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
                                                  </span>
                                                  <span class="tts-label">Dengarkan</span>
                                              </button>
                                              <button
                                                  type="button"
                                                  class="tts-nav-btn"
                                                  onclick="window.LmsTTS.nextParagraph()"
                                                  title="Paragraf Selanjutnya"
                                              >
                                                  <svg class="w-3.5 h-3.5 text-slate-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                              </button>
                                              <button
                                                  type="button"
                                                  class="tts-speed-btn"
                                                  onclick="window.LmsTTS.cycleRate()"
                                                  title="Klik untuk mengubah kecepatan suara"
                                              >
                                                  <svg class="w-3.5 h-3.5 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                                  <span class="tts-speed-val">1x</span>
                                              </button>
                                          </div>

                                          <template x-if="item.image_path">
                                              <div class="rounded-xl border border-gray-200 bg-gray-50 p-2 shadow-xs my-3 max-w-xl mx-auto">
                                                  <img :src="'/' + item.image_path" class="w-full max-h-64 object-contain rounded-lg select-none" :alt="item.title">
                                              </div>
                                          </template>

                                          <div :id="'elec-tts-content-' + item.id" class="text-base text-slate-600 leading-relaxed space-y-3.5 prose prose-slate max-w-none prose-sm" x-html="item.content"></div>

                                          @if(auth()->user()->isInstruktur())
                                              <template x-if="item.id !== 'intro_elektrikal'">
                                                  <div class="flex items-center gap-2 pt-4 border-t border-slate-100 mt-4">
                                                      <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + item.id + '/edit'" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-xs font-bold transition shadow-xs">
                                                          {{ __('Edit Modul') }}
                                                      </a>
                                                      <form :action="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + item.id" method="POST" onsubmit="return confirm('{{ __('Apakah Anda yakin ingin menghapus modul ini?') }}')">
                                                          @csrf
                                                          @method('DELETE')
                                                          <button type="submit" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-xs font-bold transition shadow-xs">
                                                              {{ __('Hapus') }}
                                                          </button>
                                                      </form>
                                                  </div>
                                              </template>
                                          @endif
                                      </div>
                                  </template>
                              </div>
                          </div>
                      </div>
                  </div>

              </div>
          </div>

        @include('courses.partials.quiz-card')
    @elseif($chapter->order == 3)
        <!-- Custom Grouped Layout for Chapter 3: Operation Details & Procedures -->
        <div class="py-6 select-none" x-data="{
            modules: @js($modules),
            completeUrlTemplate: @js(route('courses.modules.complete', [$course->id, $chapter->id, '__MODULE__'])),
            csrfToken: @js(csrf_token()),
            detailItems: [],
            manualItems: [],
            autoItems: [],
            procedureItems: [],
            expandedSectionIds: [],

            init() {
                this.detailItems = this.modules.filter(module => module.title.startsWith('1.'));
                this.manualItems = this.modules.filter(module => module.title.startsWith('2.'));
                this.autoItems = this.modules.filter(module => module.title.startsWith('3.'));
                this.procedureItems = this.modules.filter(module => module.title.startsWith('4.'));
            },

            toggleSection(sectionId) {
                this.markSectionComplete(sectionId);

                if (this.expandedSectionIds.includes(sectionId)) {
                    this.expandedSectionIds = this.expandedSectionIds.filter(id => id !== sectionId);
                    return;
                }

                this.expandedSectionIds.push(sectionId);
            },

            isSectionExpanded(sectionId) {
                return this.expandedSectionIds.includes(sectionId);
            },

            markSectionComplete(sectionId) {
                const sectionMap = {
                    detail: this.detailItems,
                    manual: this.manualItems,
                    auto: this.autoItems,
                    procedure: this.procedureItems,
                };

                (sectionMap[sectionId] || []).forEach(module => this.markModuleComplete(module.id));
            },

            markModuleComplete(moduleId) {
                fetch(this.completeUrlTemplate.replace('__MODULE__', moduleId), {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': this.csrfToken,
                        'Accept': 'application/json',
                    },
                });
            }
        }">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <!-- Navigation Back & Title Bar -->
                <div class="flex items-center justify-between">
                    <a href="{{ route('courses.show', $course->id) }}" class="inline-flex items-center text-xs font-bold text-gray-500 hover:text-blue-600 transition">
                        &larr; {{ __('Kembali ke Silabus Kursus') }}
                    </a>

                    <div class="flex items-center gap-2">
                        @if(auth()->user()->isInstruktur())
                            <a href="{{ route('modules.create', [$course->id, $chapter->id]) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg text-xs transition shadow-sm">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                </svg>
                                {{ __('Tambah Modul Baru') }}
                            </a>
                        @endif

                        <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-[9px] font-bold text-blue-600 border border-blue-100 uppercase tracking-wider">
                            {{ __('Bab') }} {{ $chapter->order }} {{ __('dari') }} {{ $chapters->count() }}
                        </span>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-800 text-base">
                        {{ str_replace("BAB {$chapter->order}: ", "", $chapter->title) }}
                    </h3>
                    <p class="text-sm text-gray-500 mt-1.5 leading-relaxed">
                        {{ __('Materi Bab 3 dibagi menjadi detail pengoperasian, mode operasi manual, mode auto, dan prosedur pengoperasian. Setiap bagian dapat dibuka dan ditutup agar materi lebih mudah dibaca.') }}
                    </p>
                </div>

                <div class="space-y-4">
                    <!-- Detail Operation Group -->
                    <section class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                        <button
                            type="button"
                            @click="toggleSection('detail')"
                            class="w-full flex flex-col gap-3 bg-white p-6 text-left transition hover:bg-slate-50 md:flex-row md:items-center md:justify-between"
                        >
                            <div class="flex items-center space-x-3">
                                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-blue-200 bg-white text-[10px] font-black text-blue-600">01</span>
                                <div>
                                    <h2 class="text-base font-extrabold text-slate-800 uppercase tracking-wider">{{ __('Detail Pengoperasian') }}</h2>
                                    <p class="mt-1 text-[10px] font-semibold text-slate-400">{{ __('Klik judul bagian untuk melihat materi lengkap.') }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-2">
                                <span class="inline-flex w-fit rounded-full border border-blue-200 bg-white px-2.5 py-0.5 text-[9px] font-bold text-blue-600 uppercase tracking-wider">
                                    Module 1.1
                                </span>
                                <span
                                    class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-full border border-slate-200 bg-white text-base font-black text-slate-600 transition"
                                    x-text="isSectionExpanded('detail') ? '-' : '+'"
                                ></span>
                            </div>
                        </button>

                        <div x-show="isSectionExpanded('detail')" class="border-t border-gray-100 bg-white">
                            <div class="p-4 md:p-6 space-y-4">
                                <template x-for="module in detailItems" :key="module.id">
                                    <article class="rounded-xl border border-gray-100 bg-white p-4 space-y-3 shadow-sm">
                                        <div class="border-b border-gray-100 pb-3">
                                            <h3 class="text-sm md:text-base font-bold text-slate-800 leading-snug" x-text="module.title"></h3>
                                        </div>

                                        {{-- TTS Button Chapter 3 Detail --}}
                                        <div class="tts-controls-group">
                                            <button
                                                type="button"
                                                class="tts-nav-btn"
                                                onclick="window.LmsTTS.prevParagraph()"
                                                title="Paragraf Sebelumnya"
                                            >
                                                <svg class="w-3.5 h-3.5 text-slate-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                            </button>
                                            <button
                                                class="tts-btn tts-btn-idle"
                                                :data-tts-id="'ch3detail_' + module.id"
                                                @click="window.ttsToggle('ch3detail_' + module.id, module.content, 'ch3detail-tts-' + module.id)"
                                                title="Dengarkan Suara Subab"
                                            >
                                                <span class="tts-icon">
                                                    <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
                                                </span>
                                                <span class="tts-label">Dengarkan</span>
                                            </button>
                                            <button
                                                type="button"
                                                class="tts-nav-btn"
                                                onclick="window.LmsTTS.nextParagraph()"
                                                title="Paragraf Selanjutnya"
                                            >
                                                <svg class="w-3.5 h-3.5 text-slate-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                            </button>
                                            <button
                                                type="button"
                                                class="tts-speed-btn"
                                                onclick="window.LmsTTS.cycleRate()"
                                                title="Klik untuk mengubah kecepatan suara"
                                            >
                                                <svg class="w-3.5 h-3.5 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                                <span class="tts-speed-val">1x</span>
                                            </button>
                                        </div>

                                        <div :id="'ch3detail-tts-' + module.id" class="text-sm text-slate-600 leading-relaxed space-y-3.5 prose prose-slate max-w-none prose-sm" x-html="module.content"></div>

                                        @if(auth()->user()->isInstruktur())
                                            <div class="flex items-center gap-2 pt-3 border-t border-slate-100 mt-3">
                                                <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + module.id + '/edit'" class="px-2.5 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-2xs font-bold transition shadow-xs">
                                                    {{ __('Edit Modul') }}
                                                </a>
                                                <form :action="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + module.id" method="POST" onsubmit="return confirm('{{ __('Apakah Anda yakin ingin menghapus modul ini?') }}')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-2.5 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-2xs font-bold transition shadow-xs">
                                                        {{ __('Hapus') }}
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </article>
                                </template>
                            </div>
                        </div>
                    </section>

                    <!-- Manual Operation Group -->
                    <section class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                        <button
                            type="button"
                            @click="toggleSection('manual')"
                            class="w-full flex flex-col gap-3 bg-white p-6 text-left transition hover:bg-slate-50 md:flex-row md:items-center md:justify-between"
                        >
                            <div class="flex items-center space-x-3">
                                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-emerald-200 bg-white text-[10px] font-black text-emerald-600">02</span>
                                <div>
                                    <h2 class="text-base font-extrabold text-slate-800 uppercase tracking-wider">{{ __('Mode Operasi Manual') }}</h2>
                                    <p class="mt-1 text-[10px] font-semibold text-slate-400">{{ __('Klik judul bagian untuk melihat materi lengkap.') }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-2">
                                <span class="inline-flex w-fit rounded-full border border-emerald-200 bg-white px-2.5 py-0.5 text-[9px] font-bold text-emerald-600 uppercase tracking-wider">
                                    Module 2.1 - 2.4
                                </span>
                                <span
                                    class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-full border border-slate-200 bg-white text-base font-black text-slate-600 transition"
                                    x-text="isSectionExpanded('manual') ? '-' : '+'"
                                ></span>
                            </div>
                        </button>

                        <div x-show="isSectionExpanded('manual')" class="border-t border-gray-100 bg-white">
                            <div class="p-4 md:p-6 space-y-4">
                                <p class="text-sm text-slate-600 leading-relaxed">
                                    {{ __('Dengan memutar keyswitch ke mode manual akan mengaktifkan seluruh komponen penggerak Garbarata') }}
                                </p>

                                <template x-for="module in manualItems" :key="module.id">
                                    <article class="rounded-xl border border-gray-100 bg-white p-4 space-y-3 shadow-sm">
                                        <div class="border-b border-gray-100 pb-3">
                                            <h3 class="text-sm md:text-base font-bold text-slate-800 leading-snug" x-text="module.title"></h3>
                                        </div>

                                        {{-- TTS Button Chapter 3 Manual --}}
                                        <div class="tts-controls-group">
                                            <button
                                                type="button"
                                                class="tts-nav-btn"
                                                onclick="window.LmsTTS.prevParagraph()"
                                                title="Paragraf Sebelumnya"
                                            >
                                                <svg class="w-3.5 h-3.5 text-slate-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                            </button>
                                            <button
                                                class="tts-btn tts-btn-idle"
                                                :data-tts-id="'ch3manual_' + module.id"
                                                @click="window.ttsToggle('ch3manual_' + module.id, module.content, 'ch3manual-tts-' + module.id)"
                                                title="Dengarkan Suara Subab"
                                            >
                                                <span class="tts-icon">
                                                    <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
                                                </span>
                                                <span class="tts-label">Dengarkan</span>
                                            </button>
                                            <button
                                                type="button"
                                                class="tts-nav-btn"
                                                onclick="window.LmsTTS.nextParagraph()"
                                                title="Paragraf Selanjutnya"
                                            >
                                                <svg class="w-3.5 h-3.5 text-slate-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                            </button>
                                            <button
                                                type="button"
                                                class="tts-speed-btn"
                                                onclick="window.LmsTTS.cycleRate()"
                                                title="Klik untuk mengubah kecepatan suara"
                                            >
                                                <svg class="w-3.5 h-3.5 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                                <span class="tts-speed-val">1x</span>
                                            </button>
                                        </div>

                                        <div :id="'ch3manual-tts-' + module.id" class="text-sm text-slate-600 leading-relaxed space-y-3.5 prose prose-slate max-w-none prose-sm" x-html="module.content"></div>

                                        @if(auth()->user()->isInstruktur())
                                            <div class="flex items-center gap-2 pt-3 border-t border-slate-100 mt-3">
                                                <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + module.id + '/edit'" class="px-2.5 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-2xs font-bold transition shadow-xs">
                                                    {{ __('Edit Modul') }}
                                                </a>
                                                <form :action="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + module.id" method="POST" onsubmit="return confirm('{{ __('Apakah Anda yakin ingin menghapus modul ini?') }}')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-2.5 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-2xs font-bold transition shadow-xs">
                                                        {{ __('Hapus') }}
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </article>
                                </template>
                            </div>
                        </div>
                    </section>

                    <!-- Auto Mode Group -->
                    <section class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                        <button
                            type="button"
                            @click="toggleSection('auto')"
                            class="w-full flex flex-col gap-3 bg-white p-6 text-left transition hover:bg-slate-50 md:flex-row md:items-center md:justify-between"
                        >
                            <div class="flex items-center space-x-3">
                                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-amber-200 bg-white text-[10px] font-black text-amber-600">03</span>
                                <div>
                                    <h2 class="text-base font-extrabold text-slate-800 uppercase tracking-wider">{{ __('Mode Auto (Autolevel)') }}</h2>
                                    <p class="mt-1 text-[10px] font-semibold text-slate-400">{{ __('Klik judul bagian untuk melihat materi lengkap.') }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-2">
                                <span class="inline-flex w-fit rounded-full border border-amber-200 bg-white px-2.5 py-0.5 text-[9px] font-bold text-amber-600 uppercase tracking-wider">
                                    Module 3
                                </span>
                                <span
                                    class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-full border border-slate-200 bg-white text-base font-black text-slate-600 transition"
                                    x-text="isSectionExpanded('auto') ? '-' : '+'"
                                ></span>
                            </div>
                        </button>

                        <div x-show="isSectionExpanded('auto')" class="border-t border-gray-100 bg-white">
                            <div class="p-4 md:p-6 space-y-4">
                                <template x-for="module in autoItems" :key="module.id">
                                    <article class="rounded-xl border border-gray-100 bg-white p-4 space-y-3 shadow-sm">
                                        <div class="border-b border-gray-100 pb-3">
                                            <h3 class="text-sm md:text-base font-bold text-slate-800 leading-snug" x-text="module.title"></h3>
                                        </div>

                                        {{-- TTS Button Chapter 3 Auto --}}
                                        <div class="tts-controls-group">
                                            <button
                                                type="button"
                                                class="tts-nav-btn"
                                                onclick="window.LmsTTS.prevParagraph()"
                                                title="Paragraf Sebelumnya"
                                            >
                                                <svg class="w-3.5 h-3.5 text-slate-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                            </button>
                                            <button
                                                class="tts-btn tts-btn-idle"
                                                :data-tts-id="'ch3auto_' + module.id"
                                                @click="window.ttsToggle('ch3auto_' + module.id, module.content, 'ch3auto-tts-' + module.id)"
                                                title="Dengarkan Suara Subab"
                                            >
                                                <span class="tts-icon">
                                                    <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
                                                </span>
                                                <span class="tts-label">Dengarkan</span>
                                            </button>
                                            <button
                                                type="button"
                                                class="tts-nav-btn"
                                                onclick="window.LmsTTS.nextParagraph()"
                                                title="Paragraf Selanjutnya"
                                            >
                                                <svg class="w-3.5 h-3.5 text-slate-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                            </button>
                                            <button
                                                type="button"
                                                class="tts-speed-btn"
                                                onclick="window.LmsTTS.cycleRate()"
                                                title="Klik untuk mengubah kecepatan suara"
                                            >
                                                <svg class="w-3.5 h-3.5 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                                <span class="tts-speed-val">1x</span>
                                            </button>
                                        </div>

                                        <div :id="'ch3auto-tts-' + module.id" class="text-sm text-slate-600 leading-relaxed space-y-3.5 prose prose-slate max-w-none prose-sm" x-html="module.content"></div>

                                        @if(auth()->user()->isInstruktur())
                                            <div class="flex items-center gap-2 pt-3 border-t border-slate-100 mt-3">
                                                <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + module.id + '/edit'" class="px-2.5 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-2xs font-bold transition shadow-xs">
                                                    {{ __('Edit Modul') }}
                                                </a>
                                                <form :action="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + module.id" method="POST" onsubmit="return confirm('{{ __('Apakah Anda yakin ingin menghapus modul ini?') }}')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-2.5 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-2xs font-bold transition shadow-xs">
                                                        {{ __('Hapus') }}
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </article>
                                </template>
                            </div>
                        </div>
                    </section>

                    <!-- Operation Procedure Group -->
                    <section class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                        <button
                            type="button"
                            @click="toggleSection('procedure')"
                            class="w-full flex flex-col gap-3 bg-white p-6 text-left transition hover:bg-slate-50 md:flex-row md:items-center md:justify-between"
                        >
                            <div class="flex items-center space-x-3">
                                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-rose-200 bg-white text-[10px] font-black text-rose-600">04</span>
                                <div>
                                    <h2 class="text-base font-extrabold text-slate-800 uppercase tracking-wider">{{ __('Prosedur Pengoperasian') }}</h2>
                                    <p class="mt-1 text-[10px] font-semibold text-slate-400">{{ __('Klik judul bagian untuk melihat materi lengkap.') }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-2">
                                <span class="inline-flex w-fit rounded-full border border-rose-200 bg-white px-2.5 py-0.5 text-[9px] font-bold text-rose-600 uppercase tracking-wider">
                                    Module 4.1 - 4.6
                                </span>
                                <span
                                    class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-full border border-slate-200 bg-white text-base font-black text-slate-600 transition"
                                    x-text="isSectionExpanded('procedure') ? '-' : '+'"
                                ></span>
                            </div>
                        </button>

                        <div x-show="isSectionExpanded('procedure')" class="border-t border-gray-100 bg-white">
                            <div class="p-4 md:p-6 space-y-4">
                                <template x-for="module in procedureItems" :key="module.id">
                                    <article class="rounded-xl border border-gray-100 bg-white p-4 space-y-3 shadow-sm">
                                        <div class="border-b border-gray-100 pb-3">
                                            <h3 class="text-sm md:text-base font-bold text-slate-800 leading-snug" x-text="module.title"></h3>
                                        </div>

                                        {{-- TTS Button Chapter 3 Procedure --}}
                                        <div class="tts-controls-group">
                                            <button
                                                type="button"
                                                class="tts-nav-btn"
                                                onclick="window.LmsTTS.prevParagraph()"
                                                title="Paragraf Sebelumnya"
                                            >
                                                <svg class="w-3.5 h-3.5 text-slate-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                            </button>
                                            <button
                                                class="tts-btn tts-btn-idle"
                                                :data-tts-id="'ch3proc_' + module.id"
                                                @click="window.ttsToggle('ch3proc_' + module.id, module.content, 'ch3proc-tts-' + module.id)"
                                                title="Dengarkan Suara Subab"
                                            >
                                                <span class="tts-icon">
                                                    <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
                                                </span>
                                                <span class="tts-label">Dengarkan</span>
                                            </button>
                                            <button
                                                type="button"
                                                class="tts-nav-btn"
                                                onclick="window.LmsTTS.nextParagraph()"
                                                title="Paragraf Selanjutnya"
                                            >
                                                <svg class="w-3.5 h-3.5 text-slate-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                            </button>
                                            <button
                                                type="button"
                                                class="tts-speed-btn"
                                                onclick="window.LmsTTS.cycleRate()"
                                                title="Klik untuk mengubah kecepatan suara"
                                            >
                                                <svg class="w-3.5 h-3.5 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                                <span class="tts-speed-val">1x</span>
                                            </button>
                                        </div>

                                        <div :id="'ch3proc-tts-' + module.id" class="text-sm text-slate-600 leading-relaxed space-y-3.5 prose prose-slate max-w-none prose-sm" x-html="module.content"></div>

                                        @if(auth()->user()->isInstruktur())
                                            <div class="flex items-center gap-2 pt-3 border-t border-slate-100 mt-3">
                                                <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + module.id + '/edit'" class="px-2.5 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-2xs font-bold transition shadow-xs">
                                                    {{ __('Edit Modul') }}
                                                </a>
                                                <form :action="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + module.id" method="POST" onsubmit="return confirm('{{ __('Apakah Anda yakin ingin menghapus modul ini?') }}')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-2.5 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-2xs font-bold transition shadow-xs">
                                                        {{ __('Hapus') }}
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </article>
                                </template>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>

        @include('courses.partials.quiz-card')
    @elseif($chapter->order == 2)
        <!-- Custom Grouped Layout for Chapter 2: Mechanical Specs & Electrical Specs -->
        <div class="py-6 select-none" x-data="{
            modules: @js($modules),
            completeUrlTemplate: @js(route('courses.modules.complete', [$course->id, $chapter->id, '__MODULE__'])),
            csrfToken: @js(csrf_token()),
            mechItems: [],
            elecItems: [],
            expandedMechIds: [],

            init() {
                this.mechItems = this.modules.filter(module => module.title.startsWith('1.'));
                this.elecItems = this.modules.filter(module => module.title.startsWith('2.'));
                
                // Automatically complete all Elektrikal modules because they are fully visible on screen!
                this.elecItems.forEach(module => {
                    this.markModuleComplete(module.id);
                });
            },

            toggleMech(moduleId) {
                this.markModuleComplete(moduleId);

                if (this.expandedMechIds.includes(moduleId)) {
                    this.expandedMechIds = this.expandedMechIds.filter(id => id !== moduleId);
                    return;
                }

                this.expandedMechIds.push(moduleId);
            },

            isMechExpanded(moduleId) {
                return this.expandedMechIds.includes(moduleId);
            },

            markModuleComplete(moduleId) {
                fetch(this.completeUrlTemplate.replace('__MODULE__', moduleId), {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': this.csrfToken,
                        'Accept': 'application/json',
                    },
                });
            }
        }">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <!-- Navigation Back & Title Bar -->
                <div class="flex items-center justify-between">
                    <a href="{{ route('courses.show', $course->id) }}" class="inline-flex items-center text-xs font-bold text-gray-500 hover:text-blue-600 transition">
                        &larr; {{ __('Kembali ke Silabus Kursus') }}
                    </a>

                    <div class="flex items-center gap-2">
                        @if(auth()->user()->isInstruktur())
                            <a href="{{ route('modules.create', [$course->id, $chapter->id]) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg text-xs transition shadow-sm">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                </svg>
                                {{ __('Tambah Modul Baru') }}
                            </a>
                        @endif

                        <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-[9px] font-bold text-blue-600 border border-blue-100 uppercase tracking-wider">
                            {{ __('Bab') }} {{ $chapter->order }} {{ __('dari') }} {{ $chapters->count() }}
                        </span>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-800 text-base">
                        {{ str_replace("BAB {$chapter->order}: ", "", $chapter->title) }}
                    </h3>
                    <p class="text-sm text-gray-500 mt-1.5 leading-relaxed">
                        {{ __('Materi Bab 2 dibagi menjadi spesifikasi mekanikal dan elektrikal. Bagian mekanikal dapat dibuka dan ditutup per topik agar tabel dan gambar lebih mudah dibaca.') }}
                    </p>
                </div>

                <div class="space-y-8">
                    <!-- Mechanical Group -->
                    <section class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-5">
                        <div class="flex flex-col gap-2 border-b border-gray-100 pb-4 md:flex-row md:items-center md:justify-between">
                            <div class="flex items-center space-x-3">
                                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-blue-200 bg-white text-[10px] font-black text-blue-600">01</span>
                                <h2 class="text-base font-extrabold text-slate-800 uppercase tracking-wider">{{ __('Mekanikal') }}</h2>
                            </div>

                            <span class="inline-flex w-fit rounded-full border border-blue-200 bg-white px-2.5 py-0.5 text-[9px] font-bold text-blue-600 uppercase tracking-wider">
                                Module 1.1 - 1.4
                            </span>
                        </div>

                        <p class="text-[10px] font-semibold text-slate-400">
                            {{ __('Klik judul module untuk melihat materi lengkap.') }}
                        </p>

                        <div class="space-y-3">
                            <template x-for="module in mechItems" :key="module.id">
                                <article class="rounded-xl border border-gray-100 bg-white overflow-hidden shadow-sm">
                                    <button
                                        type="button"
                                        @click="toggleMech(module.id)"
                                        class="w-full flex items-center justify-between gap-4 bg-white px-4 py-3.5 text-left transition hover:bg-slate-50"
                                    >
                                        <span class="text-sm md:text-base font-bold text-slate-800" x-text="module.title"></span>
                                        <span
                                            class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-full border border-slate-200 bg-white text-base font-black text-slate-600 transition"
                                            x-text="isMechExpanded(module.id) ? '-' : '+'"
                                        ></span>
                                    </button>

                                    <div x-show="isMechExpanded(module.id)" class="border-t border-gray-100 bg-white">
                                        <div class="p-4 md:p-6 space-y-4">
                                            {{-- TTS Button Chapter 2 Mekanikal --}}
                                            <div class="tts-controls-group">
                                                <button
                                                    type="button"
                                                    class="tts-nav-btn"
                                                    onclick="window.LmsTTS.prevParagraph()"
                                                    title="Paragraf Sebelumnya"
                                                >
                                                    <svg class="w-3.5 h-3.5 text-slate-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                                </button>
                                                <button
                                                    class="tts-btn tts-btn-idle"
                                                    :data-tts-id="'ch2mech_' + module.id"
                                                    @click="window.ttsToggle('ch2mech_' + module.id, module.content, 'ch2mech-tts-' + module.id)"
                                                    title="Dengarkan Suara Subab"
                                                >
                                                    <span class="tts-icon">
                                                        <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
                                                    </span>
                                                    <span class="tts-label">Dengarkan</span>
                                                </button>
                                                <button
                                                    type="button"
                                                    class="tts-nav-btn"
                                                    onclick="window.LmsTTS.nextParagraph()"
                                                    title="Paragraf Selanjutnya"
                                                >
                                                    <svg class="w-3.5 h-3.5 text-slate-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                                </button>
                                                <button
                                                    type="button"
                                                    class="tts-speed-btn"
                                                    onclick="window.LmsTTS.cycleRate()"
                                                    title="Klik untuk mengubah kecepatan suara"
                                                >
                                                    <svg class="w-3.5 h-3.5 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                                    <span class="tts-speed-val">1x</span>
                                                </button>
                                            </div>
                                            <div :id="'ch2mech-tts-' + module.id" class="text-sm text-slate-600 leading-relaxed space-y-3.5 prose prose-slate max-w-none prose-sm" x-html="module.content"></div>

                                            @if(auth()->user()->isInstruktur())
                                                <div class="flex items-center gap-2 pt-3 border-t border-slate-100 mt-3">
                                                    <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + module.id + '/edit'" class="px-2.5 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-2xs font-bold transition shadow-xs">
                                                        {{ __('Edit Modul') }}
                                                    </a>
                                                    <form :action="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + module.id" method="POST" onsubmit="return confirm('{{ __('Apakah Anda yakin ingin menghapus modul ini?') }}')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="px-2.5 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-2xs font-bold transition shadow-xs">
                                                            {{ __('Hapus') }}
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </article>
                            </template>
                        </div>
                    </section>

                    <!-- Electrical Group -->
                    <section class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-5">
                        <div class="flex flex-col gap-2 border-b border-gray-100 pb-4 md:flex-row md:items-center md:justify-between">
                            <div class="flex items-center space-x-3">
                                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-emerald-200 bg-white text-[10px] font-black text-emerald-600">02</span>
                                <h2 class="text-base font-extrabold text-slate-800 uppercase tracking-wider">{{ __('Elektrikal') }}</h2>
                            </div>

                            <span class="inline-flex w-fit rounded-full border border-emerald-200 bg-white px-2.5 py-0.5 text-[9px] font-bold text-emerald-600 uppercase tracking-wider">
                                Module 2.1 - 2.3
                            </span>
                        </div>

                        <div class="space-y-4">
                            <template x-for="module in elecItems" :key="module.id">
                                <article class="rounded-xl border border-gray-100 bg-white p-4 space-y-3 shadow-sm">
                                    <div class="border-b border-gray-100 pb-3">
                                        <h3 class="text-sm md:text-base font-bold text-slate-800 leading-snug" x-text="module.title"></h3>
                                    </div>

                                    {{-- TTS Button Chapter 2 Elektrikal --}}
                                    <div class="tts-controls-group">
                                        <button
                                            type="button"
                                            class="tts-nav-btn"
                                            onclick="window.LmsTTS.prevParagraph()"
                                            title="Paragraf Sebelumnya"
                                        >
                                            <svg class="w-3.5 h-3.5 text-slate-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                        </button>
                                        <button
                                            class="tts-btn tts-btn-idle"
                                            :data-tts-id="'ch2elec_' + module.id"
                                            @click="window.ttsToggle('ch2elec_' + module.id, module.content, 'ch2elec-tts-' + module.id)"
                                            title="Dengarkan Suara Subab"
                                        >
                                            <span class="tts-icon">
                                                <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
                                            </span>
                                            <span class="tts-label">Dengarkan</span>
                                        </button>
                                        <button
                                            type="button"
                                            class="tts-nav-btn"
                                            onclick="window.LmsTTS.nextParagraph()"
                                            title="Paragraf Selanjutnya"
                                        >
                                            <svg class="w-3.5 h-3.5 text-slate-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        </button>
                                        <button
                                            type="button"
                                            class="tts-speed-btn"
                                            onclick="window.LmsTTS.cycleRate()"
                                            title="Klik untuk mengubah kecepatan suara"
                                        >
                                            <svg class="w-3.5 h-3.5 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                            <span class="tts-speed-val">1x</span>
                                        </button>
                                    </div>

                                    <div :id="'ch2elec-tts-' + module.id" class="text-sm text-slate-600 leading-relaxed space-y-3 prose prose-slate max-w-none prose-sm" x-html="module.content"></div>

                                    @if(auth()->user()->isInstruktur())
                                        <div class="flex items-center gap-2 pt-3 border-t border-slate-100 mt-3">
                                            <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + module.id + '/edit'" class="px-2.5 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-2xs font-bold transition shadow-xs">
                                                {{ __('Edit Modul') }}
                                            </a>
                                            <form :action="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + module.id" method="POST" onsubmit="return confirm('{{ __('Apakah Anda yakin ingin menghapus modul ini?') }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-2.5 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-2xs font-bold transition shadow-xs">
                                                    {{ __('Hapus') }}
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </article>
                            </template>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        @include('courses.partials.quiz-card')
    @elseif($chapter->order == 4)
        <!-- Custom Layout for Chapter 4 - Hybrid Style (Top-Tabs + Auto-Open Subsections) -->
        <div class="py-6 select-none" x-data="{
            modules: @js($modules->values()),
            activeTab: '4.1',
            activeSectionId: null,
            completedModuleIds: @js($learningProgress ? $learningProgress['completedModules']->toArray() : []),
            completeUrlTemplate: @js(route('courses.modules.complete', [$course->id, $chapter->id, '__MODULE__'])),
            csrfToken: @js(csrf_token()),

            get tabs() {
                const uniqueTabs = new Set();
                this.modules.forEach(m => {
                    const match = m.title.match(/^(4\.\d+)/);
                    if (match) uniqueTabs.add(match[1]);
                });
                return Array.from(uniqueTabs).sort((a, b) => parseInt(a.split('.')[1]) - parseInt(b.split('.')[1]));
            },
            init() {
                if (!this.tabs.includes(this.activeTab) && this.tabs.length > 0) {
                    this.activeTab = this.tabs[0];
                }
                this.markTabComplete(this.activeTab);
            },
            setActiveTab(tab) {
                this.activeTab = tab;
                // Stop TTS when switching tabs
                if (window.LmsTTS) window.LmsTTS.stop();
                this.markTabComplete(tab);
                this.$nextTick(() => {
                    document.getElementById('content-area-chapter-4')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
                });
            },
            markTabComplete(tab) {
                // Mark main tab module complete
                const mainMod = this.getSingleModule(tab);
                if (mainMod && mainMod.id) {
                    if (mainMod.content.includes('<details')) {
                        window.setupDetailsTracker(mainMod.id, 'content-area-chapter-4');
                    } else {
                        this.markModuleComplete(mainMod.id);
                    }
                }
                
                // Mark all submodules complete automatically when viewing this tab
                let subModules = [];
                if (tab === '4.6') {
                    subModules = this.modules.filter(m => m.title.startsWith('4.6.'));
                } else if (tab === '4.7') {
                    subModules = [];
                } else {
                    subModules = this.getTabModules(tab);
                }
                
                subModules.forEach(sub => {
                    if (sub && sub.id) {
                        this.markModuleComplete(sub.id);
                    }
                });
            },
            getTabModules(tab) {
                return this.modules.filter(m => m.title.startsWith(tab + '.') && m.title !== tab);
            },
            getSingleModule(tab) {
                let m = this.modules.find(m => m.title === tab || m.title.startsWith(tab + ' '));
                if (!m) m = this.modules.find(m => m.title.startsWith(tab));
                return m || { title: tab, content: '' };
            },
            markModuleComplete(moduleId) {
                const idNum = Number(moduleId);
                if (!Number.isInteger(idNum) || !this.completeUrlTemplate) return;
                if (this.completedModuleIds.includes(idNum)) return;
                
                fetch(this.completeUrlTemplate.replace('__MODULE__', moduleId), {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': this.csrfToken,
                        'Accept': 'application/json',
                    },
                }).then(res => {
                    if (res.ok) {
                        this.completedModuleIds.push(idNum);
                    }
                });
            },
            isTabComplete(tab) {
                const mainMod = this.getSingleModule(tab);
                if (mainMod && mainMod.id && !this.completedModuleIds.includes(Number(mainMod.id))) {
                    return false;
                }
                
                let subModules = [];
                if (tab === '4.6') {
                    subModules = this.modules.filter(m => m.title.startsWith('4.6.'));
                } else if (tab === '4.7') {
                    subModules = this.modules.filter(m => m.title.startsWith('4.7.'));
                } else {
                    subModules = this.getTabModules(tab);
                }
                
                return subModules.every(sub => !sub.id || this.completedModuleIds.includes(Number(sub.id)));
            },
            nextTab() {
                const idx = this.tabs.indexOf(this.activeTab);
                if (idx !== -1 && idx < this.tabs.length - 1) {
                    this.setActiveTab(this.tabs[idx + 1]);
                }
            },
            prevTab() {
                const idx = this.tabs.indexOf(this.activeTab);
                if (idx !== -1 && idx > 0) {
                    this.setActiveTab(this.tabs[idx - 1]);
                }
            }
        }">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

                <!-- Navigation Back & Title Bar -->
                <div class="flex items-center justify-between">
                    <a href="{{ route('courses.show', $course->id) }}" class="inline-flex items-center text-xs font-bold text-gray-500 hover:text-blue-600 transition">
                        &larr; {{ __('Kembali ke Silabus Kursus') }}
                    </a>

                    <div class="flex items-center gap-2">
                        @if(auth()->user()->isInstruktur())
                            <a href="{{ route('modules.create', [$course->id, $chapter->id]) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg text-xs transition shadow-sm">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                </svg>
                                {{ __('Tambah Modul Baru') }}
                            </a>
                        @endif

                        <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-[9px] font-bold text-blue-600 border border-blue-100 uppercase tracking-wider">
                            {{ __('Bab') }} {{ $chapter->order }} {{ __('dari') }} {{ $chapters->count() }}
                        </span>
                    </div>
                </div>

                <!-- Chapter Header Description Card -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-800 text-base">
                        {{ str_replace("BAB {$chapter->order}: ", "", $chapter->title) }}
                    </h3>
                    <p class="text-sm text-gray-500 mt-1.5 leading-relaxed">
                        {{ __('Materi modul pembelajaran tertulis. Gunakan menu tab di bawah untuk memilih sub-bab secara cepat atau gunakan tombol navigasi di bawah halaman untuk membaca secara berurutan.') }}
                    </p>
                </div>

                <!-- Horizontal Sub-Chapter Tab Navigation Bar -->
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col gap-3">
                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">{{ __('Pilih Sub-Bab Utama') }}</div>
                    <div class="flex flex-wrap gap-2">
                        <template x-for="tab in tabs" :key="tab">
                            <button
                                @click="setActiveTab(tab)"
                                class="px-4 py-2.5 rounded-lg text-sm font-bold transition text-left"
                                :class="activeTab === tab ? 'bg-blue-600 text-white shadow-sm' : 'bg-slate-50 text-slate-600 hover:bg-slate-100 hover:text-slate-800'"
                            >
                                <span x-text="tab === '4.6' ? '4.6 Checklist Inspeksi' : (tab === '4.7' ? '4.7 Troubleshooting' : getSingleModule(tab).title)"></span>
                            </button>
                        </template>
                    </div>
                </div>

                <!-- Main Content Card (Centered) -->
                <div id="content-area-chapter-4" class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden p-6 md:p-8 space-y-6 scroll-mt-24">
                    
                    <!-- Sub-chapter Title & Main Description -->
                    <div class="border-b border-slate-100 pb-5" x-show="activeTab !== '4.6' && activeTab !== '4.7'">
                        <div class="flex items-center justify-between flex-wrap gap-2">
                            <h3 class="text-base md:text-base font-extrabold text-slate-800" x-text="getSingleModule(activeTab).title"></h3>
                            {{-- TTS Button Chapter 4 Main Tab --}}
                            <template x-if="getSingleModule(activeTab).content">
                                <div class="tts-controls-group">
                                    <button
                                        type="button"
                                        class="tts-nav-btn"
                                        onclick="window.LmsTTS.prevParagraph()"
                                        title="Paragraf Sebelumnya"
                                    >
                                        <svg class="w-3.5 h-3.5 text-slate-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                    </button>
                                    <button
                                        class="tts-btn tts-btn-idle"
                                        :data-tts-id="'ch4main_' + getSingleModule(activeTab).id"
                                        @click="window.ttsToggle('ch4main_' + getSingleModule(activeTab).id, getSingleModule(activeTab).content, 'ch4main-tts-content')"
                                        title="Dengarkan Suara Subab"
                                    >
                                        <span class="tts-icon">
                                            <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
                                        </span>
                                        <span class="tts-label">Dengarkan</span>
                                    </button>
                                    <button
                                        type="button"
                                        class="tts-nav-btn"
                                        onclick="window.LmsTTS.nextParagraph()"
                                        title="Paragraf Selanjutnya"
                                    >
                                        <svg class="w-3.5 h-3.5 text-slate-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </button>
                                    <button
                                        type="button"
                                        class="tts-speed-btn"
                                        onclick="window.LmsTTS.cycleRate()"
                                        title="Klik untuk mengubah kecepatan suara"
                                    >
                                        <svg class="w-3.5 h-3.5 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                        <span class="tts-speed-val">1x</span>
                                    </button>
                                </div>
                            </template>
                        </div>
                        <div id="ch4main-tts-content" class="text-sm text-slate-600 leading-relaxed mt-3.5 prose prose-slate max-w-none prose-sm" x-html="getSingleModule(activeTab).content"></div>
                        
                        <!-- Action Buttons for Instructor inside Intro Card -->
                        @if(auth()->user()->isInstruktur())
                            <template x-if="getSingleModule(activeTab).id">
                                <div class="flex items-center gap-2 pt-4 border-t border-slate-50 mt-4">
                                    <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + getSingleModule(activeTab).id + '/edit'" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-xs font-bold transition shadow-xs">
                                        {{ __('Edit Deskripsi Pengantar') }}
                                    </a>
                                </div>
                            </template>
                        @endif
                    </div>

                    <!-- 1. Display for tabs 4.1 to 4.5: All submodules fully open (No accordions!) -->
                    <template x-if="activeTab !== '4.6' && activeTab !== '4.7'">
                        <div class="space-y-8 divide-y divide-slate-100">
                            <template x-for="subModule in getTabModules(activeTab)" :key="subModule.id">
                                <div class="pt-8 first:pt-0">
                                    <div class="flex items-center justify-between flex-wrap gap-2">
                                        <h4 class="text-sm md:text-base font-bold text-slate-800" x-text="subModule.title"></h4>
                                        {{-- TTS Button Chapter 4 Sub-module --}}
                                        <div class="tts-controls-group">
                                            <button
                                                type="button"
                                                class="tts-nav-btn"
                                                onclick="window.LmsTTS.prevParagraph()"
                                                title="Paragraf Sebelumnya"
                                            >
                                                <svg class="w-3.5 h-3.5 text-slate-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                            </button>
                                            <button
                                                class="tts-btn tts-btn-idle"
                                                :data-tts-id="'ch4sub_' + subModule.id"
                                                @click="window.ttsToggle('ch4sub_' + subModule.id, subModule.content, 'ch4sub-tts-' + subModule.id)"
                                                title="Dengarkan Suara Subab"
                                            >
                                                <span class="tts-icon">
                                                    <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
                                                </span>
                                                <span class="tts-label">Dengarkan</span>
                                            </button>
                                            <button
                                                type="button"
                                                class="tts-nav-btn"
                                                onclick="window.LmsTTS.nextParagraph()"
                                                title="Paragraf Selanjutnya"
                                            >
                                                <svg class="w-3.5 h-3.5 text-slate-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                            </button>
                                            <button
                                                type="button"
                                                class="tts-speed-btn"
                                                onclick="window.LmsTTS.cycleRate()"
                                                title="Klik untuk mengubah kecepatan suara"
                                            >
                                                <svg class="w-3.5 h-3.5 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                                <span class="tts-speed-val">1x</span>
                                            </button>
                                        </div>
                                    </div>
                                    <div :id="'ch4sub-tts-' + subModule.id" class="text-sm text-slate-600 leading-relaxed prose prose-slate max-w-none prose-sm" x-html="subModule.content"></div>
                                    
                                    <!-- Action Buttons for Instructor inside Submodule -->
                                    @if(auth()->user()->isInstruktur())
                                        <div class="flex items-center gap-2 mt-4 pt-2">
                                            <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + subModule.id + '/edit'" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-xs font-bold transition shadow-xs">
                                                {{ __('Edit Modul Ini') }}
                                            </a>
                                            <form :action="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + subModule.id" method="POST" onsubmit="return confirm('{{ __('Apakah Anda yakin ingin menghapus modul ini?') }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-xs font-bold transition shadow-xs">
                                                    {{ __('Hapus Modul') }}
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </template>
                        </div>
                    </template>

                    <!-- 2. Display for tab 4.6 (Checklist): 4.6.1 & 4.6.2 open, 4.6.3 & 4.6.4 in native details accordions -->
                    <template x-if="activeTab === '4.6'">
                        <div class="space-y-8">
                            <!-- 4.6.1 -->
                            <template x-if="getSingleModule('4.6.1').id">
                                <div class="pt-4 first:pt-0">
                                    <div class="flex items-center justify-between flex-wrap gap-2 mb-3">
                                        <h4 class="text-sm md:text-base font-bold text-slate-800" x-text="getSingleModule('4.6.1').title"></h4>
                                        <div class="tts-controls-group">
                                            <button
                                                type="button"
                                                class="tts-nav-btn"
                                                onclick="window.LmsTTS.prevParagraph()"
                                                title="Paragraf Sebelumnya"
                                            >
                                                <svg class="w-3.5 h-3.5 text-slate-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                            </button>
                                            <button
                                                class="tts-btn tts-btn-idle"
                                                data-tts-id="ch4-tab461"
                                                @click="window.ttsToggle('ch4-tab461', getSingleModule('4.6.1').content, 'ch4-tts-461')"
                                                title="Dengarkan Suara Subab"
                                            >
                                                <span class="tts-icon">
                                                    <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
                                                </span>
                                                <span class="tts-label">Dengarkan</span>
                                            </button>
                                            <button
                                                type="button"
                                                class="tts-nav-btn"
                                                onclick="window.LmsTTS.nextParagraph()"
                                                title="Paragraf Selanjutnya"
                                            >
                                                <svg class="w-3.5 h-3.5 text-slate-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                            </button>
                                            <button
                                                type="button"
                                                class="tts-speed-btn"
                                                onclick="window.LmsTTS.cycleRate()"
                                                title="Klik untuk mengubah kecepatan suara"
                                            >
                                                <svg class="w-3.5 h-3.5 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                                <span class="tts-speed-val">1x</span>
                                            </button>
                                        </div>
                                    </div>
                                    <div id="ch4-tts-461" class="text-sm text-slate-600 leading-relaxed prose prose-slate max-w-none prose-sm" x-html="getSingleModule('4.6.1').content"></div>
                                    
                                    @if(auth()->user()->isInstruktur())
                                        <div class="flex items-center gap-2 mt-4 pt-2">
                                            <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + getSingleModule('4.6.1').id + '/edit'" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-xs font-bold transition shadow-xs">
                                                {{ __('Edit Modul Ini') }}
                                            </a>
                                            <form :action="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + getSingleModule('4.6.1').id" method="POST" onsubmit="return confirm('{{ __('Apakah Anda yakin ingin menghapus modul ini?') }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-xs font-bold transition shadow-xs">
                                                    {{ __('Hapus Modul') }}
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </template>

                            <!-- 4.6.2 -->
                            <template x-if="getSingleModule('4.6.2').id">
                                <div class="pt-6 border-t border-slate-100">
                                    <div class="flex items-center justify-between flex-wrap gap-2 mb-3">
                                        <h4 class="text-sm md:text-base font-bold text-slate-800" x-text="getSingleModule('4.6.2').title"></h4>
                                        <div class="tts-controls-group">
                                            <button
                                                type="button"
                                                class="tts-nav-btn"
                                                onclick="window.LmsTTS.prevParagraph()"
                                                title="Paragraf Sebelumnya"
                                            >
                                                <svg class="w-3.5 h-3.5 text-slate-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                            </button>
                                            <button
                                                class="tts-btn tts-btn-idle"
                                                data-tts-id="ch4-tab462"
                                                @click="window.ttsToggle('ch4-tab462', getSingleModule('4.6.2').content, 'ch4-tts-462')"
                                                title="Dengarkan Suara Subab"
                                            >
                                                <span class="tts-icon">
                                                    <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
                                                </span>
                                                <span class="tts-label">Dengarkan</span>
                                            </button>
                                            <button
                                                type="button"
                                                class="tts-nav-btn"
                                                onclick="window.LmsTTS.nextParagraph()"
                                                title="Paragraf Selanjutnya"
                                            >
                                                <svg class="w-3.5 h-3.5 text-slate-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                            </button>
                                            <button
                                                type="button"
                                                class="tts-speed-btn"
                                                onclick="window.LmsTTS.cycleRate()"
                                                title="Klik untuk mengubah kecepatan suara"
                                            >
                                                <svg class="w-3.5 h-3.5 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                                <span class="tts-speed-val">1x</span>
                                            </button>
                                        </div>
                                    </div>
                                    <div id="ch4-tts-462" class="text-sm text-slate-600 leading-relaxed prose prose-slate max-w-none prose-sm" x-html="getSingleModule('4.6.2').content"></div>
                                    
                                    @if(auth()->user()->isInstruktur())
                                        <div class="flex items-center gap-2 mt-4 pt-2">
                                            <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + getSingleModule('4.6.2').id + '/edit'" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-xs font-bold transition shadow-xs">
                                                {{ __('Edit Modul Ini') }}
                                            </a>
                                            <form :action="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + getSingleModule('4.6.2').id" method="POST" onsubmit="return confirm('{{ __('Apakah Anda yakin ingin menghapus modul ini?') }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-xs font-bold transition shadow-xs">
                                                    {{ __('Hapus Modul') }}
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </template>

                            <!-- 4.6.3 Inspeksi Bulanan (Native details) -->
                            <div class="pt-6 border-t border-slate-100">
                                <details class="group rounded-xl border border-slate-200 bg-white shadow-xs overflow-hidden" open>
                                    <summary class="flex items-center justify-between gap-3 cursor-pointer select-none px-4 py-3 bg-slate-50 hover:bg-slate-100 transition-colors duration-150 list-none">
                                        <span class="font-bold text-slate-800 text-sm uppercase tracking-wide">4.6.3 Inspeksi Bulanan</span>
                                        <svg class="w-4 h-4 text-slate-500 transition-transform duration-200 group-open:rotate-180 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                                    </summary>
                                    <div class="border-t border-slate-100 bg-white p-4 space-y-6 divide-y divide-slate-100">
                                        <template x-for="subModule in modules.filter(m => m.title.startsWith('4.6.3.'))" :key="subModule.id">
                                            <div class="pt-6 first:pt-0">
                                                <div class="flex items-center justify-between flex-wrap gap-2 mb-2">
                                                <h5 class="font-bold text-slate-800 text-sm" x-text="subModule.title"></h5>
                                                <div class="tts-controls-group">
                                                    <button
                                                        type="button"
                                                        class="tts-nav-btn"
                                                        onclick="window.LmsTTS.prevParagraph()"
                                                        title="Paragraf Sebelumnya"
                                                    >
                                                        <svg class="w-3.5 h-3.5 text-slate-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                                    </button>
                                                    <button
                                                        class="tts-btn tts-btn-idle"
                                                        :data-tts-id="'ch4-463sub_' + subModule.id"
                                                        @click="window.ttsToggle('ch4-463sub_' + subModule.id, subModule.content, 'ch4-463sub-tts-' + subModule.id)"
                                                        title="Dengarkan Suara Subab"
                                                    >
                                                        <span class="tts-icon">
                                                            <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
                                                        </span>
                                                        <span class="tts-label">Dengarkan</span>
                                                    </button>
                                                    <button
                                                        type="button"
                                                        class="tts-nav-btn"
                                                        onclick="window.LmsTTS.nextParagraph()"
                                                        title="Paragraf Selanjutnya"
                                                    >
                                                        <svg class="w-3.5 h-3.5 text-slate-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                                    </button>
                                                    <button
                                                        type="button"
                                                        class="tts-speed-btn"
                                                        onclick="window.LmsTTS.cycleRate()"
                                                        title="Klik untuk mengubah kecepatan suara"
                                                    >
                                                        <svg class="w-3.5 h-3.5 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                                        <span class="tts-speed-val">1x</span>
                                                    </button>
                                                </div>
                                            </div>
                                                <div :id="'ch4-463sub-tts-' + subModule.id" class="text-sm text-slate-600 leading-relaxed prose prose-slate max-w-none prose-sm" x-html="subModule.content"></div>
                                                
                                                @if(auth()->user()->isInstruktur())
                                                    <div class="flex items-center gap-2 mt-4 pt-2">
                                                        <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + subModule.id + '/edit'" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-xs font-bold transition shadow-xs">
                                                            {{ __('Edit Tabel Ini') }}
                                                        </a>
                                                        <form :action="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + subModule.id" method="POST" onsubmit="return confirm('{{ __('Apakah Anda yakin ingin menghapus tabel ini?') }}')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-xs font-bold transition shadow-xs">
                                                                {{ __('Hapus Tabel') }}
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endif
                                            </div>
                                        </template>
                                    </div>
                                </details>
                            </div>

                            <!-- 4.6.4 Inspeksi Quartal (Native details) -->
                            <div class="pt-6 border-t border-slate-100">
                                <details class="group rounded-xl border border-slate-200 bg-white shadow-xs overflow-hidden" open>
                                    <summary class="flex items-center justify-between gap-3 cursor-pointer select-none px-4 py-3 bg-slate-50 hover:bg-slate-100 transition-colors duration-150 list-none">
                                        <span class="font-bold text-slate-800 text-sm uppercase tracking-wide">4.6.4 Inspeksi Quartal</span>
                                        <svg class="w-4 h-4 text-slate-500 transition-transform duration-200 group-open:rotate-180 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                                    </summary>
                                    <div class="border-t border-slate-100 bg-white p-4 space-y-6 divide-y divide-slate-100">
                                        <template x-for="subModule in modules.filter(m => m.title.startsWith('4.6.4.'))" :key="subModule.id">
                                            <div class="pt-6 first:pt-0">
                                                <div class="flex items-center justify-between flex-wrap gap-2 mb-2">
                                                <h5 class="font-bold text-slate-800 text-sm" x-text="subModule.title"></h5>
                                                <div class="tts-controls-group">
                                                    <button
                                                        type="button"
                                                        class="tts-nav-btn"
                                                        onclick="window.LmsTTS.prevParagraph()"
                                                        title="Paragraf Sebelumnya"
                                                    >
                                                        <svg class="w-3.5 h-3.5 text-slate-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                                    </button>
                                                    <button
                                                        class="tts-btn tts-btn-idle"
                                                        :data-tts-id="'ch4-464sub_' + subModule.id"
                                                        @click="window.ttsToggle('ch4-464sub_' + subModule.id, subModule.content, 'ch4-464sub-tts-' + subModule.id)"
                                                        title="Dengarkan Suara Subab"
                                                    >
                                                        <span class="tts-icon">
                                                            <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
                                                        </span>
                                                        <span class="tts-label">Dengarkan</span>
                                                    </button>
                                                    <button
                                                        type="button"
                                                        class="tts-nav-btn"
                                                        onclick="window.LmsTTS.nextParagraph()"
                                                        title="Paragraf Selanjutnya"
                                                    >
                                                        <svg class="w-3.5 h-3.5 text-slate-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                                    </button>
                                                    <button
                                                        type="button"
                                                        class="tts-speed-btn"
                                                        onclick="window.LmsTTS.cycleRate()"
                                                        title="Klik untuk mengubah kecepatan suara"
                                                    >
                                                        <svg class="w-3.5 h-3.5 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                                        <span class="tts-speed-val">1x</span>
                                                    </button>
                                                </div>
                                            </div>
                                                <div :id="'ch4-464sub-tts-' + subModule.id" class="text-sm text-slate-600 leading-relaxed prose prose-slate max-w-none prose-sm" x-html="subModule.content"></div>
                                                
                                                @if(auth()->user()->isInstruktur())
                                                    <div class="flex items-center gap-2 mt-4 pt-2">
                                                        <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + subModule.id + '/edit'" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-xs font-bold transition shadow-xs">
                                                            {{ __('Edit Tabel Ini') }}
                                                        </a>
                                                        <form :action="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + subModule.id" method="POST" onsubmit="return confirm('{{ __('Apakah Anda yakin ingin menghapus tabel ini?') }}')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-xs font-bold transition shadow-xs">
                                                                {{ __('Hapus Tabel') }}
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endif
                                            </div>
                                        </template>
                                    </div>
                                </details>
                            </div>
                        </div>
                    </template>

                    <!-- 3. Display for tab 4.7 (Troubleshooting): Accordions list -->
                    <template x-if="activeTab === '4.7'">
                        <div class="space-y-4">
                            <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">{{ __('Daftar Troubleshooting (Klik untuk membuka detail):') }}</div>
                            <div class="space-y-3">
                                <template x-for="subModule in modules.filter(m => m.title.startsWith('4.7.') && m.title !== '4.7')" :key="subModule.id">
                                    <div class="rounded-xl border border-slate-100 bg-white overflow-hidden shadow-xs">
                                        <button
                                            type="button"
                                            @click="activeSectionId = activeSectionId === subModule.id ? null : subModule.id; if(activeSectionId === subModule.id) markModuleComplete(subModule.id);"
                                            class="w-full flex items-center justify-between gap-4 bg-slate-50/50 px-4 py-3.5 text-left transition hover:bg-slate-50"
                                        >
                                            <span class="text-sm font-bold text-slate-800" x-text="subModule.title"></span>
                                            <span
                                                class="inline-flex h-7 w-7 shrink-0 items-center justify-center rounded-full border border-slate-200 bg-white text-sm font-black text-slate-600 transition"
                                                x-text="activeSectionId === subModule.id ? '-' : '+'"
                                            ></span>
                                        </button>

                                        <div x-show="activeSectionId === subModule.id" class="border-t border-slate-100 bg-white">
                                            <div class="p-4 md:p-6 space-y-4">
                                                {{-- TTS Button Chapter 4 Tab 4.7 Troubleshooting --}}
                                                <div class="tts-controls-group">
                                                    <button
                                                        type="button"
                                                        class="tts-nav-btn"
                                                        onclick="window.LmsTTS.prevParagraph()"
                                                        title="Paragraf Sebelumnya"
                                                    >
                                                        <svg class="w-3.5 h-3.5 text-slate-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                                    </button>
                                                    <button
                                                        class="tts-btn tts-btn-idle"
                                                        :data-tts-id="'ch4-47_' + subModule.id"
                                                        @click="window.ttsToggle('ch4-47_' + subModule.id, subModule.content, 'ch4-47-tts-' + subModule.id)"
                                                        title="Dengarkan Suara Subab"
                                                    >
                                                        <span class="tts-icon">
                                                            <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
                                                        </span>
                                                        <span class="tts-label">Dengarkan</span>
                                                    </button>
                                                    <button
                                                        type="button"
                                                        class="tts-nav-btn"
                                                        onclick="window.LmsTTS.nextParagraph()"
                                                        title="Paragraf Selanjutnya"
                                                    >
                                                        <svg class="w-3.5 h-3.5 text-slate-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                                    </button>
                                                    <button
                                                        type="button"
                                                        class="tts-speed-btn"
                                                        onclick="window.LmsTTS.cycleRate()"
                                                        title="Klik untuk mengubah kecepatan suara"
                                                    >
                                                        <svg class="w-3.5 h-3.5 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                                        <span class="tts-speed-val">1x</span>
                                                    </button>
                                                </div>
                                                <div :id="'ch4-47-tts-' + subModule.id" class="text-sm text-slate-600 leading-relaxed space-y-3.5 prose prose-slate max-w-none prose-sm" x-html="subModule.content"></div>
                                                
                                                @if(auth()->user()->isInstruktur())
                                                    <div class="flex items-center gap-2 pt-4 border-t border-slate-100">
                                                        <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + subModule.id + '/edit'" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-xs font-bold transition shadow-xs">
                                                            {{ __('Edit Tabel Trouble Ini') }}
                                                        </a>
                                                        <form :action="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + subModule.id" method="POST" onsubmit="return confirm('{{ __('Apakah Anda yakin ingin menghapus tabel trouble ini?') }}')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-xs font-bold transition shadow-xs">
                                                                {{ __('Hapus Tabel Trouble') }}
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>

                    <!-- Prev/Next Navigation Buttons at the bottom of Content Card -->
                    <div class="border-t border-slate-100 pt-6 flex items-center justify-between gap-4">
                        <button
                            @click="prevTab()"
                            class="px-4 py-2 bg-slate-50 hover:bg-slate-100 text-slate-600 text-sm font-bold rounded-lg transition"
                            x-show="tabs.indexOf(activeTab) > 0"
                        >
                            &larr; {{ __('Kembali') }}
                        </button>
                        <div x-show="tabs.indexOf(activeTab) === 0"></div>

                        <button
                            @click="nextTab()"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-lg transition shadow-xs"
                            x-show="tabs.indexOf(activeTab) < tabs.length - 1"
                        >
                            {{ __('Lanjutkan') }} &rarr;
                        </button>
                        <div x-show="tabs.indexOf(activeTab) === tabs.length - 1"></div>
                    </div>

                </div>

            </div>
        </div>

        @include('courses.partials.quiz-card')
    @elseif($chapter->order == 5)
        <!-- Custom Layout for Chapter 5 with Accordions for 5.1 -->
        <div class="py-6 select-none" x-data="{
            modules: @js($modules->values()),
            activeTab: '5.1',
            expandedModuleId: null,
            completeUrlTemplate: @js(route('courses.modules.complete', [$course->id, $chapter->id, '__MODULE__'])),
            csrfToken: @js(csrf_token()),

            get tabs() {
                const uniqueTabs = new Set();
                this.modules.forEach(m => {
                    const match = m.title.match(/^(5\.\d+)/);
                    if (match) uniqueTabs.add(match[1]);
                });
                return Array.from(uniqueTabs).sort((a, b) => parseInt(a.split('.')[1]) - parseInt(b.split('.')[1]));
            },
            init() {
                if (!this.tabs.includes(this.activeTab) && this.tabs.length > 0) {
                    this.activeTab = this.tabs[0];
                }
                const initialModule = this.getSingleModule(this.activeTab);
                if (initialModule && initialModule.id) {
                    if (initialModule.content.includes('<details')) {
                        window.setupDetailsTracker(initialModule.id, 'content-area-chapter-5');
                    } else {
                        this.markModuleComplete(initialModule.id);
                    }
                }
            },
            getTabModules(tab) {
                return this.modules.filter(m => m.title.startsWith(tab + '.'));
            },
            getSingleModule(tab) {
                let m = this.modules.find(m => m.title === tab || m.title.startsWith(tab + ' '));
                if (!m) m = this.modules.find(m => m.title.startsWith(tab));
                return m || { title: tab, content: '' };
            },
            toggleModule(id) {
                this.expandedModuleId = this.expandedModuleId === id ? null : id;
                if (this.expandedModuleId === id) {
                    let dbId = id;
                    if (isNaN(id)) {
                        const m = this.getSingleModule(id);
                        if (m) dbId = m.id;
                    }
                    this.markModuleComplete(dbId);
                }
            },
            markModuleComplete(moduleId) {
                if (!Number.isInteger(Number(moduleId)) || !this.completeUrlTemplate) return;
                fetch(this.completeUrlTemplate.replace('__MODULE__', moduleId), {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': this.csrfToken,
                        'Accept': 'application/json',
                    },
                });
            },
            setActiveTab(tab) {
                this.activeTab = tab;
                // Stop TTS when switching tabs
                if (window.LmsTTS) window.LmsTTS.stop();
                this.expandedModuleId = null;
                const m = this.getSingleModule(tab);
                if (m && m.id) {
                    if (tab === '5.3') {
                        this.markModuleComplete(m.id);
                    } else if (m.content.includes('<details')) {
                        window.setupDetailsTracker(m.id, 'content-area-chapter-5');
                    } else {
                        this.markModuleComplete(m.id);
                    }
                }
                this.$nextTick(() => {
                    document.getElementById('content-area-chapter-5')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
                });
            },
            nextTab() {
                const idx = this.tabs.indexOf(this.activeTab);
                if (idx !== -1 && idx < this.tabs.length - 1) {
                    this.setActiveTab(this.tabs[idx + 1]);
                }
            },
            prevTab() {
                const idx = this.tabs.indexOf(this.activeTab);
                if (idx !== -1 && idx > 0) {
                    this.setActiveTab(this.tabs[idx - 1]);
                }
            }
        }">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6" id="content-area-chapter-5">

                <!-- Navigation Back & Title Bar -->
                <div class="flex items-center justify-between">
                    <a href="{{ route('courses.show', $course->id) }}" class="inline-flex items-center text-xs font-bold text-gray-500 hover:text-blue-600 transition">
                        &larr; {{ __('Kembali ke Silabus Kursus') }}
                    </a>

                    <div class="flex items-center gap-2">
                        @if(auth()->user()->isInstruktur())
                            <a href="{{ route('modules.create', [$course->id, $chapter->id]) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg text-xs transition shadow-sm">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                </svg>
                                {{ __('Tambah Modul Baru') }}
                            </a>
                        @endif

                        <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-[9px] font-bold text-blue-600 border border-blue-100 uppercase tracking-wider">
                            {{ __('Bab') }} {{ $chapter->order }} {{ __('dari') }} {{ $chapters->count() }}
                        </span>
                    </div>
                </div>

                <!-- Chapter Header Description Card -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-800 text-base">
                        {{ str_replace("BAB {$chapter->order}: ", "", $chapter->title) }}
                    </h3>
                    <p class="text-sm text-gray-500 mt-1.5 leading-relaxed">
                        {{ __('Materi modul pembelajaran tertulis. Gunakan menu navigasi di bawah untuk memilih sub-bab dan membaca detail spesifikasi.') }}
                    </p>
                </div>

                <!-- Main Study Room Content -->
                <div class="space-y-6">
                    
                    <!-- 1. Top horizontal Sub-Chapter Navigation Bar -->
                    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-3">
                        <div class="flex items-center space-x-2 shrink-0">
                            <span class="text-sm font-bold text-slate-700 uppercase tracking-wide">{{ __('Pilih Topik Sub-Bab:') }}</span>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <template x-for="tab in tabs" :key="tab">
                                <button
                                    @click="setActiveTab(tab)"
                                    class="px-4 py-2.5 rounded-lg text-sm font-bold transition text-left"
                                    :class="activeTab === tab ? 'bg-blue-600 text-white shadow-sm' : 'bg-slate-50 text-slate-600 hover:bg-slate-100 hover:text-slate-800'"
                                >
                                    <span x-text="getSingleModule(tab).title"></span>
                                </button>
                            </template>
                        </div>
                    </div>

                    <!-- 2. Content Display Area -->
                    <div>
                        <!-- If Active Tab is 5.1 (Daftar Komponen) -> Show Accordions -->
                        <template x-if="activeTab === '5.1'">
                            <div class="space-y-3">
                                <template x-for="module in getTabModules('5.1')" :key="module.id">
                                    <div class="rounded-xl border border-gray-100 bg-white overflow-hidden shadow-sm">
                                        <button
                                            type="button"
                                            @click="toggleModule(module.id)"
                                            class="w-full flex items-center justify-between gap-4 bg-white px-4 py-3.5 text-left transition hover:bg-slate-50"
                                        >
                                            <span class="text-sm font-bold text-slate-800" x-text="module.title"></span>
                                            <span
                                                class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-full border border-slate-200 bg-white text-base font-black text-slate-600 transition"
                                                x-text="expandedModuleId === module.id ? '-' : '+'"
                                            ></span>
                                        </button>

                                        <div x-show="expandedModuleId === module.id" class="border-t border-gray-100 bg-white">
                                            <div class="p-4 md:p-6 space-y-4">
                                                {{-- TTS Button Chapter 5 Accordion --}}
                                                <div class="tts-controls-group">
                                                    <button
                                                        type="button"
                                                        class="tts-nav-btn"
                                                        onclick="window.LmsTTS.prevParagraph()"
                                                        title="Paragraf Sebelumnya"
                                                    >
                                                        <svg class="w-3.5 h-3.5 text-slate-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                                    </button>
                                                    <button
                                                        class="tts-btn tts-btn-idle"
                                                        :data-tts-id="'ch5acc_' + module.id"
                                                        @click="window.ttsToggle('ch5acc_' + module.id, module.content, 'ch5acc-tts-' + module.id)"
                                                        title="Dengarkan Suara Subab"
                                                    >
                                                        <span class="tts-icon">
                                                            <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
                                                        </span>
                                                        <span class="tts-label">Dengarkan</span>
                                                    </button>
                                                    <button
                                                        type="button"
                                                        class="tts-nav-btn"
                                                        onclick="window.LmsTTS.nextParagraph()"
                                                        title="Paragraf Selanjutnya"
                                                    >
                                                        <svg class="w-3.5 h-3.5 text-slate-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                                    </button>
                                                    <button
                                                        type="button"
                                                        class="tts-speed-btn"
                                                        onclick="window.LmsTTS.cycleRate()"
                                                        title="Klik untuk mengubah kecepatan suara"
                                                    >
                                                        <svg class="w-3.5 h-3.5 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                                        <span class="tts-speed-val">1x</span>
                                                    </button>
                                                </div>
                                                <div :id="'ch5acc-tts-' + module.id" class="text-sm text-slate-600 leading-relaxed space-y-3.5 prose prose-slate max-w-none prose-sm" x-html="module.content"></div>
                                                
                                                <!-- Action Buttons for Instructor inside Accordion -->
                                                @if(auth()->user()->isInstruktur())
                                                    <div class="flex items-center gap-2 pt-4 border-t border-slate-100">
                                                        <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + module.id + '/edit'" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-xs font-bold transition shadow-xs">
                                                            {{ __('Edit Modul Ini') }}
                                                        </a>
                                                        <form :action="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + module.id" method="POST" onsubmit="return confirm('{{ __('Apakah Anda yakin ingin menghapus modul ini?') }}')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-xs font-bold transition shadow-xs">
                                                                {{ __('Hapus Modul') }}
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </template>

                        <!-- If Active Tab is not 5.1 -> Show Single Module Card -->
                        <template x-if="activeTab !== '5.1'">
                            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                                <div class="p-6 md:p-8 space-y-6">
                                    <div class="flex items-center justify-between flex-wrap gap-2">
                                        <h3 class="text-base font-bold text-slate-800" x-text="getSingleModule(activeTab).title"></h3>
                                        {{-- TTS Button Chapter 5 Main Content --}}
                                        <template x-if="getSingleModule(activeTab).content">
                                            <div class="tts-controls-group">
                                                <button
                                                    type="button"
                                                    class="tts-nav-btn"
                                                    onclick="window.LmsTTS.prevParagraph()"
                                                    title="Paragraf Sebelumnya"
                                                >
                                                    <svg class="w-3.5 h-3.5 text-slate-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                                </button>
                                                <button
                                                    class="tts-btn tts-btn-idle"
                                                    :data-tts-id="'ch5main_' + getSingleModule(activeTab).id"
                                                    @click="window.ttsToggle('ch5main_' + getSingleModule(activeTab).id, getSingleModule(activeTab).content, 'ch5main-tts-content')"
                                                    title="Dengarkan Suara Subab"
                                                >
                                                    <span class="tts-icon">
                                                        <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
                                                    </span>
                                                    <span class="tts-label">Dengarkan</span>
                                                </button>
                                                <button
                                                    type="button"
                                                    class="tts-nav-btn"
                                                    onclick="window.LmsTTS.nextParagraph()"
                                                    title="Paragraf Selanjutnya"
                                                >
                                                    <svg class="w-3.5 h-3.5 text-slate-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                                </button>
                                                <button
                                                    type="button"
                                                    class="tts-speed-btn"
                                                    onclick="window.LmsTTS.cycleRate()"
                                                    title="Klik untuk mengubah kecepatan suara"
                                                >
                                                    <svg class="w-3.5 h-3.5 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                                    <span class="tts-speed-val">1x</span>
                                                </button>
                                            </div>
                                        </template>
                                    </div>
                                    
                                    <div id="ch5main-tts-content" class="text-sm text-slate-600 leading-relaxed space-y-3.5 prose prose-slate max-w-none prose-sm" x-html="getSingleModule(activeTab).content"></div>
                                    
                                    <!-- Action Buttons for Instructor -->
                                    @if(auth()->user()->isInstruktur())
                                        <template x-if="getSingleModule(activeTab).id">
                                            <div class="flex items-center gap-2 pt-4 border-t border-slate-100">
                                                <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + getSingleModule(activeTab).id + '/edit'" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-xs font-bold transition shadow-xs">
                                                    {{ __('Edit Modul Ini') }}
                                                </a>
                                                <form :action="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + getSingleModule(activeTab).id" method="POST" onsubmit="return confirm('{{ __('Apakah Anda yakin ingin menghapus modul ini?') }}')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-xs font-bold transition shadow-xs">
                                                        {{ __('Hapus Modul') }}
                                                    </button>
                                                </form>
                                            </div>
                                        </template>
                                    @endif
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Prev/Next Navigation Buttons at the bottom of Content Card -->
                    <div class="border-t border-slate-100 pt-6 flex items-center justify-between gap-4">
                        <button
                            @click="prevTab()"
                            class="px-4 py-2 bg-slate-50 hover:bg-slate-100 text-slate-600 text-xs font-bold rounded-lg transition"
                            x-show="tabs.indexOf(activeTab) > 0"
                        >
                            {{ __('← Kembali') }}
                        </button>
                        <div x-show="tabs.indexOf(activeTab) === 0"></div>

                        <button
                            @click="nextTab()"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-lg transition shadow-xs"
                            x-show="tabs.indexOf(activeTab) < tabs.length - 1"
                        >
                            {{ __('Lanjutkan →') }}
                        </button>
                        <div x-show="tabs.indexOf(activeTab) === tabs.length - 1"></div>
                    </div>

                </div>
            </div>
        </div>

        @include('courses.partials.quiz-card')
    @elseif($chapter->order == 6)
        <!-- Custom Layout for Chapter 6 showing all catalogs as accordions directly -->
        <div class="py-6 select-none" x-data="{
            modules: @js($modules->values()),
            expandedModuleId: null,
            completeUrlTemplate: @js(route('courses.modules.complete', [$course->id, $chapter->id, '__MODULE__'])),
            csrfToken: @js(csrf_token()),

            toggleModule(id) {
                this.expandedModuleId = this.expandedModuleId === id ? null : id;
                if (this.expandedModuleId === id) {
                    this.markModuleComplete(id);
                }
            },

            markModuleComplete(moduleId) {
                if (!moduleId) return;
                fetch(this.completeUrlTemplate.replace('__MODULE__', moduleId), {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': this.csrfToken,
                        'Accept': 'application/json',
                    },
                });
            }
        }">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

                <!-- Navigation Back & Title Bar -->
                <div class="flex items-center justify-between">
                    <a href="{{ route('courses.show', $course->id) }}" class="inline-flex items-center text-xs font-bold text-gray-500 hover:text-blue-600 transition">
                        &larr; {{ __('Kembali ke Silabus Kursus') }}
                    </a>

                    <div class="flex items-center gap-2">
                        @if(auth()->user()->isInstruktur())
                            <a href="{{ route('modules.create', [$course->id, $chapter->id]) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg text-xs transition shadow-sm">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                </svg>
                                {{ __('Tambah Modul Baru') }}
                            </a>
                        @endif

                        <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-[9px] font-bold text-blue-600 border border-blue-100 uppercase tracking-wider">
                            {{ __('Bab') }} {{ $chapter->order }} {{ __('dari') }} {{ $chapters->count() }}
                        </span>
                    </div>
                </div>

                <!-- Chapter Header Description Card -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-800 text-base">
                        {{ str_replace("BAB {$chapter->order}: ", "", $chapter->title) }}
                    </h3>
                    <p class="text-sm text-gray-500 mt-1.5 leading-relaxed">
                        {{ __('Halaman ini berisi katalog suku cadang dan komponen Garbarata dalam format PDF. Klik pada masing-masing judul katalog di bawah ini untuk membuka dokumen PDF terkait.') }}
                    </p>
                </div>

                <!-- List of Catalogs Accordions directly -->
                <div class="space-y-3">
                    <template x-for="(module, index) in modules" :key="module.id">
                        <div class="rounded-xl border border-gray-200 bg-white shadow-sm overflow-hidden">
                            <button
                                type="button"
                                @click="toggleModule(module.id)"
                                class="w-full flex items-center justify-between gap-3 cursor-pointer select-none px-5 py-4 bg-gradient-to-r from-slate-50 to-white hover:from-blue-50 hover:to-white transition-colors duration-200"
                            >
                                <div class="flex items-center gap-3">
                                    <span class="flex-shrink-0 w-7 h-7 rounded-full bg-blue-600 text-white text-[11px] font-bold flex items-center justify-center shadow-sm" x-text="index + 1"></span>
                                    <span class="font-semibold text-slate-800 text-base text-left" x-text="module.title"></span>
                                </div>
                                <svg class="w-4 h-4 text-slate-400 transition-transform duration-300 flex-shrink-0" :class="expandedModuleId === module.id ? 'rotate-180' : ''" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <div x-show="expandedModuleId === module.id" class="border-t border-slate-100">
                                <div class="px-5 py-4 bg-slate-50/50 space-y-4">
                                    <div class="text-sm text-slate-600 leading-relaxed max-w-none prose prose-slate prose-sm animate-fade-in" x-html="module.content"></div>
                                    
                                    <!-- Action Buttons for Instructor inside Accordion -->
                                    @if(auth()->user()->isInstruktur())
                                        <div class="flex items-center gap-2 pt-4 border-t border-slate-200">
                                            <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + module.id + '/edit'" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-xs font-bold transition shadow-xs">
                                                {{ __('Edit Katalog Ini') }}
                                            </a>
                                            <form :action="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + module.id" method="POST" onsubmit="return confirm('{{ __('Apakah Anda yakin ingin menghapus katalog ini?') }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-xs font-bold transition shadow-xs">
                                                    {{ __('Hapus Katalog') }}
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

            </div>
        </div>

        @include('courses.partials.quiz-card')
    @elseif($chapter->order == 7)
        <!-- Custom Blueprint/Electrical Diagram Layout for Chapter 7 -->
        <div class="py-6 select-none" x-data="{
            modules: @js($modules->values()),
            activeModuleId: {{ $modules->first() ? $modules->first()->id : 'null' }},
            completeUrlTemplate: @js(route('courses.modules.complete', [$course->id, $chapter->id, '__MODULE__'])),
            csrfToken: @js(csrf_token()),
            zoom: 100,

            init() {
                this.markModuleComplete(this.activeModuleId);
            },

            setActiveModule(moduleId) {
                this.activeModuleId = moduleId;
                this.markModuleComplete(moduleId);
            },

            markModuleComplete(moduleId) {
                if (!moduleId) {
                    return;
                }

                fetch(this.completeUrlTemplate.replace('__MODULE__', moduleId), {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': this.csrfToken,
                        'Accept': 'application/json',
                    },
                });
            },

            getActiveModule() {
                return this.modules.find(m => m.id == this.activeModuleId) || { title: '', content: '', image_path: null };
            },

            zoomIn() {
                if (this.zoom < 200) this.zoom += 25;
            },

            zoomOut() {
                if (this.zoom > 50) this.zoom -= 25;
            },

            resetZoom() {
                this.zoom = 100;
            },

            nextModule() {
                const index = this.modules.findIndex(m => m.id == this.activeModuleId);
                if (index !== -1 && index < this.modules.length - 1) {
                    this.setActiveModule(this.modules[index + 1].id);
                }
            },

            prevModule() {
                const index = this.modules.findIndex(m => m.id == this.activeModuleId);
                if (index > 0) {
                    this.setActiveModule(this.modules[index - 1].id);
                }
            },

            isFirst() {
                return this.modules.findIndex(m => m.id == this.activeModuleId) === 0;
            },

            isLast() {
                return this.modules.findIndex(m => m.id == this.activeModuleId) === this.modules.length - 1;
            }
        }">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <!-- Navigation Back & Title Bar -->
                <div class="flex items-center justify-between">
                    <a href="{{ route('courses.show', $course->id) }}" class="inline-flex items-center text-xs font-bold text-gray-500 hover:text-blue-600 transition">
                        &larr; {{ __('Kembali ke Silabus Kursus') }}
                    </a>

                    <div class="flex items-center gap-2">
                        @if(auth()->user()->isInstruktur())
                            <a href="{{ route('modules.create', [$course->id, $chapter->id]) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg text-xs transition shadow-sm">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                </svg>
                                {{ __('Tambah Modul Baru') }}
                            </a>
                        @endif

                        <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-[9px] font-bold text-blue-600 border border-blue-100 uppercase tracking-wider">
                            {{ __('Bab') }} {{ $chapter->order }} {{ __('dari') }} {{ $chapters->count() }}
                        </span>
                    </div>
                </div>

                <!-- Chapter Header Description Card -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <div class="flex items-center space-x-3 border-b border-gray-100 pb-3 mb-3">
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-blue-200 bg-white text-sm font-bold text-blue-600 shadow-sm">07</span>
                        <h3 class="font-extrabold text-base text-slate-800 uppercase tracking-wider">
                            {{ str_replace("BAB {$chapter->order}: ", "", $chapter->title) }}
                        </h3>
                    </div>
                    <p class="text-sm text-slate-500 leading-relaxed">
                        {{ __('Halaman ini merupakan penampil lampiran gambar elektrikal (wiring diagram). Gunakan menu navigasi di bawah untuk memilih lembar gambar, dan gunakan kontrol zoom untuk memperbesar gambar agar diagram terbaca lebih jelas.') }}
                    </p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                    <!-- Left Sidebar - List of Drawings -->
                    <div class="lg:col-span-1 bg-white p-4 rounded-2xl border border-gray-100 shadow-sm flex flex-col gap-3">
                        <span class="text-xs font-extrabold text-slate-400 uppercase tracking-wide px-1">{{ __('Daftar Lembar Gambar') }}</span>
                        <div class="flex flex-col gap-1 max-h-[500px] overflow-y-auto pr-1">
                            <template x-for="(module, index) in modules" :key="module.id">
                                <button
                                    @click="setActiveModule(module.id); resetZoom()"
                                    class="w-full px-3 py-2.5 rounded-xl text-sm font-bold transition text-left flex items-start gap-2.5 border"
                                    :class="activeModuleId == module.id ? 'bg-blue-600 text-white border-blue-600 shadow-sm' : 'bg-slate-50 text-slate-600 hover:bg-slate-100 hover:text-slate-800 border-transparent'"
                                >
                                    <span class="flex-shrink-0 w-5 h-5 rounded-full bg-black/10 flex items-center justify-center text-[10px]" :class="activeModuleId == module.id ? 'bg-white/20 text-white' : 'text-slate-500'" x-text="index + 1"></span>
                                    <span class="leading-tight pt-0.5" x-text="module.title"></span>
                                </button>
                            </template>
                        </div>
                    </div>

                    <!-- Right Main Content Area - Blueprint Viewer -->
                    <div class="lg:col-span-3 space-y-4">
                        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm flex flex-col overflow-hidden min-h-[600px]">
                            <!-- Toolbar -->
                            <div class="bg-slate-50 border-b border-gray-150 px-4 py-3 flex flex-wrap items-center justify-between gap-3 text-slate-800">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-bold text-slate-800" x-text="getActiveModule().title"></span>
                                </div>
                                <div class="flex items-center gap-1 bg-white border border-gray-200 rounded-lg p-0.5">
                                    <button @click="zoomOut()" class="p-1.5 text-slate-500 hover:text-slate-800 transition hover:bg-slate-100 rounded-md cursor-pointer" title="{{ __('Zoom Out') }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15"/>
                                        </svg>
                                    </button>
                                    <span class="text-[10px] font-mono px-2 text-slate-600 w-12 text-center" x-text="zoom + '%'"></span>
                                    <button @click="zoomIn()" class="p-1.5 text-slate-500 hover:text-slate-800 transition hover:bg-slate-100 rounded-md cursor-pointer" title="{{ __('Zoom In') }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                        </svg>
                                    </button>
                                    <button @click="resetZoom()" class="p-1.5 text-slate-500 hover:text-slate-800 transition hover:bg-slate-100 rounded-md border-l border-gray-200 cursor-pointer" title="{{ __('Reset Zoom') }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 9V4.5M9 9H4.5M9 9L3 3m12 9V4.5m0 4.5H19.5M15 9l6-6M9 15v4.5M9 15H4.5M9 15l-6 6m12-6v4.5m0-4.5H19.5m-4.5 0l6 6"/>
                                        </svg>
                                    </button>
                                </div>
                                <div>
                                    <a :href="'/' + getActiveModule().image_path" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white hover:bg-slate-50 transition text-slate-600 hover:text-slate-800 font-bold rounded-lg text-[10px] border border-gray-200 shadow-2xs">
                                        {{ __('Buka Gambar Penuh') }}
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>

                            <!-- Image Container -->
                            <div class="flex-grow bg-slate-50/50 p-4 flex items-center justify-center overflow-auto relative select-none border-b border-gray-150" style="height: 550px;">
                                <template x-if="getActiveModule().image_path">
                                    <div class="transition-all duration-200 ease-out origin-center" :style="'width: ' + zoom + '%; max-width: none;'">
                                        <img :src="'/' + getActiveModule().image_path" class="w-full h-auto object-contain rounded shadow-md border border-gray-200 bg-white" :alt="getActiveModule().title" draggable="false">
                                    </div>
                                </template>
                                <template x-if="!getActiveModule().image_path">
                                    <div class="text-center text-slate-500">
                                        <svg class="w-12 h-12 mx-auto mb-2 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375 3.75 0 11-.75 0 .375 3.75 0 01.75 0z"/>
                                        </svg>
                                        <span class="text-sm font-semibold text-slate-400">{{ __('Gambar tidak ditemukan') }}</span>
                                    </div>
                                </template>
                            </div>

                            <!-- Description/Content (if any) -->
                            <div class="bg-white p-4" x-show="getActiveModule().content">
                                <div class="text-slate-600 text-sm leading-relaxed max-w-none prose prose-slate prose-sm" x-html="getActiveModule().content"></div>
                            </div>

                            @if(auth()->user()->isInstruktur())
                                <template x-if="activeModuleId">
                                    <div class="bg-slate-50 border-t border-gray-100 p-4 flex gap-2 rounded-b-2xl">
                                        <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + activeModuleId + '/edit'" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-xs font-bold transition shadow-xs">
                                            {{ __('Edit Lembar Gambar') }}
                                        </a>
                                        <form :action="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + activeModuleId" method="POST" onsubmit="return confirm('{{ __('Apakah Anda yakin ingin menghapus lembar gambar ini?') }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-xs font-bold transition shadow-xs">
                                                {{ __('Hapus Lembar Gambar') }}
                                            </button>
                                        </form>
                                    </div>
                                </template>
                            @endif
                        </div>

                        <!-- Footer Navigation -->
                        <div class="bg-white rounded-2xl border border-gray-100 p-4 shadow-sm flex items-center justify-between">
                            <button
                                @click="prevModule(); resetZoom()"
                                :disabled="isFirst()"
                                class="inline-flex items-center justify-center rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-bold text-slate-600 transition hover:bg-slate-50 disabled:opacity-50 disabled:cursor-not-allowed shadow-2xs"
                            >
                                {{ __('← Kembali') }}
                            </button>

                            <button
                                @click="nextModule(); resetZoom()"
                                :disabled="isLast()"
                                class="inline-flex items-center justify-center rounded-lg bg-slate-900 px-3.5 py-1.5 text-xs font-bold text-white transition hover:bg-slate-800 disabled:opacity-50 disabled:cursor-not-allowed shadow-2xs"
                            >
                                {{ __('Lanjutkan →') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Standard Layout for other chapters -->
        <div class="py-6 select-none" x-data="studyPage(@js($modules->values()), @js(route('courses.modules.complete', [$course->id, $chapter->id, '__MODULE__'])))">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

                <!-- Navigation Back & Title Bar -->
                <div class="flex items-center justify-between">
                    <a href="{{ route('courses.show', $course->id) }}" class="inline-flex items-center text-xs font-bold text-gray-500 hover:text-blue-600 transition">
                        &larr; {{ __('Kembali ke Silabus Kursus') }}
                    </a>

                    <div class="flex items-center gap-2">
                        @if(auth()->user()->isInstruktur())
                            <a href="{{ route('modules.create', [$course->id, $chapter->id]) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg text-xs transition shadow-sm">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                </svg>
                                {{ __('Tambah Modul Baru') }}
                            </a>
                        @endif

                        <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-[9px] font-bold text-blue-600 border border-blue-100 uppercase tracking-wider">
                            {{ __('Bab') }} {{ $chapter->order }} {{ __('dari') }} {{ $chapters->count() }}
                        </span>
                    </div>
                </div>

                <!-- Chapter Header Description Card -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-800 text-base">
                        {{ str_replace("BAB {$chapter->order}: ", "", $chapter->title) }}
                    </h3>
                    <p class="text-sm text-gray-500 mt-1.5 leading-relaxed">
                        @if($diagram)
                            {{ __('Materi pembelajaran interaktif dilengkapi visualisasi skematis. Klik pada titik-titik biru bernomor (hotspots) pada gambar atau pilih daftar sub-bab di bawah untuk membaca detail spesifikasi.') }}
                        @else
                            {{ __('Materi modul pembelajaran tertulis. Gunakan menu navigasi di panel sebelah kiri untuk berpindah antar topik sub-bab.') }}
                        @endif
                    </p>
                </div>

                <!-- Main study room layout (Stacked, clean, and full width) -->
                <div class="space-y-6">
                    
                    <!-- 1. Top horizontal Sub-Chapter Navigation Bar -->
                    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-3">
                        <div class="flex items-center space-x-2 shrink-0">
                            <span class="text-sm font-bold text-slate-700 uppercase tracking-wide">{{ __('Pilih Topik Sub-Bab:') }}</span>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <template x-for="module in modules" :key="module.id">
                                <button
                                    @click="setActiveModule(module.id)"
                                    class="px-4 py-2.5 rounded-lg text-sm font-bold transition text-left"
                                    :class="activeModuleId === module.id ? 'bg-blue-600 text-white shadow-sm' : 'bg-slate-50 text-slate-600 hover:bg-slate-100 hover:text-slate-800'"
                                >
                                    <span x-text="module.title"></span>
                                </button>
                            </template>
                        </div>
                    </div>

                    <!-- 2. Interactive Diagram (if exists) -->
                    @if($diagram)
                        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 max-w-4xl mx-auto w-full">
                            <div class="relative bg-[#eef3f8] rounded-xl overflow-hidden aspect-[1755/896] w-full border border-[#dce4ec] flex items-center justify-center shadow-inner">
                                
                                @if($diagram->image_path && file_exists(public_path($diagram->image_path)))
                                    <img src="{{ asset($diagram->image_path) }}" class="w-full h-full object-contain select-none" alt="Diagram {{ $chapter->title }}">
                                @else
                                    <!-- Dynamic Fallback SVG Schematic based on Chapter Order -->
                                    <div class="absolute inset-0 flex flex-col items-center justify-center p-8 select-none">
                                        @if($chapter->order == 7)
                                            <!-- Electrical Panel Fallback Schematic -->
                                            <svg class="w-full h-full max-h-[260px] opacity-[0.06] text-[#0091ff]" viewBox="0 0 800 400" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                                                <rect x="50" y="50" width="700" height="300" rx="10" stroke-dasharray="5" />
                                                <path d="M100 200 L200 200 M250 200 L350 200 M400 200 L550 200 M600 200 L700 200" />
                                                <rect x="200" y="170" width="50" height="60" rx="4" />
                                                <rect x="350" y="170" width="50" height="60" rx="4" />
                                                <rect x="550" y="150" width="50" height="100" rx="5" />
                                                <line x1="575" y1="150" x2="575" y2="100" />
                                                <path d="M100 280 L700 280 M150 280 L150 320 M150 320 L170 320" />
                                                <circle cx="575" cy="200" r="10" />
                                            </svg>
                                            <span class="absolute text-base font-bold text-slate-500 tracking-wide text-center">
                                                {{ __('Skema Rangkaian Elektrik') }}<br>
                                                <span class="text-sm font-normal text-slate-400 mt-1 block">{{ __('(Gambar Rangkaian Kontrol Daya 380V)') }}</span>
                                            </span>
                                        @else
                                            <!-- Standard Boarding Bridge Silhouette Fallback -->
                                            <svg class="w-full h-full max-h-[260px] opacity-[0.06] text-[#0091ff]" viewBox="0 0 800 400" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                                                <line x1="50" y1="360" x2="750" y2="360" stroke-dasharray="5 5" />
                                                <path d="M50 150 L50 250 M50 180 L110 180 L110 220 L50 220" stroke-dasharray="4" />
                                                <circle cx="150" cy="200" r="35" fill="currentColor" fill-opacity="0.03" />
                                                <circle cx="150" cy="200" r="10" />
                                                <rect x="185" y="175" width="160" height="50" rx="6" />
                                                <rect x="345" y="180" width="150" height="40" rx="6" />
                                                <line x1="495" y1="220" x2="495" y2="320" stroke-width="5" />
                                                <line x1="460" y1="320" x2="530" y2="320" stroke-width="8" />
                                                <circle cx="475" cy="340" r="18" />
                                                <circle cx="515" cy="340" r="18" />
                                                <path d="M495 200 L590 200 L630 170 L630 270 L590 240 Z" />
                                            </svg>
                                            <span class="absolute text-base font-bold text-slate-500 tracking-wide text-center">
                                                Gambar 3D Garbarata<br>
                                                <span class="text-sm font-normal text-slate-400 mt-1 block">(Siluet Jembatan Penumpang)</span>
                                            </span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- 3. Full-Width Content Reader Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between min-h-[250px] w-full">
                        
                        <!-- Article Content Area -->
                        <div class="p-6 md:p-8 space-y-6">
                            <!-- Topic Badge & Nav Bar -->
                            <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                                <span class="rounded-full bg-slate-100 px-2.5 py-0.5 text-[9px] font-bold text-slate-500 uppercase tracking-wider">
                                    Materi Pembelajaran
                                </span>
                                
                                <span class="text-[10px] text-gray-400 font-semibold">
                                    Mode Belajar Mandiri (Lebar Penuh)
                                </span>
                            </div>

                            <!-- Title and HTML Content -->
                            <div class="space-y-4">
                                <h2 class="text-lg font-bold text-slate-800 leading-snug" x-text="getActiveModule().title">
                                    Memuat materi...
                                </h2>

                                <template x-if="getActiveModule().image_path">
                                    <div class="rounded-xl border border-gray-200 bg-gray-50 p-3 shadow-sm my-3 max-w-2xl mx-auto">
                                        <img :src="'/' + getActiveModule().image_path" class="w-full max-h-72 object-contain rounded-lg select-none" :alt="getActiveModule().title">
                                    </div>
                                </template>

                                <!-- Active Module Content body (rendered with HTML) -->
                                <div class="text-sm text-slate-600 leading-relaxed space-y-3.5 prose prose-slate max-w-none prose-sm" x-html="renderModuleContent(getActiveModule().content)">
                                    Memuat isi modul pembelajaran...
                                </div>

                                @if(auth()->user()->isInstruktur())
                                    <template x-if="activeModuleId">
                                        <div class="flex items-center gap-2 pt-4 border-t border-slate-100">
                                            <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + activeModuleId + '/edit'" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-xs font-bold transition shadow-xs">
                                                Edit Modul Ini
                                            </a>
                                            <form :action="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + activeModuleId" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus modul ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-xs font-bold transition shadow-xs">
                                                    Hapus Modul
                                                </button>
                                            </form>
                                        </div>
                                    </template>
                                @endif
                            </div>
                        </div>

                        <!-- Footer Navigation inside Card -->
                        <div class="border-t border-gray-100 p-4 bg-gray-50/50 flex items-center justify-between rounded-b-2xl">
                            <button
                                @click="prevModule()"
                                :disabled="isFirst()"
                                class="inline-flex items-center justify-center rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-bold text-slate-600 transition hover:bg-slate-50 disabled:opacity-50 disabled:cursor-not-allowed shadow-2xs"
                            >
                                ← Sebelumnya
                            </button>
                            
                            <button
                                @click="nextModule()"
                                :disabled="isLast()"
                                class="inline-flex items-center justify-center rounded-lg bg-slate-900 px-3.5 py-1.5 text-xs font-bold text-white transition hover:bg-slate-800 disabled:opacity-50 disabled:cursor-not-allowed shadow-2xs"
                            >
                                Selanjutnya →
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        @include('courses.partials.quiz-card')
    @endif

    @php
        $nextChapter = $chapters->where('order', '>', $chapter->order)->first();
    @endphp

    @if($chapter->order == 1)
        {{-- Auto-complete scroll script ONLY for Chapter 1 --}}
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const modules = @js($modules->pluck('id')->toArray());
                const completeUrlTemplate = @js(route('courses.modules.complete', [$course->id, $chapter->id, '__MODULE__']));
                const csrfToken = @js(csrf_token());

                let completed = new Set();
                let hasQuiz = @js($chapterQuiz ? true : false);
                let isQuizPassed = @js($chapterQuizAttempt?->is_passed ? true : false);

                function markModuleComplete(moduleId) {
                    if (!moduleId || isNaN(moduleId)) return;
                    const idNum = Number(moduleId);
                    if (completed.has(idNum)) return;
                    completed.add(idNum);

                    fetch(completeUrlTemplate.replace('__MODULE__', idNum), {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                        },
                    });
                }

                function unlockNextChapter() {
                    if (!hasQuiz || isQuizPassed) {
                        const descEl = document.getElementById('next-chapter-desc');
                        const actionEl = document.getElementById('next-chapter-action');
                        if (descEl) {
                            descEl.innerText = @js(__('Hebat! Anda telah menyelesaikan seluruh materi dan quiz pada bab ini. Silakan lanjut ke bab berikutnya.'));
                        }
                        if (actionEl) {
                            @if($nextChapter)
                            actionEl.innerHTML = `
                                <a href="{{ route('courses.chapters.show', [$course->id, $nextChapter->id]) }}"
                                   class="inline-flex items-center justify-center gap-2 px-5 py-3 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-md hover:shadow-lg transition-all duration-150 whitespace-nowrap">
                                    {{ __('Lanjut ke Bab') }} {{ $nextChapter->order }} &rarr;
                                </a>
                            `;
                            @endif
                        }
                    }
                }

                function handleBottomReached() {
                    // Safeguard: only trigger if user has actually scrolled down from top (scrollY > 50)
                    // to prevent the IntersectionObserver initial run from auto-completing on page load.
                    if (window.scrollY < 50) return;

                    modules.forEach(id => {
                        markModuleComplete(id);
                    });
                    unlockNextChapter();
                }

                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            handleBottomReached();
                        }
                    });
                }, {
                    root: null,
                    threshold: 0.1
                });

                const target = document.getElementById('next-chapter-desc');
                if (target) {
                    observer.observe(target);
                }

                window.addEventListener('scroll', function() {
                    if ((window.innerHeight + window.scrollY) >= document.documentElement.scrollHeight - 150) {
                        handleBottomReached();
                    }
                });
            });
        </script>
    @endif

    {{-- Global progress listener and dynamic unlocker for all chapters --}}
    <script>
        (function() {
            // Set up fetch interceptor immediately to catch any initial load requests from Alpine init()
            const originalFetch = window.fetch;
            window.fetch = function (input, init) {
                const url = typeof input === 'string' ? input : (input instanceof URL ? input.href : (input && input.url ? input.url : ''));
                const match = url.match(/\/courses\/\d+\/chapters\/\d+\/modules\/(\d+)\/complete/);
                if (match && match[1]) {
                    const moduleId = Number(match[1]);
                    if (window.registerModuleCompletion) {
                        window.registerModuleCompletion(moduleId);
                    } else {
                        if (!window.pendingModuleCompletions) {
                            window.pendingModuleCompletions = [];
                        }
                        window.pendingModuleCompletions.push(moduleId);
                    }
                }
                return originalFetch.apply(this, arguments);
            };
        })();

        document.addEventListener('DOMContentLoaded', function () {
            const totalModuleIds = @js($modules->pluck('id')->toArray());
            let completedModuleIds = new Set(@js($learningProgress ? $learningProgress['completedModules']->intersect($modules->pluck('id'))->toArray() : []));
            const hasQuiz = @js($chapterQuiz ? true : false);
            const isQuizPassed = @js($chapterQuizAttempt?->is_passed ? true : false);

            function checkAndUnlockNextChapter() {
                const allCompleted = totalModuleIds.every(id => completedModuleIds.has(id));
                if (allCompleted) {
                    if (!hasQuiz || isQuizPassed) {
                        const descEl = document.getElementById('next-chapter-desc');
                        const actionEl = document.getElementById('next-chapter-action');
                        if (descEl) {
                            descEl.innerText = @js(__('Hebat! Anda telah menyelesaikan seluruh materi dan quiz pada bab ini. Silakan lanjut ke bab berikutnya.'));
                        }
                        if (actionEl) {
                            @if($nextChapter)
                            actionEl.innerHTML = `
                                <a href="{{ route('courses.chapters.show', [$course->id, $nextChapter->id]) }}"
                                   class="inline-flex items-center justify-center gap-2 px-5 py-3 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-md hover:shadow-lg transition-all duration-150 whitespace-nowrap">
                                    {{ __('Lanjut ke Bab') }} {{ $nextChapter->order }} &rarr;
                                </a>
                            `;
                            @endif
                        }
                    }
                }
            }

            // Register completion helper
            window.registerModuleCompletion = function (moduleId) {
                if (!moduleId || isNaN(moduleId)) return;
                completedModuleIds.add(Number(moduleId));
                checkAndUnlockNextChapter();
            };

            window.markModuleCompleteDirectly = function (moduleId) {
                if (!moduleId || isNaN(moduleId)) return;
                const idNum = Number(moduleId);
                
                const completeUrlTemplate = @js(route('courses.modules.complete', [$course->id, $chapter->id, '__MODULE__']));
                const csrfToken = @js(csrf_token());

                fetch(completeUrlTemplate.replace('__MODULE__', idNum), {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                }).then(res => {
                    if (res.ok) {
                        window.registerModuleCompletion(idNum);
                    }
                });
            };

            window.setupDetailsTracker = function (moduleId, containerId) {
                if (!moduleId) return;
                const container = document.getElementById(containerId);
                if (!container) return;

                setTimeout(() => {
                    const detailsElements = container.querySelectorAll('details');
                    if (detailsElements.length === 0) {
                        window.markModuleCompleteDirectly(moduleId);
                        return;
                    }

                    let openedIds = new Set();
                    detailsElements.forEach((details, index) => {
                        const id = details.id || `details-${moduleId}-${index}`;
                        details.id = id;

                        if (details.open) {
                            openedIds.add(id);
                        }

                        details.addEventListener('toggle', function onToggle() {
                            if (details.open) {
                                openedIds.add(id);
                                if (openedIds.size === detailsElements.length) {
                                    window.markModuleCompleteDirectly(moduleId);
                                }
                            }
                        });
                    });
                }, 150);
            };

            // Process any completions that happened before DOMContentLoaded
            if (window.pendingModuleCompletions) {
                window.pendingModuleCompletions.forEach(id => {
                    window.registerModuleCompletion(id);
                });
                delete window.pendingModuleCompletions;
            }

            // Run initial check on load
            checkAndUnlockNextChapter();
        });
    </script>
</x-app-layout>
