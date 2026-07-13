@section('topbar_title', 'Manajemen ' . ($isPractice ? 'Latihan' : 'Quiz'))
<x-app-layout>
<div class="max-w-5xl mx-auto space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div><h1 class="text-xl font-bold text-slate-800">Manajemen {{ $isPractice ? 'Latihan' : 'Quiz' }}</h1><p class="text-xs text-slate-500 mt-0.5">Course: <span class="font-semibold text-blue-600">{{ $course->title }}</span> — {{ $quizzes->count() }} {{ $isPractice ? 'latihan' : 'quiz' }}</p></div>
        <a href="{{ route($isPractice ? 'practices.create' : 'quizzes.create', $course) }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition">+ Buat {{ $isPractice ? 'Latihan' : 'Quiz' }} Baru</a>
    </div>
    @if(session('success')) <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm px-4 py-3 rounded-xl">{{ session('success') }}</div> @endif
    @forelse($quizzes as $quiz)
    <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-start gap-4"><div class="w-12 h-10 rounded-xl flex items-center justify-center text-[10px] font-bold tracking-wider shrink-0 {{ $isPractice ? 'bg-violet-100 text-violet-700' : ($quiz->isFinalQuiz() ? 'bg-amber-100 text-amber-700' : 'bg-blue-100 text-blue-700') }}">{{ $isPractice ? 'LATIHAN' : ($quiz->isFinalQuiz() ? 'FINAL' : 'KUIS') }}</div><div><h3 class="font-semibold text-slate-800 text-sm">{{ $quiz->title }}</h3><p class="text-xs text-slate-500">{{ $isPractice ? 'Latihan Chapter: ' . ($quiz->chapter?->title ?? '-') : ($quiz->isFinalQuiz() ? 'Final Quiz (Ujian Akhir Course)' : 'Chapter Quiz: ' . ($quiz->chapter?->title ?? '-')) }}</p><div class="flex items-center gap-3 mt-1.5 text-xs text-slate-400"><span>{{ $quiz->questions_count }} soal</span><span>·</span>@if($isPractice)<span>Tanpa timer · {{ $quiz->max_attempts ? 'Maks. ' . $quiz->max_attempts . ' percobaan' : 'Tanpa batas percobaan' }}</span>@else<span>Lulus: {{ $quiz->passing_score }}% · {{ $quiz->time_limit ? $quiz->time_limit . ' mnt' : 'Tanpa timer' }} · Maks. {{ $quiz->max_attempts }} percobaan</span>@endif</div></div></div>
        <div class="flex items-center gap-2 shrink-0"><a href="{{ route($isPractice ? 'practices.attempts' : 'quizzes.attempts', [$course, $quiz]) }}" class="px-3 py-2 text-xs font-semibold text-indigo-600 border border-indigo-200 rounded-xl">Hasil Peserta</a><a href="{{ route($isPractice ? 'practices.edit' : 'quizzes.edit', [$course, $quiz]) }}" class="px-3 py-2 text-xs font-semibold text-blue-600 border border-blue-200 rounded-xl">Edit & Soal</a><form action="{{ route($isPractice ? 'practices.destroy' : 'quizzes.destroy', [$course, $quiz]) }}" method="POST" onsubmit="return confirm('Hapus aktivitas ini?')">@csrf @method('DELETE')<button class="px-3 py-2 text-xs font-semibold text-red-500 border border-red-200 rounded-xl">Hapus</button></form></div>
    </div>
    @empty <div class="bg-white border border-dashed border-slate-200 rounded-2xl p-12 text-center text-sm text-slate-500">Belum ada {{ $isPractice ? 'latihan' : 'quiz' }}.</div>
    @endforelse
</div>
</x-app-layout>
