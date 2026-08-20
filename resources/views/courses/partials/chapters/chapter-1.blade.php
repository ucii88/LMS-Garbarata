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
                        title: '{{ __('Deskripsi Komponen Mekanikal') }}',
                        button_title: '{{ __('Pengantar') }}',
                        content: `<p class='mt-2'>{{ app()->getLocale() === 'en'
                                    ? 'Garbarata is an electromechanical passenger boarding bridge that connects the airport terminal building and an aircraft, enabling passengers to move between them. It protects passengers from rain, noise, dust, wind, and other conditions that may cause injury or disrupt airport operations.'
                                    : __('Garbarata merupakan sebuah jembatan elektromekanik yang menghubungkan bangunan Bandara dengan pesawat yang berfungsi sebagai media para penumpang untuk berpindah dari Pesawat menuju Bandara atau sebaliknya. Dengan menggunakan Garbarata, penumpang dapat terlindungi dari hujan, suara bising, angin debu dan berbagai macam hal lainnya yang dapat menciderai penumpang atau hal yang dapat mengganggu operasional Bandara.') }}</p>
                                    <p class='mt-4'>{{ app()->getLocale() === 'en' ? 'The main components of the Garbarata consist of:' : __('Komponen utama Garbarata terdiri dari:') }}</p>
                                    <ul class='mt-2'>
                                        <li>{{ app()->getLocale() === 'en' ? '- Rotunda' : __('- Rotunda') }}</li>
                                        <li>{{ app()->getLocale() === 'en' ? '- Telescopic Tunnel' : __('- Telescopic Tunnel') }}</li>
                                        <li>{{ app()->getLocale() === 'en' ? '- Drive Column and Wheel Boogie' : __('- Drive Column dan Wheel Boogie') }}</li>
                                        <li>{{ app()->getLocale() === 'en' ? '- Cabin and Control Unit' : __('- Cabin dan Control Unit') }}</li>
                                        <li>{{ app()->getLocale() === 'en' ? '- Service Stair' : __('- Service Stair') }}</li>
                                    </ul>
                                    <p class='mt-4'>{{ app()->getLocale() === 'en'
                                    ? 'Garbarata uses an electromechanical system controlled from a console in the cabin. This control system integrates all safety equipment and electronic controls, using a Programmable Logic Controller (PLC).'
                                    : __('Garbarata menggunakan sistem elektromekanik yang dikendalikan melalui sebuah control console di cabin. Sistem kendali ini mengintegrasikan seluruh peralatan keselamatan dan sistem kendali elektronik. Sistem kendali elektronik menggunakan unit kendali yang disebut Programmable Logic Controller atau PLC.') }}</p>`,
                        image_path: null,
                    },
                    ...this.modules
                        .filter((module, index, self) => module.title.startsWith('1.') && self.findIndex(m => m.title === module.title) === index)
                        .map((module) => ({
                            id: module.id,
                            title: module.title,
                            button_title: module.title,
                            content: module.content,
                            image_path: module.image_path,
                            diagrams: module.diagrams || (module.diagram ? [module.diagram] : []),
                            diagram: module.diagram,
                        })),
                ];

                this.elecItems = [
                    {
                        id: 'intro_elektrikal',
                        title: '{{ __('Deskripsi Komponen Elektrikal dan Sistem Kontrol') }}',
                        button_title: '{{ __('Pengantar') }}',
                        content: `<p class='mt-2'>
                                    {{ app()->getLocale() === 'en'
                                        ? 'This section explains the operation of the Garbarata electrical system. Detailed schematics are available in the As-Built drawings. Electrical power is distributed from the airport building through the Main Power Panel, Sub-Distribution Power Panel, and Console Desk to operate actuators, sensors, and other electrical components. The main controls are on the Console Desk, using the Control Face Plate and Touchscreen as the operator interface. Operators can also monitor component conditions through the Console Desk display.'
                                        : __('Bagian ini menjelaskan proses operasi system elektrikal Garbarata. Gambar skema detil terdapat pada gambar As-Built. Tenaga listrik didistribusikan dari bangunan bandara melalui Main Power Panel, Sub-Distribution Power Panel dan Console Desk. Dari komponen elektrik tersebut, energy listrik digunakan untuk menaktifkan actuator, sensor dan beberapa komponen elektrik pada Garbarata. Kontrol utama berada pada Console Desk yang menggunakan Control Face Plate dan Touchscreen sebagai interface operator. Operator juga dapat memeriksa kondisi komponen Garbarata jika terjadi kegagalan melalui monitor pada Console Desk.') }}
                                </p>`,
                        image_path: null,
                        diagrams: [],
                        diagram: null,
                    },
                    ...this.modules
                        .filter((module, index, self) => module.title.startsWith('2.') && self.findIndex(m => m.title === module.title) === index)
                        .map((module) => ({
                            id: module.id,
                            title: module.title,
                            button_title: module.title,
                            content: module.content,
                            image_path: module.image_path,
                            diagrams: module.diagrams || (module.diagram ? [module.diagram] : []),
                            diagram: module.diagram,
                        })),
                ];

                this.$nextTick(() => {
                    const observerOptions = {
                        root: null,
                        rootMargin: '-20% 0px -50% 0px',
                        threshold: 0
                    };

                    const observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                const id = entry.target.dataset.moduleId;
                                const type = entry.target.dataset.type;
                                if (id) {
                                    if (type === 'mech') {
                                        this.activeMechId = isNaN(id) ? id : Number(id);
                                    } else if (type === 'elec') {
                                        this.activeElecId = isNaN(id) ? id : Number(id);
                                    }
                                    this.markModuleComplete(id);
                                }
                            }
                        });
                    }, observerOptions);

                
                    this.mechItems.forEach(item => {
                        const el = document.getElementById('mech-module-' + item.id);
                        if (el) observer.observe(el);
                    });

                    this.elecItems.forEach(item => {
                        const el = document.getElementById('elec-module-' + item.id);
                        if (el) observer.observe(el);
                    });
                });
            },

            setMechModule(moduleId) {
                this.activeMechId = moduleId;
                this.markModuleComplete(moduleId);
                this.scrollToModule('mech-module-' + moduleId);
            },

            setElecModule(moduleId) {
                this.activeElecId = moduleId;
                this.markModuleComplete(moduleId);
                this.scrollToModule('elec-module-' + moduleId);
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

            scrollToModule(elementId) {
                this.$nextTick(() => {
                    const el = document.getElementById(elementId);
                    if (el) {

                        const y = el.getBoundingClientRect().top + window.pageYOffset - 100;
                        window.scrollTo({ top: y, behavior: 'smooth' });
                    }
                });
            }
        };
    };
</script>

<div class="py-6 select-none" x-data="chapterOneStudy(@js($modules->unique('title')->values()))">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">
        <!-- Navigation Back & Title Bar -->
        <div class="flex items-center justify-between">
            <a href="{{ route('courses.show', $course->id) }}" class="inline-flex items-center text-sm font-bold text-gray-500 hover:text-blue-600 transition">
                &larr; {{ __('Kembali ke Silabus Kursus') }}
            </a>

            <div class="flex items-center gap-2">
                @if(auth()->user()->isInstruktur())
                    <button type="button" @click="window.dispatchEvent(new CustomEvent('open-upload-diagram-modal'))" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg text-xs transition shadow-sm cursor-pointer">
                        <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span>{{ __('Upload Diagram Interaktif') }}</span>
                    </button>

                    <a href="{{ route('modules.create', [$course->id, $chapter->id]) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg text-xs transition shadow-sm">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                        </svg>
                        {{ __('Tambah Modul Baru') }}
                    </a>
                @endif

                <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-[9px] font-bold text-blue-600 border border-blue-100 uppercase tracking-wider">
                    {{ __('Bab') }} {{ $chapter->order }} {{ __('dari') }} {{ $chapters->count() }}
                </span>
            </div>
        </div>

        <!-- ================= BAGIAN 1: KOMPONEN MEKANIKAL ================= -->
        <section class="space-y-6">
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-6">
            <div class="flex items-center space-x-3 border-b border-gray-100 pb-3">
                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-blue-200 bg-white text-[10px] font-black text-blue-600">01</span>
                <h2 class="text-base font-extrabold text-slate-800 uppercase tracking-wider">{{ __('Deskripsi Komponen Mekanikal') }}</h2>
            </div>

            <!-- Sub-Chapter Selector for Mechanical -->
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-3">
                <div class="flex items-center space-x-2 shrink-0">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wide">{{ __('Pilih Topik Mekanikal:') }}</span>
                </div>
                <div class="flex flex-wrap gap-2">
                    <template x-for="item in mechItems" :key="item.id">
                        <button
                            @click="setMechModule(item.id)"
                            class="px-4 py-2.5 rounded-lg text-sm font-bold transition text-left"
                            :class="activeMechId === item.id ? 'bg-blue-600 text-white shadow-sm' : 'bg-slate-50 text-slate-600 hover:bg-slate-100 hover:text-slate-800 border border-slate-200'"
                        >
                            <span x-text="item.button_title"></span>
                        </button>
                    </template>
                </div>
            </div>

            <p class="text-[10px] font-semibold text-slate-400">
                {{ __('Klik judul topik untuk membuka materi yang lebih lengkap.') }}
            </p>

            @include('courses.partials.interactive-diagram-section')

            </div>

              <!-- Mechanical Reader Card -->
              <div id="chapter1-reader" x-ref="mechReader" class="bg-white rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between min-h-[320px] w-full">
                  <div class="p-4 md:p-6 space-y-8">
                      <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                          <span class="inline-flex h-8 items-center rounded-full border border-blue-200 bg-white px-3 text-[9px] font-bold text-blue-600 uppercase tracking-wider">
                              {{ __('Modul Mekanikal') }}
                          </span>
                      </div>

                      <div class="space-y-12">
                          <template x-for="item in mechItems" :key="item.id">
                              <div :id="'mech-module-' + item.id" :data-module-id="item.id" data-type="mech" class="space-y-4 pt-4 first:pt-0" :class="item.id !== 'intro_mekanikal' ? 'border-t border-gray-100' : ''">
                                  <h2 class="text-lg font-bold text-slate-800 leading-snug" x-text="item.title"></h2>

                                  {{-- TTS Button Chapter 1 Mekanikal --}}
                                  <div class="tts-controls-group">
                                      <button
                                          type="button"
                                          class="tts-nav-btn"
                                          onclick="window.LmsTTS.prevParagraph()"
                                          title="{{ app()->getLocale() === 'en' ? 'Previous Paragraph' : 'Paragraf Sebelumnya' }}"
                                      >
                                          <svg class="w-3.5 h-3.5 text-slate-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                      </button>
                                      <button
                                          class="tts-btn tts-btn-idle"
                                          :data-tts-id="'mech_' + item.id"
                                          @click="window.ttsToggle('mech_' + item.id, item.content, 'mech-tts-content-' + item.id)"
                                          title="{{ app()->getLocale() === 'en' ? 'Listen to Sub-chapter' : 'Dengarkan Suara Subab' }}"
                                      >
                                          <span class="tts-icon">
                                              <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
                                          </span>
                                          <span class="tts-label">{{ app()->getLocale() === 'en' ? 'Listen' : 'Dengarkan' }}</span>
                                      </button>
                                      <button
                                          type="button"
                                          class="tts-nav-btn"
                                          onclick="window.LmsTTS.nextParagraph()"
                                          title="{{ app()->getLocale() === 'en' ? 'Next Paragraph' : 'Paragraf Selanjutnya' }}"
                                      >
                                          <svg class="w-3.5 h-3.5 text-slate-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                      </button>
                                      <button
                                          type="button"
                                          class="tts-speed-btn"
                                          onclick="window.LmsTTS.cycleRate()"
                                          title="{{ app()->getLocale() === 'en' ? 'Change playback speed' : 'Klik untuk mengubah kecepatan suara' }}"
                                      >
                                          <svg class="w-3.5 h-3.5 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                          <span class="tts-speed-val">1x</span>
                                      </button>
                                  </div>

                                  <template x-if="item.image_path">
                                      <div class="rounded-xl border border-gray-200 bg-gray-50 p-2 shadow-xs my-3 mx-auto"
                                           :class="item.title.startsWith('1.1') || item.title.startsWith('1.4') || item.title.startsWith('1.5') ? 'max-w-4xl' : 'max-w-xl'">
                                          <img :src="'/' + item.image_path" class="w-full object-contain rounded-lg select-none"
                                               :class="item.title.startsWith('1.1') || item.title.startsWith('1.4') || item.title.startsWith('1.5') ? 'max-h-[600px]' : 'max-h-64'"
                                               :alt="item.title">
                                      </div>
                                  </template>

                                  <div :id="'mech-tts-content-' + item.id" class="text-base text-slate-600 leading-relaxed space-y-3.5 prose prose-slate max-w-none prose-sm" x-html="item.content"></div>

                                  <!-- Interactive Module Diagram -->
                                  <template x-if="item.id !== 'intro_mekanikal' && ((item.diagrams && item.diagrams.length > 0) || item.diagram)">
                                      <div class="my-6 p-4 rounded-2xl border border-slate-100 bg-slate-50/50 shadow-2xs"
                                          x-data="moduleDiagramData(
                                              (item.diagrams && item.diagrams.length > 0) ? item.diagrams : (item.diagram ? [item.diagram] : []),
                                              (item.diagrams && item.diagrams.length > 0) ? (item.diagrams[0].hotspots || []) : (item.diagram ? item.diagram.hotspots : []),
                                              {{ $course->id }},
                                              {{ $chapter->id }},
                                              item.id,
                                              @js(route('courses.modules.diagram.store', [$course->id, $chapter->id, '__MODULE__'])).replace('__MODULE__', item.id),
                                              @js(route('courses.modules.diagram.destroy', [$course->id, $chapter->id, '__MODULE__'])).replace('__MODULE__', item.id),
                                              @js(route('courses.modules.hotspots.store', [$course->id, $chapter->id, '__MODULE__'])).replace('__MODULE__', item.id),
                                              @js(route('courses.modules.hotspots.update', [$course->id, $chapter->id, '__MODULE__'])).replace('__MODULE__', item.id),
                                              @js(csrf_token())
                                          )"
                                      >
                                          @include('courses.partials.module-diagram-section')
                                      </div>
                                  </template>

                                  @if(auth()->user()->isInstruktur())
                                      <template x-if="item.id !== 'intro_mekanikal'">
                                          <div class="flex items-center gap-2 pt-4 border-t border-slate-100 mt-4">
                                              <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + item.id + '/edit'" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-xs font-bold transition shadow-xs">
                                                  {{ __('Edit Modul') }}
                                              </a>
                                              <form :action="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + item.id" method="POST" data-confirm="{{ __('Apakah Anda yakin ingin menghapus modul ini?') }}">
                                                  @csrf
                                                  @method('DELETE')
                                                  <button type="submit" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-xs font-bold transition shadow-xs">
                                                      {{ __('Hapus') }}
                                                  </button>
                                              </form>
                                          </div>
                                      </template>
                                  @endif
                              </div>
                          </template>
                      </div>
                  </div>
              </div>
        </section>

          <!-- ================= BAGIAN 2: KOMPONEN ELEKTRIKAL & SISTEM KONTROL ================= -->
          <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-6">
              <div class="flex items-center space-x-3 border-b border-gray-100 pb-3">
                  <span class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-emerald-200 bg-white text-[10px] font-black text-emerald-600">02</span>
                  <h2 class="text-base font-extrabold text-slate-800 uppercase tracking-wider">{{ __('Deskripsi Komponen Elektrikal dan Sistem Kontrol') }}</h2>
              </div>

              <!-- Sub-Chapter Selector for Electrical -->
              <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-3">
                  <div class="flex items-center space-x-2 shrink-0">
                      <span class="text-xs font-bold text-slate-500 uppercase tracking-wide">{{ __('Pilih Topik Elektrikal:') }}</span>
                  </div>
                  <div class="flex flex-wrap gap-2">
                      <template x-for="item in elecItems" :key="item.id">
                          <button
                              @click="setElecModule(item.id)"
                              class="px-4 py-2.5 rounded-lg text-sm font-bold transition text-left"
                              :class="activeElecId === item.id ? 'bg-emerald-600 text-white shadow-sm' : 'bg-slate-50 text-slate-600 hover:bg-slate-100 hover:text-slate-800 border border-slate-200'"
                          >
                              <span x-text="item.button_title"></span>
                          </button>
                      </template>
                  </div>
              </div>

              <!-- Electrical Reader Card (Kotak Teks Baru) -->
              <div class="bg-white rounded-2xl border border-slate-100 flex flex-col justify-between min-h-[320px] w-full">
                  <div class="p-4 md:p-6 space-y-8">
                      <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                          <span class="inline-flex h-8 items-center rounded-full border border-emerald-200 bg-white px-3 text-[9px] font-bold text-emerald-600 uppercase tracking-wider">
                              {{ __('Modul Elektrikal & Kontrol') }}
                          </span>
                      </div>

                      <div class="space-y-12">
                          <template x-for="item in elecItems" :key="item.id">
                              <div :id="'elec-module-' + item.id" :data-module-id="item.id" data-type="elec" class="space-y-4 pt-4 first:pt-0" :class="item.id !== 'intro_elektrikal' ? 'border-t border-gray-100' : ''">
                                  <h2 class="text-lg font-bold text-slate-800 leading-snug" x-text="item.title"></h2>

                                  {{-- TTS Button Chapter 1 Elektrikal --}}
                                  <div class="tts-controls-group">
                                      <button
                                          type="button"
                                          class="tts-nav-btn"
                                          onclick="window.LmsTTS.prevParagraph()"
                                          title="{{ app()->getLocale() === 'en' ? 'Previous Paragraph' : 'Paragraf Sebelumnya' }}"
                                      >
                                          <svg class="w-3.5 h-3.5 text-slate-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                      </button>
                                      <button
                                          class="tts-btn tts-btn-idle"
                                          :data-tts-id="'elec_' + item.id"
                                          @click="window.ttsToggle('elec_' + item.id, item.content, 'elec-tts-content-' + item.id)"
                                          title="{{ app()->getLocale() === 'en' ? 'Listen to Sub-chapter' : 'Dengarkan Suara Subab' }}"
                                      >
                                          <span class="tts-icon">
                                              <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
                                          </span>
                                          <span class="tts-label">{{ app()->getLocale() === 'en' ? 'Listen' : 'Dengarkan' }}</span>
                                      </button>
                                      <button
                                          type="button"
                                          class="tts-nav-btn"
                                          onclick="window.LmsTTS.nextParagraph()"
                                          title="{{ app()->getLocale() === 'en' ? 'Next Paragraph' : 'Paragraf Selanjutnya' }}"
                                      >
                                          <svg class="w-3.5 h-3.5 text-slate-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                      </button>
                                      <button
                                          type="button"
                                          class="tts-speed-btn"
                                          onclick="window.LmsTTS.cycleRate()"
                                          title="{{ app()->getLocale() === 'en' ? 'Change playback speed' : 'Klik untuk mengubah kecepatan suara' }}"
                                      >
                                          <svg class="w-3.5 h-3.5 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                          <span class="tts-speed-val">1x</span>
                                      </button>
                                  </div>

                                  <template x-if="item.image_path">
                                      <div class="rounded-xl border border-gray-200 bg-gray-50 p-2 shadow-xs my-3 max-w-xl mx-auto">
                                          <img :src="'/' + item.image_path" class="w-full max-h-64 object-contain rounded-lg select-none" :alt="item.title">
                                      </div>
                                  </template>

                                  <div :id="'elec-tts-content-' + item.id" class="text-base text-slate-600 leading-relaxed space-y-3.5 prose prose-slate max-w-none prose-sm" x-html="item.content"></div>

                                  <!-- Interactive Module Diagram -->
                                  <template x-if="item.id !== 'intro_elektrikal' && ((item.diagrams && item.diagrams.length > 0) || item.diagram)">
                                      <div class="my-6 p-4 rounded-2xl border border-slate-100 bg-slate-50/50 shadow-2xs"
                                          x-data="moduleDiagramData(
                                              (item.diagrams && item.diagrams.length > 0) ? item.diagrams : (item.diagram ? [item.diagram] : []),
                                              (item.diagrams && item.diagrams.length > 0) ? (item.diagrams[0].hotspots || []) : (item.diagram ? item.diagram.hotspots : []),
                                              {{ $course->id }},
                                              {{ $chapter->id }},
                                              item.id,
                                              @js(route('courses.modules.diagram.store', [$course->id, $chapter->id, '__MODULE__'])).replace('__MODULE__', item.id),
                                              @js(route('courses.modules.diagram.destroy', [$course->id, $chapter->id, '__MODULE__'])).replace('__MODULE__', item.id),
                                              @js(route('courses.modules.hotspots.store', [$course->id, $chapter->id, '__MODULE__'])).replace('__MODULE__', item.id),
                                              @js(route('courses.modules.hotspots.update', [$course->id, $chapter->id, '__MODULE__'])).replace('__MODULE__', item.id),
                                              @js(csrf_token())
                                          )"
                                      >
                                          @include('courses.partials.module-diagram-section')
                                      </div>
                                  </template>

                                  @if(auth()->user()->isInstruktur())
                                      <template x-if="item.id !== 'intro_elektrikal'">
                                          <div class="flex items-center gap-2 pt-4 border-t border-slate-100 mt-4">
                                              <a :href="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + item.id + '/edit'" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-xs font-bold transition shadow-xs">
                                                  {{ __('Edit Modul') }}
                                              </a>
                                              <form :action="'/courses/{{ $course->id }}/chapters/{{ $chapter->id }}/modules/' + item.id" method="POST" data-confirm="{{ __('Apakah Anda yakin ingin menghapus modul ini?') }}">
                                                  @csrf
                                                  @method('DELETE')
                                                  <button type="submit" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-xs font-bold transition shadow-xs">
                                                      {{ __('Hapus') }}
                                                  </button>
                                              </form>
                                          </div>
                                      </template>
                                  @endif
                              </div>
                          </template>
                      </div>
                  </div>
              </div>
          </div>

      </div>
  </div>

@include('courses.partials.quiz-card')

{{-- Auto-complete scroll script ONLY for Chapter 1 --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modules = @js($modules->pluck('id')->toArray());
        const completeUrlTemplate = @js(route('courses.modules.complete', [$course->id, $chapter->id, '__MODULE__']));
        const csrfToken = @js(csrf_token());

        let completed = new Set();
        let hasQuiz = @js($chapterQuiz ? true : false);
        let isQuizPassed = @js($chapterQuizAttempt?->is_passed ? true : false);

        function markModuleComplete(moduleId) {
            if (!moduleId || isNaN(moduleId)) return;
            const idNum = Number(moduleId);
            if (completed.has(idNum)) return;
            completed.add(idNum);

            fetch(completeUrlTemplate.replace('__MODULE__', idNum), {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
            });
        }

        function unlockNextChapter() {
            if (!hasQuiz || isQuizPassed) {
                const descEl = document.getElementById('next-chapter-desc');
                const actionEl = document.getElementById('next-chapter-action');
                if (descEl) {
                    descEl.innerText = @js(__('Hebat! Anda telah menyelesaikan seluruh materi dan quiz pada bab ini. Silakan lanjut ke bab berikutnya.'));
                }
                if (actionEl) {
                    @if($nextChapter)
                    actionEl.innerHTML = `
                        <a href="{{ route('courses.chapters.show', [$course->id, $nextChapter->id]) }}"
                           class="inline-flex items-center justify-center gap-2 px-5 py-3 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-md hover:shadow-lg transition-all duration-150 whitespace-nowrap">
                            {{ __('Lanjut ke Bab') }} {{ $nextChapter->order }} &rarr;
                        </a>
                    `;
                    @endif
                }
            }
        }

        function handleBottomReached() {
            // Safeguard: only trigger if user has actually scrolled down from top (scrollY > 50)
            // to prevent the IntersectionObserver initial run from auto-completing on page load.
            if (window.scrollY < 50) return;

            modules.forEach(id => {
                markModuleComplete(id);
            });
            unlockNextChapter();
        }

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    handleBottomReached();
                }
            });
        }, {
            root: null,
            threshold: 0.1
        });

        const target = document.getElementById('next-chapter-desc');
        if (target) {
            observer.observe(target);
        }

        window.addEventListener('scroll', function() {
            if ((window.innerHeight + window.scrollY) >= document.documentElement.scrollHeight - 150) {
                handleBottomReached();
            }
        });
    });
</script>
