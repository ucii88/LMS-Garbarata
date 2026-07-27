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
    <p class="text-sm font-bold text-blue-700 uppercase tracking-wider">{{ __('Quiz Chapter') }}</p>
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
                    {{ __('LULUS') }}
                @elseif($chapterQuizAttempt && !$chapterQuizAttempt->is_passed)
                    {{ __('GAGAL') }}
                @else
                    {{ __('QUIZ') }}
                @endif
            </div>

            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2 flex-wrap">
                    <span class="text-sm font-bold uppercase tracking-wider
                        @if($chapterQuizAttempt?->is_passed) text-emerald-600
                        @elseif($chapterQuizAttempt) text-red-500
                        @else text-blue-600 @endif">
                        {{ __('Quiz Chapter') }}
                    </span>
                    @if($chapterQuizAttempt?->is_passed)
                        <span class="text-sm px-2 py-0.5 bg-emerald-500 text-white rounded-full font-semibold">
                            {{ __('Lulus') }} · {{ number_format($chapterQuizAttempt->score, 0) }}%
                        </span>
                    @elseif($chapterQuizAttempt && !$chapterQuizAttempt->is_passed)
                        <span class="text-sm px-2 py-0.5 bg-red-400 text-white rounded-full font-semibold">
                            {{ __('Belum Lulus') }} · {{ number_format($chapterQuizAttempt->score, 0) }}%
                        </span>
                    @else
                        <span class="text-sm px-2 py-0.5 bg-blue-100 text-blue-600 rounded-full font-semibold">
                            {{ __('Belum Dikerjakan') }}
                        </span>
                    @endif
                </div>
                <h3 class="text-base font-bold text-slate-800 mt-0.5">{{ $chapterQuiz->title }}</h3>
                <p class="text-sm text-slate-500">
                    {{ $chapterQuiz->questions_count }} {{ __('soal') }} ·
                    {{ $chapterQuiz->time_limit ? $chapterQuiz->time_limit . ' ' . __('mnt') : __('Tanpa timer') }} ·
                    {{ __('Lulus:') }} {{ $chapterQuiz->passing_score }}%
                </p>
                @if($chapterQuiz->start_time || $chapterQuiz->end_time)
                    <p class="text-[10px] text-slate-400 mt-1 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        @if($chapterQuiz->availability_status === 'upcoming')
                            <span class="text-amber-600 font-semibold">{{ __('Dibuka:') }} {{ $chapterQuiz->start_time->timezone('Asia/Jakarta')->format('d M H:i') }} WIB</span>
                        @elseif($chapterQuiz->availability_status === 'closed')
                            <span class="text-red-500 font-semibold">{{ __('Sudah Ditutup') }} ({{ __('Selesai:') }} {{ $chapterQuiz->end_time->timezone('Asia/Jakarta')->format('d M H:i') }} WIB)</span>
                        @else
                            <span class="text-emerald-600 font-semibold">{{ __('S/d:') }} {{ $chapterQuiz->end_time ? $chapterQuiz->end_time->timezone('Asia/Jakarta')->format('d M H:i') . ' WIB' : __('Seterusnya') }}</span>
                        @endif
                    </p>
                @endif
            </div>

            {{-- CTA Button --}}
            <div class="shrink-0">
                @if(auth()->user()->isPeserta())
                    @if($chapterQuizAttempt?->is_passed)
                        <a href="{{ route('quiz.result', [$course, $chapterQuiz]) }}"
                           class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-bold text-emerald-700 bg-emerald-100 hover:bg-emerald-200 rounded-xl transition">
                            {{ __('Lihat Hasil') }}
                        </a>
                    @elseif($chapterQuiz->availability_status === 'upcoming')
                        <span class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold text-slate-400 bg-slate-100 rounded-xl cursor-not-allowed">
                            {{ __('Belum Dibuka') }}
                        </span>
                    @elseif($chapterQuiz->availability_status === 'closed')
                        <span class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold text-slate-400 bg-slate-100 rounded-xl cursor-not-allowed">
                            {{ __('Sudah Ditutup') }}
                        </span>
                    @elseif($chapterQuiz->canAttempt(auth()->id()))
                        <a href="{{ route('quiz.start', [$course, $chapterQuiz]) }}"
                           class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition">
                            {{ $chapterQuizAttempt ? __('Coba Lagi') : __('Mulai Quiz') }}
                        </a>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold text-slate-400 bg-slate-100 rounded-xl cursor-not-allowed">
                            {{ __('Habis') }}
                        </span>
                    @endif
                @elseif(auth()->user()->isInstruktur())
                    <div class="flex items-center gap-2">
                        <a href="{{ route('quizzes.attempts', [$course, $chapterQuiz]) }}"
                           class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-bold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 border border-indigo-200 rounded-xl transition">
                            {{ __('Hasil Peserta') }}
                        </a>
                        <a href="{{ route('quizzes.edit', [$course, $chapterQuiz]) }}"
                           class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-bold text-blue-600 border border-blue-200 hover:bg-blue-50 rounded-xl transition">
                            {{ __('Edit') }}
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
            <p class="text-sm font-semibold text-slate-500">{{ __('Quiz untuk chapter ini belum dibuat') }}</p>
        </div>
        <a href="{{ route('quizzes.create', $course) }}"
           class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition shrink-0">
            + {{ __('Buat Quiz Chapter') }}
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
                    <span class="text-sm font-bold uppercase tracking-wider text-amber-600">{{ __('Ujian') }}</span>
                    @if($finalQuizAttempt?->is_passed)
                        <span class="text-sm px-2 py-0.5 bg-amber-500 text-white rounded-full font-semibold">
                            Lulus · {{ number_format($finalQuizAttempt->score, 0) }}%
                        </span>
                    @elseif($finalQuizAttempt)
                        <span class="text-sm px-2 py-0.5 bg-orange-400 text-white rounded-full font-semibold">
                            Belum Lulus · {{ number_format($finalQuizAttempt->score, 0) }}%
                        </span>
                    @else
                        <span class="text-sm px-2 py-0.5 bg-amber-100 text-amber-700 rounded-full font-semibold">
                            Ujian Akhir Course
                        </span>
                    @endif
                </div>
                <h3 class="text-base font-bold text-slate-800 mt-0.5">{{ $finalQuiz->title }}</h3>
                <p class="text-sm text-slate-500">
                    {{ $finalQuiz->questions_count }} soal ·
                    {{ $finalQuiz->time_limit ? $finalQuiz->time_limit . ' mnt' : 'Tanpa timer' }} ·
                    Lulus: {{ $finalQuiz->passing_score }}%
                </p>
                @if($finalQuiz->start_time || $finalQuiz->end_time)
                    <p class="text-[10px] text-slate-400 mt-1 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        @if($finalQuiz->availability_status === 'upcoming')
                            <span class="text-amber-600 font-semibold">{{ __('Dibuka:') }} {{ $finalQuiz->start_time->timezone('Asia/Jakarta')->format('d M H:i') }} WIB</span>
                        @elseif($finalQuiz->availability_status === 'closed')
                            <span class="text-red-500 font-semibold">{{ __('Sudah Ditutup') }} ({{ __('Selesai:') }} {{ $finalQuiz->end_time->timezone('Asia/Jakarta')->format('d M H:i') }} WIB)</span>
                        @else
                            <span class="text-emerald-600 font-semibold">{{ __('S/d:') }} {{ $finalQuiz->end_time ? $finalQuiz->end_time->timezone('Asia/Jakarta')->format('d M H:i') . ' WIB' : __('Seterusnya') }}</span>
                        @endif
                    </p>
                @endif
            </div>

            <div class="shrink-0">
                @if(auth()->user()->isPeserta())
                    @if($finalQuizAttempt?->is_passed)
                        <a href="{{ route('quiz.result', [$course, $finalQuiz]) }}"
                           class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-bold text-amber-700 bg-amber-100 hover:bg-emerald-200 rounded-xl transition">
                            Lihat Hasil
                        </a>
                    @elseif($finalQuiz->availability_status === 'upcoming')
                        <span class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold text-slate-400 bg-slate-100 rounded-xl cursor-not-allowed">
                            Belum Dibuka
                        </span>
                    @elseif($finalQuiz->availability_status === 'closed')
                        <span class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold text-slate-400 bg-slate-100 rounded-xl cursor-not-allowed">
                            Sudah Ditutup
                        </span>
                    @elseif($finalQuiz->canAttempt(auth()->id()))
                        <a href="{{ route('quiz.start', [$course, $finalQuiz]) }}"
                           class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-bold text-white bg-amber-500 hover:bg-amber-600 rounded-xl transition">
                            Mulai Ujian
                        </a>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold text-slate-400 bg-slate-100 rounded-xl cursor-not-allowed">
                            Habis
                        </span>
                    @endif
                @elseif(auth()->user()->isInstruktur())
                    <div class="flex items-center gap-2">
                        <a href="{{ route('quizzes.attempts', [$course, $finalQuiz]) }}"
                           class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-bold text-amber-800 bg-amber-100 hover:bg-amber-200 border border-amber-200 rounded-xl transition">
                            Hasil Peserta
                        </a>
                        <a href="{{ route('quizzes.edit', [$course, $finalQuiz]) }}"
                           class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-bold text-amber-700 border border-amber-200 hover:bg-amber-50 rounded-xl transition">
                            Edit
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endif

@php
    $nextChapter = $chapters->where('order', '>', $chapter->order)->first();
    
    $isCurrentChapterComplete = false;
    if (auth()->user()->isPeserta() && isset($learningProgress)) {
        $curProgress = collect($learningProgress['chapters'])->firstWhere('id', $chapter->id);
        $isCurrentChapterComplete = $curProgress && $curProgress['is_complete'];
    } else {
        $isCurrentChapterComplete = true;
    }
@endphp

@if($nextChapter)
<div class="mt-8 px-4 sm:px-0">
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h4 class="text-sm font-bold text-slate-800">{{ __('Selesai Mempelajari Bab Ini?') }}</h4>
            <p id="next-chapter-desc" class="text-xs text-slate-500 mt-1">
                @if($isCurrentChapterComplete)
                    {{ __('Hebat! Anda telah menyelesaikan seluruh materi dan quiz pada bab ini. Silakan lanjut ke bab berikutnya.') }}
                @else
                    {{ __('Selesaikan semua modul pembelajaran dan lulus quiz di atas untuk melanjutkan ke bab berikutnya.') }}
                @endif
            </p>
        </div>
        <div id="next-chapter-action">
            @if($isCurrentChapterComplete)
                <a href="{{ route('courses.chapters.show', [$course->id, $nextChapter->id]) }}"
                   class="inline-flex items-center justify-center gap-2 px-5 py-3 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-md hover:shadow-lg transition-all duration-150 whitespace-nowrap">
                    {{ __('Lanjut ke Bab') }} {{ $nextChapter->order }} &rarr;
                </a>
            @else
                <button disabled
                        class="inline-flex items-center justify-center gap-2 px-5 py-3 text-xs font-bold text-slate-400 bg-slate-100 rounded-xl cursor-not-allowed whitespace-nowrap">
                    {{ __('Lanjut ke Bab') }} {{ $nextChapter->order }}
                </button>
            @endif
        </div>
    </div>
</div>
@endif
