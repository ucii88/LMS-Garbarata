@section('topbar_title', 'Sunting Modul')

<x-app-layout>
    <!-- Quill Rich Text Editor CDN -->
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>

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
                <h1 class="text-lg font-bold text-slate-800">Sunting Modul Pembelajaran</h1>
                <p class="text-xs text-slate-500 mt-1">Ubah formulir di bawah untuk memperbarui isi modul pembelajaran yang sudah ada.</p>
            </div>

            <!-- Form -->
            <form id="module-form" action="{{ route('modules.update', [$course->id, $chapter->id, $module->id]) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Title & Order Grid -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <!-- Title Input -->
                    <div class="md:col-span-3">
                        <label for="title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Modul</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $module->title) }}" required placeholder="Contoh: 1.1 Deskripsi Komponen Utama"
                               class="w-full text-xs text-slate-800 placeholder-slate-400 bg-white border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                        @error('title')
                            <p class="text-rose-600 text-2xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Order Input -->
                    <div class="md:col-span-1">
                        <label for="order" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nomor Urut</label>
                        <input type="number" name="order" id="order" value="{{ old('order', $module->order) }}" required min="1"
                               class="w-full text-xs text-slate-800 bg-white border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                        @error('order')
                            <p class="text-rose-600 text-2xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Image Path (Optional) -->
                <div>
                    <label for="image_path" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Path File Gambar (Opsional)</label>
                    <input type="text" name="image_path" id="image_path" value="{{ old('image_path', $module->image_path) }}" placeholder="Contoh: images/modules/Bab7/bab7.15.png"
                           class="w-full text-xs text-slate-800 placeholder-slate-400 bg-white border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                    <p class="text-[10px] text-slate-400 mt-1">Masukkan lokasi relatif file gambar dari direktori <code>public</code>. Kosongkan jika materi ini tidak memerlukan visualisasi gambar.</p>
                    @error('image_path')
                        <p class="text-rose-600 text-2xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Rich Text Editor for Content -->
                <div class="flex flex-col">
                    <div class="flex items-center justify-between mb-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Isi Materi Pembelajaran</label>
                        <div class="flex items-center gap-1 bg-slate-100 p-0.5 rounded-lg border border-slate-200">
                            <button type="button" id="btn-visual-mode" class="px-2.5 py-1 rounded-md text-[10px] font-bold transition duration-150">
                                Visual (Quill)
                            </button>
                            <button type="button" id="btn-html-mode" class="px-2.5 py-1 rounded-md text-[10px] font-bold transition duration-150">
                                Kode HTML
                            </button>
                        </div>
                    </div>
                    
                    <input type="hidden" name="content" id="content-input" value="{{ old('content', $module->content) }}">
                    
                    <!-- Visual Editor Wrapper -->
                    <div id="editor-wrapper" class="rounded-xl border border-gray-200 overflow-hidden">
                        <div id="quill-editor" class="h-80 bg-white text-slate-800 text-xs"></div>
                    </div>

                    <!-- Raw HTML Editor Wrapper (Hidden by default) -->
                    <div id="html-editor-wrapper" class="hidden">
                        <textarea id="html-textarea" class="w-full h-80 text-xs font-mono p-4 border border-gray-200 rounded-xl bg-slate-900 text-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition" placeholder="Tulis kode HTML di sini..."></textarea>
                        <p class="text-[10px] text-amber-600 font-semibold mt-1">⚠️ Peringatan: Gunakan mode HTML ini untuk mengedit tabel atau kode accordion (details/summary). Menulis langsung di mode Visual dapat merusak struktur tabel.</p>
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
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Quill Editor Setup -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const quill = new Quill('#quill-editor', {
                theme: 'snow',
                placeholder: 'Tulis isi materi di sini...',
                modules: {
                    toolbar: [
                        [{ 'header': [1, 2, 3, false] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        ['link', 'clean']
                    ]
                }
            });

            // Set initial content and determine mode
            const contentInput = document.getElementById('content-input');
            const initialContent = contentInput.value;

            const btnVisual = document.getElementById('btn-visual-mode');
            const btnHtml = document.getElementById('btn-html-mode');
            const visualWrapper = document.getElementById('editor-wrapper');
            const htmlWrapper = document.getElementById('html-editor-wrapper');
            const htmlTextarea = document.getElementById('html-textarea');

            // Detect if the content contains custom HTML structures like tables or details
            const hasHTMLBlocks = initialContent.includes('<table') || initialContent.includes('<details') || initialContent.includes('<summary');
            let currentMode = hasHTMLBlocks ? 'html' : 'visual';

            function updateTabStyles() {
                if (currentMode === 'visual') {
                    btnVisual.className = 'px-2.5 py-1 rounded-md text-[10px] font-bold transition duration-150 bg-white text-blue-600 shadow-2xs border border-slate-200/50';
                    btnHtml.className = 'px-2.5 py-1 rounded-md text-[10px] font-bold transition duration-150 text-slate-500 hover:text-slate-800 hover:bg-slate-50/50';
                } else {
                    btnHtml.className = 'px-2.5 py-1 rounded-md text-[10px] font-bold transition duration-150 bg-white text-blue-600 shadow-2xs border border-slate-200/50';
                    btnVisual.className = 'px-2.5 py-1 rounded-md text-[10px] font-bold transition duration-150 text-slate-500 hover:text-slate-800 hover:bg-slate-50/50';
                }
            }

            if (currentMode === 'html') {
                htmlTextarea.value = initialContent;
                visualWrapper.classList.add('hidden');
                htmlWrapper.classList.remove('hidden');
            } else {
                if (initialContent) {
                    quill.root.innerHTML = initialContent;
                }
            }
            updateTabStyles();

            // Click Visual Tab
            btnVisual.addEventListener('click', function() {
                if (currentMode === 'html') {
                    const textContent = htmlTextarea.value;
                    if (textContent.includes('<table') || textContent.includes('<details') || textContent.includes('<summary')) {
                        if (!confirm('Peringatan: Modul ini berisi tabel atau layout kustom. Beralih ke Mode Visual dapat merusak/menghilangkan struktur tabel tersebut. Apakah Anda yakin ingin melanjutkan?')) {
                            return; // Cancel transition
                        }
                    }

                    // Sync HTML to Quill
                    quill.root.innerHTML = textContent;

                    // Switch view
                    htmlWrapper.classList.add('hidden');
                    visualWrapper.classList.remove('hidden');
                    currentMode = 'visual';
                    updateTabStyles();
                }
            });

            // Click HTML Tab
            btnHtml.addEventListener('click', function() {
                if (currentMode === 'visual') {
                    // Sync Quill to HTML
                    htmlTextarea.value = quill.root.innerHTML;

                    // Switch view
                    visualWrapper.classList.add('hidden');
                    htmlWrapper.classList.remove('hidden');
                    currentMode = 'html';
                    updateTabStyles();
                }
            });

            // Sync editor content with hidden input field before submit
            const form = document.getElementById('module-form');
            form.addEventListener('submit', function () {
                if (currentMode === 'html') {
                    contentInput.value = htmlTextarea.value;
                } else {
                    contentInput.value = quill.root.innerHTML;
                }
            });
        });
    </script>
</x-app-layout>out>
