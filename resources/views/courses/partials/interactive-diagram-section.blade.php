<!-- Interactive Diagram with Hotspots (Universal for All Chapters) -->
<script>
    if (typeof window.interactiveDiagramData !== 'function') {
        window.interactiveDiagramData = function(diagramObj, hotspotsData, courseId, chapterId, updateUrl, storeDiagramUrl, destroyDiagramUrl, storeHotspotUrl, csrfToken, modulesData = []) {
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
                dotSize: localStorage.getItem('lms_dotsize_chap_' + chapterId) || 'md',
                setDotSize(size) {
                    this.dotSize = size;
                    localStorage.setItem('lms_dotsize_chap_' + chapterId, size);
                },
                activeHotspot: {
                    id: null,
                    label: '',
                    action_type: 'navigate',
                    target_module_id: '',
                    popup_title: '',
                    popup_content: '',
                    x_percent: 50,
                    y_percent: 50
                },
                hotspots: hotspotsData || [],
                modules: modulesData || [],
                diagramObj: diagramObj,
                updateUrl: updateUrl,
                storeDiagramUrl: storeDiagramUrl,
                destroyDiagramUrl: destroyDiagramUrl,
                storeHotspotUrl: storeHotspotUrl,
                baseUrl: '/courses/' + courseId + '/chapters/' + chapterId + '/hotspots',
                csrfToken: csrfToken,
                dragId: null,
                wasDragged: false,

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
                        const input = document.getElementById('diagram-upload-input');
                        const dt = new DataTransfer();
                        dt.items.add(file);
                        input.files = dt.files;
                        this.imageFileName = file.name;
                        this.imagePreview = URL.createObjectURL(file);
                    }
                },
                async uploadDiagram(e) {
                    this.uploading = true;
                    try {
                        const formData = new FormData(e.target);
                        const targetModuleId = formData.get('target_module_id');
                        let uploadUrl = this.storeDiagramUrl;

                        if (targetModuleId && targetModuleId !== 'chapter') {
                            uploadUrl = '/courses/' + courseId + '/chapters/' + chapterId + '/modules/' + targetModuleId + '/diagram';
                        }

                        const res = await fetch(uploadUrl, {
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
                            showGlobalAlert('Gagal', data.message || 'Gagal mengunggah gambar.');
                        }
                    } catch (err) {
                        showGlobalAlert('Kesalahan', 'Terjadi kesalahan koneksi.');
                    }
                    this.uploading = false;
                },
                async confirmDeleteDiagram() {
                    showGlobalConfirm('Hapus Diagram', 'Apakah Anda yakin ingin menghapus diagram ini beserta seluruh hotspotnya?', async () => {
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
                            showGlobalAlert('Gagal', 'Gagal menghapus diagram.');
                        }
                    });
                },
                onDiagramClick(e) {
                    if (!this.addHotspotMode) return;
                    const rect = this.$refs.diagramContainer.getBoundingClientRect();
                    let xPos = ((e.clientX - rect.left) / rect.width) * 100;
                    let yPos = ((e.clientY - rect.top) / rect.height) * 100;
                    xPos = Math.max(0, Math.min(100, Math.round(xPos * 100) / 100));
                    yPos = Math.max(0, Math.min(100, Math.round(yPos * 100) / 100));

                    this.activeHotspot = {
                        id: null,
                        label: 'Hotspot ' + (this.hotspots.length + 1),
                        action_type: 'navigate',
                        target_module_id: '',
                        popup_title: '',
                        popup_content: '',
                        x_percent: xPos,
                        y_percent: yPos
                    };
                    this.showHotspotFormModal = true;
                    this.addHotspotMode = false;
                },
                clickHotspot(hotspot) {
                    if (this.wasDragged) {
                        this.wasDragged = false;
                        return;
                    }
                    if (this.editMode) {
                        this.activeHotspot = Object.assign({}, hotspot);
                        this.showHotspotFormModal = true;
                    } else {
                        if (hotspot.action_type === 'popup') {
                            this.activePopupHotspot = hotspot;
                        } else {
                            let targetId = hotspot.target_module_id;

                            // Fallback: search module by label or popup_title
                            if (!targetId && (hotspot.label || hotspot.popup_title)) {
                                const searchStr = (hotspot.popup_title || hotspot.label).trim().toLowerCase();
                                const labelStr = String(hotspot.label).trim().toLowerCase();
                                const found = (this.modules || []).find(m => {
                                    if (!m || !m.title) return false;
                                    const titleLower = m.title.trim().toLowerCase();
                                    return titleLower.startsWith(labelStr + '.') || 
                                           titleLower.startsWith(labelStr + ' ') || 
                                           titleLower === labelStr ||
                                           titleLower.includes(searchStr) ||
                                           String(m.id) === labelStr;
                                });
                                if (found) {
                                    targetId = found.id;
                                }
                            }

                            if (!targetId && (this.modules || []).length > 0) {
                                const rawLabel = String(hotspot.label || '').replace(/hotspot/i, '').trim();
                                const num = parseInt(rawLabel, 10);
                                if (!isNaN(num) && num >= 1 && this.modules[num - 1]) {
                                    targetId = this.modules[num - 1].id;
                                } else if (this.modules[0]) {
                                    targetId = this.modules[0].id;
                                }
                            }

                            if (targetId) {
                                if (typeof window.setStudyModule === 'function') {
                                    window.setStudyModule(targetId);
                                }
                                if (typeof window.setMechModule === 'function') {
                                    window.setMechModule(targetId);
                                }
                                if (typeof window.setElecModule === 'function') {
                                    window.setElecModule(targetId);
                                }

                                // Switch active tab if target module belongs to a specific tab
                                const targetMod = (this.modules || []).find(m => String(m.id) === String(targetId));
                                if (targetMod && targetMod.title) {
                                    const match = targetMod.title.match(/^(\d+\.\d+)/);
                                    if (match) {
                                        const tabCode = match[1];
                                        const tabButtons = Array.from(document.querySelectorAll('button'));
                                        const tabBtn = tabButtons.find(b => b.textContent && b.textContent.trim().startsWith(tabCode));
                                        if (tabBtn) tabBtn.click();
                                    }
                                }

                                this.$nextTick(() => {
                                    const el = document.getElementById('module-' + targetId) 
                                            || document.getElementById('mech-module-' + targetId)
                                            || document.getElementById('elec-module-' + targetId)
                                            || document.querySelector('[data-module-id="' + targetId + '"]');
                                    if (el) {
                                        const y = el.getBoundingClientRect().top + window.pageYOffset - 100;
                                        window.scrollTo({ top: y, behavior: 'smooth' });
                                    } else {
                                        const contentContainer = document.querySelector('.space-y-6') || document.querySelector('.min-h-\\[250px\\]');
                                        if (contentContainer) {
                                            const y = contentContainer.getBoundingClientRect().top + window.pageYOffset - 100;
                                            window.scrollTo({ top: y, behavior: 'smooth' });
                                        }
                                    }
                                });
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
                            showGlobalAlert('Gagal', data.message || 'Gagal menyimpan hotspot.');
                        }
                    } catch (e) {
                        showGlobalAlert('Kesalahan', 'Terjadi kesalahan saat menyimpan hotspot.');
                    }
                    this.savingHotspot = false;
                },
                async deleteHotspot(id) {
                    showGlobalConfirm('Hapus Hotspot', 'Apakah Anda yakin hanya ingin menghapus 1 hotspot ini?', async () => {
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
                                showGlobalAlert('Berhasil', 'Hotspot berhasil dihapus.');
                            }
                        } catch (e) {
                            showGlobalAlert('Gagal', 'Gagal menghapus hotspot.');
                        }
                    });
                },
                startDrag(e, id) {
                    if (!this.editMode) return;
                    this.dragId = id;
                    this.wasDragged = false;
                },
                onDrag(e) {
                    if (!this.editMode || !this.dragId) return;
                    this.wasDragged = true;
                    if (e.cancelable) e.preventDefault();
                    const rect = this.$refs.diagramContainer.getBoundingClientRect();
                    const clientX = e.touches ? e.touches[0].clientX : e.clientX;
                    const clientY = e.touches ? e.touches[0].clientY : e.clientY;
                    let xPos = ((clientX - rect.left) / rect.width) * 100;
                    let yPos = ((clientY - rect.top) / rect.height) * 100;
                    xPos = Math.max(0, Math.min(100, xPos));
                    yPos = Math.max(0, Math.min(100, yPos));
                    const hotspot = this.hotspots.find(h => String(h.id) === String(this.dragId));
                    if (hotspot) {
                        hotspot.x_percent = Math.round(xPos * 100) / 100;
                        hotspot.y_percent = Math.round(yPos * 100) / 100;
                    }
                },
                stopDrag() {
                    setTimeout(() => {
                        this.dragId = null;
                    }, 50);
                },
                originalHotspots: [],
                startEditMode() {
                    try {
                        this.originalHotspots = (this.hotspots || []).map(h => Object.assign({}, h));
                    } catch (e) {
                        this.originalHotspots = [];
                    }
                    this.editMode = true;
                },
                cancelEditMode() {
                    if (this.originalHotspots) {
                        this.hotspots = this.originalHotspots.map(h => Object.assign({}, h));
                    }
                    this.editMode = false;
                },
                async saveHotspots() {
                    this.saving = true;
                    try {
                        const payload = this.hotspots.map(h => ({id: h.id, x: h.x_percent, y: h.y_percent}));
                        const res = await fetch(this.updateUrl, {
                            method: 'PUT',
                            headers: {
                                'X-CSRF-TOKEN': this.csrfToken,
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ hotspots: payload })
                        });
                        if (res.ok) {
                            this.originalHotspots = (this.hotspots || []).map(h => Object.assign({}, h));
                            this.editMode = false;
                            showGlobalAlert('Berhasil', 'Posisi Hotspot berhasil disimpan.');
                        } else {
                            showGlobalAlert('Gagal', 'Gagal menyimpan posisi.');
                        }
                    } catch (e) {
                        showGlobalAlert('Kesalahan', 'Terjadi kesalahan jaringan.');
                    }
                    this.saving = false;
                }
            };
        };
    }
</script>

<section
    x-data="interactiveDiagramData(
        @js($diagram),
        @js($diagram ? $diagram->hotspots : []),
        {{ $course->id }},
        {{ $chapter->id }},
        @js(route('courses.diagram.hotspots.update', [$course->id, $chapter->id])),
        @js(route('courses.diagram.store', [$course->id, $chapter->id])),
        @js(route('courses.diagram.destroy', [$course->id, $chapter->id])),
        @js(route('courses.diagram.hotspots.store', [$course->id, $chapter->id])),
        @js(csrf_token()),
        @js(isset($modules) ? $modules->values() : [])
    )"
    @mousemove.window="editMode && onDrag($event)"
    @mouseup.window="editMode && stopDrag()"
    @touchmove.window="editMode && onDrag($event)"
    @touchend.window="editMode && stopDrag()"
>
    <div x-show="diagramObj && diagramObj.image_path" x-cloak class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm max-w-4xl mx-auto w-full mb-6">
    <div class="flex flex-wrap justify-between items-center gap-2 mb-4">
        <div class="flex items-center gap-2">
            <h3 class="text-base font-bold text-slate-700">Diagram Interaktif</h3>
        <span x-show="diagramObj" class="text-xs px-2 py-0.5 rounded-full bg-blue-50 text-blue-600 font-bold border border-blue-100" x-text="hotspots.length + ' Hotspot'"></span>
            <!-- Controls Ukuran Bulatan Hotspot - Instruktur only -->
            @if(auth()->user()->isInstruktur())
            <div x-show="hotspots.length > 0" class="flex items-center gap-1 border-l border-slate-200 pl-2">
                <span class="text-[10px] text-slate-500 font-semibold mr-1">Ukuran Dot:</span>
                <button type="button" @click="setDotSize('sm')" class="px-1.5 py-0.5 rounded text-[10px] font-bold transition" :class="dotSize === 'sm' ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'">S</button>
                <button type="button" @click="setDotSize('md')" class="px-1.5 py-0.5 rounded text-[10px] font-bold transition" :class="dotSize === 'md' ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'">M</button>
                <button type="button" @click="setDotSize('lg')" class="px-1.5 py-0.5 rounded text-[10px] font-bold transition" :class="dotSize === 'lg' ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'">L</button>
                <button type="button" @click="setDotSize('xl')" class="px-1.5 py-0.5 rounded text-[10px] font-bold transition" :class="dotSize === 'xl' ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'">XL</button>
            </div>
            @endif
        </div>

        @if(auth()->user()->isInstruktur())
            <div class="flex flex-wrap items-center gap-2">
                    <div x-show="diagramObj" class="flex flex-wrap items-center gap-2">
                        <button x-show="!editMode && !addHotspotMode" @click="showUploadModal = true" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span>Ganti Gambar</span>
                        </button>

                        <button x-show="!editMode" 
                                @click="addHotspotMode = !addHotspotMode" 
                                class="px-3 py-1.5 text-xs font-bold rounded-xl transition flex items-center gap-1.5"
                                :class="addHotspotMode ? 'bg-amber-500 text-white shadow-md' : 'bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200'">
                            <template x-if="addHotspotMode">
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    <span>Batal Tambah</span>
                                </div>
                            </template>
                            <template x-if="!addHotspotMode">
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    <span>Tambah Hotspot</span>
                                </div>
                            </template>
                        </button>

                        <button x-show="!addHotspotMode && !editMode" @click="startEditMode()" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>Atur Posisi / Edit</span>
                        </button>

                        <button x-show="editMode" @click="cancelEditMode()" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-bold transition">
                            Batal Edit
                        </button>
                        <button x-show="editMode" @click="saveHotspots()" :disabled="saving" class="px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white rounded-xl text-xs font-bold transition shadow-md shadow-green-600/20 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                            <span x-show="!saving">Simpan Posisi</span>
                            <span x-show="saving">Menyimpan...</span>
                        </button>
                    </div>
            </div>
        @endif
    </div>

    <!-- Notification indicator when addHotspotMode is active -->
    <div x-show="addHotspotMode" x-cloak class="mb-3 p-2.5 bg-amber-50 border border-amber-200 rounded-xl text-amber-800 text-xs font-semibold flex items-center gap-2 animate-pulse">
        <svg class="w-4 h-4 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path></svg>
        <span>Klik di posisi mana saja pada gambar diagram untuk menempatkan titik hotspot baru.</span>
    </div>

    <!-- Diagram Display Container -->
    <div x-ref="diagramContainer" 
         @click="onDiagramClick($event)"
         class="relative bg-slate-50 rounded-xl w-full max-w-xl mx-auto border border-gray-200 shadow-sm select-none min-h-[150px]"
         :class="addHotspotMode ? 'ring-2 ring-amber-500 cursor-crosshair' : (editMode ? 'ring-2 ring-blue-500 cursor-crosshair' : '')">
        
        <img x-show="diagramObj && diagramObj.image_path" :src="diagramObj && diagramObj.image_path ? (diagramObj.image_path.startsWith('/') ? diagramObj.image_path : '/' + diagramObj.image_path) : ''" class="w-full h-auto block select-none pointer-events-none rounded-xl" :alt="'Diagram ' + '{{ $chapter->title }}'" draggable="false">



        <!-- Overlay Hotspots -->
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
                <!-- Pinging ring for non-edit mode -->
                <span x-show="!editMode" class="absolute inline-flex h-8 w-8 rounded-full opacity-40 animate-ping -left-[4px] -top-[4px]"
                      :class="hotspot.action_type === 'popup' ? 'bg-amber-400' : 'bg-blue-500'"></span>
                
                <!-- Hotspot Dot -->
                <span class="relative inline-flex rounded-full border-2 border-white items-center justify-center shadow-md transition-all duration-150 group-hover:scale-110 shrink-0"
                      :class="[
                          hotspot.action_type === 'popup' 
                            ? 'bg-amber-500 text-white' 
                            : (typeof activeMechId !== 'undefined' && activeMechId === hotspot.target_module_id && !editMode ? 'bg-blue-700 scale-110 ring-4 ring-blue-500/30' : 'bg-blue-600 text-white'),
                          dotSize === 'sm' ? 'w-5 h-5 text-[10px]' : (dotSize === 'md' ? 'w-6 h-6 text-[11px]' : (dotSize === 'lg' ? 'w-7 h-7 text-[12px]' : 'w-8 h-8 text-[13px]'))
                      ]">
                    <span class="font-extrabold leading-none select-none" x-text="hotspot.label ? (hotspot.label.length <= 2 ? hotspot.label : index + 1) : index + 1"></span>
                </span>

                <!-- Tooltip Hover Preview -->
                <span x-show="!editMode" 
                      class="absolute left-1/2 -translate-x-1/2 bottom-full mb-2.5 text-white text-xs font-bold px-3 py-1.5 rounded-lg shadow-2xl transition-all duration-150 opacity-0 transform translate-y-1 group-hover:opacity-100 group-hover:translate-y-0 whitespace-nowrap z-50 pointer-events-none border border-slate-700/80 flex items-center gap-1.5"
                      style="background-color: #0f172a; color: #ffffff;"
                >
                    <template x-if="hotspot.action_type === 'popup'">
                        <svg class="w-3.5 h-3.5 text-amber-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    </template>
                    <template x-if="hotspot.action_type !== 'popup'">
                        <svg class="w-3.5 h-3.5 text-blue-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                    </template>
                    <span x-text="hotspot.popup_title || (hotspot.label ? 'Part No. ' + hotspot.label : '')"></span>
                    <span class="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent" style="border-top-color: #0f172a;"></span>
                </span>
            </button>
        </template>
    </div>

    <!-- Hotspot List in Edit Mode -->
    <div x-show="editMode && hotspots.length > 0" class="mt-4 pt-4 border-t border-slate-100" x-cloak>
        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-2 flex items-center gap-1.5">
            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            <span>Daftar Hotspot (Klik tombol Hapus untuk menghapus 1 titik spesifik)</span>
        </h4>
        <div class="flex flex-wrap gap-2">
            <template x-for="(hotspot, idx) in hotspots" :key="hotspot.id">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl border border-slate-200 bg-slate-50 text-xs font-semibold text-slate-700 shadow-sm">
                    <span class="w-5 h-5 rounded-full bg-blue-600 text-white flex items-center justify-center text-[10px] font-bold" x-text="idx + 1"></span>
                    <span x-text="hotspot.label"></span>
                    <button type="button" @click="activeHotspot = Object.assign({}, hotspot); showHotspotFormModal = true;" class="text-blue-600 hover:text-blue-800 font-bold ml-1 hover:underline flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        <span>Edit</span>
                    </button>
                    <button type="button" @click="deleteHotspot(hotspot.id)" class="text-red-600 hover:text-red-800 font-bold ml-1 bg-red-50 px-2 py-0.5 rounded-lg border border-red-100 hover:bg-red-100 transition flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        <span>Hapus</span>
                    </button>
                </div>
            </template>
        </div>
    </div>
    </div>

    {{-- Partial Modal Component for Upload, Add/Edit Hotspot & Pop-up viewer --}}
    @include('courses.partials.diagram-hotspot-editor')
</section>
