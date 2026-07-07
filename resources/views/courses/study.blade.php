@section('topbar_title', $chapter->title)

<x-app-layout>
    <div class="py-6 select-none" x-data="{
        activeModuleId: {{ $modules->first() ? $modules->first()->id : 'null' }},
        modules: {{ $modules->toJson() }},
        getActiveModule() {
            return this.modules.find(m => m.id === this.activeModuleId) || { title: '', content: '' };
        },
        nextModule() {
            const index = this.modules.findIndex(m => m.id === this.activeModuleId);
            if (index !== -1 && index < this.modules.length - 1) {
                this.activeModuleId = this.modules[index + 1].id;
            }
        },
        prevModule() {
            const index = this.modules.findIndex(m => m.id === this.activeModuleId);
            if (index > 0) {
                this.activeModuleId = this.modules[index - 1].id;
            }
        },
        isFirst() {
            return this.modules.findIndex(m => m.id === this.activeModuleId) === 0;
        },
        isLast() {
            return this.modules.findIndex(m => m.id === this.activeModuleId) === this.modules.length - 1;
        }
    }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Navigation Back & Title Bar -->
            <div class="flex items-center justify-between">
                <a href="{{ route('courses.show', $course->id) }}" class="inline-flex items-center text-xs font-bold text-gray-500 hover:text-blue-600 transition">
                    ← Kembali ke Silabus Kursus
                </a>
                
                <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-[9px] font-bold text-blue-600 border border-blue-100 uppercase tracking-wider">
                    Bab {{ $chapter->order }} dari {{ $chapters->count() }}
                </span>
            </div>

            <!-- Chapter Header Description Card -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h3 class="font-bold text-gray-800 text-sm">
                    {{ str_replace("BAB {$chapter->order}: ", "", $chapter->title) }}
                </h3>
                <p class="text-xs text-gray-500 mt-1.5 leading-relaxed">
                    @if($diagram)
                        Materi pembelajaran interaktif dilengkapi visualisasi skematis. <strong>Klik pada titik-titik biru bernomor (hotspots)</strong> pada gambar atau pilih daftar sub-bab di bawah untuk membaca detail spesifikasi.
                    @else
                        Materi modul pembelajaran tertulis. Gunakan menu navigasi di panel sebelah kiri untuk berpindah antar topik sub-bab.
                    @endif
                </p>
            </div>

            <!-- Main study room layout -->
            @if($diagram)
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                    
                    <!-- LEFT SIDE: Interactive Diagram + List of Topics (span 7) -->
                    <div class="lg:col-span-7 space-y-6">
                        <!-- Interactive Diagram Card -->
                        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
                            <div class="relative bg-[#eef3f8] rounded-xl overflow-hidden aspect-[16/10] border border-[#dce4ec] flex items-center justify-center shadow-inner">
                                
                                @if($diagram->image_path && file_exists(public_path($diagram->image_path)))
                                    <img src="{{ asset($diagram->image_path) }}" class="w-full h-full object-cover select-none" alt="Diagram {{ $chapter->title }}">
                                @else
                                    <!-- Dynamic Fallback SVG Schematic based on Chapter Order -->
                                    <div class="absolute inset-0 flex flex-col items-center justify-center p-8 select-none">
                                        
                                        @if($chapter->order == 7)
                                            <!-- Electrical Panel Fallback Schematic -->
                                            <svg class="w-full h-full max-h-[260px] opacity-[0.06] text-[#0091ff]" viewBox="0 0 800 400" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                                                <!-- Circuit Grid -->
                                                <rect x="50" y="50" width="700" height="300" rx="10" stroke-dasharray="5" />
                                                <path d="M100 200 L200 200 M250 200 L350 200 M400 200 L550 200 M600 200 L700 200" />
                                                <!-- Relays/Transformers -->
                                                <rect x="200" y="170" width="50" height="60" rx="4" />
                                                <rect x="350" y="170" width="50" height="60" rx="4" />
                                                <!-- Main terminal switch -->
                                                <rect x="550" y="150" width="50" height="100" rx="5" />
                                                <line x1="575" y1="150" x2="575" y2="100" />
                                                <!-- Ground lines -->
                                                <path d="M100 280 L700 280 M150 280 L150 320 M150 320 L170 320" />
                                                <!-- Glow indicator -->
                                                <circle cx="575" cy="200" r="10" />
                                            </svg>
                                            <span class="absolute text-sm font-bold text-slate-500 tracking-wide text-center">
                                                Skema Rangkaian Elektrik<br>
                                                <span class="text-xs font-normal text-slate-400 mt-1 block">(Gambar Rangkaian Kontrol Daya 380V)</span>
                                            </span>
                                        @else
                                            <!-- Standard Boarding Bridge Silhouette Fallback -->
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
                                            <span class="absolute text-sm font-bold text-slate-500 tracking-wide text-center">
                                                Gambar 3D Garbarata<br>
                                                <span class="text-xs font-normal text-slate-400 mt-1 block">(Siluet Jembatan Penumpang)</span>
                                            </span>
                                        @endif
                                    </div>
                                @endif

                                <!-- Overlay Hotspots -->
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
                            </div>
                        </div>

                        <!-- Topic List Sidebar (Vertical listing of sub-chapters) -->
                        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 space-y-3">
                            <h4 class="font-bold text-slate-800 text-xs tracking-wide uppercase">Topik Sub-Bab</h4>
                            <div class="space-y-1">
                                <template x-for="module in modules" :key="module.id">
                                    <button 
                                        @click="activeModuleId = module.id"
                                        class="w-full flex items-center space-x-3 px-3.5 py-2.5 rounded-lg text-xs font-semibold transition text-left"
                                        :class="activeModuleId === module.id ? 'bg-[#e6f4ff] text-[#0091ff]' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-800'"
                                    >
                                        <!-- Bullet marker -->
                                        <span class="h-1.5 w-1.5 rounded-full shrink-0" :class="activeModuleId === module.id ? 'bg-[#0091ff]' : 'bg-gray-300'"></span>
                                        <span class="truncate" x-text="module.title"></span>
                                    </button>
                                </template>
                            </div>
                        </div>

                        <!-- Jump to other Chapters menu -->
                        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 space-y-3">
                            <h4 class="font-bold text-slate-800 text-xs tracking-wide uppercase">Pindah Bab Buku</h4>
                            <div class="grid grid-cols-2 gap-2">
                                @foreach($chapters as $c)
                                    <a 
                                        href="{{ route('courses.chapters.show', [$course->id, $c->id]) }}" 
                                        class="px-3 py-2 text-center rounded-lg text-[10px] font-bold border transition duration-150 {{ $c->id == $chapter->id ? 'bg-slate-900 text-white border-slate-950' : 'bg-white text-slate-600 border-gray-100 hover:bg-slate-50' }}"
                                    >
                                        BAB {{ $c->order }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- RIGHT SIDE: Content Reader / Active Module Viewer (span 5) -->
                    <div class="lg:col-span-5">
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between min-h-[480px]">
                            
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

                                <!-- Title and HTML Content -->
                                <div class="space-y-4">
                                    <h2 class="text-lg font-bold text-slate-800 leading-snug" x-text="getActiveModule().title">
                                        Memuat materi...
                                    </h2>
                                    
                                    <!-- Active Module Content body (rendered with HTML) -->
                                    <div class="text-xs text-slate-600 leading-relaxed space-y-3.5 prose prose-slate max-w-none prose-sm" x-html="getActiveModule().content">
                                        Memuat isi modul pembelajaran...
                                    </div>
                                </div>
                            </div>

                            <!-- Footer Navigation inside Card -->
                            <div class="border-t border-gray-100 p-4 bg-gray-50/50 flex items-center justify-between rounded-b-2xl">
                                <button 
                                    @click="prevModule()" 
                                    :disabled="isFirst()" 
                                    class="inline-flex items-center justify-center rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-2xs font-bold text-slate-600 transition hover:bg-slate-50 disabled:opacity-50 disabled:cursor-not-allowed shadow-2xs"
                                >
                                    ← Sebelumnya
                                </button>
                                
                                <button 
                                    @click="nextModule()" 
                                    :disabled="isLast()" 
                                    class="inline-flex items-center justify-center rounded-lg bg-slate-900 px-3.5 py-1.5 text-2xs font-bold text-white transition hover:bg-slate-800 disabled:opacity-50 disabled:cursor-not-allowed shadow-2xs"
                                >
                                    Selanjutnya →
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            @else
                <!-- Full-Width Layout for Chapters without Diagram (e.g. BAB 2, 4, 5) -->
                <div class="space-y-6">
                    
                    <!-- Top horizontal Sub-Chapter Navigation Bar -->
                    <div class="bg-white p-4 rounded-xl shadow-xs border border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-3">
                        <div class="flex items-center space-x-2 shrink-0">
                            <span class="text-xs font-bold text-slate-700 uppercase tracking-wide">Pilih Topik Sub-Bab:</span>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <template x-for="module in modules" :key="module.id">
                                <button 
                                    @click="activeModuleId = module.id"
                                    class="px-4 py-2.5 rounded-lg text-xs font-bold transition text-left"
                                    :class="activeModuleId === module.id ? 'bg-blue-600 text-white shadow-sm' : 'bg-slate-50 text-slate-600 hover:bg-slate-100 hover:text-slate-800'"
                                >
                                    <span x-text="module.title"></span>
                                </button>
                            </template>
                        </div>
                    </div>

                    <!-- Full Width Content Reader Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between min-h-[480px] w-full">
                        
                        <!-- Article Content Area -->
                        <div class="p-6 md:p-8 space-y-6">
                            <!-- Topic Badge & Nav Bar -->
                            <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                                <span class="rounded-full bg-slate-100 px-2.5 py-0.5 text-[9px] font-bold text-slate-500 uppercase tracking-wider">
                                    Materi Pembelajaran
                                </span>
                                
                                <span class="text-[10px] text-gray-400 font-semibold">
                                    Mode Belajar Mandiri (Lebar Penuh)
                                </span>
                            </div>

                            <!-- Title and HTML Content -->
                            <div class="space-y-4">
                                <h2 class="text-lg font-bold text-slate-800 leading-snug" x-text="getActiveModule().title">
                                    Memuat materi...
                                </h2>
                                
                                <!-- Active Module Content body (rendered with HTML) -->
                                <div class="text-xs text-slate-600 leading-relaxed space-y-3.5 prose prose-slate max-w-none prose-sm" x-html="getActiveModule().content">
                                    Memuat isi modul pembelajaran...
                                </div>
                            </div>
                        </div>

                        <!-- Footer Navigation inside Card -->
                        <div class="border-t border-gray-100 p-4 bg-gray-50/50 flex items-center justify-between rounded-b-2xl">
                            <button 
                                @click="prevModule()" 
                                :disabled="isFirst()" 
                                class="inline-flex items-center justify-center rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-2xs font-bold text-slate-600 transition hover:bg-slate-50 disabled:opacity-50 disabled:cursor-not-allowed shadow-2xs"
                            >
                                ← Sebelumnya
                            </button>
                            
                            <button 
                                @click="nextModule()" 
                                :disabled="isLast()" 
                                class="inline-flex items-center justify-center rounded-lg bg-slate-900 px-3.5 py-1.5 text-2xs font-bold text-white transition hover:bg-slate-800 disabled:opacity-50 disabled:cursor-not-allowed shadow-2xs"
                            >
                                Selanjutnya →
                            </button>
                        </div>
                    </div>

                    <!-- Bottom horizontal Chapter Switcher Bar -->
                    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 space-y-3">
                        <h4 class="font-bold text-slate-800 text-xs tracking-wide uppercase">Pindah Bab Buku</h4>
                        <div class="flex flex-wrap gap-2">
                            @foreach($chapters as $c)
                                <a 
                                    href="{{ route('courses.chapters.show', [$course->id, $c->id]) }}" 
                                    class="px-4 py-2.5 text-center rounded-lg text-xs font-bold border transition duration-150 {{ $c->id == $chapter->id ? 'bg-slate-900 text-white border-slate-950' : 'bg-white text-slate-600 border-gray-100 hover:bg-slate-50' }}"
                                >
                                    BAB {{ $c->order }}: {{ str_replace("BAB {$c->order}: ", "", $c->title) }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                </div>
            @endif
        </div>
    </div>
</x-app-layout>
