<!-- Custom Layout for Chapter 4 - Hybrid Style (Top-Tabs + Auto-Open Subsections) -->
<div class="py-6 select-none" x-data="{
    modules: @js($modules->values()),
    activeTab: '4.1',
    activeSectionId: null,
    completedModuleIds: @js($learningProgress ? $learningProgress['completedModules']->values()->toArray() : []),
    completeUrlTemplate: @js(route('courses.modules.complete', [$course->id, $chapter->id, '__MODULE__'])),
    csrfToken: @js(csrf_token()),

    get tabs() {
        const uniqueTabs = new Set();
        this.modules.forEach(m => {
            const match = m.title.match(/^(4\.\d+)/);
            if (match) uniqueTabs.add(match[1]);
        });
        return Array.from(uniqueTabs).sort((a, b) => parseInt(a.split('.')[1]) - parseInt(b.split('.')[1]));
    },
    init() {
        if (!this.tabs.includes(this.activeTab) && this.tabs.length > 0) {
            this.activeTab = this.tabs[0];
        }
        this.markTabComplete(this.activeTab);
    },
    setActiveTab(tab) {
        this.activeTab = tab;
        // Stop TTS when switching tabs
        if (window.LmsTTS) window.LmsTTS.stop();
        this.markTabComplete(tab);
        this.$nextTick(() => {
            document.getElementById('content-area-chapter-4')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    },
    markTabComplete(tab) {
        // Mark main tab module complete
        const mainMod = this.getSingleModule(tab);
        if (mainMod && mainMod.id) {
            if (mainMod.content.includes('<details')) {
                window.setupDetailsTracker(mainMod.id, 'content-area-chapter-4');
            } else {
                this.markModuleComplete(mainMod.id);
            }
        }
        
        // Mark all submodules complete automatically when viewing this tab
        let subModules = [];
        if (tab === '4.6') {
            subModules = this.modules.filter(m => m.title.startsWith('4.6.'));
        } else if (tab === '4.7') {
            subModules = [];
        } else {
            subModules = this.getTabModules(tab);
        }
        
        subModules.forEach(sub => {
            if (sub && sub.id) {
                this.markModuleComplete(sub.id);
            }
        });
    },
    getTabModules(tab) {
        return this.modules.filter(m => m.title.startsWith(tab + '.') && m.title !== tab);
    },
    getSingleModule(tab) {
        let m = this.modules.find(m => m.title === tab || m.title.startsWith(tab + ' '));
        if (!m) m = this.modules.find(m => m.title.startsWith(tab));
        return m || { title: tab, content: '' };
    },
    markModuleComplete(moduleId) {
        const idNum = Number(moduleId);
        if (!Number.isInteger(idNum) || !this.completeUrlTemplate) return;
        if (this.completedModuleIds.includes(idNum)) return;
        
        fetch(this.completeUrlTemplate.replace('__MODULE__', moduleId), {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': this.csrfToken,
                'Accept': 'application/json',
            },
        }).then(res => {
            if (res.ok) {
                this.completedModuleIds.push(idNum);
            }
        });
    },
    isTabComplete(tab) {
        const mainMod = this.getSingleModule(tab);
        if (mainMod && mainMod.id && !this.completedModuleIds.includes(Number(mainMod.id))) {
            return false;
        }
        
        let subModules = [];
        if (tab === '4.6') {
            subModules = this.modules.filter(m => m.title.startsWith('4.6.'));
        } else if (tab === '4.7') {
            subModules = this.modules.filter(m => m.title.startsWith('4.7.'));
        } else {
            subModules = this.getTabModules(tab);
        }
        
        return subModules.every(sub => !sub.id || this.completedModuleIds.includes(Number(sub.id)));
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
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

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
                {{ __('Materi modul pembelajaran tertulis. Gunakan menu tab di bawah untuk memilih sub-bab secara cepat atau gunakan tombol navigasi di bawah halaman untuk membaca secara berurutan.') }}
            </p>
        </div>

        @include('courses.partials.interactive-diagram-section')

        <!-- Horizontal Sub-Chapter Tab Navigation Bar -->
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col gap-3">
            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">{{ __('Pilih Sub-Bab Utama') }}</div>
            <div class="flex flex-wrap gap-2">
                <template x-for="tab in tabs" :key="tab">
                    <button
                        @click="setActiveTab(tab)"
                        class="px-4 py-2.5 rounded-lg text-sm font-bold transition text-left"
                        :class="activeTab === tab ? 'bg-blue-600 text-white shadow-sm' : 'bg-slate-50 text-slate-600 hover:bg-slate-100 hover:text-slate-800'"
                    >
                        <span x-text="tab === '4.6' ? '4.6 Checklist Inspeksi' : (tab === '4.7' ? '4.7 Troubleshooting' : getSingleModule(tab).title)"></span>
                    </button>
                </template>
            </div>
        </div>

        <!-- Main Content Card (Centered) -->
        <div id="content-area-chapter-4" class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden p-6 md:p-8 space-y-6 scroll-mt-24">
            
            <!-- Sub-chapter Title & Main Description -->
            <div class="border-b border-slate-100 pb-5" x-show="activeTab !== '4.6' && activeTab !== '4.7'">
                <div class="flex items-center justify-between flex-wrap gap-2">
                    <h3 class="text-base md:text-base font-extrabold text-slate-800" x-text="getSingleModule(activeTab).title"></h3>
                    {{-- TTS Button Chapter 4 Main Tab --}}
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
                                :data-tts-id="'ch4main_' + getSingleModule(activeTab).id"
                                @click="window.ttsToggle('ch4main_' + getSingleModule(activeTab).id, getSingleModule(activeTab).content, 'ch4main-tts-content')"
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
                <div id="ch4main-tts-content" class="text-sm text-slate-600 leading-relaxed mt-3.5 prose prose-slate max-w-none prose-sm" x-html="getSingleModule(activeTab).content"></div>
                
                <!-- Action Buttons for Instructor inside Intro Card -->
                @if(auth()->user()->isInstruktur())
                    <template x-if="getSingleModule(activeTab).id">
                        <div class="flex items-center gap-2 pt-4 border-t border-slate-50 mt-4">
                            <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + getSingleModule(activeTab).id + '/edit'" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-xs font-bold transition shadow-xs">
                                {{ __('Edit Deskripsi Pengantar') }}
                            </a>
                        </div>
                    </template>
                @endif
            </div>

            <!-- 1. Display for tabs 4.1 to 4.5: All submodules fully open (No accordions!) -->
            <template x-if="activeTab !== '4.6' && activeTab !== '4.7'">
                <div class="space-y-8 divide-y divide-slate-100">
                    <template x-for="subModule in getTabModules(activeTab)" :key="subModule.id">
                        <div :id="'module-' + subModule.id" :data-module-id="subModule.id" class="pt-8 first:pt-0">
                            <div class="flex items-center justify-between flex-wrap gap-2">
                                <h4 class="text-sm md:text-base font-bold text-slate-800" x-text="subModule.title"></h4>
                                {{-- TTS Button Chapter 4 Sub-module --}}
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
                                        :data-tts-id="'ch4sub_' + subModule.id"
                                        @click="window.ttsToggle('ch4sub_' + subModule.id, subModule.content, 'ch4sub-tts-' + subModule.id)"
                                        title="{{ app()->getLocale() === 'en' ? 'Listen to Sub-chapter' : 'Dengarkan Suara Subab' }}"
                                    >
                                        <span class="tts-icon">
                                            <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
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
                            </div>
                            <div :id="'ch4sub-tts-' + subModule.id" class="text-sm text-slate-600 leading-relaxed prose prose-slate max-w-none prose-sm" x-html="subModule.content"></div>
                            
                            <!-- Interactive Diagram for Sub-Module -->
                            <template x-if="subModule.diagram || @js(auth()->user()->isInstruktur())">
                                <div class="my-6 p-4 rounded-2xl border border-slate-100 bg-slate-50/50 shadow-2xs"
                                    x-data="moduleDiagramData(
                                        subModule.diagram,
                                        subModule.diagram ? subModule.diagram.hotspots : [],
                                        {{ $course->id }},
                                        {{ $chapter->id }},
                                        subModule.id,
                                        @js(route('courses.modules.diagram.store', [$course->id, $chapter->id, '__MODULE__'])).replace('__MODULE__', subModule.id),
                                        @js(route('courses.modules.diagram.destroy', [$course->id, $chapter->id, '__MODULE__'])).replace('__MODULE__', subModule.id),
                                        @js(route('courses.modules.hotspots.store', [$course->id, $chapter->id, '__MODULE__'])).replace('__MODULE__', subModule.id),
                                        @js(route('courses.modules.hotspots.update', [$course->id, $chapter->id, '__MODULE__'])).replace('__MODULE__', subModule.id),
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
                            </template>
                            
                            <!-- Action Buttons for Instructor inside Submodule -->
                            @if(auth()->user()->isInstruktur())
                                <div class="flex items-center gap-2 mt-4 pt-2">
                                    <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + subModule.id + '/edit'" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-xs font-bold transition shadow-xs">
                                        {{ __('Edit Modul Ini') }}
                                    </a>
                                    <form :action="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + subModule.id" method="POST" data-confirm="{{ __('Apakah Anda yakin ingin menghapus modul ini?') }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-xs font-bold transition shadow-xs">
                                            {{ __('Hapus Modul') }}
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </template>
                </div>
            </template>

            <!-- 2. Display for tab 4.6 (Checklist): 4.6.1 & 4.6.2 open, 4.6.3 & 4.6.4 in native details accordions -->
            <template x-if="activeTab === '4.6'">
                <div class="space-y-8">
                    <!-- 4.6.1 -->
                    <template x-if="getSingleModule('4.6.1').id">
                        <div class="pt-4 first:pt-0">
                            <div class="flex items-center justify-between flex-wrap gap-2 mb-3">
                                <h4 class="text-sm md:text-base font-bold text-slate-800" x-text="getSingleModule('4.6.1').title"></h4>
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
                                        data-tts-id="ch4-tab461"
                                        @click="window.ttsToggle('ch4-tab461', getSingleModule('4.6.1').content, 'ch4-tts-461')"
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
                            </div>
                            <div id="ch4-tts-461" class="text-sm text-slate-600 leading-relaxed prose prose-slate max-w-none prose-sm" x-html="getSingleModule('4.6.1').content"></div>
                            
                            @if(auth()->user()->isInstruktur())
                                <div class="flex items-center gap-2 mt-4 pt-2">
                                    <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + getSingleModule('4.6.1').id + '/edit'" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-xs font-bold transition shadow-xs">
                                        {{ __('Edit Modul Ini') }}
                                    </a>
                                    <form :action="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + getSingleModule('4.6.1').id" method="POST" data-confirm="{{ __('Apakah Anda yakin ingin menghapus modul ini?') }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-xs font-bold transition shadow-xs">
                                            {{ __('Hapus Modul') }}
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </template>

                    <!-- 4.6.2 -->
                    <template x-if="getSingleModule('4.6.2').id">
                        <div class="pt-6 border-t border-slate-100">
                            <div class="flex items-center justify-between flex-wrap gap-2 mb-3">
                                <h4 class="text-sm md:text-base font-bold text-slate-800" x-text="getSingleModule('4.6.2').title"></h4>
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
                                        data-tts-id="ch4-tab462"
                                        @click="window.ttsToggle('ch4-tab462', getSingleModule('4.6.2').content, 'ch4-tts-462')"
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
                            </div>
                            <div id="ch4-tts-462" class="text-sm text-slate-600 leading-relaxed prose prose-slate max-w-none prose-sm" x-html="getSingleModule('4.6.2').content"></div>
                            
                            @if(auth()->user()->isInstruktur())
                                <div class="flex items-center gap-2 mt-4 pt-2">
                                    <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + getSingleModule('4.6.2').id + '/edit'" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-xs font-bold transition shadow-xs">
                                        {{ __('Edit Modul Ini') }}
                                    </a>
                                    <form :action="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + getSingleModule('4.6.2').id" method="POST" data-confirm="{{ __('Apakah Anda yakin ingin menghapus modul ini?') }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-xs font-bold transition shadow-xs">
                                            {{ __('Hapus Modul') }}
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </template>

                    <!-- 4.6.3 Inspeksi Bulanan (Native details) -->
                    <div class="pt-6 border-t border-slate-100">
                        <details class="group rounded-xl border border-slate-200 bg-white shadow-xs overflow-hidden" open>
                            <summary class="flex items-center justify-between gap-3 cursor-pointer select-none px-4 py-3 bg-slate-50 hover:bg-slate-100 transition-colors duration-150 list-none">
                                <span class="font-bold text-slate-800 text-sm uppercase tracking-wide">4.6.3 Inspeksi Bulanan</span>
                                <svg class="w-4 h-4 text-slate-500 transition-transform duration-200 group-open:rotate-180 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                            </summary>
                            <div class="border-t border-slate-100 bg-white p-4 space-y-6 divide-y divide-slate-100">
                                <template x-for="subModule in modules.filter(m => m.title.startsWith('4.6.3.'))" :key="subModule.id">
                                    <div class="pt-6 first:pt-0">
                                        <div class="flex items-center justify-between flex-wrap gap-2 mb-2">
                                        <h5 class="font-bold text-slate-800 text-sm" x-text="subModule.title"></h5>
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
                                                :data-tts-id="'ch4-463sub_' + subModule.id"
                                                @click="window.ttsToggle('ch4-463sub_' + subModule.id, subModule.content, 'ch4-463sub-tts-' + subModule.id)"
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
                                    </div>
                                        <div :id="'ch4-463sub-tts-' + subModule.id" class="text-sm text-slate-600 leading-relaxed prose prose-slate max-w-none prose-sm" x-html="subModule.content"></div>
                                        
                                        @if(auth()->user()->isInstruktur())
                                            <div class="flex items-center gap-2 mt-4 pt-2">
                                                <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + subModule.id + '/edit'" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-xs font-bold transition shadow-xs">
                                                    {{ __('Edit Tabel Ini') }}
                                                </a>
                                                <form :action="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + subModule.id" method="POST" data-confirm="{{ __('Apakah Anda yakin ingin menghapus tabel ini?') }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-xs font-bold transition shadow-xs">
                                                        {{ __('Hapus Tabel') }}
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                </template>
                            </div>
                        </details>
                    </div>

                    <!-- 4.6.4 Inspeksi Quartal (Native details) -->
                    <div class="pt-6 border-t border-slate-100">
                        <details class="group rounded-xl border border-slate-200 bg-white shadow-xs overflow-hidden" open>
                            <summary class="flex items-center justify-between gap-3 cursor-pointer select-none px-4 py-3 bg-slate-50 hover:bg-slate-100 transition-colors duration-150 list-none">
                                <span class="font-bold text-slate-800 text-sm uppercase tracking-wide">4.6.4 Inspeksi Quartal</span>
                                <svg class="w-4 h-4 text-slate-500 transition-transform duration-200 group-open:rotate-180 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                            </summary>
                            <div class="border-t border-slate-100 bg-white p-4 space-y-6 divide-y divide-slate-100">
                                <template x-for="subModule in modules.filter(m => m.title.startsWith('4.6.4.'))" :key="subModule.id">
                                    <div class="pt-6 first:pt-0">
                                        <div class="flex items-center justify-between flex-wrap gap-2 mb-2">
                                        <h5 class="font-bold text-slate-800 text-sm" x-text="subModule.title"></h5>
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
                                                :data-tts-id="'ch4-464sub_' + subModule.id"
                                                @click="window.ttsToggle('ch4-464sub_' + subModule.id, subModule.content, 'ch4-464sub-tts-' + subModule.id)"
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
                                    </div>
                                        <div :id="'ch4-464sub-tts-' + subModule.id" class="text-sm text-slate-600 leading-relaxed prose prose-slate max-w-none prose-sm" x-html="subModule.content"></div>
                                        
                                        @if(auth()->user()->isInstruktur())
                                            <div class="flex items-center gap-2 mt-4 pt-2">
                                                <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + subModule.id + '/edit'" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-xs font-bold transition shadow-xs">
                                                    {{ __('Edit Tabel Ini') }}
                                                </a>
                                                <form :action="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + subModule.id" method="POST" data-confirm="{{ __('Apakah Anda yakin ingin menghapus tabel ini?') }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-xs font-bold transition shadow-xs">
                                                        {{ __('Hapus Tabel') }}
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                </template>
                            </div>
                        </details>
                    </div>
                </div>
            </template>

            <!-- 3. Display for tab 4.7 (Troubleshooting): Accordions list -->
            <template x-if="activeTab === '4.7'">
                <div class="space-y-4">
                    <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">{{ __('Daftar Troubleshooting (Klik untuk membuka detail):') }}</div>
                    <div class="space-y-3">
                        <template x-for="subModule in modules.filter(m => m.title.startsWith('4.7.') && m.title !== '4.7')" :key="subModule.id">
                            <div class="rounded-xl border border-slate-100 bg-white overflow-hidden shadow-xs">
                                <button
                                    type="button"
                                    @click="activeSectionId = activeSectionId === subModule.id ? null : subModule.id; if(activeSectionId === subModule.id) markModuleComplete(subModule.id);"
                                    class="w-full flex items-center justify-between gap-4 bg-slate-50/50 px-4 py-3.5 text-left transition hover:bg-slate-50"
                                >
                                    <span class="text-sm font-bold text-slate-800" x-text="subModule.title"></span>
                                    <span
                                        class="inline-flex h-7 w-7 shrink-0 items-center justify-center rounded-full border border-slate-200 bg-white text-sm font-black text-slate-600 transition"
                                        x-text="activeSectionId === subModule.id ? '-' : '+'"
                                    ></span>
                                </button>

                                <div x-show="activeSectionId === subModule.id" class="border-t border-slate-100 bg-white">
                                    <div class="p-4 md:p-6 space-y-4">
                                        {{-- TTS Button Chapter 4 Tab 4.7 Troubleshooting --}}
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
                                                :data-tts-id="'ch4-47_' + subModule.id"
                                                @click="window.ttsToggle('ch4-47_' + subModule.id, subModule.content, 'ch4-47-tts-' + subModule.id)"
                                                title="{{ app()->getLocale() === 'en' ? 'Listen to Sub-chapter' : 'Dengarkan Suara Subab' }}"
                                            >
                                                <span class="tts-icon">
                                                    <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
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
                                        <div :id="'ch4-47-tts-' + subModule.id" class="text-sm text-slate-600 leading-relaxed space-y-3.5 prose prose-slate max-w-none prose-sm" x-html="subModule.content"></div>
                                        
                                        @if(auth()->user()->isInstruktur())
                                            <div class="flex items-center gap-2 pt-4 border-t border-slate-100">
                                                <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + subModule.id + '/edit'" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-xs font-bold transition shadow-xs">
                                                    {{ __('Edit Tabel Trouble Ini') }}
                                                </a>
                                                <form :action="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + subModule.id" method="POST" data-confirm="{{ __('Apakah Anda yakin ingin menghapus tabel trouble ini?') }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-xs font-bold transition shadow-xs">
                                                        {{ __('Hapus Tabel Trouble') }}
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </template>

            <!-- Prev/Next Navigation Buttons at the bottom of Content Card -->
            <div class="border-t border-slate-100 pt-6 flex items-center justify-between gap-4">
                <button
                    @click="prevTab()"
                    class="px-4 py-2 bg-slate-50 hover:bg-slate-100 text-slate-600 text-sm font-bold rounded-lg transition"
                    x-show="tabs.indexOf(activeTab) > 0"
                >
                    &larr; {{ __('Kembali') }}
                </button>
                <div x-show="tabs.indexOf(activeTab) === 0"></div>

                <button
                    @click="nextTab()"
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-lg transition shadow-xs"
                    x-show="tabs.indexOf(activeTab) < tabs.length - 1"
                >
                    {{ __('Lanjutkan') }} &rarr;
                </button>
                <div x-show="tabs.indexOf(activeTab) === tabs.length - 1"></div>
            </div>

        </div>

    </div>
</div>

@include('courses.partials.quiz-card')
