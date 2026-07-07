@section('topbar_title', 'Materi Interaktif Garbarata')

<x-app-layout>
    <div class="py-12" x-data="{
        activeModuleId: null,
        modules: {{ $modules->toJson() }},
        getActiveModule() {
            return this.modules.find(m => m.id === this.activeModuleId) || { title: '', content: '', image_path: null };
        },
        nextModule() {
            const index = this.modules.findIndex(m => m.id === this.activeModuleId);
            if (index !== -1 && index < this.modules.length - 1) {
                this.activeModuleId = this.modules[index + 1].id;
            } else if (this.activeModuleId === null && this.modules.length > 0) {
                this.activeModuleId = this.modules[0].id;
            }
        },
        prevModule() {
            const index = this.modules.findIndex(m => m.id === this.activeModuleId);
            if (index > 0) {
                this.activeModuleId = this.modules[index - 1].id;
            }
        },
        isFirst() {
            if (this.activeModuleId === null) return true;
            return this.modules.findIndex(m => m.id === this.activeModuleId) === 0;
        },
        isLast() {
            if (this.activeModuleId === null) return true;
            return this.modules.findIndex(m => m.id === this.activeModuleId) === this.modules.length - 1;
        }
    }">
        <div class="w-full mx-auto sm:px-6 lg:px-8" :class="$store.ui.sidebarCollapsed ? 'max-w-none' : 'max-w-7xl'">
            <!-- Navigation Back Button -->
            <div class="mb-4">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center text-xs font-bold text-gray-500 hover:text-blue-600 transition">
                    ← Kembali ke Dashboard
                </a>
            </div>

            <!-- Top Description Card from Mockup -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-6">
                <h3 class="font-bold text-gray-800 text-sm">Pengenalan Komponen Garbarata</h3>
                <p class="text-xs text-gray-500 mt-1 leading-relaxed">
                    Pelajari bagian-bagian dari <em>Passenger Boarding Bridge</em> (PBB). <strong>Klik pada titik-titik biru (hotspots)</strong> pada gambar di bawah ini untuk mempelajari spesifikasi setiap komponen.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                <!-- SISI KIRI: Diagram Interaktif Garbarata (span 7) -->
                <div class="lg:col-span-8 space-y-6">
                    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
                        <!-- Diagram Box -->
                        <div class="relative bg-[#eef3f8] rounded-xl overflow-hidden aspect-[1755/896] w-full border border-[#dce4ec] flex items-center justify-center shadow-inner">

                            @if($diagram && $diagram->image_path && file_exists(public_path($diagram->image_path)))
                                <img src="{{ asset($diagram->image_path) }}" class="w-full h-full object-contain select-none" alt="Diagram Garbarata">
                            @else
                                <!-- Premium Blueprint SVG Schematic Fallback with Mockup Text -->
                                <div class="absolute inset-0 flex flex-col items-center justify-center p-8 select-none">
                                    <!-- Low-contrast schematic outline -->
                                    <svg class="w-full h-full max-h-[260px] opacity-[0.06] text-[#0091ff]" viewBox="0 0 800 400" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                                        <line x1="50" y1="360" x2="750" y2="360" stroke-dasharray="5 5" />
                                        <path d="M50 150 L50 250 M50 180 L110 180 L110 220 L50 220" stroke-dasharray="4" />
                                        <circle cx="150" cy="200" r="35" fill="currentColor" fill-opacity="0.03" />
                                        <circle cx="150" cy="200" r="10" />
                                        <rect x="185" y="175" width="160" height="50" rx="6" />
                                        <rect x="345" y="180" width="150" height="40" rx="6" />
                                        <line x1="495" y1="220" x2="495" y2="320" stroke-width="5" />
                                        <line x1="460" y1="320" x2="530" y2="320" stroke-width="8" />
                                        <circle cx="475" cy="340" r="18" />
                                        <circle cx="515" cy="340" r="18" />
                                        <path d="M495 200 L590 200 L630 170 L630 270 L590 240 Z" />
                                    </svg>
                                    <!-- Mockup title text centered -->
                                    <span class="absolute text-sm font-bold text-slate-500 tracking-wide text-center">
                                        Gambar 3D Garbarata<br>
                                        <span class="text-xs font-normal text-slate-400 mt-1 block">(Siluet Jembatan Penumpang)</span>
                                    </span>
                                </div>
                            @endif

                            <!-- Overlay Hotspots -->
                            @if($diagram)
                                @foreach($diagram->hotspots as $hotspot)
                                    <button
                                        @click="activeModuleId = {{ $hotspot->target_module_id }}"
                                        class="absolute z-20 group -translate-x-1/2 -translate-y-1/2 focus:outline-none"
                                        style="left: {{ $hotspot->x_percent }}%; top: {{ $hotspot->y_percent }}%;"
                                    >
                                        <!-- Outer Pulse Effect -->
                                        <span class="absolute inline-flex h-8 w-8 rounded-full bg-[#0091ff] opacity-40 animate-ping -left-[4px] -top-[4px]"></span>
                                        <!-- Inner Solid Circle with white number -->
                                        <span class="relative inline-flex rounded-full h-6 w-6 bg-[#0091ff] border-2 border-white items-center justify-center shadow-md transition-all duration-150 group-hover:scale-110"
                                              :class="activeModuleId === {{ $hotspot->target_module_id }} ? 'bg-[#0070c6] scale-110 ring-4 ring-[#0091ff]/20' : ''">
                                            <span class="text-white text-[10px] font-bold">{{ $loop->iteration }}</span>
                                        </span>
                                        <!-- Tooltip label -->
                                        <span class="absolute left-1/2 -translate-x-1/2 bottom-7 bg-slate-900 text-white text-[10px] font-semibold px-2 py-0.5 rounded shadow transition-all duration-150 opacity-0 transform translate-y-1 group-hover:opacity-100 group-hover:translate-y-0 whitespace-nowrap z-30 pointer-events-none">
                                            {{ $hotspot->label }}
                                        </span>
                                    </button>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <!-- Modul List Navigation Sidebar -->
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <h4 class="font-bold text-gray-900 text-sm mb-3">Daftar Modul Kursus</h4>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                            <template x-for="(module, index) in modules" :key="module.id">
                                <button
                                    @click="activeModuleId = module.id"
                                    class="p-3 text-left border rounded-xl transition text-xs font-semibold flex flex-col justify-between h-20"
                                    :class="activeModuleId === module.id ? 'border-indigo-600 bg-indigo-50/50 text-indigo-700' : 'border-gray-100 bg-white text-gray-600 hover:bg-gray-50'"
                                >
                                    <span x-text="'Materi ' + (index + 1)" class="text-[10px] text-gray-400 uppercase tracking-wider"></span>
                                    <span x-text="module.title.split('. ').slice(1).join('. ') || module.title" class="line-clamp-2 mt-1"></span>
                                </button>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- SISI KANAN: Detail Materi Modul (span 5) -->
                <div class="lg:col-span-4">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col h-full min-h-[500px]">

                        <!-- Initial Placeholder when no module is active -->
                        <template x-if="activeModuleId === null">
                            <div class="p-8 flex-1 flex flex-col items-center justify-center text-center space-y-4 my-auto">
                                <div class="p-4 bg-blue-50 text-blue-600 rounded-full">
                                    <!-- Sleek Cursor/Click Icon from screenshot -->
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.042 21.672L13.684 16.6m0 0l-2.51 2.225.569-9.47 5.227 7.917-3.286-.672zm-7.518-.267A9.016 9.016 0 013.3 12c0-4.97 4.03-9 9-9s9 4.03 9 9a9 9 0 01-1.782 5.378"></path>
                                    </svg>
                                </div>
                                <h3 class="text-sm font-bold text-gray-800">Detail Komponen</h3>
                                <p class="text-xs text-gray-500 max-w-[240px] leading-relaxed">
                                    Pilih salah satu komponen pada gambar di samping untuk melihat materi detail.
                                </p>
                            </div>
                        </template>

                        <!-- Module Content Area -->
                        <template x-if="activeModuleId !== null">
                            <div class="flex flex-col h-full flex-1">
                                <!-- Header Modul Aktif -->
                                <div class="p-6 bg-gray-50/50 border-b border-gray-100">
                                    <span class="text-xs text-blue-600 font-bold uppercase tracking-wider">{{ $course->title }}</span>
                                    <template x-if="getActiveModule().image_path">
                                        <div class="mt-3 rounded-xl border border-gray-200 bg-white p-3 shadow-sm">
                                            <img
                                                :src="'/' + getActiveModule().image_path"
                                                class="w-full max-h-56 object-contain rounded-lg select-none"
                                                :alt="getActiveModule().title"
                                            >
                                        </div>
                                    </template>
                                    <h3 class="text-lg font-bold text-gray-900 mt-1" aria-live="polite">
                                        <span class="sr-only">Materi aktif: </span>
                                        <span x-text="getActiveModule().title || 'Belum ada materi dipilih'"></span>
                                    </h3>
                                </div>

                                <!-- Konten Modul -->
                                <div class="p-6 flex-1 overflow-y-auto prose max-w-none text-sm text-gray-600 leading-relaxed space-y-4">
                                    <div x-html="getActiveModule().content"></div>
                                </div>

                                <!-- Footer Navigasi Modul -->
                                <div class="p-6 bg-gray-50/50 border-t border-gray-100 flex items-center justify-between">
                                    <button
                                        @click="prevModule()"
                                        :disabled="isFirst()"
                                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-xs font-semibold text-gray-700 bg-white hover:bg-gray-50 focus:outline-none disabled:opacity-50 disabled:cursor-not-allowed transition"
                                    >
                                        ← Sebelumnya
                                    </button>
                                    <button
                                        @click="nextModule()"
                                        :disabled="isLast()"
                                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none disabled:opacity-50 disabled:cursor-not-allowed transition"
                                    >
                                        Berikutnya →
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
