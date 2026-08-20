<!-- Standard Layout for custom/new chapters with Sub-Bab Grouping (e.g. 8.1, 8.1.1, 8.1.2) -->
<div class="py-6 select-none" x-data="{
    modules: @js($modules->values()),
    activeTab: '',
    completedModuleIds: @js($learningProgress ? $learningProgress['completedModules']->values()->toArray() : []),
    completeUrlTemplate: @js(route('courses.modules.complete', [$course->id, $chapter->id, '__MODULE__'])),
    csrfToken: @js(csrf_token()),

    get tabs() {
        const uniqueTabs = new Set();
        this.modules.forEach(m => {
            if (!m || !m.title) return;
            const match = m.title.match(/^(\d+\.\d+)/);
            if (match) {
                uniqueTabs.add(match[1]);
            } else {
                uniqueTabs.add(m.title);
            }
        });
        const arr = Array.from(uniqueTabs);
        return arr.sort((a, b) => {
            const matchA = a.match(/^(\d+)\.(\d+)/);
            const matchB = b.match(/^(\d+)\.(\d+)/);
            if (matchA && matchB) {
                const chapterA = parseInt(matchA[1], 10);
                const chapterB = parseInt(matchB[1], 10);
                if (chapterA !== chapterB) return chapterA - chapterB;
                const subA = parseInt(matchA[2], 10);
                const subB = parseInt(matchB[2], 10);
                if (subA !== subB) return subA - subB;
            }
            return a.localeCompare(b);
        });
    },

    init() {
        if (this.tabs.length > 0) {
            this.activeTab = this.tabs[0];
        }
        window.setStudyModule = (targetId) => {
            if (!targetId) return;
            const str = String(targetId).trim().toLowerCase();
            const targetMod = this.modules.find(m => String(m.id) === str || (m.title && m.title.toLowerCase().includes(str)));
            if (targetMod) {
                const match = targetMod.title.match(/^(\d+\.\d+)/);
                if (match && this.tabs.includes(match[1])) {
                    this.setActiveTab(match[1]);
                } else if (this.tabs.includes(targetMod.title)) {
                    this.setActiveTab(targetMod.title);
                }
            }
        };
        const initialMod = this.getSingleModule(this.activeTab);
        if (initialMod && initialMod.id) {
            this.markModuleComplete(initialMod.id);
        }
    },

    setActiveTab(tab) {
        this.activeTab = tab;
        const mainMod = this.getSingleModule(tab);
        if (mainMod && mainMod.id) {
            this.markModuleComplete(mainMod.id);
        }
        this.getTabModules(tab).forEach(sub => {
            if (sub && sub.id) this.markModuleComplete(sub.id);
        });
    },

    getSingleModule(tab) {
        if (!tab) return { title: '', content: '', image_path: null };
        let m = this.modules.find(m => m.title === tab || m.title.startsWith(tab + ' '));
        if (!m) m = this.modules.find(m => m.title.startsWith(tab + '.'));
        if (!m) m = this.modules.find(m => m.title.startsWith(tab));
        return m || { title: tab, content: '', image_path: null };
    },

    getTabModules(tab) {
        if (!tab) return [];
        const mainMod = this.getSingleModule(tab);
        return this.modules.filter(m => m.id !== mainMod.id && (m.title.startsWith(tab + '.') || m.title.startsWith(tab + ' ')));
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
    },
    isFirst() {
        return this.tabs.indexOf(this.activeTab) <= 0;
    },
    isLast() {
        return this.tabs.indexOf(this.activeTab) >= this.tabs.length - 1;
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
                        <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
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
                @if($diagram)
                    {{ __('Materi pembelajaran interaktif dilengkapi visualisasi skematis. Klik pada titik-titik biru bernomor (hotspots) pada gambar atau pilih daftar sub-bab di bawah untuk membaca detail spesifikasi.') }}
                @else
                    {{ __('Materi modul pembelajaran tertulis. Gunakan menu navigasi di bawah untuk memilih topik sub-bab.') }}
                @endif
            </p>
        </div>

        @include('courses.partials.interactive-diagram-section')

        <!-- Main study room layout (Stacked, clean, and full width) -->
        <div class="space-y-6">
            
            <!-- 1. Top horizontal Sub-Chapter Navigation Bar -->
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col gap-3">
                <div class="flex items-center space-x-2 shrink-0">
                    <span class="text-sm font-bold text-slate-700 uppercase tracking-wide">{{ __('Pilih Topik Sub-Bab:') }}</span>
                </div>
                <div class="flex flex-wrap gap-2">
                    <template x-for="tab in tabs" :key="tab">
                        <button
                            @click="setActiveTab(tab)"
                            class="px-4 py-2.5 rounded-lg text-sm font-bold transition text-left cursor-pointer"
                            :class="activeTab === tab ? 'bg-blue-600 text-white shadow-sm' : 'bg-slate-50 text-slate-600 hover:bg-slate-100 hover:text-slate-800'"
                        >
                            <span x-text="getSingleModule(tab).title"></span>
                        </button>
                    </template>
                </div>
            </div>

            <!-- 2. Full-Width Content Reader Card -->
            <div id="study-content-reader" :id="'module-' + getSingleModule(activeTab).id" :data-module-id="getSingleModule(activeTab).id" class="bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between min-h-[250px] w-full">
                
                <!-- Article Content Area -->
                <div class="p-6 md:p-8 space-y-6">
                    <!-- Topic Badge & Nav Bar -->
                    <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                        <span class="rounded-full bg-slate-100 px-2.5 py-0.5 text-[9px] font-bold text-slate-500 uppercase tracking-wider">
                            Materi Pembelajaran
                        </span>
                        
                        <span class="text-[10px] text-gray-400 font-semibold">
                            Mode Belajar Mandiri
                        </span>
                    </div>

                    <!-- Main Sub-Bab Title and HTML Content -->
                    <div class="space-y-4">
                        <h2 class="text-lg font-bold text-slate-800 leading-snug" x-text="getSingleModule(activeTab).title">
                            Memuat materi...
                        </h2>

                        <template x-if="getSingleModule(activeTab).image_path">
                            <div class="rounded-xl border border-gray-200 bg-gray-50 p-3 shadow-sm my-3 max-w-2xl mx-auto">
                                <img :src="'/' + getSingleModule(activeTab).image_path" class="w-full max-h-72 object-contain rounded-lg select-none" :alt="getSingleModule(activeTab).title">
                            </div>
                        </template>

                        <template x-if="(getSingleModule(activeTab).diagrams && getSingleModule(activeTab).diagrams.length > 0) || getSingleModule(activeTab).diagram || @js(auth()->user()->isInstruktur())">
                            <div class="my-6 p-4 rounded-2xl border border-slate-100 bg-slate-50/50 shadow-2xs"
                                x-data="moduleDiagramData(
                                    (getSingleModule(activeTab).diagrams && getSingleModule(activeTab).diagrams.length > 0) ? getSingleModule(activeTab).diagrams : (getSingleModule(activeTab).diagram ? [getSingleModule(activeTab).diagram] : []),
                                    (getSingleModule(activeTab).diagrams && getSingleModule(activeTab).diagrams.length > 0) ? (getSingleModule(activeTab).diagrams[0].hotspots || []) : (getSingleModule(activeTab).diagram ? getSingleModule(activeTab).diagram.hotspots : []),
                                    {{ $course->id }},
                                    {{ $chapter->id }},
                                    getSingleModule(activeTab).id,
                                    @js(route('courses.modules.diagram.store', [$course->id, $chapter->id, '__MODULE__'])).replace('__MODULE__', getSingleModule(activeTab).id),
                                    @js(route('courses.modules.diagram.destroy', [$course->id, $chapter->id, '__MODULE__'])).replace('__MODULE__', getSingleModule(activeTab).id),
                                    @js(route('courses.modules.hotspots.store', [$course->id, $chapter->id, '__MODULE__'])).replace('__MODULE__', getSingleModule(activeTab).id),
                                    @js(route('courses.modules.hotspots.update', [$course->id, $chapter->id, '__MODULE__'])).replace('__MODULE__', getSingleModule(activeTab).id),
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

                        <!-- Active Module Content body (rendered with HTML) -->
                        <div class="text-sm text-slate-600 leading-relaxed space-y-3.5 prose prose-slate max-w-none prose-sm" x-html="getSingleModule(activeTab).content">
                            Memuat isi modul pembelajaran...
                        </div>

                        @if(auth()->user()->isInstruktur())
                            <template x-if="getSingleModule(activeTab).id">
                                <div class="flex items-center gap-2 pt-4 border-t border-slate-100">
                                    <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + getSingleModule(activeTab).id + '/edit'" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-xs font-bold transition shadow-xs flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        <span>Edit Modul Ini</span>
                                    </a>
                                    <form :action="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + getSingleModule(activeTab).id" method="POST" data-confirm="{{ __('Apakah Anda yakin ingin menghapus modul ini?') }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-xs font-bold transition shadow-xs flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            <span>Hapus Modul</span>
                                        </button>
                                    </form>
                                </div>
                            </template>
                        @endif
                    </div>

                    <!-- Nested Sub-Modules (e.g. 8.1.1, 8.1.2 under 8.1) -->
                    <template x-if="getTabModules(activeTab).length > 0">
                        <div class="mt-8 pt-6 border-t-2 border-slate-100 space-y-8">
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">
                                Sub-Bab & Detail Komponen
                            </h3>

                            <template x-for="subModule in getTabModules(activeTab)" :key="subModule.id">
                                <div :id="'module-' + subModule.id" :data-module-id="subModule.id" class="pt-6 first:pt-0 border-t border-slate-100 space-y-4">
                                    <h4 class="text-base font-bold text-slate-800 leading-snug" x-text="subModule.title"></h4>

                                    <template x-if="subModule.image_path">
                                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-3 shadow-xs my-3 max-w-2xl mx-auto">
                                            <img :src="'/' + subModule.image_path" class="w-full max-h-72 object-contain rounded-lg select-none" :alt="subModule.title">
                                        </div>
                                    </template>

                                    <template x-if="(subModule.diagrams && subModule.diagrams.length > 0) || subModule.diagram || @js(auth()->user()->isInstruktur())">
                                        <div class="my-6 p-4 rounded-2xl border border-slate-100 bg-slate-50/50 shadow-2xs"
                                            x-data="moduleDiagramData(
                                                (subModule.diagrams && subModule.diagrams.length > 0) ? subModule.diagrams : (subModule.diagram ? [subModule.diagram] : []),
                                                (subModule.diagrams && subModule.diagrams.length > 0) ? (subModule.diagrams[0].hotspots || []) : (subModule.diagram ? subModule.diagram.hotspots : []),
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

                                    <div class="text-sm text-slate-600 leading-relaxed space-y-3.5 prose prose-slate max-w-none prose-sm" x-html="subModule.content"></div>

                                    @if(auth()->user()->isInstruktur())
                                        <div class="flex items-center gap-2 pt-3 border-t border-slate-100">
                                            <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + subModule.id + '/edit'" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-xs font-bold transition shadow-xs flex items-center gap-1">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                <span>Edit Sub-Modul Ini</span>
                                            </a>
                                            <form :action="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + subModule.id" method="POST" data-confirm="{{ __('Apakah Anda yakin ingin menghapus sub-modul ini?') }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-xs font-bold transition shadow-xs flex items-center gap-1">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    <span>Hapus Sub-Modul</span>
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </template>
                        </div>
                    </template>
                </div>

                <!-- Footer Navigation inside Card -->
                <div class="border-t border-gray-100 p-4 bg-gray-50/50 flex items-center justify-between rounded-b-2xl">
                    <button
                        @click="prevTab()"
                        :disabled="isFirst()"
                        class="inline-flex items-center justify-center rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-bold text-slate-600 transition hover:bg-slate-50 disabled:opacity-50 disabled:cursor-not-allowed shadow-2xs cursor-pointer"
                    >
                        ← Sub-Bab Sebelumnya
                    </button>
                    
                    <button
                        @click="nextTab()"
                        :disabled="isLast()"
                        class="inline-flex items-center justify-center rounded-lg bg-slate-900 px-3.5 py-1.5 text-xs font-bold text-white transition hover:bg-slate-800 disabled:opacity-50 disabled:cursor-not-allowed shadow-2xs cursor-pointer"
                    >
                        Sub-Bab Selanjutnya →
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

@include('courses.partials.quiz-card')
