@section('topbar_title', __('Tambah Modul Baru'))

<x-app-layout>
    <!-- TinyMCE Editor CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js" referrerpolicy="origin"></script>

    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Back Button & Breadcrumbs -->
        <div class="flex items-center justify-between">
            <a href="{{ route('courses.chapters.show', [$course->id, $chapter->id]) }}" class="inline-flex items-center text-sm font-bold text-slate-500 hover:text-blue-600 transition">
                &larr; {{ __('Kembali ke Silabus / Materi') }}
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
            <form id="module-form" action="{{ route('modules.store', [$course->id, $chapter->id]) }}" method="POST" class="space-y-6">
                @csrf

                <!-- Title & Order Grid -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <!-- Title Inputs -->
                    <div class="md:col-span-3 space-y-4">
                        <div>
                            <label for="title_id" class="block text-sm font-bold text-slate-700 uppercase tracking-wider mb-2">{{ __('JUDUL MODUL (BAHASA INDONESIA)') }}</label>
                            <input type="text" name="title[id]" id="title_id" value="{{ old('title.id') }}" required placeholder="{{ __('Contoh: 1.1 Deskripsi Komponen Utama') }}"
                                   class="w-full text-sm text-slate-800 placeholder-slate-400 bg-white border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                            @error('title.id')
                                <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="title_en" class="block text-sm font-bold text-slate-700 uppercase tracking-wider mb-2">{{ __('JUDUL MODUL (ENGLISH)') }}</label>
                            <input type="text" name="title[en]" id="title_en" value="{{ old('title.en') }}" placeholder="{{ __('Example: 1.1 Main Component Description') }}"
                                   class="w-full text-sm text-slate-800 placeholder-slate-400 bg-white border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                            @error('title.en')
                                <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Order Input -->
                    <div class="md:col-span-1">
                        <label for="order" class="block text-sm font-bold text-slate-700 uppercase tracking-wider mb-2">{{ __('NOMOR URUT') }}</label>
                        <input type="number" name="order" id="order" value="{{ old('order', $nextOrder) }}" required min="1"
                               class="w-full text-sm text-slate-800 bg-white border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                        @error('order')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Image Path (Optional) -->
                <div>
                    <label for="image_path" class="block text-sm font-bold text-slate-700 uppercase tracking-wider mb-2">{{ __('PATH FILE GAMBAR (OPSIONAL)') }}</label>
                    <input type="text" name="image_path" id="image_path" value="{{ old('image_path') }}" placeholder="{{ __('Contoh: images/modules/Bab7/bab7.15.png') }}"
                           class="w-full text-sm text-slate-800 placeholder-slate-400 bg-white border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                    <p class="text-[10px] text-slate-400 mt-1">{{ __('Masukkan lokasi relatif file gambar dari direktori') }} <code>public</code>. {{ __('Kosongkan jika materi ini tidak memerlukan visualisasi gambar.') }}</p>
                    @error('image_path')
                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
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
