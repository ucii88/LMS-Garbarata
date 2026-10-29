<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

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
            /* Clean container styling for light mode */
            .light-container {
                background: #FFFFFF;
                border: 1px solid #E2E8F0;
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.03);
            }
            /* Custom background grid pattern for light mode */
            .bg-grid-pattern {
                background-size: 40px 40px;
                background-image: linear-gradient(to right, rgba(148, 163, 184, 0.05) 1px, transparent 1px),
                                  linear-gradient(to bottom, rgba(148, 163, 184, 0.05) 1px, transparent 1px);
            }
        </style>
    </head>
    <body class="text-slate-800 antialiased min-h-screen flex items-center justify-center p-6 relative overflow-x-hidden bg-grid-pattern">
        
        <!-- Soft Ambient Lights -->
        <div class="absolute top-[-20%] left-[-10%] w-[60%] h-[60%] bg-blue-600/5 rounded-full blur-[140px] pointer-events-none"></div>
        <div class="absolute bottom-[-20%] right-[-10%] w-[60%] h-[60%] bg-blue-600/5 rounded-full blur-[140px] pointer-events-none"></div>

        <div class="w-full max-w-md flex flex-col items-center gap-6 relative z-10">
            <!-- Header Brand Logo -->
            <a href="/" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-[#0091ff] to-[#40a9ff] flex items-center justify-center shadow-md shadow-[#0091ff]/25 group-hover:scale-105 transition duration-300">
                    <svg class="w-5.5 h-5.5 text-white transform -rotate-12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"></path>
                    </svg>
                </div>
                <span class="font-outfit font-extrabold text-2xl tracking-tight text-slate-900">GARBAR<span class="text-[#0091ff]">ATA</span></span>
            </a>

            <!-- Form Wrapper Container -->
            <div class="w-full p-8 rounded-3xl light-container flex flex-col gap-6">
                {{ $slot }}
            </div>

            <!-- Simple Nav Link Back to Welcome -->
            <a href="/" class="text-sm text-slate-400 hover:text-slate-600 transition duration-300 flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                {{ __('Kembali ke Beranda') }}
            </a>
        </div>
    </body>
</html>
