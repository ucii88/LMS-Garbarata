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

        {{-- Global Logout Confirmation Modal --}}
        <div id="logout-confirm-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
            <div class="bg-white rounded-2xl shadow-2xl p-6 max-w-sm w-full mx-4 border border-slate-100">
                <div class="text-center mb-5">
                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-rose-50 text-rose-600 text-2xl font-bold mb-3">
                        🚪
                    </div>
                    <h3 class="text-base font-bold text-slate-800">{{ __('Yakin ingin keluar?') }}</h3>
                    <p class="text-sm text-slate-500 mt-1">{{ __('Anda akan keluar dari sesi masuk LMS-Garbarata saat ini.') }}</p>
                </div>
                <div class="flex gap-3">
                    <button type="button" onclick="closeLogoutModal()"
                            class="flex-1 py-2.5 text-sm font-bold text-slate-600 border border-slate-200 rounded-xl hover:bg-slate-50 transition">
                        {{ __('Batal') }}
                    </button>
                    <button type="button" onclick="submitLogoutForm()"
                            class="flex-1 py-2.5 text-sm font-bold text-white bg-rose-600 hover:bg-rose-700 rounded-xl shadow-sm transition">
                        {{ __('Ya, Keluar') }}
                    </button>
                </div>
            </div>
        </div>

        {{-- Global Alert Modal --}}
        <div id="global-alert-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
            <div class="bg-white rounded-2xl shadow-2xl p-6 max-w-sm w-full mx-4 border border-slate-100">
                <div class="text-center mb-5">
                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-amber-50 text-amber-600 text-2xl font-bold mb-3">
                        📜
                    </div>
                    <h3 id="global-alert-title" class="text-base font-bold text-slate-800">{{ __('Pemberitahuan') }}</h3>
                    <p id="global-alert-message" class="text-xs text-slate-500 mt-2 leading-relaxed"></p>
                </div>
                <div>
                    <button type="button" onclick="closeGlobalAlertModal()"
                            class="w-full py-2.5 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-sm transition">
                        {{ __('Tutup') }}
                    </button>
                </div>
            </div>
        </div>

        {{-- Global Logout Form --}}
        <form id="global-logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
            @csrf
        </form>

        <script>
            function showGlobalAlert(title, message) {
                document.getElementById('global-alert-title').innerText = title;
                document.getElementById('global-alert-message').innerText = message;
                document.getElementById('global-alert-modal').classList.remove('hidden');
            }

            function closeGlobalAlertModal() {
                document.getElementById('global-alert-modal').classList.add('hidden');
            }

            // Close global alert modal when clicking outside the dialog card
            document.getElementById('global-alert-modal').addEventListener('click', function(event) {
                if (event.target === this) {
                    closeGlobalAlertModal();
                }
            });

            function openLogoutModal(event) {
                if (event) {
                    event.preventDefault();
                }
                document.getElementById('logout-confirm-modal').classList.remove('hidden');
            }

            function closeLogoutModal() {
                document.getElementById('logout-confirm-modal').classList.add('hidden');
            }

            // Close modal when clicking outside the dialog card
            document.getElementById('logout-confirm-modal').addEventListener('click', function(event) {
                if (event.target === this) {
                    closeLogoutModal();
                }
            });

            function submitLogoutForm() {
                const form = document.getElementById('global-logout-form');
                if (form) {
                    form.submit();
                }
            }
        </script>
    </body>
</html>
