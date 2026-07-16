@section('topbar_title', 'Silabus Pembelajaran')

<x-app-layout>
    <div class="py-6 select-none">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="mb-2">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center text-xs font-bold text-gray-500 hover:text-blue-600 transition">
                    Kembali ke Dashboard
                </a>
            </div>

            @if (session('error'))
                <div class="rounded-xl border border-rose-100 bg-rose-50 p-4 text-xs font-semibold text-rose-700">
                    {{ session('error') }}
                </div>
            @endif

            <section class="relative rounded-2xl overflow-hidden bg-gradient-to-r from-slate-900 via-slate-800 to-indigo-950 p-8 md:p-10 shadow-sm border border-slate-800">
                <div class="absolute inset-0 opacity-15 bg-[radial-gradient(#4f46e5_1px,transparent_1px)] [background-size:16px_16px] pointer-events-none"></div>
                <div class="relative z-10 space-y-3">
                    <span class="inline-flex items-center rounded-full bg-blue-500/10 px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-blue-400 border border-blue-500/20">
                        Buku Panduan Teknis
                    </span>
                    <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight text-white leading-tight">
                        {{ $course->title }}
                    </h1>
                    <p class="text-xs md:text-sm leading-relaxed text-slate-300 max-w-3xl">
                        {{ $course->description }}
                    </p>
                </div>
            </section>

            <div class="grid gap-6 lg:grid-cols-12">
                <div class="lg:col-span-8 space-y-4">
                    <div class="border-b border-[#f0f0f0] pb-3 mb-5">
                        <h2 class="text-base font-bold text-slate-800">Daftar Bab & Pembelajaran</h2>
                        <p class="text-xs text-slate-400 mt-0.5">Selesaikan semua topik pada sebuah bab untuk membuka bab berikutnya.</p>
                    </div>

                    <div class="space-y-4">
                        @foreach ($course->chapters as $chapter)
                            @php
                                $hasDiagram = ($chapter->order === 1 || $chapter->order === 7);
                                $chapterProgress = $learningProgress ? $learningProgress['chapters']->firstWhere('id', $chapter->id) : null;
                                $isLocked = $chapterProgress ? ! $chapterProgress['is_unlocked'] : false;
                                $missingModule = $chapterProgress ? $chapterProgress['missing_modules']->first() : null;
                            @endphp

                            <article class="rounded-xl border {{ $isLocked ? 'border-slate-100 bg-slate-50/70' : 'border-[#f0f0f0] bg-white hover:border-blue-200 hover:shadow-sm' }} p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-5 transition duration-150">
                                <div class="space-y-2">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span class="inline-flex rounded-full bg-slate-100 px-2.5 py-0.5 text-[9px] font-bold text-slate-500 tracking-wider">
                                            BAB {{ $chapter->order }}
                                        </span>

                                        <span class="inline-flex rounded-full {{ $hasDiagram ? 'bg-blue-50 text-blue-600 border-blue-100' : 'bg-slate-50 text-slate-400 border-slate-100' }} px-2.5 py-0.5 text-[9px] font-bold border tracking-wider">
                                            {{ $hasDiagram ? 'Diagram Interaktif' : 'Modul Pembelajaran' }}
                                        </span>

                                        @if($chapterProgress)
                                            <span class="inline-flex rounded-full {{ $isLocked ? 'bg-slate-100 text-slate-400 border-slate-200' : ($chapterProgress['is_complete'] ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-amber-50 text-amber-600 border-amber-100') }} px-2.5 py-0.5 text-[9px] font-bold border tracking-wider">
                                                {{ $isLocked ? 'Terkunci' : $chapterProgress['percent'].'%' }}
                                            </span>
                                        @endif
                                    </div>

                                    <h3 class="text-sm font-bold text-slate-800 leading-snug">
                                        {{ str_replace("BAB {$chapter->order}: ", '', $chapter->title) }}
                                    </h3>

                                    <p class="text-2xs text-slate-400 leading-normal">
                                        Berisi {{ $chapter->modules_count }} topik pembahasan utama beserta materi evaluasi mandiri.
                                    </p>

                                    @if($chapterProgress && ! $chapterProgress['is_complete'])
                                        <p class="text-[10px] font-semibold {{ $isLocked ? 'text-slate-400' : 'text-amber-600' }}">
                                            {{ $isLocked ? 'Selesaikan semua materi BAB sebelumnya untuk membuka bab ini.' : 'Lengkapi pembelajaran BAB '.$chapter->order.' untuk module '.($missingModule->title ?? '-').'.' }}
                                        </p>
                                    @endif
                                </div>

                                <div class="shrink-0 flex items-center justify-end gap-2 border-t sm:border-t-0 border-[#f0f0f0] pt-3 sm:pt-0">
                                    @if($isLocked)
                                        <span class="inline-flex items-center justify-center rounded-lg bg-slate-200 px-4 py-2 text-xs font-bold text-slate-500">
                                            Terkunci
                                        </span>
                                    @else
                                        {{-- Tombol Bank Soal untuk instruktur --}}
                                        @if(auth()->user()->isInstruktur())
                                            <a href="{{ route('questions.index', [$course->id, $chapter->id]) }}"
                                               class="inline-flex items-center justify-center rounded-lg bg-indigo-50 hover:bg-indigo-100 border border-indigo-200 px-3 py-2 text-xs font-bold text-indigo-700 transition"
                                               title="Kelola bank soal chapter ini">
                                                Bank Soal
                                            </a>
                                        @endif
                                        <a href="{{ route('courses.chapters.show', [$course->id, $chapter->id]) }}" class="inline-flex items-center justify-center rounded-lg bg-blue-600 hover:bg-blue-700 px-4 py-2 text-xs font-bold text-white transition shadow-sm">
                                            Buka Bab
                                        </a>
                                    @endif
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>

                <div class="lg:col-span-4 space-y-6">
                    @if(!auth()->user()->isInstruktur())
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6 border-b border-gray-100">
                            <h3 class="text-sm font-bold text-slate-800">Petunjuk Belajar</h3>
                            <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                Bab berikutnya terbuka setelah seluruh topik pada bab sebelumnya dibaca.
                            </p>
                        </div>

                        <div class="p-6 space-y-3">
                            @if($learningProgress)
                                <div class="rounded-xl bg-emerald-50 border border-emerald-100 p-4">
                                    <p class="text-xs font-semibold text-emerald-700">Progress materi</p>
                                    <p class="text-[11px] leading-relaxed text-emerald-600 mt-1">{{ $learningProgress['percent'] }}% dari seluruh materi sudah dipelajari.</p>
                                </div>
                            @endif

                            <div class="rounded-xl bg-slate-50 border border-slate-100 p-4">
                                <p class="text-xs font-semibold text-slate-700">Alur belajar</p>
                                <p class="text-[11px] leading-relaxed text-slate-500 mt-1">Mulai dari Bab 1, lalu lanjutkan ke bab berikutnya sesuai urutan.</p>
                            </div>

                            <div class="rounded-xl bg-blue-50 border border-blue-100 p-4">
                                <p class="text-xs font-semibold text-blue-700">Diagram interaktif</p>
                                <p class="text-[11px] leading-relaxed text-blue-600 mt-1">Klik hotspot atau tombol topik untuk menandai materi sebagai sudah dibaca.</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Panel Instruktur: Manajemen Quiz --}}
                    @if(auth()->user()->isInstruktur())
                    <div class="bg-white rounded-2xl shadow-sm border border-indigo-100 overflow-hidden">
                        <div class="p-6 border-b border-indigo-50">
                            <h3 class="text-sm font-bold text-slate-800">Manajemen Quiz</h3>
                            <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                Kelola Bank Soal, Quiz, dan Ujian untuk course ini.
                            </p>
                        </div>
                        <div class="p-6 space-y-2">
                            <a href="{{ route('quizzes.index', $course) }}"
                               class="flex items-center justify-center gap-2 w-full px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                Lihat Semua Quiz
                            </a>
                            <a href="{{ route('quizzes.create', $course) }}"
                               class="flex items-center justify-center gap-2 w-full px-4 py-2.5 bg-white hover:bg-indigo-50 border border-indigo-200 text-indigo-700 text-xs font-bold rounded-xl transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Buat Quiz Baru
                            </a>
                        </div>
                    </div>
                    <div class="bg-white rounded-2xl shadow-sm border border-violet-100 overflow-hidden mt-4">
                        <div class="p-6 border-b border-violet-50">
                            <h3 class="text-sm font-bold text-slate-800">Manajemen Latihan</h3>
                            <p class="text-xs text-slate-500 mt-1 leading-relaxed">Kelola latihan tiap chapter menggunakan bank soal yang sama.</p>
                        </div>
                        <div class="p-6 space-y-2">
                            <a href="{{ route('practices.index', $course) }}" class="flex items-center justify-center gap-2 w-full px-4 py-2.5 bg-violet-600 hover:bg-violet-700 text-white text-xs font-bold rounded-xl transition">Lihat Semua Latihan</a>
                            <a href="{{ route('practices.create', $course) }}" class="flex items-center justify-center gap-2 w-full px-4 py-2.5 bg-white hover:bg-violet-50 border border-violet-200 text-violet-700 text-xs font-bold rounded-xl transition">+ Buat Latihan Baru</a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
