@section('topbar_title', 'Latihan & Quiz')

<x-app-layout>
    @php
        $practiceActivities = $activities->filter(fn ($activity) => $activity->isPractice());
        $chapterQuizActivities = $activities->filter(fn ($activity) => ! $activity->isPractice() && ! $activity->isFinalQuiz());
        $finalQuizActivities = $activities->filter(fn ($activity) => ! $activity->isPractice() && $activity->isFinalQuiz());
    @endphp

    <div class="max-w-5xl mx-auto space-y-8">
        <div>
            <h1 class="text-xl font-bold text-slate-800">Latihan & Quiz</h1>
            <p class="text-sm text-slate-500">Pilih aktivitas pembelajaran pada {{ $course->title }}.</p>
        </div>

        @foreach ([
            ['title' => 'Latihan Chapter', 'description' => 'Latihan tidak memengaruhi progres atau sertifikat.', 'items' => $practiceActivities, 'theme' => 'violet'],
            ['title' => 'Quiz Chapter', 'description' => 'Quiz evaluasi pada masing-masing chapter.', 'items' => $chapterQuizActivities, 'theme' => 'blue'],
            ['title' => 'Final Quiz', 'description' => 'Ujian akhir course hanya tersedia di halaman ini.', 'items' => $finalQuizActivities, 'theme' => 'amber'],
        ] as $section)
            <section class="rounded-2xl border border-slate-100 bg-white shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-100 {{ $section['theme'] === 'violet' ? 'bg-violet-50' : ($section['theme'] === 'amber' ? 'bg-amber-50' : 'bg-blue-50') }}">
                    <h2 class="text-sm font-bold {{ $section['theme'] === 'violet' ? 'text-violet-700' : ($section['theme'] === 'amber' ? 'text-amber-700' : 'text-blue-700') }}">{{ $section['title'] }}</h2>
                    <p class="text-xs text-slate-500 mt-0.5">{{ $section['description'] }}</p>
                </div>
                <div class="p-4 space-y-3">
                    @forelse ($section['items'] as $activity)
                        @php $attempt = $lastAttempts->get($activity->id); @endphp
                        <div class="border border-slate-100 rounded-xl p-4 flex flex-col sm:flex-row gap-3 sm:items-center justify-between">
                            <div>
                                <p class="text-xs text-slate-400">{{ $activity->chapter?->title ?? 'Ujian akhir course' }}</p>
                                <h3 class="font-semibold text-slate-800 mt-1">{{ $activity->title }}</h3>
                                <p class="text-xs text-slate-500 mt-1">{{ $activity->questions_count }} soal · @if($attempt) Nilai terakhir: <b>{{ number_format($attempt->score, 0) }}%</b> @else Belum dikerjakan @endif</p>
                            </div>
                            <a href="{{ route($activity->isPractice() ? 'practice.start' : 'quiz.start', [$course, $activity]) }}" class="shrink-0 px-4 py-2 text-xs font-bold text-white rounded-xl {{ $section['theme'] === 'violet' ? 'bg-violet-600' : ($section['theme'] === 'amber' ? 'bg-amber-500' : 'bg-blue-600') }}">
                                {{ $attempt && $activity->isPractice() ? 'Latihan Lagi' : 'Mulai' }}
                            </a>
                        </div>
                    @empty
                        <div class="py-4 text-center text-xs text-slate-400">Belum ada {{ strtolower($section['title']) }} aktif.</div>
                    @endforelse
                </div>
            </section>
        @endforeach
    </div>
</x-app-layout>
