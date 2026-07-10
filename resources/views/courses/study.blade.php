<x-app-layout>
    @if($chapter->order == 1)
        <!-- Custom Dual Layout for Chapter 1: Mekanikal & Elektrikal -->
        <div class="py-6 select-none" x-data="{
            modules: {{ $modules->toJson() }},
            
            // Mechanical State
            activeMechId: 'intro_mekanikal',
            mechItems: [],
            
            // Electrical State
            activeElecId: 'intro_elektrikal',
            elecItems: [],
            
            init() {
                // Initialize mechanical items
                this.mechItems.push({
                    id: 'intro_mekanikal',
                    title: 'Deskripsi Komponen Mekanikal',
                    button_title: 'Pengantar',
                    content: `<p class='mt-2'>Garbarata merupakan sebuah jembatan elektromekanik yang menghubungkan bangunan Bandara dengan pesawat yang berfungsi sebagai media para penumpang untuk berpindah dari Pesawat menuju Bandara atau sebaliknya. Dengan menggunakan Garbarata, penumpang dapat terlindungi dari hujan, suara bising, angin debu dan berbagai macam hal lainnya yang dapat menciderai penumpang atau hal yang dapat mengganggu operasional Bandara.</p><p class='mt-4'>Garbarata menggunakan sistem elektromekanik yang dikendalikan melalui sebuah control console di cabin. Sistem kendali ini mengintegrasikan seluruh peralatan keselamatan dan sistem kendali elektronik. Sistem kendali elektronik menggunakan unit kendali yang disebut Programmable Logic Controller atau PLC.</p>`,
                    image_path: null
                });
    <div class="py-6 select-none" x-data="studyPage(@js($modules->values()))">
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
                        Materi modul pembelajaran tertulis. Gunakan tombol pilihan topik sub-bab di bawah untuk berpindah antar materi.
                    @endif
                </p>
            </div>

            <!-- Main study room layout (Stacked, clean, and full width) -->
            <div class="space-y-6">
                
                this.modules.filter(m => m.title.startsWith('1.')).forEach(m => {
                    this.mechItems.push({
                        id: m.id,
                        title: m.title,
                        button_title: m.title,
                        content: m.content,
                        image_path: m.image_path
                    });
                });
                
                // Initialize electrical items
                this.elecItems.push({
                    id: 'intro_elektrikal',
                    title: 'Deskripsi Komponen Elektrikal dan Sistem Kontrol',
                    button_title: 'Pengantar',
                    content: `<p class='mt-2'>Bagian ini menjelaskan proses operasi system elektrikal Garbarata. Gambar skema detil terdapat pada gambar As-Built. Tenaga listrik didistribusikan dari bangunan bandara melalui Main Power Panel, Sub-Distribution Power Panel dan Console Desk. Dari komponen elektrik tersebut, energy listrik digunakan untuk menaktifkan actuator, sensor dan beberapa komponen elektrik pada Garbarata. Kontrol utama berada pada Console Desk yang menggunakan Control Face Plate dan Touchscreen sebagai interface operator. Operator juga dapat memeriksa kondisi komponen Garbarata jika terjadi kegagalan melalui monitor pada Console Desk.</p>`,
                    image_path: null
                });
                
                this.modules.filter(m => m.title.startsWith('2.')).forEach(m => {
                    this.elecItems.push({
                        id: m.id,
                        title: m.title,
                        button_title: m.title,
                        content: m.content,
                        image_path: m.image_path
                    });
                });
            },

            setMechModule(moduleId) {
                this.activeMechId = moduleId;
                this.scrollToMechReader();
            },

            scrollToMechReader() {
                this.$nextTick(() => {
                    this.$refs.mechReader?.scrollIntoView({ behavior: 'smooth', block: 'start' });
                });
            },
            
            getActiveMech() {
                return this.mechItems.find(item => item.id === this.activeMechId) || { title: '', content: '', image_path: null };
            },
            
            getActiveElec() {
                return this.elecItems.find(item => item.id === this.activeElecId) || { title: '', content: '', image_path: null };
            },
            
            nextMech() {
                const index = this.mechItems.findIndex(item => item.id === this.activeMechId);
                if (index !== -1 && index < this.mechItems.length - 1) {
                    this.activeMechId = this.mechItems[index + 1].id;
                }
            },
            
            prevMech() {
                const index = this.mechItems.findIndex(item => item.id === this.activeMechId);
                if (index > 0) {
                    this.activeMechId = this.mechItems[index - 1].id;
                }
            },
            
            isMechFirst() {
                return this.mechItems.findIndex(item => item.id === this.activeMechId) === 0;
            },
            
            isMechLast() {
                return this.mechItems.findIndex(item => item.id === this.activeMechId) === this.mechItems.length - 1;
            },
            
            nextElec() {
                const index = this.elecItems.findIndex(item => item.id === this.activeElecId);
                if (index !== -1 && index < this.elecItems.length - 1) {
                    this.activeElecId = this.elecItems[index + 1].id;
                }
            },
            
            prevElec() {
                const index = this.elecItems.findIndex(item => item.id === this.activeElecId);
                if (index > 0) {
                this.activeElecId = this.elecItems[index - 1].id;
                }
            },
            
            isElecFirst() {
                return this.elecItems.findIndex(item => item.id === this.activeElecId) === 0;
            },
            
            isElecLast() {
                return this.elecItems.findIndex(item => item.id === this.activeElecId) === this.elecItems.length - 1;
            }
        }">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">
                
                <!-- Navigation Back & Title Bar -->
                <div class="flex items-center justify-between">
                    <a href="{{ route('courses.show', $course->id) }}" class="inline-flex items-center text-xs font-bold text-gray-500 hover:text-blue-600 transition">
                        ← Kembali ke Silabus Kursus
                    </a>
                    
                    <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-[9px] font-bold text-blue-600 border border-blue-100 uppercase tracking-wider">
                        Bab {{ $chapter->order }} dari {{ $chapters->count() }}
                    </span>
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
                            <div class="text-xs text-slate-600 leading-relaxed space-y-3.5 prose prose-slate max-w-none prose-sm" x-html="renderModuleContent(getActiveModule().content)">
                                Memuat isi modul pembelajaran...
                            </div>

                            <template x-if="getActiveModule().image_path">
                                <div id="torque-diagram" class="rounded-xl border border-gray-200 bg-gray-50 p-3 shadow-sm my-3 max-w-2xl mx-auto">
                                    <img :src="'/' + getActiveModule().image_path" class="w-full max-h-72 object-contain rounded-lg select-none" :alt="getActiveModule().title">
                                </div>
                            </template>
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

                <!-- ================= BAGIAN 1: KOMPONEN MEKANIKAL ================= -->
                <section class="space-y-6">
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-6">
                    <div class="flex items-center space-x-3 border-b border-gray-100 pb-3">
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-blue-200 bg-white text-[10px] font-black text-blue-600">01</span>
                        <h2 class="text-sm font-extrabold text-slate-800 uppercase tracking-wider">Deskripsi Komponen Mekanikal</h2>
                    </div>

                    <!-- Sub-Chapter Selector for Mechanical -->
                    <div class="bg-slate-50/50 p-3 rounded-xl border border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-3">
                        <div class="flex items-center space-x-2 shrink-0">
                            <span class="text-2xs font-bold text-slate-500 uppercase tracking-wide">Pilih Topik Mekanikal:</span>
                        </div>
                        <div class="flex flex-wrap gap-1.5">
                            <template x-for="item in mechItems" :key="item.id">
                                <button
                                    @click="setMechModule(item.id)"
                                    class="px-3 py-1.5 rounded-lg text-2xs font-bold transition text-left"
                                    :class="activeMechId === item.id ? 'bg-blue-600 text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200'"
                                >
                                    <span x-text="item.button_title"></span>
                                </button>
                            </template>
                        </div>
                    </div>

                    <p class="text-[10px] font-semibold text-slate-400">
                        Klik judul topik untuk membuka materi yang lebih lengkap.
                    </p>

                    <!-- Interactive Diagram with Hotspots -->
                    @if($diagram)
                        <section class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm max-w-4xl mx-auto w-full">
                            <div class="relative bg-white rounded-xl overflow-hidden aspect-[1755/896] w-full border border-gray-200 flex items-center justify-center shadow-sm">
                                @if($diagram->image_path && file_exists(public_path($diagram->image_path)))
                                    <img src="{{ asset($diagram->image_path) }}" class="w-full h-full object-contain select-none" alt="Diagram {{ $chapter->title }}">
                                @endif
                                
                                <!-- Overlay Hotspots -->
                                @foreach($diagram->hotspots as $hotspot)
                                    <button
                                        @click="setMechModule({{ $hotspot->target_module_id }})"
                                        class="absolute z-20 group -translate-x-1/2 -translate-y-1/2 focus:outline-none"
                                        style="left: {{ $hotspot->x_percent }}%; top: {{ $hotspot->y_percent }}%;"
                                    >
                                        <span class="absolute inline-flex h-8 w-8 rounded-full bg-[#0091ff] opacity-40 animate-ping -left-[4px] -top-[4px]"></span>
                                        <span class="relative inline-flex rounded-full h-6 w-6 bg-[#0091ff] border-2 border-white items-center justify-center shadow-md transition-all duration-150 group-hover:scale-110"
                                              :class="activeMechId === {{ $hotspot->target_module_id }} ? 'bg-[#0070c6] scale-110 ring-4 ring-[#0091ff]/20' : ''">
                                            <span class="text-white text-[10px] font-bold">{{ $loop->iteration }}</span>
                                        </span>
                                        <span class="absolute left-1/2 -translate-x-1/2 bottom-7 bg-slate-900 text-white text-[10px] font-semibold px-2 py-0.5 rounded shadow transition-all duration-150 opacity-0 transform translate-y-1 group-hover:opacity-100 group-hover:translate-y-0 whitespace-nowrap z-30 pointer-events-none">
                                            {{ $hotspot->label }}
                                        </span>
                                    </button>
                                @endforeach
                              </div>
                          </section>
                      @endif

                    </div>

                      <!-- Mechanical Reader Card -->
                      <div id="chapter1-reader" x-ref="mechReader" class="bg-white rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between min-h-[320px] w-full">
                          <div class="p-4 md:p-6 space-y-5">
                              <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                                  <span class="inline-flex h-8 items-center rounded-full border border-blue-200 bg-white px-3 text-[9px] font-bold text-blue-600 uppercase tracking-wider">
                                      Modul Mekanikal
                                  </span>
                                  <span class="text-[10px] text-gray-400 font-semibold" x-text="activeMechId === 'intro_mekanikal' ? 'Halaman Pengantar' : 'Topik ' + getActiveMech().title.split(' ')[0]"></span>
                              </div>

                              <div class="space-y-4">
                                  <h2 class="text-base font-bold text-slate-800 leading-snug" x-text="getActiveMech().title"></h2>

                                  <div class="text-xs text-slate-600 leading-relaxed space-y-3.5 prose prose-slate max-w-none prose-sm" x-html="getActiveMech().content"></div>
                              </div>
                          </div>

                          <!-- Footer Navigation Inside Card -->
                          <div class="border-t border-slate-100 p-4 bg-slate-50/50 flex items-center justify-between rounded-b-2xl">
                              <button
                                  @click="prevMech()"
                                  :disabled="isMechFirst()"
                                  class="inline-flex items-center justify-center rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-2xs font-bold text-slate-600 transition hover:bg-slate-50 disabled:opacity-50 disabled:cursor-not-allowed shadow-2xs"
                              >
                                  ← Sebelumnya
                              </button>
                              
                              <button
                                  @click="nextMech()"
                                  :disabled="isMechLast()"
                                  class="inline-flex items-center justify-center rounded-lg bg-slate-900 px-3.5 py-1.5 text-2xs font-bold text-white transition hover:bg-slate-800 disabled:opacity-50 disabled:cursor-not-allowed shadow-2xs"
                              >
                                  Selanjutnya →
                              </button>
                          </div>
                      </div>
                </section>

                  <!-- ================= BAGIAN 2: KOMPONEN ELEKTRIKAL & SISTEM KONTROL ================= -->
                  <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-6">
                      <div class="flex items-center space-x-3 border-b border-gray-100 pb-3">
                          <span class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-emerald-200 bg-white text-[10px] font-black text-emerald-600">02</span>
                          <h2 class="text-sm font-extrabold text-slate-800 uppercase tracking-wider">Deskripsi Komponen Elektrikal dan Sistem Kontrol</h2>
                      </div>

                      <!-- Sub-Chapter Selector for Electrical -->
                      <div class="bg-slate-50/50 p-3 rounded-xl border border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-3">
                          <div class="flex items-center space-x-2 shrink-0">
                              <span class="text-2xs font-bold text-slate-500 uppercase tracking-wide">Pilih Topik Elektrikal:</span>
                          </div>
                          <div class="flex flex-wrap gap-1.5">
                              <template x-for="item in elecItems" :key="item.id">
                                  <button
                                      @click="activeElecId = item.id"
                                      class="px-3 py-1.5 rounded-lg text-2xs font-bold transition text-left"
                                      :class="activeElecId === item.id ? 'bg-emerald-600 text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200'"
                                  >
                                      <span x-text="item.button_title"></span>
                                  </button>
                              </template>
                          </div>
                      </div>

                      <!-- Electrical Reader Card (Kotak Teks Baru) -->
                      <div class="bg-white rounded-2xl border border-slate-100 flex flex-col justify-between min-h-[320px] w-full">
                          <div class="p-4 md:p-6 space-y-5">
                              <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                                  <span class="inline-flex h-8 items-center rounded-full border border-emerald-200 bg-white px-3 text-[9px] font-bold text-emerald-600 uppercase tracking-wider">
                                      Modul Elektrikal & Kontrol
                                  </span>
                                  <span class="text-[10px] text-gray-400 font-semibold" x-text="activeElecId === 'intro_elektrikal' ? 'Halaman Pengantar' : 'Topik ' + getActiveElec().title.split(' ')[0]"></span>
                              </div>

                              <div class="space-y-4">
                                  <h2 class="text-base font-bold text-slate-800 leading-snug" x-text="getActiveElec().title"></h2>

                                  <template x-if="getActiveElec().image_path">
                                      <div class="rounded-xl border border-gray-200 bg-gray-50 p-2 shadow-xs my-3 max-w-xl mx-auto">
                                          <img :src="'/' + getActiveElec().image_path" class="w-full max-h-64 object-contain rounded-lg select-none" :alt="getActiveElec().title">
                                      </div>
                                  </template>

                                  <div class="text-xs text-slate-600 leading-relaxed space-y-3.5 prose prose-slate max-w-none prose-sm" x-html="getActiveElec().content"></div>
                              </div>
                          </div>

                          <!-- Footer Navigation Inside Card -->
                          <div class="border-t border-slate-100 p-4 bg-slate-50/50 flex items-center justify-between rounded-b-2xl">
                              <button
                                  @click="prevElec()"
                                  :disabled="isElecFirst()"
                                  class="inline-flex items-center justify-center rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-2xs font-bold text-slate-600 transition hover:bg-slate-50 disabled:opacity-50 disabled:cursor-not-allowed shadow-2xs"
                              >
                                  ← Sebelumnya
                              </button>
                              
                              <button
                                  @click="nextElec()"
                                  :disabled="isElecLast()"
                                  class="inline-flex items-center justify-center rounded-lg bg-slate-900 px-3.5 py-1.5 text-2xs font-bold text-white transition hover:bg-slate-800 disabled:opacity-50 disabled:cursor-not-allowed shadow-2xs"
                              >
                                  Selanjutnya →
                              </button>
                          </div>
                      </div>
                  </div>

              </div>
          </div>
    @elseif($chapter->order == 3)
        <!-- Custom Grouped Layout for Chapter 3: Operation Details & Procedures -->
        <div class="py-6 select-none" x-data="{
            modules: @js($modules),
            detailItems: [],
            manualItems: [],
            autoItems: [],
            procedureItems: [],
            expandedSectionIds: [],

            init() {
                this.detailItems = this.modules.filter(module => module.title.startsWith('1.'));
                this.manualItems = this.modules.filter(module => module.title.startsWith('2.'));
                this.autoItems = this.modules.filter(module => module.title.startsWith('3.'));
                this.procedureItems = this.modules.filter(module => module.title.startsWith('4.'));
            },

            toggleSection(sectionId) {
                if (this.expandedSectionIds.includes(sectionId)) {
                    this.expandedSectionIds = this.expandedSectionIds.filter(id => id !== sectionId);
                    return;
                }

                this.expandedSectionIds.push(sectionId);
            },

            isSectionExpanded(sectionId) {
                return this.expandedSectionIds.includes(sectionId);
            }
        }">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <!-- Navigation Back & Title Bar -->
                <div class="flex items-center justify-between">
                    <a href="{{ route('courses.show', $course->id) }}" class="inline-flex items-center text-xs font-bold text-gray-500 hover:text-blue-600 transition">
                        â† Kembali ke Silabus Kursus
                    </a>

                    <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-[9px] font-bold text-blue-600 border border-blue-100 uppercase tracking-wider">
                        Bab {{ $chapter->order }} dari {{ $chapters->count() }}
                    </span>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-800 text-sm">
                        {{ str_replace("BAB {$chapter->order}: ", "", $chapter->title) }}
                    </h3>
                    <p class="text-xs text-gray-500 mt-1.5 leading-relaxed">
                        Materi Bab 3 dibagi menjadi detail pengoperasian, mode operasi manual, mode auto, dan prosedur pengoperasian. Setiap bagian dapat dibuka dan ditutup agar materi lebih mudah dibaca.
                    </p>
                </div>

                <div class="space-y-4">
                    <!-- Detail Operation Group -->
                    <section class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                        <button
                            type="button"
                            @click="toggleSection('detail')"
                            class="w-full flex flex-col gap-3 bg-white p-6 text-left transition hover:bg-slate-50 md:flex-row md:items-center md:justify-between"
                        >
                            <div class="flex items-center space-x-3">
                                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-blue-200 bg-white text-[10px] font-black text-blue-600">01</span>
                                <div>
                                    <h2 class="text-sm font-extrabold text-slate-800 uppercase tracking-wider">Detail Pengoperasian</h2>
                                    <p class="mt-1 text-[10px] font-semibold text-slate-400">Klik judul bagian untuk melihat materi lengkap.</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-2">
                                <span class="inline-flex w-fit rounded-full border border-blue-200 bg-white px-2.5 py-0.5 text-[9px] font-bold text-blue-600 uppercase tracking-wider">
                                    Module 1.1
                                </span>
                                <span
                                    class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-full border border-slate-200 bg-white text-sm font-black text-slate-600 transition"
                                    x-text="isSectionExpanded('detail') ? '-' : '+'"
                                ></span>
                            </div>
                        </button>

                        <div x-show="isSectionExpanded('detail')" class="border-t border-gray-100 bg-white">
                            <div class="p-4 md:p-6 space-y-4">
                                <template x-for="module in detailItems" :key="module.id">
                                    <article class="rounded-xl border border-gray-100 bg-white p-4 space-y-3 shadow-sm">
                                        <div class="border-b border-gray-100 pb-3">
                                            <h3 class="text-xs md:text-sm font-bold text-slate-800 leading-snug" x-text="module.title"></h3>
                                        </div>

                                        <div class="text-xs text-slate-600 leading-relaxed space-y-3.5 prose prose-slate max-w-none prose-sm" x-html="module.content"></div>
                                    </article>
                                </template>
                            </div>
                        </div>
                    </section>

                    <!-- Manual Operation Group -->
                    <section class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                        <button
                            type="button"
                            @click="toggleSection('manual')"
                            class="w-full flex flex-col gap-3 bg-white p-6 text-left transition hover:bg-slate-50 md:flex-row md:items-center md:justify-between"
                        >
                            <div class="flex items-center space-x-3">
                                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-emerald-200 bg-white text-[10px] font-black text-emerald-600">02</span>
                                <div>
                                    <h2 class="text-sm font-extrabold text-slate-800 uppercase tracking-wider">Mode Operasi Manual</h2>
                                    <p class="mt-1 text-[10px] font-semibold text-slate-400">Klik judul bagian untuk melihat materi lengkap.</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-2">
                                <span class="inline-flex w-fit rounded-full border border-emerald-200 bg-white px-2.5 py-0.5 text-[9px] font-bold text-emerald-600 uppercase tracking-wider">
                                    Module 2.1 - 2.4
                                </span>
                                <span
                                    class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-full border border-slate-200 bg-white text-sm font-black text-slate-600 transition"
                                    x-text="isSectionExpanded('manual') ? '-' : '+'"
                                ></span>
                            </div>
                        </button>

                        <div x-show="isSectionExpanded('manual')" class="border-t border-gray-100 bg-white">
                            <div class="p-4 md:p-6 space-y-4">
                                <p class="text-xs text-slate-600 leading-relaxed">
                                    Dengan memutar keyswitch ke mode manual akan mengaktifkan seluruh komponen  penggerak Garbarata
                                </p>

                                <template x-for="module in manualItems" :key="module.id">
                                    <article class="rounded-xl border border-gray-100 bg-white p-4 space-y-3 shadow-sm">
                                        <div class="border-b border-gray-100 pb-3">
                                            <h3 class="text-xs md:text-sm font-bold text-slate-800 leading-snug" x-text="module.title"></h3>
                                        </div>

                                        <div class="text-xs text-slate-600 leading-relaxed space-y-3.5 prose prose-slate max-w-none prose-sm" x-html="module.content"></div>
                                    </article>
                                </template>
                            </div>
                        </div>
                    </section>

                    <!-- Auto Mode Group -->
                    <section class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                        <button
                            type="button"
                            @click="toggleSection('auto')"
                            class="w-full flex flex-col gap-3 bg-white p-6 text-left transition hover:bg-slate-50 md:flex-row md:items-center md:justify-between"
                        >
                            <div class="flex items-center space-x-3">
                                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-amber-200 bg-white text-[10px] font-black text-amber-600">03</span>
                                <div>
                                    <h2 class="text-sm font-extrabold text-slate-800 uppercase tracking-wider">Mode Auto (Autolevel)</h2>
                                    <p class="mt-1 text-[10px] font-semibold text-slate-400">Klik judul bagian untuk melihat materi lengkap.</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-2">
                                <span class="inline-flex w-fit rounded-full border border-amber-200 bg-white px-2.5 py-0.5 text-[9px] font-bold text-amber-600 uppercase tracking-wider">
                                    Module 3
                                </span>
                                <span
                                    class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-full border border-slate-200 bg-white text-sm font-black text-slate-600 transition"
                                    x-text="isSectionExpanded('auto') ? '-' : '+'"
                                ></span>
                            </div>
                        </button>

                        <div x-show="isSectionExpanded('auto')" class="border-t border-gray-100 bg-white">
                            <div class="p-4 md:p-6 space-y-4">
                                <template x-for="module in autoItems" :key="module.id">
                                    <article class="rounded-xl border border-gray-100 bg-white p-4 space-y-3 shadow-sm">
                                        <div class="border-b border-gray-100 pb-3">
                                            <h3 class="text-xs md:text-sm font-bold text-slate-800 leading-snug" x-text="module.title"></h3>
                                        </div>

                                        <div class="text-xs text-slate-600 leading-relaxed space-y-3.5 prose prose-slate max-w-none prose-sm" x-html="module.content"></div>
                                    </article>
                                </template>
                            </div>
                        </div>
                    </section>

                    <!-- Operation Procedure Group -->
                    <section class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                        <button
                            type="button"
                            @click="toggleSection('procedure')"
                            class="w-full flex flex-col gap-3 bg-white p-6 text-left transition hover:bg-slate-50 md:flex-row md:items-center md:justify-between"
                        >
                            <div class="flex items-center space-x-3">
                                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-rose-200 bg-white text-[10px] font-black text-rose-600">04</span>
                                <div>
                                    <h2 class="text-sm font-extrabold text-slate-800 uppercase tracking-wider">Prosedur Pengoperasian</h2>
                                    <p class="mt-1 text-[10px] font-semibold text-slate-400">Klik judul bagian untuk melihat materi lengkap.</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-2">
                                <span class="inline-flex w-fit rounded-full border border-rose-200 bg-white px-2.5 py-0.5 text-[9px] font-bold text-rose-600 uppercase tracking-wider">
                                    Module 4.1 - 4.6
                                </span>
                                <span
                                    class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-full border border-slate-200 bg-white text-sm font-black text-slate-600 transition"
                                    x-text="isSectionExpanded('procedure') ? '-' : '+'"
                                ></span>
                            </div>
                        </button>

                        <div x-show="isSectionExpanded('procedure')" class="border-t border-gray-100 bg-white">
                            <div class="p-4 md:p-6 space-y-4">
                                <template x-for="module in procedureItems" :key="module.id">
                                    <article class="rounded-xl border border-gray-100 bg-white p-4 space-y-3 shadow-sm">
                                        <div class="border-b border-gray-100 pb-3">
                                            <h3 class="text-xs md:text-sm font-bold text-slate-800 leading-snug" x-text="module.title"></h3>
                                        </div>

                                        <div class="text-xs text-slate-600 leading-relaxed space-y-3.5 prose prose-slate max-w-none prose-sm" x-html="module.content"></div>
                                    </article>
                                </template>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    @elseif($chapter->order == 2)
        <!-- Custom Grouped Layout for Chapter 2: Mechanical Specs & Electrical Specs -->
        <div class="py-6 select-none" x-data="{
            modules: @js($modules),
            mechItems: [],
            elecItems: [],
            expandedMechIds: [],

            init() {
                this.mechItems = this.modules.filter(module => module.title.startsWith('1.'));
                this.elecItems = this.modules.filter(module => module.title.startsWith('2.'));
            },

            toggleMech(moduleId) {
                if (this.expandedMechIds.includes(moduleId)) {
                    this.expandedMechIds = this.expandedMechIds.filter(id => id !== moduleId);
                    return;
                }

                this.expandedMechIds.push(moduleId);
            },

            isMechExpanded(moduleId) {
                return this.expandedMechIds.includes(moduleId);
            }
        }">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <!-- Navigation Back & Title Bar -->
                <div class="flex items-center justify-between">
                    <a href="{{ route('courses.show', $course->id) }}" class="inline-flex items-center text-xs font-bold text-gray-500 hover:text-blue-600 transition">
                        â† Kembali ke Silabus Kursus
                    </a>

                    <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-[9px] font-bold text-blue-600 border border-blue-100 uppercase tracking-wider">
                        Bab {{ $chapter->order }} dari {{ $chapters->count() }}
                    </span>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-800 text-sm">
                        {{ str_replace("BAB {$chapter->order}: ", "", $chapter->title) }}
                    </h3>
                    <p class="text-xs text-gray-500 mt-1.5 leading-relaxed">
                        Materi Bab 2 dibagi menjadi spesifikasi mekanikal dan elektrikal. Bagian mekanikal dapat dibuka dan ditutup per topik agar tabel dan gambar lebih mudah dibaca.
                    </p>
                </div>

                <div class="space-y-8">
                    <!-- Mechanical Group -->
                    <section class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-5">
                        <div class="flex flex-col gap-2 border-b border-gray-100 pb-4 md:flex-row md:items-center md:justify-between">
                            <div class="flex items-center space-x-3">
                                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-blue-200 bg-white text-[10px] font-black text-blue-600">01</span>
                                <h2 class="text-sm font-extrabold text-slate-800 uppercase tracking-wider">Mekanikal</h2>
                            </div>

                            <span class="inline-flex w-fit rounded-full border border-blue-200 bg-white px-2.5 py-0.5 text-[9px] font-bold text-blue-600 uppercase tracking-wider">
                                Module 1.1 - 1.4
                            </span>
                        </div>

                        <p class="text-[10px] font-semibold text-slate-400">
                            Klik judul module untuk melihat materi lengkap.
                        </p>

                        <div class="space-y-3">
                            <template x-for="module in mechItems" :key="module.id">
                                <article class="rounded-xl border border-gray-100 bg-white overflow-hidden shadow-sm">
                                    <button
                                        type="button"
                                        @click="toggleMech(module.id)"
                                        class="w-full flex items-center justify-between gap-4 bg-white px-4 py-3.5 text-left transition hover:bg-slate-50"
                                    >
                                        <span class="text-xs md:text-sm font-bold text-slate-800" x-text="module.title"></span>
                                        <span
                                            class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-full border border-slate-200 bg-white text-sm font-black text-slate-600 transition"
                                            x-text="isMechExpanded(module.id) ? '-' : '+'"
                                        ></span>
                                    </button>

                                    <div x-show="isMechExpanded(module.id)" class="border-t border-gray-100 bg-white">
                                        <div class="p-4 md:p-6 space-y-4">
                                            <div class="text-xs text-slate-600 leading-relaxed space-y-3.5 prose prose-slate max-w-none prose-sm" x-html="module.content"></div>
                                        </div>
                                    </div>
                                </article>
                            </template>
                        </div>
                    </section>

                    <!-- Electrical Group -->
                    <section class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-5">
                        <div class="flex flex-col gap-2 border-b border-gray-100 pb-4 md:flex-row md:items-center md:justify-between">
                            <div class="flex items-center space-x-3">
                                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-emerald-200 bg-white text-[10px] font-black text-emerald-600">02</span>
                                <h2 class="text-sm font-extrabold text-slate-800 uppercase tracking-wider">Elektrikal</h2>
                            </div>

                            <span class="inline-flex w-fit rounded-full border border-emerald-200 bg-white px-2.5 py-0.5 text-[9px] font-bold text-emerald-600 uppercase tracking-wider">
                                Module 2.1 - 2.3
                            </span>
                        </div>

                        <div class="space-y-4">
                            <template x-for="module in elecItems" :key="module.id">
                                <article class="rounded-xl border border-gray-100 bg-white p-4 space-y-3 shadow-sm">
                                    <div class="border-b border-gray-100 pb-3">
                                        <h3 class="text-xs md:text-sm font-bold text-slate-800 leading-snug" x-text="module.title"></h3>
                                    </div>

                                    <div class="text-xs text-slate-600 leading-relaxed space-y-3 prose prose-slate max-w-none prose-sm" x-html="module.content"></div>
                                </article>
                            </template>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    @else
        <!-- Standard Layout for other chapters -->
        <div class="py-6 select-none" x-data="{
            activeModuleId: {{ $modules->first() ? $modules->first()->id : 'null' }},
            modules: {{ $modules->toJson() }},
            getActiveModule() {
                return this.modules.find(m => m.id === this.activeModuleId) || { title: '', content: '', image_path: null };
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

                <!-- Main study room layout (Stacked, clean, and full width) -->
                <div class="space-y-6">
                    
                    <!-- 1. Top horizontal Sub-Chapter Navigation Bar -->
                    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-3">
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

                    <!-- 2. Interactive Diagram (if exists) -->
                    @if($diagram)
                        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 max-w-4xl mx-auto w-full">
                            <div class="relative bg-[#eef3f8] rounded-xl overflow-hidden aspect-[1755/896] w-full border border-[#dce4ec] flex items-center justify-center shadow-inner">
                                
                                @if($diagram->image_path && file_exists(public_path($diagram->image_path)))
                                    <img src="{{ asset($diagram->image_path) }}" class="w-full h-full object-contain select-none" alt="Diagram {{ $chapter->title }}">
                                @else
                                    <!-- Dynamic Fallback SVG Schematic based on Chapter Order -->
                                    <div class="absolute inset-0 flex flex-col items-center justify-center p-8 select-none">
                                        @if($chapter->order == 7)
                                            <!-- Electrical Panel Fallback Schematic -->
                                            <svg class="w-full h-full max-h-[260px] opacity-[0.06] text-[#0091ff]" viewBox="0 0 800 400" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                                                <rect x="50" y="50" width="700" height="300" rx="10" stroke-dasharray="5" />
                                                <path d="M100 200 L200 200 M250 200 L350 200 M400 200 L550 200 M600 200 L700 200" />
                                                <rect x="200" y="170" width="50" height="60" rx="4" />
                                                <rect x="350" y="170" width="50" height="60" rx="4" />
                                                <rect x="550" y="150" width="50" height="100" rx="5" />
                                                <line x1="575" y1="150" x2="575" y2="100" />
                                                <path d="M100 280 L700 280 M150 280 L150 320 M150 320 L170 320" />
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
                            </div>
                        </div>
                    @endif

                    <!-- 3. Full-Width Content Reader Card -->
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

                                <template x-if="getActiveModule().image_path">
                                    <div class="rounded-xl border border-gray-200 bg-gray-50 p-3 shadow-sm my-3 max-w-2xl mx-auto">
                                        <img :src="'/' + getActiveModule().image_path" class="w-full max-h-72 object-contain rounded-lg select-none" :alt="getActiveModule().title">
                                    </div>
                                </template>

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
        </div>
    @endif
</x-app-layout>
