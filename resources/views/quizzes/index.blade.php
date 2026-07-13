@section('topbar_title', 'Manajemen Quiz')

<x-app-layout>
<div class="max-w-5xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h1 class="text-xl font-bold text-slate-800">Manajemen Quiz</h1>
            <p class="text-xs text-slate-500 mt-0.5">
                Course: <span class="font-semibold text-blue-600">{{ $course->title }}</span> —
                {{ $quizzes->count() }} quiz
            </p>
        </div>
        <a href="{{ route('quizzes.create', $course) }}"
           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Buat Quiz Baru
        </a>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm px-4 py-3 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    {{-- Daftar Quiz --}}
    @if($quizzes->isEmpty())
        <div class="bg-white border border-dashed border-slate-200 rounded-2xl p-12 text-center">
            <h3 class="font-semibold text-slate-700">Belum ada kuis</h3>
            <p class="text-sm text-slate-500 mt-1">Buat kuis pertama untuk course ini.</p>
        </div>
    @else
        <div class="space-y-3">
            @foreach($quizzes as $quiz)
            <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center text-[10px] font-bold tracking-wider shrink-0
                        {{ $quiz->isFinalQuiz() ? 'bg-amber-100 text-amber-700' : 'bg-blue-100 text-blue-700' }}">
                        {{ $quiz->isFinalQuiz() ? 'FINAL' : 'KUIS' }}
                    </div>
                    <div>
                        <div class="flex items-center gap-2 mb-0.5">
                            <h3 class="font-semibold text-slate-800 text-sm">{{ $quiz->title }}</h3>
                            @if(!$quiz->is_active)
                                <span class="text-xs px-2 py-0.5 bg-slate-100 text-slate-500 rounded-full">Non-aktif</span>
                            @endif
                        </div>
                        <p class="text-xs text-slate-500">
                            {{ $quiz->isFinalQuiz() ? ' Final Quiz (Ujian Akhir Course)' : ' Chapter Quiz: ' . ($quiz->chapter?->title ?? '-') }}
                        </p>
                        <div class="flex items-center gap-3 mt-1.5 text-xs text-slate-400">
                            <span>{{ $quiz->questions_count }} soal</span>
                            <span>·</span>
                            <span>Lulus: {{ $quiz->passing_score }}%</span>
                            <span>·</span>
                            <span>{{ $quiz->time_limit ? $quiz->time_limit . ' mnt' : 'Tanpa timer' }}</span>
                            <span>·</span>
                            <span>Max {{ $quiz->max_attempts }}× percobaan</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-2 shrink-0">
                    <a href="{{ route('quizzes.attempts', [$course, $quiz]) }}"
                       class="px-3 py-2 text-xs font-semibold text-indigo-600 hover:bg-indigo-50 border border-indigo-200 rounded-xl transition">
                        Hasil Peserta
                    </a>
                    <a href="{{ route('quizzes.edit', [$course, $quiz]) }}"
                       class="px-3 py-2 text-xs font-semibold text-blue-600 hover:bg-blue-50 border border-blue-200 rounded-xl transition">
                        Edit & Kelola Soal
                    </a>
                    <form action="{{ route('quizzes.destroy', [$course, $quiz]) }}" method="POST"
                          onsubmit="return confirm('Hapus quiz ini?')">
                        @csrf @method('DELETE')
                        <button class="px-3 py-2 text-xs font-semibold text-red-500 hover:bg-red-50 border border-red-200 rounded-xl transition">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    @endif

</div>
</x-app-layout>
