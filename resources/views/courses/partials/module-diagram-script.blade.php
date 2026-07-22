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
                dotSize: localStorage.getItem('lms_dotsize_mod_' + moduleId) || 'md',
                setDotSize(size) {
                    this.dotSize = size;
                    localStorage.setItem('lms_dotsize_mod_' + moduleId, size);
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
                            const num = parseInt(hotspot.label, 10);
                            const targetId = hotspot.label;

                            // Walk up from current diagram component to find the containing module card
                            let container = this.$el ? this.$el.parentElement : null;
                            while (container && container !== document.body && !container.querySelector('table')) {
                                container = container.parentElement;
                            }
                            if (!container) container = document;

                            // Special handling for 5.1.2 Tunnel Roller with reference tabs
                            if (!isNaN(num) && typeof window.scrollToRollerRow === 'function' && container.querySelector('#roller-row-1')) {
                                window.scrollToRollerRow(num);
                                return;
                            }

                            // Locate table row inside THIS module's container
                            let row = container.querySelector(`[id$="-row-${targetId}"]`)
                                   || container.querySelector(`[id="part-row-${targetId}"]`)
                                   || container.querySelector(`[id*="-row-${targetId}"]`)
                                   || container.querySelector(`tr:nth-child(${targetId})`);

                            // Fallback to global document search if not found in container
                            if (!row) {
                                const prefixes = [
                                    'part-row-', 'roller-row-', 'cable-row-', 'lift-row-', 'bogie-row-',
                                    'stair-row-', 'rotation-row-', 'curtain-row-', 'leveler-row-', 'closure-row-',
                                    'swing-row-', 'weathering-row-', 'equalizer-row-', 'row-'
                                ];
                                for (const prefix of prefixes) {
                                    const candidate = document.getElementById(prefix + targetId);
                                    if (candidate) {
                                        row = candidate;
                                        break;
                                    }
                                }
                            }

                            if (row) {
                                row.scrollIntoView({ behavior: 'smooth', block: 'center' });

                                // Remove previous highlights
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
