<!-- Module Interactive Diagram with Hotspots -->
<script>
    if (typeof window.moduleDiagramData !== 'function') {
        window.moduleDiagramData = function(diagramObj, hotspotsData, courseId, chapterId, moduleId, storeDiagramUrl, destroyDiagramUrl, storeHotspotUrl, updateHotspotsUrl, csrfToken) {
            return {
                editMode: false,
                addHotspotMode: false,
                saving: false,
                uploading: false,
                savingHotspot: false,
                showUploadModal: false,
                showHotspotFormModal: false,
                imagePreview: null,
                imageFileName: '',
                activePopupHotspot: null,
                activeHotspot: {
                    id: null,
                    label: '',
                    action_type: 'scroll_row',
                    target_module_id: '',
                    popup_title: '',
                    popup_content: '',
                    x_percent: 50,
                    y_percent: 50
                },
                hotspots: hotspotsData || [],
                diagramObj: diagramObj,
                storeDiagramUrl: storeDiagramUrl,
                destroyDiagramUrl: destroyDiagramUrl,
                storeHotspotUrl: storeHotspotUrl,
                updateHotspotsUrl: updateHotspotsUrl,
                baseUrl: '/courses/' + courseId + '/chapters/' + chapterId + '/modules/' + moduleId + '/hotspots',
                csrfToken: csrfToken,
                dragId: null,

                previewImage(e) {
                    const file = e.target.files[0];
                    if (file) {
                        this.imageFileName = file.name;
                        this.imagePreview = URL.createObjectURL(file);
                    }
                },
                handleFileDrop(e) {
                    const file = e.dataTransfer.files[0];
                    if (file) {
                        const input = e.currentTarget.querySelector('input[type="file"]');
                        if (input) {
                            const dt = new DataTransfer();
                            dt.items.add(file);
                            input.files = dt.files;
                            this.imageFileName = file.name;
                            this.imagePreview = URL.createObjectURL(file);
                        }
                    }
                },
                async uploadDiagram(e) {
                    this.uploading = true;
                    try {
                        const formData = new FormData(e.target);
                        const res = await fetch(this.storeDiagramUrl, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': this.csrfToken,
                                'Accept': 'application/json'
                            },
                            body: formData
                        });
                        const data = await res.json();
                        if (res.ok && data.status === 'success') {
                            this.showUploadModal = false;
                            window.location.reload();
                        } else {
                            alert(data.message || 'Gagal mengunggah gambar.');
                        }
                    } catch (err) {
                        alert('Terjadi kesalahan koneksi.');
                    }
                    this.uploading = false;
                },
                async confirmDeleteDiagram() {
                    if (!confirm('Apakah Anda yakin ingin menghapus diagram modul ini beserta seluruh hotspotnya?')) return;
                    try {
                        const res = await fetch(this.destroyDiagramUrl, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': this.csrfToken,
                                'Accept': 'application/json'
                            }
                        });
                        if (res.ok) {
                            window.location.reload();
                        }
                    } catch (err) {
                        alert('Gagal menghapus diagram.');
                    }
                },
                onDiagramClick(e) {
                    if (!this.addHotspotMode) return;
                    const rect = this.$refs.diagramContainer.getBoundingClientRect();
                    let xPos = ((e.clientX - rect.left) / rect.width) * 100;
                    let yPos = ((e.clientY - rect.top) / rect.height) * 100;
                    xPos = Math.max(0, Math.min(100, Math.round(xPos * 100) / 100));
                    yPos = Math.max(0, Math.min(100, Math.round(yPos * 100) / 100));

                    const defaultLabel = String(this.hotspots.length + 1);
                    this.activeHotspot = {
                        id: null,
                        label: defaultLabel,
                        action_type: 'scroll_row',
                        target_module_id: '',
                        popup_title: defaultLabel + '. Component',
                        popup_content: '',
                        x_percent: xPos,
                        y_percent: yPos
                    };
                    this.showHotspotFormModal = true;
                    this.addHotspotMode = false;
                },
                clickHotspot(hotspot) {
                    if (this.editMode) {
                        this.activeHotspot = Object.assign({}, hotspot);
                        this.showHotspotFormModal = true;
                    } else {
                        if (hotspot.action_type === 'popup') {
                            this.activePopupHotspot = hotspot;
                        } else {
                            // Try scrolling to row by numeric label or target_module_id
                            const num = parseInt(hotspot.label, 10);
                            if (!isNaN(num) && typeof window.scrollToPartRow === 'function') {
                                window.scrollToPartRow(num);
                            } else {
                                const targetId = hotspot.label;
                                const row = document.getElementById('part-row-' + targetId) 
                                         || document.getElementById('row-' + targetId)
                                         || document.querySelector(`[data-part-row="${targetId}"]`);
                                if (row) {
                                    row.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                    row.classList.add('bg-blue-100', 'ring-2', 'ring-blue-400');
                                    setTimeout(() => row.classList.remove('bg-blue-100', 'ring-2', 'ring-blue-400'), 2500);
                                }
                            }
                        }
                    }
                },
                async saveHotspotForm() {
                    this.savingHotspot = true;
                    try {
                        const isEdit = !!this.activeHotspot.id;
                        const url = isEdit ? (this.baseUrl + '/' + this.activeHotspot.id) : this.storeHotspotUrl;
                        const method = isEdit ? 'PUT' : 'POST';

                        const res = await fetch(url, {
                            method: method,
                            headers: {
                                'X-CSRF-TOKEN': this.csrfToken,
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify(this.activeHotspot)
                        });
                        const data = await res.json();
                        if (res.ok && data.status === 'success') {
                            if (isEdit) {
                                const idx = this.hotspots.findIndex(h => String(h.id) === String(this.activeHotspot.id));
                                if (idx !== -1) this.hotspots[idx] = data.hotspot;
                            } else {
                                this.hotspots.push(data.hotspot);
                            }
                            this.showHotspotFormModal = false;
                        } else {
                            alert(data.message || 'Gagal menyimpan hotspot.');
                        }
                    } catch (e) {
                        alert('Terjadi kesalahan saat menyimpan hotspot.');
                    }
                    this.savingHotspot = false;
                },
                async deleteHotspot(id) {
                    if (!confirm('Apakah Anda yakin hanya ingin menghapus 1 hotspot ini?')) return;
                    try {
                        const res = await fetch(this.baseUrl + '/' + id, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': this.csrfToken,
                                'Accept': 'application/json'
                            }
                        });
                        if (res.ok) {
                            this.hotspots = this.hotspots.filter(h => String(h.id) !== String(id));
                            this.showHotspotFormModal = false;
                            alert('Hotspot berhasil dihapus.');
                        }
                    } catch (e) {
                        alert('Gagal menghapus hotspot.');
                    }
                },
                startDrag(e, id) {
                    if (!this.editMode) return;
                    this.dragId = id;
                    if (e.type !== 'touchstart') e.preventDefault();
                },
                onDrag(e) {
                    if (!this.editMode || !this.dragId) return;
                    const rect = this.$refs.diagramContainer.getBoundingClientRect();
                    const clientX = e.touches ? e.touches[0].clientX : e.clientX;
                    const clientY = e.touches ? e.touches[0].clientY : e.clientY;
                    let xPos = ((clientX - rect.left) / rect.width) * 100;
                    let yPos = ((clientY - rect.top) / rect.height) * 100;
                    xPos = Math.max(0, Math.min(100, xPos));
                    yPos = Math.max(0, Math.min(100, yPos));
                    const hotspot = this.hotspots.find(h => h.id === this.dragId);
                    if (hotspot) {
                        hotspot.x_percent = Math.round(xPos * 100) / 100;
                        hotspot.y_percent = Math.round(yPos * 100) / 100;
                    }
                },
                stopDrag() {
                    this.dragId = null;
                },
                async saveHotspots() {
                    this.saving = true;
                    try {
                        const payload = this.hotspots.map(h => ({id: h.id, x: h.x_percent, y: h.y_percent}));
                        const res = await fetch(this.updateHotspotsUrl, {
                            method: 'PUT',
                            headers: {
                                'X-CSRF-TOKEN': this.csrfToken,
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ hotspots: payload })
                        });
                        if (res.ok) {
                            this.editMode = false;
                            alert('Posisi Hotspot berhasil disimpan.');
                        } else {
                            alert('Gagal menyimpan posisi.');
                        }
                    } catch (e) {
                        alert('Terjadi kesalahan jaringan.');
                    }
                    this.saving = false;
                }
            };
        };
    }
</script>

<div class="my-6"
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
    @mousemove.window="onDrag"
    @mouseup.window="stopDrag"
    @touchmove.window="onDrag"
    @touchend.window="stopDrag"
>
    <!-- Top toolbar for Instructor -->
    @if(auth()->user()->isInstruktur())
        <div class="flex flex-wrap items-center justify-between gap-2 mb-3 bg-slate-50 p-3 rounded-xl border border-slate-200">
            <div class="flex items-center gap-2">
                <span class="text-xs font-bold text-slate-700">Diagram / Gambar Kerja Technical Drawing</span>
                <template x-if="diagramObj">
                    <span class="text-[10px] px-2 py-0.5 rounded-full bg-blue-100 text-blue-700 font-bold" x-text="hotspots.length + ' Hotspots'"></span>
                </template>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <template x-if="!diagramObj">
                    <button @click="showUploadModal = true" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-bold transition shadow-xs flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        <span>Upload Technical Drawing</span>
                    </button>
                </template>

                <template x-if="diagramObj">
                    <div class="flex flex-wrap items-center gap-2">
                        <button x-show="!editMode && !addHotspotMode" @click="showUploadModal = true" class="px-2.5 py-1 bg-white border border-slate-200 text-slate-700 rounded-lg text-xs font-bold hover:bg-slate-100 transition flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span>Ganti Gambar</span>
                        </button>

                        <button x-show="!editMode" 
                                @click="addHotspotMode = !addHotspotMode" 
                                class="px-2.5 py-1 text-xs font-bold rounded-lg transition flex items-center gap-1"
                                :class="addHotspotMode ? 'bg-amber-500 text-white shadow-xs' : 'bg-blue-600 text-white hover:bg-blue-700 shadow-xs'">
                            <template x-if="addHotspotMode">
                                <div class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    <span>Batal Tambah</span>
                                </div>
                            </template>
                            <template x-if="!addHotspotMode">
                                <div class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    <span>Tambah Hotspot Dot</span>
                                </div>
                            </template>
                        </button>

                        <button x-show="!addHotspotMode && !editMode" @click="editMode = true" class="px-2.5 py-1 bg-slate-200 text-slate-700 rounded-lg text-xs font-bold hover:bg-slate-300 transition flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>Atur Posisi / Edit</span>
                        </button>

                        <button x-show="editMode" @click="editMode = false" class="px-2 py-1 bg-slate-200 text-slate-700 rounded-lg text-xs font-bold">
                            Selesai
                        </button>
                        <button x-show="editMode" @click="saveHotspots()" :disabled="saving" class="px-2.5 py-1 bg-green-600 hover:bg-green-700 text-white rounded-lg text-xs font-bold transition shadow-xs flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                            <span>Simpan Posisi</span>
                        </button>
                    </div>
                </template>
            </div>
        </div>
    @endif

    <!-- Helper indicator when addHotspotMode active -->
    <div x-show="addHotspotMode" x-cloak class="mb-3 p-2 bg-amber-50 border border-amber-200 rounded-lg text-amber-800 text-xs font-semibold flex items-center gap-2 animate-pulse">
        <svg class="w-4 h-4 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path></svg>
        <span>Klik di posisi titik mana saja pada gambar Technical Drawing untuk menambah hotspot baru.</span>
    </div>

    <!-- Technical Drawing Display Container -->
    <template x-if="diagramObj && diagramObj.image_path">
        <div x-ref="diagramContainer" 
             @click="onDiagramClick($event)"
             class="relative mx-auto border border-slate-200 rounded-xl bg-white overflow-hidden shadow-sm aspect-[1085/1450] max-w-sm select-none"
             :class="addHotspotMode ? 'ring-2 ring-amber-500 cursor-crosshair' : (editMode ? 'ring-2 ring-blue-500 cursor-crosshair' : '')">
            
            <img :src="'{{ asset('') }}' + diagramObj.image_path" class="w-full h-full object-contain select-none pointer-events-none" alt="Technical Drawing" draggable="false">

            <!-- Overlay Hotspot Dots -->
            <template x-for="(hotspot, index) in hotspots" :key="hotspot.id">
                <button
                    type="button"
                    @click.stop="clickHotspot(hotspot)"
                    @mousedown="startDrag($event, hotspot.id)"
                    @touchstart="startDrag($event, hotspot.id)"
                    class="absolute z-20 group -translate-x-1/2 -translate-y-1/2 focus:outline-none select-none"
                    :style="`left: ${hotspot.x_percent}%; top: ${hotspot.y_percent}%; cursor: ${editMode ? 'grab' : 'pointer'};`"
                    :class="editMode && dragId === hotspot.id ? 'cursor-grabbing scale-125 z-50' : ''"
                >
                    <!-- Hotspot Dot -->
                    <span class="relative inline-flex rounded-full h-5 w-5 border-2 border-white items-center justify-center shadow-md transition-all duration-150 group-hover:scale-110"
                          :class="hotspot.action_type === 'popup' ? 'bg-amber-500 text-white' : 'bg-blue-600 text-white'">
                        <span class="text-white text-[9px] font-extrabold" x-text="hotspot.label"></span>
                    </span>

                    <!-- Hover preview tooltip -->
                    <span x-show="!editMode" class="absolute left-1/2 -translate-x-1/2 bottom-6 bg-slate-900/90 text-white text-[10px] font-semibold px-2 py-0.5 rounded shadow-lg opacity-0 transition-opacity group-hover:opacity-100 whitespace-nowrap z-30 pointer-events-none">
                        <span x-text="hotspot.popup_title || ('Part No. ' + hotspot.label)"></span>
                    </span>
                </button>
            </template>
        </div>
    </template>

    <!-- Hotspot List in Edit Mode -->
    <div x-show="editMode && hotspots.length > 0" class="mt-4 pt-3 border-t border-slate-200" x-cloak>
        <h5 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-2 flex items-center gap-1">
            <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
            <span>Daftar Hotspot modul ini:</span>
        </h5>
        <div class="flex flex-wrap gap-1.5">
            <template x-for="(hotspot, idx) in hotspots" :key="hotspot.id">
                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg border border-slate-200 bg-white text-xs font-semibold text-slate-700 shadow-2xs">
                    <span class="w-4 h-4 rounded-full bg-blue-600 text-white flex items-center justify-center text-[9px] font-bold" x-text="hotspot.label"></span>
                    <span class="text-[11px]" x-text="hotspot.popup_title || ('Part ' + hotspot.label)"></span>
                    <button type="button" @click="activeHotspot = Object.assign({}, hotspot); showHotspotFormModal = true;" class="text-blue-600 hover:text-blue-800 font-bold ml-1 hover:underline">
                        Edit
                    </button>
                    <button type="button" @click="deleteHotspot(hotspot.id)" class="text-rose-600 hover:text-rose-800 font-bold ml-1 bg-rose-50 px-1.5 py-0.5 rounded text-[10px]">
                        Hapus
                    </button>
                </div>
            </template>
        </div>
    </div>

    <!-- Modals for Module Hotspot Form & Image Upload -->
    <!-- Upload Modal -->
    <div x-show="showUploadModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-xs p-4" x-cloak>
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4" @click.away="showUploadModal = false">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="font-bold text-slate-800 text-sm">Upload Technical Drawing Modul</h3>
                <button type="button" @click="showUploadModal = false" class="text-slate-400 hover:text-slate-600 font-bold text-base">&times;</button>
            </div>

            <form @submit.prevent="uploadDiagram($event)" enctype="multipart/form-data" class="space-y-4">
                <div class="border-2 border-dashed border-slate-200 rounded-xl p-6 text-center hover:border-blue-400 transition" @dragover.prevent @drop.prevent="handleFileDrop($event)">
                    <template x-if="!imagePreview">
                        <div>
                            <svg class="w-10 h-10 text-slate-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <p class="text-xs font-bold text-slate-700">Pilih file gambar atau drag ke sini</p>
                            <p class="text-[10px] text-slate-400 mt-1">PNG, JPG, WEBP hingga 10MB</p>
                        </div>
                    </template>
                    <template x-if="imagePreview">
                        <div>
                            <img :src="imagePreview" class="max-h-48 mx-auto rounded-lg shadow-sm mb-2 object-contain">
                            <p class="text-xs font-bold text-slate-700" x-text="imageFileName"></p>
                        </div>
                    </template>
                    <input type="file" name="image" required accept="image/*" class="mt-3 text-xs text-slate-500 w-full" @change="previewImage($event)">
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" @click="showUploadModal = false" class="px-3 py-1.5 rounded-lg text-xs font-bold border border-slate-200 text-slate-600">Batal</button>
                    <button type="submit" :disabled="uploading" class="px-4 py-1.5 bg-blue-600 text-white rounded-lg text-xs font-bold hover:bg-blue-700 shadow-xs">
                        <span x-show="!uploading">Unggah Gambar</span>
                        <span x-show="uploading">Mengunggah...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Hotspot Form Modal -->
    <div x-show="showHotspotFormModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-xs p-4" x-cloak>
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4" @click.away="showHotspotFormModal = false">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="font-bold text-slate-800 text-sm" x-text="activeHotspot.id ? 'Edit Hotspot Dot' : 'Tambah Hotspot Dot Baru'"></h3>
                <button type="button" @click="showHotspotFormModal = false" class="text-slate-400 hover:text-slate-600 font-bold text-base">&times;</button>
            </div>

            <form @submit.prevent="saveHotspotForm()" class="space-y-4 text-xs">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Nomor / Label Hotspot Dot (misal: 1, 2, 3...)</label>
                    <input type="text" x-model="activeHotspot.label" required placeholder="Contoh: 1" class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Nama Part / Deskripsi Singkat</label>
                    <input type="text" x-model="activeHotspot.popup_title" placeholder="Contoh: 1. Barrel Rotunda Curtain Assembly" class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Aksi Saat Dot Diklik</label>
                    <select x-model="activeHotspot.action_type" class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-blue-500">
                        <option value="scroll_row">Sorot & Scroll ke Baris Tabel Part (Nomor Item)</option>
                        <option value="popup">Tampilkan Modal Pop-up Info</option>
                    </select>
                </div>

                <template x-if="activeHotspot.action_type === 'popup'">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Isi Detail Pop-up Info</label>
                        <textarea x-model="activeHotspot.popup_content" rows="3" placeholder="Tuliskan spesifikasi/penjelasan detail komponen ini..." class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                </template>

                <div class="flex justify-between items-center pt-3 border-t border-slate-100">
                    <template x-if="activeHotspot.id">
                        <button type="button" @click="deleteHotspot(activeHotspot.id)" class="px-3 py-1.5 bg-rose-50 text-rose-600 border border-rose-200 rounded-lg text-xs font-bold hover:bg-rose-100">
                            Hapus Dot Ini
                        </button>
                    </template>
                    <template x-if="!activeHotspot.id">
                        <div></div>
                    </template>

                    <div class="flex gap-2">
                        <button type="button" @click="showHotspotFormModal = false" class="px-3 py-1.5 border border-slate-200 text-slate-600 rounded-lg text-xs font-bold">Batal</button>
                        <button type="submit" :disabled="savingHotspot" class="px-4 py-1.5 bg-blue-600 text-white rounded-lg text-xs font-bold hover:bg-blue-700 shadow-xs">
                            <span x-show="!savingHotspot">Simpan Hotspot</span>
                            <span x-show="savingHotspot">Menyimpan...</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
