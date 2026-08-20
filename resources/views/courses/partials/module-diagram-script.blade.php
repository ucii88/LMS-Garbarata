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
                            showGlobalAlert(@js(__('Gagal')), data.message || @js(__('Gagal mengunggah gambar.')));
                        }
                    } catch (err) {
                        showGlobalAlert(@js(__('Kesalahan')), @js(__('Terjadi kesalahan koneksi.')));
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
                                   || container.querySelector(`[id="part-row-${targetId}"]`)
                                   || container.querySelector(`[id*="-row-${targetId}"]`);

                            if (!row) {
                                const prefixes = [
                                    'part-row-', 'roller-row-', 'cable-row-', 'lift-row-', 'bogie-row-',
                                    'stair-row-', 'rotation-row-', 'curtain-row-', 'leveler-row-', 'closure-row-',
                                    'swing-row-', 'weathering-row-', 'equalizer-row-', 'auto-row-', 'canopy-row-',
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
                        showGlobalAlert(@js(__('Gagal')), @js(__('Terjadi kesalahan saat menyimpan hotspot.')));
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
                            const data = await res.json();
                            if (res.ok && data.success) {
                                this.hotspots = this.hotspots.filter(h => h.id !== id);
                                if (this.activeHotspot && this.activeHotspot.id === id) {
                                    this.activeHotspot = null;
                                }
                                this.showHotspotFormModal = false;
                            } else {
                                showGlobalAlert(@js(__('Gagal')), data.message || @js(__('Gagal menghapus hotspot.')));
                            }
                        } catch (e) {
                            showGlobalAlert(@js(__('Gagal')), @js(__('Terjadi kesalahan koneksi.')));
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
                    if (this.originalHotspots && this.originalHotspots.length > 0) {
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
                            this.editMode = false;
                            showGlobalAlert(@js(__('Berhasil')), @js(__('Posisi Hotspot berhasil disimpan.')));
                        } else {
                            showGlobalAlert(@js(__('Gagal')), @js(__('Gagal menyimpan posisi.')));
                        }
                    } catch (err) {
                        showGlobalAlert(@js(__('Gagal')), @js(__('Terjadi kesalahan jaringan.')));
                    }
                    this.saving = false;
                }
            };
        };
    }
</script>
