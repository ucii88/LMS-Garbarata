@section('topbar_title', $isPractice ? __('Buat Latihan Baru') : __('Buat Kuis Baru'))
<x-app-layout>
    <div class="max-w-2xl mx-auto space-y-6">
        <div>
            <a href="{{ route($isPractice ? 'practices.index' : 'quizzes.index', $course) }}" class="text-sm font-bold text-slate-500">{{ __('← Kembali') }}</a>
            <h1 class="text-xl font-bold text-slate-800 mt-2">{{ $isPractice ? __('Buat Latihan Baru') : __('Buat Kuis Baru') }}</h1>
        </div>

        @if ($errors->any())
            <div class="rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm font-semibold text-rose-700 space-y-1">
                @foreach ($errors->all() as $error)
                    <p>{{ __( $error ) }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route($isPractice ? 'practices.store' : 'quizzes.store', $course) }}" method="POST" class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-semibold mb-1">{{ __('Judul *') }}</label>
                <input name="title" required value="{{ old('title') }}" class="w-full border rounded-xl px-3 py-2.5 text-base">
            </div>
            <div>
                <label class="block text-sm font-semibold mb-1">{{ __('Deskripsi') }}</label>
                <textarea name="description" rows="2" class="w-full border rounded-xl px-3 py-2.5 text-base">{{ old('description') }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-semibold mb-1">{{ __('Chapter') }}</label>
                <select name="chapter_id" {{ $isPractice ? 'required' : '' }} class="w-full border rounded-xl px-3 py-2.5 text-base">
                    <option value="">{{ $isPractice ? __('-- Pilih chapter --') : __('Ujian (Akhir Course)') }}</option>
                    @foreach($chapters as $chapter)
                        <option value="{{ $chapter->id }}" @selected(old('chapter_id') == $chapter->id)>{{ $chapter->order }}. {{ $chapter->title }}</option>
                    @endforeach
                </select>
            </div>
            @if($isPractice)
                <input type="hidden" name="review_policy" value="show_all">
                <div>
                    <label class="block text-sm font-semibold mb-1">{{ __('Maks. percobaan (kosong = tanpa batas)') }}</label>
                    <input type="number" name="max_attempts" min="1" max="100" value="{{ old('max_attempts') }}" class="w-full border rounded-xl px-3 py-2.5 text-base">
                </div>
            @else
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-semibold mb-1">{{ __('Dibuka pada') }}</label>
                        <input type="datetime-local" name="start_time" value="{{ old('start_time') }}" class="w-full border rounded-xl px-3 py-2.5 text-base">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">{{ __('Ditutup pada') }}</label>
                        <input type="datetime-local" name="end_time" value="{{ old('end_time') }}" class="w-full border rounded-xl px-3 py-2.5 text-base">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-semibold mb-1">{{ __('Timer (menit)') }} <span class="text-gray-400 font-normal">— {{ __('kosong = tanpa batas') }}</span></label>
                        <input type="number" name="time_limit" min="1" max="300" value="{{ old('time_limit') }}" class="w-full border rounded-xl px-3 py-2.5 text-base">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">{{ __('Nilai lulus *') }}</label>
                        <input type="number" name="passing_score" required min="1" max="100" value="{{ old('passing_score', 70) }}" class="w-full border rounded-xl px-3 py-2.5 text-base">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1">{{ __('Maks. percobaan *') }}</label>
                    <input type="number" name="max_attempts" required min="1" max="10" value="{{ old('max_attempts', 1) }}" class="w-full border rounded-xl px-3 py-2.5 text-base">
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1">{{ __('Kebijakan Review Hasil') }}</label>
                    <select name="review_policy" class="w-full border rounded-xl px-3 py-2.5 text-base">
                        <option value="show_all" @selected(old('review_policy', 'show_all') === 'show_all')>{{ __('Tampilkan semua') }}</option>
                        <option value="points_only" @selected(old('review_policy') === 'points_only')>{{ __('Skor saja') }}</option>
                        <option value="hide_all" @selected(old('review_policy') === 'hide_all')>{{ __('Sembunyikan detail') }}</option>
                    </select>
                </div>
            @endif
            <div class="flex gap-4 text-sm">
                <label><input type="checkbox" name="shuffle_questions" value="1" @checked(old('shuffle_questions'))> {{ __('Acak soal') }}</label>
                <label><input type="checkbox" name="shuffle_options" value="1" @checked(old('shuffle_options'))> {{ __('Acak pilihan') }}</label>
            </div>
            <button class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-base font-bold transition shadow-sm">{{ __('Simpan & Lanjut ke Pilih Soal →') }}</button>
        </form>
    </div>
</x-app-layout>
