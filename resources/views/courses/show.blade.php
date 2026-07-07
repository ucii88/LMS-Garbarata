@section('topbar_title', 'Silabus Pembelajaran')

<x-app-layout>
    <div class="py-6 select-none">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="mb-2">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center text-xs font-bold text-gray-500 hover:text-blue-600 transition">
                    ← Kembali ke Dashboard
                </a>
            </div>

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
                        <p class="text-xs text-slate-400 mt-0.5">Selesaikan setiap bab secara berurutan sesuai kurikulum buku operasional.</p>
                    </div>

                    <div class="space-y-4">
                        @foreach ($course->chapters as $chapter)
                            @php
                                $hasDiagram = ($chapter->order === 1 || $chapter->order === 7);
                            @endphp
                            <article class="rounded-xl border border-[#f0f0f0] bg-white p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-5 hover:border-blue-200 hover:shadow-sm transition duration-150">
                                <div class="space-y-2">
                                    <div class="flex items-center space-x-2.5">
                                        <span class="inline-flex rounded-full bg-slate-100 px-2.5 py-0.5 text-[9px] font-bold text-slate-500 tracking-wider">
                                            BAB {{ $chapter->order }}
                                        </span>

                                        @if($hasDiagram)
                                            <span class="inline-flex rounded-full bg-blue-50 px-2.5 py-0.5 text-[9px] font-bold text-blue-600 border border-blue-100 tracking-wider">
                                                Diagram Interaktif
                                            </span>
                                        @else
                                            <span class="inline-flex rounded-full bg-slate-50 px-2.5 py-0.5 text-[9px] font-bold text-slate-400 border border-slate-100 tracking-wider">
                                                Modul Pembelajaran
                                            </span>
                                        @endif
                                    </div>

                                    <h3 class="text-sm font-bold text-slate-800 leading-snug">
                                        {{ str_replace("BAB {$chapter->order}: ", '', $chapter->title) }}
                                    </h3>

                                    <p class="text-2xs text-slate-400 leading-normal">
                                        Berisi {{ $chapter->modules_count }} topik pembahasan utama beserta materi evaluasi mandiri.
                                    </p>
                                </div>

                                <div class="shrink-0 flex items-center justify-end border-t sm:border-t-0 border-[#f0f0f0] pt-3 sm:pt-0">
                                    <a href="{{ route('courses.chapters.show', [$course->id, $chapter->id]) }}" class="inline-flex items-center justify-center rounded-lg bg-blue-600 hover:bg-blue-700 px-4 py-2 text-xs font-bold text-white transition shadow-sm">
                                        Buka Bab →
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>

                <div class="lg:col-span-4 space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6 border-b border-gray-100">
                            <h3 class="text-sm font-bold text-slate-800">Petunjuk Belajar</h3>
                            <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                Pilih bab yang ingin dibuka. Bab 1 dan Bab 7 memiliki diagram interaktif dengan hotspot.
                            </p>
                        </div>

                        <div class="p-6 space-y-3">
                            <div class="rounded-xl bg-slate-50 border border-slate-100 p-4">
                                <p class="text-xs font-semibold text-slate-700">Alur belajar</p>
                                <p class="text-[11px] leading-relaxed text-slate-500 mt-1">Mulai dari Bab 1, lalu lanjutkan ke bab berikutnya sesuai urutan.</p>
                            </div>

                            <div class="rounded-xl bg-blue-50 border border-blue-100 p-4">
                                <p class="text-xs font-semibold text-blue-700">Diagram interaktif</p>
                                <p class="text-[11px] leading-relaxed text-blue-600 mt-1">Klik hotspot untuk membuka materi sub-bab yang terhubung.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
