@section('topbar_title', 'Bank Soal — ' . $chapter->title)

<x-app-layout>
<div class="max-w-7xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <a href="{{ route('courses.chapters.show', [$course->id, $chapter->id]) }}"
               class="inline-flex items-center text-sm font-bold text-slate-500 hover:text-blue-600 transition mb-2">
                ← Kembali ke Chapter
            </a>
            <h1 class="text-xl font-bold text-slate-800">Bank Soal</h1>
            <p class="text-sm text-slate-500 mt-0.5">
                <span class="font-semibold text-blue-600">{{ $chapter->title }}</span> —
                {{ $questions->count() }} soal tersedia
            </p>
        </div>
        <button onclick="openAddModal()"
                class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-base font-semibold px-4 py-2.5 rounded-xl transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Soal
        </button>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 text-base px-4 py-3 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    {{-- Daftar Soal --}}
    @if($questions->isEmpty())
        <div class="bg-white border border-dashed border-slate-200 rounded-2xl p-12 text-center">
            <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <h3 class="font-semibold text-slate-700">Belum ada soal</h3>
            <p class="text-base text-slate-500 mt-1">Klik "Tambah Soal" untuk mulai mengisi bank soal chapter ini.</p>
        </div>
    @else
        <div class="space-y-3">
            @foreach($questions as $i => $question)
            <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm" id="question-{{ $question->id }}">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-sm font-bold text-white bg-blue-500 rounded-full w-6 h-6 flex items-center justify-center">
                                {{ $i + 1 }}
                            </span>
                            <span class="text-sm font-semibold px-2 py-0.5 rounded-full
                                @switch($question->type)
                                    @case('multiple_choice') bg-indigo-100 text-indigo-700 @break
                                    @case('true_false') bg-green-100 text-green-700 @break
                                    @case('essay') bg-orange-100 text-orange-700 @break
                                    @case('matching') bg-purple-100 text-purple-700 @break
                                    @case('ordering') bg-rose-100 text-rose-700 @break
                                @endswitch">
                                {{ $question->type_label }}
                            </span>
                            <span class="text-sm text-slate-400">{{ $question->points }} poin</span>
                            @if($question->topic_tag)
                                <span class="text-sm px-2 py-0.5 bg-slate-100 text-slate-500 rounded-full">
                                    {{ $question->topic_tag }}
                                </span>
                            @endif
                        </div>
                        <p class="text-base text-slate-800 font-medium leading-relaxed">
                            {!! nl2br(e($question->question_text)) !!}
                        </p>
                        @if($question->question_image)
                            <img src="{{ Storage::url($question->question_image) }}"
                                 class="mt-2 max-h-32 rounded-lg border border-slate-200" alt="Gambar soal">
                        @endif

                        {{-- Pilihan Jawaban --}}
                        <div class="mt-3 space-y-1">
                            @foreach($question->options as $opt)
                                <div class="flex items-center gap-2 text-sm {{ $opt->is_correct ? 'text-emerald-700 font-semibold' : 'text-slate-500' }}">
                                    <span class="w-4 h-4 rounded-full border flex items-center justify-center text-[10px]
                                        {{ $opt->is_correct ? 'bg-emerald-500 border-emerald-500 text-white' : 'border-slate-300' }}">
                                        {{ $opt->is_correct ? '✓' : '' }}
                                    </span>
                                    @if($opt->match_label)
                                        <span class="font-bold">{{ $opt->match_label }}.</span>
                                    @endif
                                    {{ $opt->option_text }}
                                </div>
                            @endforeach
                        </div>

                        @if($question->explanation)
                            <div class="mt-3 text-sm bg-blue-50 border border-blue-100 rounded-lg px-3 py-2 text-blue-700">
                                <span class="font-semibold">Penjelasan:</span> {{ $question->explanation }}
                            </div>
                        @endif
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center gap-1 shrink-0">
                        <button onclick="openEditModal({{ $question->id }})"
                                class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition text-sm" title="Edit Soal">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </button>
                        <form action="{{ route('questions.destroy', [$course, $chapter, $question]) }}"
                              method="POST" data-confirm="Apakah Anda yakin ingin menghapus soal ini dari bank soal?">
                            @csrf @method('DELETE')
                            <button class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition text-sm" title="Hapus Soal">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif

</div>

{{-- ===================== MODAL TAMBAH SOAL ===================== --}}
<div id="modal-add-question" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between p-6 border-b border-slate-100">
            <h2 class="text-base font-bold text-slate-800">Tambah Soal ke Bank Soal</h2>
            <button onclick="closeQuestionModal()"
                    class="text-slate-400 hover:text-slate-600 text-xl leading-none">&times;</button>
        </div>
        <form action="{{ route('questions.store', [$course, $chapter]) }}" method="POST"
              enctype="multipart/form-data" class="p-6 space-y-5" id="form-add-question">
            @csrf
            <input type="hidden" name="return_to" value="{{ request('return_to') }}">

            {{-- Tipe Soal --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Tipe Soal <span class="text-red-500">*</span></label>
                <select name="type" id="q-type" onchange="renderOptionsUI(this.value)"
                        class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-base focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                    <option value="multiple_choice">Pilihan Ganda</option>
                    <option value="true_false">Benar / Salah</option>
                    <option value="essay">Esai</option>
                    <option value="matching">Menjodohkan</option>
                    <option value="ordering">Urutan Langkah</option>
                </select>
            </div>

            {{-- Pertanyaan --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Pertanyaan <span class="text-red-500">*</span></label>
                <textarea name="question_text" rows="3" required
                          class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-base focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none resize-none"
                          placeholder="Tulis pertanyaan di sini..."></textarea>
            </div>

            {{-- Gambar Soal (opsional) --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Gambar Soal <span class="text-slate-400">(opsional)</span></label>
                <input type="file" name="question_image" accept="image/*"
                       class="w-full text-sm text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700">
                <p class="mt-1 text-[10px] text-slate-400">Ukuran gambar maksimal 5MB.</p>
                <div id="current-image-preview" class="hidden mt-2 p-2 border border-slate-100 rounded-xl bg-slate-50/50 flex items-center justify-between gap-3">
                    <img src="" id="current-image-img" class="max-h-20 max-w-[120px] rounded-lg object-contain border bg-white">
                    <label class="flex items-center gap-1.5 text-sm text-red-600 font-bold cursor-pointer shrink-0 select-none">
                        <input type="checkbox" name="delete_image" value="1" class="w-4 h-4 rounded text-red-600">
                        Hapus Gambar
                    </label>
                </div>
            </div>

            {{-- Pilihan Jawaban (dinamis berdasarkan tipe) --}}
            <div id="options-container">
                {{-- Di-render oleh JavaScript --}}
            </div>

            {{-- Poin & Tag --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Poin <span class="text-red-500">*</span></label>
                    <input type="number" name="points" value="1" min="1"
                           class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-base focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Tag Topik <span class="text-slate-400">(opsional)</span></label>
                    <input type="text" name="topic_tag" placeholder="misal: Hidrolik"
                           class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-base focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
            </div>

            {{-- Penjelasan --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Penjelasan Jawaban <span class="text-slate-400">(opsional)</span></label>
                <textarea name="explanation" rows="2"
                          class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-base focus:ring-2 focus:ring-blue-500 outline-none resize-none"
                          placeholder="Penjelasan mengapa jawaban ini benar..."></textarea>
            </div>

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-xl">
                    @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
                </div>
            @endif

            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="closeQuestionModal()"
                        class="px-4 py-2 text-base font-semibold text-slate-600 hover:text-slate-800 transition">
                    Batal
                </button>
                <button type="submit"
                        class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-base font-semibold rounded-xl transition">
                    Simpan Soal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
const returnToActivityEditor = new URLSearchParams(window.location.search).get('return_to');

function closeQuestionModal() {
    if (returnToActivityEditor) {
        window.location.href = returnToActivityEditor;
        return;
    }

    document.getElementById('modal-add-question').classList.add('hidden');
}

// Render UI pilihan jawaban berdasarkan tipe soal
function renderOptionsUI(type) {
    const container = document.getElementById('options-container');
    container.innerHTML = '';

    const label = document.createElement('label');
    label.className = 'block text-sm font-semibold text-slate-700 mb-2';
    label.textContent = 'Pilihan Jawaban *';
    container.appendChild(label);

    if (type === 'multiple_choice') {
        container.appendChild(buildMCOptions(4));
        addOptionBtn(container, 'multiple_choice');
    } else if (type === 'true_false') {
        container.appendChild(buildTrueFalseOptions());
    } else if (type === 'essay') {
        container.appendChild(buildEssayInfo());
    } else if (type === 'matching') {
        container.appendChild(buildMatchingOptions(3));
        addOptionBtn(container, 'matching');
    } else if (type === 'ordering') {
        container.appendChild(buildOrderingOptions(3));
        addOptionBtn(container, 'ordering');
    }
}

function buildMCOptions(count) {
    const wrap = document.createElement('div');
    wrap.id = 'mc-options';
    wrap.className = 'space-y-2';
    const labels = ['A', 'B', 'C', 'D', 'E'];
    for (let i = 0; i < count; i++) {
        wrap.appendChild(mcOptionRow(i, labels[i]));
    }
    return wrap;
}

function mcOptionRow(i, label) {
    const row = document.createElement('div');
    row.className = 'flex items-center gap-2';
    row.innerHTML = `
        <span class="opt-label text-sm font-bold text-slate-500 w-5">${label}.</span>
        <input type="text" name="options[${i}][text]" placeholder="Opsi ${label}" required
               class="flex-1 border border-slate-200 rounded-lg px-3 py-2 text-base focus:ring-2 focus:ring-blue-500 outline-none">
        <label class="flex items-center gap-1 text-sm text-emerald-600 font-semibold cursor-pointer shrink-0">
            <input type="radio" name="correct_mc" value="${i}">
            Benar
        </label>
        <input type="hidden" name="options[${i}][is_correct]" value="0">
        <button type="button" onclick="removeOptionRow(this, 'multiple_choice')" class="text-sm text-red-500 hover:text-red-700 font-semibold px-2">
            Hapus
        </button>
    `;
    // Simpler approach using a radio
    row.querySelector('input[type=radio]').addEventListener('change', function() {
        document.querySelectorAll('.mc-correct').forEach(h => h.value = 0);
        row.querySelector('.mc-correct').value = 1;
    });
    const hidden = row.querySelector('input[type=hidden]');
    hidden.className = 'mc-correct';
    return row;
}

function buildTrueFalseOptions() {
    const wrap = document.createElement('div');
    wrap.className = 'space-y-2';
    wrap.innerHTML = `
        <div class="flex items-center gap-4">
            <label class="flex items-center gap-2 text-base cursor-pointer">
                <input type="radio" name="correct_tf" value="0" checked onchange="setTFCorrect(0)">
                <input type="hidden" name="options[0][text]" value="Benar">
                <input type="hidden" name="options[0][is_correct]" id="tf-correct-0" value="1">
                <span class="font-semibold text-emerald-600">✓ Benar</span>
            </label>
            <label class="flex items-center gap-2 text-base cursor-pointer">
                <input type="radio" name="correct_tf" value="1" onchange="setTFCorrect(1)">
                <input type="hidden" name="options[1][text]" value="Salah">
                <input type="hidden" name="options[1][is_correct]" id="tf-correct-1" value="0">
                <span class="font-semibold text-red-500">✗ Salah</span>
            </label>
        </div>
        <p class="text-sm text-slate-400">Pilih mana yang merupakan jawaban benar.</p>
    `;
    return wrap;
}

function setTFCorrect(correctIdx) {
    document.getElementById('tf-correct-0').value = correctIdx === 0 ? 1 : 0;
    document.getElementById('tf-correct-1').value = correctIdx === 1 ? 1 : 0;
}

function buildFillBlankOption() {
    const wrap = document.createElement('div');
    wrap.innerHTML = `
        <input type="hidden" name="options[0][is_correct]" value="1">
        <input type="text" name="options[0][text]" required placeholder="Ketik jawaban yang benar (case-insensitive)"
               class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-base focus:ring-2 focus:ring-blue-500 outline-none">
        <p class="text-sm text-slate-400 mt-1">Jawaban dicocokkan secara case-insensitive.</p>
    `;
    return wrap;
}

function buildEssayInfo() {
    const wrap = document.createElement('div');
    wrap.innerHTML = `
        <div class="flex items-start gap-3 p-4 bg-orange-50 border border-orange-200 rounded-xl">
            <svg class="w-6 h-6 text-orange-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
            <div>
                <p class="text-base font-semibold text-orange-800">Soal Esai — Dinilai Manual</p>
                <p class="text-sm text-orange-700 mt-1">Peserta akan menulis jawaban panjang. Instruktur yang akan memberikan nilai setelah peserta mengumpulkan jawabannya. Tidak perlu mengisi opsi jawaban.</p>
            </div>
        </div>
    `;
    return wrap;
}

function buildMatchingOptions(count) {
    const wrap = document.createElement('div');
    wrap.id = 'matching-options';
    wrap.className = 'space-y-2';
    const letters = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
    for (let i = 0; i < count; i++) {
        wrap.appendChild(matchingRow(i, letters[i]));
    }
    return wrap;
}

function matchingRow(i, letter) {
    const row = document.createElement('div');
    row.className = 'flex items-center gap-2';
    row.innerHTML = `
        <span class="opt-label text-sm font-bold text-slate-500 w-6">${letter}.</span>
        <input type="hidden" name="options[${i}][is_correct]" value="1">
        <input type="text" name="options[${i}][text]" placeholder="Item kiri (soal)" required
               class="flex-1 border border-slate-200 rounded-lg px-3 py-2 text-base focus:ring-2 focus:ring-blue-500 outline-none">
        <span class="text-slate-400">→</span>
        <input type="text" name="options[${i}][match_label]" placeholder="Item kanan (pasangan)" required
               class="flex-1 border border-slate-200 rounded-lg px-3 py-2 text-base focus:ring-2 focus:ring-blue-500 outline-none">
        <button type="button" onclick="removeOptionRow(this, 'matching')" class="text-sm text-red-500 hover:text-red-700 font-semibold px-2">
            Hapus
        </button>
    `;
    return row;
}

function buildOrderingOptions(count) {
    const wrap = document.createElement('div');
    wrap.id = 'ordering-options';
    wrap.className = 'space-y-2';
    for (let i = 0; i < count; i++) {
        wrap.appendChild(orderingRow(i));
    }
    return wrap;
}

function orderingRow(i) {
    const row = document.createElement('div');
    row.className = 'flex items-center gap-2';
    row.innerHTML = `
        <span class="opt-label text-sm font-bold text-slate-500 w-6">${i+1}.</span>
        <input type="hidden" name="options[${i}][is_correct]" value="1">
        <input type="text" name="options[${i}][text]" placeholder="Langkah ke-${i+1}" required
               class="flex-1 border border-slate-200 rounded-lg px-3 py-2 text-base focus:ring-2 focus:ring-blue-500 outline-none">
        <button type="button" onclick="removeOptionRow(this, 'ordering')" class="text-sm text-red-500 hover:text-red-700 font-semibold px-2">
            Hapus
        </button>
    `;
    return row;
}

function removeOptionRow(btn, type) {
    const row = btn.closest('.flex');
    if (!row) return;
    const wrap = row.parentNode;
    if (wrap.children.length <= 1) {
        showGlobalAlert('Pemberitahuan', 'Minimal harus ada 1 opsi jawaban.');
        return;
    }
    row.remove();
    reindexOptions(type);
}

function reindexOptions(type) {
    const wrapId = type === 'multiple_choice' ? 'mc-options' : (type === 'matching' ? 'matching-options' : 'ordering-options');
    const wrap = document.getElementById(wrapId);
    if (!wrap) return;

    const letters = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N'];
    Array.from(wrap.children).forEach((row, idx) => {
        const labelEl = row.querySelector('.opt-label');
        if (labelEl) {
            if (type === 'multiple_choice' || type === 'matching') {
                labelEl.textContent = `${letters[idx]}.`;
            } else if (type === 'ordering') {
                labelEl.textContent = `${idx + 1}.`;
            }
        }
        
        const textInputs = row.querySelectorAll('input[type=text]');
        if (textInputs.length > 0) {
            if (type === 'matching') {
                textInputs[0].name = `options[${idx}][text]`;
                textInputs[1].name = `options[${idx}][match_label]`;
            } else {
                textInputs[0].name = `options[${idx}][text]`;
                if (type === 'multiple_choice') textInputs[0].placeholder = `Opsi ${letters[idx]}`;
                else if (type === 'ordering') textInputs[0].placeholder = `Langkah ke-${idx + 1}`;
            }
        }
        
        const correctInput = row.querySelector('.mc-correct');
        if (correctInput) {
            correctInput.name = `options[${idx}][is_correct]`;
        }

        const radioInput = row.querySelector('input[type=radio]');
        if (radioInput) {
            radioInput.value = idx;
        }

        const idInput = row.querySelector('input[name*="[id]"]');
        if (idInput) {
            idInput.name = `options[${idx}][id]`;
        }

        const isCorrectHidden = row.querySelector('input[name$="[is_correct]"]:not(.mc-correct)');
        if (isCorrectHidden) {
            isCorrectHidden.name = `options[${idx}][is_correct]`;
        }
    });
}

function addOptionBtn(container, type) {
    const btn = document.createElement('button');
    btn.type = 'button';
    btn.className = 'mt-2 text-sm text-blue-600 hover:text-blue-800 font-semibold';
    btn.textContent = '+ Tambah opsi';
    btn.onclick = function() {
        const wrap = document.getElementById(type === 'matching' ? 'matching-options' : (type === 'ordering' ? 'ordering-options' : 'mc-options'));
        const i = wrap.children.length;
        const letters = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N'];
        if (type === 'multiple_choice') wrap.appendChild(mcOptionRow(i, letters[i]));
        else if (type === 'matching') wrap.appendChild(matchingRow(i, letters[i]));
        else if (type === 'ordering') wrap.appendChild(orderingRow(i));
    };
    container.appendChild(btn);
}

// Data quiz untuk keperluan Edit Modal
const questionsData = @js($questions->keyBy('id'));

function openAddModal() {
    const modal = document.getElementById('modal-add-question');
    const form = document.getElementById('form-add-question');
    
    modal.querySelector('h2').textContent = 'Tambah Soal ke Bank Soal';
    form.action = `{{ route('questions.store', [$course->id, $chapter->id]) }}`;
    
    const methodInput = form.querySelector('input[name="_method"]');
    if (methodInput) {
        methodInput.remove();
    }

    form.reset();
    
    // Sembunyikan preview gambar lama
    document.getElementById('current-image-preview').classList.add('hidden');
    document.getElementById('current-image-img').src = '';
    form.querySelector('input[name=delete_image]').checked = false;

    renderOptionsUI('multiple_choice');
    modal.classList.remove('hidden');
}

function openEditModal(id) {
    const question = questionsData[id];
    if (!question) return;

    const modal = document.getElementById('modal-add-question');
    const form = document.getElementById('form-add-question');
    
    modal.querySelector('h2').textContent = 'Edit Soal';
    form.action = `{{ route('questions.update', [$course->id, $chapter->id, '__ID__']) }}`.replace('__ID__', id);
    
    let methodInput = form.querySelector('input[name="_method"]');
    if (!methodInput) {
        methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'PUT';
        form.appendChild(methodInput);
    }

    form.querySelector('[name=type]').value = question.type;
    form.querySelector('[name=question_text]').value = question.question_text;
    form.querySelector('[name=points]').value = question.points;
    form.querySelector('[name=explanation]').value = question.explanation || '';
    form.querySelector('[name=topic_tag]').value = question.topic_tag || '';

    // Kelola preview gambar lama
    const previewDiv = document.getElementById('current-image-preview');
    const previewImg = document.getElementById('current-image-img');
    const deleteCheck = form.querySelector('input[name=delete_image]');
    
    deleteCheck.checked = false;
    
    if (question.question_image) {
        previewImg.src = `/storage/${question.question_image}`;
        previewDiv.classList.remove('hidden');
    } else {
        previewImg.src = '';
        previewDiv.classList.add('hidden');
    }

    renderOptionsUI(question.type);

    if (question.type === 'multiple_choice') {
        const wrap = document.getElementById('mc-options');
        wrap.innerHTML = '';
        const letters = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
        question.options.forEach((opt, idx) => {
            const row = mcOptionRow(idx, letters[idx]);
            const idInput = document.createElement('input');
            idInput.type = 'hidden';
            idInput.name = `options[${idx}][id]`;
            idInput.value = opt.id;
            row.appendChild(idInput);
            row.querySelector('input[type=text]').value = opt.option_text;
            if (opt.is_correct) {
                row.querySelector('input[type=radio]').checked = true;
                row.querySelector('.mc-correct').value = 1;
            }
            wrap.appendChild(row);
        });
    } else if (question.type === 'true_false') {
        const isTrueCorrect = question.options[0] ? question.options[0].is_correct : true;
        document.querySelector(`input[name="correct_tf"][value="${isTrueCorrect ? '0' : '1'}"]`).checked = true;
        setTFCorrect(isTrueCorrect ? 0 : 1);
        if (question.options[0]) {
            const id0 = document.createElement('input');
            id0.type = 'hidden';
            id0.name = 'options[0][id]';
            id0.value = question.options[0].id;
            document.getElementById('options-container').appendChild(id0);
        }
        if (question.options[1]) {
            const id1 = document.createElement('input');
            id1.type = 'hidden';
            id1.name = 'options[1][id]';
            id1.value = question.options[1].id;
            document.getElementById('options-container').appendChild(id1);
        }
    } else if (question.type === 'essay') {
        // Soal esai tidak punya opsi, tampilkan info saja
        const wrap = document.getElementById('options-container');
        // buildEssayInfo() already rendered by renderOptionsUI
    } else if (question.type === 'matching') {
        const wrap = document.getElementById('matching-options');
        wrap.innerHTML = '';
        const letters = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
        question.options.forEach((opt, idx) => {
            const row = matchingRow(idx, letters[idx]);
            const idInput = document.createElement('input');
            idInput.type = 'hidden';
            idInput.name = `options[${idx}][id]`;
            idInput.value = opt.id;
            row.appendChild(idInput);
            row.querySelector('[placeholder="Item kiri (soal)"]').value = opt.option_text;
            row.querySelector('[placeholder="Item kanan (pasangan)"]').value = opt.match_label;
            wrap.appendChild(row);
        });
    } else if (question.type === 'ordering') {
        const wrap = document.getElementById('ordering-options');
        wrap.innerHTML = '';
        question.options.forEach((opt, idx) => {
            const row = orderingRow(idx);
            const idInput = document.createElement('input');
            idInput.type = 'hidden';
            idInput.name = `options[${idx}][id]`;
            idInput.value = opt.id;
            row.appendChild(idInput);
            row.querySelector('input[type=text]').value = opt.option_text;
            wrap.appendChild(row);
        });
    }

    modal.classList.remove('hidden');
}

// Init on load
renderOptionsUI('multiple_choice');

// Buka detail soal langsung ketika diakses dari halaman Quiz/Ujian/Latihan.
const questionFromQuery = new URLSearchParams(window.location.search).get('question');
if (questionFromQuery && questionsData[questionFromQuery]) {
    openEditModal(questionFromQuery);
}

// Re-open modal if validation errors
@if($errors->any())
    document.getElementById('modal-add-question').classList.remove('hidden');
@endif

// Validasi ukuran gambar di sisi client
document.querySelector('input[name="question_image"]').addEventListener('change', function() {
    if (this.files && this.files[0]) {
        const file = this.files[0];
        const maxSize = 5 * 1024 * 1024; // 5MB
        if (file.size > maxSize) {
            showGlobalAlert('Ukuran File Terlalu Besar', 'File gambar terlalu besar! Maksimal ukuran file adalah 5MB.\nFile yang Anda pilih berukuran ' + (file.size / (1024 * 1024)).toFixed(2) + 'MB. Silakan pilih gambar lain.');
            this.value = ''; // Reset file input
        }
    }
});
</script>
</x-app-layout>
