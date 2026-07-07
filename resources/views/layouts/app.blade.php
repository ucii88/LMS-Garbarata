<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-slate-800 bg-[#f4f5f7]">
        <div x-data class="min-h-screen flex bg-[#f4f5f7]">
            <!-- Left Sidebar -->
            @include('layouts.sidebar')

            <!-- Right Content Area -->
            <div class="flex-1 flex flex-col min-h-screen overflow-y-auto">
                <!-- Topbar -->
                @include('layouts.topbar')

                <!-- Page Header (Optional) -->
                @isset($header)
                    <div class="bg-white border-b border-gray-100 py-4 px-8">
                        <div class="w-full">
                            {{ $header }}
                        </div>
                    </div>
                @endisset

                <!-- Main Page Content -->
                <main class="flex-1 py-8 px-8 w-full">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
