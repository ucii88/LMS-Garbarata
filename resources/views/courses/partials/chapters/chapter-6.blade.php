<!-- Custom Layout for Chapter 6 showing all catalogs as accordions directly -->
<div class="py-6 select-none" x-data="{
    modules: @js($modules->values()),
    expandedModuleId: null,
    completeUrlTemplate: @js(route('courses.modules.complete', [$course->id, $chapter->id, '__MODULE__'])),
    csrfToken: @js(csrf_token()),

    toggleModule(id) {
        this.expandedModuleId = this.expandedModuleId === id ? null : id;
        if (this.expandedModuleId === id) {
            this.markModuleComplete(id);
        }
    },

    markModuleComplete(moduleId) {
        if (!moduleId) return;
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

        <!-- Chapter Header Description Card -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-6">
            <h3 class="font-bold text-gray-800 text-base">
                {{ str_replace("BAB {$chapter->order}: ", "", $chapter->title) }}
            </h3>
            <p class="text-sm text-gray-500 mt-1.5 leading-relaxed">
                {{ __('Halaman ini berisi katalog suku cadang dan komponen Garbarata dalam format PDF. Klik pada masing-masing judul katalog di bawah ini untuk membuka dokumen PDF terkait.') }}
            </p>
        </div>

        @include('courses.partials.interactive-diagram-section')

        <!-- List of Catalogs Accordions directly -->
        <div class="space-y-3">
            <template x-for="(module, index) in modules" :key="module.id">
                <div class="rounded-xl border border-gray-200 bg-white shadow-sm overflow-hidden">
                    <button
                        type="button"
                        @click="toggleModule(module.id)"
                        class="w-full flex items-center justify-between gap-3 cursor-pointer select-none px-5 py-4 bg-gradient-to-r from-slate-50 to-white hover:from-blue-50 hover:to-white transition-colors duration-200"
                    >
                        <div class="flex items-center gap-3">
                            <span class="flex-shrink-0 w-7 h-7 rounded-full bg-blue-600 text-white text-[11px] font-bold flex items-center justify-center shadow-sm" x-text="index + 1"></span>
                            <span class="font-semibold text-slate-800 text-base text-left" x-text="module.title"></span>
                        </div>
                        <svg class="w-4 h-4 text-slate-400 transition-transform duration-300 flex-shrink-0" :class="expandedModuleId === module.id ? 'rotate-180' : ''" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div x-show="expandedModuleId === module.id" class="border-t border-slate-100">
                        <div class="px-5 py-4 bg-slate-50/50 space-y-4">
                            <div class="text-sm text-slate-600 leading-relaxed max-w-none prose prose-slate prose-sm animate-fade-in" x-html="module.content"></div>
                            
                            <!-- Action Buttons for Instructor inside Accordion -->
                            @if(auth()->user()->isInstruktur())
                                <div class="flex items-center gap-2 pt-4 border-t border-slate-200">
                                    <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + module.id + '/edit'" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-xs font-bold transition shadow-xs">
                                        {{ __('Edit Katalog Ini') }}
                                    </a>
                                    <form :action="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + module.id" method="POST" data-confirm="{{ __('Apakah Anda yakin ingin menghapus katalog ini?') }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-xs font-bold transition shadow-xs">
                                            {{ __('Hapus Katalog') }}
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
</div>

@include('courses.partials.quiz-card')
