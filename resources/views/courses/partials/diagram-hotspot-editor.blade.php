{{-- Modal 1: Upload / Replace Diagram Image --}}
@if(auth()->user()->isInstruktur())
<div x-show="showUploadModal" 
     @open-upload-diagram-modal.window="showUploadModal = true"
     @click.self="showUploadModal = false"
     x-cloak
     class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm transition-opacity"
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-150"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">
    <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full p-6 overflow-hidden border border-slate-100" @click.stop>
        <div class="flex justify-between items-center pb-4 border-b border-slate-100">
            <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span>Upload / Ganti Diagram Gambar</span>
            </h3>
            <button type="button" @click="showUploadModal = false" class="text-slate-400 hover:text-slate-600 rounded-lg p-1 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <form @submit.prevent="uploadDiagram($event)" class="mt-4 space-y-4">
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Pilih Lokasi Modul / Bab</label>
                <select name="target_module_id" class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-xs font-semibold text-slate-800 outline-none transition">
                    <option value="chapter">-- Diagram Utama Bab (Peta Lokasi Umum) --</option>
                    @if(isset($modules) && count($modules) > 0)
                        @foreach($modules as $mod)
                            <option value="{{ $mod->id }}" :selected="typeof module !== 'undefined' && module.id == {{ $mod->id }}">Modul {{ $mod->title }}</option>
                        @endforeach
                    @endif
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">File Gambar Diagram</label>
                <div class="border-2 border-dashed border-slate-200 hover:border-blue-500 rounded-xl p-6 text-center bg-slate-50/50 transition cursor-pointer relative"
                     @dragover.prevent=""
                     @drop.prevent="handleFileDrop($event)">
                    <input type="file" name="image" id="diagram-upload-input" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full" @change="previewImage($event)">
                    <div x-show="!imagePreview" class="space-y-2">
                        <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center mx-auto text-xl font-bold">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        </div>
                        <p class="text-sm font-semibold text-slate-700">Pilih atau Seret Gambar di sini</p>
                        <p class="text-xs text-slate-400">JPG, PNG, WebP, atau SVG (Maks. 5MB)</p>
                    </div>
                    <div x-show="imagePreview" class="space-y-3" x-cloak>
                        <img :src="imagePreview" class="max-h-48 mx-auto rounded-lg shadow-sm border border-slate-200 object-contain">
                        <p class="text-xs text-blue-600 font-semibold" x-text="imageFileName"></p>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                <div>
                    <button type="button" x-show="diagramObj" @click="showUploadModal = false; confirmDeleteDiagram()" class="px-3 py-2 text-xs font-bold text-red-600 hover:bg-red-50 rounded-xl transition border border-red-100 flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        <span>Hapus Gambar Diagram</span>
                    </button>
                </div>
                <div class="flex items-center gap-2">
                    <button type="button" @click="showUploadModal = false" class="px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100 rounded-xl transition">
                        Batal
                    </button>
                    <button type="submit" :disabled="uploading" class="px-5 py-2 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-lg shadow-blue-500/20 transition disabled:opacity-50 flex items-center gap-2">
                        <span x-show="!uploading">Simpan Diagram</span>
                        <span x-show="uploading" class="flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4 text-white" viewBox="0 0 24 24" fill="none"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                            Mengunggah...
                        </span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Modal 2: Add / Edit Hotspot Modal --}}
<div x-show="showHotspotFormModal" 
     @click.self="showHotspotFormModal = false"
     x-cloak
     class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm transition-opacity"
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-150"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">
    <div class="relative bg-white rounded-2xl shadow-2xl max-w-lg w-full p-6 overflow-hidden border border-slate-100" @click.stop>
        <div class="flex justify-between items-center pb-4 border-b border-slate-100">
            <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                <span x-text="activeHotspot.id ? 'Edit Hotspot' : 'Tambah Hotspot Baru'"></span>
            </h3>
            <button type="button" @click="showHotspotFormModal = false" class="text-slate-400 hover:text-slate-600 rounded-lg p-1 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <form @submit.prevent="saveHotspotForm()" class="mt-4 space-y-4">
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Label Hotspot</label>
                <input type="text" x-model="activeHotspot.label" required placeholder="Contoh: Titik 1 atau Katup Utama" 
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm font-semibold text-slate-800 outline-none transition">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Tipe Aksi Hotspot</label>
                <div class="grid grid-cols-2 gap-3">
                    <button type="button"
                            @click.prevent="activeHotspot.action_type = 'navigate'"
                            class="relative flex flex-col p-3 rounded-xl border-2 text-left cursor-pointer transition focus:outline-none"
                            :class="activeHotspot.action_type !== 'popup' ? 'border-blue-500 bg-blue-50/40 text-blue-900' : 'border-slate-200 hover:border-slate-300 text-slate-700'">
                        <div class="flex items-center gap-2 font-bold text-sm">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                            <span>Navigasi Subbab</span>
                        </div>
                        <span class="text-[11px] text-slate-500 mt-1">Scroll langsung ke Modul/Subbab tertentu</span>
                    </button>

                    <button type="button"
                            @click.prevent="activeHotspot.action_type = 'popup'"
                            class="relative flex flex-col p-3 rounded-xl border-2 text-left cursor-pointer transition focus:outline-none"
                            :class="activeHotspot.action_type === 'popup' ? 'border-blue-500 bg-blue-50/40 text-blue-900' : 'border-slate-200 hover:border-slate-300 text-slate-700'">
                        <div class="flex items-center gap-2 font-bold text-sm">
                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            <span>Pop-Up Informasi</span>
                        </div>
                        <span class="text-[11px] text-slate-500 mt-1">Tampilkan modal info penjelasan singkat</span>
                    </button>
                </div>
            </div>

            {{-- Fields for Navigate Action --}}
            <div x-show="activeHotspot.action_type !== 'popup'" class="space-y-2">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Target Modul / Subbab</label>
                <select x-model="activeHotspot.target_module_id" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm font-medium text-slate-800 outline-none transition">
                    <option value="">-- Pilih Modul Tujuan --</option>
                    @foreach($chapter->modules as $mod)
                        <option value="{{ $mod->id }}">{{ $loop->iteration }}. {{ $mod->title }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Fields for Pop-up Action --}}
            <div x-show="activeHotspot.action_type === 'popup'" class="space-y-3">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Judul Pop-Up</label>
                    <input type="text" x-model="activeHotspot.popup_title" placeholder="Contoh: Penjelasan Pompa Utama" 
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm font-semibold text-slate-800 outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Isi Penjelasan Pop-Up</label>
                    <textarea x-model="activeHotspot.popup_content" rows="3" placeholder="Tuliskan penjelasan rinci mengenai komponen ini..." 
                              class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm font-medium text-slate-800 outline-none transition resize-none"></textarea>
                </div>
            </div>

            <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                <div>
                    <button type="button" x-show="activeHotspot.id" @click="deleteHotspot(activeHotspot.id)" class="px-3 py-2 text-xs font-bold text-red-700 bg-red-50 hover:bg-red-100 border border-red-200 rounded-xl transition flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        <span>Hapus 1 Hotspot Ini</span>
                    </button>
                </div>
                <div class="flex items-center gap-2">
                    <button type="button" @click="showHotspotFormModal = false" class="px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100 rounded-xl transition">
                        Batal
                    </button>
                    <button type="submit" :disabled="savingHotspot" class="px-5 py-2 text-sm font-bold text-white bg-green-600 hover:bg-green-700 rounded-xl shadow-lg shadow-green-600/20 transition disabled:opacity-50 flex items-center gap-2">
                        <span x-show="!savingHotspot">Simpan</span>
                        <span x-show="savingHotspot">Menyimpan...</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endif

{{-- Modal 3: Pop-Up Information Modal (Viewable by Students & Instructors) --}}
<div x-show="activePopupHotspot" 
     @click.self="activePopupHotspot = null"
     x-cloak
     class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm transition-opacity"
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-150"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">
    <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full p-6 overflow-hidden border border-slate-100" @click.stop>
        <div class="flex justify-between items-start pb-3 border-b border-slate-100">
            <div class="flex items-center gap-3">
                <span class="w-9 h-9 rounded-full bg-blue-100 text-blue-600 font-bold flex items-center justify-center text-sm shadow-sm" x-text="activePopupHotspot?.label || 'i'"></span>
                <h3 class="text-base font-bold text-slate-800" x-text="activePopupHotspot?.popup_title || activePopupHotspot?.label"></h3>
            </div>
            <button @click="activePopupHotspot = null" class="text-slate-400 hover:text-slate-600 rounded-lg p-1 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <div class="mt-4 space-y-3">
            <div class="text-sm text-slate-600 leading-relaxed whitespace-pre-line font-medium" x-text="activePopupHotspot?.popup_content || 'Tidak ada deskripsi tambahan.'"></div>
        </div>

        <div class="mt-6 flex justify-end">
            <button @click="activePopupHotspot = null" class="px-4 py-2 text-sm font-bold text-white bg-slate-800 hover:bg-slate-900 rounded-xl transition">
                Tutup
            </button>
        </div>
    </div>
</div>
