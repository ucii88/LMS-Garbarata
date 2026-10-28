@section('topbar_title', __('Tanda Tangan Digital'))

<x-app-layout>
    <div class="space-y-6">

        {{-- Flash Messages --}}
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

        {{-- Page Header --}}
        <section class="relative rounded-2xl overflow-hidden bg-gradient-to-r from-slate-900 via-slate-800 to-indigo-950 p-8 shadow-sm border border-slate-800">
            <div class="absolute inset-0 opacity-15 bg-[radial-gradient(#4f46e5_1px,transparent_1px)] [background-size:16px_16px] pointer-events-none"></div>
            <div class="relative z-10 flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
                <div class="space-y-2">
                    <span class="inline-flex items-center rounded-full bg-amber-500/10 px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-amber-400 border border-amber-500/20">
                        {{ __('Instruktur') }}
                    </span>
                    <h1 class="text-2xl font-extrabold tracking-tight text-white">{{ __('Tanda Tangan Digital') }}</h1>
                    <p class="text-sm text-slate-300 leading-relaxed">{{ __('Tanda tangan Anda akan tampil di sertifikat kelulusan peserta pada kursus yang Anda ampu.') }}</p>
                </div>
                <a href="{{ route('profile.edit') }}" class="shrink-0 inline-flex items-center gap-2 rounded-xl border border-slate-600 bg-white/10 hover:bg-white/20 text-white px-4 py-2.5 text-sm font-bold transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    {{ __('Kembali ke Profil') }}
                </a>
            </div>
        </section>

        <div class="grid gap-6 lg:grid-cols-3">

            {{-- Kiri: Signature Canvas --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Tanda Tangan Saat Ini --}}
                @if ($signature)
                    <section class="rounded-2xl border border-[#f0f0f0] bg-white p-6 shadow-sm">
                        <h2 class="text-base font-bold text-slate-800 mb-4">{{ __('Tanda Tangan Saat Ini') }}</h2>
                        <div class="flex items-start gap-4">
                            <div class="rounded-xl border-2 border-dashed border-slate-200 bg-slate-50 p-4 inline-block">
                                <img src="{{ $signature->signature_url }}"
                                     alt="{{ __('Tanda Tangan') }}"
                                     class="max-h-24 max-w-xs object-contain">
                            </div>
                            <div class="text-sm text-slate-500 space-y-1">
                                <p>{{ __('Diunggah:') }} <span class="font-medium text-slate-700">{{ $signature->created_at->locale(app()->getLocale())->diffForHumans() }}</span></p>
                                <p class="text-xs text-slate-400">{{ $signature->created_at->locale(app()->getLocale())->translatedFormat('d F Y, H:i') }}</p>
                            </div>
                        </div>
                    </section>
                @endif

                {{-- Gambar Tanda Tangan Baru --}}
                <section class="rounded-2xl border border-[#f0f0f0] bg-white p-6 shadow-sm" x-data="{ activeTab: 'canvas', saving: false, saved: false }">
                    <h2 class="text-base font-bold text-slate-800 mb-1">{{ $signature ? __('Perbarui Tanda Tangan') : __('Buat Tanda Tangan') }}</h2>
                    <p class="text-sm text-slate-500 mb-5">{{ __('Gunakan mouse atau layar sentuh untuk menggambar, atau unggah file gambar.') }}</p>

                    {{-- Tab Toggle --}}
                    <div class="flex gap-1 rounded-xl bg-slate-100 p-1 mb-5 w-fit">
                        <button type="button"
                                @click="activeTab = 'canvas'"
                                :class="activeTab === 'canvas' ? 'bg-white shadow text-slate-800' : 'text-slate-500 hover:text-slate-700'"
                                class="rounded-lg px-4 py-2 text-sm font-bold transition">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            {{ __('Gambar') }}
                        </button>
                        <button type="button"
                                @click="activeTab = 'upload'"
                                :class="activeTab === 'upload' ? 'bg-white shadow text-slate-800' : 'text-slate-500 hover:text-slate-700'"
                                class="rounded-lg px-4 py-2 text-sm font-bold transition">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                            {{ __('Unggah File') }}
                        </button>
                    </div>

                    {{-- Canvas Panel --}}
                    <div x-show="activeTab === 'canvas'">
                        <div class="rounded-xl border-2 border-slate-200 bg-white overflow-hidden mb-3">
                            <canvas id="signature-pad"
                                    class="block w-full touch-none cursor-crosshair"
                                    style="height: 200px;">
                            </canvas>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <button type="button" id="clear-btn"
                                    class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 px-4 py-2 text-sm font-bold text-slate-600 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                {{ __('Hapus') }}
                            </button>
                            <button type="button" id="undo-btn"
                                    class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 px-4 py-2 text-sm font-bold text-slate-600 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                                {{ __('Undo') }}
                            </button>
                            <button type="button" id="save-canvas-btn"
                                    @click="saving = true"
                                    :disabled="saving"
                                    class="inline-flex items-center gap-2 rounded-lg bg-amber-500 hover:bg-amber-600 disabled:opacity-60 px-5 py-2 text-sm font-bold text-white transition shadow-sm ml-auto">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                <span x-text="saving ? '{{ __('Menyimpan...') }}' : '{{ __('Simpan Tanda Tangan') }}'"></span>
                            </button>
                        </div>
                        <div id="canvas-result" class="mt-3 hidden">
                            <div class="flex items-center gap-2 text-sm text-emerald-600 font-medium">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ __('Tanda tangan berhasil disimpan!') }}
                            </div>
                        </div>
                    </div>

                    {{-- Upload Panel --}}
                    <div x-show="activeTab === 'upload'" style="display:none;">
                        <form action="{{ route('profile.signature.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            <div class="rounded-xl border-2 border-dashed border-slate-200 bg-slate-50 p-6 text-center">
                                <svg class="w-10 h-10 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                <label for="signature_file" class="cursor-pointer">
                                    <span class="text-sm font-bold text-amber-600 hover:text-amber-700">{{ __('Pilih file gambar') }}</span>
                                    <span class="text-sm text-slate-500"> {{ __('atau seret ke sini') }}</span>
                                </label>
                                <p class="text-xs text-slate-400 mt-1">{{ __('PNG, JPG, JPEG — Maks. 5 MB') }}</p>
                                <div id="chosen-file-badge" class="mt-3 inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-white border border-slate-200 text-xs text-slate-600 font-medium">
                                    <span class="text-slate-400">{{ __('File:') }}</span>
                                    <span id="chosen-filename-text">{{ __('Tidak ada file yang dipilih') }}</span>
                                </div>
                                <input type="file" name="signature_file" id="signature_file"
                                       accept="image/png,image/jpeg,image/jpg"
                                       class="hidden"
                                       required>
                            </div>
                            <div id="file-preview" class="hidden">
                                <img id="file-preview-img" src="" alt="{{ __('Preview') }}" class="max-h-24 rounded-lg border border-slate-200">
                            </div>
                            @error('signature_file')
                                <p class="text-xs text-rose-600 font-semibold">{{ $message }}</p>
                            @enderror
                            <button type="submit"
                                    class="inline-flex items-center gap-2 rounded-lg bg-amber-500 hover:bg-amber-600 px-5 py-2.5 text-sm font-bold text-white transition shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                {{ __('Unggah Tanda Tangan') }}
                            </button>
                        </form>
                    </div>
                </section>
            </div>

            {{-- Kanan: Info & Kursus --}}
            <div class="space-y-6">

                {{-- Info Instruktur --}}
                <section class="rounded-2xl border border-[#f0f0f0] bg-white p-6 shadow-sm">
                    <h2 class="text-base font-bold text-slate-800 mb-4">{{ __('Informasi Akun') }}</h2>
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-amber-500 flex items-center justify-center text-white font-black text-base shrink-0">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-bold text-slate-800">{{ $user->name }}</p>
                                <p class="text-slate-500 text-xs">{{ $user->email }}</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between border-t border-slate-100 pt-3">
                            <span class="text-slate-500">{{ __('Peran') }}</span>
                            <span class="inline-flex rounded-full bg-amber-50 border border-amber-100 text-amber-600 px-2.5 py-0.5 text-[10px] font-bold capitalize">
                                {{ $user->role === 'instruktur' ? __('Instruktur') : ($user->role === 'peserta' ? __('Peserta') : __('Administrator')) }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500">{{ __('Status Tanda Tangan') }}</span>
                            @if ($signature)
                                <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 border border-emerald-100 text-emerald-600 px-2.5 py-0.5 text-[10px] font-bold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    {{ __('Ada') }}
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 border border-slate-200 text-slate-500 px-2.5 py-0.5 text-[10px] font-bold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                    {{ __('Belum Ada') }}
                                </span>
                            @endif
                        </div>
                    </div>
                </section>

                {{-- Kursus yang menggunakan tanda tangan ini --}}
                <section class="rounded-2xl border border-[#f0f0f0] bg-white p-6 shadow-sm">
                    <h2 class="text-base font-bold text-slate-800 mb-4">{{ __('Kursus Menggunakan Tanda Tangan Ini') }}</h2>
                    @if ($courses->isNotEmpty())
                        <ul class="space-y-2">
                            @foreach ($courses as $course)
                                <li class="flex items-center gap-3 text-sm">
                                    <div class="w-7 h-7 rounded-lg bg-indigo-50 flex items-center justify-center shrink-0">
                                        <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                    </div>
                                    <span class="text-slate-700 font-medium">{{ $course->title }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-center py-4">
                            <svg class="w-8 h-8 text-slate-200 mx-auto mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            <p class="text-sm text-slate-400">{{ __('Belum ada kursus yang menggunakan tanda tangan Anda.') }}</p>
                        </div>
                    @endif
                </section>

                {{-- Tips --}}
                <section class="rounded-2xl border border-amber-100 bg-amber-50 p-5">
                    <h3 class="text-sm font-bold text-amber-800 mb-2 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ __('Tips') }}
                    </h3>
                    <ul class="text-xs text-amber-700 space-y-1.5 list-disc list-inside">
                        <li>{{ __('Gunakan latar transparan (PNG) untuk hasil terbaik') }}</li>
                        <li>{{ __('Tanda tangan lama tetap tersimpan untuk sertifikat yang sudah diterbitkan') }}</li>
                        <li>{{ __('Perubahan hanya berlaku untuk sertifikat baru') }}</li>
                    </ul>
                </section>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
    <script>
        (function () {
            const canvas = document.getElementById('signature-pad');
            if (!canvas) return;

            // Sesuaikan resolusi canvas dengan ukuran tampilan
            function resizeCanvas() {
                const ratio = Math.max(window.devicePixelRatio || 1, 1);
                const rect = canvas.getBoundingClientRect();
                canvas.width = rect.width * ratio;
                canvas.height = rect.height * ratio;
                canvas.getContext('2d').scale(ratio, ratio);
                signaturePad.clear();
            }

            const signaturePad = new SignaturePad(canvas, {
                backgroundColor: 'rgb(255, 255, 255)',
                penColor: 'rgb(0, 0, 0)',
            });

            window.addEventListener('resize', resizeCanvas);
            resizeCanvas();

            // Simpan semua stroke untuk undo
            let strokes = [];
            signaturePad.addEventListener('endStroke', () => {
                strokes = signaturePad.toData();
            });

            document.getElementById('clear-btn').addEventListener('click', () => {
                signaturePad.clear();
                strokes = [];
            });

            document.getElementById('undo-btn').addEventListener('click', () => {
                if (strokes.length > 0) {
                    strokes.pop();
                    signaturePad.fromData(strokes);
                }
            });

            document.getElementById('save-canvas-btn').addEventListener('click', async function () {
                if (signaturePad.isEmpty()) {
                    showGlobalAlert('{{ __("Peringatan") }}', '{{ __("Silakan gambar tanda tangan terlebih dahulu.") }}');
                    this.closest('[x-data]').__x.$data.saving = false;
                    return;
                }

                const dataURL = signaturePad.toDataURL('image/png');

                try {
                    const resp = await fetch('{{ route("profile.signature.save") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({ signature_data: dataURL }),
                    });
                    const result = await resp.json();
                    if (result.success) {
                        document.getElementById('canvas-result').classList.remove('hidden');
                        setTimeout(() => window.location.reload(), 1500);
                    } else {
                        showGlobalAlert('{{ __("Gagal") }}', result.message);
                        this.closest('[x-data]').__x.$data.saving = false;
                    }
                } catch (err) {
                    showGlobalAlert('{{ __("Error") }}', '{{ __("Terjadi kesalahan saat menyimpan tanda tangan.") }}');
                    this.closest('[x-data]').__x.$data.saving = false;
                }
            });

            // Preview file yang dipilih
            const fileInput = document.getElementById('signature_file');
            if (fileInput) {
                fileInput.addEventListener('change', function () {
                    const file = this.files[0];
                    const chosenText = document.getElementById('chosen-filename-text');
                    if (chosenText) {
                        chosenText.textContent = file ? file.name : '{{ __('Tidak ada file yang dipilih') }}';
                    }
                    if (!file) return;
                    const reader = new FileReader();
                    reader.onload = e => {
                        const preview = document.getElementById('file-preview');
                        const img = document.getElementById('file-preview-img');
                        img.src = e.target.result;
                        preview.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                });
            }
        })();
    </script>
    @endpush
</x-app-layout>
