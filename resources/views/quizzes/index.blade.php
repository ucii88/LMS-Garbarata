@section('topbar_title', __('Manajemen') . ' ' . ($isPractice ? __('Latihan') : __('Quiz')))

<x-app-layout>
<div class="max-w-5xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h1 class="text-xl font-bold text-slate-800">{{ __('Manajemen') }} {{ $isPractice ? __('Latihan') : __('Quiz') }}</h1>
            <p class="text-sm text-slate-500 mt-0.5">
                {{ __('Course:') }} <span class="font-semibold text-blue-600">{{ $course->title }}</span> &mdash;
                {{ $quizzes->count() }} {{ $isPractice ? __('latihan') : __('quiz') }}
            </p>
        </div>
        <a href="{{ route($isPractice ? 'practices.create' : 'quizzes.create', $course) }}"
           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-base font-semibold px-4 py-2.5 rounded-xl transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            {{ __('Buat') }} {{ $isPractice ? __('Latihan') : __('Quiz') }} {{ __('Baru') }}
        </a>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 text-base px-4 py-3 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-rose-50 border border-rose-200 text-rose-700 text-base px-4 py-3 rounded-xl">
            {{ session('error') }}
        </div>
    @endif

    {{-- Daftar Quiz / Latihan --}}
    @if($quizzes->isEmpty())
        <div class="bg-white border border-dashed border-slate-200 rounded-2xl p-12 text-center">
            <div class="text-4xl mb-3"></div>
            <h3 class="font-semibold text-slate-700">{{ $isPractice ? __('Belum ada latihan') : __('Belum ada quiz') }}</h3>
            <p class="text-base text-slate-500 mt-1">{{ $isPractice ? __('Buat latihan pertama untuk course ini.') : __('Buat quiz pertama untuk course ini.') }}</p>
        </div>
    @else
        <div class="space-y-3">
            @foreach($quizzes as $quiz)
            <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-10 rounded-xl flex items-center justify-center text-[10px] font-bold tracking-wider shrink-0
                        {{ $isPractice ? 'bg-violet-100 text-violet-700' : ($quiz->isFinalQuiz() ? 'bg-amber-100 text-amber-700' : 'bg-blue-100 text-blue-700') }}">
                        {{ $isPractice ? __('LATIHAN') : ($quiz->isFinalQuiz() ? __('FINAL') : __('KUIS')) }}
                    </div>
                    <div>
                        <div class="flex items-center gap-2 mb-0.5">
                            <h3 class="font-semibold text-slate-800 text-base">{{ $quiz->title }}</h3>
                            @if(!$quiz->is_active)
                                <span class="text-sm px-2 py-0.5 bg-slate-100 text-slate-500 rounded-full">{{ __('Non-aktif') }}</span>
                            @endif
                        </div>
                        <p class="text-sm text-slate-500">
                            {{ $isPractice ? __('Latihan Chapter:') . ' ' . ($quiz->chapter?->title ?? '-') : ($quiz->isFinalQuiz() ? __('Final Quiz (Ujian Akhir Course)') : __('Chapter Quiz:') . ' ' . ($quiz->chapter?->title ?? '-')) }}
                        </p>
                        <div class="flex items-center gap-3 mt-1.5 text-sm text-slate-400">
                            <span>{{ $quiz->questions_count }} {{ __('soal') }}</span>
                            <span>&middot;</span>
                            @if($isPractice)
                                <span>{{ __('Tanpa timer') }} &middot; {{ $quiz->max_attempts ? __('Maks.') . ' ' . $quiz->max_attempts . ' ' . __('percobaan') : __('Tanpa batas percobaan') }}</span>
                            @else
                                <span>{{ __('Lulus:') }} {{ $quiz->passing_score }}% &middot; {{ $quiz->time_limit ? $quiz->time_limit . ' ' . __('mnt') : __('Tanpa timer') }} &middot; {{ __('Maks.') }} {{ $quiz->max_attempts }} {{ __('percobaan') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-2 shrink-0">
                    <form action="{{ route($isPractice ? 'practices.publish' : 'quizzes.publish', [$course, $quiz]) }}" method="POST" class="inline-flex">
                        @csrf @method('PATCH')
                        <input type="hidden" name="is_active" value="0">
                        <label class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-semibold {{ $quiz->is_active ? 'text-emerald-700 border border-emerald-200 bg-emerald-50' : 'text-slate-500 border border-slate-200 hover:bg-slate-50' }} rounded-xl cursor-pointer transition select-none">
                            <input type="checkbox" name="is_active" value="1" @checked($quiz->is_active) onchange="this.form.submit()" class="rounded text-blue-600 focus:ring-blue-500 border-slate-300">
                            <span>{{ $isPractice ? __('Publish Latihan') : ($quiz->isFinalQuiz() ? __('Publish Ujian') : __('Publish Quiz')) }}</span>
                        </label>
                    </form>
                    <a href="{{ route($isPractice ? 'practices.attempts' : 'quizzes.attempts', [$course, $quiz]) }}"
                       class="px-3 py-2 text-sm font-semibold text-indigo-600 hover:bg-indigo-50 border border-indigo-200 rounded-xl transition">
                         {{ __('Hasil Peserta') }}
                    </a>
                    <a href="{{ route($isPractice ? 'practices.edit' : 'quizzes.edit', [$course, $quiz]) }}"
                       class="px-3 py-2 text-sm font-semibold text-blue-600 hover:bg-blue-50 border border-blue-200 rounded-xl transition">
                         {{ __('Edit & Kelola Soal') }}
                    </a>
                    <form action="{{ route($isPractice ? 'practices.destroy' : 'quizzes.destroy', [$course, $quiz]) }}" method="POST"
                          data-confirm="{{ $isPractice ? __('Apakah Anda yakin ingin menghapus latihan ini?') : __('Apakah Anda yakin ingin menghapus quiz ini?') }}">
                        @csrf @method('DELETE')
                        <button class="px-3 py-2 text-sm font-semibold text-red-500 hover:bg-red-50 border border-red-200 rounded-xl transition">
                             {{ __('Hapus') }}
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    @endif

</div>
</x-app-layout>

