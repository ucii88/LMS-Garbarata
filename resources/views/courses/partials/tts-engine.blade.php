{{-- ========================================================= --}}
{{-- GLOBAL TTS ENGINE (Web Speech API) — Semua bab teks (kecuali Bab 6 PDF & Bab 7 Skema) --}}
{{-- ========================================================= --}}
@if($chapter->order != 6 && $chapter->order != 7)
<style>
        /* Highlight paragraf yang sedang dibacakan TTS */
    .tts-paragraph-highlight {
        background-color: #fef9c3 !important; /* amber/yellow-100 */
        border-left: 4px solid #2563eb !important; /* blue-600 LMS Garbarata indicator bar */
        padding-left: 0.75rem !important;
        padding-top: 0.375rem !important;
        padding-bottom: 0.375rem !important;
        border-radius: 0.375rem !important;
        transition: all 0.25s ease-in-out !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05) !important;
    }

    /* TTS Audio Bar Container */
    .tts-controls-group {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: transparent;
    }

    /* Dropdown Kecepatan */
    .tts-speed-select {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background: #ffffff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%230f172a' stroke-width='2.5'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E") no-repeat right 8px center;
        background-size: 11px;
        padding: 5px 24px 5px 10px;
        border: 1.5px solid #cbd5e1;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 700;
        color: #0f172a;
        cursor: pointer;
        outline: none;
        transition: all 0.15s ease;
        line-height: 1.2;
        height: 34px;
    }
    .tts-speed-select:hover {
        border-color: #94a3b8;
        background-color: #f8fafc;
    }

    .tts-divider {
        width: 1px;
        height: 22px;
        background-color: #e2e8f0;
        margin: 0 4px;
    }

    /* Tombol Kontrol Persegi (Icon Only) */
    .tts-ctrl-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        border-radius: 8px;
        border: 1.5px solid #cbd5e1;
        background: #ffffff;
        color: #0f172a;
        cursor: pointer;
        transition: all 0.15s ease;
        user-select: none;
        padding: 0;
        flex-shrink: 0;
    }
    .tts-ctrl-btn:hover {
        background: #f1f5f9;
        border-color: #94a3b8;
    }

    /* Tombol Play/Pause Utama (Biru LMS Garbarata blue-600) */
    .tts-play-btn {
        background: #2563eb !important; /* blue-600 */
        border-color: #1d4ed8 !important; /* blue-700 */
        color: #ffffff !important;
    }
    .tts-play-btn:hover {
        background: #1d4ed8 !important; /* blue-700 */
        border-color: #1e40af !important;
    }
    .tts-play-btn-playing {
        background: #1d4ed8 !important;
        border-color: #1e40af !important;
    }
    .tts-play-btn svg,
    .tts-play-btn svg path,
    .tts-play-btn svg rect {
        fill: #ffffff !important;
        color: #ffffff !important;
    }

    @keyframes tts-pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }
</style>
<script>
    window.LmsTTS = (function () {
        const synth = window.speechSynthesis;
        let currentId          = null;   
        let currentUtt         = null;  
        let isPaused           = false;
        let currentRate        = 1.0;    
        let currentParagraphs  = [];    
        let currentIndex       = 0;      
        let currentCharIndex   = 0;      

        const SVG_PLAY = `<svg class="w-4 h-4 ml-0.5" fill="#ffffff" viewBox="0 0 24 24"><path fill="#ffffff" d="M8 5.14v13.72a1 1 0 0 0 1.53.85l11-6.86a1 1 0 0 0 0-1.7l-11-6.86a1 1 0 0 0-1.53.85z"/></svg>`;
        const SVG_PAUSE = `<svg class="w-4 h-4" fill="#ffffff" viewBox="0 0 24 24"><rect x="6" y="5" width="3.5" height="14" rx="1" fill="#ffffff"/><rect x="14.5" y="5" width="3.5" height="14" rx="1" fill="#ffffff"/></svg>`;
        const SVG_STOP = `<svg class="w-3.5 h-3.5 fill-slate-800" viewBox="0 0 24 24"><rect x="5" y="5" width="14" height="14" rx="1.5"/></svg>`;
        const SVG_PREV = `<svg class="w-3.5 h-3.5 fill-slate-800" viewBox="0 0 24 24"><path d="M6 6h2v12H6zm3 6l9 6V6z"/></svg>`;
        const SVG_NEXT = `<svg class="w-3.5 h-3.5 fill-slate-800" viewBox="0 0 24 24"><path d="M6 18l9-6-9-6v12zm10-12h2v12h-2z"/></svg>`;

        
        const ttsI18n = {
            id: {
                listen:   'Dengarkan',
                reading:  'Sedang Dibaca...',
                resume:   'Lanjutkan',
                langCode: 'id-ID',
            },
            en: {
                listen:   'Listen',
                reading:  'Reading...',
                resume:   'Resume',
                langCode: 'en-US',
            }
        };

        function getLocale() {
            const htmlLang = (document.documentElement.lang || 'id').toLowerCase();
            return htmlLang.startsWith('en') ? 'en' : 'id';
        }

        function t(key) {
            return (ttsI18n[getLocale()] || ttsI18n['id'])[key] || ttsI18n['id'][key];
        }

        
        function getParagraphs(containerEl) {
            if (!containerEl) return [];

            const blockSelector = 'p, li, h1, h2, h3, h4, h5, h6, blockquote, td, th, div, section, aside, dt, dd';
            let nodes = Array.from(containerEl.querySelectorAll(blockSelector));

            
            nodes = nodes.filter(el => {
                const txt = (el.innerText || el.textContent || '').trim();
                if (!txt) return false;

                const hasTextBlockChild = Array.from(el.querySelectorAll(blockSelector)).some(child => {
                    return (child.innerText || child.textContent || '').trim().length > 0;
                });

                return !hasTextBlockChild;
            });

            
            if (nodes.length === 0 && containerEl.innerText && containerEl.innerText.trim()) {
                nodes = [containerEl];
            }

            return nodes.map(el => ({
                el: el,
                text: (el.innerText || el.textContent || '').trim()
            })).filter(item => item.text.length > 0);
        }

        
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

        
        function broadcastState(id, state) {
            document.querySelectorAll('[data-tts-id]').forEach(btn => {
                const btnId = btn.getAttribute('data-tts-id');
                const icon = btn.querySelector('.tts-icon') || btn;
                if (btnId === String(id) && state !== 'idle') {
                    if (state === 'playing') {
                        btn.classList.add('tts-play-btn-playing');
                        icon.innerHTML = SVG_PAUSE;
                        btn.title = t('reading') || 'Pause';
                    } else {
                        btn.classList.remove('tts-play-btn-playing');
                        icon.innerHTML = SVG_PLAY;
                        btn.title = t('resume') || 'Resume';
                    }
                } else {
                    btn.classList.remove('tts-play-btn-playing');
                    icon.innerHTML = SVG_PLAY;
                    btn.title = t('listen') || 'Play';
                }
            });

            document.querySelectorAll('.tts-speed-select').forEach(sel => {
                sel.value = currentRate.toString();
            });
        }

       
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

        function cleanTextForSpeech(text) {
            if (!text) return '';

            const romanMap = {
                'viii': '8', 'vii': '7', 'iii': '3', 'vi': '6',
                'iv': '4', 'ix': '9', 'ii': '2', 'v': '5', 'x': '10', 'i': '1'
            };

            
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

       
        function getVoiceForLocale() {
            const voices = synth.getVoices();
            const locale = getLocale();

            if (locale === 'en') {
                return voices.find(v => v.lang === 'en-US') ||
                       voices.find(v => v.lang === 'en-GB') ||
                       voices.find(v => v.lang.startsWith('en')) ||
                       null;
            } else {
                return voices.find(v => v.lang === 'id-ID') ||
                       voices.find(v => v.lang.startsWith('id')) ||
                       null;
            }
        }

        
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

            const locale   = getLocale();
            const langCode = ttsI18n[locale].langCode;

            const utt = new SpeechSynthesisUtterance(textToSpeak);
            utt.lang  = langCode;
            utt.rate  = currentRate;
            utt.pitch = 1;

            const selectedVoice = getVoiceForLocale();
            if (selectedVoice) utt.voice = selectedVoice;

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

        
        function setRate(newRate) {
            currentRate = parseFloat(newRate) || 1.0;
            document.querySelectorAll('.tts-speed-select').forEach(el => {
                el.value = currentRate.toString();
            });

            
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

        
        function togglePause() {
            if (currentId === null) return;
            if (isPaused) {
                isPaused = false;
                broadcastState(currentId, 'playing');
                if (synth.paused) {
                    synth.resume();
                } else {
                    playCurrentParagraph(currentCharIndex);
                }
            } else {
                isPaused = true;
                synth.pause();
                broadcastState(currentId, 'paused');
            }
        }

        return { toggle, stop, togglePause, setRate, cycleRate, getRate: () => currentRate, prevParagraph, nextParagraph, isActive: () => currentId !== null };
    })();

    
    window.ttsToggle = function(moduleId, contentHtml, containerId) {
        window.LmsTTS.toggle(moduleId, contentHtml, containerId || null);
    };


    document.addEventListener('keydown', function(e) {
        const activeEl = document.activeElement;
        if (activeEl && (['INPUT', 'TEXTAREA', 'SELECT'].includes(activeEl.tagName) || activeEl.isContentEditable)) {
            return;
        }

        if (e.key === ' ' || e.code === 'Space') {
            if (window.LmsTTS && window.LmsTTS.isActive()) {
                e.preventDefault();
                window.LmsTTS.togglePause();
            }
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
