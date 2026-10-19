<!-- Custom Grouped Layout for Chapter 2: Mechanical Specs & Electrical Specs -->
<div class="py-6 select-none" x-data="{
    modules: @js($modules),
    completeUrlTemplate: @js(route('courses.modules.complete', [$course->id, $chapter->id, '__MODULE__'])),
    csrfToken: @js(csrf_token()),
    mechItems: [],
    elecItems: [],
    expandedMechIds: [],

    init() {
        this.mechItems = this.modules.filter(module => module.title.startsWith('1.'));
        this.elecItems = this.modules.filter(module => module.title.startsWith('2.'));
        
        // Automatically complete all Elektrikal modules because they are fully visible on screen!
        this.elecItems.forEach(module => {
            this.markModuleComplete(module.id);
        });
    },

    toggleMech(moduleId) {
        this.markModuleComplete(moduleId);

        if (this.expandedMechIds.includes(moduleId)) {
            this.expandedMechIds = this.expandedMechIds.filter(id => id !== moduleId);
            return;
        }

        this.expandedMechIds.push(moduleId);
    },

    isMechExpanded(moduleId) {
        return this.expandedMechIds.includes(moduleId);
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
                &larr; {{ __('Kembali ke Silabus Kursus') }}
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
                {{ __('Materi Bab 2 dibagi menjadi spesifikasi mekanikal dan elektrikal. Bagian mekanikal dapat dibuka dan ditutup per topik agar tabel dan gambar lebih mudah dibaca.') }}
            </p>
        </div>

        @include('courses.partials.interactive-diagram-section')

        <div class="space-y-8">
            <!-- Mechanical Group -->
            <section class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-5">
                <div class="flex flex-col gap-2 border-b border-gray-100 pb-4 md:flex-row md:items-center md:justify-between">
                    <div class="flex items-center space-x-3">
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-blue-200 bg-white text-[10px] font-black text-blue-600">01</span>
                        <h2 class="text-base font-extrabold text-slate-800 uppercase tracking-wider">{{ __('Mekanikal') }}</h2>
                    </div>

                    <span class="inline-flex w-fit rounded-full border border-blue-200 bg-white px-2.5 py-0.5 text-[9px] font-bold text-blue-600 uppercase tracking-wider">
                        Module 1.1 - 1.4
                    </span>
                </div>

                <p class="text-[10px] font-semibold text-slate-400">
                    {{ __('Klik judul module untuk melihat materi lengkap.') }}
                </p>

                <div class="space-y-3">
                    <template x-for="module in mechItems" :key="module.id">
                        <article :id="'module-' + module.id" :data-module-id="module.id" class="rounded-xl border border-gray-100 bg-white overflow-hidden shadow-sm">
                            <button
                                type="button"
                                @click="toggleMech(module.id)"
                                class="w-full flex items-center justify-between gap-4 bg-white px-4 py-3.5 text-left transition hover:bg-slate-50"
                            >
                                <span class="text-sm md:text-base font-bold text-slate-800" x-text="module.title"></span>
                                <span
                                    class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-full border border-slate-200 bg-white text-base font-black text-slate-600 transition"
                                    x-text="isMechExpanded(module.id) ? '-' : '+'"
                                ></span>
                            </button>

                            <div x-show="isMechExpanded(module.id)" class="border-t border-gray-100 bg-white">
                                <div class="p-4 md:p-6 space-y-4">
                                    <div class="flex items-center justify-end pb-1 border-b border-slate-100">
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
            :data-tts-id="'ch2mech_' + module.id"
            @click="window.ttsToggle('ch2mech_' + module.id, module.content, 'ch2mech-tts-' + module.id)"
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
                                    <div :id="'ch2mech-tts-' + module.id" class="text-sm text-slate-600 leading-relaxed space-y-3.5 prose prose-slate max-w-none prose-sm" x-html="module.content"></div>

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
                                            <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + module.id + '/edit'" class="px-2.5 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-2xs font-bold transition shadow-xs">
                                                {{ __('Edit Modul') }}
                                            </a>
                                            <form :action="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + module.id" method="POST" data-confirm="{{ __('Apakah Anda yakin ingin menghapus modul ini?') }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-2.5 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-2xs font-bold transition shadow-xs">
                                                    {{ __('Hapus') }}
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </article>
                    </template>
                </div>
            </section>

            <!-- Electrical Group -->
            <section class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-5">
                <div class="flex flex-col gap-2 border-b border-gray-100 pb-4 md:flex-row md:items-center md:justify-between">
                    <div class="flex items-center space-x-3">
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-emerald-200 bg-white text-[10px] font-black text-emerald-600">02</span>
                        <h2 class="text-base font-extrabold text-slate-800 uppercase tracking-wider">{{ __('Elektrikal') }}</h2>
                    </div>

                    <span class="inline-flex w-fit rounded-full border border-emerald-200 bg-white px-2.5 py-0.5 text-[9px] font-bold text-emerald-600 uppercase tracking-wider">
                        Module 2.1 - 2.3
                    </span>
                </div>

                <div class="space-y-4">
                    <template x-for="module in elecItems" :key="module.id">
                        <article class="rounded-xl border border-gray-100 bg-white p-4 space-y-3 shadow-sm">
                            <div class="border-b border-gray-100 pb-3">
                                <h3 class="text-sm md:text-base font-bold text-slate-800 leading-snug" x-text="module.title"></h3>
                            </div>

                            <div class="flex items-center justify-end pb-1 border-b border-slate-100">
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
            :data-tts-id="'ch2elec_' + module.id"
            @click="window.ttsToggle('ch2elec_' + module.id, module.content, 'ch2elec-tts-' + module.id)"
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

                            <div :id="'ch2elec-tts-' + module.id" class="text-sm text-slate-600 leading-relaxed space-y-3 prose prose-slate max-w-none prose-sm" x-html="module.content"></div>

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
                                    <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + module.id + '/edit'" class="px-2.5 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-2xs font-bold transition shadow-xs">
                                        {{ __('Edit Modul') }}
                                    </a>
                                    <form :action="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + module.id" method="POST" data-confirm="{{ __('Apakah Anda yakin ingin menghapus modul ini?') }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-2xs font-bold transition shadow-xs">
                                            {{ __('Hapus') }}
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </article>
                    </template>
                </div>
            </section>
        </div>
    </div>
</div>
@include('courses.partials.quiz-card')
