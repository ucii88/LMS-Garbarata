@section('topbar_title', $quiz->title . ' — Sedang Dikerjakan')

<x-app-layout>
{{-- Prevent leaving page accidentally --}}
<script>
    window.isSubmittingQuiz = false;
    window.addEventListener('beforeunload', function(e) {
        if (window.isSubmittingQuiz) return;
        e.preventDefault();
        e.returnValue = '';
    });
</script>

{{-- Connection Alert Banner --}}
<div id="connection-banner" class="hidden fixed top-0 left-0 right-0 z-50 px-4 py-2.5 text-center text-xs font-bold transition-all duration-300">
    <span id="connection-banner-text"></span>
</div>

<div class="max-w-4xl mx-auto">
    <form id="quiz-form" action="{{ route('quiz.submit', [$course, $quiz]) }}" method="POST">
        @csrf

        {{-- Sticky Header: Timer + Progress --}}
        <div class="sticky top-0 z-30 bg-white/95 backdrop-blur border-b border-slate-200 px-4 py-3 mb-6 -mx-4 flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="text-sm font-bold text-slate-700">{{ $quiz->title }}</div>
                <span class="text-xs text-slate-400" id="progress-label">
                    Soal <span id="current-q">1</span> / {{ $questions->count() }}
                </span>
            </div>

            {{-- Timer --}}
            @if($quiz->time_limit)
                <div id="timer"
                     class="flex items-center gap-1.5 text-sm font-bold px-3 py-1.5 rounded-xl bg-slate-100 text-slate-700"
                     data-seconds="{{ $timeRemainingSeconds }}">
                    ⏱ <span id="timer-display">{{ gmdate('i:s', $timeRemainingSeconds) }}</span>
                </div>
            @endif

            <button type="button" onclick="confirmSubmit()"
                    class="px-4 py-2 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition">
                Submit Quiz
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

            {{-- Soal-soal --}}
            <div class="lg:col-span-3 space-y-8" id="questions-container">
                @foreach($questions as $i => $question)
                <div class="question-card bg-white border border-slate-100 rounded-2xl shadow-sm p-6 {{ $loop->iteration > 1 ? 'hidden' : '' }}"
                     id="q-card-{{ $loop->iteration }}"
                     data-qnum="{{ $loop->iteration }}">

                    {{-- Header soal --}}
                    <div class="flex items-start justify-between gap-3 mb-4">
                        <div class="flex items-center gap-2">
                            <span class="w-8 h-8 rounded-full bg-blue-600 text-white text-sm font-bold flex items-center justify-center shrink-0">
                                {{ $loop->iteration }}
                            </span>
                            <span class="text-xs font-semibold px-2 py-0.5 rounded-full
                                @switch($question->type)
                                    @case('multiple_choice') bg-indigo-100 text-indigo-700 @break
                                    @case('true_false') bg-green-100 text-green-700 @break
                                    @case('fill_blank') bg-amber-100 text-amber-700 @break
                                    @case('matching') bg-purple-100 text-purple-700 @break
                                    @case('ordering') bg-rose-100 text-rose-700 @break
                                @endswitch">
                                {{ $question->type_label }}
                            </span>
                            <span class="text-xs text-slate-400">
                                @if($question->type === 'matching')
                                    {{ $question->points }} poin per pasangan (Total: {{ $question->options->count() * $question->points }} poin)
                                @elseif($question->type === 'ordering')
                                    {{ $question->points }} poin per langkah (Total: {{ $question->options->count() * $question->points }} poin)
                                @else
                                    {{ $question->points }} poin
                                @endif
                            </span>
                        </div>
                        {{-- Flag soal --}}
                        <button type="button" onclick="toggleFlag({{ $loop->iteration }}, this)"
                                class="text-slate-300 hover:text-amber-400 transition text-xl leading-none"
                                title="Tandai soal">⚑</button>
                    </div>

                    {{-- Teks Soal --}}
                    <p class="text-sm font-medium text-slate-800 leading-relaxed mb-1">
                        {!! nl2br(e($question->question_text)) !!}
                    </p>
                    @if($question->question_image)
                        <img src="{{ Storage::url($question->question_image) }}"
                             class="my-3 max-h-48 rounded-xl border border-slate-200" alt="Gambar soal">
                    @endif

                    {{-- Pilihan Jawaban berdasarkan tipe --}}
                    <div class="mt-4 space-y-2">

                        @if($question->type === 'multiple_choice')
                            @foreach($question->options as $j => $option)
                                <label class="flex items-start gap-3 p-3.5 border-2 border-slate-100 rounded-xl cursor-pointer transition hover:border-blue-300 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
                                    <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option->id }}"
                                           class="mt-0.5 w-4 h-4 text-blue-600"
                                           {{ isset($savedAnswers[$question->id]) && $savedAnswers[$question->id]->selected_option_id == $option->id ? 'checked' : '' }}
                                           onchange="autoSave({{ $question->id }}, {{ $option->id }}, 'radio')">
                                    <span class="text-sm text-slate-700 leading-relaxed">
                                        <span class="font-semibold text-slate-500 mr-1">{{ chr(65 + $j) }}.</span>
                                        {{ $option->option_text }}
                                    </span>
                                </label>
                            @endforeach

                        @elseif($question->type === 'true_false')
                            @foreach($question->options as $option)
                                <label class="flex items-center gap-3 p-3.5 border-2 border-slate-100 rounded-xl cursor-pointer transition hover:border-blue-300 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
                                    <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option->id }}"
                                           class="w-4 h-4 text-blue-600"
                                           {{ isset($savedAnswers[$question->id]) && $savedAnswers[$question->id]->selected_option_id == $option->id ? 'checked' : '' }}
                                           onchange="autoSave({{ $question->id }}, {{ $option->id }}, 'radio')">
                                    <span class="text-sm font-semibold {{ $option->option_text === 'Benar' ? 'text-emerald-600' : 'text-red-500' }}">
                                        {{ $option->option_text === 'Benar' ? '✓ Benar' : '✗ Salah' }}
                                    </span>
                                </label>
                            @endforeach

                        @elseif($question->type === 'fill_blank')
                            <input type="text" name="answers[{{ $question->id }}]"
                                   value="{{ $savedAnswers[$question->id]->text_answer ?? '' }}"
                                   placeholder="Ketik jawaban kamu di sini..."
                                   class="w-full border-2 border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                                   oninput="autoSaveText({{ $question->id }}, this.value)">

                        @elseif($question->type === 'matching')
                            <div class="space-y-3">
                                @php
                                    $savedMatch = isset($savedAnswers[$question->id]) ? ($savedAnswers[$question->id]->order_answer ?? []) : [];
                                    $rightItems = $question->options->pluck('match_label')->filter()->unique()->shuffle();
                                @endphp
                                @foreach($question->options as $option)
                                    <div class="flex flex-col sm:flex-row sm:items-center gap-3 p-3 bg-slate-50/50 rounded-xl border border-slate-100">
                                        <span class="text-sm font-semibold text-slate-700 sm:w-1/2">{{ $option->option_text }}</span>
                                        <span class="text-slate-400 hidden sm:inline">→</span>
                                        <select name="answers[{{ $question->id }}][{{ $option->id }}]" required
                                                onchange="autoSaveText({{ $question->id }}, 'select')"
                                                class="flex-1 border-2 border-slate-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                                            <option value="">-- Pilih Pasangan --</option>
                                            @foreach($rightItems as $itemText)
                                                <option value="{{ $itemText }}"
                                                        {{ isset($savedMatch[$option->id]) && $savedMatch[$option->id] === $itemText ? 'selected' : '' }}>
                                                    {{ $itemText }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endforeach
                            </div>

                        @elseif($question->type === 'ordering')
                            <div class="space-y-3">
                                @php
                                    $savedOrder = isset($savedAnswers[$question->id]) ? ($savedAnswers[$question->id]->order_answer ?? []) : [];
                                    $optionsShuffled = $question->options->shuffle();
                                @endphp
                                @for($stepNum = 1; $stepNum <= $question->options->count(); $stepNum++)
                                    <div class="flex items-center gap-3">
                                        <span class="text-xs font-bold text-slate-500 w-24">Langkah {{ $stepNum }}:</span>
                                        <select name="answers[{{ $question->id }}][]" required
                                                onchange="autoSaveText({{ $question->id }}, 'select')"
                                                class="flex-1 border-2 border-slate-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                                            <option value="">-- Pilih Langkah Ke-{{ $stepNum }} --</option>
                                            @foreach($optionsShuffled as $opt)
                                                <option value="{{ $opt->id }}"
                                                        {{ isset($savedOrder[$stepNum - 1]) && $savedOrder[$stepNum - 1] == $opt->id ? 'selected' : '' }}>
                                                    {{ $opt->option_text }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endfor
                            </div>
                        @endif

                    </div>
                    
                    {{-- Navigasi Sebelumnya & Selanjutnya di bawah setiap soal --}}
                    <div class="flex items-center justify-between gap-4 mt-8 pt-5 border-t border-slate-100">
                        @if($loop->iteration > 1)
                            <button type="button" onclick="jumpTo({{ $loop->iteration - 1 }})"
                                    class="px-4 py-2 text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition">
                                ← Sebelumnya
                            </button>
                        @else
                            <div></div>
                        @endif

                        @if($loop->iteration < $questions->count())
                            <button type="button" onclick="jumpTo({{ $loop->iteration + 1 }})"
                                    class="px-5 py-2.5 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition">
                                Selanjutnya →
                            </button>
                        @else
                            <button type="button" onclick="confirmSubmit()"
                                    class="px-5 py-2.5 text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl transition">
                                Selesai & Kirim
                            </button>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Sidebar: Navigasi Soal --}}
            <div class="lg:col-span-1">
                <div class="sticky top-24 bg-white border border-slate-100 rounded-2xl shadow-sm p-4 space-y-4">
                    <h3 class="text-xs font-bold text-slate-700">Navigasi Soal</h3>
                    <div class="grid grid-cols-5 lg:grid-cols-4 gap-1.5" id="nav-grid">
                        @foreach($questions as $i => $question)
                            <button type="button" onclick="jumpTo({{ $loop->iteration }})"
                                    id="nav-{{ $loop->iteration }}"
                                    class="nav-btn w-8 h-8 text-xs font-bold rounded-lg border-2 border-slate-200 text-slate-500 hover:border-blue-400 transition">
                                {{ $loop->iteration }}
                            </button>
                        @endforeach
                    </div>
                    <div class="space-y-1.5 text-xs text-slate-500 border-t border-slate-100 pt-3">
                        <div class="flex items-center gap-2">
                            <div class="w-4.5 h-4.5 rounded bg-slate-500 shrink-0"></div>
                            <span>Sudah dijawab (Abu-abu)</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-4.5 h-4.5 rounded bg-amber-500 shrink-0"></div>
                            <span>Ragu-ragu / Ditandai (Oranye)</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-4.5 h-4.5 rounded bg-white border-2 border-slate-200 shrink-0"></div>
                            <span>Belum dijawab (Putih)</span>
                        </div>
                    </div>
                    <button type="button" onclick="confirmSubmit()"
                            class="w-full py-2.5 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition">
                        Submit Quiz
                    </button>
                </div>
            </div>

        </div>
    </form>
</div>

{{-- Confirm Submit Modal --}}
<div id="confirm-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
    <div class="bg-white rounded-2xl shadow-2xl p-6 max-w-sm w-full mx-4">
        <div class="text-center mb-4">
            <h3 class="text-base font-bold text-slate-800">Yakin submit quiz?</h3>
            <p class="text-sm text-slate-500 mt-1" id="unanswered-msg"></p>
        </div>
        <div class="flex gap-3">
            <button onclick="document.getElementById('confirm-modal').classList.add('hidden')"
                    class="flex-1 py-2.5 text-sm font-semibold text-slate-600 border border-slate-200 rounded-xl hover:bg-slate-50">
                Kembali
            </button>
            <button onclick="submitQuiz()"
                    class="flex-1 py-2.5 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl">
                Ya, Submit
            </button>
        </div>
    </div>
</div>

{{-- Cheating Alert Modal --}}
<div id="cheat-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm">
    <div class="bg-white rounded-2xl shadow-2xl p-6 max-w-sm w-full mx-4 border border-red-200">
        <div class="text-center mb-4 space-y-2">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-red-50 text-red-600 text-2xl font-bold mb-1">
                ⚠
            </div>
            <h3 class="text-sm font-bold text-red-600">Peringatan Keamanan!</h3>
            <p class="text-xs text-slate-700 font-semibold">Anda terdeteksi meninggalkan halaman kuis.</p>
            <p class="text-2xs text-slate-500 leading-relaxed bg-slate-50 p-2.5 rounded-lg border border-slate-100" id="cheat-warning-msg"></p>
        </div>
        <button type="button" onclick="closeCheatModal()"
                class="w-full py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl transition">
            Saya Mengerti & Lanjutkan Kuis
        </button>
    </div>
</div>

<script>
let focusLossCount = 0;
const MAX_FOCUS_LOSS = 3;

document.addEventListener('visibilitychange', function() {
    if (document.hidden) {
        handleFocusLoss();
    }
});

window.addEventListener('blur', function() {
    handleFocusLoss();
});

function handleFocusLoss() {
    if (window.isSubmittingQuiz) return;
    
    focusLossCount++;
    
    if (focusLossCount >= MAX_FOCUS_LOSS) {
        window.isSubmittingQuiz = true;
        alert('Kuis Anda otomatis dikirim karena melanggar aturan fokus halaman kuis sebanyak 3 kali.');
        document.getElementById('quiz-form').submit();
    } else {
        const remaining = MAX_FOCUS_LOSS - focusLossCount;
        const msg = `Peringatan ${focusLossCount}/${MAX_FOCUS_LOSS}: Harap tetap fokus pada halaman kuis. Jika Anda meninggalkan halaman ini sebanyak ${remaining} kali lagi, jawaban Anda akan otomatis dikirim secara paksa!`;
        
        document.getElementById('cheat-warning-msg').textContent = msg;
        document.getElementById('cheat-modal').classList.remove('hidden');
    }
}

function closeCheatModal() {
    document.getElementById('cheat-modal').classList.add('hidden');
}

// Detektor Koneksi Internet
window.addEventListener('online', function() {
    showConnectionStatus(true);
});

window.addEventListener('offline', function() {
    showConnectionStatus(false);
});

function showConnectionStatus(isOnline) {
    const banner = document.getElementById('connection-banner');
    const text = document.getElementById('connection-banner-text');
    const submitBtns = document.querySelectorAll('button[onclick="confirmSubmit()"], button[type="submit"]');
    
    if (isOnline) {
        text.textContent = '✓ Koneksi Terhubung Kembali! Menyelaraskan jawaban...';
        banner.className = 'fixed top-0 left-0 right-0 z-50 px-4 py-2.5 text-center text-xs font-bold bg-emerald-600 text-white shadow-md transition-all duration-300';
        
        // Aktifkan kembali tombol submit
        submitBtns.forEach(btn => {
            btn.disabled = false;
            btn.style.opacity = '1';
            btn.style.cursor = 'pointer';
        });
        
        // Sembunyikan banner setelah 2.5 detik
        setTimeout(() => {
            if (navigator.onLine) {
                banner.classList.add('hidden');
            }
        }, 2500);
    } else {
        text.textContent = '⚠️ Koneksi Internet Terputus! Harap jangan menutup halaman kuis ini. Jawaban Anda akan otomatis tersinkronisasi kembali ketika internet aktif.';
        banner.className = 'fixed top-0 left-0 right-0 z-50 px-4 py-2.5 text-center text-xs font-bold bg-red-600 text-white shadow-md animate-pulse transition-all duration-300';
        
        // Nonaktifkan tombol submit
        submitBtns.forEach(btn => {
            btn.disabled = true;
            btn.style.opacity = '0.5';
            btn.style.cursor = 'not-allowed';
        });
    }
}
const SAVE_URL = "{{ route('quiz.save-answer', [$course, $quiz]) }}";
const CSRF = "{{ csrf_token() }}";
const flagged = new Set();
const answered = new Set();

// Auto-save via AJAX
function autoSave(questionId, value, type) {
    const body = { question_id: questionId, _token: CSRF };
    if (type === 'radio') body.selected_option_id = value;
    else body.text_answer = value;

    fetch(SAVE_URL, { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF }, body: JSON.stringify(body) });
    markAnswered(questionId);
}

function autoSaveText(questionId, value) {
    markAnswered(questionId);
}

function markAnswered(questionId) {
    // Find nav button by question ID mapping
    answered.add(questionId);
    updateNavColors();
}

function updateNavColors() {
    document.querySelectorAll('.nav-btn').forEach(btn => {
        const num = parseInt(btn.id.replace('nav-', ''));
        const card = document.getElementById('q-card-' + num);
        if (!card) return;

        const isFlagged = flagged.has(num);

        const hasRadio = card.querySelector('input[type=radio]:checked');
        const hasText = Array.from(card.querySelectorAll('input[type=text]')).some(i => i.value.trim() !== '');
        const hasSelect = Array.from(card.querySelectorAll('select')).some(s => s.value !== '');
        const isAnswered = hasRadio || hasText || hasSelect;

        if (isFlagged) {
            // RAGU-RAGU / BENDERA -> ORANYE SOLID (Warna Oranye)
            btn.style.backgroundColor = '#f59e0b'; // Amber 500
            btn.style.borderColor = '#f59e0b';
            btn.style.color = '#ffffff';
        } else if (isAnswered) {
            // SUDAH DIJAWAB -> ABU-ABU SOLID (Warna Abu-abu)
            btn.style.backgroundColor = '#64748b'; // Slate 500
            btn.style.borderColor = '#64748b';
            btn.style.color = '#ffffff';
        } else {
            // BELUM DIJAWAB -> PUTIH/BORDER ABU-ABU TIPIS (DEFAULT)
            btn.style.backgroundColor = '#ffffff';
            btn.style.borderColor = '#cbd5e1'; // Slate 300
            btn.style.color = '#64748b'; // Slate 500
        }
    });
}

function toggleFlag(num, btn) {
    if (flagged.has(num)) {
        flagged.delete(num);
        btn.classList.remove('text-amber-500');
        btn.classList.add('text-slate-300');
    } else {
        flagged.add(num);
        btn.classList.remove('text-slate-300');
        btn.classList.add('text-amber-500');
    }
    updateNavColors();
}

let currentActiveQ = 1;
function jumpTo(num) {
    const nextCard = document.getElementById('q-card-' + num);
    if (!nextCard) return;

    // Sembunyikan card kuis aktif saat ini
    const currentCard = document.getElementById('q-card-' + currentActiveQ);
    if (currentCard) {
        currentCard.classList.add('hidden');
    }

    // Tampilkan card kuis target baru
    nextCard.classList.remove('hidden');
    currentActiveQ = num;

    // Update nomor soal aktif di bagian atas kuis (Soal X / Y)
    const curQLbl = document.getElementById('current-q');
    if (curQLbl) {
        curQLbl.textContent = num;
    }

    // Scroll kembali ke atas halaman kuis secara halus agar peserta fokus ke atas soal baru
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function confirmSubmit() {
    const total = {{ $questions->count() }};
    let answeredCount = 0;
    
    document.querySelectorAll('.question-card').forEach(card => {
        const hasRadio = card.querySelector('input[type=radio]:checked');
        const hasText = Array.from(card.querySelectorAll('input[type=text]')).some(i => i.value.trim() !== '');
        const hasSelect = Array.from(card.querySelectorAll('select')).some(s => s.value !== '');
        if (hasRadio || hasText || hasSelect) {
            answeredCount++;
        }
    });

    const unanswered = total - answeredCount;
    const msg = unanswered > 0
        ? `${unanswered} soal belum terjawab. Soal yang belum dijawab tidak akan mendapat poin.`
        : 'Semua soal sudah dijawab.';
    document.getElementById('unanswered-msg').textContent = msg;
    document.getElementById('confirm-modal').classList.remove('hidden');
}

function submitQuiz() {
    window.isSubmittingQuiz = true;
    document.getElementById('quiz-form').submit();
}

// Timer countdown
@if($quiz->time_limit)
let secondsLeft = {{ $timeRemainingSeconds ?? ($quiz->time_limit * 60) }};
const timerEl = document.getElementById('timer-display');
const timerWrap = document.getElementById('timer');

function tick() {
    if (secondsLeft <= 0) {
        timerEl.textContent = '00:00';
        // Auto submit
        submitQuiz();
        return;
    }
    secondsLeft--;
    const m = String(Math.floor(secondsLeft / 60)).padStart(2, '0');
    const s = String(secondsLeft % 60).padStart(2, '0');
    timerEl.textContent = `${m}:${s}`;

    if (secondsLeft <= 120) { // merah jika <= 2 menit
        timerWrap.classList.remove('bg-slate-100', 'text-slate-700');
        timerWrap.classList.add('bg-red-100', 'text-red-600');
    }
}
setInterval(tick, 1000);
@endif

// Init
updateNavColors();
</script>
</x-app-layout>
