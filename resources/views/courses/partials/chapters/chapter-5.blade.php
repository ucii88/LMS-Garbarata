<!-- Custom Layout for Chapter 5 with Accordions for 5.1 -->
<div class="py-6 select-none" x-data="{
    modules: @js($modules->values()),
    activeTab: '5.1',
    expandedModuleId: null,
    completeUrlTemplate: @js(route('courses.modules.complete', [$course->id, $chapter->id, '__MODULE__'])),
    csrfToken: @js(csrf_token()),

    get tabs() {
        const uniqueTabs = new Set();
        this.modules.forEach(m => {
            const match = m.title.match(/^(\d+\.\d+)/);
            if (match) {
                uniqueTabs.add(match[1]);
            } else {
                uniqueTabs.add(m.title);
            }
        });
        return Array.from(uniqueTabs).sort((a, b) => {
            const matchA = a.match(/^(\d+)\.(\d+)/);
            const matchB = b.match(/^(\d+)\.(\d+)/);
            if (matchA && matchB) {
                return parseInt(matchA[2]) - parseInt(matchB[2]);
            }
            if (matchA) return -1;
            if (matchB) return 1;
            return a.localeCompare(b);
        });
    },
    init() {
        if (!this.tabs.includes(this.activeTab) && this.tabs.length > 0) {
            this.activeTab = this.tabs[0];
        }
        const initialModule = this.getSingleModule(this.activeTab);
        if (initialModule && initialModule.id) {
            if (initialModule.content.includes('<details')) {
                window.setupDetailsTracker(initialModule.id, 'content-area-chapter-5');
            } else {
                this.markModuleComplete(initialModule.id);
            }
        }
    },
    getTabModules(tab) {
        return this.modules.filter(m => m.title.startsWith(tab + '.') || m.title === tab);
    },
    getSingleModule(tab) {
        let m = this.modules.find(m => m.title === tab || m.title.startsWith(tab + ' ') || m.title.startsWith(tab + '.'));
        if (!m) m = this.modules.find(m => m.title.startsWith(tab));
        return m || { title: tab, content: '' };
    },
    toggleModule(id) {
        this.expandedModuleId = this.expandedModuleId === id ? null : id;
        if (this.expandedModuleId === id) {
            let dbId = id;
            if (isNaN(id)) {
                const m = this.getSingleModule(id);
                if (m) dbId = m.id;
            }
            this.markModuleComplete(dbId);
        }
    },
    markModuleComplete(moduleId) {
        if (!Number.isInteger(Number(moduleId)) || !this.completeUrlTemplate) return;
        fetch(this.completeUrlTemplate.replace('__MODULE__', moduleId), {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': this.csrfToken,
                'Accept': 'application/json',
            },
        });
    },
    setActiveTab(tab) {
        this.activeTab = tab;
        // Stop TTS when switching tabs
        if (window.LmsTTS) window.LmsTTS.stop();
        this.expandedModuleId = null;
        const m = this.getSingleModule(tab);
        if (m && m.id) {
            if (tab === '5.3') {
                this.markModuleComplete(m.id);
            } else if (m.content.includes('<details')) {
                window.setupDetailsTracker(m.id, 'content-area-chapter-5');
            } else {
                this.markModuleComplete(m.id);
            }
        }
        this.$nextTick(() => {
            document.getElementById('content-area-chapter-5')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    },
    nextTab() {
        const idx = this.tabs.indexOf(this.activeTab);
        if (idx !== -1 && idx < this.tabs.length - 1) {
            this.setActiveTab(this.tabs[idx + 1]);
        }
    },
    prevTab() {
        const idx = this.tabs.indexOf(this.activeTab);
        if (idx !== -1 && idx > 0) {
            this.setActiveTab(this.tabs[idx - 1]);
        }
    }
}">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6" id="content-area-chapter-5">

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

        <!-- Chapter Header Description Card -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-6">
            <h3 class="font-bold text-gray-800 text-base">
                {{ str_replace("BAB {$chapter->order}: ", "", $chapter->title) }}
            </h3>
            <p class="text-sm text-gray-500 mt-1.5 leading-relaxed">
                {{ __('Materi modul pembelajaran tertulis. Gunakan menu navigasi di bawah untuk memilih sub-bab dan membaca detail spesifikasi.') }}
            </p>
        </div>

        @if($diagram)
            @include('courses.partials.interactive-diagram-section')
        @endif

        <!-- Main Study Room Content -->
        <div class="space-y-6">
            
            <!-- 1. Top horizontal Sub-Chapter Navigation Bar -->
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-3">
                <div class="flex items-center space-x-2 shrink-0">
                    <span class="text-sm font-bold text-slate-700 uppercase tracking-wide">{{ __('Pilih Topik Sub-Bab:') }}</span>
                </div>
                <div class="flex flex-wrap gap-2">
                    <template x-for="tab in tabs" :key="tab">
                        <button
                            @click="setActiveTab(tab)"
                            class="px-4 py-2.5 rounded-lg text-sm font-bold transition text-left"
                            :class="activeTab === tab ? 'bg-blue-600 text-white shadow-sm' : 'bg-slate-50 text-slate-600 hover:bg-slate-100 hover:text-slate-800'"
                        >
                            <span x-text="getSingleModule(tab).title"></span>
                        </button>
                    </template>
                </div>
            </div>

            <!-- 2. Content Display Area -->
            <div>
                <!-- If Active Tab is 5.1 (Daftar Komponen) -> Show Accordions -->
                <div x-show="activeTab === '5.1'">
                    <div class="space-y-3">
                        @foreach($modules->filter(fn($m) => str_starts_with($m->title, '5.1')) as $module)
                            <div class="rounded-xl border border-gray-100 bg-white overflow-hidden shadow-sm">
                                <button
                                    type="button"
                                    @click="toggleModule({{ $module->id }})"
                                    class="w-full flex items-center justify-between gap-4 bg-white px-4 py-3.5 text-left transition hover:bg-slate-50"
                                >
                                    <span class="text-sm font-bold text-slate-800">{{ $module->title }}</span>
                                    <span
                                        class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-full border border-slate-200 bg-white text-base font-black text-slate-600 transition"
                                        x-text="expandedModuleId === {{ $module->id }} ? '-' : '+'"
                                    ></span>
                                </button>

                                <div x-show="expandedModuleId === {{ $module->id }}" class="border-t border-gray-100 bg-white">
                                    <div class="p-4 md:p-6 space-y-4">
                                        {{-- TTS Button Chapter 5 Accordion --}}
                                        <div class="tts-controls-group">
                                            <button
                                                type="button"
                                                class="tts-nav-btn"
                                                onclick="window.LmsTTS.prevParagraph()"
                                                title="{{ app()->getLocale() === 'en' ? 'Previous Paragraph' : 'Paragraf Sebelumnya' }}"
                                            >
                                                <svg class="w-3.5 h-3.5 text-slate-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                            </button>
                                            <button
                                                class="tts-btn tts-btn-idle"
                                                data-tts-id="ch5acc_{{ $module->id }}"
                                                @click="window.ttsToggle('ch5acc_{{ $module->id }}', @js($module->content), 'ch5acc-tts-{{ $module->id }}')"
                                                title="{{ app()->getLocale() === 'en' ? 'Listen to Sub-chapter' : 'Dengarkan Suara Subab' }}"
                                            >
                                                <span class="tts-icon">
                                                    <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
                                                </span>
                                                <span class="tts-label">{{ app()->getLocale() === 'en' ? 'Listen' : 'Dengarkan' }}</span>
                                            </button>
                                            <button
                                                type="button"
                                                class="tts-nav-btn"
                                                onclick="window.LmsTTS.nextParagraph()"
                                                title="{{ app()->getLocale() === 'en' ? 'Next Paragraph' : 'Paragraf Selanjutnya' }}"
                                            >
                                                <svg class="w-3.5 h-3.5 text-slate-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                            </button>
                                            <button
                                                type="button"
                                                class="tts-speed-btn"
                                                onclick="window.LmsTTS.cycleRate()"
                                                title="{{ app()->getLocale() === 'en' ? 'Change playback speed' : 'Klik untuk mengubah kecepatan suara' }}"
                                            >
                                                <svg class="w-3.5 h-3.5 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                                <span class="tts-speed-val">1x</span>
                                            </button>
                                        </div>

                                        <!-- Module Diagram Component -->
                                        @if($module->diagram || auth()->user()->isInstruktur())
                                            <div>
                                                <div class="my-6 p-4 rounded-2xl border border-slate-100 bg-slate-50/50 shadow-2xs"
                                                     x-data="moduleDiagramData(
                                                         @js($module->diagram),
                                                         @js($module->diagram ? $module->diagram->hotspots : []),
                                                         {{ $course->id }},
                                                         {{ $chapter->id }},
                                                         {{ $module->id }},
                                                         @js(route('courses.modules.diagram.store', [$course->id, $chapter->id, $module->id])),
                                                         @js(route('courses.modules.diagram.destroy', [$course->id, $chapter->id, $module->id])),
                                                         @js(route('courses.modules.hotspots.store', [$course->id, $chapter->id, $module->id])),
                                                         @js(route('courses.modules.hotspots.update', [$course->id, $chapter->id, $module->id])),
                                                         @js(csrf_token())
                                                     )"
                                                     @mousemove.window="editMode && onDrag($event)"
                                                     @mouseup.window="editMode && stopDrag()"
                                                     @touchmove.window="editMode && onDrag($event)"
                                                     @touchend.window="editMode && stopDrag()"
                                                >
                                                     @include('courses.partials.module-diagram-section')
                                                     @include('courses.partials.diagram-hotspot-editor')
                                                 </div>
                                            </div>
                                        @endif

                                        @php
                                            $cleanedContent = preg_replace('/<div class="relative mx-auto border border-slate-200 rounded-xl bg-white overflow-hidden shadow-sm my-6 aspect-\[[^\]]+\\][^\"]*\"[^>]*>.*?<\/div>/s', '', $module->content);
                                        @endphp

                                        <div id="ch5acc-tts-{{ $module->id }}" class="text-sm text-slate-600 leading-relaxed space-y-3.5 prose prose-slate max-w-none prose-sm">
                                            {!! $cleanedContent !!}
                                        </div>
                                        
                                        <!-- Action Buttons for Instructor inside Accordion -->
                                        @if(auth()->user()->isInstruktur())
                                            <div class="flex items-center gap-2 pt-4 border-t border-slate-100">
                                                <a href="/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/{{ $module->id }}/edit" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-xs font-bold transition shadow-xs">
                                                    {{ __('Edit Modul Ini') }}
                                                </a>
                                                <form action="/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/{{ $module->id }}" method="POST" data-confirm="{{ __('Apakah Anda yakin ingin menghapus modul ini?') }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-xs font-bold transition shadow-xs">
                                                        {{ __('Hapus Modul') }}
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- If Active Tab is not 5.1 -> Show Single Module Card -->
                <template x-if="activeTab !== '5.1'">
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                        <div class="p-6 md:p-8 space-y-6">
                            <div class="flex items-center justify-between flex-wrap gap-2">
                                <h3 class="text-base font-bold text-slate-800" x-text="getSingleModule(activeTab).title"></h3>
                                {{-- TTS Button Chapter 5 Main Content --}}
                                <template x-if="getSingleModule(activeTab).content">
                                    <div class="tts-controls-group">
                                        <button
                                            type="button"
                                            class="tts-nav-btn"
                                            onclick="window.LmsTTS.prevParagraph()"
                                            title="{{ app()->getLocale() === 'en' ? 'Previous Paragraph' : 'Paragraf Sebelumnya' }}"
                                        >
                                            <svg class="w-3.5 h-3.5 text-slate-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                        </button>
                                        <button
                                            class="tts-btn tts-btn-idle"
                                            :data-tts-id="'ch5main_' + getSingleModule(activeTab).id"
                                            @click="window.ttsToggle('ch5main_' + getSingleModule(activeTab).id, getSingleModule(activeTab).content, 'ch5main-tts-content')"
                                            title="{{ app()->getLocale() === 'en' ? 'Listen to Sub-chapter' : 'Dengarkan Suara Subab' }}"
                                        >
                                            <span class="tts-icon">
                                                <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
                                            </span>
                                            <span class="tts-label">{{ app()->getLocale() === 'en' ? 'Listen' : 'Dengarkan' }}</span>
                                        </button>
                                        <button
                                            type="button"
                                            class="tts-nav-btn"
                                            onclick="window.LmsTTS.nextParagraph()"
                                            title="{{ app()->getLocale() === 'en' ? 'Next Paragraph' : 'Paragraf Selanjutnya' }}"
                                        >
                                            <svg class="w-3.5 h-3.5 text-slate-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        </button>
                                        <button
                                            type="button"
                                            class="tts-speed-btn"
                                            onclick="window.LmsTTS.cycleRate()"
                                            title="{{ app()->getLocale() === 'en' ? 'Change playback speed' : 'Klik untuk mengubah kecepatan suara' }}"
                                        >
                                            <svg class="w-3.5 h-3.5 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                            <span class="tts-speed-val">1x</span>
                                        </button>
                                    </div>
                                </template>
                            </div>
                            
                            <div id="ch5main-tts-content" class="text-sm text-slate-600 leading-relaxed space-y-3.5 prose prose-slate max-w-none prose-sm" x-html="getSingleModule(activeTab).content"></div>
                            
                            <!-- Module Diagram Component for Single Module Tab -->
                            <div x-show="getSingleModule(activeTab).diagram || @js(auth()->user()->isInstruktur())">
                                <div class="my-6 p-4 rounded-2xl border border-slate-100 bg-slate-50/50 shadow-2xs"
                                    :key="getSingleModule(activeTab).id"
                                    x-data="moduleDiagramData(
                                        getSingleModule(activeTab).diagram,
                                        getSingleModule(activeTab).diagram ? getSingleModule(activeTab).diagram.hotspots : [],
                                        {{ $course->id }},
                                        {{ $chapter->id }},
                                        getSingleModule(activeTab).id,
                                        '/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + getSingleModule(activeTab).id + '/diagram',
                                        '/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + getSingleModule(activeTab).id + '/diagram',
                                        '/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + getSingleModule(activeTab).id + '/hotspots',
                                        '/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + getSingleModule(activeTab).id + '/hotspots',
                                        @js(csrf_token())
                                    )"
                                    @mousemove.window="editMode && onDrag($event)"
                                    @mouseup.window="editMode && stopDrag()"
                                    @touchmove.window="editMode && onDrag($event)"
                                    @touchend.window="editMode && stopDrag()"
                                >
                                    @include('courses.partials.module-diagram-section')
                                    @include('courses.partials.diagram-hotspot-editor')
                                </div>
                            </div>
                            
                            <!-- Action Buttons for Instructor -->
                            @if(auth()->user()->isInstruktur())
                                <template x-if="getSingleModule(activeTab).id">
                                    <div class="flex items-center gap-2 pt-4 border-t border-slate-100">
                                        <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + getSingleModule(activeTab).id + '/edit'" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-xs font-bold transition shadow-xs">
                                            {{ __('Edit Modul Ini') }}
                                        </a>
                                        <form :action="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + getSingleModule(activeTab).id" method="POST" data-confirm="{{ __('Apakah Anda yakin ingin menghapus modul ini?') }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-xs font-bold transition shadow-xs">
                                                {{ __('Hapus Modul') }}
                                            </button>
                                        </form>
                                    </div>
                                </template>
                            @endif
                        </div>
                    </div>
                </template>
            </div>

            <!-- Prev/Next Navigation Buttons at the bottom of Content Card -->
            <div class="border-t border-slate-100 pt-6 flex items-center justify-between gap-4">
                <button
                    @click="prevTab()"
                    class="px-4 py-2 bg-slate-50 hover:bg-slate-100 text-slate-600 text-xs font-bold rounded-lg transition"
                    x-show="tabs.indexOf(activeTab) > 0"
                >
                    {{ __('← Kembali') }}
                </button>
                <div x-show="tabs.indexOf(activeTab) === 0"></div>

                <button
                    @click="nextTab()"
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-lg transition shadow-xs"
                    x-show="tabs.indexOf(activeTab) < tabs.length - 1"
                >
                    {{ __('Lanjutkan →') }}
                </button>
                <div x-show="tabs.indexOf(activeTab) === tabs.length - 1"></div>
            </div>

        </div>
    </div>
</div>

@include('courses.partials.quiz-card')
