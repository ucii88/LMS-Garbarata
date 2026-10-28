<!-- Custom Grouped Layout for Chapter 3: Operation Details & Procedures -->
<div class="py-6 select-none" x-data="{
    modules: @js($modules),
    completeUrlTemplate: @js(route('courses.modules.complete', [$course->id, $chapter->id, '__MODULE__'])),
    csrfToken: @js(csrf_token()),
    detailItems: [],
    manualItems: [],
    autoItems: [],
    procedureItems: [],
    expandedSectionIds: [],

    init() {
        this.detailItems = this.modules.filter(module => module.title.startsWith('1.'));
        this.manualItems = this.modules.filter(module => module.title.startsWith('2.'));
        this.autoItems = this.modules.filter(module => module.title.startsWith('3.'));
        this.procedureItems = this.modules.filter(module => module.title.startsWith('4.'));
    },

    toggleSection(sectionId) {
        this.markSectionComplete(sectionId);

        if (this.expandedSectionIds.includes(sectionId)) {
            this.expandedSectionIds = this.expandedSectionIds.filter(id => id !== sectionId);
            return;
        }

        this.expandedSectionIds.push(sectionId);
    },

    isSectionExpanded(sectionId) {
        return this.expandedSectionIds.includes(sectionId);
    },

    markSectionComplete(sectionId) {
        const sectionMap = {
            detail: this.detailItems,
            manual: this.manualItems,
            auto: this.autoItems,
            procedure: this.procedureItems,
        };

        (sectionMap[sectionId] || []).forEach(module => this.markModuleComplete(module.id));
    },

    markModuleComplete(moduleId) {
        fetch(this.completeUrlTemplate.replace('__MODULE__', moduleId), {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': this.csrfToken,
                'Accept': 'application/json',
            },
        });
    }
}">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <!-- Navigation Back & Title Bar -->
        <div class="flex items-center justify-between">
            <a href="{{ route('courses.show', $course->id) }}" class="inline-flex items-center text-xs font-bold text-gray-500 hover:text-blue-600 transition">
                &larr; {{ __('Kembali ke Daftar Bab') }}
            </a>

            <div class="flex items-center gap-2">
                @if(auth()->user()->isInstruktur())
                    <button type="button" @click="window.dispatchEvent(new CustomEvent('open-upload-diagram-modal'))" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg text-xs transition shadow-sm cursor-pointer">
                        <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span>{{ __('Upload Diagram Interaktif') }}</span>
                    </button>

                    <a href="{{ route('modules.create', [$course->id, $chapter->id]) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg text-xs transition shadow-sm">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                        </svg>
                        {{ __('Tambah Modul Baru') }}
                    </a>
                @endif

                <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-[9px] font-bold text-blue-600 border border-blue-100 uppercase tracking-wider">
                    {{ __('Bab') }} {{ $chapter->order }} {{ __('dari') }} {{ $chapters->count() }}
                </span>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-6">
            <h3 class="font-bold text-gray-800 text-base">
                {{ str_replace("BAB {$chapter->order}: ", "", $chapter->title) }}
            </h3>
            <p class="text-sm text-gray-500 mt-1.5 leading-relaxed">
                {{ __('Materi Bab 3 dibagi menjadi detail pengoperasian, mode operasi manual, mode auto, dan prosedur pengoperasian. Setiap bagian dapat dibuka dan ditutup agar materi lebih mudah dibaca.') }}
            </p>
        </div>

        @include('courses.partials.interactive-diagram-section')

        <div class="space-y-4">
            <!-- Detail Operation Group -->
            <section class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <button
                    type="button"
                    @click="toggleSection('detail')"
                    class="w-full flex flex-col gap-3 bg-white p-6 text-left transition hover:bg-slate-50 md:flex-row md:items-center md:justify-between"
                >
                    <div class="flex items-center space-x-3">
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-blue-200 bg-white text-[10px] font-black text-blue-600">01</span>
                        <div>
                            <h2 class="text-base font-extrabold text-slate-800 uppercase tracking-wider">{{ __('Detail Pengoperasian') }}</h2>
                            <p class="mt-1 text-[10px] font-semibold text-slate-400">{{ __('Klik judul bagian untuk melihat materi lengkap.') }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="inline-flex w-fit rounded-full border border-blue-200 bg-white px-2.5 py-0.5 text-[9px] font-bold text-blue-600 uppercase tracking-wider">
                            Module 1.1
                        </span>
                        <span
                            class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-full border border-slate-200 bg-white text-base font-black text-slate-600 transition"
                            x-text="isSectionExpanded('detail') ? '-' : '+'"
                        ></span>
                    </div>
                </button>

                <div x-show="isSectionExpanded('detail')" class="border-t border-gray-100 bg-white">
                    <div class="p-4 md:p-6 space-y-4">
                        <template x-for="module in detailItems" :key="module.id">
                            <article class="rounded-xl border border-gray-100 bg-white p-4 space-y-3 shadow-sm">
                                <div class="border-b border-gray-100 pb-3 flex items-center justify-between flex-wrap gap-2">
                                     <h3 class="text-sm md:text-base font-bold text-slate-800 leading-snug" x-text="module.title"></h3>
                                     <div class="tts-controls-group">
        <select class="tts-speed-select" onchange="window.LmsTTS.setRate(this.value)" title="{{ app()->getLocale() === 'en' ? 'Voice Speed' : 'Kecepatan Suara' }}">
            <option value="0.8">0.8x</option>
            <option value="1" selected>1.0x</option>
            <option value="1.2">1.2x</option>
            <option value="1.4">1.4x</option>
            <option value="1.6">1.6x</option>
            <option value="1.8">1.8x</option>
            <option value="2">2.0x</option>
        </select>
        <div class="tts-divider"></div>
        <button
            type="button"
            class="tts-ctrl-btn"
            onclick="window.LmsTTS.prevParagraph()"
            title="{{ app()->getLocale() === 'en' ? 'Previous Paragraph' : 'Paragraf Sebelumnya' }}"
        >
            <svg class="w-3.5 h-3.5 fill-slate-800" viewBox="0 0 24 24"><path d="M6 6h2v12H6zm3 6l9 6V6z"/></svg>
        </button>
        <button
            type="button"
            class="tts-ctrl-btn"
            onclick="window.LmsTTS.stop()"
            title="{{ app()->getLocale() === 'en' ? 'Stop' : 'Berhenti' }}"
        >
            <svg class="w-3.5 h-3.5 fill-slate-800" viewBox="0 0 24 24"><rect x="5" y="5" width="14" height="14" rx="1.5"/></svg>
        </button>
        <button
            type="button"
            class="tts-ctrl-btn tts-play-btn"
            :data-tts-id="'ch3detail_' + module.id"
            @click="window.ttsToggle('ch3detail_' + module.id, module.content, 'ch3detail-tts-' + module.id)"
            title="{{ app()->getLocale() === 'en' ? 'Play / Pause' : 'Putar / Jeda' }}"
        >
            <span class="tts-icon">
                <svg class="w-4 h-4 ml-0.5" fill="#ffffff" viewBox="0 0 24 24"><path fill="#ffffff" d="M8 5.14v13.72a1 1 0 0 0 1.53.85l11-6.86a1 1 0 0 0 0-1.7l-11-6.86a1 1 0 0 0-1.53.85z"/></svg>
            </span>
        </button>
        <button
            type="button"
            class="tts-ctrl-btn"
            onclick="window.LmsTTS.nextParagraph()"
            title="{{ app()->getLocale() === 'en' ? 'Next Paragraph' : 'Paragraf Selanjutnya' }}"
        >
            <svg class="w-3.5 h-3.5 fill-slate-800" viewBox="0 0 24 24"><path d="M6 18l9-6-9-6v12zm10-12h2v12h-2z"/></svg>
        </button>
    </div>
                                 </div>

                                <div :id="'ch3detail-tts-' + module.id" class="text-sm text-slate-600 leading-relaxed space-y-3.5 prose prose-slate max-w-none prose-sm" x-html="module.content"></div>

                                <!-- Gambar Modul Jika Diunggah -->
                                <template x-if="module.image_path">
                                    <div class="rounded-xl border border-gray-200 bg-gray-50 p-3 shadow-xs my-4 max-w-2xl mx-auto">
                                        <img :src="module.image_path.startsWith('/') ? module.image_path : '/' + module.image_path" class="w-full max-h-80 object-contain rounded-lg select-none mx-auto" :alt="module.title">
                                    </div>
                                </template>

                                <!-- Interactive Module Diagram -->
                                <template x-if="(module.diagrams && module.diagrams.length > 0) || module.diagram">
                                    <div class="my-4 p-4 rounded-2xl border border-slate-100 bg-slate-50/50 shadow-2xs"
                                        x-data="moduleDiagramData(
                                            (module.diagrams && module.diagrams.length > 0) ? module.diagrams : (module.diagram ? [module.diagram] : []),
                                            (module.diagrams && module.diagrams.length > 0) ? (module.diagrams[0].hotspots || []) : (module.diagram ? module.diagram.hotspots : []),
                                            {{ $course->id }},
                                            {{ $chapter->id }},
                                            module.id,
                                            @js(route('courses.modules.diagram.store', [$course->id, $chapter->id, '__MODULE__'])).replace('__MODULE__', module.id),
                                            @js(route('courses.modules.diagram.destroy', [$course->id, $chapter->id, '__MODULE__'])).replace('__MODULE__', module.id),
                                            @js(route('courses.modules.hotspots.store', [$course->id, $chapter->id, '__MODULE__'])).replace('__MODULE__', module.id),
                                            @js(route('courses.modules.hotspots.update', [$course->id, $chapter->id, '__MODULE__'])).replace('__MODULE__', module.id),
                                            @js(csrf_token())
                                        )"
                                    >
                                        @include('courses.partials.module-diagram-section')
                                    </div>
                                </template>

                                @if(auth()->user()->isInstruktur())
                                    <div class="flex items-center gap-2 pt-3 border-t border-slate-100 mt-3">
                                        <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + module.id + '/edit'" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-xs font-bold transition shadow-xs flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            <span>{{ __('Edit Modul Ini') }}</span>
                                        </a>
                                        <form :action="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + module.id" method="POST" data-confirm="{{ __('Apakah Anda yakin ingin menghapus modul ini?') }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-xs font-bold transition shadow-xs flex items-center gap-1.5">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                <span>{{ __('Hapus Modul') }}</span>
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </article>
                        </template>
                    </div>
                </div>
            </section>

            <!-- Manual Operation Group -->
            <section class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <button
                    type="button"
                    @click="toggleSection('manual')"
                    class="w-full flex flex-col gap-3 bg-white p-6 text-left transition hover:bg-slate-50 md:flex-row md:items-center md:justify-between"
                >
                    <div class="flex items-center space-x-3">
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-emerald-200 bg-white text-[10px] font-black text-emerald-600">02</span>
                        <div>
                            <h2 class="text-base font-extrabold text-slate-800 uppercase tracking-wider">{{ __('Mode Operasi Manual') }}</h2>
                            <p class="mt-1 text-[10px] font-semibold text-slate-400">{{ __('Klik judul bagian untuk melihat materi lengkap.') }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="inline-flex w-fit rounded-full border border-emerald-200 bg-white px-2.5 py-0.5 text-[9px] font-bold text-emerald-600 uppercase tracking-wider">
                            Module 2.1 - 2.4
                        </span>
                        <span
                            class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-full border border-slate-200 bg-white text-base font-black text-slate-600 transition"
                            x-text="isSectionExpanded('manual') ? '-' : '+'"
                        ></span>
                    </div>
                </button>

                <div x-show="isSectionExpanded('manual')" class="border-t border-gray-100 bg-white">
                    <div class="p-4 md:p-6 space-y-4">
                        <p class="text-sm text-slate-600 leading-relaxed">
                            {{ __('Dengan memutar keyswitch ke mode manual akan mengaktifkan seluruh komponen penggerak Garbarata') }}
                        </p>

                        <template x-for="module in manualItems" :key="module.id">
                            <article class="rounded-xl border border-gray-100 bg-white p-4 space-y-3 shadow-sm">
                                <div class="border-b border-gray-100 pb-3 flex items-center justify-between flex-wrap gap-2">
                                     <h3 class="text-sm md:text-base font-bold text-slate-800 leading-snug" x-text="module.title"></h3>
                                     <div class="tts-controls-group">
        <select class="tts-speed-select" onchange="window.LmsTTS.setRate(this.value)" title="{{ app()->getLocale() === 'en' ? 'Voice Speed' : 'Kecepatan Suara' }}">
            <option value="0.8">0.8x</option>
            <option value="1" selected>1.0x</option>
            <option value="1.2">1.2x</option>
            <option value="1.4">1.4x</option>
            <option value="1.6">1.6x</option>
            <option value="1.8">1.8x</option>
            <option value="2">2.0x</option>
        </select>
        <div class="tts-divider"></div>
        <button
            type="button"
            class="tts-ctrl-btn"
            onclick="window.LmsTTS.prevParagraph()"
            title="{{ app()->getLocale() === 'en' ? 'Previous Paragraph' : 'Paragraf Sebelumnya' }}"
        >
            <svg class="w-3.5 h-3.5 fill-slate-800" viewBox="0 0 24 24"><path d="M6 6h2v12H6zm3 6l9 6V6z"/></svg>
        </button>
        <button
            type="button"
            class="tts-ctrl-btn"
            onclick="window.LmsTTS.stop()"
            title="{{ app()->getLocale() === 'en' ? 'Stop' : 'Berhenti' }}"
        >
            <svg class="w-3.5 h-3.5 fill-slate-800" viewBox="0 0 24 24"><rect x="5" y="5" width="14" height="14" rx="1.5"/></svg>
        </button>
        <button
            type="button"
            class="tts-ctrl-btn tts-play-btn"
            :data-tts-id="'ch3manual_' + module.id"
            @click="window.ttsToggle('ch3manual_' + module.id, module.content, 'ch3manual-tts-' + module.id)"
            title="{{ app()->getLocale() === 'en' ? 'Play / Pause' : 'Putar / Jeda' }}"
        >
            <span class="tts-icon">
                <svg class="w-4 h-4 ml-0.5" fill="#ffffff" viewBox="0 0 24 24"><path fill="#ffffff" d="M8 5.14v13.72a1 1 0 0 0 1.53.85l11-6.86a1 1 0 0 0 0-1.7l-11-6.86a1 1 0 0 0-1.53.85z"/></svg>
            </span>
        </button>
        <button
            type="button"
            class="tts-ctrl-btn"
            onclick="window.LmsTTS.nextParagraph()"
            title="{{ app()->getLocale() === 'en' ? 'Next Paragraph' : 'Paragraf Selanjutnya' }}"
        >
            <svg class="w-3.5 h-3.5 fill-slate-800" viewBox="0 0 24 24"><path d="M6 18l9-6-9-6v12zm10-12h2v12h-2z"/></svg>
        </button>
    </div>
                                 </div>

                                <div :id="'ch3manual-tts-' + module.id" class="text-sm text-slate-600 leading-relaxed space-y-3.5 prose prose-slate max-w-none prose-sm" x-html="module.content"></div>

                                <!-- Gambar Modul Jika Diunggah -->
                                <template x-if="module.image_path">
                                    <div class="rounded-xl border border-gray-200 bg-gray-50 p-3 shadow-xs my-4 max-w-2xl mx-auto">
                                        <img :src="module.image_path.startsWith('/') ? module.image_path : '/' + module.image_path" class="w-full max-h-80 object-contain rounded-lg select-none mx-auto" :alt="module.title">
                                    </div>
                                </template>

                                <!-- Interactive Module Diagram -->
                                <template x-if="(module.diagrams && module.diagrams.length > 0) || module.diagram">
                                    <div class="my-4 p-4 rounded-2xl border border-slate-100 bg-slate-50/50 shadow-2xs"
                                        x-data="moduleDiagramData(
                                            (module.diagrams && module.diagrams.length > 0) ? module.diagrams : (module.diagram ? [module.diagram] : []),
                                            (module.diagrams && module.diagrams.length > 0) ? (module.diagrams[0].hotspots || []) : (module.diagram ? module.diagram.hotspots : []),
                                            {{ $course->id }},
                                            {{ $chapter->id }},
                                            module.id,
                                            @js(route('courses.modules.diagram.store', [$course->id, $chapter->id, '__MODULE__'])).replace('__MODULE__', module.id),
                                            @js(route('courses.modules.diagram.destroy', [$course->id, $chapter->id, '__MODULE__'])).replace('__MODULE__', module.id),
                                            @js(route('courses.modules.hotspots.store', [$course->id, $chapter->id, '__MODULE__'])).replace('__MODULE__', module.id),
                                            @js(route('courses.modules.hotspots.update', [$course->id, $chapter->id, '__MODULE__'])).replace('__MODULE__', module.id),
                                            @js(csrf_token())
                                        )"
                                    >
                                        @include('courses.partials.module-diagram-section')
                                    </div>
                                </template>

                                @if(auth()->user()->isInstruktur())
                                    <div class="flex items-center gap-2 pt-3 border-t border-slate-100 mt-3">
                                        <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + module.id + '/edit'" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-xs font-bold transition shadow-xs flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            <span>{{ __('Edit Modul Ini') }}</span>
                                        </a>
                                        <form :action="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + module.id" method="POST" data-confirm="{{ __('Apakah Anda yakin ingin menghapus modul ini?') }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-xs font-bold transition shadow-xs flex items-center gap-1.5">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                <span>{{ __('Hapus Modul') }}</span>
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </article>
                        </template>
                    </div>
                </div>
            </section>

            <!-- Auto Mode Group -->
            <section class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <button
                    type="button"
                    @click="toggleSection('auto')"
                    class="w-full flex flex-col gap-3 bg-white p-6 text-left transition hover:bg-slate-50 md:flex-row md:items-center md:justify-between"
                >
                    <div class="flex items-center space-x-3">
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-amber-200 bg-white text-[10px] font-black text-amber-600">03</span>
                        <div>
                            <h2 class="text-base font-extrabold text-slate-800 uppercase tracking-wider">{{ __('Mode Auto (Autolevel)') }}</h2>
                            <p class="mt-1 text-[10px] font-semibold text-slate-400">{{ __('Klik judul bagian untuk melihat materi lengkap.') }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="inline-flex w-fit rounded-full border border-amber-200 bg-white px-2.5 py-0.5 text-[9px] font-bold text-amber-600 uppercase tracking-wider">
                            Module 3
                        </span>
                        <span
                            class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-full border border-slate-200 bg-white text-base font-black text-slate-600 transition"
                            x-text="isSectionExpanded('auto') ? '-' : '+'"
                        ></span>
                    </div>
                </button>

                <div x-show="isSectionExpanded('auto')" class="border-t border-gray-100 bg-white">
                    <div class="p-4 md:p-6 space-y-4">
                        <template x-for="module in autoItems" :key="module.id">
                            <article class="rounded-xl border border-gray-100 bg-white p-4 space-y-3 shadow-sm">
                                <div class="border-b border-gray-100 pb-3 flex items-center justify-between flex-wrap gap-2">
                                     <h3 class="text-sm md:text-base font-bold text-slate-800 leading-snug" x-text="module.title"></h3>
                                     <div class="tts-controls-group">
        <select class="tts-speed-select" onchange="window.LmsTTS.setRate(this.value)" title="{{ app()->getLocale() === 'en' ? 'Voice Speed' : 'Kecepatan Suara' }}">
            <option value="0.8">0.8x</option>
            <option value="1" selected>1.0x</option>
            <option value="1.2">1.2x</option>
            <option value="1.4">1.4x</option>
            <option value="1.6">1.6x</option>
            <option value="1.8">1.8x</option>
            <option value="2">2.0x</option>
        </select>
        <div class="tts-divider"></div>
        <button
            type="button"
            class="tts-ctrl-btn"
            onclick="window.LmsTTS.prevParagraph()"
            title="{{ app()->getLocale() === 'en' ? 'Previous Paragraph' : 'Paragraf Sebelumnya' }}"
        >
            <svg class="w-3.5 h-3.5 fill-slate-800" viewBox="0 0 24 24"><path d="M6 6h2v12H6zm3 6l9 6V6z"/></svg>
        </button>
        <button
            type="button"
            class="tts-ctrl-btn"
            onclick="window.LmsTTS.stop()"
            title="{{ app()->getLocale() === 'en' ? 'Stop' : 'Berhenti' }}"
        >
            <svg class="w-3.5 h-3.5 fill-slate-800" viewBox="0 0 24 24"><rect x="5" y="5" width="14" height="14" rx="1.5"/></svg>
        </button>
        <button
            type="button"
            class="tts-ctrl-btn tts-play-btn"
            :data-tts-id="'ch3auto_' + module.id"
            @click="window.ttsToggle('ch3auto_' + module.id, module.content, 'ch3auto-tts-' + module.id)"
            title="{{ app()->getLocale() === 'en' ? 'Play / Pause' : 'Putar / Jeda' }}"
        >
            <span class="tts-icon">
                <svg class="w-4 h-4 ml-0.5" fill="#ffffff" viewBox="0 0 24 24"><path fill="#ffffff" d="M8 5.14v13.72a1 1 0 0 0 1.53.85l11-6.86a1 1 0 0 0 0-1.7l-11-6.86a1 1 0 0 0-1.53.85z"/></svg>
            </span>
        </button>
        <button
            type="button"
            class="tts-ctrl-btn"
            onclick="window.LmsTTS.nextParagraph()"
            title="{{ app()->getLocale() === 'en' ? 'Next Paragraph' : 'Paragraf Selanjutnya' }}"
        >
            <svg class="w-3.5 h-3.5 fill-slate-800" viewBox="0 0 24 24"><path d="M6 18l9-6-9-6v12zm10-12h2v12h-2z"/></svg>
        </button>
    </div>
                                 </div>

                                <div :id="'ch3auto-tts-' + module.id" class="text-sm text-slate-600 leading-relaxed space-y-3.5 prose prose-slate max-w-none prose-sm" x-html="module.content"></div>

                                <!-- Gambar Modul Jika Diunggah -->
                                <template x-if="module.image_path">
                                    <div class="rounded-xl border border-gray-200 bg-gray-50 p-3 shadow-xs my-4 max-w-2xl mx-auto">
                                        <img :src="module.image_path.startsWith('/') ? module.image_path : '/' + module.image_path" class="w-full max-h-80 object-contain rounded-lg select-none mx-auto" :alt="module.title">
                                    </div>
                                </template>

                                <!-- Interactive Module Diagram -->
                                <template x-if="(module.diagrams && module.diagrams.length > 0) || module.diagram">
                                    <div class="my-4 p-4 rounded-2xl border border-slate-100 bg-slate-50/50 shadow-2xs"
                                        x-data="moduleDiagramData(
                                            (module.diagrams && module.diagrams.length > 0) ? module.diagrams : (module.diagram ? [module.diagram] : []),
                                            (module.diagrams && module.diagrams.length > 0) ? (module.diagrams[0].hotspots || []) : (module.diagram ? module.diagram.hotspots : []),
                                            {{ $course->id }},
                                            {{ $chapter->id }},
                                            module.id,
                                            @js(route('courses.modules.diagram.store', [$course->id, $chapter->id, '__MODULE__'])).replace('__MODULE__', module.id),
                                            @js(route('courses.modules.diagram.destroy', [$course->id, $chapter->id, '__MODULE__'])).replace('__MODULE__', module.id),
                                            @js(route('courses.modules.hotspots.store', [$course->id, $chapter->id, '__MODULE__'])).replace('__MODULE__', module.id),
                                            @js(route('courses.modules.hotspots.update', [$course->id, $chapter->id, '__MODULE__'])).replace('__MODULE__', module.id),
                                            @js(csrf_token())
                                        )"
                                    >
                                        @include('courses.partials.module-diagram-section')
                                    </div>
                                </template>

                                @if(auth()->user()->isInstruktur())
                                    <div class="flex items-center gap-2 pt-3 border-t border-slate-100 mt-3">
                                        <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + module.id + '/edit'" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-xs font-bold transition shadow-xs flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            <span>{{ __('Edit Modul Ini') }}</span>
                                        </a>
                                        <form :action="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + module.id" method="POST" data-confirm="{{ __('Apakah Anda yakin ingin menghapus modul ini?') }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-xs font-bold transition shadow-xs flex items-center gap-1.5">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                <span>{{ __('Hapus Modul') }}</span>
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </article>
                        </template>
                    </div>
                </div>
            </section>

            <!-- Operation Procedure Group -->
            <section class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <button
                    type="button"
                    @click="toggleSection('procedure')"
                    class="w-full flex flex-col gap-3 bg-white p-6 text-left transition hover:bg-slate-50 md:flex-row md:items-center md:justify-between"
                >
                    <div class="flex items-center space-x-3">
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-rose-200 bg-white text-[10px] font-black text-rose-600">04</span>
                        <div>
                            <h2 class="text-base font-extrabold text-slate-800 uppercase tracking-wider">{{ __('Prosedur Pengoperasian') }}</h2>
                            <p class="mt-1 text-[10px] font-semibold text-slate-400">{{ __('Klik judul bagian untuk melihat materi lengkap.') }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="inline-flex w-fit rounded-full border border-rose-200 bg-white px-2.5 py-0.5 text-[9px] font-bold text-rose-600 uppercase tracking-wider">
                            Module 4.1 - 4.6
                        </span>
                        <span
                            class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-full border border-slate-200 bg-white text-base font-black text-slate-600 transition"
                            x-text="isSectionExpanded('procedure') ? '-' : '+'"
                        ></span>
                    </div>
                </button>

                <div x-show="isSectionExpanded('procedure')" class="border-t border-gray-100 bg-white">
                    <div class="p-4 md:p-6 space-y-4">
                        <template x-for="module in procedureItems" :key="module.id">
                            <article class="rounded-xl border border-gray-100 bg-white p-4 space-y-3 shadow-sm">
                                <div class="border-b border-gray-100 pb-3 flex items-center justify-between flex-wrap gap-2">
                                     <h3 class="text-sm md:text-base font-bold text-slate-800 leading-snug" x-text="module.title"></h3>
                                     <div class="tts-controls-group">
        <select class="tts-speed-select" onchange="window.LmsTTS.setRate(this.value)" title="{{ app()->getLocale() === 'en' ? 'Voice Speed' : 'Kecepatan Suara' }}">
            <option value="0.8">0.8x</option>
            <option value="1" selected>1.0x</option>
            <option value="1.2">1.2x</option>
            <option value="1.4">1.4x</option>
            <option value="1.6">1.6x</option>
            <option value="1.8">1.8x</option>
            <option value="2">2.0x</option>
        </select>
        <div class="tts-divider"></div>
        <button
            type="button"
            class="tts-ctrl-btn"
            onclick="window.LmsTTS.prevParagraph()"
            title="{{ app()->getLocale() === 'en' ? 'Previous Paragraph' : 'Paragraf Sebelumnya' }}"
        >
            <svg class="w-3.5 h-3.5 fill-slate-800" viewBox="0 0 24 24"><path d="M6 6h2v12H6zm3 6l9 6V6z"/></svg>
        </button>
        <button
            type="button"
            class="tts-ctrl-btn"
            onclick="window.LmsTTS.stop()"
            title="{{ app()->getLocale() === 'en' ? 'Stop' : 'Berhenti' }}"
        >
            <svg class="w-3.5 h-3.5 fill-slate-800" viewBox="0 0 24 24"><rect x="5" y="5" width="14" height="14" rx="1.5"/></svg>
        </button>
        <button
            type="button"
            class="tts-ctrl-btn tts-play-btn"
            :data-tts-id="'ch3proc_' + module.id"
            @click="window.ttsToggle('ch3proc_' + module.id, module.content, 'ch3proc-tts-' + module.id)"
            title="{{ app()->getLocale() === 'en' ? 'Play / Pause' : 'Putar / Jeda' }}"
        >
            <span class="tts-icon">
                <svg class="w-4 h-4 ml-0.5" fill="#ffffff" viewBox="0 0 24 24"><path fill="#ffffff" d="M8 5.14v13.72a1 1 0 0 0 1.53.85l11-6.86a1 1 0 0 0 0-1.7l-11-6.86a1 1 0 0 0-1.53.85z"/></svg>
            </span>
        </button>
        <button
            type="button"
            class="tts-ctrl-btn"
            onclick="window.LmsTTS.nextParagraph()"
            title="{{ app()->getLocale() === 'en' ? 'Next Paragraph' : 'Paragraf Selanjutnya' }}"
        >
            <svg class="w-3.5 h-3.5 fill-slate-800" viewBox="0 0 24 24"><path d="M6 18l9-6-9-6v12zm10-12h2v12h-2z"/></svg>
        </button>
    </div>
                                 </div>

                                <div :id="'ch3proc-tts-' + module.id" class="text-sm text-slate-600 leading-relaxed space-y-3.5 prose prose-slate max-w-none prose-sm" x-html="module.content"></div>

                                <!-- Gambar Modul Jika Diunggah -->
                                <template x-if="module.image_path">
                                    <div class="rounded-xl border border-gray-200 bg-gray-50 p-3 shadow-xs my-4 max-w-2xl mx-auto">
                                        <img :src="module.image_path.startsWith('/') ? module.image_path : '/' + module.image_path" class="w-full max-h-80 object-contain rounded-lg select-none mx-auto" :alt="module.title">
                                    </div>
                                </template>

                                <!-- Interactive Module Diagram -->
                                <template x-if="(module.diagrams && module.diagrams.length > 0) || module.diagram">
                                    <div class="my-4 p-4 rounded-2xl border border-slate-100 bg-slate-50/50 shadow-2xs"
                                        x-data="moduleDiagramData(
                                            (module.diagrams && module.diagrams.length > 0) ? module.diagrams : (module.diagram ? [module.diagram] : []),
                                            (module.diagrams && module.diagrams.length > 0) ? (module.diagrams[0].hotspots || []) : (module.diagram ? module.diagram.hotspots : []),
                                            {{ $course->id }},
                                            {{ $chapter->id }},
                                            module.id,
                                            @js(route('courses.modules.diagram.store', [$course->id, $chapter->id, '__MODULE__'])).replace('__MODULE__', module.id),
                                            @js(route('courses.modules.diagram.destroy', [$course->id, $chapter->id, '__MODULE__'])).replace('__MODULE__', module.id),
                                            @js(route('courses.modules.hotspots.store', [$course->id, $chapter->id, '__MODULE__'])).replace('__MODULE__', module.id),
                                            @js(route('courses.modules.hotspots.update', [$course->id, $chapter->id, '__MODULE__'])).replace('__MODULE__', module.id),
                                            @js(csrf_token())
                                        )"
                                    >
                                        @include('courses.partials.module-diagram-section')
                                    </div>
                                </template>

                                @if(auth()->user()->isInstruktur())
                                    <div class="flex items-center gap-2 pt-3 border-t border-slate-100 mt-3">
                                        <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + module.id + '/edit'" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-xs font-bold transition shadow-xs flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            <span>{{ __('Edit Modul Ini') }}</span>
                                        </a>
                                        <form :action="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + module.id" method="POST" data-confirm="{{ __('Apakah Anda yakin ingin menghapus modul ini?') }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-xs font-bold transition shadow-xs flex items-center gap-1.5">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                <span>{{ __('Hapus Modul') }}</span>
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </article>
                        </template>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

@include('courses.partials.quiz-card')
