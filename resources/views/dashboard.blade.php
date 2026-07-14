@section('topbar_title', 'Dashboard')

<x-app-layout>
    @php
        $toneMap = [
            'blue' => [
                'stat' => 'bg-blue-50 text-blue-600 ring-blue-100/50 border-l-blue-500',
                'badge' => 'bg-blue-50 text-blue-600 border-blue-100',
                'button' => 'bg-blue-600 hover:bg-blue-700 focus:ring-blue-500',
                'panel' => 'bg-blue-100 text-blue-700',
            ],
            'amber' => [
                'stat' => 'bg-amber-50 text-amber-600 ring-amber-100/50 border-l-amber-500',
                'badge' => 'bg-amber-50 text-amber-600 border-amber-100',
                'button' => 'bg-amber-600 hover:bg-amber-700 focus:ring-amber-500',
                'panel' => 'bg-amber-100 text-amber-700',
            ],
            'emerald' => [
                'stat' => 'bg-emerald-50 text-emerald-600 ring-emerald-100/50 border-l-emerald-500',
                'badge' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                'button' => 'bg-emerald-600 hover:bg-emerald-700 focus:ring-emerald-500',
                'panel' => 'bg-emerald-100 text-emerald-700',
            ],
            'rose' => [
                'stat' => 'bg-rose-50 text-rose-600 ring-rose-100/50 border-l-rose-500',
                'badge' => 'bg-rose-50 text-rose-600 border-rose-100',
                'button' => 'bg-rose-600 hover:bg-rose-700 focus:ring-rose-500',
                'panel' => 'bg-rose-100 text-rose-700',
            ],
            'slate' => [
                'stat' => 'bg-slate-50 text-slate-600 ring-slate-100 border-l-slate-400',
                'badge' => 'bg-slate-100 text-slate-600 border-slate-200',
                'button' => 'bg-slate-900 hover:bg-slate-800 focus:ring-slate-500',
                'panel' => 'bg-slate-200 text-slate-700',
            ],
        ];
    @endphp

    <div class="space-y-8 select-none" x-data="{ showModal: {{ $errors->any() ? 'true' : 'false' }}, selectedUserProgress: null, userProgress: @js($adminUserProgress ?? []), participantTab: 'materi' }">
        <!-- Flash Messages -->
        @if (session('success'))
            <div class="rounded-xl border border-emerald-100 bg-emerald-50/50 p-4 text-xs font-semibold text-emerald-800 shadow-sm flex items-center space-x-2">
                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="rounded-xl border border-rose-100 bg-rose-50/50 p-4 text-xs font-semibold text-rose-800 shadow-sm flex items-center space-x-2">
                <svg class="w-4 h-4 text-rose-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Premium Hero Welcome Banner -->
        <section class="relative rounded-2xl overflow-hidden bg-gradient-to-r from-slate-900 via-slate-800 to-indigo-950 p-8 md:p-10 shadow-sm border border-slate-800">
            <!-- Subtle background geometric mesh decoration -->
            <div class="absolute inset-0 opacity-15 bg-[radial-gradient(#4f46e5_1px,transparent_1px)] [background-size:16px_16px] pointer-events-none"></div>
            
            <div class="relative z-10 flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                <div class="max-w-2xl space-y-3">
                    <span class="inline-flex items-center rounded-full bg-indigo-500/10 px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-indigo-400 border border-indigo-500/20">
                        {{ $badgeLabel }}
                    </span>
                    <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight text-white">
                        {{ $headline }}
                    </h1>
                    <p class="text-xs md:text-sm leading-relaxed text-slate-300">
                        {{ $description }}
                    </p>
                </div>

                @if ($primaryAction)
                    <div class="shrink-0">
                        <a href="{{ $primaryAction['href'] }}" class="inline-flex items-center justify-center rounded-xl bg-white hover:bg-slate-50 text-slate-900 px-5 py-3 text-xs font-bold transition-all shadow shadow-white/5 border border-slate-200">
                            {{ $primaryAction['label'] }}
                        </a>
                    </div>
                @endif
            </div>
        </section>

        <!-- Stats Overview Cards Grid -->
        <section class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($stats as $stat)
                @php
                    $tone = $toneMap[$stat['tone']] ?? $toneMap['slate'];
                @endphp
                <article class="rounded-xl border border-[#f0f0f0] bg-white p-5 shadow-sm hover:shadow-md transition duration-200 border-l-4 {{ $tone['stat'] }}">
                    <div class="flex items-center justify-between">
                        <div class="space-y-1">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                {{ $stat['label'] }}
                            </p>
                            <p class="text-2xl font-extrabold text-slate-800">
                                {{ $stat['value'] }}
                            </p>
                        </div>
                        <div class="h-10 w-10 flex items-center justify-center rounded-lg bg-white shadow-sm border border-gray-100">
                            <span class="text-xs font-black text-gray-500">
                                {{ strtoupper(substr($stat['label'], 0, 1)) }}
                            </span>
                        </div>
                    </div>
                </article>
            @endforeach
        </section>

        <!-- Tab and Details Section -->
        @if ($isPeserta)
            <!-- Tabs Menu matching Mockup -->
            <div class="border-b border-[#f0f0f0]">
                <nav class="-mb-px flex gap-6 sm:gap-8" aria-label="Menu pembelajaran">
                    <button type="button" @click="participantTab = 'materi'" :class="participantTab === 'materi' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-400 hover:text-gray-600'" class="border-b-2 py-3 px-1 text-sm font-semibold transition">Materi Belajar</button>
                    <button type="button" @click="participantTab = 'quiz'" :class="participantTab === 'quiz' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-400 hover:text-gray-600'" class="border-b-2 py-3 px-1 text-sm font-semibold transition">Quiz & Ujian</button>
                    <button type="button" @click="participantTab = 'latihan'" :class="participantTab === 'latihan' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-400 hover:text-gray-600'" class="border-b-2 py-3 px-1 text-sm font-semibold transition">Latihan Mandiri</button>
                </nav>
            </div>
        @endif

        <div class="grid gap-6 lg:grid-cols-12">
            <!-- Left Side: Role Specific Main Section (span 8) -->
            <div class="lg:col-span-8 space-y-6">
                <!-- 1. DASHBOARD ADMIN: USER MANAGEMENT -->
                @if ($isAdmin)
                    <section id="manajemen-user" class="rounded-2xl border border-[#f0f0f0] bg-white p-6 shadow-sm">
                        <div class="flex flex-col gap-4 border-b border-[#f0f0f0] pb-5 md:flex-row md:items-center md:justify-between">
                            <div>
                                <h2 class="text-base font-bold text-slate-800">Manajemen Pengguna</h2>
                                <p class="text-xs text-slate-400 mt-1">Tambahkan atau hapus akun instruktur dan peserta dari dashboard.</p>
                            </div>
                            <button @click="showModal = true" class="inline-flex items-center justify-center rounded-lg bg-slate-900 hover:bg-slate-800 px-4 py-2.5 text-xs font-bold text-white transition shadow-sm">
                                Tambah User
                            </button>
                        </div>

                        <div class="mt-5 overflow-hidden rounded-xl border border-[#f0f0f0]">
                            <table class="min-w-full divide-y divide-[#f0f0f0] text-left text-xs">
                                <thead class="bg-gray-50">
                                    <tr class="text-[10px] font-bold uppercase tracking-wider text-slate-500">
                                        <th class="px-5 py-3">Nama</th>
                                        <th class="px-5 py-3">Email</th>
                                        <th class="px-5 py-3">Role</th>
                                        <th class="px-5 py-3">Terdaftar</th>
                                        <th class="px-5 py-3 text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[#f0f0f0] bg-white text-slate-700">
                                    @foreach ($items as $item)
                                        <tr class="transition hover:bg-slate-50/50">
                                            <td class="px-5 py-3.5 font-bold text-slate-800">
                                                @if($item->role === 'peserta')
                                                    <button type="button" @click="selectedUserProgress = userProgress[{{ $item->id }}]" class="font-bold text-blue-600 hover:text-blue-700 hover:underline">
                                                        {{ $item->name }}
                                                    </button>
                                                @else
                                                    {{ $item->name }}
                                                @endif
                                            </td>
                                            <td class="px-5 py-3.5 text-slate-500">{{ $item->email }}</td>
                                            <td class="px-5 py-3.5">
                                                @php
                                                    $roleTone = $item->role === 'admin' ? 'rose' : ($item->role === 'instruktur' ? 'amber' : 'blue');
                                                    $roleStyle = $toneMap[$roleTone];
                                                @endphp
                                                <span class="inline-flex rounded-full border px-2.5 py-0.5 text-2xs font-bold capitalize {{ $roleStyle['badge'] }}">
                                                    {{ $item->role }}
                                                </span>
                                            </td>
                                            <td class="px-5 py-3.5 text-slate-400">{{ $item->created_at->format('d M Y') }}</td>
                                            <td class="px-5 py-3.5 text-right">
                                                @if ($item->id !== $user->id)
                                                    <form action="{{ route('admin.users.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="font-bold text-rose-600 transition hover:text-rose-800">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="text-2xs font-semibold italic text-slate-400">Akun Anda</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </section>
                @endif

                <!-- 2. DASHBOARD INSTRUCTOR: COURSE WORKSPACE -->
                @if ($isInstruktur)
                    <section id="kelola-kursus" class="rounded-2xl border border-[#f0f0f0] bg-white p-6 shadow-sm">
                        <div class="border-b border-[#f0f0f0] pb-5">
                            <h2 class="text-base font-bold text-slate-800">Kelola Materi</h2>
                            <p class="text-xs text-slate-400 mt-1">Tambah, edit, dan hapus modul materi pada setiap bab kursus.</p>
                        </div>

                        <div class="mt-5 grid gap-4">
                            @forelse ($items as $course)
                                <article class="rounded-xl border border-[#f0f0f0] bg-slate-50/50 p-5 space-y-4 hover:border-gray-300 transition duration-150">
                                    <div class="flex items-center justify-between">
                                        <span class="inline-flex rounded-full px-2.5 py-0.5 text-[9px] font-bold uppercase tracking-wider {{ $course->is_published ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-slate-200 text-slate-600' }}">
                                            {{ $course->is_published ? 'Published' : 'Draft' }}
                                        </span>
                                        <span class="text-2xs font-bold text-slate-400">{{ $course->modules_count }} modul</span>
                                    </div>

                                    <div class="space-y-1">
                                        <h3 class="text-sm font-bold text-slate-800 leading-snug">{{ $course->title }}</h3>
                                        <p class="text-2xs text-slate-500 line-clamp-2 leading-relaxed">{{ $course->description }}</p>
                                    </div>

                                    <div class="flex items-center justify-between border-t border-gray-200/60 pt-3">
                                        <span class="text-[9px] font-bold uppercase tracking-wider text-slate-400">Diagram interaktif</span>
                                        <a href="{{ route('courses.show', $course->id) }}" class="inline-flex items-center gap-1 justify-center rounded-lg bg-amber-500 hover:bg-amber-600 px-4 py-2 text-2xs font-bold text-white transition shadow-sm">
                                            Kelola Materi →
                                        </a>
                                    </div>
                                </article>
                            @empty
                                <div class="rounded-xl border border-dashed border-[#f0f0f0] bg-slate-50 p-8 text-center text-xs text-slate-400 sm:col-span-2">
                                    Belum ada kursus yang tersedia.
                                </div>
                            @endforelse
                        </div>
                    </section>

                    <section id="progress-peserta" class="rounded-2xl border border-[#f0f0f0] bg-white p-6 shadow-sm mt-6">
                        <div class="border-b border-[#f0f0f0] pb-5">
                            <h2 class="text-base font-bold text-slate-800">Progress Belajar Peserta</h2>
                            <p class="text-xs text-slate-400 mt-1">Pantau perkembangan peserta dalam menyelesaikan modul dan bab pembelajaran.</p>
                        </div>

                        <div class="mt-5 overflow-hidden rounded-xl border border-[#f0f0f0]">
                            <table class="min-w-full divide-y divide-[#f0f0f0] text-left text-xs">
                                <thead class="bg-gray-50">
                                    <tr class="text-[10px] font-bold uppercase tracking-wider text-slate-500">
                                        <th class="px-5 py-3">Nama Peserta</th>
                                        <th class="px-5 py-3">Email</th>
                                        <th class="px-5 py-3">Progress Keseluruhan</th>
                                        <th class="px-5 py-3 text-right">Detail</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[#f0f0f0] bg-white text-slate-700">
                                    @forelse ($participants as $participant)
                                        @php
                                            $prog = $adminUserProgress[$participant->id] ?? null;
                                            $percent = $prog ? $prog['material_percent'] : 0;
                                        @endphp
                                        <tr class="transition hover:bg-slate-50/50">
                                            <td class="px-5 py-3.5 font-bold text-slate-800">
                                                <button type="button" @click="selectedUserProgress = userProgress[{{ $participant->id }}]" class="font-bold text-blue-600 hover:text-blue-700 hover:underline">
                                                    {{ $participant->name }}
                                                </button>
                                            </td>
                                            <td class="px-5 py-3.5 text-slate-500">{{ $participant->email }}</td>
                                            <td class="px-5 py-3.5">
                                                <div class="flex items-center gap-3">
                                                    <div class="h-2 w-full max-w-[120px] rounded-full bg-slate-100 overflow-hidden">
                                                        <div class="h-full rounded-full bg-emerald-500" style="width: {{ $percent }}%"></div>
                                                    </div>
                                                    <span class="text-[10px] font-bold text-slate-600">{{ $percent }}%</span>
                                                </div>
                                            </td>
                                            <td class="px-5 py-3.5 text-right">
                                                <button type="button" @click="selectedUserProgress = userProgress[{{ $participant->id }}]" class="inline-flex items-center gap-1 rounded border border-slate-200 bg-white px-2 py-1 text-[10px] font-bold text-slate-600 transition hover:bg-slate-50">
                                                    Lihat Detail
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-5 py-8 text-center text-xs text-slate-400">Belum ada peserta yang terdaftar.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </section>
                @endif

                <!-- 3. DASHBOARD STUDENT: COURSE CATALOG -->
                @if ($isPeserta)
                    <section id="materi-kursus" x-show="participantTab === 'materi'" class="rounded-2xl border border-[#f0f0f0] bg-white p-6 shadow-sm">
                        <div class="border-b border-[#f0f0f0] pb-5">
                            <h2 class="text-base font-bold text-slate-800">Materi Kursus Tersedia</h2>
                            <p class="text-xs text-slate-400 mt-1">Pilih materi untuk membaca modul pembelajaran.</p>
                        </div>

                        <div class="mt-5 space-y-4">
                            @forelse ($items as $course)
                                <article class="rounded-xl border border-[#f0f0f0] bg-slate-50/30 p-5 flex flex-col md:flex-row md:items-center justify-between gap-5 hover:bg-slate-50/80 transition duration-150">
                                    <div class="space-y-1.5 max-w-xl">
                                        <span class="text-2xs font-bold text-slate-400">{{ $course->modules_count ?? 0 }} modul</span>
                                        <h3 class="text-sm font-bold text-slate-800 leading-snug">{{ $course->title }}</h3>
                                        <p class="text-2xs text-slate-500 leading-relaxed">{{ $course->description }}</p>
                                    </div>

                                    <div class="shrink-0 flex items-center border-t md:border-t-0 border-[#f0f0f0] pt-3 md:pt-0">
                                        <a href="{{ route('courses.show', $course->id) }}" class="inline-flex items-center justify-center rounded-lg bg-blue-600 hover:bg-blue-700 px-4 py-2 text-xs font-bold text-white transition shadow-sm">
                                            Mulai Belajar →
                                        </a>
                                    </div>
                                </article>
                            @empty
                                <div class="rounded-xl border border-dashed border-[#f0f0f0] bg-slate-50 p-8 text-center text-xs text-slate-400">
                                    Belum ada materi kursus yang dipublikasikan.
                                </div>
                            @endforelse
                        </div>
                    </section>

                    <section id="quiz-ujian" x-cloak x-show="participantTab === 'quiz'" class="rounded-2xl border border-[#f0f0f0] bg-white p-6 shadow-sm">
                        <div class="flex flex-col gap-4 border-b border-[#f0f0f0] pb-5 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h2 class="text-base font-bold text-slate-800">Quiz & Ujian</h2>
                                <p class="text-xs text-slate-400 mt-1">Kerjakan quiz chapter dan ujian akhir dari kursus yang tersedia.</p>
                            </div>
                        </div>
                        <div class="mt-5 space-y-3">
                            @forelse ($participantQuizzes as $quiz)
                                <article class="rounded-xl border border-[#f0f0f0] bg-slate-50/30 p-4 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                                    <div>
                                        <p class="text-[10px] font-bold uppercase tracking-wider {{ $quiz->isFinalQuiz() ? 'text-amber-600' : 'text-blue-600' }}">{{ $quiz->isFinalQuiz() ? 'Ujian Akhir' : 'Quiz Chapter' }} · {{ $quiz->course->title }}</p>
                                        <h3 class="mt-1 text-sm font-bold text-slate-800">{{ $quiz->title }}</h3>
                                        <p class="mt-1 text-2xs text-slate-500">{{ $quiz->questions_count }} soal{{ $quiz->chapter ? ' · ' . $quiz->chapter->title : '' }}</p>
                                    </div>
                                    <a href="{{ route('quiz.start', [$quiz->course, $quiz]) }}" class="shrink-0 inline-flex items-center justify-center rounded-lg {{ $quiz->isFinalQuiz() ? 'bg-amber-500 hover:bg-amber-600' : 'bg-blue-600 hover:bg-blue-700' }} px-4 py-2 text-xs font-bold text-white transition">Mulai →</a>
                                </article>
                            @empty
                                <div class="rounded-xl border border-dashed border-[#f0f0f0] bg-slate-50 p-8 text-center text-xs text-slate-400">Belum ada quiz atau ujian yang tersedia.</div>
                            @endforelse
                        </div>
                    </section>

                    <section id="latihan-mandiri" x-cloak x-show="participantTab === 'latihan'" class="rounded-2xl border border-[#f0f0f0] bg-white p-6 shadow-sm">
                        <div class="flex flex-col gap-4 border-b border-[#f0f0f0] pb-5 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h2 class="text-base font-bold text-slate-800">Latihan Mandiri</h2>
                                <p class="text-xs text-slate-400 mt-1">Semua latihan dari kursus yang tersedia untuk mengasah pemahaman Anda.</p>
                            </div>
                        </div>
                        <div class="mt-5 space-y-3">
                            @forelse ($participantPractices as $practice)
                                <article class="rounded-xl border border-[#f0f0f0] bg-slate-50/30 p-4 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                                    <div>
                                        <p class="text-[10px] font-bold uppercase tracking-wider text-violet-600">Latihan · {{ $practice->course->title }}</p>
                                        <h3 class="mt-1 text-sm font-bold text-slate-800">{{ $practice->title }}</h3>
                                        <p class="mt-1 text-2xs text-slate-500">{{ $practice->questions_count }} soal{{ $practice->chapter ? ' · ' . $practice->chapter->title : '' }}</p>
                                    </div>
                                    <a href="{{ route('practice.start', [$practice->course, $practice]) }}" class="shrink-0 inline-flex items-center justify-center rounded-lg bg-violet-600 hover:bg-violet-700 px-4 py-2 text-xs font-bold text-white transition">Mulai Latihan →</a>
                                </article>
                            @empty
                                <div class="rounded-xl border border-dashed border-[#f0f0f0] bg-slate-50 p-8 text-center text-xs text-slate-400">Belum ada latihan yang tersedia.</div>
                            @endforelse
                        </div>
                    </section>
                @endif
            </div>

            <!-- Right Side: Cards Grid / Coming Soon Cards (span 4) -->
            <div class="lg:col-span-4 space-y-6">
                <div class="rounded-2xl border border-[#f0f0f0] bg-white p-6 shadow-sm space-y-5">
                    <h2 class="text-sm font-bold text-slate-800">Aktivitas Lanjutan</h2>
                    
                    <div class="space-y-3.5">
                        @foreach ($cards as $card)
                            @php
                                $tone = $toneMap[$card['tone']] ?? $toneMap['slate'];
                            @endphp
                            <article class="rounded-xl border border-[#f0f0f0] bg-slate-50/50 p-4 space-y-3 hover:border-gray-200 transition duration-150">
                                <div class="flex items-center justify-between">
                                    <span class="inline-flex rounded-full border px-2 py-0.5 text-[9px] font-bold uppercase tracking-wider {{ $tone['badge'] }}">
                                        {{ $card['meta'] }}
                                    </span>
                                </div>

                                <div class="space-y-1">
                                    <h3 class="text-xs font-bold text-slate-800 leading-snug">{{ $card['title'] }}</h3>
                                    <p class="text-[10px] text-slate-500 leading-relaxed">{{ $card['description'] }}</p>
                                </div>

                                <div class="pt-1">
                                    @if (!($card['disabled'] ?? false))
                                        <a href="{{ $card['href'] }}" class="inline-flex items-center text-xs font-bold transition {{ $isPeserta ? 'rounded-lg px-3 py-2 text-white shadow-sm ' . $tone['button'] : 'text-blue-600 hover:text-blue-700' }}">
                                            {{ $card['action'] }} <span class="ml-1">→</span>
                                        </a>
                                    @else
                                        <span class="inline-flex items-center text-xs font-bold text-gray-400 cursor-not-allowed">
                                            {{ $card['action'] }}
                                        </span>
                                    @endif
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Progress Detail Modal -->
        @if ($isAdmin || $isInstruktur)
            <div x-show="selectedUserProgress" class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true" style="display: none;">
                <div class="flex min-h-screen items-center justify-center px-4 py-10">
                    <div class="fixed inset-0 bg-slate-900/60" @click="selectedUserProgress = null"></div>
                    <div class="relative z-10 w-full max-w-2xl overflow-hidden rounded-2xl border border-slate-200 bg-white text-left shadow-2xl">
                        <div class="flex items-start justify-between gap-4 border-b border-slate-100 px-6 py-5">
                            <div>
                                <h3 class="text-sm font-bold text-slate-900">Detail Progress Peserta</h3>
                                <p class="mt-1 text-[10px] text-slate-400" x-text="selectedUserProgress ? selectedUserProgress.name + ' - ' + selectedUserProgress.email : ''"></p>
                            </div>
                            <button type="button" @click="selectedUserProgress = null" class="rounded-lg px-2 py-1 text-xs font-bold text-slate-400 hover:bg-slate-100 hover:text-slate-700">
                                Tutup
                            </button>
                        </div>

                        <div class="max-h-[70vh] space-y-5 overflow-y-auto px-6 py-5">
                            <div class="rounded-xl border border-emerald-100 bg-emerald-50 p-4">
                                <p class="text-xs font-bold text-emerald-700">Progress materi keseluruhan</p>
                                <p class="mt-1 text-2xl font-extrabold text-emerald-700" x-text="selectedUserProgress ? selectedUserProgress.material_percent + '%' : '0%'"></p>
                            </div>

                            <div class="space-y-2">
                                <p class="text-xs font-bold text-slate-800">Progress per BAB</p>
                                <template x-for="chapter in (selectedUserProgress ? selectedUserProgress.chapters : [])" :key="chapter.order">
                                    <div class="rounded-xl border border-slate-100 bg-white p-3">
                                        <div class="flex items-center justify-between gap-3">
                                            <p class="text-xs font-bold text-slate-700" x-text="'BAB ' + chapter.order + (chapter.title ? ' · ' + chapter.title : '')"></p>
                                            <span class="rounded-full px-2.5 py-0.5 text-[10px] font-bold" :class="chapter.is_complete ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600'" x-text="chapter.percent + '%'"></span>
                                        </div>
                                        <template x-if="chapter.missing_modules.length">
                                            <div class="mt-2 border-t border-amber-100 pt-2">
                                                <p class="text-[10px] font-semibold text-amber-700" x-text="chapter.missing_modules.length + ' materi belum selesai'"></p>
                                                <div class="mt-1.5 flex flex-wrap gap-1.5">
                                                    <template x-for="module in chapter.missing_modules.slice(0, 5)" :key="module">
                                                        <span class="rounded-md bg-amber-50 px-2 py-1 text-[9px] font-medium leading-tight text-amber-700" x-text="module"></span>
                                                    </template>
                                                    <template x-if="chapter.missing_modules.length > 5">
                                                        <span class="rounded-md bg-slate-100 px-2 py-1 text-[9px] font-bold text-slate-500" x-text="'+' + (chapter.missing_modules.length - 5) + ' lainnya'"></span>
                                                    </template>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </template>
                            </div>

                            <div class="space-y-3">
                                <p class="text-xs font-bold text-slate-800">Aktivitas Evaluasi</p>
                                <template x-for="section in [
                                    { key: 'quizzes', title: 'Quiz', tone: 'blue' },
                                    { key: 'exams', title: 'Ujian', tone: 'amber' },
                                    { key: 'practices', title: 'Latihan', tone: 'violet' }
                                ]" :key="section.key">
                                    <div class="rounded-xl border border-slate-100 bg-white p-3">
                                        <p class="text-[11px] font-bold" :class="section.tone === 'blue' ? 'text-blue-700' : (section.tone === 'amber' ? 'text-amber-700' : 'text-violet-700')" x-text="section.title"></p>
                                        <div class="mt-2 space-y-2">
                                            <template x-for="activity in (selectedUserProgress ? selectedUserProgress[section.key] : [])" :key="activity.id">
                                                <div class="flex items-center justify-between gap-3 rounded-lg bg-slate-50 px-3 py-2">
                                                    <div class="min-w-0">
                                                        <p class="truncate text-[10px] font-semibold text-slate-700" x-text="activity.title"></p>
                                                        <p class="truncate text-[9px] text-slate-400" x-text="activity.course + (activity.chapter ? ' · ' + activity.chapter : '')"></p>
                                                    </div>
                                                    <span class="shrink-0 rounded-full px-2 py-0.5 text-[9px] font-bold" :class="activity.is_completed ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-200 text-slate-500'" x-text="activity.is_completed ? 'Selesai · ' + activity.score + '%' : 'Belum dikerjakan'"></span>
                                                </div>
                                            </template>
                                            <template x-if="selectedUserProgress && !selectedUserProgress[section.key].length">
                                                <p class="py-1 text-[10px] text-slate-400">Belum ada aktivitas tersedia.</p>
                                            </template>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @endif

        <!-- Admin Add User Modal -->
        @if ($isAdmin)
            <div x-show="showModal" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none;">
                <div class="flex min-h-screen items-center justify-center px-4 py-10 text-center sm:block sm:p-0">
                    <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-0 bg-slate-900/60 transition-opacity" @click="showModal = false"></div>

                    <span class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</span>

                    <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="relative z-10 inline-block w-full max-w-md align-middle overflow-hidden rounded-2xl border border-slate-200 bg-white text-left shadow-2xl transition-all">
                        <div class="border-b border-slate-100 px-6 py-5">
                            <h3 class="text-sm font-bold text-slate-900" id="modal-title">Tambah Pengguna Baru</h3>
                            <p class="text-[10px] text-slate-400 mt-1">Buat akun admin, instruktur, atau peserta baru.</p>
                        </div>

                        <form id="addUserForm" action="{{ route('admin.users.store') }}" method="POST" class="space-y-4 px-6 py-5 text-xs text-slate-700">
                            @csrf

                            <div class="space-y-1">
                                <label for="name" class="block font-bold text-slate-700">Nama Lengkap <span class="font-medium text-slate-400">(opsional)</span></label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" class="block w-full rounded-lg border-slate-200 text-xs shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('name')
                                    <p class="text-[10px] font-semibold text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-1">
                                <label for="email" class="block font-bold text-slate-700">Alamat Email</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" required class="block w-full rounded-lg border-slate-200 text-xs shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('email')
                                    <p class="text-[10px] font-semibold text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-1">
                                <label for="password" class="block font-bold text-slate-700">Password</label>
                                <input type="password" name="password" id="password" required class="block w-full rounded-lg border-slate-200 text-xs shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('password')
                                    <p class="text-[10px] font-semibold text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-1">
                                <label for="role" class="block font-bold text-slate-700">Peran</label>
                                <select name="role" id="role" required class="block w-full rounded-lg border-slate-200 text-xs shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="peserta" @selected(old('role') === 'peserta')>Peserta</option>
                                    <option value="instruktur" @selected(old('role') === 'instruktur')>Instruktur</option>
                                    <option value="admin" @selected(old('role') === 'admin')>Admin</option>
                                </select>
                                @error('role')
                                    <p class="text-[10px] font-semibold text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </form>

                        <div class="flex flex-col-reverse gap-2 border-t border-slate-100 bg-slate-50 px-6 py-4 sm:flex-row sm:justify-end text-xs">
                            <button type="button" @click="showModal = false" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2 font-bold text-slate-700 transition hover:bg-slate-50">
                                Batal
                            </button>
                            <button type="submit" form="addUserForm" class="inline-flex items-center justify-center rounded-lg bg-blue-600 hover:bg-blue-700 px-4 py-2 font-bold text-white transition shadow-sm">
                                Simpan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
