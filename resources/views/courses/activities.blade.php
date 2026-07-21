@section('topbar_title', $pageTitle)

<x-app-layout>
    <div class="max-w-5xl mx-auto space-y-8">
        <div>
            <h1 class="text-xl font-bold text-slate-800">{{ $pageTitle }}</h1>
            <p class="text-base text-slate-500">{{ __('Pilih aktivitas pembelajaran pada') }} {{ $course->title }}.</p>
        </div>

        @foreach ($sections as $section)
            <section class="rounded-2xl border border-slate-100 bg-white shadow-sm overflow-hidden">
                @if($section['theme'] === 'violet')
                    <div class="px-5 py-4 border-b border-slate-100 bg-violet-50">
                        <h2 class="text-base font-bold text-violet-700">{{ $section['title'] }}</h2>
                        <p class="text-sm text-slate-500 mt-0.5">{{ $section['description'] }}</p>
                    </div>
                @elseif($section['theme'] === 'amber')
                    <div class="px-5 py-4 border-b border-slate-100 bg-amber-50">
                        <h2 class="text-base font-bold text-amber-700">{{ $section['title'] }}</h2>
                        <p class="text-sm text-slate-500 mt-0.5">{{ $section['description'] }}</p>
                    </div>
                @else
                    <div class="px-5 py-4 border-b border-slate-100 bg-blue-50">
                        <h2 class="text-base font-bold text-blue-700">{{ $section['title'] }}</h2>
                        <p class="text-sm text-slate-500 mt-0.5">{{ $section['description'] }}</p>
                    </div>
                @endif

                <div class="p-4 space-y-3">
                    @forelse ($section['items'] as $activity)
                        @php $attempt = $lastAttempts->get($activity->id); @endphp
                        <div class="border border-slate-100 rounded-xl p-4 flex flex-col sm:flex-row gap-3 sm:items-center justify-between">
                            <div>
                                <p class="text-sm text-slate-400">{{ $activity->chapter?->title ?? __('Ujian akhir course') }}</p>
                                <h3 class="font-semibold text-slate-800 mt-1">{{ $activity->title }}</h3>
                                 <p class="text-sm text-slate-500 mt-1">
                                    {{ $activity->questions_count }} {{ __('soal') }} ·
                                    @if($attempt)
                                        @if($attempt->grading_status === 'pending_essay')
                                            <span class="text-orange-600 font-semibold">{{ __('Menunggu penilaian') }}</span>
                                        @else
                                            {{ __('Nilai terakhir:') }} <b>{{ number_format($attempt->score, 0) }}%</b>
                                        @endif
                                    @else
                                        {{ __('Belum dikerjakan') }}
                                    @endif
                                </p>
                            </div>
                            @if($activity->isPractice())
                                <a href="{{ route('practice.start', [$course, $activity]) }}" class="shrink-0 px-4 py-2 text-sm font-bold text-white rounded-xl bg-violet-600 hover:bg-violet-700 transition">
                                    {{ $attempt ? __('Latihan Lagi') : __('Mulai') }}
                                </a>
                            @elseif($activity->isFinalQuiz())
                                @if($attempt)
                                    <a href="{{ route('quiz.result', [$course, $activity]) }}" class="shrink-0 px-4 py-2 text-sm font-bold text-white rounded-xl bg-amber-500 hover:bg-amber-600 transition">
                                        {{ __('Lihat Hasil') }}
                                    </a>
                                @else
                                    <a href="{{ route('quiz.start', [$course, $activity]) }}" class="shrink-0 px-4 py-2 text-sm font-bold text-white rounded-xl bg-amber-500 hover:bg-amber-600 transition">
                                        {{ __('Mulai') }}
                                    </a>
                                @endif
                            @else
                                @if($attempt)
                                    <a href="{{ route('quiz.result', [$course, $activity]) }}" class="shrink-0 px-4 py-2 text-sm font-bold text-white rounded-xl bg-blue-600 hover:bg-blue-700 transition">
                                        {{ __('Lihat Hasil') }}
                                    </a>
                                @else
                                    <a href="{{ route('quiz.start', [$course, $activity]) }}" class="shrink-0 px-4 py-2 text-sm font-bold text-white rounded-xl bg-blue-600 hover:bg-blue-700 transition">
                                        {{ __('Mulai') }}
                                    </a>
                                @endif
                            @endif
                        </div>
                    @empty
                        <div class="py-4 text-center text-sm text-slate-400">{{ __('Belum ada') }} {{ strtolower($section['title']) }} {{ __('aktif.') }}</div>
                    @endforelse
                </div>
            </section>
        @endforeach
    </div>
</x-app-layout>
