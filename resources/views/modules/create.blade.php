@section('topbar_title', __('Tambah Modul Baru'))

<x-app-layout>
    <!-- TinyMCE Editor CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js" referrerpolicy="origin"></script>

    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Back Button & Breadcrumbs -->
        <div class="flex items-center justify-between">
            <a href="{{ route('courses.chapters.show', [$course->id, $chapter->id]) }}" class="inline-flex items-center text-sm font-bold text-slate-500 hover:text-blue-600 transition">
                &larr; {{ __('Kembali ke Modul') }}
            </a>
            <span class="text-sm text-slate-400 font-semibold">
                {{ $chapter->title }}
            </span>
        </div>

        <!-- Form Card -->
        <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100 space-y-6">
            <div>
                <h1 class="text-lg font-bold text-slate-800">{{ __('Tambah Modul Pembelajaran') }}</h1>
                <p class="text-sm text-slate-500 mt-1">{{ __('Gunakan formulir di bawah untuk menambahkan modul/materi baru ke dalam bab ini.') }}</p>
            </div>

            <!-- Form -->
            <form id="module-form" action="{{ route('modules.store', [$course->id, $chapter->id]) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Hidden input for order -->
                <input type="hidden" name="order" value="{{ old('order', $nextOrder) }}">

                <!-- Title Inputs -->
                <div class="space-y-4">
                    <!-- Indonesian Title -->
                    <div>
                        <label for="title_id" class="block text-sm font-bold text-slate-700 uppercase tracking-wider mb-2">
                            {{ __('JUDUL MODUL (BAHASA INDONESIA)') }}
                        </label>
                        <input type="text" name="title[id]" id="title_id" value="{{ old('title.id') }}" required
                               placeholder="{{ __('Contoh: 1.1 Deskripsi Komponen Utama') }}"
                               class="w-full text-sm text-slate-800 placeholder-slate-400 bg-white border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition shadow-xs">
                        @error('title.id')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- English Title -->
                    <div>
                        <label for="title_en" class="block text-sm font-bold text-slate-700 uppercase tracking-wider mb-2">
                            {{ __('JUDUL MODUL (ENGLISH)') }} <span class="text-xs font-normal text-slate-400 lowercase">({{ __('opsional') }})</span>
                        </label>
                        <input type="text" name="title[en]" id="title_en" value="{{ old('title.en') }}"
                               placeholder="{{ __('Example: 1.1 Main Component Description') }}"
                               class="w-full text-sm text-slate-800 placeholder-slate-400 bg-white border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition shadow-xs">
                        @error('title.en')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Unggah Gambar Modul (Opsional) -->
                <div x-data="{
                    imagePreview: null,
                    fileName: '',
                    fileSize: '',
                    previewImage(e) {
                        const file = e.target.files[0];
                        if (file) {
                            this.fileName = file.name;
                            this.fileSize = (file.size / (1024 * 1024)).toFixed(2) + ' MB';
                            const reader = new FileReader();
                            reader.onload = (ev) => { this.imagePreview = ev.target.result; };
                            reader.readAsDataURL(file);
                        } else {
                            this.clearImage();
                        }
                    },
                    clearImage() {
                        this.imagePreview = null;
                        this.fileName = '';
                        this.fileSize = '';
                        this.$refs.fileInput.value = '';
                    }
                }" class="space-y-2">
                    <label class="block text-sm font-bold text-slate-700 uppercase tracking-wider mb-2">
                        {{ __('UNGGAH GAMBAR MODUL (OPSIONAL)') }}
                    </label>

                    <!-- Hidden input file -->
                    <input type="file" name="image" id="image" x-ref="fileInput" @change="previewImage" accept="image/*" class="hidden">

                    <!-- State 1: Belum ada gambar dipilih (Full Width Dropzone) -->
                    <div x-show="!imagePreview">
                        <label for="image" class="flex flex-col sm:flex-row items-center justify-center gap-4 w-full p-5 border-2 border-dashed border-gray-200 hover:border-blue-500 rounded-xl cursor-pointer bg-slate-50/50 hover:bg-blue-50/30 transition group text-center sm:text-left">
                            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 group-hover:scale-105 transition">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-slate-700">
                                    <span class="font-bold text-blue-600 group-hover:underline">{{ __('Klik untuk memilih gambar') }}</span>
                                    <span>{{ __('atau seret berkas ke sini') }}</span>
                                </p>
                                <p class="text-xs text-slate-400 mt-1">
                                    {{ __('Format yang didukung: PNG, JPG, JPEG, WEBP, SVG • Maksimal 5 MB') }}
                                </p>
                            </div>
                        </label>
                        @error('image')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- State 2: Gambar Sudah Dipilih (Pratinjau Responsif) -->
                    <div x-show="imagePreview" x-cloak class="border border-gray-200 rounded-xl p-4 bg-white shadow-xs space-y-4">
                        <!-- Top Header Info & Action Buttons -->
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-gray-100">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-9 h-9 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs font-bold text-slate-800 truncate" x-text="fileName || 'Gambar Terpilih'"></p>
                                    <p class="text-[11px] text-slate-400" x-text="fileSize"></p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 shrink-0">
                                <button type="button" @click="$refs.fileInput.click()" class="px-3 py-1.5 text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-lg transition inline-flex items-center gap-1.5 cursor-pointer">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                    {{ __('Ganti Gambar') }}
                                </button>
                                <button type="button" @click="clearImage" class="px-3 py-1.5 text-xs font-semibold text-rose-600 hover:bg-rose-50 rounded-lg transition inline-flex items-center gap-1.5 cursor-pointer">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    {{ __('Hapus') }}
                                </button>
                            </div>
                        </div>

                        <!-- Image Display Box -->
                        <div class="w-full rounded-lg overflow-hidden bg-slate-50 flex items-center justify-center border border-gray-100 p-3">
                            <img :src="imagePreview" class="max-h-80 w-auto max-w-full object-contain mx-auto rounded shadow-2xs" alt="Pratinjau Modul">
                        </div>
                    </div>
                </div>

                <!-- Rich Text Editor for Content -->
                <div class="flex flex-col space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 uppercase tracking-wider mb-2">{{ __('ISI MATERI PEMBELAJARAN (BAHASA INDONESIA)') }}</label>
                        <div class="rounded-xl border border-gray-200 overflow-hidden bg-white">
                            <textarea class="tinymce-editor w-full h-80" name="content[id]">{{ old('content.id') }}</textarea>
                        </div>
                        @error('content.id')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-slate-700 uppercase tracking-wider mb-2">{{ __('ISI MATERI PEMBELAJARAN (ENGLISH)') }}</label>
                        <div class="rounded-xl border border-gray-200 overflow-hidden bg-white">
                            <textarea class="tinymce-editor w-full h-80" name="content[en]">{{ old('content.en') }}</textarea>
                        </div>
                        @error('content.en')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('courses.chapters.show', [$course->id, $chapter->id]) }}" 
                       class="inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-bold text-slate-600 transition hover:bg-slate-50 shadow-2xs">
                        {{ __('Batal') }}
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center justify-center rounded-xl bg-blue-600 hover:bg-blue-700 px-6 py-2.5 text-sm font-bold text-white transition shadow-sm">
                        {{ __('Simpan Modul') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- TinyMCE Editor Setup -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            tinymce.init({
                selector: '.tinymce-editor',
                height: 400,
                menubar: false,
                plugins: [
                    'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                    'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                    'insertdatetime', 'media', 'table', 'code', 'help', 'wordcount'
                ],
                toolbar: 'undo redo | blocks | ' +
                    'bold italic underline strikethrough | alignleft aligncenter ' +
                    'alignright alignjustify | table bullist numlist outdent indent | ' +
                    'removeformat | code | help',
                content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif; font-size: 14px; }',
                setup: function (editor) {
                    editor.on('change', function () {
                        editor.save(); // auto save to textarea
                    });
                }
            });
        });
    </script>
</x-app-layout>
