<aside x-cloak x-show="!$store.ui.sidebarCollapsed" x-transition class="w-64 bg-white border-r border-[#f0f0f0] flex flex-col justify-between h-screen sticky top-0 shrink-0 select-none">
    <!-- Top Area: Logo & Navigation -->
    <div class="py-6 px-5 space-y-7">
        <!-- Logo -->
        <div class="flex items-center justify-between px-2">
            <div class="flex items-center space-x-2.5">
            <!-- Stylized colorful logo from screenshot -->
            <div class="w-7 h-7 rounded-lg bg-gradient-to-tr from-[#0091ff] to-[#40a9ff] flex items-center justify-center text-white shadow-sm font-black text-sm tracking-tighter">
                <svg class="w-4.5 h-4.5 text-white transform -rotate-12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"></path>
                </svg>
            </div>
            <span class="text-base font-extrabold text-slate-800 tracking-tight">Garbarata</span>
            </div>
            <button type="button" @click="$store.ui.toggleSidebar()" class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-slate-500 hover:bg-slate-100" aria-label="Tutup sidebar">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            </button>
        </div>

        <!-- Menu Navigation -->
        <nav class="space-y-1">
            @if(Auth::user()->isAdmin())
                <!-- Admin specific links -->
                <a
                    href="{{ route('dashboard') }}"
                    class="flex items-center space-x-3 px-3.5 py-2.5 rounded-lg text-sm font-semibold transition-all duration-150 {{ request()->routeIs('dashboard') ? 'bg-[#e6f4ff] text-[#0091ff]' : 'text-gray-500 hover:bg-[#f5f5f5] hover:text-gray-800' }}"
                >
                    <svg class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-[#0091ff]' : 'text-gray-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                    <span>Dashboard</span>
                </a>

                <a
                    href="{{ route('dashboard') }}#manajemen-user"
                    class="flex items-center space-x-3 px-3.5 py-2.5 rounded-lg text-sm font-semibold transition-all duration-150 text-gray-500 hover:bg-[#f5f5f5] hover:text-gray-800"
                >
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <span>Kelola Pengguna</span>
                </a>
            @endif

            @if(Auth::user()->isInstruktur())
                <!-- Instruktur specific links -->
                <a
                    href="{{ route('dashboard') }}"
                    class="flex items-center space-x-3 px-3.5 py-2.5 rounded-lg text-sm font-semibold transition-all duration-150 {{ request()->routeIs('dashboard') ? 'bg-[#e6f4ff] text-[#0091ff]' : 'text-gray-500 hover:bg-[#f5f5f5] hover:text-gray-800' }}"
                >
                    <svg class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-[#0091ff]' : 'text-gray-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                    <span>Dashboard</span>
                </a>

                <a
                    href="{{ route('courses.show', 1) }}"
                    class="flex items-center space-x-3 px-3.5 py-2.5 rounded-lg text-sm font-semibold transition-all duration-150 {{ request()->routeIs('courses.show') || request()->routeIs('courses.chapters.*') ? 'bg-[#e6f4ff] text-[#0091ff]' : 'text-gray-500 hover:bg-[#f5f5f5] hover:text-gray-800' }}"
                >
                    <svg class="w-5 h-5 {{ request()->routeIs('courses.show') || request()->routeIs('courses.chapters.*') ? 'text-[#0091ff]' : 'text-gray-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <span>Kelola Materi</span>
                </a>

                <a
                    href="{{ route('practices.index', 1) }}"
                    class="flex items-center space-x-3 px-3.5 py-2.5 rounded-lg text-sm font-semibold transition-all duration-150 {{ request()->routeIs('practices.*') ? 'bg-[#e6f4ff] text-[#0091ff]' : 'text-gray-500 hover:bg-[#f5f5f5] hover:text-gray-800' }}"
                >
                    <svg class="w-5 h-5 {{ request()->routeIs('practices.*') ? 'text-[#0091ff]' : 'text-gray-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m5-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Kelola Latihan</span>
                </a>

                {{-- Kelola Quiz dan Ujian di sidebar instruktur --}}
                <a
                    href="{{ route('quizzes.index', 1) }}"
                    class="flex items-center space-x-3 px-3.5 py-2.5 rounded-lg text-sm font-semibold transition-all duration-150 {{ request()->routeIs('quizzes.*') ? 'bg-[#e6f4ff] text-[#0091ff]' : 'text-gray-500 hover:bg-[#f5f5f5] hover:text-gray-800' }}"
                >
                    <svg class="w-5 h-5 {{ request()->routeIs('quizzes.*') ? 'text-[#0091ff]' : 'text-gray-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    <span>Kelola Quiz dan Ujian</span>
                </a>
            @endif

            @if(Auth::user()->isPeserta())
                <!-- Peserta specific links (Matches mockup design) -->
                <!-- Dashboard Link -->
                <a
                    href="{{ route('dashboard') }}"
                    class="flex items-center space-x-3 px-3.5 py-2.5 rounded-lg text-sm font-semibold transition-all duration-150 {{ request()->routeIs('dashboard') ? 'bg-[#e6f4ff] text-[#0091ff]' : 'text-gray-500 hover:bg-[#f5f5f5] hover:text-gray-800' }}"
                >
                    <svg class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-[#0091ff]' : 'text-gray-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                    <span>Dashboard</span>
                </a>

                <!-- Materi Garbarata Link -->
                <a
                    href="{{ route('courses.show', 1) }}"
                    class="flex items-center space-x-3 px-3.5 py-2.5 rounded-lg text-sm font-semibold transition-all duration-150 {{ request()->routeIs('courses.show') || request()->routeIs('courses.chapters.show') ? 'bg-[#e6f4ff] text-[#0091ff]' : 'text-gray-500 hover:bg-[#f5f5f5] hover:text-gray-800' }}"
                >
                    <svg class="w-5 h-5 {{ request()->routeIs('courses.show') || request()->routeIs('courses.chapters.show') ? 'text-[#0091ff]' : 'text-gray-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <span>Materi Garbarata</span>
                </a>

                 <a
                    href="{{ route('courses.practices', 1) }}"
                    class="flex items-center space-x-3 px-3.5 py-2.5 rounded-lg text-sm font-semibold transition-all duration-150 {{ request()->routeIs('courses.practices') || request()->routeIs('practice.*') ? 'bg-[#e6f4ff] text-[#0091ff]' : 'text-gray-500 hover:bg-[#f5f5f5] hover:text-gray-800' }}"
                >
                    <svg class="w-5 h-5 {{ request()->routeIs('courses.practices') || request()->routeIs('practice.*') ? 'text-[#0091ff]' : 'text-gray-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m5-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Latihan</span>
                </a>

                <a
                    href="{{ route('courses.quizzes', 1) }}"
                    class="flex items-center space-x-3 px-3.5 py-2.5 rounded-lg text-sm font-semibold transition-all duration-150 {{ request()->routeIs('courses.quizzes') || request()->routeIs('quiz.*') ? 'bg-[#e6f4ff] text-[#0091ff]' : 'text-gray-500 hover:bg-[#f5f5f5] hover:text-gray-800' }}"
                >
                    <svg class="w-5 h-5 {{ request()->routeIs('courses.quizzes') || request()->routeIs('quiz.*') ? 'text-[#0091ff]' : 'text-gray-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    <span>Quiz & Ujian</span>
                </a>

                <!-- Sertifikat Link -->
                @php
                    $userCert = \App\Models\Certificate::where('user_id', Auth::id())->where('course_id', 1)->first();
                @endphp
                @if($userCert)
                    <a
                        href="{{ route('certificate.show', $userCert->id) }}"
                        class="flex items-center space-x-3 px-3.5 py-2.5 rounded-lg text-sm font-semibold transition-all duration-150 text-gray-500 hover:bg-[#f5f5f5] hover:text-gray-800"
                    >
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                        </svg>
                        <span>Sertifikat</span>
                    </a>
                @else
                    <a
                        href="#"
                        onclick="alert('Sertifikat belum tersedia. Silakan selesaikan semua quiz dengan nilai kelulusan terlebih dahulu!')"
                        class="flex items-center space-x-3 px-3.5 py-2.5 rounded-lg text-sm font-semibold transition-all duration-150 text-gray-400 hover:bg-[#f5f5f5] hover:text-gray-500"
                    >
                        <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                        </svg>
                        <span>Sertifikat</span>
                    </a>
                @endif
            @endif
        </nav>
    </div>

    <!-- Bottom Area: Profile Card & Logout -->
    <div class="p-4 border-t border-[#f0f0f0] space-y-3">
        <!-- User Profile Info (Matches mockup exactly with 'User' label in circle) -->
        <button
            type="button"
            class="w-full flex items-center space-x-3 p-2 rounded-xl select-none text-left"
            title="Profil pengguna"
        >
            <!-- Profile Avatar -->
            <div class="w-10 h-10 rounded-full bg-[#0091ff] text-white flex items-center justify-center font-bold text-xs shadow-sm">
                User
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-bold text-gray-800 truncate leading-tight">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-400 truncate mt-0.5">
                    {{ Auth::user()->role === 'peserta' ? 'Peserta (Teknisi)' : (Auth::user()->role === 'instruktur' ? 'Instruktur' : 'Administrator') }}
                </p>
            </div>
        </button>

        <button type="button" onclick="openLogoutModal(event)" class="w-full rounded-lg border border-rose-100 bg-rose-50 px-3 py-2 text-left text-xs font-bold text-rose-600 transition hover:bg-rose-100 hover:text-rose-700">
            Logout
        </button>

        <!-- Safe Reporting Link -->
        <div class="px-2">
            <a href="#" class="block text-[10px] text-gray-400 hover:underline transition">
                Laporkan konten tidak aman
            </a>
        </div>
    </div>
</aside>
<aside x-cloak x-show="$store.ui.sidebarCollapsed" class="w-14 bg-white border-r border-[#f0f0f0] h-screen sticky top-0 shrink-0 flex justify-center pt-6">
    <button type="button" @click="$store.ui.toggleSidebar()" class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-slate-500 hover:bg-slate-100" aria-label="Buka sidebar">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
    </button>
</aside>
