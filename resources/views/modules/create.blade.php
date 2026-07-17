@section('topbar_title', 'Tambah Modul Baru')

<x-app-layout>
    <!-- TinyMCE Editor CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js" referrerpolicy="origin"></script>

    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Back Button & Breadcrumbs -->
        <div class="flex items-center justify-between">
            <a href="{{ route('courses.chapters.show', [$course->id, $chapter->id]) }}" class="inline-flex items-center text-xs font-bold text-slate-500 hover:text-blue-600 transition">
                &larr; Kembali ke Silabus / Materi
            </a>
            <span class="text-xs text-slate-400 font-semibold">
                {{ $chapter->title }}
            </span>
        </div>

        <!-- Form Card -->
        <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100 space-y-6">
            <div>
                <h1 class="text-lg font-bold text-slate-800">Tambah Modul Pembelajaran</h1>
                <p class="text-xs text-slate-500 mt-1">Gunakan formulir di bawah untuk menambahkan modul/materi baru ke dalam bab ini.</p>
            </div>

            <!-- Form -->
            <form id="module-form" action="{{ route('modules.store', [$course->id, $chapter->id]) }}" method="POST" class="space-y-6">
                @csrf

                <!-- Title & Order Grid -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <!-- Title Input -->
                    <div class="md:col-span-3">
                        <label for="title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Modul</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required placeholder="Contoh: 1.1 Deskripsi Komponen Utama"
                               class="w-full text-xs text-slate-800 placeholder-slate-400 bg-white border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                        @error('title')
                            <p class="text-rose-600 text-2xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Order Input -->
                    <div class="md:col-span-1">
                        <label for="order" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nomor Urut</label>
                        <input type="number" name="order" id="order" value="{{ old('order', $nextOrder) }}" required min="1"
                               class="w-full text-xs text-slate-800 bg-white border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                        @error('order')
                            <p class="text-rose-600 text-2xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Image Path (Optional) -->
                <div>
                    <label for="image_path" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Path File Gambar (Opsional)</label>
                    <input type="text" name="image_path" id="image_path" value="{{ old('image_path') }}" placeholder="Contoh: images/modules/Bab7/bab7.15.png"
                           class="w-full text-xs text-slate-800 placeholder-slate-400 bg-white border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                    <p class="text-[10px] text-slate-400 mt-1">Masukkan lokasi relatif file gambar dari direktori <code>public</code>. Kosongkan jika materi ini tidak memerlukan visualisasi gambar.</p>
                    @error('image_path')
                        <p class="text-rose-600 text-2xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Rich Text Editor for Content -->
                <div class="flex flex-col">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Isi Materi Pembelajaran</label>
                    
                    <!-- TinyMCE Editor -->
                    <div class="rounded-xl border border-gray-200 overflow-hidden bg-white">
                        <textarea id="tinymce-editor" name="content" class="w-full h-80">{{ old('content') }}</textarea>
                    </div>

                    @error('content')
                        <p class="text-rose-600 text-2xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('courses.chapters.show', [$course->id, $chapter->id]) }}" 
                       class="inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-xs font-bold text-slate-600 transition hover:bg-slate-50 shadow-2xs">
                        Batal
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center justify-center rounded-xl bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 text-xs font-bold transition shadow-xs">
                        Simpan Modul
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- TinyMCE Editor Setup -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            tinymce.init({
                selector: '#tinymce-editor',
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
