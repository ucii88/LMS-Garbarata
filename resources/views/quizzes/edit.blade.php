@section('topbar_title', 'Edit ' . ($isPractice ? 'Latihan' : ($quiz->isFinalQuiz() ? 'Ujian' : 'Quiz')) . ' — ' . $quiz->title)

<x-app-layout>
    @php
        $activityLabel = $isPractice ? 'Latihan' : ($quiz->isFinalQuiz() ? 'Ujian' : 'Quiz');
    @endphp

    <div class="max-w-6xl mx-auto space-y-6">
        <div>
            <a href="{{ route($isPractice ? 'practices.index' : 'quizzes.index', $course) }}" class="text-sm font-bold text-slate-500">← Kembali</a>
            <h1 class="mt-2 text-xl font-bold text-slate-800">Edit {{ $activityLabel }}</h1>
            <p class="text-sm text-slate-500">Konfigurasi dan pilih soal dari bank soal. Total poin wajib tepat 100.</p>
        </div>

        @if (session('success'))
            <div class="rounded-xl bg-emerald-50 p-3 text-base text-emerald-700">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="rounded-xl border border-rose-100 bg-rose-50 p-3 text-sm font-semibold text-rose-700">
                @foreach ($errors->all() as $error)<p>{{ $error }}</p>@endforeach
            </div>
        @endif

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2 lg:items-start" id="edit-grid">
            <!-- 1. PERUBAHAN DI SINI: height diganti menjadi calc(100vh - 8rem) dan ditambah overflow-y: auto -->
            <form id="quiz-config-form" action="{{ route($isPractice ? 'practices.update' : 'quizzes.update', [$course, $quiz]) }}" method="POST" class="flex flex-col rounded-2xl border bg-white p-6" style="height: calc(100vh - 8rem); overflow-y: auto;">
                @csrf @method('PUT')
                <div class="flex-1 space-y-4">
                    <h2 class="font-bold">Konfigurasi {{ $activityLabel }}</h2>
                    <div><label class="mb-1 block text-xs font-semibold">Judul *</label><input name="title" required value="{{ old('title', $quiz->title) }}" class="w-full rounded-xl border px-3 py-2.5 text-sm"></div>
                    <div><label class="mb-1 block text-xs font-semibold">Deskripsi</label><textarea name="description" rows="2" class="w-full rounded-xl border px-3 py-2.5 text-sm">{{ old('description', $quiz->description) }}</textarea></div>
                    <div><label class="mb-1 block text-xs font-semibold">Chapter</label><select name="chapter_id" {{ $isPractice ? 'required' : '' }} class="w-full rounded-xl border px-3 py-2.5 text-sm"><option value="">{{ $isPractice ? '-- Pilih chapter --' : 'Ujian' }}</option>@foreach($chapters as $chapter)<option value="{{ $chapter->id }}" @selected($quiz->chapter_id == $chapter->id)>{{ $chapter->order }}. {{ $chapter->title }}</option>@endforeach</select></div>

                    @if($isPractice)
                        <input type="hidden" name="review_policy" value="show_all">
                        <div><label class="mb-1 block text-xs font-semibold">Maks. percobaan (kosong = tanpa batas)</label><input type="number" name="max_attempts" min="1" max="100" value="{{ old('max_attempts', $quiz->max_attempts) }}" class="w-full rounded-xl border px-3 py-2.5 text-sm"></div>
                    @else
                        <div class="grid grid-cols-2 gap-3"><div><label class="mb-1 block text-xs font-semibold">Dibuka pada</label><input type="datetime-local" name="start_time" value="{{ old('start_time', $quiz->start_time ? $quiz->start_time->timezone('Asia/Jakarta')->format('Y-m-d\TH:i') : '') }}" class="w-full rounded-xl border px-3 py-2.5 text-sm"></div><div><label class="mb-1 block text-xs font-semibold">Ditutup pada</label><input type="datetime-local" name="end_time" value="{{ old('end_time', $quiz->end_time ? $quiz->end_time->timezone('Asia/Jakarta')->format('Y-m-d\TH:i') : '') }}" class="w-full rounded-xl border px-3 py-2.5 text-sm"></div></div>
                        <div class="grid grid-cols-2 gap-3"><div><label class="mb-1 block text-xs font-semibold">Timer (menit) <span class="text-gray-400 font-normal">— kosong = tanpa batas</span></label><input type="number" name="time_limit" min="1" placeholder="Contoh: 30" value="{{ old('time_limit', $quiz->time_limit) }}" class="w-full rounded-xl border px-3 py-2.5 text-sm"></div><div><label class="mb-1 block text-xs font-semibold">Nilai lulus *</label><input type="number" name="passing_score" required value="{{ old('passing_score', $quiz->passing_score) }}" class="w-full rounded-xl border px-3 py-2.5 text-sm"></div></div>
                        <div><label class="mb-1 block text-xs font-semibold">Maks. percobaan *</label><input type="number" name="max_attempts" required value="{{ old('max_attempts', $quiz->max_attempts) }}" class="w-full rounded-xl border px-3 py-2.5 text-sm"></div>
                        <select name="review_policy" class="w-full rounded-xl border px-3 py-2.5 text-sm"><option value="show_all" @selected($quiz->review_policy === 'show_all')>Tampilkan semua</option><option value="points_only" @selected($quiz->review_policy === 'points_only')>Skor saja</option><option value="hide_all" @selected($quiz->review_policy === 'hide_all')>Sembunyikan detail</option></select>
                        <div class="flex gap-4 text-xs -mt-2"><label><input type="checkbox" name="shuffle_questions" value="1" @checked($quiz->shuffle_questions)> Acak soal</label><label><input type="checkbox" name="shuffle_options" value="1" @checked($quiz->shuffle_options)> Acak pilihan</label></div>
                    @endif
                </div>
                <!-- 2. PERUBAHAN DI SINI: mt-6 dikembalikan menjadi mt-auto -->
                <button class="mt-auto w-full rounded-xl bg-blue-600 py-2.5 text-sm font-bold text-white">Simpan Perubahan</button>
            </form>

            <!-- 3. PERUBAHAN DI SINI: max-height diganti menjadi height biasa -->
            <div id="question-selection-card" class="flex flex-col overflow-hidden rounded-2xl border bg-white p-6 lg:sticky lg:top-6" style="height: calc(100vh - 8rem);">
                <div class="mb-4 flex items-start justify-between gap-4">
                    <div>
                        <h2 class="font-bold">Soal dalam {{ $activityLabel }}</h2>
                        <p class="text-xs text-slate-500">
                            @if($quiz->isFinalQuiz())
                                Soal dari semua bab · pilih hingga total 100 poin.
                            @else
                                Pilih dari bank soal terkait.
                            @endif
                        </p>
                    </div>
                    <p class="text-right text-xs font-semibold text-slate-600">
                        <span id="selected-question-count">{{ count($selectedQuestionIds) }}</span> soal dipilih<br>
                        <span id="selected-question-points" class="text-blue-600">0</span> / 100 poin
                    </p>
                </div>

                <form id="question-selection-form" action="{{ route($isPractice ? 'practices.questions.sync' : 'quizzes.questions.sync', [$course, $quiz]) }}" method="POST" class="flex flex-1 flex-col overflow-hidden min-h-0">
                    @csrf
                    @if($quiz->isFinalQuiz())
                        {{-- Ujian: Tab filter per bab --}}
                        @php $groupedQuestions = $availableQuestions->groupBy('chapter_id'); @endphp

                        {{-- Tab Pills --}}
                        <div class="flex flex-wrap gap-1.5 border-b border-slate-100 pb-3" id="chapter-tabs">
                            <button type="button"
                                class="chapter-tab-btn active-tab rounded-full px-3 py-1 text-xs font-semibold transition"
                                data-tab="all"
                                onclick="switchTab('all', this)">
                                Semua
                                <span class="ml-1 rounded-full bg-white/60 px-1.5 text-[10px] font-bold" id="badge-all">{{ $availableQuestions->count() }}</span>
                            </button>
                            @foreach($groupedQuestions as $chapterId => $chapterQuestions)
                                @php $ch = $chapterQuestions->first()->chapter; @endphp
                                <button type="button"
                                    class="chapter-tab-btn rounded-full px-3 py-1 text-xs font-semibold transition"
                                    data-tab="{{ $chapterId }}"
                                    onclick="switchTab('{{ $chapterId }}', this)">
                                    Bab {{ $ch->order ?? $loop->iteration }}
                                    <span class="ml-1 rounded-full bg-white/60 px-1.5 text-[10px] font-bold" id="badge-{{ $chapterId }}">{{ $chapterQuestions->count() }}</span>
                                </button>
                            @endforeach
                        </div>

                        {{-- Semua soal (semua tab) --}}
                        <div class="min-h-0 flex-1 overflow-y-auto pr-1 space-y-1.5" id="tab-panel-all">
                            @forelse($availableQuestions as $question)
                                <label class="flex gap-3 rounded-xl border p-3 transition hover:border-blue-200 hover:bg-blue-50/30">
                                    <input class="question-checkbox mt-0.5" type="checkbox"
                                        name="question_ids[]" value="{{ $question->id }}"
                                        data-question-id="{{ $question->id }}"
                                        data-chapter="{{ $question->chapter_id }}"
                                        data-points="{{ ($question->type === 'matching' || $question->type === 'ordering') ? $question->points * $question->options->count() : $question->points }}"
                                        @checked(in_array($question->id, $selectedQuestionIds))>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-xs font-semibold leading-relaxed text-slate-800">{{ $question->question_text }}</p>
                                        <p class="mt-1 text-[10px] text-slate-400">
                                            <span class="mr-1 rounded bg-blue-50 px-1.5 py-0.5 text-blue-600 font-semibold">Bab {{ $question->chapter->order }}</span>
                                            {{ $question->type_label }} ·
                                            @if($question->type === 'matching' || $question->type === 'ordering')
                                                {{ $question->points * $question->options->count() }} poin
                                            @else
                                                {{ $question->points }} poin
                                            @endif
                                        </p>
                                    </div>
                                    <a href="{{ route('questions.index', [$course, $question->chapter]) }}?question={{ $question->id }}&return_to={{ urlencode(route('quizzes.edit', [$course, $quiz])) }}"
                                       class="shrink-0 self-center rounded-lg px-2 py-1 text-[10px] font-bold text-blue-600 hover:bg-blue-50"
                                       onclick="event.stopPropagation()">Lihat detail</a>
                                </label>
                            @empty
                                <div class="py-8 text-center text-sm text-slate-400">Belum ada soal di bank soal.</div>
                            @endforelse
                        </div>

                        {{-- Panel per bab (tersembunyi secara default) --}}
                        @foreach($groupedQuestions as $chapterId => $chapterQuestions)
                            @php $ch = $chapterQuestions->first()->chapter; @endphp
                            <div class="min-h-0 flex-1 overflow-y-auto pr-1 space-y-1.5 hidden" id="tab-panel-{{ $chapterId }}">
                                <div class="mb-1 flex items-center justify-between">
                                    <span class="text-[11px] font-bold text-slate-600">{{ $ch->title ?? 'Bab '.$chapterId }}</span>
                                    <button type="button"
                                        class="text-[10px] font-semibold text-blue-500 hover:text-blue-700"
                                        onclick="toggleChapter({{ $chapterId }}, this)">Pilih Semua</button>
                                </div>
                                <div data-chapter-group="{{ $chapterId }}" class="space-y-1.5">
                                    @foreach($chapterQuestions as $question)
                                        <label class="flex gap-3 rounded-xl border p-3 transition hover:border-blue-200 hover:bg-blue-50/30">
                                            <input class="question-checkbox mt-0.5" type="checkbox"
                                                name="question_ids[]" value="{{ $question->id }}"
                                                data-question-id="{{ $question->id }}"
                                                data-chapter="{{ $chapterId }}"
                                                data-points="{{ ($question->type === 'matching' || $question->type === 'ordering') ? $question->points * $question->options->count() : $question->points }}"
                                                @checked(in_array($question->id, $selectedQuestionIds))>
                                            <div class="min-w-0 flex-1">
                                                <p class="text-xs font-semibold leading-relaxed text-slate-800">{{ $question->question_text }}</p>
                                                <p class="mt-1 text-[10px] text-slate-400">
                                                    {{ $question->type_label }} ·
                                                    @if($question->type === 'matching' || $question->type === 'ordering')
                                                        {{ $question->points * $question->options->count() }} poin
                                                    @else
                                                        {{ $question->points }} poin
                                                    @endif
                                                </p>
                                            </div>
                                            <a href="{{ route('questions.index', [$course, $question->chapter]) }}?question={{ $question->id }}&return_to={{ urlencode(route('quizzes.edit', [$course, $quiz])) }}"
                                               class="shrink-0 self-center rounded-lg px-2 py-1 text-[10px] font-bold text-blue-600 hover:bg-blue-50"
                                               onclick="event.stopPropagation()">Lihat detail</a>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach

                    @else
                        {{-- Quiz / Latihan: list biasa --}}
                        <div class="max-h-96 space-y-2 overflow-y-auto pr-1">
                            @forelse($availableQuestions as $question)
                                <label class="flex gap-3 rounded-xl border p-3 transition hover:border-blue-200 hover:bg-blue-50/30">
                                    <input class="question-checkbox mt-0.5" type="checkbox" name="question_ids[]" value="{{ $question->id }}" data-question-id="{{ $question->id }}" data-points="{{ ($question->type === 'matching' || $question->type === 'ordering') ? $question->points * $question->options->count() : $question->points }}" @checked(in_array($question->id, $selectedQuestionIds))>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-xs font-semibold leading-relaxed text-slate-800">{{ $question->question_text }}</p>
                                        <p class="mt-1 text-[10px] text-slate-400">
                                            {{ $question->type_label }} ·
                                            @if($question->type === 'matching' || $question->type === 'ordering')
                                                {{ $question->points * $question->options->count() }} poin ({{ $question->options->count() }} x {{ $question->points }} poin)
                                            @else
                                                {{ $question->points }} poin
                                            @endif
                                        </p>
                                    </div>
                                    <a href="{{ route('questions.index', [$course, $question->chapter]) }}?question={{ $question->id }}&return_to={{ urlencode(route($isPractice ? 'practices.edit' : 'quizzes.edit', [$course, $quiz])) }}" class="shrink-0 self-center rounded-lg px-2 py-1 text-[10px] font-bold text-blue-600 hover:bg-blue-50" onclick="event.stopPropagation()">Lihat detail</a>
                                </label>
                            @empty
                                <div class="py-8 text-center text-sm text-slate-400">Belum ada soal.</div>
                            @endforelse
                        </div>
                    @endif

                        <button class="mt-4 w-full shrink-0 rounded-xl bg-emerald-600 py-2.5 text-sm font-bold text-white">Simpan Pilihan Soal</button>
            </div>{{-- end card kanan --}}
        </div>{{-- end grid --}}
    </div>{{-- end container --}}

    <style>
        .chapter-tab-btn {
            background: #f1f5f9;
            color: #475569;
        }
        .chapter-tab-btn:hover {
            background: #e2e8f0;
        }
        .chapter-tab-btn.active-tab {
            background: #2563eb;
            color: #ffffff;
        }
        .chapter-tab-btn.active-tab span {
            background: rgba(255,255,255,0.25);
        }
    </style>

    <script>
        let questionCheckboxes = [];
        const countElement = document.getElementById('selected-question-count');
        const pointsElement = document.getElementById('selected-question-points');

        // Hitung total poin yang dipilih
        function updateQuestionSummary() {
            questionCheckboxes = Array.from(document.querySelectorAll('.question-checkbox'));
            const selectedById = new Map();

            questionCheckboxes.forEach(cb => {
                const questionId = cb.dataset.questionId || cb.value;
                if (cb.checked && !selectedById.has(questionId)) {
                    selectedById.set(questionId, cb);
                }
            });

            const selected = Array.from(selectedById.values());
            const totalPoints = selected.reduce((sum, cb) => sum + Number(cb.dataset.points), 0);
            countElement.textContent = selected.length;
            pointsElement.textContent = totalPoints;
            pointsElement.className = totalPoints === 100 ? 'text-emerald-600' : 'text-rose-600';
            return totalPoints;
        }

        function setQuestionChecked(questionId, isChecked) {
            document.querySelectorAll('.question-checkbox[data-question-id="' + questionId + '"]').forEach(cb => {
                cb.checked = isChecked;
            });
        }

        function syncQuestionCardHeight() {
            // Height now controlled via CSS; nothing to do here.
        }

        // Switch tab filter
        function switchTab(tabId, btn) {
            // Update tombol aktif
            document.querySelectorAll('.chapter-tab-btn').forEach(b => b.classList.remove('active-tab'));
            btn.classList.add('active-tab');

            // Sembunyikan semua panel
            document.querySelectorAll('[id^="tab-panel-"]').forEach(p => p.classList.add('hidden'));

            // Tampilkan panel yang dipilih
            const panel = document.getElementById('tab-panel-' + tabId);
            if (panel) panel.classList.remove('hidden');
        }

        // Toggle semua soal dalam satu bab
        function toggleChapter(chapterId, btn) {
            const group = document.querySelector('[data-chapter-group="' + chapterId + '"]');
            if (!group) return;
            const boxes = group.querySelectorAll('.question-checkbox');
            const allChecked = Array.from(boxes).every(cb => cb.checked);
            const nextState = !allChecked;
            boxes.forEach(cb => {
                setQuestionChecked(cb.dataset.questionId || cb.value, nextState);
            });
            btn.textContent = allChecked ? 'Pilih Semua' : 'Batal Pilih';
            updateQuestionSummary();
        }

        // Sync checkbox di panel "Semua" & panel bab (karena soal muncul di dua tempat)
        document.addEventListener('change', function(e) {
            if (!e.target.classList.contains('question-checkbox')) return;
            const questionId = e.target.dataset.questionId || e.target.value;
            const isChecked = e.target.checked;
            setQuestionChecked(questionId, isChecked);
            updateQuestionSummary();
        });

        document.getElementById('question-selection-form').addEventListener('submit', (event) => {
            const totalPoints = updateQuestionSummary();
            if (totalPoints !== 100) {
                event.preventDefault();
                alert('Total poin soal harus tepat 100/100. Saat ini: ' + totalPoints + ' poin.');
            }
        });
        document.getElementById('quiz-config-form').addEventListener('submit', (event) => {
            const totalPoints = updateQuestionSummary();
            if (totalPoints !== 100) {
                event.preventDefault();
                alert('Quiz, ujian, atau latihan hanya dapat disimpan setelah total poin soal tepat 100/100. Saat ini: ' + totalPoints + ' poin.');
            }
        });

        window.addEventListener('load', syncQuestionCardHeight);
        window.addEventListener('resize', syncQuestionCardHeight);
        updateQuestionSummary();
        syncQuestionCardHeight();
    </script>

</x-app-layout>