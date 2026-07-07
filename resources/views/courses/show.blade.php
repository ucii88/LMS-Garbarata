@section('topbar_title', 'Silabus Pembelajaran')

<x-app-layout>
    <div class="py-6 select-none">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Breadcrumb Navigation -->
            <div class="mb-2">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center text-xs font-bold text-gray-500 hover:text-blue-600 transition">
                    ← Kembali ke Dashboard
                </a>
            </div>

            <!-- Course Title Welcome Banner -->
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

            <!-- Syllabus Content Grid -->
            <div class="grid gap-6 lg:grid-cols-12">
                
                <!-- Left Side: Chapters List (span 8) -->
                <div class="lg:col-span-8 space-y-4">
                    <div class="border-b border-[#f0f0f0] pb-3 mb-5">
                        <h2 class="text-base font-bold text-slate-800">Daftar Bab & Pembelajaran</h2>
                        <p class="text-xs text-slate-400 mt-0.5">Selesaikan setiap bab secara berurutan sesuai kurikulum buku operasional.</p>
                    </div>

                    <div class="space-y-4">
                        @foreach ($course->chapters as $chapter)
                            @php
                                // Detect if the chapter has a diagram for badge styling
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
                                        {{ str_replace("BAB {$chapter->order}: ", "", $chapter->title) }}
                                    </h3>
                                    
                                    <p class="text-2xs text-slate-400 leading-normal">
                                        Berisi {{ $chapter->modules_count }} topik pembahasan utama beserta materi evaluasi mandiri.
                                    </p>
                                </div>

                                <div class="shrink-0 flex items-center justify-end border-t sm:border-t-0 border-[#f0f0f0] pt-3 sm:pt-0">
                                    <a 
                                        href="{{ route('courses.chapters.show', [$course->id, $chapter->id]) }}" 
                                        class="inline-flex items-center justify-center rounded-lg bg-blue-600 hover:bg-blue-700 px-4 py-2 text-xs font-bold text-white transition shadow-sm"
                                    >
                                        Buka Bab →
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>

                <!-- Right Side: Metadata / Side Panel (span 4) -->
                <div class="lg:col-span-4 space-y-6">
                    <!-- Course Info Panel -->
                    <div class="rounded-2xl border border-[#f0f0f0] bg-white p-6 shadow-sm space-y-5">
                        <h2 class="text-sm font-bold text-slate-800">Informasi Kursus</h2>
                        
                        <div class="divide-y divide-[#f0f0f0] text-xs">
                            <div class="py-3 flex justify-between">
                                <span class="text-gray-400">Instruktur</span>
                                <span class="font-bold text-slate-700">Capt. Hermawan</span>
                            </div>
                            <div class="py-3 flex justify-between">
                                <span class="text-gray-400">Target Role</span>
                                <span class="font-bold text-slate-700">Peserta (Teknisi)</span>
                            </div>
                            <div class="py-3 flex justify-between">
                                <span class="text-gray-400">Total Pembahasan</span>
                                <span class="font-bold text-slate-700">{{ $course->chapters->count() }} Bab Buku</span>
                            </div>
                            <div class="py-3 flex justify-between">
                                <span class="text-gray-400">Metode</span>
                                <span class="font-bold text-slate-700">Visual & Interaktif</span>
                            </div>
                        </div>

                        <!-- Progress Section -->
                        <div class="space-y-2 border-t border-[#f0f0f0] pt-4">
                            <div class="flex justify-between text-2xs font-bold uppercase tracking-wider text-slate-400">
                                <span>Progress Belajar</span>
                                <span class="text-blue-600">0% Selesai</span>
                            </div>
                            <div class="h-1.5 w-full bg-slate-100 rounded-full overflow-hidden">
                                <div class="h-full bg-blue-500 rounded-full" style="width: 0%;"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Safety Reminder from Manual -->
                    <div class="rounded-2xl border border-amber-100 bg-amber-50/50 p-5 space-y-3">
                        <div class="flex items-center space-x-2 text-amber-800 font-bold text-xs">
                            <svg class="w-4.5 h-4.5 text-amber-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            <span>Aturan Keselamatan Apron</span>
                        </div>
                        <p class="text-2xs text-amber-700 leading-relaxed">
                            Berdasarkan SOP Bandara Internasional Sultan Hasanuddin, pergerakan Garbarata di area apron harus dilakukan oleh operator bersertifikat dan berkoordinasi penuh dengan petugas marshalling.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
