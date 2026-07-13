@section('topbar_title', 'Edit Quiz — ' . $quiz->title)

<x-app-layout>
<div class="max-w-6xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('quizzes.index', $course) }}"
               class="inline-flex items-center text-xs font-bold text-slate-500 hover:text-blue-600 transition mb-2">
                ← Kembali ke Daftar Quiz
            </a>
            <h1 class="text-xl font-bold text-slate-800">Edit Quiz</h1>
            <p class="text-xs text-slate-500 mt-0.5">
                {{ $quiz->isFinalQuiz() ? '🏆 Final Quiz' : '📌 Chapter Quiz: ' . ($quiz->chapter?->title ?? '-') }}
            </p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm px-4 py-3 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Kiri: Form Konfigurasi Quiz --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 space-y-5">
            <h2 class="text-base font-bold text-slate-800">Konfigurasi Quiz</h2>
            <form action="{{ route('quizzes.update', [$course, $quiz]) }}" method="POST" class="space-y-4">
                @csrf @method('PUT')

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Judul Quiz *</label>
                    <input type="text" name="title" value="{{ old('title', $quiz->title) }}" required
                           class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Deskripsi</label>
                    <textarea name="description" rows="2"
                              class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none resize-none">{{ old('description', $quiz->description) }}</textarea>
                </div>

                {{-- Penempatan --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-2">Penempatan</label>
                    <div class="space-y-2">
                        <label class="flex items-start gap-3 p-3 border-2 rounded-xl cursor-pointer transition has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 border-slate-200">
                            <input type="radio" name="placement" value="chapter"
                                   {{ !$quiz->isFinalQuiz() ? 'checked' : '' }}
                                   onchange="document.getElementById('edit-chapter-select').classList.remove('hidden')">
                            <div>
                                <p class="text-xs font-semibold text-slate-700">📌 Chapter Quiz</p>
                            </div>
                        </label>
                        <label class="flex items-start gap-3 p-3 border-2 rounded-xl cursor-pointer transition has-[:checked]:border-amber-500 has-[:checked]:bg-amber-50 border-slate-200">
                            <input type="radio" name="placement" value="final"
                                   {{ $quiz->isFinalQuiz() ? 'checked' : '' }}
                                   onchange="document.getElementById('edit-chapter-select').classList.add('hidden')">
                            <div>
                                <p class="text-xs font-semibold text-slate-700">🏆 Final Quiz</p>
                            </div>
                        </label>
                    </div>
                    <div id="edit-chapter-select" class="{{ $quiz->isFinalQuiz() ? 'hidden' : '' }} mt-2">
                        <select name="chapter_id"
                                class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                            <option value="">-- Pilih Chapter --</option>
                            @foreach($chapters as $chapter)
                                <option value="{{ $chapter->id }}" {{ $quiz->chapter_id == $chapter->id ? 'selected' : '' }}>
                                    {{ $chapter->order }}. {{ $chapter->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Kebijakan Hasil Ujian --}}
                <div class="mb-3">
                    <label class="block text-xs font-semibold text-slate-700 mb-2">Kebijakan Hasil Kuis (Review Peserta) *</label>
                    <select name="review_policy" required
                            class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="show_all" {{ old('review_policy', $quiz->review_policy) == 'show_all' ? 'selected' : '' }}>Tampilkan Semua (Poin, Jawaban Benar/Salah & Penjelasan)</option>
                        <option value="points_only" {{ old('review_policy', $quiz->review_policy) == 'points_only' ? 'selected' : '' }}>Hanya Tampilkan Skor & Poin Per Soal (Sembunyikan Kunci Jawaban)</option>
                        <option value="hide_all" {{ old('review_policy', $quiz->review_policy) == 'hide_all' ? 'selected' : '' }}>Sembunyikan Detail Jawaban Sepenuhnya (Hanya Tampilkan Skor Akhir)</option>
                    </select>
                    <p class="text-2xs text-slate-400 mt-1">Mengontrol apa saja yang dapat dilihat oleh peserta setelah mengirimkan (submit) kuis.</p>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Timer (menit)</label>
                        <input type="number" name="time_limit" value="{{ old('time_limit', $quiz->time_limit) }}"
                               min="1" max="300" placeholder="Tanpa timer"
                               class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Nilai Lulus (%) *</label>
                        <input type="number" name="passing_score" value="{{ old('passing_score', $quiz->passing_score) }}"
                               min="1" max="100" required
                               class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Max Percobaan *</label>
                        <input type="number" name="max_attempts" value="{{ old('max_attempts', $quiz->max_attempts) }}"
                               min="1" max="10" required
                               class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div class="flex flex-col justify-end gap-1.5">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="shuffle_questions" value="1" {{ $quiz->shuffle_questions ? 'checked' : '' }}
                                   class="w-4 h-4 rounded text-blue-600">
                            <span class="text-xs font-semibold text-slate-700">Acak soal</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="shuffle_options" value="1" {{ $quiz->shuffle_options ? 'checked' : '' }}
                                   class="w-4 h-4 rounded text-blue-600">
                            <span class="text-xs font-semibold text-slate-700">Acak pilihan</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" {{ $quiz->is_active ? 'checked' : '' }}
                                   class="w-4 h-4 rounded text-blue-600">
                            <span class="text-xs font-semibold text-slate-700">Aktif</span>
                        </label>
                    </div>
                </div>

                <button type="submit"
                        class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition">
                    Simpan Perubahan
                </button>
            </form>
        </div>

        {{-- Kanan: Pilih Soal dari Bank --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-base font-bold text-slate-800">Soal dalam Quiz</h2>
                    <p class="text-xs text-slate-500">
                        Pilih dari bank soal {{ $quiz->isFinalQuiz() ? 'semua chapter' : ('chapter: ' . ($quiz->chapter?->title ?? '-')) }}
                    </p>
                </div>
                <span class="text-xs font-semibold px-2 py-1 bg-blue-100 text-blue-700 rounded-full"
                      id="selected-count">{{ count($selectedQuestionIds) }} dipilih</span>
            </div>

            <form action="{{ route('quizzes.questions.sync', [$course, $quiz]) }}" method="POST" id="sync-form">
                @csrf

                {{-- Filter per chapter (untuk final quiz) --}}
                @if($quiz->isFinalQuiz())
                <div class="flex gap-2 flex-wrap">
                    <button type="button" onclick="filterChapter('all')"
                            class="text-xs px-3 py-1 rounded-full border font-semibold filter-btn bg-slate-800 text-white border-slate-800"
                            data-chapter="all">Semua</button>
                    @foreach($availableQuestions->groupBy('chapter_id') as $chapterId => $cQuestions)
                        <button type="button" onclick="filterChapter({{ $chapterId }})"
                                class="text-xs px-3 py-1 rounded-full border font-semibold filter-btn bg-white text-slate-600 border-slate-200"
                                data-chapter="{{ $chapterId }}">
                            {{ $cQuestions->first()->chapter->title }}
                        </button>
                    @endforeach
                </div>
                @endif

                {{-- Daftar Soal --}}
                <div class="space-y-2 max-h-80 overflow-y-auto pr-1" id="question-list">
                    @forelse($availableQuestions as $question)
                    <label class="flex items-start gap-3 p-3 border-2 rounded-xl cursor-pointer transition hover:border-blue-300
                                  {{ in_array($question->id, $selectedQuestionIds) ? 'border-blue-500 bg-blue-50' : 'border-slate-100' }}"
                           data-chapter="{{ $question->chapter_id }}">
                        <input type="checkbox" name="question_ids[]" value="{{ $question->id }}"
                               {{ in_array($question->id, $selectedQuestionIds) ? 'checked' : '' }}
                               class="mt-0.5 w-4 h-4 text-blue-600 rounded"
                               onchange="updateCount(); toggleHighlight(this)">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-1.5 mb-0.5">
                                <span class="text-xs font-semibold px-1.5 py-0.5 rounded
                                    @switch($question->type)
                                        @case('multiple_choice') bg-indigo-100 text-indigo-700 @break
                                        @case('true_false') bg-green-100 text-green-700 @break
                                        @case('fill_blank') bg-amber-100 text-amber-700 @break
                                        @case('matching') bg-purple-100 text-purple-700 @break
                                        @case('ordering') bg-rose-100 text-rose-700 @break
                                    @endswitch">
                                    {{ $question->type_label }}
                                </span>
                                <span class="text-xs text-slate-400">{{ $question->points }} poin</span>
                                @if($quiz->isFinalQuiz())
                                    <span class="text-xs text-slate-400">— {{ $question->chapter->title }}</span>
                                @endif
                            </div>
                            <p class="text-xs text-slate-700 line-clamp-2">{{ $question->question_text }}</p>
                        </div>
                    </label>
                    @empty
                        <div class="text-center py-8 text-sm text-slate-400">
                            Belum ada soal di bank soal
                            {{ $quiz->isFinalQuiz() ? 'course ini' : 'chapter ini' }}.
                        </div>
                    @endforelse
                </div>

                <button type="submit"
                        class="w-full py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl transition">
                    💾 Simpan Pilihan Soal
                </button>
            </form>
        </div>

    </div>
</div>

<script>
function updateCount() {
    const checked = document.querySelectorAll('input[name="question_ids[]"]:checked').length;
    document.getElementById('selected-count').textContent = checked + ' dipilih';
}

function toggleHighlight(checkbox) {
    const label = checkbox.closest('label');
    if (checkbox.checked) {
        label.classList.add('border-blue-500', 'bg-blue-50');
        label.classList.remove('border-slate-100');
    } else {
        label.classList.remove('border-blue-500', 'bg-blue-50');
        label.classList.add('border-slate-100');
    }
}

function filterChapter(chapterId) {
    document.querySelectorAll('#question-list label').forEach(label => {
        if (chapterId === 'all' || label.dataset.chapter == chapterId) {
            label.style.display = '';
        } else {
            label.style.display = 'none';
        }
    });
    document.querySelectorAll('.filter-btn').forEach(btn => {
        if (btn.dataset.chapter == chapterId) {
            btn.style.backgroundColor = '#1e293b'; // slate-800
            btn.style.borderColor = '#1e293b';
            btn.style.color = '#ffffff';
        } else {
            btn.style.backgroundColor = '#ffffff';
            btn.style.borderColor = '#e2e8f0'; // slate-200
            btn.style.color = '#475569'; // slate-600
        }
    });
}

document.querySelectorAll('input[name=placement]').forEach(radio => {
    radio.addEventListener('change', function() {
        const sel = document.getElementById('edit-chapter-select');
        this.value === 'chapter' ? sel.classList.remove('hidden') : sel.classList.add('hidden');
    });
});
</script>
</x-app-layout>
