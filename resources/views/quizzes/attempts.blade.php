@section('topbar_title', 'Hasil Kuis Peserta — ' . $quiz->title)

<x-app-layout>
<div class="max-w-6xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <a href="{{ route('quizzes.index', $course) }}"
               class="inline-flex items-center text-xs font-bold text-slate-500 hover:text-blue-600 transition mb-2">
                ← Kembali ke Manajemen Quiz
            </a>
            <h1 class="text-xl font-bold text-slate-800">Hasil Kuis Peserta</h1>
            <p class="text-xs text-slate-500 mt-0.5">
                Quiz: <span class="font-semibold text-blue-600">{{ $quiz->title }}</span> · 
                Passing Score: <span class="font-semibold">{{ $quiz->passing_score }}%</span>
            </p>
        </div>
        @if($attempts->isNotEmpty())
            <a href="{{ route('quizzes.attempts.export', [$course, $quiz]) }}"
               class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow-sm transition">
                📥 Ekspor Rekap Nilai (CSV)
            </a>
        @endif
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm px-4 py-3 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    {{-- Table Card --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-slate-400 font-semibold text-xs uppercase tracking-wider">
                        <th class="px-6 py-4">Peserta</th>
                        <th class="px-6 py-4 text-center">Percobaan ke-</th>
                        <th class="px-6 py-4">Waktu Pengerjaan</th>
                        <th class="px-6 py-4 text-center">Skor / Nilai</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($attempts as $attempt)
                        <tr>
                            {{-- Peserta --}}
                            <td class="px-6 py-4">
                                <div class="font-semibold text-slate-800">{{ $attempt->user->name }}</div>
                                <div class="text-xs text-slate-400">{{ $attempt->user->email }}</div>
                            </td>
                            {{-- Percobaan ke- --}}
                            <td class="px-6 py-4 text-center font-semibold text-slate-600">
                                {{ $attempt->attempt_number }}
                            </td>
                            {{-- Waktu --}}
                            <td class="px-6 py-4 text-xs">
                                <div>Mulai: {{ $attempt->started_at->timezone('Asia/Jakarta')->format('d M Y H:i') }}</div>
                                @if($attempt->submitted_at)
                                    <div>Selesai: {{ $attempt->submitted_at->timezone('Asia/Jakarta')->format('d M Y H:i') }}</div>
                                    <div class="text-slate-400 mt-0.5">Durasi: {{ $attempt->getDurationLabel() }}</div>
                                @else
                                    <span class="text-amber-500 font-semibold">Sedang Dikerjakan</span>
                                @endif
                            </td>
                            {{-- Skor --}}
                            <td class="px-6 py-4 text-center font-bold text-base
                                @if($attempt->submitted_at)
                                    {{ $attempt->is_passed ? 'text-emerald-600' : 'text-red-500' }}
                                @else
                                    text-slate-400
                                @endif">
                                {{ $attempt->submitted_at ? number_format($attempt->score, 0) . '%' : '-' }}
                            </td>
                            {{-- Status --}}
                            <td class="px-6 py-4 text-center">
                                @if($attempt->submitted_at)
                                    <span class="px-2.5 py-1 rounded-full text-xs font-bold
                                        {{ $attempt->is_passed ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-600' }}">
                                        {{ $attempt->is_passed ? 'LULUS' : 'GAGAL' }}
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700">
                                        BERJALAN
                                    </span>
                                @endif
                            </td>
                            {{-- Aksi --}}
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <form action="{{ route('quizzes.attempts.destroy', [$course, $quiz, $attempt]) }}"
                                          method="POST"
                                          onsubmit="return confirm('Apakah Anda yakin ingin mereset percobaan ini? Seluruh jawaban dan nilai peserta untuk percobaan ini akan terhapus secara permanen, dan peserta akan diberikan kesempatan untuk mengerjakan ulang.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 text-xs font-bold rounded-lg border border-red-200 transition">
                                            Reset Percobaan
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400 italic">
                                Belum ada peserta yang mengerjakan kuis ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
</x-app-layout>
