@section('topbar_title', 'Hasil ' . ($isPractice ? 'Latihan' : 'Kuis') . ' Peserta — ' . $quiz->title)
<x-app-layout>
<div class="max-w-6xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex items-start justify-between gap-4">
        <div>
            <a href="{{ route($isPractice ? 'practices.index' : 'quizzes.index', $course) }}"
               class="inline-flex text-xs font-bold text-slate-500 hover:text-blue-600 transition mb-2">
                ← Kembali ke Manajemen {{ $isPractice ? 'Latihan' : 'Quiz' }}
            </a>
            <h1 class="text-xl font-bold text-slate-800">Hasil {{ $isPractice ? 'Latihan' : 'Kuis' }} Peserta</h1>
            <p class="text-xs text-slate-500 mt-1">
                {{ $isPractice ? 'Latihan' : 'Quiz' }}: <span class="font-semibold text-blue-600">{{ $quiz->title }}</span>
                @unless($isPractice) · Nilai lulus: {{ $quiz->passing_score }}% @endunless
            </p>
        </div>
        <div class="flex items-center gap-2">
            @if(!$isPractice && $attempts->isNotEmpty())
                <a href="{{ route('quizzes.attempts.export', [$course, $quiz]) }}"
                   class="px-4 py-2.5 bg-emerald-600 text-white text-xs font-bold rounded-xl hover:bg-emerald-700 transition">
                    Ekspor Rekap Nilai (CSV)
                </a>
            @endif
        </div>
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm px-4 py-3 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    {{-- Banner: ada esai yang butuh penilaian --}}
    @if(isset($pendingEssayCount) && $pendingEssayCount > 0)
        <div class="bg-orange-50 border border-orange-200 rounded-2xl p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center text-base shrink-0">✍️</div>
            <div class="flex-1">
                <p class="text-sm font-bold text-orange-800">{{ $pendingEssayCount }} percobaan menunggu penilaian esai</p>
                <p class="text-xs text-orange-700 mt-0.5">Klik tombol "Nilai Esai" di bawah untuk mulai menilai jawaban peserta.</p>
            </div>
        </div>
    @endif

    {{-- Tabel Attempts --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b text-slate-400 text-xs uppercase">
                        <th class="px-6 py-4">Peserta</th>
                        <th class="px-6 py-4 text-center">Percobaan</th>
                        <th class="px-6 py-4">Waktu Pengerjaan</th>
                        <th class="px-6 py-4 text-center">Skor / Nilai</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($attempts as $attempt)
                    <tr class="hover:bg-slate-50/50 transition">
                        {{-- Peserta --}}
                        <td class="px-6 py-4">
                            <div class="font-semibold text-slate-800">{{ $attempt->user->name }}</div>
                            <div class="text-xs text-slate-400">{{ $attempt->user->email }}</div>
                        </td>

                        {{-- Percobaan --}}
                        <td class="px-6 py-4 text-center text-slate-600">{{ $attempt->attempt_number }}</td>

                        {{-- Waktu --}}
                        <td class="px-6 py-4 text-xs text-slate-600">
                            Mulai: {{ $attempt->started_at->timezone('Asia/Jakarta')->format('d M Y H:i') }}
                            @if($attempt->submitted_at)
                                <br>Selesai: {{ $attempt->submitted_at->timezone('Asia/Jakarta')->format('d M Y H:i') }}
                                <br><span class="text-slate-400">Durasi: {{ $attempt->getDurationLabel() }}</span>
                            @else
                                <br><span class="text-amber-600 font-semibold">Sedang dikerjakan</span>
                            @endif
                        </td>

                        {{-- Skor --}}
                        <td class="px-6 py-4 text-center font-bold text-slate-700">
                            @if(!$attempt->submitted_at)
                                -
                            @elseif($attempt->isPendingEssay())
                                <span class="text-orange-500 text-xs">Menunggu esai</span>
                            @else
                                {{ number_format($attempt->score, 0) }}%
                            @endif
                        </td>

                        {{-- Status --}}
                        <td class="px-6 py-4 text-center">
                            @if(!$attempt->submitted_at)
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700">BERJALAN</span>
                            @elseif($attempt->isPendingEssay())
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-orange-100 text-orange-700">MENUNGGU PENILAIAN</span>
                            @elseif($isPractice)
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-violet-50 text-violet-700">SELESAI</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $attempt->is_passed ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-600' }}">
                                    {{ $attempt->is_passed ? 'LULUS' : 'GAGAL' }}
                                </span>
                            @endif
                        </td>

                        {{-- Aksi --}}
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                {{-- Tombol Nilai Esai --}}
                                @if($attempt->submitted_at && $attempt->isPendingEssay())
                                    <a href="{{ route($isPractice ? 'practices.attempts.grade' : 'quizzes.attempts.grade', [$course, $quiz, $attempt]) }}"
                                       class="px-3 py-1.5 bg-orange-500 text-white text-xs font-bold rounded-lg hover:bg-orange-600 transition inline-flex items-center gap-1">
                                         Nilai Esai
                                    </a>
                                @elseif($attempt->submitted_at && $attempt->grading_status === 'graded')
                                    <a href="{{ route($isPractice ? 'practices.attempts.grade' : 'quizzes.attempts.grade', [$course, $quiz, $attempt]) }}"
                                       class="px-3 py-1.5 bg-slate-100 text-slate-600 text-xs font-bold rounded-lg hover:bg-slate-200 transition inline-flex items-center gap-1">
                                         Lihat Esai
                                    </a>
                                @endif

                                {{-- Reset --}}
                                <form action="{{ route($isPractice ? 'practices.attempts.destroy' : 'quizzes.attempts.destroy', [$course, $quiz, $attempt]) }}"
                                      method="POST" onsubmit="return confirm('Reset percobaan ini? Nilai & jawaban akan dihapus.')">
                                    @csrf @method('DELETE')
                                    <button class="px-3 py-1.5 bg-red-50 text-red-600 text-xs font-bold rounded-lg border border-red-200 hover:bg-red-100 transition">
                                        Reset
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                            Belum ada peserta yang mengerjakan {{ $isPractice ? 'latihan' : 'kuis' }} ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
</x-app-layout>
