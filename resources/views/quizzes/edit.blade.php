@section('topbar_title', __('Edit') . ' ' . ($isPractice ? __('Latihan') : ($quiz->isFinalQuiz() ? __('Ujian') : __('Kuis'))) . ' — ' . $quiz->title)

<x-app-layout>
    @php
        $activityLabel = $isPractice ? __('Latihan') : ($quiz->isFinalQuiz() ? __('Ujian') : __('Kuis'));
        $currentStep = request('step', 'questions');
    @endphp

    <div class="max-w-5xl mx-auto space-y-6" x-data="{ activeStep: '{{ $errors->any() ? 'config' : $currentStep }}' }">
        {{-- Header Navigation & Stepper --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <a href="{{ route($isPractice ? 'practices.index' : 'quizzes.index', $course) }}" 
                   x-show="activeStep === 'config'"
                   class="inline-flex items-center text-sm font-semibold text-slate-500 hover:text-slate-800 transition">
                    &larr; {{ __('Kembali ke Manajemen') }} {{ $activityLabel }}
                </a>
                <h1 class="mt-1 text-2xl font-bold text-slate-800">{{ $quiz->title }}</h1>
                <p class="text-xs sm:text-sm text-slate-500">
                    <span class="inline-block px-2 py-0.5 rounded-full text-xs font-semibold mr-1 {{ $quiz->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                        {{ $quiz->is_active ? __('Aktif / Published') : __('Draft') }}
                    </span>
                    {{ __('Kelola pengaturan dan daftar soal.') }}
                </p>
            </div>

            {{-- 2-Step Stepper Tabs --}}
            <div class="inline-flex items-center p-1.5 bg-slate-100 border border-slate-200 rounded-2xl shadow-inner self-start sm:self-auto">
                <button type="button" 
                    @click="activeStep = 'config'"
                    :class="activeStep === 'config' ? 'bg-white text-blue-600 shadow-sm font-bold' : 'text-slate-600 hover:text-slate-900 font-medium'"
                    class="flex items-center gap-2 px-3.5 py-1.5 rounded-xl text-xs sm:text-sm transition cursor-pointer">
                    <span :class="activeStep === 'config' ? 'bg-blue-600 text-white' : 'bg-slate-300 text-slate-700'" class="w-5 h-5 rounded-full flex items-center justify-center text-[11px] font-bold">1</span>
                    {{ __('1. Pengaturan') }}
                </button>
                <span class="text-slate-300 px-1">──</span>
                <button type="button" 
                    @click="activeStep = 'questions'"
                    :class="activeStep === 'questions' ? 'bg-white text-blue-600 shadow-sm font-bold' : 'text-slate-600 hover:text-slate-900 font-medium'"
                    class="flex items-center gap-2 px-3.5 py-1.5 rounded-xl text-xs sm:text-sm transition cursor-pointer">
                    <span :class="activeStep === 'questions' ? 'bg-blue-600 text-white' : 'bg-slate-300 text-slate-700'" class="w-5 h-5 rounded-full flex items-center justify-center text-[11px] font-bold">2</span>
                    {{ __('2. Pilih Soal') }}
                    <span class="ml-1 px-1.5 py-0.5 rounded text-[10px] font-bold bg-slate-200 text-slate-700">
                        <span id="step-points-display">0</span>/100 Poin
                    </span>
                </button>
            </div>
        </div>

        <x-flash-message type="success" />
        @if ($errors->any())
            <div class="rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm font-semibold text-rose-700 space-y-1">
                @foreach ($errors->all() as $error)<p>{{ __( $error ) }}</p>@endforeach
            </div>
        @endif

        {{-- ==================== LANGKAH 1: KONFIGURASI ==================== --}}
        <div x-show="activeStep === 'config'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="max-w-3xl mx-auto">
            <form id="quiz-config-form" action="{{ route($isPractice ? 'practices.update' : 'quizzes.update', [$course, $quiz]) }}" method="POST" class="rounded-2xl border border-slate-200 bg-white p-6 sm:p-8 shadow-sm space-y-6">
                @csrf 
                @method('PUT')

                <div class="border-b border-slate-100 pb-4">
                    <h2 class="text-lg font-bold text-slate-800">{{ __('Pengaturan') }} {{ $activityLabel }}</h2>
                    <p class="text-xs text-slate-500 mt-0.5">{{ __('Atur judul, jadwal pelaksanaan, durasi pengerjaan, dan kriteria kelulusan.') }}</p>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="mb-1 block text-xs font-semibold text-slate-700">{{ __('Judul *') }}</label>
                        <input name="title" required value="{{ old('title', $quiz->title) }}" class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="mb-1 block text-xs font-semibold text-slate-700">{{ __('Deskripsi') }}</label>
                        <textarea name="description" rows="3" class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">{{ old('description', $quiz->description) }}</textarea>
                    </div>

                    <div>
                        <label class="mb-1 block text-xs font-semibold text-slate-700">{{ __('Chapter') }}</label>
                        <select name="chapter_id" {{ $isPractice ? 'required' : '' }} class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            <option value="">{{ $isPractice ? __('-- Pilih chapter --') : __('Ujian (Akhir Course)') }}</option>
                            @foreach($chapters as $chapter)
                                <option value="{{ $chapter->id }}" @selected($quiz->chapter_id == $chapter->id)>{{ $chapter->order }}. {{ $chapter->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    @if($isPractice)
                        <input type="hidden" name="review_policy" value="show_all">
                        <div>
                            <label class="mb-1 block text-xs font-semibold text-slate-700">{{ __('Maks. percobaan (kosong = tanpa batas)') }}</label>
                            <input type="number" name="max_attempts" min="1" max="100" value="{{ old('max_attempts', $quiz->max_attempts) }}" class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                        </div>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="mb-1 block text-xs font-semibold text-slate-700">{{ __('Dibuka pada') }}</label>
                                <input type="datetime-local" name="start_time" value="{{ old('start_time', $quiz->start_time ? $quiz->start_time->timezone('Asia/Jakarta')->format('Y-m-d\TH:i') : '') }}" class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="mb-1 block text-xs font-semibold text-slate-700">{{ __('Ditutup pada') }}</label>
                                <input type="datetime-local" name="end_time" value="{{ old('end_time', $quiz->end_time ? $quiz->end_time->timezone('Asia/Jakarta')->format('Y-m-d\TH:i') : '') }}" class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="mb-1 block text-xs font-semibold text-slate-700">{{ __('Timer (menit)') }} <span class="text-slate-400 font-normal">— {{ __('kosong = tanpa batas') }}</span></label>
                                <input type="number" name="time_limit" min="1" placeholder="{{ __('Contoh: 30') }}" value="{{ old('time_limit', $quiz->time_limit) }}" class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="mb-1 block text-xs font-semibold text-slate-700">{{ __('Nilai lulus *') }}</label>
                                <input type="number" name="passing_score" required value="{{ old('passing_score', $quiz->passing_score) }}" class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            </div>
                        </div>

                        <div>
                            <label class="mb-1 block text-xs font-semibold text-slate-700">{{ __('Maks. percobaan *') }}</label>
                            <input type="number" name="max_attempts" required value="{{ old('max_attempts', $quiz->max_attempts) }}" class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="mb-1 block text-xs font-semibold text-slate-700">{{ __('Kebijakan Review Hasil') }}</label>
                            <select name="review_policy" class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                <option value="show_all" @selected($quiz->review_policy === 'show_all')>{{ __('Tampilkan semua (kunci & pembahasan)') }}</option>
                                <option value="points_only" @selected($quiz->review_policy === 'points_only')>{{ __('Skor saja') }}</option>
                                <option value="hide_all" @selected($quiz->review_policy === 'hide_all')>{{ __('Sembunyikan detail') }}</option>
                            </select>
                        </div>

                        <div class="flex flex-wrap gap-6 text-xs pt-1">
                            <label class="inline-flex items-center gap-2 cursor-pointer font-medium text-slate-700">
                                <input type="checkbox" name="shuffle_questions" value="1" @checked($quiz->shuffle_questions) class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                {{ __('Acak urutan soal untuk setiap peserta') }}
                            </label>
                            <label class="inline-flex items-center gap-2 cursor-pointer font-medium text-slate-700">
                                <input type="checkbox" name="shuffle_options" value="1" @checked($quiz->shuffle_options) class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                {{ __('Acak opsi pilihan ganda') }}
                            </label>
                        </div>
                    @endif
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center justify-end pt-6 border-t border-slate-100">
                    <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm shadow-sm transition cursor-pointer">
                        <span>{{ __('Simpan & Lanjut ke Pilih Soal →') }}</span>
                    </button>
                </div>
            </form>
        </div>

        {{-- ==================== LANGKAH 2: PILIH SOAL ==================== --}}
        <div x-show="activeStep === 'questions'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="w-full space-y-4">
            {{-- Toolbar Step 2 --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
                <div class="flex items-center gap-3">
                    <button type="button" @click="activeStep = 'config'" 
                        class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-bold text-blue-700 bg-blue-50 hover:bg-blue-100 border border-blue-200 transition cursor-pointer">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        <span>{{ __('Pengaturan') }} {{ $activityLabel }}</span>
                    </button>
                    <div class="hidden sm:block h-5 w-px bg-slate-200"></div>
                    <div>
                        <h2 class="text-sm font-bold text-slate-800">{{ __('Daftar Soal Tersedia') }}</h2>
                        <p class="text-[11px] text-slate-500">
                            @if($quiz->isFinalQuiz())
                                {{ __('Pilih soal dari bank soal bab. Total poin soal yang dipilih wajib tepat 100.') }}
                            @else
                                {{ __('Pilih soal dari bab terkait. Total poin soal yang dipilih wajib tepat 100.') }}
                            @endif
                        </p>
                    </div>
                </div>

                {{-- Counter & Points Pill --}}
                <div class="flex items-center gap-3 self-end sm:self-auto">
                    <div class="text-right">
                        <p class="text-xs font-medium text-slate-500">
                            <span id="selected-question-count" class="font-bold text-slate-800">{{ count($selectedQuestionIds) }}</span> {{ __('soal dipilih') }}
                        </p>
                    </div>
                    <div id="points-pill-container" class="px-3.5 py-1.5 rounded-xl border text-xs font-bold flex items-center gap-1.5 bg-slate-50 border-slate-200">
                        <span id="selected-question-points" class="text-sm font-extrabold text-blue-600">0</span>
                        <span class="text-slate-400">/ 100</span>
                        <span class="text-[10px] uppercase tracking-wider text-slate-500">{{ __('Poin') }}</span>
                    </div>
                </div>
            </div>

            {{-- Card Bank Soal --}}
            <div id="question-selection-card" class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <form id="question-selection-form" action="{{ route($isPractice ? 'practices.questions.sync' : 'quizzes.questions.sync', [$course, $quiz]) }}" method="POST" class="flex flex-col space-y-4">
                    @csrf

                    @if($quiz->isFinalQuiz())
                        {{-- Ujian: Tab filter per bab --}}
                        @php $groupedQuestions = $availableQuestions->groupBy('chapter_id'); @endphp

                        {{-- Tab Pills --}}
                        <div class="flex flex-wrap gap-2 border-b border-slate-100 pb-4" id="chapter-tabs">
                            <button type="button"
                                class="chapter-tab-btn active-tab rounded-full px-3.5 py-1.5 text-xs font-semibold transition cursor-pointer"
                                data-tab="all"
                                onclick="switchTab('all', this)">
                                {{ __('Semua Bab') }}
                                <span class="ml-1 rounded-full bg-white/60 px-1.5 py-0.5 text-[10px] font-bold" id="badge-all">{{ $availableQuestions->count() }}</span>
                            </button>
                            @foreach($groupedQuestions as $chapterId => $chapterQuestions)
                                @php $ch = $chapterQuestions->first()->chapter; @endphp
                                <button type="button"
                                    class="chapter-tab-btn rounded-full px-3.5 py-1.5 text-xs font-semibold transition cursor-pointer"
                                    data-tab="{{ $chapterId }}"
                                    onclick="switchTab('{{ $chapterId }}', this)">
                                    {{ __('Bab') }} {{ $ch->order ?? $loop->iteration }}
                                    <span class="ml-1 rounded-full bg-slate-200 px-1.5 py-0.5 text-[10px] font-bold" id="badge-{{ $chapterId }}">{{ $chapterQuestions->count() }}</span>
                                </button>
                            @endforeach
                        </div>

                        {{-- Panel Semua Soal --}}
                        <div class="max-h-[720px] overflow-y-auto pr-2 py-1 space-y-4" id="tab-panel-all">
                            @forelse($availableQuestions as $question)
                                @php
                                    $calculatedPoints = ($question->type === 'matching' || $question->type === 'ordering') ? $question->points * $question->options->count() : $question->points;
                                @endphp
                                <div class="flex items-start gap-4 rounded-2xl border border-slate-200/90 bg-white p-5 transition hover:border-blue-300 hover:shadow-sm">
                                    <input class="question-checkbox mt-0.5 h-5 w-5 shrink-0 rounded-md border-slate-300 text-blue-600 focus:ring-blue-500 cursor-pointer" type="checkbox"
                                        name="question_ids[]" value="{{ $question->id }}"
                                        data-question-id="{{ $question->id }}"
                                        data-chapter="{{ $question->chapter_id }}"
                                        data-points="{{ $calculatedPoints }}"
                                        @checked(in_array($question->id, $selectedQuestionIds))>
                                    <div class="min-w-0 flex-1 cursor-pointer select-none" onclick="toggleQuestionCheckbox('{{ $question->id }}')">
                                        <p class="text-sm font-semibold leading-relaxed text-slate-800">{{ $question->question_text }}</p>
                                        <div class="mt-3 flex flex-wrap items-center gap-2.5 text-xs text-slate-500">
                                            <span class="rounded-lg bg-blue-50 border border-blue-100/60 px-2.5 py-0.5 text-blue-700 font-bold text-[11px]">{{ __('Bab') }} {{ $question->chapter->order }}</span>
                                            <span class="rounded-lg bg-slate-100 px-2.5 py-0.5 text-slate-600 font-medium text-[11px]">{{ $question->type_label }}</span>
                                            <span class="font-bold text-slate-700 text-xs">• {{ $calculatedPoints }} {{ __('poin') }}</span>
                                        </div>
                                    </div>
                                    <a href="{{ route('questions.index', [$course, $question->chapter]) }}?question={{ $question->id }}&return_to={{ urlencode(route('quizzes.edit', [$course, $quiz])) }}"
                                       class="shrink-0 self-center rounded-xl px-3 py-1.5 text-xs font-bold text-blue-600 hover:bg-blue-50 hover:text-blue-700 transition"
                                       onclick="event.stopPropagation()">{{ __('Lihat detail') }}</a>
                                </div>
                            @empty
                                <div class="py-14 text-center text-sm text-slate-400">{{ __('Belum ada soal di bank soal.') }}</div>
                            @endforelse
                        </div>

                        {{-- Panel Per Bab --}}
                        @foreach($groupedQuestions as $chapterId => $chapterQuestions)
                            @php $ch = $chapterQuestions->first()->chapter; @endphp
                            <div class="max-h-[720px] overflow-y-auto pr-2 py-1 space-y-4 hidden" id="tab-panel-{{ $chapterId }}">
                                <div class="mb-2 flex items-center justify-between pb-2 border-b border-slate-100">
                                    <span class="text-xs font-bold text-slate-700">{{ $ch->title ?? 'Bab '.$chapterId }}</span>
                                    <button type="button"
                                        class="text-xs font-bold text-blue-600 hover:text-blue-800 cursor-pointer"
                                        onclick="toggleChapter({{ $chapterId }}, this)">{{ __('Pilih Semua Bab Ini') }}</button>
                                </div>
                                <div data-chapter-group="{{ $chapterId }}" class="space-y-4">
                                    @foreach($chapterQuestions as $question)
                                        @php
                                            $calculatedPoints = ($question->type === 'matching' || $question->type === 'ordering') ? $question->points * $question->options->count() : $question->points;
                                        @endphp
                                        <div class="flex items-start gap-4 rounded-2xl border border-slate-200/90 bg-white p-5 transition hover:border-blue-300 hover:shadow-sm">
                                            <input class="question-checkbox mt-0.5 h-5 w-5 shrink-0 rounded-md border-slate-300 text-blue-600 focus:ring-blue-500 cursor-pointer" type="checkbox"
                                                name="question_ids[]" value="{{ $question->id }}"
                                                data-question-id="{{ $question->id }}"
                                                data-chapter="{{ $chapterId }}"
                                                data-points="{{ $calculatedPoints }}"
                                                @checked(in_array($question->id, $selectedQuestionIds))>
                                            <div class="min-w-0 flex-1 cursor-pointer select-none" onclick="toggleQuestionCheckbox('{{ $question->id }}')">
                                                <p class="text-sm font-semibold leading-relaxed text-slate-800">{{ $question->question_text }}</p>
                                                <div class="mt-3 flex flex-wrap items-center gap-2.5 text-xs text-slate-500">
                                                    <span class="rounded-lg bg-slate-100 px-2.5 py-0.5 text-slate-600 font-medium text-[11px]">{{ $question->type_label }}</span>
                                                    <span class="font-bold text-slate-700 text-xs">• {{ $calculatedPoints }} {{ __('poin') }}</span>
                                                </div>
                                            </div>
                                            <a href="{{ route('questions.index', [$course, $question->chapter]) }}?question={{ $question->id }}&return_to={{ urlencode(route('quizzes.edit', [$course, $quiz])) }}"
                                               class="shrink-0 self-center rounded-xl px-3 py-1.5 text-xs font-bold text-blue-600 hover:bg-blue-50 hover:text-blue-700 transition"
                                               onclick="event.stopPropagation()">{{ __('Lihat detail') }}</a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach

                    @else
                        {{-- Quiz / Latihan: list biasa --}}
                        <div class="max-h-[720px] space-y-4 overflow-y-auto pr-2 py-1">
                            @forelse($availableQuestions as $question)
                                @php
                                    $calculatedPoints = ($question->type === 'matching' || $question->type === 'ordering') ? $question->points * $question->options->count() : $question->points;
                                @endphp
                                <div class="flex items-start gap-4 rounded-2xl border border-slate-200/90 bg-white p-5 transition hover:border-blue-300 hover:shadow-sm">
                                    <input class="question-checkbox mt-0.5 h-5 w-5 shrink-0 rounded-md border-slate-300 text-blue-600 focus:ring-blue-500 cursor-pointer" type="checkbox" 
                                        name="question_ids[]" value="{{ $question->id }}" 
                                        data-question-id="{{ $question->id }}" 
                                        data-points="{{ $calculatedPoints }}" 
                                        @checked(in_array($question->id, $selectedQuestionIds))>
                                    <div class="min-w-0 flex-1 cursor-pointer select-none" onclick="toggleQuestionCheckbox('{{ $question->id }}')">
                                        <p class="text-sm font-semibold leading-relaxed text-slate-800">{{ $question->question_text }}</p>
                                        <div class="mt-3 flex flex-wrap items-center gap-2.5 text-xs text-slate-500">
                                            <span class="rounded-lg bg-slate-100 px-2.5 py-0.5 text-slate-600 font-medium text-[11px]">{{ $question->type_label }}</span>
                                            <span class="font-bold text-slate-700 text-xs">• {{ $calculatedPoints }} {{ __('poin') }}</span>
                                        </div>
                                    </div>
                                    <a href="{{ route('questions.index', [$course, $question->chapter]) }}?question={{ $question->id }}&return_to={{ urlencode(route($isPractice ? 'practices.edit' : 'quizzes.edit', [$course, $quiz])) }}" 
                                       class="shrink-0 self-center rounded-xl px-3 py-1.5 text-xs font-bold text-blue-600 hover:bg-blue-50 hover:text-blue-700 transition" 
                                       onclick="event.stopPropagation()">{{ __('Lihat detail') }}</a>
                                </div>
                            @empty
                                <div class="py-14 text-center text-sm text-slate-400">{{ __('Belum ada soal pada bab ini.') }}</div>
                            @endforelse
                        </div>
                    @endif

                    {{-- Sticky Action Footer --}}
                    <div class="sticky bottom-4 z-10 mt-6 flex flex-col sm:flex-row items-center justify-between gap-4 rounded-2xl border border-slate-200 bg-white/95 backdrop-blur px-6 py-4 shadow-lg">
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-slate-500 font-medium">
                                Total: <strong id="bottom-points-text" class="text-blue-600 font-bold">0</strong> / 100 poin
                            </span>
                        </div>
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm shadow-sm transition cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>{{ __('Simpan Pilihan Soal') }}</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
            color: #ffffff;
        }
    </style>

    <script>
        let questionCheckboxes = [];
        const countElement = document.getElementById('selected-question-count');
        const pointsElement = document.getElementById('selected-question-points');
        const pointsContainer = document.getElementById('points-pill-container');
        const stepPointsDisplay = document.getElementById('step-points-display');
        const bottomPointsText = document.getElementById('bottom-points-text');
        const DRAFT_KEY = 'quiz_draft_selected_{{ $quiz->id }}';

        // Pulihkan centang draf dari sessionStorage jika ada
        function restoreDraftSelections() {
            const saved = sessionStorage.getItem(DRAFT_KEY);
            if (saved) {
                try {
                    const ids = JSON.parse(saved);
                    if (Array.isArray(ids)) {
                        document.querySelectorAll('.question-checkbox').forEach(cb => {
                            const qId = cb.dataset.questionId || cb.value;
                            cb.checked = ids.includes(qId) || ids.includes(Number(qId));
                        });
                    }
                } catch (e) {
                    console.error('Failed to parse draft selections', e);
                }
            }
        }

        // Simpan centang draf saat ini ke sessionStorage
        function saveDraftSelections(selectedIds) {
            sessionStorage.setItem(DRAFT_KEY, JSON.stringify(selectedIds));
        }

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
            const selectedIds = Array.from(selectedById.keys());
            saveDraftSelections(selectedIds);

            const totalPoints = selected.reduce((sum, cb) => sum + Number(cb.dataset.points), 0);
            if (countElement) countElement.textContent = selected.length;
            if (pointsElement) pointsElement.textContent = totalPoints;
            if (stepPointsDisplay) stepPointsDisplay.textContent = totalPoints;
            if (bottomPointsText) bottomPointsText.textContent = totalPoints;

            if (pointsContainer) {
                if (totalPoints === 100) {
                    pointsContainer.className = 'px-3.5 py-1.5 rounded-xl border text-xs font-bold flex items-center gap-1.5 bg-emerald-50 border-emerald-300 text-emerald-700';
                    if (pointsElement) pointsElement.className = 'text-sm font-extrabold text-emerald-600';
                    if (bottomPointsText) bottomPointsText.className = 'text-emerald-600 font-bold';
                } else {
                    pointsContainer.className = 'px-3.5 py-1.5 rounded-xl border text-xs font-bold flex items-center gap-1.5 bg-rose-50 border-rose-200 text-rose-700';
                    if (pointsElement) pointsElement.className = 'text-sm font-extrabold text-rose-600';
                    if (bottomPointsText) bottomPointsText.className = 'text-rose-600 font-bold';
                }
            }
            return totalPoints;
        }

        function setQuestionChecked(questionId, isChecked) {
            document.querySelectorAll('.question-checkbox[data-question-id="' + questionId + '"]').forEach(cb => {
                cb.checked = isChecked;
            });
        }

        function toggleQuestionCheckbox(questionId) {
            const cb = document.querySelector('.question-checkbox[data-question-id="' + questionId + '"]');
            if (!cb) return;
            const nextState = !cb.checked;
            setQuestionChecked(questionId, nextState);
            updateQuestionSummary();
        }

        // Switch tab filter
        function switchTab(tabId, btn) {
            document.querySelectorAll('.chapter-tab-btn').forEach(b => b.classList.remove('active-tab'));
            btn.classList.add('active-tab');

            document.querySelectorAll('[id^="tab-panel-"]').forEach(p => p.classList.add('hidden'));

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
            btn.textContent = allChecked ? '{{ __('Pilih Semua Bab Ini') }}' : '{{ __('Batal Pilih Bab Ini') }}';
            updateQuestionSummary();
        }

        // Sync checkbox di panel "Semua" & panel bab
        document.addEventListener('change', function(e) {
            if (!e.target.classList.contains('question-checkbox')) return;
            const questionId = e.target.dataset.questionId || e.target.value;
            const isChecked = e.target.checked;
            setQuestionChecked(questionId, isChecked);
            updateQuestionSummary();
        });

        const qForm = document.getElementById('question-selection-form');
        if (qForm) {
            qForm.addEventListener('submit', (event) => {
                sessionStorage.removeItem(DRAFT_KEY);
                const totalPoints = updateQuestionSummary();
                if (totalPoints !== 100) {
                    event.preventDefault();
                    showGlobalAlert('{{ __('Poin Belum Sesuai') }}', '{{ __('Total poin soal harus tepat 100/100. Saat ini:') }} ' + totalPoints + ' {{ __('poin.') }}');
                }
            });
        }

        const configForm = document.getElementById('quiz-config-form');
        if (configForm) {
            configForm.addEventListener('submit', (event) => {
                @if($quiz->is_active)
                    const totalPoints = updateQuestionSummary();
                    if (totalPoints !== 100) {
                        event.preventDefault();
                        showGlobalAlert('{{ __('Poin Belum Sesuai') }}', '{{ __('Kuis atau latihan aktif hanya dapat disimpan jika total poin soal tepat 100/100. Saat ini:') }} ' + totalPoints + ' {{ __('poin.') }}');
                    }
                @endif
            });
        }

        restoreDraftSelections();
        updateQuestionSummary();
    </script>
</x-app-layout>