<!-- Module Interactive Diagram with Hotspots -->
<script>
    if (typeof window.moduleDiagramData !== 'function') {
        window.moduleDiagramData = function(diagramInput, legacyHotspotsData, courseId, chapterId, moduleId, storeDiagramUrl, destroyDiagramUrl, storeHotspotUrl, updateHotspotsUrl, csrfToken) {
            let diagramsList = [];
            if (Array.isArray(diagramInput)) {
                diagramsList = diagramInput;
            } else if (diagramInput && typeof diagramInput === 'object' && diagramInput !== null) {
                diagramsList = [diagramInput];
            }

            return {
                diagrams: diagramsList,
                activeTab: 0,
                editMode: false,
                addHotspotMode: false,
                saving: false,
                uploading: false,
                savingHotspot: false,
                showUploadModal: false,
                isUploadingNewTab: false,
                showHotspotFormModal: false,
                imagePreview: null,
                imageFileName: '',
                newTabTitle: '',
                activePopupHotspot: null,
                highlightedHotspotLabel: null,
                dotSize: localStorage.getItem('lms_dotsize_mod_' + moduleId) || 'sm',
                setDotSize(size) {
                    this.dotSize = size;
                    localStorage.setItem('lms_dotsize_mod_' + moduleId, size);
                },

                get currentDiagram() {
                    return (this.diagrams && this.diagrams.length > 0) ? (this.diagrams[this.activeTab] || this.diagrams[0]) : null;
                },
                get diagramObj() {
                    return this.currentDiagram;
                },
                get hotspots() {
                    return (this.currentDiagram && this.currentDiagram.hotspots) ? this.currentDiagram.hotspots : [];
                },
                set hotspots(val) {
                    if (this.currentDiagram) {
                        this.currentDiagram.hotspots = val;
                    }
                },

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
                storeDiagramUrl: storeDiagramUrl,
                destroyDiagramUrl: destroyDiagramUrl,
                storeHotspotUrl: storeHotspotUrl,
                updateHotspotsUrl: updateHotspotsUrl,
                baseUrl: '/courses/' + courseId + '/chapters/' + chapterId + '/modules/' + moduleId + '/hotspots',
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
                        if (!this.isUploadingNewTab && this.currentDiagram && this.currentDiagram.id) {
                            formData.append('diagram_id', this.currentDiagram.id);
                        }
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
                            showGlobalAlert(@js(__('Gagal')), data.message || @js(__('Gagal mengunggah gambar.')));
                        }
                    } catch (err) {
                        showGlobalAlert(@js(__('Gagal')), @js(__('Terjadi kesalahan koneksi.')));
                    }
                    this.uploading = false;
                },
                async confirmDeleteDiagram() {
                    if (!this.currentDiagram) return;
                    showGlobalConfirm(@js(__('Hapus Diagram')), @js(__('Apakah Anda yakin ingin menghapus tab diagram ini beserta seluruh hotspotnya?')), async () => {
                        try {
                            const res = await fetch(this.destroyDiagramUrl + '?diagram_id=' + this.currentDiagram.id, {
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
                            showGlobalAlert(@js(__('Gagal')), @js(__('Gagal menghapus diagram.')));
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
                            const labelStr = String(hotspot.label || '').trim();

                            // Highlight the matching hotspot dot visually on whichever tab becomes active
                            this.highlightedHotspotLabel = labelStr;
                            setTimeout(() => {
                                if (this.highlightedHotspotLabel === labelStr) {
                                    this.highlightedHotspotLabel = null;
                                }
                            }, 3500);

                            // Automatically switch tab to detail diagram tab if clicking from main map (tab 0) or if current tab doesn't have detail hotspot
                            if (this.diagrams && this.diagrams.length > 1) {
                                const currentHasIt = this.hotspots && this.hotspots.some(h => String(h.label || '').trim() === labelStr);
                                if (!currentHasIt || this.activeTab === 0) {
                                    const targetTabIdx = this.diagrams.findIndex((diag, idx) => {
                                        if (idx === 0) return false;
                                        return diag.hotspots && diag.hotspots.some(h => String(h.label || '').trim() === labelStr);
                                    });

                                    if (targetTabIdx !== -1) {
                                        this.activeTab = targetTabIdx;
                                    }
                                }
                            }

                            if (hotspot.target_module_id) {
                                const targetId = hotspot.target_module_id;
                                if (typeof window.setMechModule === 'function') window.setMechModule(targetId);
                                if (typeof window.setElecModule === 'function') window.setElecModule(targetId);
                                const el = document.getElementById('module-' + targetId)
                                        || document.getElementById('mech-module-' + targetId)
                                        || document.getElementById('elec-module-' + targetId)
                                        || document.querySelector('[data-module-id="' + targetId + '"]');
                                if (el) {
                                    const y = el.getBoundingClientRect().top + window.pageYOffset - 100;
                                    window.scrollTo({ top: y, behavior: 'smooth' });
                                    return;
                                }
                            }

                            const num = parseInt(labelStr, 10);
                            const targetId = labelStr;

                            let container = this.$el ? this.$el.parentElement : null;
                            while (container && container !== document.body && !container.querySelector('table')) {
                                container = container.parentElement;
                            }
                            if (!container) container = document;

                            if (!isNaN(num) && typeof window.scrollToRollerRow === 'function' && container.querySelector('#roller-row-1')) {
                                window.scrollToRollerRow(num);
                                return;
                            }
                            if (!isNaN(num) && typeof window.scrollToPartRow === 'function' && container.querySelector('#part-row-1')) {
                                window.scrollToPartRow(num);
                                return;
                            }

                            let row = container.querySelector(`[id$="-row-${targetId}"]`)
                                   || container.querySelector(`[id*="-row-${targetId}"]`)
                                   || container.querySelector(`[data-part-row="${targetId}"]`);

                            if (!row) {
                                const prefixes = [
                                    'part-row-', 'roller-row-', 'cable-row-', 'lift-row-', 'bogie-row-',
                                    'stair-row-', 'cabin-row-', 'curtain-row-', 'auto-row-', 'canopy-row-',
                                    'door-row-', 'rubber-row-', 'wire-row-', 'row-'
                                ];
                                for (const prefix of prefixes) {
                                    const candidate = document.getElementById(prefix + targetId);
                                    if (candidate) {
                                        row = candidate;
                                        break;
                                    }
                                }
                            }

                            if (!row && !isNaN(num)) {
                                const allTrs = container.querySelectorAll('table tbody tr');
                                for (const tr of allTrs) {
                                    const firstTd = tr.querySelector('td');
                                    if (firstTd && firstTd.textContent.trim() === String(num)) {
                                        row = tr;
                                        break;
                                    }
                                }
                            }

                            if (row) {
                                row.scrollIntoView({ behavior: 'smooth', block: 'center' });

                                document.querySelectorAll('tr').forEach(r => r.classList.remove('bg-blue-100', 'ring-2', 'ring-blue-400', 'bg-blue-50', 'text-blue-900', 'font-semibold'));

                                row.classList.add('bg-blue-100', 'ring-2', 'ring-blue-400', 'font-semibold');
                                setTimeout(() => row.classList.remove('bg-blue-100', 'ring-2', 'ring-blue-400', 'font-semibold'), 2500);
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

                        const payload = Object.assign({}, this.activeHotspot, {
                            diagram_id: this.currentDiagram ? this.currentDiagram.id : null
                        });

                        const res = await fetch(url, {
                            method: method,
                            headers: {
                                'X-CSRF-TOKEN': this.csrfToken,
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify(payload)
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
                            showGlobalAlert(@js(__('Gagal')), data.message || @js(__('Gagal menyimpan hotspot.')));
                        }
                    } catch (e) {
                        showGlobalAlert(@js(__('Kesalahan')), @js(__('Terjadi kesalahan saat menyimpan hotspot.')));
                    }
                    this.savingHotspot = false;
                },
                async deleteHotspot(id) {
                    showGlobalConfirm(@js(__('Hapus Hotspot')), @js(__('Apakah Anda yakin hanya ingin menghapus 1 hotspot ini?')), async () => {
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
                                showGlobalAlert(@js(__('Berhasil')), @js(__('Hotspot berhasil dihapus.')));
                            }
                        } catch (e) {
                            showGlobalAlert(@js(__('Gagal')), @js(__('Gagal menghapus hotspot.')));
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
                            this.originalHotspots = (this.hotspots || []).map(h => Object.assign({}, h));
                            this.editMode = false;
                            showGlobalAlert(@js(__('Berhasil')), @js(__('Posisi Hotspot berhasil disimpan.')));
                        } else {
                            showGlobalAlert(@js(__('Gagal')), @js(__('Gagal menyimpan posisi.')));
                        }
                    } catch (e) {
                        showGlobalAlert(@js(__('Kesalahan')), @js(__('Terjadi kesalahan jaringan.')));
                    }
                    this.saving = false;
                }
            };
        };
    }
</script>

<div
    x-show="diagrams && diagrams.length > 0"
    x-cloak
    @mousemove.window="editMode && onDrag($event)"
    @mouseup.window="editMode && stopDrag()"
    @touchmove.window="editMode && onDrag($event)"
    @touchend.window="editMode && stopDrag()"
>
    <!-- Multi-Diagram Tab Navigation Bar -->
    <div x-show="diagrams && diagrams.length > 0" class="flex flex-wrap items-center justify-between gap-2 border-b border-slate-200 pb-3 mb-4">
        <div class="flex flex-wrap items-center gap-2">
            <template x-for="(diag, idx) in diagrams" :key="diag.id || idx">
                <button type="button"
                        @click="activeTab = idx; editMode = false; addHotspotMode = false;"
                        :class="activeTab === idx ? 'bg-blue-600 text-white shadow-xs font-bold' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200 font-semibold'"
                        class="px-3 py-1.5 rounded-xl text-xs transition focus:outline-none flex items-center gap-1.5">
                    <span x-text="diag.title || ('Diagram ' + (idx + 1))"></span>
                    <span class="text-[10px] px-1.5 py-0.2 rounded-full" :class="activeTab === idx ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-500'" x-text="(diag.hotspots ? diag.hotspots.length : 0)"></span>
                </button>
            </template>

            @if(auth()->user()->isInstruktur())
                <button type="button"
                        @click="imagePreview = null; imageFileName = ''; isUploadingNewTab = true; showUploadModal = true;"
                        class="px-3 py-1.5 text-xs font-bold rounded-xl border border-dashed border-blue-400 text-blue-600 hover:bg-blue-50 transition flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    <span>{{ __('Tambah Diagram Tab') }}</span>
                </button>
            @endif
        </div>
    </div>

    <!-- Top toolbar for Instructor -->
    <div x-show="currentDiagram" class="flex flex-wrap justify-between items-center gap-3 mb-4 pb-3 border-b border-slate-200/80">
        <!-- Left: Title, Hotspot Pill & Dot Size Selector -->
        <div class="flex flex-wrap items-center gap-2">
            <h3 class="text-base font-bold text-slate-800" x-text="currentDiagram ? currentDiagram.title : 'Diagram Interaktif'"></h3>
            <span x-show="currentDiagram" class="text-xs px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-600 font-bold border border-blue-100 shrink-0" x-text="hotspots.length + ' Hotspot'"></span>
            
            <!-- Controls Ukuran Bulatan Hotspot - Instruktur only -->
            @if(auth()->user()->isInstruktur())
            <div x-show="hotspots.length > 0" class="flex items-center gap-1.5 border-l border-slate-200 pl-2.5 ml-0.5">
                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">{{ __('Ukuran Dot:') }}</span>
                <div class="inline-flex p-0.5 rounded-lg bg-slate-100 border border-slate-200/80">
                    <button type="button" @click="setDotSize('sm')" class="px-2 py-0.5 rounded-md text-[10px] font-bold transition" :class="dotSize === 'sm' ? 'bg-blue-600 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900'">S</button>
                    <button type="button" @click="setDotSize('md')" class="px-2 py-0.5 rounded-md text-[10px] font-bold transition" :class="dotSize === 'md' ? 'bg-blue-600 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900'">M</button>
                    <button type="button" @click="setDotSize('lg')" class="px-2 py-0.5 rounded-md text-[10px] font-bold transition" :class="dotSize === 'lg' ? 'bg-blue-600 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900'">L</button>
                    <button type="button" @click="setDotSize('xl')" class="px-2 py-0.5 rounded-md text-[10px] font-bold transition" :class="dotSize === 'xl' ? 'bg-blue-600 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900'">XL</button>
                </div>
            </div>
            @endif
        </div>

        <!-- Right: Instructor Action Buttons Group -->
        @if(auth()->user()->isInstruktur())
            <div class="flex flex-wrap items-center gap-1.5" x-show="currentDiagram">
                <button x-show="!editMode"
                        @click="addHotspotMode = !addHotspotMode"
                        class="px-3 py-1.5 text-xs font-bold rounded-xl transition flex items-center gap-1.5"
                        :class="addHotspotMode ? 'bg-amber-500 text-white shadow-md shadow-amber-500/20' : 'bg-blue-600 hover:bg-blue-700 text-white shadow-md shadow-blue-600/20'">
                    <template x-if="addHotspotMode">
                        <div class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            <span>{{ __('Batal Tambah') }}</span>
                        </div>
                    </template>
                    <template x-if="!addHotspotMode">
                        <div class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            <span>{{ __('Tambah Hotspot') }}</span>
                        </div>
                    </template>
                </button>

                <button x-show="!addHotspotMode && !editMode" @click="startEditMode()" class="px-3 py-1.5 bg-white hover:bg-slate-50 text-slate-700 rounded-xl text-xs font-bold transition flex items-center gap-1.5 border border-slate-200 shadow-2xs">
                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span>{{ __('Atur Posisi') }}</span>
                </button>

                <button x-show="!editMode && !addHotspotMode" @click="imagePreview = null; imageFileName = ''; isUploadingNewTab = false; showUploadModal = true;" class="px-3 py-1.5 bg-white hover:bg-slate-50 text-slate-700 rounded-xl text-xs font-bold transition flex items-center gap-1.5 border border-slate-200 shadow-2xs">
                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span>{{ __('Ganti Gambar') }}</span>
                </button>

                <button x-show="editMode" @click="cancelEditMode()" class="px-3 py-1.5 bg-white hover:bg-slate-50 text-slate-600 rounded-xl text-xs font-bold transition border border-slate-200 shadow-2xs">
                    {{ __('Batal Edit') }}
                </button>
                <button x-show="editMode" @click="saveHotspots()" :disabled="saving" class="px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white rounded-xl text-xs font-bold transition shadow-md shadow-green-600/20 flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                    <span x-show="!saving">{{ __('Simpan Posisi') }}</span>
                    <span x-show="saving">{{ __('Menyimpan...') }}</span>
                </button>

                <button x-show="!editMode && !addHotspotMode" @click="confirmDeleteDiagram()" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200/80 rounded-xl text-xs font-bold transition flex items-center gap-1">
                    <svg class="w-3.5 h-3.5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    <span>{{ __('Hapus Tab') }}</span>
                </button>
            </div>
        @endif
    </div>

    <!-- Notification indicator when addHotspotMode active -->
    <div x-show="addHotspotMode" x-cloak class="mb-3 p-2.5 bg-amber-50 border border-amber-200 rounded-xl text-amber-800 text-xs font-semibold flex items-center gap-2 animate-pulse">
        <svg class="w-4 h-4 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path></svg>
        <span>Klik di posisi mana saja pada gambar diagram untuk menempatkan titik hotspot baru.</span>
    </div>

    <!-- Technical Drawing Display Container -->
    <div x-show="currentDiagram"
         x-ref="diagramContainer"
         @click="onDiagramClick($event)"
         class="relative bg-slate-50 rounded-xl w-full max-w-xl mx-auto border border-gray-200 shadow-sm select-none min-h-[150px]"
         :class="addHotspotMode ? 'ring-2 ring-amber-500 cursor-crosshair' : (editMode ? 'ring-2 ring-blue-500 cursor-crosshair' : '')">
        
        <img x-show="currentDiagram && currentDiagram.image_path" :src="currentDiagram && currentDiagram.image_path ? (currentDiagram.image_path.startsWith('/') ? currentDiagram.image_path : '/' + currentDiagram.image_path) : ''" class="w-full h-auto block select-none pointer-events-none rounded-xl" alt="Technical Drawing" draggable="false">

        <!-- Overlay Hotspot Dots -->
        <template x-for="(hotspot, index) in hotspots" :key="hotspot.id">
            <button
                type="button"
                @click.stop="clickHotspot(hotspot)"
                @mousedown="startDrag($event, hotspot.id)"
                @touchstart="startDrag($event, hotspot.id)"
                class="absolute z-20 group -translate-x-1/2 -translate-y-1/2 focus:outline-none select-none transition-all duration-200"
                :style="`left: ${hotspot.x_percent}%; top: ${hotspot.y_percent}%; cursor: ${editMode ? 'grab' : 'pointer'};`"
                :class="[
                    editMode && dragId === hotspot.id ? 'cursor-grabbing z-50' : '',
                    String(hotspot.label || '').trim() === String(highlightedHotspotLabel || '').trim() ? 'z-50' : ''
                ]"
            >
                <!-- Subtle pinging ring for non-edit mode -->
                <span x-show="!editMode"
                      class="absolute inline-flex h-6 w-6 rounded-full opacity-30 animate-ping -left-[2px] -top-[2px]"
                      :class="String(hotspot.label || '').trim() === String(highlightedHotspotLabel || '').trim() ? 'bg-amber-400 opacity-60' : (hotspot.action_type === 'popup' ? 'bg-amber-400' : 'bg-blue-500')"></span>

                <!-- Hotspot Dot -->
                <span class="relative inline-flex rounded-full border border-white items-center justify-center shadow-xs transition-all duration-200 group-hover:scale-105 shrink-0"
                      :class="[
                          String(hotspot.label || '').trim() === String(highlightedHotspotLabel || '').trim() ? 'bg-amber-500 text-white font-bold ring-2 ring-amber-400/70 shadow-sm' : (hotspot.action_type === 'popup' ? 'bg-amber-500 text-white' : 'bg-blue-600 text-white'),
                          dotSize === 'sm' ? 'w-5 h-5 text-[10px]' : (dotSize === 'md' ? 'w-6 h-6 text-[11px]' : (dotSize === 'lg' ? 'w-7 h-7 text-[12px]' : 'w-8 h-8 text-[13px]'))
                      ]">
                    <span class="font-extrabold leading-none select-none" x-text="hotspot.label"></span>
                </span>

                <!-- Hover preview tooltip or auto tooltip when highlighted -->
                <span x-show="!editMode" 
                      class="absolute left-1/2 -translate-x-1/2 bottom-full mb-1 text-white text-[10px] font-bold px-2 py-0.5 rounded-md shadow-md transition-all duration-200 whitespace-nowrap z-50 pointer-events-none border border-slate-700/80 flex items-center gap-1"
                      :class="String(hotspot.label || '').trim() === String(highlightedHotspotLabel || '').trim() ? 'opacity-100 translate-y-0 bg-amber-600 text-white border-amber-400' : 'opacity-0 translate-y-1 group-hover:opacity-100 group-hover:translate-y-0 bg-slate-900 text-white'"
                >
                    <span x-text="hotspot.popup_title || (hotspot.label ? 'Part No. ' + hotspot.label : '')"></span>
                    <span class="absolute top-full left-1/2 -translate-x-1/2 border-[3px] border-transparent"
                          :style="String(hotspot.label || '').trim() === String(highlightedHotspotLabel || '').trim() ? 'border-top-color: #d97706;' : 'border-top-color: #0f172a;'"></span>
                </span>
            </button>
        </template>
    </div>

    <!-- Hotspot List in Edit Mode -->
    <div x-show="editMode && hotspots.length > 0" class="mt-4 pt-3 border-t border-slate-200" x-cloak>
        <h5 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-2 flex items-center gap-1">
            <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
            <span>{{ __('Daftar Hotspot modul ini:') }}</span>
        </h5>
        <div class="flex flex-wrap gap-1.5">
            <template x-for="(hotspot, idx) in hotspots" :key="hotspot.id">
                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg border border-slate-200 bg-white text-xs font-semibold text-slate-700 shadow-2xs">
                    <span class="w-4 h-4 rounded-full bg-blue-600 text-white flex items-center justify-center text-[9px] font-bold" x-text="hotspot.label"></span>
                    <span class="text-[11px]" x-text="hotspot.popup_title || ('Part ' + hotspot.label)"></span>
                    <button type="button" @click="activeHotspot = Object.assign({}, hotspot); showHotspotFormModal = true;" class="text-blue-600 hover:text-blue-800 font-bold ml-1 hover:underline">
                        {{ __('Edit') }}
                    </button>
                    <button type="button" @click="deleteHotspot(hotspot.id)" class="text-rose-600 hover:text-rose-800 font-bold ml-1 bg-rose-50 px-1.5 py-0.5 rounded text-[10px]">
                        {{ __('Hapus') }}
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
                <h3 class="font-bold text-slate-800 text-sm" x-text="isUploadingNewTab ? '{{ __('Tambah Diagram Tab Baru') }}' : '{{ __('Upload / Ganti Gambar Diagram') }}'"></h3>
                <button type="button" @click="showUploadModal = false" class="text-slate-400 hover:text-slate-600 font-bold text-base">&times;</button>
            </div>

            <form @submit.prevent="uploadDiagram($event)" enctype="multipart/form-data" class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">{{ __('Judul Diagram / Nama Tab') }}</label>
                    <input type="text" name="title" :value="isUploadingNewTab ? '' : (currentDiagram ? currentDiagram.title : '')" placeholder="{{ __('contoh: Detail B2 (Roller 1-6)') }}" class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="border-2 border-dashed border-slate-200 rounded-xl p-6 text-center hover:border-blue-400 transition" @dragover.prevent @drop.prevent="handleFileDrop($event)">
                    <template x-if="!imagePreview">
                        <div>
                            <svg class="w-10 h-10 text-slate-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <p class="text-xs font-bold text-slate-700">{{ __('Pilih file gambar atau drag ke sini') }}</p>
                            <p class="text-[10px] text-slate-400 mt-1">{{ __('PNG, JPG, WEBP hingga 10MB') }}</p>
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
                    <button type="button" @click="showUploadModal = false" class="px-3 py-1.5 rounded-lg text-xs font-bold border border-slate-200 text-slate-600">{{ __('Batal') }}</button>
                    <button type="submit" :disabled="uploading" class="px-4 py-1.5 bg-blue-600 text-white rounded-lg text-xs font-bold hover:bg-blue-700 shadow-xs">
                        <span x-show="!uploading">{{ __('Unggah Gambar') }}</span>
                        <span x-show="uploading">{{ __('Mengunggah...') }}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Hotspot Form Modal -->
    <div x-show="showHotspotFormModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-xs p-4" x-cloak>
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4" @click.away="showHotspotFormModal = false">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="font-bold text-slate-800 text-sm" x-text="activeHotspot.id ? '{{ __('Edit Hotspot Dot') }}' : '{{ __('Tambah Hotspot Dot Baru') }}'"></h3>
                <button type="button" @click="showHotspotFormModal = false" class="text-slate-400 hover:text-slate-600 font-bold text-base">&times;</button>
            </div>

            <form @submit.prevent="saveHotspotForm()" class="space-y-4 text-xs">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">{{ __('Nomor / Label Hotspot Dot (misal: 1, 2, 3...)') }}</label>
                    <input type="text" x-model="activeHotspot.label" required placeholder="{{ __('Contoh: 1') }}" class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">{{ __('Nama Part / Deskripsi Singkat') }}</label>
                    <input type="text" x-model="activeHotspot.popup_title" placeholder="{{ __('Contoh: 1. Barrel Rotunda Curtain Assembly') }}" class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">{{ __('Aksi Saat Dot Diklik') }}</label>
                    <select x-model="activeHotspot.action_type" class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-blue-500">
                        <option value="scroll_row">{{ __('Sorot & Scroll ke Baris Tabel Part (Nomor Item)') }}</option>
                        <option value="popup">{{ __('Tampilkan Modal Pop-up Info') }}</option>
                    </select>
                </div>

                <template x-if="activeHotspot.action_type === 'popup'">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">{{ __('Isi Detail Pop-up Info') }}</label>
                        <textarea x-model="activeHotspot.popup_content" rows="3" placeholder="{{ __('Tuliskan spesifikasi/penjelasan detail komponen ini...') }}" class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                </template>

                <div class="flex justify-between items-center pt-3 border-t border-slate-100">
                    <template x-if="activeHotspot.id">
                        <button type="button" @click="deleteHotspot(activeHotspot.id)" class="px-3 py-1.5 bg-rose-50 text-rose-600 border border-rose-200 rounded-lg text-xs font-bold hover:bg-rose-100">
                            {{ __('Hapus Dot Ini') }}
                        </button>
                    </template>
                    <template x-if="!activeHotspot.id">
                        <div></div>
                    </template>

                    <div class="flex gap-2">
                        <button type="button" @click="showHotspotFormModal = false" class="px-3 py-1.5 border border-slate-200 text-slate-600 rounded-lg text-xs font-bold">{{ __('Batal') }}</button>
                        <button type="submit" :disabled="savingHotspot" class="px-4 py-1.5 bg-blue-600 text-white rounded-lg text-xs font-bold hover:bg-blue-700 shadow-xs">
                            <span x-show="!savingHotspot">{{ __('Simpan Hotspot') }}</span>
                            <span x-show="savingHotspot">{{ __('Menyimpan...') }}</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
