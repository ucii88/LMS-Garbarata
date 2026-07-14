<x-app-layout>
    @if($chapter->order == 1)
        <script>
            window.chapterOneStudy = function (modules) {
                return {
                    modules,
                    completeUrlTemplate: @js(route('courses.modules.complete', [$course->id, $chapter->id, '__MODULE__'])),
                    csrfToken: @js(csrf_token()),
                    activeMechId: 'intro_mekanikal',
                    mechItems: [],
                    activeElecId: 'intro_elektrikal',
                    elecItems: [],

                    init() {
                        this.mechItems = [
                            {
                                id: 'intro_mekanikal',
                                title: 'Deskripsi Komponen Mekanikal',
                                button_title: 'Pengantar',
                                content: `<p class='mt-2'>Garbarata merupakan sebuah jembatan elektromekanik yang menghubungkan bangunan Bandara dengan pesawat yang berfungsi sebagai media para penumpang untuk berpindah dari Pesawat menuju Bandara atau sebaliknya. Dengan menggunakan Garbarata, penumpang dapat terlindungi dari hujan, suara bising, angin debu dan berbagai macam hal lainnya yang dapat menciderai penumpang atau hal yang dapat mengganggu operasional Bandara.</p><p class='mt-4'>Garbarata menggunakan sistem elektromekanik yang dikendalikan melalui sebuah control console di cabin. Sistem kendali ini mengintegrasikan seluruh peralatan keselamatan dan sistem kendali elektronik. Sistem kendali elektronik menggunakan unit kendali yang disebut Programmable Logic Controller atau PLC.</p>`,
                                image_path: null,
                            },
                            ...this.modules
                                .filter((module) => module.title.startsWith('1.'))
                                .map((module) => ({
                                    id: module.id,
                                    title: module.title,
                                    button_title: module.title,
                                    content: module.content,
                                    image_path: module.image_path,
                                })),
                        ];

                        this.elecItems = [
                            {
                                id: 'intro_elektrikal',
                                title: 'Deskripsi Komponen Elektrikal dan Sistem Kontrol',
                                button_title: 'Pengantar',
                                content: `<p class='mt-2'>Bagian ini menjelaskan proses operasi system elektrikal Garbarata. Gambar skema detil terdapat pada gambar As-Built. Tenaga listrik didistribusikan dari bangunan bandara melalui Main Power Panel, Sub-Distribution Power Panel dan Console Desk. Dari komponen elektrik tersebut, energy listrik digunakan untuk menaktifkan actuator, sensor dan beberapa komponen elektrik pada Garbarata. Kontrol utama berada pada Console Desk yang menggunakan Control Face Plate dan Touchscreen sebagai interface operator. Operator juga dapat memeriksa kondisi komponen Garbarata jika terjadi kegagalan melalui monitor pada Console Desk.</p>`,
                                image_path: null,
                            },
                            ...this.modules
                                .filter((module) => module.title.startsWith('2.'))
                                .map((module) => ({
                                    id: module.id,
                                    title: module.title,
                                    button_title: module.title,
                                    content: module.content,
                                    image_path: module.image_path,
                                })),
                        ];
                    },

                    setMechModule(moduleId) {
                        this.activeMechId = moduleId;
                        this.markModuleComplete(moduleId);
                        this.scrollToMechReader();
                    },

                    setElecModule(moduleId) {
                        this.activeElecId = moduleId;
                        this.markModuleComplete(moduleId);
                    },

                    markModuleComplete(moduleId) {
                        if (!Number.isInteger(Number(moduleId))) {
                            return;
                        }

                        fetch(this.completeUrlTemplate.replace('__MODULE__', moduleId), {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': this.csrfToken,
                                'Accept': 'application/json',
                            },
                        });
                    },

                    scrollToMechReader() {
                        this.$nextTick(() => {
                            this.$refs.mechReader?.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        });
                    },

                    getActiveMech() {
                        return this.mechItems.find((item) => item.id === this.activeMechId) || { title: '', content: '', image_path: null };
                    },

                    getActiveElec() {
                        return this.elecItems.find((item) => item.id === this.activeElecId) || { title: '', content: '', image_path: null };
                    },

                    nextMech() {
                        const index = this.mechItems.findIndex((item) => item.id === this.activeMechId);
                        if (index !== -1 && index < this.mechItems.length - 1) {
                            this.setMechModule(this.mechItems[index + 1].id);
                        }
                    },

                    prevMech() {
                        const index = this.mechItems.findIndex((item) => item.id === this.activeMechId);
                        if (index > 0) {
                            this.activeMechId = this.mechItems[index - 1].id;
                        }
                    },

                    isMechFirst() {
                        return this.mechItems.findIndex((item) => item.id === this.activeMechId) === 0;
                    },

                    isMechLast() {
                        return this.mechItems.findIndex((item) => item.id === this.activeMechId) === this.mechItems.length - 1;
                    },

                    nextElec() {
                        const index = this.elecItems.findIndex((item) => item.id === this.activeElecId);
                        if (index !== -1 && index < this.elecItems.length - 1) {
                            this.setElecModule(this.elecItems[index + 1].id);
                        }
                    },

                    prevElec() {
                        const index = this.elecItems.findIndex((item) => item.id === this.activeElecId);
                        if (index > 0) {
                            this.activeElecId = this.elecItems[index - 1].id;
                        }
                    },

                    isElecFirst() {
                        return this.elecItems.findIndex((item) => item.id === this.activeElecId) === 0;
                    },

                    isElecLast() {
                        return this.elecItems.findIndex((item) => item.id === this.activeElecId) === this.elecItems.length - 1;
                    },
                };
            };
        </script>

        <div class="py-6 select-none" x-data="chapterOneStudy(@js($modules->values()))">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">
                <!-- Navigation Back & Title Bar -->
                <div class="flex items-center justify-between">
                    <a href="{{ route('courses.show', $course->id) }}" class="inline-flex items-center text-xs font-bold text-gray-500 hover:text-blue-600 transition">
                        &larr; Kembali ke Silabus Kursus
                    </a>

                    <div class="flex items-center gap-2">
                        @if(auth()->user()->isInstruktur())
                            <a href="{{ route('modules.create', [$course->id, $chapter->id]) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg text-2xs transition shadow-sm">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                </svg>
                                Tambah Modul Baru
                            </a>
                        @endif

                        <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-[9px] font-bold text-blue-600 border border-blue-100 uppercase tracking-wider">
                            Bab {{ $chapter->order }} dari {{ $chapters->count() }}
                        </span>
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

                                  @if(auth()->user()->isInstruktur())
                                      <template x-if="activeMechId !== 'intro_mekanikal'">
                                          <div class="flex items-center gap-2 pt-4 border-t border-slate-100">
                                              <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + activeMechId + '/edit'" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-2xs font-bold transition shadow-xs">
                                                  Edit Modul Ini
                                              </a>
                                              <form :action="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + activeMechId" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus modul ini?')">
                                                  @csrf
                                                  @method('DELETE')
                                                  <button type="submit" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-2xs font-bold transition shadow-xs">
                                                      Hapus Modul
                                                  </button>
                                              </form>
                                          </div>
                                      </template>
                                  @endif
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
                                      @click="setElecModule(item.id)"
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

                                  @if(auth()->user()->isInstruktur())
                                      <template x-if="activeElecId !== 'intro_elektrikal'">
                                          <div class="flex items-center gap-2 pt-4 border-t border-slate-100">
                                              <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + activeElecId + '/edit'" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-2xs font-bold transition shadow-xs">
                                                  Edit Modul Ini
                                              </a>
                                              <form :action="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + activeElecId" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus modul ini?')">
                                                  @csrf
                                                  @method('DELETE')
                                                  <button type="submit" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-2xs font-bold transition shadow-xs">
                                                      Hapus Modul
                                                  </button>
                                              </form>
                                          </div>
                                      </template>
                                  @endif
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

        @include('courses.partials.quiz-card')
        @include('courses.partials.practice-cards')
    @elseif($chapter->order == 3)
        <!-- Custom Grouped Layout for Chapter 3: Operation Details & Procedures -->
        <div class="py-6 select-none" x-data="{
            modules: @js($modules),
            completeUrlTemplate: @js(route('courses.modules.complete', [$course->id, $chapter->id, '__MODULE__'])),
            csrfToken: @js(csrf_token()),
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
                this.markSectionComplete(sectionId);

                if (this.expandedSectionIds.includes(sectionId)) {
                    this.expandedSectionIds = this.expandedSectionIds.filter(id => id !== sectionId);
                    return;
                }

                this.expandedSectionIds.push(sectionId);
            },

            isSectionExpanded(sectionId) {
                return this.expandedSectionIds.includes(sectionId);
            },

            markSectionComplete(sectionId) {
                const sectionMap = {
                    detail: this.detailItems,
                    manual: this.manualItems,
                    auto: this.autoItems,
                    procedure: this.procedureItems,
                };

                (sectionMap[sectionId] || []).forEach(module => this.markModuleComplete(module.id));
            },

            markModuleComplete(moduleId) {
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
                        â† Kembali ke Silabus Kursus
                    </a>

                    <div class="flex items-center gap-2">
                        @if(auth()->user()->isInstruktur())
                            <a href="{{ route('modules.create', [$course->id, $chapter->id]) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg text-2xs transition shadow-sm">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                </svg>
                                Tambah Modul Baru
                            </a>
                        @endif

                        <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-[9px] font-bold text-blue-600 border border-blue-100 uppercase tracking-wider">
                            Bab {{ $chapter->order }} dari {{ $chapters->count() }}
                        </span>
                    </div>
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

                                        @if(auth()->user()->isInstruktur())
                                            <div class="flex items-center gap-2 pt-3 border-t border-slate-100 mt-3">
                                                <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + module.id + '/edit'" class="px-2.5 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-3xs font-bold transition shadow-xs">
                                                    Edit Modul
                                                </a>
                                                <form :action="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + module.id" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus modul ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-2.5 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-3xs font-bold transition shadow-xs">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
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

                                        @if(auth()->user()->isInstruktur())
                                            <div class="flex items-center gap-2 pt-3 border-t border-slate-100 mt-3">
                                                <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + module.id + '/edit'" class="px-2.5 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-3xs font-bold transition shadow-xs">
                                                    Edit Modul
                                                </a>
                                                <form :action="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + module.id" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus modul ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-2.5 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-3xs font-bold transition shadow-xs">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
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

                                        @if(auth()->user()->isInstruktur())
                                            <div class="flex items-center gap-2 pt-3 border-t border-slate-100 mt-3">
                                                <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + module.id + '/edit'" class="px-2.5 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-3xs font-bold transition shadow-xs">
                                                    Edit Modul
                                                </a>
                                                <form :action="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + module.id" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus modul ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-2.5 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-3xs font-bold transition shadow-xs">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
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

                                        @if(auth()->user()->isInstruktur())
                                            <div class="flex items-center gap-2 pt-3 border-t border-slate-100 mt-3">
                                                <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + module.id + '/edit'" class="px-2.5 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-3xs font-bold transition shadow-xs">
                                                    Edit Modul
                                                </a>
                                                <form :action="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + module.id" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus modul ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-2.5 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-3xs font-bold transition shadow-xs">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </article>
                                </template>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>

        @include('courses.partials.quiz-card')
    @elseif($chapter->order == 2)
        <!-- Custom Grouped Layout for Chapter 2: Mechanical Specs & Electrical Specs -->
        <div class="py-6 select-none" x-data="{
            modules: @js($modules),
            completeUrlTemplate: @js(route('courses.modules.complete', [$course->id, $chapter->id, '__MODULE__'])),
            csrfToken: @js(csrf_token()),
            mechItems: [],
            elecItems: [],
            expandedMechIds: [],

            init() {
                this.mechItems = this.modules.filter(module => module.title.startsWith('1.'));
                this.elecItems = this.modules.filter(module => module.title.startsWith('2.'));
            },

            toggleMech(moduleId) {
                this.markModuleComplete(moduleId);

                if (this.expandedMechIds.includes(moduleId)) {
                    this.expandedMechIds = this.expandedMechIds.filter(id => id !== moduleId);
                    return;
                }

                this.expandedMechIds.push(moduleId);
            },

            isMechExpanded(moduleId) {
                return this.expandedMechIds.includes(moduleId);
            },

            markModuleComplete(moduleId) {
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
                        â† Kembali ke Silabus Kursus
                    </a>

                    <div class="flex items-center gap-2">
                        @if(auth()->user()->isInstruktur())
                            <a href="{{ route('modules.create', [$course->id, $chapter->id]) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg text-2xs transition shadow-sm">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                </svg>
                                Tambah Modul Baru
                            </a>
                        @endif

                        <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-[9px] font-bold text-blue-600 border border-blue-100 uppercase tracking-wider">
                            Bab {{ $chapter->order }} dari {{ $chapters->count() }}
                        </span>
                    </div>
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

                                            @if(auth()->user()->isInstruktur())
                                                <div class="flex items-center gap-2 pt-3 border-t border-slate-100 mt-3">
                                                    <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + module.id + '/edit'" class="px-2.5 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-3xs font-bold transition shadow-xs">
                                                        Edit Modul
                                                    </a>
                                                    <form :action="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + module.id" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus modul ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="px-2.5 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-3xs font-bold transition shadow-xs">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
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
                                <article @click="markModuleComplete(module.id)" class="rounded-xl border border-gray-100 bg-white p-4 space-y-3 shadow-sm cursor-pointer hover:border-emerald-200">
                                    <div class="border-b border-gray-100 pb-3">
                                        <h3 class="text-xs md:text-sm font-bold text-slate-800 leading-snug" x-text="module.title"></h3>
                                    </div>

                                    <div class="text-xs text-slate-600 leading-relaxed space-y-3 prose prose-slate max-w-none prose-sm" x-html="module.content"></div>

                                    @if(auth()->user()->isInstruktur())
                                        <div class="flex items-center gap-2 pt-3 border-t border-slate-100 mt-3">
                                            <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + module.id + '/edit'" class="px-2.5 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-3xs font-bold transition shadow-xs">
                                                Edit Modul
                                            </a>
                                            <form :action="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + module.id" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus modul ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-2.5 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-3xs font-bold transition shadow-xs">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </article>
                            </template>
                        </div>
                    </section>
                </div>
            </div>
        </div>

        @include('courses.partials.quiz-card')
    @elseif($chapter->order == 4)
        <!-- Custom Layout for Chapter 4 with Accordions for 4.6 -->
        <div class="py-6 select-none" x-data="{
            modules: @js($modules->values()),
            activeTab: '4.1',
            expandedModuleId: null,
            completeUrlTemplate: @js(route('courses.modules.complete', [$course->id, $chapter->id, '__MODULE__'])),
            csrfToken: @js(csrf_token()),

            get tabs() {
                const uniqueTabs = new Set();
                this.modules.forEach(m => {
                    const match = m.title.match(/^(4\.\d+)/);
                    if (match) uniqueTabs.add(match[1]);
                });
                return Array.from(uniqueTabs).sort((a, b) => parseInt(a.split('.')[1]) - parseInt(b.split('.')[1]));
            },
            init() {
                if (!this.tabs.includes(this.activeTab) && this.tabs.length > 0) {
                    this.activeTab = this.tabs[0];
                }
                const initialModule = this.getSingleModule(this.activeTab);
                if (initialModule && initialModule.id) {
                    this.markModuleComplete(initialModule.id);
                }
            },
            getTabModules(tab) {
                return this.modules.filter(m => m.title.startsWith(tab + '.'));
            },
            getSingleModule(tab) {
                let m = this.modules.find(m => m.title === tab || m.title.startsWith(tab + ' '));
                if (!m) m = this.modules.find(m => m.title.startsWith(tab));
                return m || { title: tab, content: '' };
            },
            toggleModule(id) {
                this.expandedModuleId = this.expandedModuleId === id ? null : id;
                if (this.expandedModuleId === id) {
                    let dbId = id;
                    if (isNaN(id)) {
                        const m = this.getSingleModule(id);
                        if (m) dbId = m.id;
                    }
                    this.markModuleComplete(dbId);
                }
            },
            markModuleComplete(moduleId) {
                if (!Number.isInteger(Number(moduleId)) || !this.completeUrlTemplate) return;
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
                        ← Kembali ke Silabus Kursus
                    </a>

                    <div class="flex items-center gap-2">
                        @if(auth()->user()->isInstruktur())
                            <a href="{{ route('modules.create', [$course->id, $chapter->id]) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg text-2xs transition shadow-sm">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                </svg>
                                Tambah Modul Baru
                            </a>
                        @endif

                        <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-[9px] font-bold text-blue-600 border border-blue-100 uppercase tracking-wider">
                            Bab {{ $chapter->order }} dari {{ $chapters->count() }}
                        </span>
                    </div>
                </div>

                <!-- Chapter Header Description Card -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-800 text-sm">
                        {{ str_replace("BAB {$chapter->order}: ", "", $chapter->title) }}
                    </h3>
                    <p class="text-xs text-gray-500 mt-1.5 leading-relaxed">
                        Materi modul pembelajaran tertulis. Gunakan menu navigasi di bawah untuk memilih sub-bab dan membaca detail spesifikasi.
                    </p>
                </div>

                <!-- Main Study Room Content -->
                <div class="space-y-6">
                    
                    <!-- 1. Top horizontal Sub-Chapter Navigation Bar -->
                    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-3">
                        <div class="flex items-center space-x-2 shrink-0">
                            <span class="text-xs font-bold text-slate-700 uppercase tracking-wide">Pilih Topik Sub-Bab:</span>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <template x-for="tab in tabs" :key="tab">
                                <button
                                    @click="activeTab = tab; expandedModuleId = null; const m = getSingleModule(tab); if(m && m.id) markModuleComplete(m.id);"
                                    class="px-4 py-2.5 rounded-lg text-xs font-bold transition text-left"
                                    :class="activeTab === tab ? 'bg-blue-600 text-white shadow-sm' : 'bg-slate-50 text-slate-600 hover:bg-slate-100 hover:text-slate-800'"
                                >
                                    <span x-text="tab === '4.6' ? '4.6 Checklist Inspeksi' : (tab === '4.7' ? '4.7 Troubleshooting' : getSingleModule(tab).title)"></span>
                                </button>
                            </template>
                        </div>
                    </div>

                    <!-- 2. Content Display Area -->
                    <div>
                        <!-- If Active Tab is 4.6 (Checklist) -> Show Accordions -->
                        <template x-if="activeTab === '4.6'">
                            <div class="space-y-4">
                                <!-- 4.6.1 Pemeriksaan Harian untuk Operator -->
                                <template x-if="getSingleModule('4.6.1').id">
                                    <div class="rounded-xl border border-gray-100 bg-white overflow-hidden shadow-sm">
                                        <button
                                            type="button"
                                            @click="toggleModule('4.6.1')"
                                            class="w-full flex items-center justify-between gap-4 bg-white px-4 py-3.5 text-left transition hover:bg-slate-50"
                                        >
                                            <span class="text-xs font-bold text-slate-800" x-text="getSingleModule('4.6.1').title"></span>
                                            <span
                                                class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-full border border-slate-200 bg-white text-sm font-black text-slate-600 transition"
                                                x-text="expandedModuleId === '4.6.1' ? '-' : '+'"
                                            ></span>
                                        </button>
                                        <div x-show="expandedModuleId === '4.6.1'" class="border-t border-gray-100 bg-white">
                                            <div class="p-4 md:p-6 space-y-4">
                                                <div class="text-xs text-slate-600 leading-relaxed space-y-3.5 prose prose-slate max-w-none prose-sm" x-html="getSingleModule('4.6.1').content"></div>
                                                
                                                <!-- Action Buttons for Instructor inside Accordion -->
                                                @if(auth()->user()->isInstruktur())
                                                    <div class="flex items-center gap-2 pt-4 border-t border-slate-100">
                                                        <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + getSingleModule('4.6.1').id + '/edit'" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-2xs font-bold transition shadow-xs">
                                                            Edit Modul Ini
                                                        </a>
                                                        <form :action="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + getSingleModule('4.6.1').id" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus modul ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-2xs font-bold transition shadow-xs">
                                                                Hapus Modul
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </template>

                                <!-- 4.6.2 Pelumasan -->
                                <template x-if="getSingleModule('4.6.2').id">
                                    <div class="rounded-xl border border-gray-100 bg-white overflow-hidden shadow-sm">
                                        <button
                                            type="button"
                                            @click="toggleModule('4.6.2')"
                                            class="w-full flex items-center justify-between gap-4 bg-white px-4 py-3.5 text-left transition hover:bg-slate-50"
                                        >
                                            <span class="text-xs font-bold text-slate-800" x-text="getSingleModule('4.6.2').title"></span>
                                            <span
                                                class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-full border border-slate-200 bg-white text-sm font-black text-slate-600 transition"
                                                x-text="expandedModuleId === '4.6.2' ? '-' : '+'"
                                            ></span>
                                        </button>
                                        <div x-show="expandedModuleId === '4.6.2'" class="border-t border-gray-100 bg-white">
                                            <div class="p-4 md:p-6 space-y-4">
                                                <div class="text-xs text-slate-600 leading-relaxed space-y-3.5 prose prose-slate max-w-none prose-sm" x-html="getSingleModule('4.6.2').content"></div>
                                                
                                                <!-- Action Buttons for Instructor inside Accordion -->
                                                @if(auth()->user()->isInstruktur())
                                                    <div class="flex items-center gap-2 pt-4 border-t border-slate-100">
                                                        <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + getSingleModule('4.6.2').id + '/edit'" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-2xs font-bold transition shadow-xs">
                                                            Edit Modul Ini
                                                        </a>
                                                        <form :action="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + getSingleModule('4.6.2').id" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus modul ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-2xs font-bold transition shadow-xs">
                                                                Hapus Modul
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </template>

                                <!-- 4.6.3 Inspeksi Bulanan (Parent Accordion) -->
                                <div class="rounded-xl border border-gray-100 bg-white overflow-hidden shadow-sm">
                                    <button
                                        type="button"
                                        @click="toggleModule('4.6.3')"
                                        class="w-full flex items-center justify-between gap-4 bg-slate-50 px-4 py-3.5 text-left transition hover:bg-slate-100"
                                    >
                                        <span class="text-xs font-bold text-slate-800">4.6.3 Inspeksi Bulanan</span>
                                        <span
                                            class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-full border border-slate-200 bg-white text-sm font-black text-slate-600 transition"
                                            x-text="expandedModuleId === '4.6.3' ? '-' : '+'"
                                        ></span>
                                    </button>
                                    <div x-show="expandedModuleId === '4.6.3'" class="border-t border-gray-100 bg-white p-4 space-y-3">
                                        <p class="text-[10px] text-slate-400 font-semibold mb-2">Pilih bagian tabel di bawah untuk melihat detail atau mengedit/menghapusnya:</p>
                                        <template x-for="subModule in modules.filter(m => m.title.startsWith('4.6.3.'))" :key="subModule.id">
                                            <details class="group rounded-xl border border-slate-200 bg-white shadow-xs overflow-hidden my-2.5" @toggle="if($el.open) markModuleComplete(subModule.id)">
                                                <summary class="flex items-center justify-between gap-3 cursor-pointer select-none px-4 py-2.5 bg-slate-50 hover:bg-slate-100 transition-colors duration-150 list-none">
                                                    <span class="font-bold text-slate-800 text-[10px] uppercase tracking-wide" x-text="subModule.title"></span>
                                                    <svg class="w-3.5 h-3.5 text-slate-400 transition-transform duration-200 group-open:rotate-180 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                                                </summary>
                                                <div class="border-t border-slate-100 bg-white p-4 space-y-4">
                                                    <div class="text-xs text-slate-600 leading-relaxed space-y-3.5 prose prose-slate max-w-none prose-sm" x-html="subModule.content"></div>
                                                    
                                                    <!-- Action Buttons for Instructor inside Accordion -->
                                                    @if(auth()->user()->isInstruktur())
                                                        <div class="flex items-center gap-2 pt-4 border-t border-slate-100">
                                                            <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + subModule.id + '/edit'" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-2xs font-bold transition shadow-xs">
                                                                Edit Tabel Ini
                                                            </a>
                                                            <form :action="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + subModule.id" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tabel ini?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-2xs font-bold transition shadow-xs">
                                                                    Hapus Tabel
                                                                </button>
                                                            </form>
                                                        </div>
                                                    @endif
                                                </div>
                                            </details>
                                        </template>
                                    </div>
                                </div>

                                <!-- 4.6.4 Inspeksi Quartal (Parent Accordion) -->
                                <div class="rounded-xl border border-gray-100 bg-white overflow-hidden shadow-sm">
                                    <button
                                        type="button"
                                        @click="toggleModule('4.6.4')"
                                        class="w-full flex items-center justify-between gap-4 bg-slate-50 px-4 py-3.5 text-left transition hover:bg-slate-100"
                                    >
                                        <span class="text-xs font-bold text-slate-800">4.6.4 Inspeksi Quartal</span>
                                        <span
                                            class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-full border border-slate-200 bg-white text-sm font-black text-slate-600 transition"
                                            x-text="expandedModuleId === '4.6.4' ? '-' : '+'"
                                        ></span>
                                    </button>
                                    <div x-show="expandedModuleId === '4.6.4'" class="border-t border-gray-100 bg-white p-4 space-y-3">
                                        <p class="text-[10px] text-slate-400 font-semibold mb-2">Pilih bagian tabel di bawah untuk melihat detail atau mengedit/menghapusnya:</p>
                                        <template x-for="subModule in modules.filter(m => m.title.startsWith('4.6.4.'))" :key="subModule.id">
                                            <details class="group rounded-xl border border-slate-200 bg-white shadow-xs overflow-hidden my-2.5" @toggle="if($el.open) markModuleComplete(subModule.id)">
                                                <summary class="flex items-center justify-between gap-3 cursor-pointer select-none px-4 py-2.5 bg-slate-50 hover:bg-slate-100 transition-colors duration-150 list-none">
                                                    <span class="font-bold text-slate-800 text-[10px] uppercase tracking-wide" x-text="subModule.title"></span>
                                                    <svg class="w-3.5 h-3.5 text-slate-400 transition-transform duration-200 group-open:rotate-180 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                                                </summary>
                                                <div class="border-t border-slate-100 bg-white p-4 space-y-4">
                                                    <div class="text-xs text-slate-600 leading-relaxed space-y-3.5 prose prose-slate max-w-none prose-sm" x-html="subModule.content"></div>
                                                    
                                                    <!-- Action Buttons for Instructor inside Accordion -->
                                                    @if(auth()->user()->isInstruktur())
                                                        <div class="flex items-center gap-2 pt-4 border-t border-slate-100">
                                                            <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + subModule.id + '/edit'" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-2xs font-bold transition shadow-xs">
                                                                Edit Tabel Ini
                                                            </a>
                                                            <form :action="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + subModule.id" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tabel ini?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-2xs font-bold transition shadow-xs">
                                                                    Hapus Tabel
                                                                </button>
                                                            </form>
                                                        </div>
                                                    @endif
                                                </div>
                                            </details>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <!-- If Active Tab is 4.7 (Troubleshooting) -> Show Intro + Accordions -->
                        <template x-if="activeTab === '4.7'">
                            <div class="space-y-4">
                                <!-- Introduction Card -->
                                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden p-6 md:p-8 space-y-4">
                                    <h3 class="text-base font-bold text-slate-800" x-text="getSingleModule('4.7').title"></h3>
                                    <div class="text-xs text-slate-600 leading-relaxed space-y-3.5 prose prose-slate max-w-none prose-sm" x-html="getSingleModule('4.7').content"></div>
                                    
                                    <!-- Action Buttons for Instructor inside Intro Card -->
                                    @if(auth()->user()->isInstruktur())
                                        <template x-if="getSingleModule('4.7').id">
                                            <div class="flex items-center gap-2 pt-4 border-t border-slate-100">
                                                <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + getSingleModule('4.7').id + '/edit'" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-2xs font-bold transition shadow-xs">
                                                    Edit Deskripsi Pengantar
                                                </a>
                                            </div>
                                        </template>
                                    @endif
                                </div>

                                <!-- Accordion List of TROUBLE tables -->
                                <div class="space-y-3">
                                    <template x-for="subModule in modules.filter(m => m.title.startsWith('4.7.'))" :key="subModule.id">
                                        <div class="rounded-xl border border-gray-100 bg-white overflow-hidden shadow-sm">
                                            <button
                                                type="button"
                                                @click="toggleModule(subModule.id)"
                                                class="w-full flex items-center justify-between gap-4 bg-white px-4 py-3.5 text-left transition hover:bg-slate-50"
                                            >
                                                <span class="text-xs font-bold text-slate-800" x-text="subModule.title"></span>
                                                <span
                                                    class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-full border border-slate-200 bg-white text-sm font-black text-slate-600 transition"
                                                    x-text="expandedModuleId === subModule.id ? '-' : '+'"
                                                ></span>
                                            </button>

                                            <div x-show="expandedModuleId === subModule.id" class="border-t border-gray-100 bg-white">
                                                <div class="p-4 md:p-6 space-y-4">
                                                    <div class="text-xs text-slate-600 leading-relaxed space-y-3.5 prose prose-slate max-w-none prose-sm" x-html="subModule.content"></div>
                                                    
                                                    <!-- Action Buttons for Instructor inside Accordion -->
                                                    @if(auth()->user()->isInstruktur())
                                                        <div class="flex items-center gap-2 pt-4 border-t border-slate-100">
                                                            <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + subModule.id + '/edit'" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-2xs font-bold transition shadow-xs">
                                                                Edit Tabel Trouble Ini
                                                            </a>
                                                            <form :action="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + subModule.id" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tabel trouble ini?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-2xs font-bold transition shadow-xs">
                                                                    Hapus Tabel Trouble
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
                        </template>

                        <!-- If Active Tab is not 4.6 and not 4.7 -> Show Intro + Sub-accordions -->
                        <template x-if="activeTab !== '4.6' && activeTab !== '4.7'">
                            <div class="space-y-4">
                                <!-- Introduction Card -->
                                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden p-6 md:p-8 space-y-4">
                                    <h3 class="text-base font-bold text-slate-800" x-text="getSingleModule(activeTab).title"></h3>
                                    <div class="text-xs text-slate-600 leading-relaxed space-y-3.5 prose prose-slate max-w-none prose-sm" x-html="getSingleModule(activeTab).content"></div>
                                    
                                    <!-- Action Buttons for Instructor inside Intro Card -->
                                    @if(auth()->user()->isInstruktur())
                                        <template x-if="getSingleModule(activeTab).id">
                                            <div class="flex items-center gap-2 pt-4 border-t border-slate-100">
                                                <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + getSingleModule(activeTab).id + '/edit'" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-2xs font-bold transition shadow-xs">
                                                    Edit Deskripsi Pengantar
                                                </a>
                                            </div>
                                        </template>
                                    @endif
                                </div>

                                <!-- Accordion List of Sub-modules (like 4.1.1, 4.1.2) -->
                                <template x-if="modules.filter(m => m.title.startsWith(activeTab + '.')).length > 0">
                                    <div class="space-y-3">
                                        <template x-for="subModule in modules.filter(m => m.title.startsWith(activeTab + '.'))" :key="subModule.id">
                                            <div class="rounded-xl border border-gray-100 bg-white overflow-hidden shadow-sm">
                                                <button
                                                    type="button"
                                                    @click="toggleModule(subModule.id)"
                                                    class="w-full flex items-center justify-between gap-4 bg-white px-4 py-3.5 text-left transition hover:bg-slate-50"
                                                >
                                                    <span class="text-xs font-bold text-slate-800" x-text="subModule.title"></span>
                                                    <span
                                                        class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-full border border-slate-200 bg-white text-sm font-black text-slate-600 transition"
                                                        x-text="expandedModuleId === subModule.id ? '-' : '+'"
                                                    ></span>
                                                </button>

                                                <div x-show="expandedModuleId === subModule.id" class="border-t border-gray-100 bg-white">
                                                    <div class="p-4 md:p-6 space-y-4">
                                                        <div class="text-xs text-slate-600 leading-relaxed space-y-3.5 prose prose-slate max-w-none prose-sm" x-html="subModule.content"></div>
                                                        
                                                        <!-- Action Buttons for Instructor inside Accordion -->
                                                        @if(auth()->user()->isInstruktur())
                                                            <div class="flex items-center gap-2 pt-4 border-t border-slate-100">
                                                                <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + subModule.id + '/edit'" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-2xs font-bold transition shadow-xs">
                                                                    Edit Modul Ini
                                                                </a>
                                                                <form :action="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + subModule.id" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus modul ini?')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-2xs font-bold transition shadow-xs">
                                                                        Hapus Modul
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </template>
                            </div>
                        </template>
                    </div>

                </div>
            </div>
        </div>

        @include('courses.partials.quiz-card')
    @elseif($chapter->order == 5)
        <!-- Custom Layout for Chapter 5 with Accordions for 5.1 -->
        <div class="py-6 select-none" x-data="{
            modules: @js($modules->values()),
            activeTab: '5.1',
            expandedModuleId: null,
            completeUrlTemplate: @js(route('courses.modules.complete', [$course->id, $chapter->id, '__MODULE__'])),
            csrfToken: @js(csrf_token()),

            get tabs() {
                const uniqueTabs = new Set();
                this.modules.forEach(m => {
                    const match = m.title.match(/^(5\.\d+)/);
                    if (match) uniqueTabs.add(match[1]);
                });
                return Array.from(uniqueTabs).sort((a, b) => parseInt(a.split('.')[1]) - parseInt(b.split('.')[1]));
            },
            init() {
                if (!this.tabs.includes(this.activeTab) && this.tabs.length > 0) {
                    this.activeTab = this.tabs[0];
                }
                const initialModule = this.getSingleModule(this.activeTab);
                if (initialModule && initialModule.id) {
                    this.markModuleComplete(initialModule.id);
                }
            },
            getTabModules(tab) {
                return this.modules.filter(m => m.title.startsWith(tab + '.'));
            },
            getSingleModule(tab) {
                let m = this.modules.find(m => m.title === tab || m.title.startsWith(tab + ' '));
                if (!m) m = this.modules.find(m => m.title.startsWith(tab));
                return m || { title: tab, content: '' };
            },
            toggleModule(id) {
                this.expandedModuleId = this.expandedModuleId === id ? null : id;
                if (this.expandedModuleId === id) {
                    let dbId = id;
                    if (isNaN(id)) {
                        const m = this.getSingleModule(id);
                        if (m) dbId = m.id;
                    }
                    this.markModuleComplete(dbId);
                }
            },
            markModuleComplete(moduleId) {
                if (!Number.isInteger(Number(moduleId)) || !this.completeUrlTemplate) return;
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
                        ← Kembali ke Silabus Kursus
                    </a>

                    <div class="flex items-center gap-2">
                        @if(auth()->user()->isInstruktur())
                            <a href="{{ route('modules.create', [$course->id, $chapter->id]) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg text-2xs transition shadow-sm">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                </svg>
                                Tambah Modul Baru
                            </a>
                        @endif

                        <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-[9px] font-bold text-blue-600 border border-blue-100 uppercase tracking-wider">
                            Bab {{ $chapter->order }} dari {{ $chapters->count() }}
                        </span>
                    </div>
                </div>

                <!-- Chapter Header Description Card -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-800 text-sm">
                        {{ str_replace("BAB {$chapter->order}: ", "", $chapter->title) }}
                    </h3>
                    <p class="text-xs text-gray-500 mt-1.5 leading-relaxed">
                        Materi modul pembelajaran tertulis. Gunakan menu navigasi di bawah untuk memilih sub-bab dan membaca detail spesifikasi.
                    </p>
                </div>

                <!-- Main Study Room Content -->
                <div class="space-y-6">
                    
                    <!-- 1. Top horizontal Sub-Chapter Navigation Bar -->
                    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-3">
                        <div class="flex items-center space-x-2 shrink-0">
                            <span class="text-xs font-bold text-slate-700 uppercase tracking-wide">Pilih Topik Sub-Bab:</span>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <template x-for="tab in tabs" :key="tab">
                                <button
                                    @click="activeTab = tab; expandedModuleId = null; const m = getSingleModule(tab); if(m && m.id) markModuleComplete(m.id);"
                                    class="px-4 py-2.5 rounded-lg text-xs font-bold transition text-left"
                                    :class="activeTab === tab ? 'bg-blue-600 text-white shadow-sm' : 'bg-slate-50 text-slate-600 hover:bg-slate-100 hover:text-slate-800'"
                                >
                                    <span x-text="getSingleModule(tab).title"></span>
                                </button>
                            </template>
                        </div>
                    </div>

                    <!-- 2. Content Display Area -->
                    <div>
                        <!-- If Active Tab is 5.1 (Daftar Komponen) -> Show Accordions -->
                        <template x-if="activeTab === '5.1'">
                            <div class="space-y-3">
                                <template x-for="module in getTabModules('5.1')" :key="module.id">
                                    <div class="rounded-xl border border-gray-100 bg-white overflow-hidden shadow-sm">
                                        <button
                                            type="button"
                                            @click="toggleModule(module.id)"
                                            class="w-full flex items-center justify-between gap-4 bg-white px-4 py-3.5 text-left transition hover:bg-slate-50"
                                        >
                                            <span class="text-xs font-bold text-slate-800" x-text="module.title"></span>
                                            <span
                                                class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-full border border-slate-200 bg-white text-sm font-black text-slate-600 transition"
                                                x-text="expandedModuleId === module.id ? '-' : '+'"
                                            ></span>
                                        </button>

                                        <div x-show="expandedModuleId === module.id" class="border-t border-gray-100 bg-white">
                                            <div class="p-4 md:p-6 space-y-4">
                                                <div class="text-xs text-slate-600 leading-relaxed space-y-3.5 prose prose-slate max-w-none prose-sm" x-html="module.content"></div>
                                                
                                                <!-- Action Buttons for Instructor inside Accordion -->
                                                @if(auth()->user()->isInstruktur())
                                                    <div class="flex items-center gap-2 pt-4 border-t border-slate-100">
                                                        <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + module.id + '/edit'" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-2xs font-bold transition shadow-xs">
                                                            Edit Modul Ini
                                                        </a>
                                                        <form :action="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + module.id" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus modul ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-2xs font-bold transition shadow-xs">
                                                                Hapus Modul
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </template>

                        <!-- If Active Tab is not 5.1 -> Show Single Module Card -->
                        <template x-if="activeTab !== '5.1'">
                            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                                <div class="p-6 md:p-8 space-y-6">
                                    <h3 class="text-base font-bold text-slate-800" x-text="getSingleModule(activeTab).title"></h3>
                                    
                                    <div class="text-xs text-slate-600 leading-relaxed space-y-3.5 prose prose-slate max-w-none prose-sm" x-html="getSingleModule(activeTab).content"></div>
                                    
                                    <!-- Action Buttons for Instructor -->
                                    @if(auth()->user()->isInstruktur())
                                        <template x-if="getSingleModule(activeTab).id">
                                            <div class="flex items-center gap-2 pt-4 border-t border-slate-100">
                                                <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + getSingleModule(activeTab).id + '/edit'" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-2xs font-bold transition shadow-xs">
                                                    Edit Modul Ini
                                                </a>
                                                <form :action="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + getSingleModule(activeTab).id" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus modul ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-2xs font-bold transition shadow-xs">
                                                        Hapus Modul
                                                    </button>
                                                </form>
                                            </div>
                                        </template>
                                    @endif
                                </div>
                            </div>
                        </template>
                    </div>

                </div>
            </div>
        </div>

        @include('courses.partials.quiz-card')
    @elseif($chapter->order == 6)
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
                        ← Kembali ke Silabus Kursus
                    </a>

                    <div class="flex items-center gap-2">
                        @if(auth()->user()->isInstruktur())
                            <a href="{{ route('modules.create', [$course->id, $chapter->id]) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg text-2xs transition shadow-sm">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                </svg>
                                Tambah Modul Baru
                            </a>
                        @endif

                        <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-[9px] font-bold text-blue-600 border border-blue-100 uppercase tracking-wider">
                            Bab {{ $chapter->order }} dari {{ $chapters->count() }}
                        </span>
                    </div>
                </div>

                <!-- Chapter Header Description Card -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-800 text-sm">
                        {{ str_replace("BAB {$chapter->order}: ", "", $chapter->title) }}
                    </h3>
                    <p class="text-xs text-gray-500 mt-1.5 leading-relaxed">
                        Halaman ini berisi katalog suku cadang dan komponen Garbarata dalam format PDF. Klik pada masing-masing judul katalog di bawah ini untuk membuka dokumen PDF terkait.
                    </p>
                </div>

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
                                    <span class="font-semibold text-slate-800 text-sm text-left" x-text="module.title"></span>
                                </div>
                                <svg class="w-4 h-4 text-slate-400 transition-transform duration-300 flex-shrink-0" :class="expandedModuleId === module.id ? 'rotate-180' : ''" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <div x-show="expandedModuleId === module.id" class="border-t border-slate-100">
                                <div class="px-5 py-4 bg-slate-50/50 space-y-4">
                                    <div class="text-xs text-slate-600 leading-relaxed max-w-none prose prose-slate prose-sm animate-fade-in" x-html="module.content"></div>
                                    
                                    <!-- Action Buttons for Instructor inside Accordion -->
                                    @if(auth()->user()->isInstruktur())
                                        <div class="flex items-center gap-2 pt-4 border-t border-slate-200">
                                            <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + module.id + '/edit'" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-2xs font-bold transition shadow-xs">
                                                Edit Katalog Ini
                                            </a>
                                            <form :action="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + module.id" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus katalog ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-2xs font-bold transition shadow-xs">
                                                    Hapus Katalog
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
    @elseif($chapter->order == 7)
        <!-- Custom Blueprint/Electrical Diagram Layout for Chapter 7 -->
        <div class="py-6 select-none" x-data="{
            modules: @js($modules->values()),
            activeModuleId: {{ $modules->first() ? $modules->first()->id : 'null' }},
            completeUrlTemplate: @js(route('courses.modules.complete', [$course->id, $chapter->id, '__MODULE__'])),
            csrfToken: @js(csrf_token()),
            zoom: 100,

            init() {
                this.markModuleComplete(this.activeModuleId);
            },

            setActiveModule(moduleId) {
                this.activeModuleId = moduleId;
                this.markModuleComplete(moduleId);
            },

            markModuleComplete(moduleId) {
                if (!moduleId) {
                    return;
                }

                fetch(this.completeUrlTemplate.replace('__MODULE__', moduleId), {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': this.csrfToken,
                        'Accept': 'application/json',
                    },
                });
            },

            getActiveModule() {
                return this.modules.find(m => m.id == this.activeModuleId) || { title: '', content: '', image_path: null };
            },

            zoomIn() {
                if (this.zoom < 200) this.zoom += 25;
            },

            zoomOut() {
                if (this.zoom > 50) this.zoom -= 25;
            },

            resetZoom() {
                this.zoom = 100;
            },

            nextModule() {
                const index = this.modules.findIndex(m => m.id == this.activeModuleId);
                if (index !== -1 && index < this.modules.length - 1) {
                    this.setActiveModule(this.modules[index + 1].id);
                }
            },

            prevModule() {
                const index = this.modules.findIndex(m => m.id == this.activeModuleId);
                if (index > 0) {
                    this.setActiveModule(this.modules[index - 1].id);
                }
            },

            isFirst() {
                return this.modules.findIndex(m => m.id == this.activeModuleId) === 0;
            },

            isLast() {
                return this.modules.findIndex(m => m.id == this.activeModuleId) === this.modules.length - 1;
            }
        }">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <!-- Navigation Back & Title Bar -->
                <div class="flex items-center justify-between">
                    <a href="{{ route('courses.show', $course->id) }}" class="inline-flex items-center text-xs font-bold text-gray-500 hover:text-blue-600 transition">
                        ← Kembali ke Silabus Kursus
                    </a>

                    <div class="flex items-center gap-2">
                        @if(auth()->user()->isInstruktur())
                            <a href="{{ route('modules.create', [$course->id, $chapter->id]) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg text-2xs transition shadow-sm">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                </svg>
                                Tambah Modul Baru
                            </a>
                        @endif

                        <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-[9px] font-bold text-blue-600 border border-blue-100 uppercase tracking-wider">
                            Bab {{ $chapter->order }} dari {{ $chapters->count() }}
                        </span>
                    </div>
                </div>

                <!-- Chapter Header Description Card -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <div class="flex items-center space-x-3 border-b border-gray-100 pb-3 mb-3">
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-blue-200 bg-white text-xs font-bold text-blue-600 shadow-sm">07</span>
                        <h3 class="font-extrabold text-sm text-slate-800 uppercase tracking-wider">
                            {{ str_replace("BAB {$chapter->order}: ", "", $chapter->title) }}
                        </h3>
                    </div>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Halaman ini merupakan penampil lampiran gambar elektrikal (wiring diagram). Gunakan menu navigasi di bawah untuk memilih lembar gambar, dan gunakan kontrol zoom untuk memperbesar gambar agar diagram terbaca lebih jelas.
                    </p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                    <!-- Left Sidebar - List of Drawings -->
                    <div class="lg:col-span-1 bg-white p-4 rounded-2xl border border-gray-100 shadow-sm flex flex-col gap-3">
                        <span class="text-2xs font-extrabold text-slate-400 uppercase tracking-wide px-1">Daftar Lembar Gambar</span>
                        <div class="flex flex-col gap-1 max-h-[500px] overflow-y-auto pr-1">
                            <template x-for="(module, index) in modules" :key="module.id">
                                <button
                                    @click="setActiveModule(module.id); resetZoom()"
                                    class="w-full px-3 py-2.5 rounded-xl text-xs font-bold transition text-left flex items-start gap-2.5 border"
                                    :class="activeModuleId == module.id ? 'bg-blue-600 text-white border-blue-600 shadow-sm' : 'bg-slate-50 text-slate-600 hover:bg-slate-100 hover:text-slate-800 border-transparent'"
                                >
                                    <span class="flex-shrink-0 w-5 h-5 rounded-full bg-black/10 flex items-center justify-center text-[10px]" :class="activeModuleId == module.id ? 'bg-white/20 text-white' : 'text-slate-500'" x-text="index + 1"></span>
                                    <span class="leading-tight pt-0.5" x-text="module.title"></span>
                                </button>
                            </template>
                        </div>
                    </div>

                    <!-- Right Main Content Area - Blueprint Viewer -->
                    <div class="lg:col-span-3 space-y-4">
                        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm flex flex-col overflow-hidden min-h-[600px]">
                            <!-- Toolbar -->
                            <div class="bg-slate-50 border-b border-gray-150 px-4 py-3 flex flex-wrap items-center justify-between gap-3 text-slate-800">
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-bold text-slate-800" x-text="getActiveModule().title"></span>
                                </div>
                                <div class="flex items-center gap-1 bg-white border border-gray-200 rounded-lg p-0.5">
                                    <button @click="zoomOut()" class="p-1.5 text-slate-500 hover:text-slate-800 transition hover:bg-slate-100 rounded-md cursor-pointer" title="Zoom Out">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15"/>
                                        </svg>
                                    </button>
                                    <span class="text-[10px] font-mono px-2 text-slate-600 w-12 text-center" x-text="zoom + '%'"></span>
                                    <button @click="zoomIn()" class="p-1.5 text-slate-500 hover:text-slate-800 transition hover:bg-slate-100 rounded-md cursor-pointer" title="Zoom In">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                        </svg>
                                    </button>
                                    <button @click="resetZoom()" class="p-1.5 text-slate-500 hover:text-slate-800 transition hover:bg-slate-100 rounded-md border-l border-gray-200 cursor-pointer" title="Reset Zoom">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 9V4.5M9 9H4.5M9 9L3 3m12 9V4.5m0 4.5H19.5M15 9l6-6M9 15v4.5M9 15H4.5M9 15l-6 6m12-6v4.5m0-4.5H19.5m-4.5 0l6 6"/>
                                        </svg>
                                    </button>
                                </div>
                                <div>
                                    <a :href="'/' + getActiveModule().image_path" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white hover:bg-slate-50 transition text-slate-600 hover:text-slate-800 font-bold rounded-lg text-[10px] border border-gray-200 shadow-2xs">
                                        Buka Gambar Penuh
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>

                            <!-- Image Container -->
                            <div class="flex-grow bg-slate-50/50 p-4 flex items-center justify-center overflow-auto relative select-none border-b border-gray-150" style="height: 550px;">
                                <template x-if="getActiveModule().image_path">
                                    <div class="transition-all duration-200 ease-out origin-center" :style="'width: ' + zoom + '%; max-width: none;'">
                                        <img :src="'/' + getActiveModule().image_path" class="w-full h-auto object-contain rounded shadow-md border border-gray-200 bg-white" :alt="getActiveModule().title" draggable="false">
                                    </div>
                                </template>
                                <template x-if="!getActiveModule().image_path">
                                    <div class="text-center text-slate-500">
                                        <svg class="w-12 h-12 mx-auto mb-2 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375 3.75 0 11-.75 0 .375 3.75 0 01.75 0z"/>
                                        </svg>
                                        <span class="text-xs">Gambar tidak ditemukan</span>
                                    </div>
                                </template>
                            </div>

                            <!-- Description/Content (if any) -->
                            <div class="bg-white p-4" x-show="getActiveModule().content">
                                <div class="text-slate-600 text-xs leading-relaxed max-w-none prose prose-slate prose-sm" x-html="getActiveModule().content"></div>
                            </div>

                            @if(auth()->user()->isInstruktur())
                                <template x-if="activeModuleId">
                                    <div class="bg-slate-50 border-t border-gray-100 p-4 flex gap-2 rounded-b-2xl">
                                        <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + activeModuleId + '/edit'" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-2xs font-bold transition shadow-xs">
                                            Edit Lembar Gambar
                                        </a>
                                        <form :action="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + activeModuleId" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus lembar gambar ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-2xs font-bold transition shadow-xs">
                                                Hapus Lembar Gambar
                                            </button>
                                        </form>
                                    </div>
                                </template>
                            @endif
                        </div>

                        <!-- Footer Navigation -->
                        <div class="bg-white rounded-2xl border border-gray-100 p-4 shadow-sm flex items-center justify-between">
                            <button
                                @click="prevModule(); resetZoom()"
                                :disabled="isFirst()"
                                class="inline-flex items-center justify-center rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-2xs font-bold text-slate-600 transition hover:bg-slate-50 disabled:opacity-50 disabled:cursor-not-allowed shadow-2xs"
                            >
                                ← Sebelumnya
                            </button>

                            <button
                                @click="nextModule(); resetZoom()"
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
    @else
        <!-- Standard Layout for other chapters -->
        <div class="py-6 select-none" x-data="studyPage(@js($modules->values()), @js(route('courses.modules.complete', [$course->id, $chapter->id, '__MODULE__'])))">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

                <!-- Navigation Back & Title Bar -->
                <div class="flex items-center justify-between">
                    <a href="{{ route('courses.show', $course->id) }}" class="inline-flex items-center text-xs font-bold text-gray-500 hover:text-blue-600 transition">
                        ← Kembali ke Silabus Kursus
                    </a>

                    <div class="flex items-center gap-2">
                        @if(auth()->user()->isInstruktur())
                            <a href="{{ route('modules.create', [$course->id, $chapter->id]) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg text-2xs transition shadow-sm">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                </svg>
                                Tambah Modul Baru
                            </a>
                        @endif

                        <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-[9px] font-bold text-blue-600 border border-blue-100 uppercase tracking-wider">
                            Bab {{ $chapter->order }} dari {{ $chapters->count() }}
                        </span>
                    </div>
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
                                    @click="setActiveModule(module.id)"
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
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between min-h-[250px] w-full">
                        
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
                                <div class="text-xs text-slate-600 leading-relaxed space-y-3.5 prose prose-slate max-w-none prose-sm" x-html="renderModuleContent(getActiveModule().content)">
                                    Memuat isi modul pembelajaran...
                                </div>

                                @if(auth()->user()->isInstruktur())
                                    <template x-if="activeModuleId">
                                        <div class="flex items-center gap-2 pt-4 border-t border-slate-100">
                                            <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + activeModuleId + '/edit'" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-2xs font-bold transition shadow-xs">
                                                Edit Modul Ini
                                            </a>
                                            <form :action="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + activeModuleId" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus modul ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-2xs font-bold transition shadow-xs">
                                                    Hapus Modul
                                                </button>
                                            </form>
                                        </div>
                                    </template>
                                @endif
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

        @include('courses.partials.quiz-card')
    @endif
</x-app-layout>
