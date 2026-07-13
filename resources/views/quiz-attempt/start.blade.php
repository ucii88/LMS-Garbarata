@section('topbar_title', $quiz->title)

<x-app-layout>
<div class="max-w-2xl mx-auto space-y-6">

    {{-- Error Messages --}}
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 text-xs font-semibold px-4 py-3 rounded-xl shadow-sm">
            {{ $errors->first() }}
        </div>
    @endif

    {{-- Header Card --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        {{-- Banner --}}
        <div class="h-2 {{ $quiz->isFinalQuiz() ? 'bg-gradient-to-r from-amber-400 to-orange-500' : 'bg-gradient-to-r from-blue-500 to-indigo-600' }}"></div>

        <div class="p-6 md:p-8">
            <div class="flex items-start gap-4">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl shrink-0
                    {{ $quiz->isFinalQuiz() ? 'bg-amber-100' : 'bg-blue-100' }}">
                    {{ $quiz->isFinalQuiz() ? '🏆' : '📝' }}
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">
                        {{ $quiz->isFinalQuiz() ? 'Final Quiz — Ujian Akhir' : 'Chapter Quiz' }}
                    </p>
                    <h1 class="text-xl font-bold text-slate-800">{{ $quiz->title }}</h1>
                    @if($quiz->description)
                        <p class="text-sm text-slate-500 mt-1">{{ $quiz->description }}</p>
                    @endif
                </div>
            </div>

            {{-- Info Quiz --}}
            <div class="mt-6 grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div class="text-center p-3 bg-slate-50 rounded-xl">
                    <div class="text-lg font-bold text-slate-800">{{ $questionCount }}</div>
                    <div class="text-xs text-slate-500">Soal</div>
                </div>
                <div class="text-center p-3 bg-slate-50 rounded-xl">
                    <div class="text-lg font-bold text-slate-800">
                        {{ $quiz->time_limit ? $quiz->time_limit . ' mnt' : '∞' }}
                    </div>
                    <div class="text-xs text-slate-500">Waktu</div>
                </div>
                <div class="text-center p-3 bg-slate-50 rounded-xl">
                    <div class="text-lg font-bold text-slate-800">{{ $quiz->passing_score }}%</div>
                    <div class="text-xs text-slate-500">Nilai Lulus</div>
                </div>
                <div class="text-center p-3 bg-slate-50 rounded-xl">
                    <div class="text-lg font-bold {{ $canAttempt ? 'text-emerald-600' : 'text-red-500' }}">
                        {{ $quiz->max_attempts - $attemptCount }} / {{ $quiz->max_attempts }}
                    </div>
                    <div class="text-xs text-slate-500">Sisa Percobaan</div>
                </div>
            </div>

            {{-- Jadwal Akses Kuis --}}
            @if($quiz->start_time || $quiz->end_time)
                <div class="mt-4 p-4 rounded-xl border bg-slate-50 border-slate-200 text-xs space-y-1.5">
                    <p class="font-bold text-slate-700">📅 Jadwal Akses Kuis:</p>
                    @if($quiz->start_time)
                        <p class="text-slate-600">Dibuka: <span class="font-semibold text-slate-800">{{ $quiz->start_time->timezone('Asia/Jakarta')->format('d M Y H:i') }} WIB</span></p>
                    @endif
                    @if($quiz->end_time)
                        <p class="text-slate-600">Ditutup: <span class="font-semibold text-slate-800">{{ $quiz->end_time->timezone('Asia/Jakarta')->format('d M Y H:i') }} WIB</span></p>
                    @endif
                </div>
            @endif

            {{-- Hasil Terbaik (jika pernah coba) --}}
            @if($bestAttempt)
                <div class="mt-4 p-4 rounded-xl border {{ $bestAttempt->is_passed ? 'bg-emerald-50 border-emerald-200' : 'bg-red-50 border-red-200' }}">
                    <p class="text-xs font-semibold {{ $bestAttempt->is_passed ? 'text-emerald-700' : 'text-red-700' }}">
                        Percobaan Terakhir: Skor {{ number_format($bestAttempt->score, 0) }}% —
                        {{ $bestAttempt->is_passed ? '✅ Lulus' : '❌ Belum Lulus' }}
                    </p>
                </div>
            @endif

            {{-- Aturan --}}
            <div class="mt-5 p-4 bg-blue-50 border border-blue-100 rounded-xl space-y-1.5">
                <p class="text-xs font-bold text-blue-800">📋 Perhatikan sebelum mulai:</p>
                <ul class="text-xs text-blue-700 space-y-1 list-disc list-inside">
                    <li>Pastikan koneksi internet stabil selama mengerjakan.</li>
                    @if($quiz->time_limit)
                        <li>Quiz memiliki batas waktu {{ $quiz->time_limit }} menit — quiz otomatis submit jika waktu habis.</li>
                    @endif
                    <li>Kamu memiliki <strong>{{ $quiz->max_attempts }}× percobaan</strong>. Sudah digunakan: {{ $attemptCount }}×.</li>
                    <li>Nilai kelulusan minimum: <strong>{{ $quiz->passing_score }}%</strong>.</li>
                    @if($quiz->shuffle_questions)
                        <li>Urutan soal diacak setiap percobaan.</li>
                    @endif
                </ul>
            </div>

            {{-- Tombol Aksi --}}
            <div class="mt-6 flex gap-3">
                <a href="{{ route('courses.chapters.show', [$course, $quiz->chapter_id ?? $course->chapters->first()->id]) }}"
                   class="flex-1 text-center py-2.5 text-sm font-semibold text-slate-600 border border-slate-200 rounded-xl hover:bg-slate-50 transition">
                    ← Kembali
                </a>

                @if($quiz->availability_status === 'upcoming')
                    <div class="flex-1 text-center py-2.5 text-sm font-semibold text-slate-400 bg-slate-100 rounded-xl cursor-not-allowed">
                        🔒 Kuis Belum Dibuka
                    </div>
                @elseif($quiz->availability_status === 'closed')
                    <div class="flex-1 text-center py-2.5 text-sm font-semibold text-slate-400 bg-slate-100 rounded-xl cursor-not-allowed">
                        🔒 Kuis Sudah Ditutup
                    </div>
                @elseif($ongoingAttempt)
                    {{-- Lanjutkan attempt yang belum selesai --}}
                    <a href="{{ route('quiz.attempt', [$course, $quiz]) }}"
                       class="flex-1 text-center py-2.5 text-sm font-bold text-white bg-amber-500 hover:bg-amber-600 rounded-xl transition">
                        ⏱ Lanjutkan Quiz
                    </a>
                @elseif($canAttempt)
                    <form action="{{ route('quiz.begin', [$course, $quiz]) }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit"
                                class="w-full py-2.5 text-sm font-bold text-white
                                       {{ $quiz->isFinalQuiz() ? 'bg-amber-500 hover:bg-amber-600' : 'bg-blue-600 hover:bg-blue-700' }}
                                       rounded-xl transition">
                            {{ $attemptCount > 0 ? '🔄 Coba Lagi' : '🚀 Mulai Quiz' }}
                        </button>
                    </form>
                @else
                    <div class="flex-1 text-center py-2.5 text-sm font-semibold text-slate-400 bg-slate-100 rounded-xl cursor-not-allowed">
                        🔒 Batas Percobaan Habis
                    </div>
                @endif
            </div>
        </div>
    </div>

</div>
</x-app-layout>
