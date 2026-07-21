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
        let currentId          = null;   
        let currentUtt         = null;  
        let isPaused           = false;
        let currentRate        = 1.0;    
        let currentParagraphs  = [];    
        let currentIndex       = 0;      
        let currentCharIndex   = 0;      

        const SVG_SPEAKER = `<svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>`;

        const SVG_PAUSE = `<svg class="w-4 h-4 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`;

        const SVG_PLAY = `<svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`;

        
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

        
        function broadcastState(id, state ) {
            document.querySelectorAll('[data-tts-id]').forEach(btn => {
                const btnId = btn.getAttribute('data-tts-id');
                const icon  = btn.querySelector('.tts-icon');
                const label = btn.querySelector('.tts-label');
                if (btnId === String(id) && state !== 'idle') {
                    if (state === 'playing') {
                        btn.className = 'tts-btn tts-btn-playing';
                        if (icon)  icon.innerHTML   = SVG_PAUSE;
                        if (label) label.textContent = t('reading');
                    } else {
                        btn.className = 'tts-btn tts-btn-paused';
                        if (icon)  icon.innerHTML   = SVG_PLAY;
                        if (label) label.textContent = t('resume');
                    }
                } else {
                    btn.className = 'tts-btn tts-btn-idle';
                    if (icon)  icon.innerHTML   = SVG_SPEAKER;
                    if (label) label.textContent = t('listen');
                }
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
            document.querySelectorAll('.tts-speed-val').forEach(el => {
                el.textContent = currentRate + 'x';
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
