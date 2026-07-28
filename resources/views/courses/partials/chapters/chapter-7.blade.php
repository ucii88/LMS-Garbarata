<!-- Custom Blueprint/Electrical Diagram Layout for Chapter 7 -->
<div class="py-6 select-none" x-data="{
    modules: @js($modules->values()),
    activeModuleId: {{ $modules->first() ? $modules->first()->id : 'null' }},
    completeUrlTemplate: @js(route('courses.modules.complete', [$course->id, $chapter->id, '__MODULE__'])),
    csrfToken: @js(csrf_token()),
    zoom: 100,

    init() {
        this.markModuleComplete(this.activeModuleId);
    },

    setActiveModule(moduleId) {
        this.activeModuleId = moduleId;
        this.markModuleComplete(moduleId);
    },

    markModuleComplete(moduleId) {
        if (!moduleId) {
            return;
        }

        fetch(this.completeUrlTemplate.replace('__MODULE__', moduleId), {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': this.csrfToken,
                'Accept': 'application/json',
            },
        });
    },

    getActiveModule() {
        return this.modules.find(m => m.id == this.activeModuleId) || { title: '', content: '', image_path: null };
    },

    zoomIn() {
        if (this.zoom < 200) this.zoom += 25;
    },

    zoomOut() {
        if (this.zoom > 50) this.zoom -= 25;
    },

    resetZoom() {
        this.zoom = 100;
    },

    nextModule() {
        const index = this.modules.findIndex(m => m.id == this.activeModuleId);
        if (index !== -1 && index < this.modules.length - 1) {
            this.setActiveModule(this.modules[index + 1].id);
        }
    },

    prevModule() {
        const index = this.modules.findIndex(m => m.id == this.activeModuleId);
        if (index > 0) {
            this.setActiveModule(this.modules[index - 1].id);
        }
    },

    isFirst() {
        return this.modules.findIndex(m => m.id == this.activeModuleId) === 0;
    },

    isLast() {
        return this.modules.findIndex(m => m.id == this.activeModuleId) === this.modules.length - 1;
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
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-6">
            <div class="flex items-center space-x-3 border-b border-gray-100 pb-3 mb-3">
                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-blue-200 bg-white text-sm font-bold text-blue-600 shadow-sm">07</span>
                <h3 class="font-extrabold text-base text-slate-800 uppercase tracking-wider">
                    {{ str_replace("BAB {$chapter->order}: ", "", $chapter->title) }}
                </h3>
            </div>
            <p class="text-sm text-slate-500 leading-relaxed">
                {{ __('Halaman ini merupakan penampil lampiran gambar elektrikal (wiring diagram). Gunakan menu navigasi di bawah untuk memilih lembar gambar, dan gunakan kontrol zoom untuk memperbesar gambar agar diagram terbaca lebih jelas.') }}
            </p>
        </div>

        @include('courses.partials.interactive-diagram-section')

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Left Sidebar - List of Drawings -->
            <div class="lg:col-span-1 bg-white p-4 rounded-2xl border border-gray-100 shadow-sm flex flex-col gap-3">
                <span class="text-xs font-extrabold text-slate-400 uppercase tracking-wide px-1">{{ __('Daftar Lembar Gambar') }}</span>
                <div class="flex flex-col gap-1 max-h-[500px] overflow-y-auto pr-1">
                    <template x-for="(module, index) in modules" :key="module.id">
                        <button
                            @click="setActiveModule(module.id); resetZoom()"
                            class="w-full px-3 py-2.5 rounded-xl text-sm font-bold transition text-left flex items-start gap-2.5 border"
                            :class="activeModuleId == module.id ? 'bg-blue-600 text-white border-blue-600 shadow-sm' : 'bg-slate-50 text-slate-600 hover:bg-slate-100 hover:text-slate-800 border-transparent'"
                        >
                            <span class="flex-shrink-0 w-5 h-5 rounded-full bg-black/10 flex items-center justify-center text-[10px]" :class="activeModuleId == module.id ? 'bg-white/20 text-white' : 'text-slate-500'" x-text="index + 1"></span>
                            <span class="leading-tight pt-0.5" x-text="module.title"></span>
                        </button>
                    </template>
                </div>
            </div>

            <!-- Right Main Content Area - Blueprint Viewer -->
            <div class="lg:col-span-3 space-y-4">
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm flex flex-col overflow-hidden min-h-[600px]">
                    <!-- Toolbar -->
                    <div class="bg-slate-50 border-b border-gray-150 px-4 py-3 flex flex-wrap items-center justify-between gap-3 text-slate-800">
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-bold text-slate-800" x-text="getActiveModule().title"></span>
                        </div>
                        <div class="flex items-center gap-1 bg-white border border-gray-200 rounded-lg p-0.5">
                            <button @click="zoomOut()" class="p-1.5 text-slate-500 hover:text-slate-800 transition hover:bg-slate-100 rounded-md cursor-pointer" title="{{ __('Zoom Out') }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15"/>
                                </svg>
                            </button>
                            <span class="text-[10px] font-mono px-2 text-slate-600 w-12 text-center" x-text="zoom + '%'"></span>
                            <button @click="zoomIn()" class="p-1.5 text-slate-500 hover:text-slate-800 transition hover:bg-slate-100 rounded-md cursor-pointer" title="{{ __('Zoom In') }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                </svg>
                            </button>
                            <button @click="resetZoom()" class="p-1.5 text-slate-500 hover:text-slate-800 transition hover:bg-slate-100 rounded-md border-l border-gray-200 cursor-pointer" title="{{ __('Reset Zoom') }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 9V4.5M9 9H4.5M9 9L3 3m12 9V4.5m0 4.5H19.5M15 9l6-6M9 15v4.5M9 15H4.5M9 15l-6 6m12-6v4.5m0-4.5H19.5m-4.5 0l6 6"/>
                                </svg>
                            </button>
                        </div>
                        <div>
                            <a :href="'/' + getActiveModule().image_path" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white hover:bg-slate-50 transition text-slate-600 hover:text-slate-800 font-bold rounded-lg text-[10px] border border-gray-200 shadow-2xs">
                                {{ __('Buka Gambar Penuh') }}
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Image Container -->
                    <div class="flex-grow bg-slate-50/50 p-4 flex items-center justify-center overflow-auto relative select-none border-b border-gray-150" style="height: 550px;">
                        <template x-if="getActiveModule().image_path">
                            <div class="transition-all duration-200 ease-out origin-center" :style="'width: ' + zoom + '%; max-width: none;'">
                                <img :src="'/' + getActiveModule().image_path" class="w-full h-auto object-contain rounded shadow-md border border-gray-200 bg-white" :alt="getActiveModule().title" draggable="false">
                            </div>
                        </template>
                        <template x-if="!getActiveModule().image_path">
                            <div class="text-center text-slate-500">
                                <svg class="w-12 h-12 mx-auto mb-2 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375 3.75 0 11-.75 0 .375 3.75 0 01.75 0z"/>
                                </svg>
                                <span class="text-sm font-semibold text-slate-400">{{ __('Gambar tidak ditemukan') }}</span>
                            </div>
                        </template>
                    </div>

                    <!-- Description/Content (if any) -->
                    <div class="bg-white p-4" x-show="getActiveModule().content">
                        <div class="text-slate-600 text-sm leading-relaxed max-w-none prose prose-slate prose-sm" x-html="getActiveModule().content"></div>
                    </div>

                    @if(auth()->user()->isInstruktur())
                        <template x-if="activeModuleId">
                            <div class="bg-slate-50 border-t border-gray-100 p-4 flex gap-2 rounded-b-2xl">
                                <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + activeModuleId + '/edit'" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-xs font-bold transition shadow-xs">
                                    {{ __('Edit Lembar Gambar') }}
                                </a>
                                <form :action="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + activeModuleId" method="POST" data-confirm="{{ __('Apakah Anda yakin ingin menghapus lembar gambar ini?') }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-xs font-bold transition shadow-xs">
                                        {{ __('Hapus Lembar Gambar') }}
                                    </button>
                                </form>
                            </div>
                        </template>
                    @endif
                </div>

                <!-- Footer Navigation -->
                <div class="bg-white rounded-2xl border border-gray-100 p-4 shadow-sm flex items-center justify-between">
                    <button
                        @click="prevModule(); resetZoom()"
                        :disabled="isFirst()"
                        class="inline-flex items-center justify-center rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-bold text-slate-600 transition hover:bg-slate-50 disabled:opacity-50 disabled:cursor-not-allowed shadow-2xs"
                    >
                        {{ __('← Kembali') }}
                    </button>

                    <button
                        @click="nextModule(); resetZoom()"
                        :disabled="isLast()"
                        class="inline-flex items-center justify-center rounded-lg bg-slate-900 px-3.5 py-1.5 text-xs font-bold text-white transition hover:bg-slate-800 disabled:opacity-50 disabled:cursor-not-allowed shadow-2xs"
                    >
                        {{ __('Lanjutkan →') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
