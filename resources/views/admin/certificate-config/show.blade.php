@section('topbar_title', __('Atur Sertifikat'))

<x-app-layout>
    <div class="space-y-6">
        @if (session('success'))
            <div class="flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-3.5 text-sm text-emerald-700">
                <svg class="w-5 h-5 shrink-0 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="flex items-center gap-3 rounded-xl border border-rose-200 bg-rose-50 px-5 py-3.5 text-sm text-rose-700">
                <svg class="w-5 h-5 shrink-0 text-rose-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('error') }}
            </div>
        @endif

        {{-- Header --}}
        <section class="relative rounded-2xl overflow-hidden bg-gradient-to-r from-slate-900 via-slate-800 to-amber-950 p-8 shadow-sm border border-slate-800">
            <div class="absolute inset-0 opacity-15 bg-[radial-gradient(#f59e0b_1px,transparent_1px)] [background-size:16px_16px] pointer-events-none"></div>
            <div class="relative z-10 flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
                <div class="space-y-2">
                    <span class="inline-flex items-center rounded-full bg-amber-500/10 px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-amber-400 border border-amber-500/20">{{ __('Konfigurasi Sertifikat') }}</span>
                    <h1 class="text-2xl font-extrabold tracking-tight text-white">{{ $course->title }}</h1>
                    <p class="text-sm text-slate-300">{{ __('Atur template, tanda tangan, dan branding sertifikat untuk kursus ini.') }}</p>
                </div>
                <div class="flex gap-2 shrink-0">
                    <a href="{{ route('admin.certificate-config.preview', $course) }}" target="_blank"
                       class="inline-flex items-center gap-2 rounded-xl border border-slate-600 bg-white/10 hover:bg-white/20 text-white px-4 py-2.5 text-sm font-bold transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        {{ __('Preview PDF') }}
                    </a>
                    <a href="{{ route('admin.certificate-config.index') }}"
                       class="inline-flex items-center gap-2 rounded-xl border border-slate-600 bg-white/10 hover:bg-white/20 text-white px-4 py-2.5 text-sm font-bold transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        {{ __('Kembali') }}
                    </a>
                </div>
            </div>
        </section>

        <form action="{{ route('admin.certificate-config.update', $course) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- 1: Template --}}
            <section class="rounded-2xl border border-[#f0f0f0] bg-white p-6 shadow-sm">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-8 h-8 rounded-xl bg-amber-100 flex items-center justify-center text-amber-600 font-black text-sm shrink-0">1</div>
                    <div>
                        <h2 class="text-base font-bold text-slate-800">{{ __('Pilih Template Sertifikat') }}</h2>
                        <p class="text-xs text-slate-500 mt-0.5">{{ __('Pilih desain sertifikat yang digunakan untuk kursus ini.') }}</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    @foreach ($templates as $key => $template)
                        <label class="cursor-pointer">
                            <input type="radio" name="template_preset" value="{{ $key }}"
                                   {{ ($config->template_preset ?? 'current_style') === $key ? 'checked' : '' }}
                                   class="sr-only peer" required>
                            <div class="relative rounded-xl border-2 border-slate-200 peer-checked:border-amber-500 peer-checked:bg-amber-50 hover:border-amber-300 transition-all p-4 h-full">
                                <div class="w-full rounded-lg mb-3 overflow-hidden" style="height:80px;">
                                    @if(in_array($key, ['garbarata_default', 'current_style']))
                                        <div class="w-full h-full bg-gradient-to-br from-amber-50 to-yellow-100 flex flex-col items-center justify-center gap-1">
                                            <div class="w-10 h-1.5 bg-amber-500 rounded"></div>
                                            <div class="text-[7px] font-extrabold uppercase tracking-widest text-amber-700">{{ __('Sertifikat Kelulusan') }}</div>
                                            <div class="w-14 h-0.5 bg-amber-300 rounded"></div>
                                        </div>
                                    @elseif($key === 'elegant_classic_1')
                                        <div class="w-full h-full bg-[#2d1b00] flex flex-col items-center justify-center gap-1 border border-yellow-600/60">
                                            <div class="text-[7px] font-extrabold text-yellow-400 uppercase tracking-widest">{{ __('Certificate') }}</div>
                                            <div class="w-8 h-0.5 bg-yellow-500 rounded"></div>
                                            <div class="text-[8px] font-serif text-yellow-100">{{ __('of Completion') }}</div>
                                        </div>
                                    @else
                                        <div class="w-full h-full flex">
                                            <div class="w-8 bg-blue-800 flex items-center justify-center shrink-0">
                                                <span class="text-[5px] text-white font-bold rotate-90 whitespace-nowrap">GARBARATA</span>
                                            </div>
                                            <div class="flex-1 bg-white flex flex-col justify-center px-2 gap-0.5">
                                                <div class="text-[6px] text-slate-500 uppercase tracking-widest">{{ __('Certificate') }}</div>
                                                <div class="text-[8px] font-bold text-slate-800">{{ __('of Completion') }}</div>
                                                <div class="w-8 h-0.5 bg-slate-300 rounded"></div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <h3 class="font-bold text-sm text-slate-800">{{ __($template['name']) }}</h3>
                                <p class="text-xs text-slate-500 mt-0.5 leading-snug">{{ __($template['description']) }}</p>
                            </div>
                        </label>
                    @endforeach
                </div>
                @error('template_preset') <p class="mt-2 text-xs text-rose-600 font-semibold">{{ $message }}</p> @enderror
            </section>

            {{-- 2: Instruktur --}}
            <section class="rounded-2xl border border-[#f0f0f0] bg-white p-6 shadow-sm">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-8 h-8 rounded-xl bg-amber-100 flex items-center justify-center text-amber-600 font-black text-sm shrink-0">2</div>
                    <div>
                        <h2 class="text-base font-bold text-slate-800">{{ __('Tanda Tangan Instruktur') }}</h2>
                        <p class="text-xs text-slate-500 mt-0.5">{{ __('Pilih instruktur yang tanda tangannya muncul di sertifikat ini.') }}</p>
                    </div>
                </div>
                <div class="grid gap-5 lg:grid-cols-2">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1.5">{{ __('Instruktur') }}</label>
                        <select name="instructor_id" id="instructor_select"
                                class="block w-full rounded-xl border-slate-200 text-sm shadow-sm focus:border-amber-400 focus:ring-amber-400">
                            <option value="">— {{ __('Tidak ada instruktur') }} —</option>
                            @foreach ($instructors as $instructor)
                                <option value="{{ $instructor->id }}" {{ ($config->instructor_id ?? null) == $instructor->id ? 'selected' : '' }}>
                                    {{ $instructor->name }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-[10px] text-slate-400 mt-1">{{ __('Tanda tangan diambil otomatis dari profil instruktur.') }}</p>
                        @error('instructor_id') <p class="mt-1 text-xs text-rose-600 font-semibold">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1.5">{{ __('Preview Tanda Tangan') }}</label>
                        <div id="instructor-sig-preview"
                             class="rounded-xl border-2 border-dashed border-slate-200 bg-slate-50 p-4 min-h-[80px] flex items-center justify-center text-xs text-slate-400 text-center">
                            @if ($config->instructor_id && $config->instructor)
                                @php $instructorSig = app(\App\Services\SignatureService::class)->getCurrentSignature($config->instructor, 'instructor'); @endphp
                                @if ($instructorSig)
                                    <img src="{{ $instructorSig->signature_url }}" alt="" class="max-h-16 object-contain">
                                @else
                                    {{ __('Instruktur belum upload tanda tangan') }}
                                @endif
                            @else
                                {{ __('Pilih instruktur untuk melihat preview') }}
                            @endif
                        </div>
                    </div>
                </div>
            </section>

            {{-- 3: Kepala Training --}}
            <section class="rounded-2xl border border-[#f0f0f0] bg-white p-6 shadow-sm">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-8 h-8 rounded-xl bg-amber-100 flex items-center justify-center text-amber-600 font-black text-sm shrink-0">3</div>
                    <div>
                        <h2 class="text-base font-bold text-slate-800">{{ __('Tanda Tangan Kepala Training') }}</h2>
                        <p class="text-xs text-slate-500 mt-0.5">{{ __('Tanda tangan global Kepala Training Center untuk semua sertifikat.') }}</p>
                    </div>
                </div>

                @if ($kepalaSignature)
                    <div class="mb-5 flex items-center gap-4 p-4 rounded-xl bg-slate-50 border border-slate-200">
                        <div class="rounded-lg border border-slate-200 bg-white p-2 shrink-0">
                            <img src="{{ $kepalaSignature->signature_url }}" alt="" class="max-h-12 max-w-[130px] object-contain">
                        </div>
                        <div class="text-sm">
                            <p class="font-semibold text-slate-800">{{ __('Tanda tangan tersimpan') }}</p>
                            <p class="text-xs text-slate-400 mt-0.5">{{ $kepalaSignature->created_at->locale(app()->getLocale())->translatedFormat('d F Y') }}</p>
                        </div>
                    </div>
                @else
                    <div class="mb-4 flex items-center gap-3 p-3 rounded-xl bg-amber-50 border border-amber-100">
                        <svg class="w-4 h-4 text-amber-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="text-xs text-amber-700">{{ __('Belum ada tanda tangan kepala training. Gambar di bawah.') }}</p>
                    </div>
                @endif

                <div class="space-y-3">
                    <label class="block text-sm font-bold text-slate-700">{{ $kepalaSignature ? __('Perbarui Tanda Tangan') : __('Gambar Tanda Tangan') }}</label>
                    <p class="text-xs text-slate-400 -mt-1">{{ __('Gambar tanda tangan mengisi area yang cukup besar — tidak perlu terlalu kecil agar terlihat jelas di sertifikat.') }}</p>
                    <div class="rounded-xl border-2 border-slate-200 bg-white overflow-hidden relative">
                        <canvas id="kepala-sig-pad" class="block w-full touch-none cursor-crosshair" style="height:200px;"></canvas>
                        <div class="absolute inset-0 pointer-events-none flex items-center justify-center opacity-0" id="kepala-canvas-hint">
                            <span class="text-slate-200 text-xs font-medium">{{ __('Gambar di sini') }}</span>
                        </div>
                    </div>
                    <div class="flex gap-2 flex-wrap">
                        <button type="button" id="kepala-clear-btn"
                                class="inline-flex items-center gap-1 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 px-3 py-1.5 text-xs font-bold text-slate-600 transition">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                            {{ __('Hapus Canvas') }}
                        </button>
                        <button type="button" id="kepala-save-global-btn"
                                class="inline-flex items-center gap-1 rounded-lg bg-indigo-500 hover:bg-indigo-600 px-3 py-1.5 text-xs font-bold text-white transition shadow-sm">
                            {{ __('Simpan Sebagai Global') }}
                        </button>
                    </div>
                    <div id="kepala-save-result" class="hidden text-xs text-emerald-600 font-semibold">
                        {{ __('Tanda tangan kepala training berhasil disimpan secara global!') }}
                    </div>
                    <input type="hidden" name="kepala_signature_data" id="kepala_signature_data_input">
                    <p class="text-[10px] text-slate-400">{{ __('Atau isi kanvas lalu klik Simpan Konfigurasi untuk menyimpan sekaligus.') }}</p>
                </div>

                <div class="mt-5 grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1.5">{{ __('Nama Kepala Training') }}</label>
                        <input type="text" name="kepala_name"
                               value="{{ old('kepala_name', config('certificate.defaults.kepala_training_name')) }}"
                               maxlength="100"
                               class="block w-full rounded-xl border-slate-200 text-sm shadow-sm focus:border-amber-400 focus:ring-amber-400">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1.5">{{ __('Jabatan / Institusi') }}</label>
                        <input type="text" name="kepala_title"
                               value="{{ old('kepala_title', config('certificate.defaults.kepala_training_title')) }}"
                               maxlength="100"
                               class="block w-full rounded-xl border-slate-200 text-sm shadow-sm focus:border-amber-400 focus:ring-amber-400">
                    </div>
                </div>
            </section>

            {{-- 4: Branding --}}
            <section class="rounded-2xl border border-[#f0f0f0] bg-white p-6 shadow-sm">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-8 h-8 rounded-xl bg-amber-100 flex items-center justify-center text-amber-600 font-black text-sm shrink-0">4</div>
                    <div>
                        <h2 class="text-base font-bold text-slate-800">{{ __('Branding & Warna') }}</h2>
                        <p class="text-xs text-slate-500 mt-0.5">{{ __('Nama organisasi, logo, dan warna utama sertifikat.') }}</p>
                    </div>
                </div>

                <div class="space-y-5">
                    {{-- Org Name --}}
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1.5">{{ __('Nama Organisasi') }} <span class="text-rose-500">*</span></label>
                        <input type="text" name="organization_name"
                               value="{{ old('organization_name', $config->organization_name ?? config('certificate.defaults.organization_name')) }}"
                               maxlength="200" required
                               class="block w-full rounded-xl border-slate-200 text-sm shadow-sm focus:border-amber-400 focus:ring-amber-400">
                        @error('organization_name') <p class="mt-1 text-xs text-rose-600 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    {{-- Logo --}}
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1.5">{{ __('Logo Organisasi') }}</label>
                        @if ($config->logo_path && app(\App\Services\SignatureService::class)->toDataUri($config->logo_path))
                            <div class="mb-2 flex items-center gap-3">
                                <img src="{{ app(\App\Services\SignatureService::class)->toDataUri($config->logo_path) }}" alt="Logo" class="max-h-10 rounded-lg border border-slate-200 bg-white p-1 object-contain">
                                <span class="text-xs text-slate-500">{{ __('Logo saat ini. Unggah file baru untuk mengganti.') }}</span>
                            </div>
                        @endif
                        <div class="flex items-center gap-0">
                            <input type="file" name="logo" id="logo_input" accept="image/png,image/jpeg,image/jpg"
                                   class="sr-only"
                                   onchange="document.getElementById('logo_filename_display').textContent = this.files[0] ? this.files[0].name : '{{ __('Tidak ada file yang dipilih') }}';">
                            <label for="logo_input" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-l-xl border border-r-0 border-slate-300 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold cursor-pointer transition select-none">
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                {{ __('Pilih File') }}
                            </label>
                            <div id="logo_filename_display" class="flex-1 py-2.5 px-4 text-xs text-slate-500 border border-slate-300 rounded-r-xl bg-slate-50 truncate select-none">
                                {{ __('Tidak ada file yang dipilih') }}
                            </div>
                        </div>
                        <p class="text-[10px] text-slate-400 mt-1">{{ __('PNG, JPG — Maks. 5 MB.') }}</p>
                        @error('logo') <p class="mt-1 text-xs text-rose-600 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    {{-- Colors --}}
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1.5">{{ __('Warna Utama') }} <span class="text-rose-500">*</span></label>
                            <div class="flex items-center gap-2">
                                <input type="color" id="primary_color_picker"
                                       value="{{ old('primary_color', $config->primary_color ?? config('certificate.defaults.primary_color')) }}"
                                       class="h-10 w-14 rounded-lg border border-slate-200 cursor-pointer p-0.5 shrink-0">
                                <input type="text" name="primary_color" id="primary_color_text"
                                       value="{{ old('primary_color', $config->primary_color ?? config('certificate.defaults.primary_color')) }}"
                                       maxlength="7" required
                                       class="block flex-1 rounded-xl border-slate-200 text-sm shadow-sm font-mono focus:border-amber-400 focus:ring-amber-400">
                            </div>
                            @error('primary_color') <p class="mt-1 text-xs text-rose-600 font-semibold">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1.5">{{ __('Warna Sekunder') }} <span class="text-rose-500">*</span></label>
                            <div class="flex items-center gap-2">
                                <input type="color" id="secondary_color_picker"
                                       value="{{ old('secondary_color', $config->secondary_color ?? config('certificate.defaults.secondary_color')) }}"
                                       class="h-10 w-14 rounded-lg border border-slate-200 cursor-pointer p-0.5 shrink-0">
                                <input type="text" name="secondary_color" id="secondary_color_text"
                                       value="{{ old('secondary_color', $config->secondary_color ?? config('certificate.defaults.secondary_color')) }}"
                                       maxlength="7" required
                                       class="block flex-1 rounded-xl border-slate-200 text-sm shadow-sm font-mono focus:border-amber-400 focus:ring-amber-400">
                            </div>
                            @error('secondary_color') <p class="mt-1 text-xs text-rose-600 font-semibold">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </section>

            {{-- Save --}}
            <div class="flex items-center justify-between rounded-2xl border border-[#f0f0f0] bg-white p-5 shadow-sm">
                <p class="text-sm text-slate-500">{{ __('Perubahan akan membuat snapshot konfigurasi baru dan berlaku untuk sertifikat yang diterbitkan setelah ini.') }}</p>
                <button type="submit"
                        class="shrink-0 inline-flex items-center gap-2 rounded-xl bg-amber-500 hover:bg-amber-600 px-6 py-2.5 text-sm font-bold text-white transition shadow-sm ml-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    {{ __('Simpan Konfigurasi') }}
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
    <script>
    (function () {
        // ── Color sync ──
        const pc = document.getElementById('primary_color_picker');
        const pt = document.getElementById('primary_color_text');
        const sc = document.getElementById('secondary_color_picker');
        const st = document.getElementById('secondary_color_text');

        if (pc && pt) {
            pc.addEventListener('input', () => pt.value = pc.value);
            pt.addEventListener('input', () => { if (/^#[a-fA-F0-9]{6}$/.test(pt.value)) pc.value = pt.value; });
        }
        if (sc && st) {
            sc.addEventListener('input', () => st.value = sc.value);
            st.addEventListener('input', () => { if (/^#[a-fA-F0-9]{6}$/.test(st.value)) sc.value = st.value; });
        }

        // ── Kepala Training Signature Pad ──
        const kepalaCanvas = document.getElementById('kepala-sig-pad');
        if (kepalaCanvas) {
            const ratio = Math.max(window.devicePixelRatio || 1, 1);
        const existingSignature = @json($kepalaSignature?->signature_url);
        function resizeKepala() {
            const rect = kepalaCanvas.getBoundingClientRect();
            kepalaCanvas.width = rect.width * ratio;
            kepalaCanvas.height = rect.height * ratio;
            kepalaCanvas.getContext('2d').scale(ratio, ratio);
            kepalaPad.clear();
            if (existingSignature) {
                kepalaPad.fromDataURL(existingSignature);
            }
        }
            const kepalaPad = new SignaturePad(kepalaCanvas, {
                backgroundColor: 'rgb(255,255,255)',
                penColor: 'rgb(0,0,0)',
            });
            window.addEventListener('resize', resizeKepala);
            resizeKepala();

            document.getElementById('kepala-clear-btn').addEventListener('click', () => kepalaPad.clear());

            // Saat form submit: embed kanvas ke hidden input jika ada coretan
            document.querySelector('form').addEventListener('submit', function () {
                const hiddenInput = document.getElementById('kepala_signature_data_input');
                if (hiddenInput && !kepalaPad.isEmpty()) {
                    hiddenInput.value = kepalaPad.toDataURL('image/png');
                }
            });

            // Simpan sebagai global via AJAX
            document.getElementById('kepala-save-global-btn').addEventListener('click', async function () {
                if (kepalaPad.isEmpty()) {
                    alert('{{ __("Gambar tanda tangan terlebih dahulu.") }}');
                    return;
                }
                const dataURL = kepalaPad.toDataURL('image/png');
                try {
                    const resp = await fetch('{{ route("admin.kepala-signature.save") }}', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        body: JSON.stringify({ signature_data: dataURL }),
                    });
                    const result = await resp.json();
                    if (result.success) {
                        document.getElementById('kepala-save-result').classList.remove('hidden');
                        document.getElementById('kepala_signature_data_input').value = dataURL;
                    } else {
                        alert(result.message || '{{ __("Gagal menyimpan.") }}');
                    }
                } catch (e) {
                    alert('{{ __("Terjadi kesalahan.") }}');
                }
            });
        }

        // ── Instructor signature preview via AJAX ──
        const instrSelect = document.getElementById('instructor_select');
        const instrPreview = document.getElementById('instructor-sig-preview');
        if (instrSelect && instrPreview) {
            instrSelect.addEventListener('change', async function () {
                const id = this.value;
                if (!id) {
                    instrPreview.innerHTML = '<span class="text-xs text-slate-400">{{ __("Pilih instruktur untuk melihat preview") }}</span>';
                    return;
                }
                instrPreview.innerHTML = '<span class="text-xs text-slate-400 animate-pulse">{{ __("Memuat...") }}</span>';
                try {
                    const resp = await fetch(`/admin/instructor-signature/${id}`, {
                        headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    });
                    const data = await resp.json();
                    if (data.url) {
                        instrPreview.innerHTML = `<img src="${data.url}" alt="{{ __('Tanda Tangan') }}" class="max-h-16 object-contain">`;
                    } else {
                        instrPreview.innerHTML = '<span class="text-xs text-amber-500">{{ __("Instruktur belum upload tanda tangan") }}</span>';
                    }
                } catch (e) {
                    instrPreview.innerHTML = '<span class="text-xs text-slate-400">{{ __("Gagal memuat preview") }}</span>';
                }
            });
        }
    })();
    </script>
    @endpush
</x-app-layout>
