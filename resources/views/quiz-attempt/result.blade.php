@section('topbar_title', 'Hasil Quiz — ' . $quiz->title)

<x-app-layout>
<div class="max-w-3xl mx-auto space-y-6">

    {{-- Result Hero Card --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="h-2 {{ $attempt->is_passed ? 'bg-gradient-to-r from-emerald-400 to-teal-500' : 'bg-gradient-to-r from-red-400 to-rose-500' }}"></div>

        <div class="p-6 md:p-8 text-center">
            <h1 class="text-2xl font-bold {{ $attempt->is_passed ? 'text-emerald-700' : 'text-red-600' }}">
                {{ $attempt->is_passed ? 'Selamat, Kamu Lulus!' : 'Belum Lulus' }}
            </h1>
            <p class="text-slate-500 text-sm mt-1">{{ $quiz->title }}</p>

            {{-- Skor Besar --}}
            <div class="my-6">
                <div class="inline-flex items-center justify-center w-28 h-28 rounded-full border-4 {{ $attempt->is_passed ? 'border-emerald-500' : 'border-red-400' }} bg-white shadow-sm">
                    <span class="text-3xl font-bold {{ $attempt->is_passed ? 'text-emerald-600' : 'text-red-500' }}">
                        {{ number_format($attempt->score, 0) }}
                    </span>
                </div>
                <p class="text-xs text-slate-400 mt-2">dari 100 poin · Nilai lulus: {{ $quiz->passing_score }}</p>
            </div>
            
            {{-- Stats --}}
            <div class="grid grid-cols-3 gap-4 max-w-xs mx-auto">
                @php
                    $correctCount   = $attempt->answers->where('is_correct', true)->count();
                    $incorrectCount = $attempt->answers->where('is_correct', false)->count();
                    $totalCount     = $attempt->answers->count();
                @endphp
                <div class="text-center">
                    <div class="text-lg font-bold text-emerald-600">{{ $correctCount }}</div>
                    <div class="text-xs text-slate-500">Benar</div>
                </div>
                <div class="text-center">
                    <div class="text-lg font-bold text-red-500">{{ $incorrectCount }}</div>
                    <div class="text-xs text-slate-500">Salah</div>
                </div>
                <div class="text-center">
                    <div class="text-lg font-bold text-slate-600">{{ $attempt->getDurationLabel() }}</div>
                    <div class="text-xs text-slate-500">Waktu</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Sertifikat (jika ada) --}}
    @if($certificate)
        <div class="bg-gradient-to-r from-amber-50 to-yellow-50 border border-amber-200 rounded-2xl p-5 flex items-center gap-4">
            <div class="w-10 h-10 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center font-bold text-xs shrink-0">
                CERT
            </div>
            <div class="flex-1">
                <h3 class="font-bold text-amber-800">Sertifikat Diterbitkan!</h3>
                <p class="text-xs text-amber-700 mt-0.5">
                    Kamu telah menyelesaikan semua quiz dalam course ini. Sertifikatmu sudah siap!
                </p>
            </div>
            <a href="{{ route('certificate.show', $certificate) }}"
               class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-bold rounded-xl transition shrink-0">
                Lihat Sertifikat
            </a>
        </div>
    @endif

    {{-- Tombol Aksi --}}
    <div class="flex gap-3">
        <a href="{{ route('courses.chapters.show', [$course, $quiz->chapter_id ?? $course->chapters->first()->id]) }}"
           class="flex-1 text-center py-2.5 text-sm font-semibold text-slate-600 border border-slate-200 rounded-xl hover:bg-slate-50 transition">
            ← Kembali ke Materi
        </a>
        @if(!$attempt->is_passed && $quiz->canAttempt(auth()->id()))
            <a href="{{ route('quiz.start', [$course, $quiz]) }}"
               class="flex-1 text-center py-2.5 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition">
                Coba Lagi
            </a>
        @endif
    </div>

    {{-- Review per Soal --}}
    <div class="space-y-4">
        <h2 class="text-base font-bold text-slate-800">Review Jawaban</h2>

        @if($quiz->review_policy === 'hide_all')
            <div class="bg-white border border-slate-100 rounded-2xl p-6 text-center text-slate-500 italic text-xs">
                Detail review jawaban untuk kuis ini dinonaktifkan oleh instruktur.
            </div>
        @elseif($quiz->review_policy === 'points_only')
            @foreach($attempt->answers->sortBy('question_id') as $i => $answer)
            @php $question = $answer->question; @endphp
            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="flex items-center gap-2 px-5 py-3 bg-slate-50">
                    <span class="text-sm font-bold text-slate-700">
                        Soal {{ $i + 1 }}
                    </span>
                    <span class="text-xs text-slate-500">·</span>
                    <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-white/60
                        @switch($question->type)
                            @case('multiple_choice') text-indigo-700 @break
                            @case('true_false') text-green-700 @break
                            @case('fill_blank') text-amber-700 @break
                            @case('matching') text-purple-700 @break
                            @case('ordering') text-rose-700 @break
                        @endswitch">
                        {{ $question->type_label }}
                    </span>
                    <span class="ml-auto text-xs font-semibold text-slate-600">
                        @if($question->type === 'matching' || $question->type === 'ordering')
                            +{{ number_format($answer->points_earned, 0) }} / {{ $question->options->count() * $question->points }} poin
                        @else
                            +{{ number_format($answer->points_earned, 0) }} / {{ $question->points }} poin
                        @endif
                    </span>
                </div>
                <div class="p-5 space-y-3">
                    <p class="text-sm font-medium text-slate-800">{!! nl2br(e($question->question_text)) !!}</p>
                    @if($question->question_image)
                        <img src="{{ Storage::url($question->question_image) }}"
                             alt="Gambar Soal"
                             class="mt-2 max-h-48 rounded-xl border border-slate-100 object-contain">
                    @endif

                    {{-- Jawaban user --}}
                    <div class="text-sm">
                        @if($question->type === 'multiple_choice' || $question->type === 'true_false')
                            <span class="text-xs font-semibold text-slate-500">Jawabanmu: </span>
                            <span class="text-slate-700 font-medium">
                                {{ $answer->selectedOption?->option_text ?? 'Tidak dijawab' }}
                            </span>
                        @elseif($question->type === 'fill_blank')
                            <span class="text-xs font-semibold text-slate-500">Jawabanmu: </span>
                            <span class="text-slate-700 font-medium">
                                {{ $answer->text_answer ?? 'Tidak dijawab' }}
                            </span>
                        @elseif($question->type === 'matching')
                            <span class="text-xs font-semibold text-slate-500 block mb-1">Jawabanmu (Mencocokkan):</span>
                            <div class="space-y-1 pl-3 border-l-2 border-slate-200 text-xs">
                                @php $userMatch = $answer->order_answer ?? []; @endphp
                                @foreach($question->options as $option)
                                    @php
                                        $userChoice = $userMatch[$option->id] ?? 'Tidak dijawab';
                                    @endphp
                                    <div class="flex items-center gap-2">
                                        <span class="text-slate-600 font-medium">{{ $option->option_text }}</span>
                                        <span class="text-slate-400">→</span>
                                        <span class="text-slate-700 font-medium">
                                            {{ $userChoice }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @elseif($question->type === 'ordering')
                            <span class="text-xs font-semibold text-slate-500 block mb-1">Jawabanmu (Urutan Langkah):</span>
                            <div class="space-y-1 pl-3 border-l-2 border-slate-200 text-xs">
                                @php
                                    $userOrder = $answer->order_answer ?? [];
                                @endphp
                                @forelse($userOrder as $j => $optId)
                                    @php
                                        $opt = $question->options->firstWhere('id', $optId);
                                    @endphp
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-slate-400 text-[10px]">Langkah {{ $j + 1 }}:</span>
                                        <span class="text-slate-700 font-medium">
                                            {{ $opt?->option_text ?? 'Tidak diisi' }}
                                        </span>
                                    </div>
                                @empty
                                    <span class="text-slate-500 font-medium">Tidak diisi</span>
                                @endforelse
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        @else
            @foreach($attempt->answers->sortBy('question_id') as $i => $answer)
            @php $question = $answer->question; @endphp
            <div class="bg-white border rounded-2xl shadow-sm overflow-hidden
                {{ $answer->is_correct ? 'border-emerald-200' : 'border-red-200' }}">
                <div class="flex items-center gap-2 px-5 py-3 {{ $answer->is_correct ? 'bg-emerald-50' : 'bg-red-50' }}">
                    <span class="text-sm font-bold {{ $answer->is_correct ? 'text-emerald-700' : 'text-red-600' }}">
                        [{{ $answer->is_correct ? 'Benar' : 'Salah' }}] Soal {{ $i + 1 }}
                    </span>
                    <span class="text-xs text-slate-500">·</span>
                    <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-white/60
                        @switch($question->type)
                            @case('multiple_choice') text-indigo-700 @break
                            @case('true_false') text-green-700 @break
                            @case('fill_blank') text-amber-700 @break
                            @case('matching') text-purple-700 @break
                            @case('ordering') text-rose-700 @break
                        @endswitch">
                        {{ $question->type_label }}
                    </span>
                    <span class="ml-auto text-xs font-semibold {{ $answer->is_correct ? 'text-emerald-700' : 'text-red-500' }}">
                        @if($question->type === 'matching' || $question->type === 'ordering')
                            +{{ number_format($answer->points_earned, 0) }} / {{ $question->options->count() * $question->points }} poin
                        @else
                            +{{ number_format($answer->points_earned, 0) }} / {{ $question->points }} poin
                        @endif
                    </span>
                </div>
                <div class="p-5 space-y-3">
                    <p class="text-sm font-medium text-slate-800">{!! nl2br(e($question->question_text)) !!}</p>
                    @if($question->question_image)
                        <img src="{{ Storage::url($question->question_image) }}"
                             alt="Gambar Soal"
                             class="mt-2 max-h-48 rounded-xl border border-slate-100 object-contain">
                    @endif

                    {{-- Jawaban user --}}
                    <div class="text-sm">
                        @if($question->type === 'multiple_choice' || $question->type === 'true_false')
                            <span class="text-xs font-semibold text-slate-500">Jawabanmu: </span>
                            <span class="{{ $answer->is_correct ? 'text-emerald-700 font-semibold' : 'text-red-500 line-through' }}">
                                {{ $answer->selectedOption?->option_text ?? 'Tidak dijawab' }}
                            </span>
                        @elseif($question->type === 'fill_blank')
                            <span class="text-xs font-semibold text-slate-500">Jawabanmu: </span>
                            <span class="{{ $answer->is_correct ? 'text-emerald-700 font-semibold' : 'text-red-500 line-through' }}">
                                {{ $answer->text_answer ?? 'Tidak dijawab' }}
                            </span>
                        @elseif($question->type === 'matching')
                            <span class="text-xs font-semibold text-slate-500 block mb-1">Jawabanmu (Mencocokkan):</span>
                            <div class="space-y-1 pl-3 border-l-2 border-slate-200 text-xs">
                                @php $userMatch = $answer->order_answer ?? []; @endphp
                                @foreach($question->options as $option)
                                    @php
                                        $userChoice = $userMatch[$option->id] ?? 'Tidak dijawab';
                                        $isChoiceCorrect = $userChoice === $option->match_label;
                                    @endphp
                                    <div class="flex items-center gap-2">
                                        <span class="text-slate-600 font-medium">{{ $option->option_text }}</span>
                                        <span class="text-slate-400">→</span>
                                        <span class="{{ $isChoiceCorrect ? 'text-emerald-700 font-semibold' : 'text-red-500 font-medium' }}">
                                            {{ $userChoice }}
                                        </span>
                                        @if(!$isChoiceCorrect)
                                            <span class="text-slate-400 font-normal">(Seharusnya: <span class="text-emerald-700 font-semibold">{{ $option->match_label }}</span>)</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @elseif($question->type === 'ordering')
                            <span class="text-xs font-semibold text-slate-500 block mb-1">Jawabanmu (Urutan Langkah):</span>
                            <div class="space-y-1 pl-3 border-l-2 border-slate-200 text-xs">
                                @php
                                    $userOrder = $answer->order_answer ?? [];
                                    $correctOrder = $question->options->sortBy('order')->pluck('id')->toArray();
                                @endphp
                                @forelse($userOrder as $j => $optId)
                                    @php
                                        $opt = $question->options->firstWhere('id', $optId);
                                        $correctOpt = $question->options->firstWhere('id', $correctOrder[$j] ?? null);
                                        $isStepCorrect = $optId === ($correctOrder[$j] ?? null);
                                    @endphp
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-slate-400 text-[10px]">Langkah {{ $j + 1 }}:</span>
                                        <span class="{{ $isStepCorrect ? 'text-emerald-700 font-semibold' : 'text-red-500 font-medium' }}">
                                            {{ $opt?->option_text ?? 'Tidak diisi' }}
                                        </span>
                                        @if(!$isStepCorrect)
                                            <span class="text-slate-400 font-normal">(Seharusnya: <span class="text-emerald-700 font-semibold">{{ $correctOpt?->option_text }}</span>)</span>
                                        @endif
                                    </div>
                                @empty
                                    <span class="text-red-500 font-medium">Tidak diisi</span>
                                @endforelse
                            </div>
                        @endif
                    </div>

                    {{-- Jawaban benar (jika salah) --}}
                    @if(!$answer->is_correct && in_array($question->type, ['multiple_choice', 'true_false', 'fill_blank']))
                        <div class="text-sm">
                            <span class="text-xs font-semibold text-slate-500">Jawaban benar: </span>
                            <span class="text-emerald-700 font-semibold">
                                {{ $question->options->firstWhere('is_correct', true)?->option_text ?? '-' }}
                            </span>
                        </div>
                    @endif

                    {{-- Penjelasan --}}
                    @if($question->explanation)
                        <div class="text-xs bg-blue-50 border border-blue-100 rounded-lg px-3 py-2 text-blue-700">
                            <span class="font-semibold">Penjelasan:</span> {{ $question->explanation }}
                        </div>
                    @endif
                </div>
            </div>
            @endforeach
        @endif
    </div>

</div>
</x-app-layout>
