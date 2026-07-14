@section('topbar_title', 'Edit ' . ($isPractice ? 'Latihan' : ($quiz->isFinalQuiz() ? 'Ujian' : 'Quiz')) . ' — ' . $quiz->title)

<x-app-layout>
    @php
        $activityLabel = $isPractice ? 'Latihan' : ($quiz->isFinalQuiz() ? 'Ujian' : 'Quiz');
    @endphp

    <div class="max-w-6xl mx-auto space-y-6">
        <div>
            <a href="{{ route($isPractice ? 'practices.index' : 'quizzes.index', $course) }}" class="text-xs font-bold text-slate-500">← Kembali</a>
            <h1 class="mt-2 text-xl font-bold text-slate-800">Edit {{ $activityLabel }}</h1>
            <p class="text-xs text-slate-500">Konfigurasi dan pilih soal dari bank soal. Total poin wajib tepat 100.</p>
        </div>

        @if (session('success'))
            <div class="rounded-xl bg-emerald-50 p-3 text-sm text-emerald-700">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="rounded-xl border border-rose-100 bg-rose-50 p-3 text-xs font-semibold text-rose-700">
                @foreach ($errors->all() as $error)<p>{{ $error }}</p>@endforeach
            </div>
        @endif

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <form id="quiz-config-form" action="{{ route($isPractice ? 'practices.update' : 'quizzes.update', [$course, $quiz]) }}" method="POST" class="space-y-4 rounded-2xl border bg-white p-6">
                @csrf @method('PUT')
                <h2 class="font-bold">Konfigurasi {{ $activityLabel }}</h2>
                <div><label class="mb-1 block text-xs font-semibold">Judul *</label><input name="title" required value="{{ old('title', $quiz->title) }}" class="w-full rounded-xl border px-3 py-2.5 text-sm"></div>
                <div><label class="mb-1 block text-xs font-semibold">Deskripsi</label><textarea name="description" rows="2" class="w-full rounded-xl border px-3 py-2.5 text-sm">{{ old('description', $quiz->description) }}</textarea></div>
                <div><label class="mb-1 block text-xs font-semibold">Chapter</label><select name="chapter_id" {{ $isPractice ? 'required' : '' }} class="w-full rounded-xl border px-3 py-2.5 text-sm"><option value="">{{ $isPractice ? '-- Pilih chapter --' : 'Ujian' }}</option>@foreach($chapters as $chapter)<option value="{{ $chapter->id }}" @selected($quiz->chapter_id == $chapter->id)>{{ $chapter->order }}. {{ $chapter->title }}</option>@endforeach</select></div>

                @if($isPractice)
                    <input type="hidden" name="review_policy" value="show_all">
                    <div><label class="mb-1 block text-xs font-semibold">Maks. percobaan (kosong = tanpa batas)</label><input type="number" name="max_attempts" min="1" max="100" value="{{ old('max_attempts', $quiz->max_attempts) }}" class="w-full rounded-xl border px-3 py-2.5 text-sm"></div>
                @else
                    <div class="grid grid-cols-2 gap-3"><div><label class="mb-1 block text-xs font-semibold">Dibuka pada</label><input type="datetime-local" name="start_time" value="{{ old('start_time', $quiz->start_time ? $quiz->start_time->timezone('Asia/Jakarta')->format('Y-m-d\TH:i') : '') }}" class="w-full rounded-xl border px-3 py-2.5 text-sm"></div><div><label class="mb-1 block text-xs font-semibold">Ditutup pada</label><input type="datetime-local" name="end_time" value="{{ old('end_time', $quiz->end_time ? $quiz->end_time->timezone('Asia/Jakarta')->format('Y-m-d\TH:i') : '') }}" class="w-full rounded-xl border px-3 py-2.5 text-sm"></div></div>
                    <div class="grid grid-cols-2 gap-3"><div><label class="mb-1 block text-xs font-semibold">Timer</label><input type="number" name="time_limit" value="{{ old('time_limit', $quiz->time_limit) }}" class="w-full rounded-xl border px-3 py-2.5 text-sm"></div><div><label class="mb-1 block text-xs font-semibold">Nilai lulus *</label><input type="number" name="passing_score" required value="{{ old('passing_score', $quiz->passing_score) }}" class="w-full rounded-xl border px-3 py-2.5 text-sm"></div></div>
                    <div><label class="mb-1 block text-xs font-semibold">Maks. percobaan *</label><input type="number" name="max_attempts" required value="{{ old('max_attempts', $quiz->max_attempts) }}" class="w-full rounded-xl border px-3 py-2.5 text-sm"></div>
                    <select name="review_policy" class="w-full rounded-xl border px-3 py-2.5 text-sm"><option value="show_all" @selected($quiz->review_policy === 'show_all')>Tampilkan semua</option><option value="points_only" @selected($quiz->review_policy === 'points_only')>Skor saja</option><option value="hide_all" @selected($quiz->review_policy === 'hide_all')>Sembunyikan detail</option></select>
                @endif

                <div class="flex gap-4 text-xs"><label><input type="checkbox" name="shuffle_questions" value="1" @checked($quiz->shuffle_questions)> Acak soal</label><label><input type="checkbox" name="shuffle_options" value="1" @checked($quiz->shuffle_options)> Acak pilihan</label></div>
                <button class="w-full rounded-xl bg-blue-600 py-2.5 text-sm font-bold text-white">Simpan Perubahan</button>
            </form>

            <div class="rounded-2xl border bg-white p-6">
                <div class="mb-4 flex items-start justify-between gap-4">
                    <div><h2 class="font-bold">Soal dalam {{ $activityLabel }}</h2><p class="text-xs text-slate-500">Pilih dari bank soal terkait.</p></div>
                    <p class="text-right text-xs font-semibold text-slate-600"><span id="selected-question-count">{{ count($selectedQuestionIds) }}</span> soal dipilih<br><span id="selected-question-points" class="text-blue-600">0</span> / 100 poin</p>
                </div>

                <form id="question-selection-form" action="{{ route($isPractice ? 'practices.questions.sync' : 'quizzes.questions.sync', [$course, $quiz]) }}" method="POST" class="space-y-3">
                    @csrf
                    <div class="max-h-96 space-y-2 overflow-y-auto pr-1">
                        @forelse($availableQuestions as $question)
                            <label class="flex gap-3 rounded-xl border p-3 transition hover:border-blue-200 hover:bg-blue-50/30">
                                <input class="question-checkbox mt-0.5" type="checkbox" name="question_ids[]" value="{{ $question->id }}" data-points="{{ $question->points }}" @checked(in_array($question->id, $selectedQuestionIds))>
                                <div class="min-w-0 flex-1">
                                    <p class="text-xs font-semibold leading-relaxed text-slate-800">{{ $question->question_text }}</p>
                                    <p class="mt-1 text-[10px] text-slate-400">{{ $question->type_label }} · {{ $question->points }} poin</p>
                                </div>
                                <a href="{{ route('questions.index', [$course, $question->chapter]) }}?question={{ $question->id }}&return_to={{ urlencode(route($isPractice ? 'practices.edit' : 'quizzes.edit', [$course, $quiz])) }}" class="shrink-0 self-center rounded-lg px-2 py-1 text-[10px] font-bold text-blue-600 hover:bg-blue-50" onclick="event.stopPropagation()">Lihat detail</a>
                            </label>
                        @empty
                            <div class="py-8 text-center text-sm text-slate-400">Belum ada soal.</div>
                        @endforelse
                    </div>
                    <button class="w-full rounded-xl bg-emerald-600 py-2.5 text-sm font-bold text-white">Simpan Pilihan Soal</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const questionCheckboxes = Array.from(document.querySelectorAll('.question-checkbox'));
        const countElement = document.getElementById('selected-question-count');
        const pointsElement = document.getElementById('selected-question-points');

        function updateQuestionSummary() {
            const selected = questionCheckboxes.filter((checkbox) => checkbox.checked);
            const totalPoints = selected.reduce((sum, checkbox) => sum + Number(checkbox.dataset.points), 0);
            countElement.textContent = selected.length;
            pointsElement.textContent = totalPoints;
            pointsElement.className = totalPoints === 100 ? 'text-emerald-600' : 'text-rose-600';
            return totalPoints;
        }

        questionCheckboxes.forEach((checkbox) => checkbox.addEventListener('change', updateQuestionSummary));
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
        updateQuestionSummary();
    </script>
</x-app-layout>
