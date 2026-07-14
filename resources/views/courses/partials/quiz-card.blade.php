{{--
    Partial: Quiz Card untuk study page
    Digunakan di akhir setiap chapter section di study.blade.php

    Variables yang dibutuhkan (passed dari parent):
    - $course, $chapter
    - $chapterQuiz: Quiz|null
    - $chapterQuizAttempt: QuizAttempt|null
    - $finalQuiz: Quiz|null
    - $finalQuizAttempt: QuizAttempt|null
    - $certificate: Certificate|null
--}}

{{-- ========== QUIZ CARD ========== --}}
@if($chapterQuiz)
<div class="mt-8 px-4 sm:px-0">
    <p class="text-xs font-bold text-blue-700 uppercase tracking-wider">Quiz Chapter</p>
</div>
<div class="mt-8 px-4 sm:px-0">
    <div class="rounded-2xl border-2 overflow-hidden
        @if($chapterQuizAttempt?->is_passed)
            border-emerald-300 bg-emerald-50
        @elseif($chapterQuizAttempt && !$chapterQuizAttempt->is_passed)
            border-red-200 bg-red-50
        @else
            border-blue-200 bg-blue-50
        @endif">

        <div class="flex items-center gap-4 px-5 py-4">
            {{-- Icon status --}}
            <div class="w-12 h-12 rounded-xl flex items-center justify-center text-[10px] font-bold tracking-wider shrink-0
                @if($chapterQuizAttempt?->is_passed)
                    bg-emerald-100 text-emerald-700
                @elseif($chapterQuizAttempt && !$chapterQuizAttempt->is_passed)
                    bg-red-100 text-red-700
                @else
                    bg-blue-100 text-blue-700
                @endif">
                @if($chapterQuizAttempt?->is_passed)
                    LULUS
                @elseif($chapterQuizAttempt && !$chapterQuizAttempt->is_passed)
                    GAGAL
                @else
                    QUIZ
                @endif
            </div>

            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2 flex-wrap">
                    <span class="text-xs font-bold uppercase tracking-wider
                        @if($chapterQuizAttempt?->is_passed) text-emerald-600
                        @elseif($chapterQuizAttempt) text-red-500
                        @else text-blue-600 @endif">
                        Quiz Chapter
                    </span>
                    @if($chapterQuizAttempt?->is_passed)
                        <span class="text-xs px-2 py-0.5 bg-emerald-500 text-white rounded-full font-semibold">
                            Lulus · {{ number_format($chapterQuizAttempt->score, 0) }}%
                        </span>
                    @elseif($chapterQuizAttempt && !$chapterQuizAttempt->is_passed)
                        <span class="text-xs px-2 py-0.5 bg-red-400 text-white rounded-full font-semibold">
                            Belum Lulus · {{ number_format($chapterQuizAttempt->score, 0) }}%
                        </span>
                    @else
                        <span class="text-xs px-2 py-0.5 bg-blue-100 text-blue-600 rounded-full font-semibold">
                            Belum Dikerjakan
                        </span>
                    @endif
                </div>
                <h3 class="text-sm font-bold text-slate-800 mt-0.5">{{ $chapterQuiz->title }}</h3>
                <p class="text-xs text-slate-500">
                    {{ $chapterQuiz->questions_count }} soal ·
                    {{ $chapterQuiz->time_limit ? $chapterQuiz->time_limit . ' mnt' : 'Tanpa timer' }} ·
                    Lulus: {{ $chapterQuiz->passing_score }}%
                </p>
                @if($chapterQuiz->start_time || $chapterQuiz->end_time)
                    <p class="text-[10px] text-slate-400 mt-1 flex items-center gap-1">
                        <span>📅</span>
                        @if($chapterQuiz->availability_status === 'upcoming')
                            <span class="text-amber-600 font-semibold">Dibuka: {{ $chapterQuiz->start_time->timezone('Asia/Jakarta')->format('d M H:i') }} WIB</span>
                        @elseif($chapterQuiz->availability_status === 'closed')
                            <span class="text-red-500 font-semibold">Sudah Ditutup (Selesai: {{ $chapterQuiz->end_time->timezone('Asia/Jakarta')->format('d M H:i') }} WIB)</span>
                        @else
                            <span class="text-emerald-600 font-semibold">S/d: {{ $chapterQuiz->end_time ? $chapterQuiz->end_time->timezone('Asia/Jakarta')->format('d M H:i') . ' WIB' : 'Seterusnya' }}</span>
                        @endif
                    </p>
                @endif
            </div>

            {{-- CTA Button --}}
            <div class="shrink-0">
                @if(auth()->user()->isPeserta())
                    @if($chapterQuizAttempt?->is_passed)
                        <a href="{{ route('quiz.result', [$course, $chapterQuiz]) }}"
                           class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-bold text-emerald-700 bg-emerald-100 hover:bg-emerald-200 rounded-xl transition">
                            Lihat Hasil
                        </a>
                    @elseif($chapterQuiz->availability_status === 'upcoming')
                        <span class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-semibold text-slate-400 bg-slate-100 rounded-xl cursor-not-allowed">
                            Belum Dibuka
                        </span>
                    @elseif($chapterQuiz->availability_status === 'closed')
                        <span class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-semibold text-slate-400 bg-slate-100 rounded-xl cursor-not-allowed">
                            Sudah Ditutup
                        </span>
                    @elseif($chapterQuiz->canAttempt(auth()->id()))
                        <a href="{{ route('quiz.start', [$course, $chapterQuiz]) }}"
                           class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition">
                            {{ $chapterQuizAttempt ? 'Coba Lagi' : 'Mulai Quiz' }}
                        </a>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-semibold text-slate-400 bg-slate-100 rounded-xl cursor-not-allowed">
                            Habis
                        </span>
                    @endif
                @elseif(auth()->user()->isInstruktur())
                    <div class="flex items-center gap-2">
                        <a href="{{ route('quizzes.attempts', [$course, $chapterQuiz]) }}"
                           class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-bold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 border border-indigo-200 rounded-xl transition">
                            Hasil Peserta
                        </a>
                        <a href="{{ route('quizzes.edit', [$course, $chapterQuiz]) }}"
                           class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-bold text-blue-600 border border-blue-200 hover:bg-blue-50 rounded-xl transition">
                            Edit
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@elseif(auth()->user()->isInstruktur())
{{-- Instruktur: tampilkan tombol buat quiz jika belum ada --}}
<div class="mt-8 px-4 sm:px-0">
    <div class="rounded-2xl border-2 border-dashed border-slate-200 bg-slate-50 px-5 py-4 flex items-center justify-between gap-4">
        <div>
            <p class="text-xs font-semibold text-slate-500">Quiz untuk chapter ini belum dibuat</p>
        </div>
        <a href="{{ route('quizzes.create', $course) }}"
           class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition shrink-0">
            + Buat Quiz Chapter
        </a>
    </div>
</div>
@endif

{{-- ========== UJIAN CARD (ditampilkan di semua chapter) ========== --}}
@if(false && $finalQuiz)
<div class="mt-4 px-4 sm:px-0">
    <div class="rounded-2xl border-2 overflow-hidden
        @if($finalQuizAttempt?->is_passed)
            border-amber-300 bg-amber-50
        @elseif($finalQuizAttempt && !$finalQuizAttempt->is_passed)
            border-orange-200 bg-orange-50
        @else
            border-amber-200 bg-amber-50/50
        @endif">

        <div class="flex items-center gap-4 px-5 py-4">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center text-[10px] font-bold tracking-wider shrink-0
                @if($finalQuizAttempt?->is_passed) bg-amber-100 text-amber-800 @else bg-amber-50 text-amber-600 @endif">
                FINAL
            </div>

            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2 flex-wrap">
                    <span class="text-xs font-bold uppercase tracking-wider text-amber-600">Ujian</span>
                    @if($finalQuizAttempt?->is_passed)
                        <span class="text-xs px-2 py-0.5 bg-amber-500 text-white rounded-full font-semibold">
                            Lulus · {{ number_format($finalQuizAttempt->score, 0) }}%
                        </span>
                    @elseif($finalQuizAttempt)
                        <span class="text-xs px-2 py-0.5 bg-orange-400 text-white rounded-full font-semibold">
                            Belum Lulus · {{ number_format($finalQuizAttempt->score, 0) }}%
                        </span>
                    @else
                        <span class="text-xs px-2 py-0.5 bg-amber-100 text-amber-700 rounded-full font-semibold">
                            Ujian Akhir Course
                        </span>
                    @endif
                </div>
                <h3 class="text-sm font-bold text-slate-800 mt-0.5">{{ $finalQuiz->title }}</h3>
                <p class="text-xs text-slate-500">
                    {{ $finalQuiz->questions_count }} soal ·
                    {{ $finalQuiz->time_limit ? $finalQuiz->time_limit . ' mnt' : 'Tanpa timer' }} ·
                    Lulus: {{ $finalQuiz->passing_score }}%
                </p>
                @if($finalQuiz->start_time || $finalQuiz->end_time)
                    <p class="text-[10px] text-slate-400 mt-1 flex items-center gap-1">
                        <span>📅</span>
                        @if($finalQuiz->availability_status === 'upcoming')
                            <span class="text-amber-600 font-semibold">Dibuka: {{ $finalQuiz->start_time->timezone('Asia/Jakarta')->format('d M H:i') }} WIB</span>
                        @elseif($finalQuiz->availability_status === 'closed')
                            <span class="text-red-500 font-semibold">Sudah Ditutup (Selesai: {{ $finalQuiz->end_time->timezone('Asia/Jakarta')->format('d M H:i') }} WIB)</span>
                        @else
                            <span class="text-emerald-600 font-semibold">S/d: {{ $finalQuiz->end_time ? $finalQuiz->end_time->timezone('Asia/Jakarta')->format('d M H:i') . ' WIB' : 'Seterusnya' }}</span>
                        @endif
                    </p>
                @endif
            </div>

            <div class="shrink-0">
                @if(auth()->user()->isPeserta())
                    @if($finalQuizAttempt?->is_passed)
                        <a href="{{ route('quiz.result', [$course, $finalQuiz]) }}"
                           class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-bold text-amber-700 bg-amber-100 hover:bg-emerald-200 rounded-xl transition">
                            Lihat Hasil
                        </a>
                    @elseif($finalQuiz->availability_status === 'upcoming')
                        <span class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-semibold text-slate-400 bg-slate-100 rounded-xl cursor-not-allowed">
                            Belum Dibuka
                        </span>
                    @elseif($finalQuiz->availability_status === 'closed')
                        <span class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-semibold text-slate-400 bg-slate-100 rounded-xl cursor-not-allowed">
                            Sudah Ditutup
                        </span>
                    @elseif($finalQuiz->canAttempt(auth()->id()))
                        <a href="{{ route('quiz.start', [$course, $finalQuiz]) }}"
                           class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-bold text-white bg-amber-500 hover:bg-amber-600 rounded-xl transition">
                            Mulai Ujian
                        </a>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-semibold text-slate-400 bg-slate-100 rounded-xl cursor-not-allowed">
                            Habis
                        </span>
                    @endif
                @elseif(auth()->user()->isInstruktur())
                    <div class="flex items-center gap-2">
                        <a href="{{ route('quizzes.attempts', [$course, $finalQuiz]) }}"
                           class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-bold text-amber-800 bg-amber-100 hover:bg-amber-200 border border-amber-200 rounded-xl transition">
                            Hasil Peserta
                        </a>
                        <a href="{{ route('quizzes.edit', [$course, $finalQuiz]) }}"
                           class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-bold text-amber-700 border border-amber-200 hover:bg-amber-50 rounded-xl transition">
                            Edit
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endif
