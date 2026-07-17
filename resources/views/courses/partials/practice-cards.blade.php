@if($practices->isNotEmpty())
<div class="mt-4 px-4 sm:px-0 space-y-3"><p class="text-sm font-bold text-violet-700 uppercase tracking-wider">Latihan Chapter</p>
@foreach($practices as $practice) @php($lastAttempt = $practiceAttempts->get($practice->id))
<div class="rounded-2xl border border-violet-200 bg-violet-50 p-4 flex items-center justify-between gap-3"><div><h3 class="text-base font-bold text-slate-800">{{ $practice->title }}</h3><p class="text-sm text-slate-500 mt-1">{{ $practice->questions_count }} soal · Tanpa timer · {{ $lastAttempt ? 'Nilai terakhir: ' . number_format($lastAttempt->score, 0) . '%' : 'Belum dikerjakan' }}</p></div>@if(auth()->user()->isPeserta())<a href="{{ route('practice.start', [$course, $practice]) }}" class="px-3 py-2 rounded-xl bg-violet-600 text-white text-sm font-bold">{{ $lastAttempt ? 'Latihan Lagi' : 'Mulai Latihan' }}</a>@else<a href="{{ route('practices.edit', [$course, $practice]) }}" class="px-3 py-2 rounded-xl border border-violet-300 text-violet-700 text-sm font-bold">Edit</a>@endif</div>
@endforeach</div>
@endif
