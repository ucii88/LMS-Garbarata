<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="LMS Garbarata - Portal Belajar Mandiri Terintegrasi Suku Cadang, Sistem Mekanikal & Elektrikal Passenger Boarding Bridge.">
        <title>LMS Garbarata - Portal Belajar Mandiri Terintegrasi</title>

        <!-- Google Fonts: Outfit & Inter -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts & Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                font-family: 'Inter', sans-serif;
                background-color: #F8FAFC;
            }
            .font-outfit {
                font-family: 'Outfit', sans-serif;
            }
            /* Custom glassmorphism styling for light mode */
            .light-card {
                background: #FFFFFF;
                border: 1px solid #E2E8F0;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            }
            .light-card:hover {
                border-color: #3B82F6;
                box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.1), 0 8px 10px -6px rgba(59, 130, 246, 0.05);
                transform: translateY(-4px);
            }
            /* Smooth transitions */
            .transition-premium {
                transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            }
            /* Custom background grid pattern for light mode */
            .bg-grid-pattern {
                background-size: 40px 40px;
                background-image: linear-gradient(to right, rgba(148, 163, 184, 0.05) 1px, transparent 1px),
                                  linear-gradient(to bottom, rgba(148, 163, 184, 0.05) 1px, transparent 1px);
            }
        </style>
    </head>
    <body class="text-slate-800 antialiased min-h-screen flex flex-col relative overflow-x-hidden bg-grid-pattern">
        
        <!-- Soft Ambient Lights -->
        <div class="absolute top-[-10%] left-[25%] w-[50%] h-[50%] bg-blue-500/5 rounded-full blur-[120px] pointer-events-none"></div>
        
        <!-- Navigation Bar -->
        <header class="w-full max-w-7xl mx-auto px-6 py-5 flex items-center justify-between relative z-10">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-500 flex items-center justify-center shadow-lg shadow-blue-500/20">
                    <!-- Custom Aviation Wing Icon -->
                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                </div>
                <div>
                    <span class="font-outfit font-extrabold text-xl tracking-tight bg-gradient-to-r from-slate-900 via-slate-800 to-blue-700 bg-clip-text text-transparent">GARBARATA</span>
                    <span class="block text-[9px] font-semibold text-blue-600 tracking-widest uppercase">LMS Portal</span>
                </div>
            </div>

            <!-- Auth Buttons -->
            <nav class="flex items-center gap-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ route('dashboard') }}" 
                           class="px-5 py-2 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white text-sm font-semibold shadow-lg shadow-blue-500/10 hover:shadow-blue-500/25 transition-premium flex items-center gap-1.5">
                            Masuk Dashboard
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                    @else
                        <a href="{{ route('login') }}" 
                           class="px-4 py-2 text-sm font-medium text-slate-600 hover:text-slate-900 transition-premium">
                            Log in
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" 
                               class="px-4.5 py-2 rounded-xl border border-slate-200 hover:border-slate-300 text-slate-700 text-sm font-medium bg-white shadow-sm transition-premium">
                                Register
                            </a>
                        @endif
                    @endauth
                @endif
            </nav>
        </header>

        <!-- Main Hero Section (Centered Layout) -->
        <main class="flex-1 w-full max-w-4xl mx-auto px-6 flex flex-col items-center justify-center text-center py-20 lg:py-28 relative z-10 gap-8">
            
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-blue-500/10 border border-blue-500/20 text-blue-600 text-sm font-semibold tracking-wide">
                <span class="flex h-2 w-2 relative">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                </span>
                Interactive Training Portal
            </div>
            
            <h1 class="font-outfit text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight tracking-tight text-slate-900 max-w-3xl">
                Kuasai Kompetensi <br>
                <span class="bg-gradient-to-r from-blue-600 via-indigo-600 to-blue-500 bg-clip-text text-transparent">Garbarata</span> Interaktif
            </h1>
            
            <p class="text-base sm:text-base text-slate-600 leading-relaxed max-w-2xl">
                Portal belajar mandiri terlengkap mengenai sistem mekanikal, elektrikal, perakitan Rotunda & Cabin, serta standardisasi suku cadang Passenger Boarding Bridge (PBB).
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center mt-2 w-full sm:w-auto">
                @auth
                    <a href="{{ route('dashboard') }}"
                       style="display:inline-flex;align-items:center;justify-content:center;gap:0.5rem;padding:1rem 2rem;border-radius:0.75rem;background:linear-gradient(to right,#2563eb,#4f46e5);color:#fff;font-size:1rem;font-weight:600;text-decoration:none;box-shadow:0 4px 14px rgba(37,99,235,0.2);transition:opacity 0.3s;"
                       onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                        Mulai Belajar Sekarang
                        <svg style="width:1rem;height:1rem;flex-shrink:0;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       style="display:inline-flex;align-items:center;justify-content:center;gap:0.5rem;padding:1rem 2rem;border-radius:0.75rem;background:linear-gradient(to right,#2563eb,#4f46e5);color:#fff;font-size:1rem;font-weight:600;text-decoration:none;box-shadow:0 4px 14px rgba(37,99,235,0.2);transition:opacity 0.3s;"
                       onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                        Masuk &amp; Mulai Belajar
                        <svg style="width:1rem;height:1rem;flex-shrink:0;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                @endauth
                <a href="#features"
                   style="display:inline-flex;align-items:center;justify-content:center;gap:0.5rem;padding:1rem 2rem;border-radius:0.75rem;border:1px solid #e2e8f0;background:#fff;color:#475569;font-size:1rem;font-weight:500;text-decoration:none;box-shadow:0 1px 3px rgba(0,0,0,0.06);transition:border-color 0.3s, color 0.3s;"
                   onmouseover="this.style.borderColor='#94a3b8';this.style.color='#1e293b';" onmouseout="this.style.borderColor='#e2e8f0';this.style.color='#475569';">
                    Tinjau Fitur
                </a>
            </div>

            <!-- Stats counter -->
            <div class="grid grid-cols-3 gap-8 px-8 py-4 border border-slate-200/80 bg-white/60 backdrop-blur-md rounded-2xl mt-4 w-full max-w-lg mx-auto shadow-sm">
                <div>
                    <span class="block text-2xl font-bold text-slate-900 font-outfit">7 Bab</span>
                    <span class="text-[10px] uppercase tracking-wider text-slate-500">Materi Silabus</span>
                </div>
                <div class="border-x border-slate-200">
                    <span class="block text-2xl font-bold text-slate-900 font-outfit">50+</span>
                    <span class="text-[10px] uppercase tracking-wider text-slate-500">Soal Latihan</span>
                </div>
                <div>
                    <span class="block text-2xl font-bold text-slate-900 font-outfit">Lulus</span>
                    <span class="text-[10px] uppercase tracking-wider text-slate-500">Sertifikasi</span>
                </div>
            </div>
        </main>

        <!-- Features Highlights Section -->
        <section id="features" class="w-full max-w-7xl mx-auto px-6 py-20 relative z-10 border-t border-slate-200">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <h2 class="font-outfit text-3xl font-bold text-slate-900 mb-4">Fitur Utama Pembelajaran</h2>
                <p class="text-base text-slate-500">Dirancang secara khusus dengan fitur pendukung lengkap guna menjamin akselerasi pemahaman kompetensi operasional & pemeliharaan.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature Card 1 -->
                <div class="p-6 rounded-2xl light-card transition-premium flex flex-col gap-4">
                    <div class="w-10 h-10 rounded-xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center text-blue-600">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h3 class="font-outfit text-lg font-bold text-slate-900">7 Bab Silabus Terstruktur</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Kurikulum lengkap dari dasar pengenalan struktur Rotunda Assembly, Cabin, hingga langkah pemecahan masalah (Troubleshooting) operasional di lapangan.
                    </p>
                </div>

                <!-- Feature Card 2 -->
                <div class="p-6 rounded-2xl light-card transition-premium flex flex-col gap-4">
                    <div class="w-10 h-10 rounded-xl bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center text-indigo-600">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                    </div>
                    <h3 class="font-outfit text-lg font-bold text-slate-900">Bank Soal & Kuis Mandiri</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Evaluasi komprehensif dengan berbagai tipe soal ujian interaktif seperti pilihan ganda, benar/salah, menjodohkan bagian drawing, dan esai deskriptif.
                    </p>
                </div>

                <!-- Feature Card 3 -->
                <div class="p-6 rounded-2xl light-card transition-premium flex flex-col gap-4">
                    <div class="w-10 h-10 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-600">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                    </div>
                    <h3 class="font-outfit text-lg font-bold text-slate-900">Sertifikat Kompetensi Digital</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Bukti pencapaian akademik terverifikasi. Selesaikan seluruh materi modul dan lulus kuis penilaian akhir untuk mengklaim sertifikat kompetensi Anda.
                    </p>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="w-full max-w-7xl mx-auto px-6 py-8 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4 relative z-10 mt-auto text-slate-400 text-sm">
            <p>&copy; {{ date('Y') }} LMS Garbarata. Hak Cipta Dilindungi.</p>
            <p>Dirancang untuk Pembelajaran Mandiri Terintegrasi.</p>
        </footer>
    </body>
</html>
