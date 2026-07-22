@section('topbar_title', __('Silabus Pembelajaran'))

<x-app-layout>
    <div class="py-6 select-none" x-data="{ showCreateModal: false, showEditModal: false, editChapter: { id: null, title: '', order: 1 }, editAction: '' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="mb-2">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-bold text-gray-500 hover:text-blue-600 transition">
                    {{ __('Kembali ke Dashboard') }}
                </a>
            </div>

            @if (session('success'))
                <div class="rounded-xl border border-emerald-100 bg-emerald-50 p-4 text-sm font-semibold text-emerald-700 flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="rounded-xl border border-rose-100 bg-rose-50 p-4 text-sm font-semibold text-rose-700 flex items-center gap-2">
                    <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <section class="relative rounded-2xl overflow-hidden bg-gradient-to-r from-slate-900 via-slate-800 to-indigo-950 p-8 md:p-10 shadow-sm border border-slate-800">
                <div class="absolute inset-0 opacity-15 bg-[radial-gradient(#4f46e5_1px,transparent_1px)] [background-size:16px_16px] pointer-events-none"></div>
                <div class="relative z-10 space-y-3">
                    <span class="inline-flex items-center rounded-full bg-blue-500/10 px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-blue-400 border border-blue-500/20">
                        {{ __('Buku Panduan Teknis') }}
                    </span>
                    <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight text-white leading-tight">
                        {{ $course->title }}
                    </h1>
                    <p class="text-sm md:text-base leading-relaxed text-slate-300 max-w-3xl">
                        {{ $course->description }}
                    </p>
                </div>
            </section>

            <div class="grid gap-6 lg:grid-cols-12">
                <div class="lg:col-span-8 space-y-4">
                    <div class="border-b border-[#f0f0f0] pb-3 mb-5 flex flex-wrap items-center justify-between gap-3">
                        <div>
                            <h2 class="text-base font-bold text-slate-800">{{ __('Daftar Bab & Pembelajaran') }}</h2>
                            <p class="text-sm text-slate-400 mt-0.5">{{ __('Selesaikan semua topik pada sebuah bab untuk membuka bab berikutnya.') }}</p>
                        </div>
                        @if(auth()->user()->isInstruktur())
                            <button @click="showCreateModal = true" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition shadow-md shadow-blue-500/20 flex items-center gap-1.5 shrink-0">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                <span>{{ __('Tambah Bab Baru') }}</span>
                            </button>
                        @endif
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
                                            {{ __('BAB') }} {{ $chapter->order }}
                                        </span>

                                        <span class="inline-flex rounded-full {{ $hasDiagram ? 'bg-blue-50 text-blue-600 border-blue-100' : 'bg-slate-50 text-slate-400 border-slate-100' }} px-2.5 py-0.5 text-[9px] font-bold border tracking-wider">
                                            {{ $hasDiagram ? __('Diagram Interaktif') : __('Modul Pembelajaran') }}
                                        </span>

                                        @if($chapterProgress)
                                            <span class="inline-flex rounded-full {{ $isLocked ? 'bg-slate-100 text-slate-400 border-slate-200' : ($chapterProgress['is_complete'] ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-amber-50 text-amber-600 border-amber-100') }} px-2.5 py-0.5 text-[9px] font-bold border tracking-wider">
                                                {{ $isLocked ? __('Terkunci') : $chapterProgress['percent'].'%' }}
                                            </span>
                                        @endif
                                    </div>

                                    <h3 class="text-base font-bold text-slate-800 leading-snug">
                                        {{ $chapter->title }}
                                    </h3>

                                    <p class="text-xs text-slate-400 leading-normal">
                                        {{ __('Berisi :count topik pembahasan utama beserta materi evaluasi mandiri.', ['count' => $chapter->modules_count]) }}
                                    </p>

                                    @if($chapterProgress && ! $chapterProgress['is_complete'])
                                        <p class="text-[10px] font-semibold {{ $isLocked ? 'text-slate-400' : 'text-amber-600' }}">
                                            {{ $isLocked ? __('Selesaikan semua materi BAB sebelumnya untuk membuka bab ini.') : __('Lengkapi pembelajaran BAB :order.', ['order' => $chapter->order]) }}
                                        </p>
                                    @endif
                                </div>

                                <div class="shrink-0 flex items-center justify-end gap-2 border-t sm:border-t-0 border-[#f0f0f0] pt-3 sm:pt-0">
                                    @if($isLocked)
                                        <span class="inline-flex items-center justify-center rounded-lg bg-slate-200 px-4 py-2 text-sm font-bold text-slate-500">
                                            {{ __('Terkunci') }}
                                        </span>
                                    @else
                                        @if(auth()->user()->isInstruktur())
                                            <a href="{{ route('questions.index', [$course->id, $chapter->id]) }}"
                                               class="inline-flex items-center justify-center rounded-lg bg-indigo-50 hover:bg-indigo-100 border border-indigo-200 px-3 py-2 text-sm font-bold text-indigo-700 transition"
                                               title="{{ __('Kelola bank soal chapter ini') }}">
                                                {{ __('Bank Soal') }}
                                            </a>
                                            <button @click="editChapter = { id: {{ $chapter->id }}, title: @js($chapter->title), order: {{ $chapter->order }} }; editAction = '{{ route('courses.chapters.update', [$course->id, $chapter->id]) }}'; showEditModal = true;"
                                                    class="inline-flex items-center justify-center rounded-lg bg-slate-100 hover:bg-slate-200 border border-slate-200 px-3 py-2 text-sm font-bold text-slate-700 transition"
                                                    title="{{ __('Edit nama / urutan bab ini') }}">
                                                {{ __('Edit') }}
                                            </button>
                                            <form action="{{ route('courses.chapters.destroy', [$course->id, $chapter->id]) }}" method="POST" data-confirm="{{ __('Apakah Anda yakin ingin menghapus bab ini beserta seluruh modul di dalamnya?') }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-rose-50 hover:bg-rose-100 border border-rose-200 px-3 py-2 text-sm font-bold text-rose-700 transition" title="{{ __('Hapus bab ini') }}">
                                                    {{ __('Hapus') }}
                                                </button>
                                            </form>
                                        @endif
                                        <a href="{{ route('courses.chapters.show', [$course->id, $chapter->id]) }}" class="inline-flex items-center justify-center rounded-lg bg-blue-600 hover:bg-blue-700 px-4 py-2 text-sm font-bold text-white transition shadow-sm">
                                            {{ __('Buka Bab') }}
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
                            <h3 class="text-base font-bold text-slate-800">{{ __('Petunjuk Belajar') }}</h3>
                            <p class="text-sm text-slate-500 mt-1 leading-relaxed">
                                {{ __('Bab berikutnya terbuka setelah seluruh topik pada bab sebelumnya dibaca.') }}
                            </p>
                        </div>

                        <div class="p-6 space-y-3">
                            @if($learningProgress)
                                <div class="rounded-xl bg-emerald-50 border border-emerald-100 p-4">
                                    <p class="text-sm font-semibold text-emerald-700">{{ __('Progress materi') }}</p>
                                    <p class="text-[11px] leading-relaxed text-emerald-600 mt-1">{{ __(':percent% dari seluruh materi sudah dipelajari.', ['percent' => $learningProgress['percent']]) }}</p>
                                </div>
                            @endif

                            <div class="rounded-xl bg-slate-50 border border-slate-100 p-4">
                                <p class="text-sm font-semibold text-slate-700">{{ __('Alur belajar') }}</p>
                                <p class="text-[11px] leading-relaxed text-slate-500 mt-1">{{ __('Mulai dari Bab 1, lalu lanjutkan ke bab berikutnya sesuai urutan.') }}</p>
                            </div>

                            <div class="rounded-xl bg-blue-50 border border-blue-100 p-4">
                                <p class="text-sm font-semibold text-blue-700">{{ __('Diagram interaktif') }}</p>
                                <p class="text-[11px] leading-relaxed text-blue-600 mt-1">{{ __('Klik hotspot atau tombol topik untuk menandai materi sebagai sudah dibaca.') }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if(auth()->user()->isInstruktur())
                    <div class="bg-white rounded-2xl shadow-sm border border-indigo-100 overflow-hidden">
                        <div class="p-6 border-b border-indigo-50">
                            <h3 class="text-base font-bold text-slate-800">{{ __('Manajemen Quiz') }}</h3>
                            <p class="text-sm text-slate-500 mt-1 leading-relaxed">{{ __('Kelola kuis dan ujian evaluasi pembelajaran.') }}</p>
                        </div>
                        <div class="p-6 space-y-2">
                            <a href="{{ route('quizzes.index', $course) }}"
                               class="flex items-center justify-center gap-2 w-full px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl transition shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                {{ __('Lihat Semua Quiz') }}
                            </a>
                            <a href="{{ route('quizzes.create', $course) }}"
                               class="flex items-center justify-center gap-2 w-full px-4 py-2.5 bg-white hover:bg-indigo-50 border border-indigo-200 text-indigo-700 text-sm font-bold rounded-xl transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                {{ __('Buat Quiz Baru') }}
                            </a>
                        </div>
                    </div>
                    <div class="bg-white rounded-2xl shadow-sm border border-violet-100 overflow-hidden mt-4">
                        <div class="p-6 border-b border-violet-50">
                            <h3 class="text-base font-bold text-slate-800">{{ __('Manajemen Latihan') }}</h3>
                            <p class="text-sm text-slate-500 mt-1 leading-relaxed">{{ __('Kelola latihan tiap chapter menggunakan bank soal yang sama.') }}</p>
                        </div>
                        <div class="p-6 space-y-2">
                            <a href="{{ route('practices.index', $course) }}" class="flex items-center justify-center gap-2 w-full px-4 py-2.5 bg-violet-600 hover:bg-violet-700 text-white text-sm font-bold rounded-xl transition">{{ __('Lihat Semua Latihan') }}</a>
                            <a href="{{ route('practices.create', $course) }}" class="flex items-center justify-center gap-2 w-full px-4 py-2.5 bg-white hover:bg-violet-50 border border-violet-200 text-violet-700 text-sm font-bold rounded-xl transition">+ {{ __('Buat Latihan Baru') }}</a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Modal Tambah Bab Baru -->
        <template x-teleport="body">
            <div x-show="showCreateModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
                    <div x-show="showCreateModal" x-transition.opacity @click="showCreateModal = false" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs"></div>

                    <div x-show="showCreateModal" x-transition class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md">
                        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4 flex items-center justify-between text-white">
                            <h3 class="text-base font-bold flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                <span>{{ __('Tambah Bab Baru') }}</span>
                            </h3>
                            <button @click="showCreateModal = false" class="text-white/80 hover:text-white font-bold text-lg">&times;</button>
                        </div>

                        <form action="{{ route('courses.chapters.store', $course->id) }}" method="POST" class="p-6 space-y-4">
                            @csrf
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">{{ __('Judul Bab') }} <span class="text-rose-500">*</span></label>
                                <input type="text" name="title" required placeholder="Contoh: BAB 8: Pemeliharaan dan Perawatan Berkala" class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm font-semibold focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition">
                                <p class="text-[11px] text-slate-400 mt-1">{{ __('Tuliskan judul bab secara lengkap beserta nomor bab.') }}</p>
                            </div>

                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">{{ __('Nomor Urut Bab (Order)') }}</label>
                                <input type="number" name="order" min="1" value="{{ ($course->chapters->max('order') ?? 0) + 1 }}" class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm font-semibold focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition">
                                <p class="text-[11px] text-slate-400 mt-1">{{ __('Urutan posisi bab pada silabus (otomatis terisi nilai berikutnya).') }}</p>
                            </div>

                            <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                                <button type="button" @click="showCreateModal = false" class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-100 transition">
                                    {{ __('Batal') }}
                                </button>
                                <button type="submit" class="px-5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold transition shadow-md shadow-blue-500/20 flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    <span>{{ __('Simpan Bab') }}</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </template>

        <!-- Modal Edit Bab -->
        <template x-teleport="body">
            <div x-show="showEditModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
                    <div x-show="showEditModal" x-transition.opacity @click="showEditModal = false" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs"></div>

                    <div x-show="showEditModal" x-transition class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md">
                        <div class="bg-gradient-to-r from-slate-800 to-slate-900 px-6 py-4 flex items-center justify-between text-white">
                            <h3 class="text-base font-bold flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                <span>{{ __('Edit Judul / Urutan Bab') }}</span>
                            </h3>
                            <button @click="showEditModal = false" class="text-white/80 hover:text-white font-bold text-lg">&times;</button>
                        </div>

                        <form :action="editAction" method="POST" class="p-6 space-y-4">
                            @csrf
                            @method('PUT')
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">{{ __('Judul Bab') }} <span class="text-rose-500">*</span></label>
                                <input type="text" name="title" x-model="editChapter.title" required class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm font-semibold focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition">
                            </div>

                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">{{ __('Nomor Urut Bab (Order)') }}</label>
                                <input type="number" name="order" min="1" x-model="editChapter.order" required class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm font-semibold focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition">
                            </div>

                            <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                                <button type="button" @click="showEditModal = false" class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-100 transition">
                                    {{ __('Batal') }}
                                </button>
                                <button type="submit" class="px-5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold transition shadow-md shadow-blue-500/20 flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    <span>{{ __('Simpan Perubahan') }}</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </template>
    </div>
</x-app-layout>
