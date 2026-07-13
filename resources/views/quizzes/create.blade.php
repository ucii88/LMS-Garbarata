@section('topbar_title', 'Buat Quiz Baru')

<x-app-layout>
<div class="max-w-2xl mx-auto space-y-6">

    <div>
        <a href="{{ route('quizzes.index', $course) }}"
           class="inline-flex items-center text-xs font-bold text-slate-500 hover:text-blue-600 transition mb-2">
            ← Kembali ke Daftar Quiz
        </a>
        <h1 class="text-xl font-bold text-slate-800">Buat Quiz Baru</h1>
        <p class="text-xs text-slate-500 mt-0.5">Course: <span class="font-semibold">{{ $course->title }}</span></p>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 md:p-8">
        <form action="{{ route('quizzes.store', $course) }}" method="POST" class="space-y-6">
            @csrf

            {{-- Judul --}}
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Judul Quiz <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title') }}" required
                       placeholder="cth: Quiz Chapter 1 — Pengenalan PBB"
                       class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Deskripsi --}}
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Deskripsi <span class="text-slate-400">(opsional)</span></label>
                <textarea name="description" rows="2"
                          placeholder="Penjelasan singkat tentang quiz ini..."
                          class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none resize-none">{{ old('description') }}</textarea>
            </div>

            {{-- Penempatan Quiz --}}
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-2">Penempatan Quiz <span class="text-red-500">*</span></label>
                <div class="space-y-2">
                    <label class="flex items-start gap-3 p-3.5 border-2 rounded-xl cursor-pointer transition has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 border-slate-200">
                        <input type="radio" name="placement" value="chapter" class="mt-0.5" {{ old('chapter_id') ? 'checked' : '' }}
                               onchange="document.getElementById('chapter-select').classList.remove('hidden')">
                        <div>
                            <p class="text-sm font-semibold text-slate-700">📌 Chapter Quiz</p>
                            <p class="text-xs text-slate-500">Quiz muncul di akhir chapter tertentu</p>
                        </div>
                    </label>
                    <label class="flex items-start gap-3 p-3.5 border-2 rounded-xl cursor-pointer transition has-[:checked]:border-amber-500 has-[:checked]:bg-amber-50 border-slate-200">
                        <input type="radio" name="placement" value="final" class="mt-0.5" {{ !old('chapter_id') ? 'checked' : '' }}
                               onchange="document.getElementById('chapter-select').classList.add('hidden')">
                        <div>
                            <p class="text-sm font-semibold text-slate-700">🏆 Final Quiz</p>
                            <p class="text-xs text-slate-500">Ujian akhir course, muncul setelah semua chapter selesai. Soal bisa diambil dari semua chapter.</p>
                        </div>
                    </label>
                </div>

                {{-- Pilih Chapter --}}
                <div id="chapter-select" class="{{ old('chapter_id') ? '' : 'hidden' }} mt-3">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Pilih Chapter</label>
                    <select name="chapter_id"
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="">-- Pilih Chapter --</option>
                        @foreach($chapters as $chapter)
                            <option value="{{ $chapter->id }}" {{ old('chapter_id') == $chapter->id ? 'selected' : '' }}>
                                {{ $chapter->order }}. {{ $chapter->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('chapter_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Kebijakan Hasil Ujian --}}
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-2">Kebijakan Hasil Kuis (Review Peserta) <span class="text-red-500">*</span></label>
                <select name="review_policy" required
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    <option value="show_all" {{ old('review_policy', 'show_all') == 'show_all' ? 'selected' : '' }}>Tampilkan Semua (Poin, Jawaban Benar/Salah & Penjelasan)</option>
                    <option value="points_only" {{ old('review_policy') == 'points_only' ? 'selected' : '' }}>Hanya Tampilkan Skor & Poin Per Soal (Sembunyikan Kunci Jawaban)</option>
                    <option value="hide_all" {{ old('review_policy') == 'hide_all' ? 'selected' : '' }}>Sembunyikan Detail Jawaban Sepenuhnya (Hanya Tampilkan Skor Akhir)</option>
                </select>
                <p class="text-2xs text-slate-400 mt-1">Mengontrol apa saja yang dapat dilihat oleh peserta setelah mengirimkan (submit) kuis.</p>
            </div>

            {{-- Jadwal Kuis --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Dibuka Pada <span class="text-slate-400">(opsional)</span></label>
                    <input type="datetime-local" name="start_time" value="{{ old('start_time') }}"
                           class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    <p class="text-2xs text-slate-400 mt-1">Kosongkan jika kuis bisa diakses kapan saja.</p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Ditutup Pada <span class="text-slate-400">(opsional)</span></label>
                    <input type="datetime-local" name="end_time" value="{{ old('end_time') }}"
                           class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    <p class="text-2xs text-slate-400 mt-1">Batas akhir pengerjaan kuis oleh peserta.</p>
                </div>
            </div>

            {{-- Konfigurasi --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Timer (menit)</label>
                    <input type="number" name="time_limit" value="{{ old('time_limit') }}" min="1" max="300"
                           placeholder="Kosongkan = tanpa timer"
                           class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nilai Kelulusan (%) <span class="text-red-500">*</span></label>
                    <input type="number" name="passing_score" value="{{ old('passing_score', 70) }}" min="1" max="100" required
                           class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Max Percobaan <span class="text-red-500">*</span></label>
                    <input type="number" name="max_attempts" value="{{ old('max_attempts', 1) }}" min="1" max="10" required
                           class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div class="flex flex-col justify-center gap-2 pt-4">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="shuffle_questions" value="1" {{ old('shuffle_questions') ? 'checked' : '' }}
                               class="w-4 h-4 rounded text-blue-600">
                        <span class="text-xs font-semibold text-slate-700">Acak urutan soal</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="shuffle_options" value="1" {{ old('shuffle_options') ? 'checked' : '' }}
                               class="w-4 h-4 rounded text-blue-600">
                        <span class="text-xs font-semibold text-slate-700">Acak pilihan jawaban</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" checked
                               class="w-4 h-4 rounded text-blue-600">
                        <span class="text-xs font-semibold text-slate-700">Aktifkan quiz</span>
                    </label>
                </div>
            </div>

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 text-xs px-4 py-3 rounded-xl">
                    @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
                </div>
            @endif

            <div class="flex justify-end gap-3 pt-2 border-t border-slate-100">
                <a href="{{ route('quizzes.index', $course) }}"
                   class="px-4 py-2 text-sm font-semibold text-slate-600 hover:text-slate-800 transition">
                    Batal
                </a>
                <button type="submit"
                        class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition">
                    Simpan & Pilih Soal →
                </button>
            </div>
        </form>
    </div>

</div>

<script>
    // Sync radio placement dengan hidden chapter_id
    document.querySelectorAll('input[name=placement]').forEach(radio => {
        radio.addEventListener('change', function() {
            const select = document.getElementById('chapter-select');
            if (this.value === 'chapter') {
                select.classList.remove('hidden');
            } else {
                select.classList.add('hidden');
                document.querySelector('select[name=chapter_id]').value = '';
            }
        });
    });

    // Set default state
    const defaultFinal = document.querySelector('input[name=placement][value=final]');
    if (defaultFinal && defaultFinal.checked) {
        document.getElementById('chapter-select').classList.add('hidden');
    }
</script>
</x-app-layout>
