@section('topbar_title', 'Nilai Esai — ' . $attempt->user->name)

<x-app-layout>
<div class="max-w-4xl mx-auto space-y-6">

    {{-- Header --}}
    <div>
        <a href="{{ route($isPractice ? 'practices.attempts' : 'quizzes.attempts', [$course, $quiz]) }}"
           class="inline-flex items-center text-xs font-bold text-slate-500 hover:text-blue-600 transition mb-2">
            ← Kembali ke Daftar Peserta
        </a>
        <div class="flex items-start justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-slate-800">Penilaian Esai</h1>
                <p class="text-xs text-slate-500 mt-1">
                    <span class="font-semibold text-blue-600">{{ $quiz->title }}</span>
                    · Peserta: <span class="font-semibold text-slate-700">{{ $attempt->user->name }}</span>
                    · {{ $attempt->user->email }}
                </p>
                <p class="text-xs text-slate-400 mt-0.5">
                    Dikerjakan: {{ $attempt->started_at->timezone('Asia/Jakarta')->format('d M Y H:i') }}
                    @if($attempt->submitted_at)
                        · Dikumpulkan: {{ $attempt->submitted_at->timezone('Asia/Jakarta')->format('H:i') }}
                        · Durasi: {{ $attempt->getDurationLabel() }}
                    @endif
                </p>
            </div>
            {{-- Status Badge --}}
            @if($attempt->isPendingEssay())
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-orange-100 text-orange-700">
                     Menunggu Penilaian
                </span>
            @else
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">
                     Sudah Dinilai
                </span>
            @endif
        </div>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm px-4 py-3 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    {{-- Form Penilaian --}}
    <form action="{{ route($isPractice ? 'practices.attempts.grade.submit' : 'quizzes.attempts.grade.submit', [$course, $quiz, $attempt]) }}"
          method="POST" id="grading-form">
        @csrf

        <div class="space-y-5">
            @foreach($essayAnswers as $i => $answer)
            @php $question = $answer->question; @endphp

            <div class="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden
                {{ $answer->essay_graded_at ? 'border-blue-200' : '' }}">

                {{-- Header soal --}}
                <div class="flex items-center justify-between px-6 py-4 bg-slate-50 border-b border-slate-100">
                    <div class="flex items-center gap-2">
                        <span class="w-7 h-7 rounded-full bg-orange-500 text-white text-xs font-bold flex items-center justify-center">
                            {{ $i + 1 }}
                        </span>
                        <span class="text-xs font-bold text-orange-600 px-2 py-0.5 bg-orange-100 rounded-full">Esai</span>
                    </div>
                    <span class="text-xs text-slate-500 font-semibold">Maks. {{ $question->points }} poin</span>
                </div>

                <div class="p-6 space-y-5">
                    {{-- Teks Soal --}}
                    <div>
                        <p class="text-xs font-semibold text-slate-500 mb-1">Soal:</p>
                        <p class="text-sm font-medium text-slate-800 leading-relaxed">
                            {!! nl2br(e($question->question_text)) !!}
                        </p>
                        @if($question->question_image)
                            <img src="{{ Storage::url($question->question_image) }}"
                                 class="mt-3 max-h-48 rounded-xl border border-slate-200 object-contain" alt="Gambar soal">
                        @endif
                    </div>

                    {{-- Jawaban Peserta --}}
                    <div>
                        <p class="text-xs font-semibold text-slate-500 mb-1">Jawaban Peserta:</p>
                        <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 text-sm text-slate-800 leading-relaxed whitespace-pre-wrap min-h-[80px]">
                            {{ $answer->text_answer ?: '(tidak ada jawaban)' }}
                        </div>
                    </div>

                    <hr class="border-slate-100">

                    {{-- Form Penilaian per Soal --}}
                    <input type="hidden" name="grades[{{ $i }}][answer_id]" value="{{ $answer->id }}">

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        {{-- Input Nilai --}}
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">
                                Nilai <span class="text-red-500">*</span>
                                <span class="text-slate-400 font-normal">(0 – {{ $question->points }} poin)</span>
                            </label>
                            <div class="flex items-center gap-2">
                                <input type="number"
                                       name="grades[{{ $i }}][points]"
                                       id="points-{{ $i }}"
                                       value="{{ $answer->essay_graded_at ? number_format($answer->points_earned, 0) : '' }}"
                                       min="0"
                                       max="{{ $question->points }}"
                                       step="0.5"
                                       required
                                       placeholder="0"
                                       class="w-full border-2 border-slate-200 rounded-xl px-3 py-2.5 text-sm font-bold focus:ring-2 focus:ring-orange-400 focus:border-orange-400 outline-none"
                                       oninput="updatePointsDisplay({{ $i }}, this.value, {{ $question->points }})">
                                <span class="text-sm text-slate-400 shrink-0">/ {{ $question->points }}</span>
                            </div>
                            {{-- Visual progress bar --}}
                            <div class="mt-2 h-2 bg-slate-100 rounded-full overflow-hidden">
                                <div id="progress-{{ $i }}"
                                     class="h-full bg-orange-400 rounded-full transition-all duration-300"
                                     style="width: {{ $answer->essay_graded_at ? min(100, ($answer->points_earned / $question->points) * 100) : 0 }}%">
                                </div>
                            </div>
                        </div>

                        {{-- Feedback --}}
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">
                                Feedback <span class="text-slate-400 font-normal">(opsional)</span>
                            </label>
                            <textarea name="grades[{{ $i }}][feedback]"
                                      rows="3"
                                      placeholder="Tulis komentar atau feedback untuk peserta..."
                                      class="w-full border-2 border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-orange-400 focus:border-orange-400 outline-none resize-none">{{ $answer->essay_feedback ?? '' }}</textarea>
                        </div>
                    </div>

                    {{-- Info sudah dinilai sebelumnya --}}
                    @if($answer->essay_graded_at)
                        <div class="flex items-center gap-2 text-xs text-blue-600 bg-blue-50 border border-blue-200 rounded-lg px-3 py-2">
                            <span></span>
                            <span>
                                Sebelumnya dinilai {{ $answer->essay_graded_at->timezone('Asia/Jakarta')->format('d M Y H:i') }}
                                @if($answer->gradedBy) oleh <span class="font-semibold">{{ $answer->gradedBy->name }}</span> @endif
                                · Nilai lama: <span class="font-bold">{{ number_format($answer->points_earned, 0) }}</span> poin
                            </span>
                        </div>
                    @endif
                </div>
            </div>
            @endforeach

            {{-- Total & Submit --}}
            <div class="bg-white border border-slate-200 rounded-2xl p-5 flex items-center justify-between gap-4 sticky bottom-4 shadow-lg">
                <div class="text-sm text-slate-600">
                    <span class="font-semibold">{{ $essayAnswers->count() }}</span> soal esai
                    · Total maks: <span class="font-semibold">{{ $essayAnswers->sum(fn($a) => $a->question->points) }}</span> poin
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route($isPractice ? 'practices.attempts' : 'quizzes.attempts', [$course, $quiz]) }}"
                       class="px-4 py-2.5 text-sm font-semibold text-slate-600 hover:text-slate-800 transition">
                        Batal
                    </a>
                    <button type="submit"
                            class="px-6 py-2.5 bg-orange-500 hover:bg-orange-600 text-white text-sm font-bold rounded-xl transition shadow-sm">
                         Simpan Semua Penilaian
                    </button>
                </div>
            </div>
        </div>
    </form>

</div>

<script>
function updatePointsDisplay(idx, val, max) {
    const pct = max > 0 ? Math.min(100, Math.max(0, (parseFloat(val) / max) * 100)) : 0;
    const bar = document.getElementById(`progress-${idx}`);
    if (bar) {
        bar.style.width = pct + '%';
        if (pct >= 80) {
            bar.className = 'h-full bg-emerald-500 rounded-full transition-all duration-300';
        } else if (pct >= 50) {
            bar.className = 'h-full bg-amber-400 rounded-full transition-all duration-300';
        } else {
            bar.className = 'h-full bg-orange-400 rounded-full transition-all duration-300';
        }
    }
}
</script>
</x-app-layout>
