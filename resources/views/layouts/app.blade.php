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
                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-rose-50 text-rose-600 font-bold mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-800">{{ __('Are you sure you want to log out?') }}</h3>
                    <p class="text-sm text-slate-500 mt-1">{{ __('You will be signed out of your current LMS-Garbarata session.') }}</p>
                </div>
                <div class="flex gap-3">
                    <button type="button" onclick="closeLogoutModal()"
                            class="flex-1 py-2.5 text-sm font-bold text-slate-600 border border-slate-200 rounded-xl hover:bg-slate-50 transition">
                        {{ __('Cancel') }}
                    </button>
                    <button type="button" onclick="submitLogoutForm()"
                            class="flex-1 py-2.5 text-sm font-bold text-white bg-rose-600 hover:bg-rose-700 rounded-xl shadow-sm transition">
                        {{ __('Yes, Log Out') }}
                    </button>
                </div>
            </div>
        </div>

        {{-- Global Confirm Action Modal --}}
        <div id="global-confirm-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
            <div class="bg-white rounded-2xl shadow-2xl p-6 max-w-sm w-full mx-4 border border-slate-100">
                <div class="text-center mb-5">
                    <div id="global-confirm-icon-bg" class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-rose-50 text-rose-600 font-bold mb-3">
                        <svg id="global-confirm-icon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </div>
                    <h3 id="global-confirm-title" class="text-base font-bold text-slate-800">{{ __('Konfirmasi Tindakan') }}</h3>
                    <p id="global-confirm-message" class="text-sm text-slate-500 mt-1 leading-relaxed"></p>
                </div>
                <div class="flex gap-3">
                    <button type="button" onclick="closeGlobalConfirmModal(false)"
                            class="flex-1 py-2.5 text-sm font-bold text-slate-600 border border-slate-200 rounded-xl hover:bg-slate-50 transition cursor-pointer">
                        {{ __('Batal') }}
                    </button>
                    <button type="button" id="global-confirm-btn" onclick="closeGlobalConfirmModal(true)"
                            class="flex-1 py-2.5 text-sm font-bold text-white bg-rose-600 hover:bg-rose-700 rounded-xl shadow-sm transition cursor-pointer">
                        {{ __('Ya, Lanjutkan') }}
                    </button>
                </div>
            </div>
        </div>

        {{-- Global Alert Modal --}}
        <div id="global-alert-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
            <div class="bg-white rounded-2xl shadow-2xl p-6 max-w-sm w-full mx-4 border border-slate-100">
                <div class="text-center mb-5">
                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-amber-50 text-amber-600 font-bold mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 id="global-alert-title" class="text-base font-bold text-slate-800">{{ __('Pemberitahuan') }}</h3>
                    <p id="global-alert-message" class="text-xs text-slate-500 mt-2 leading-relaxed"></p>
                </div>
                <div>
                    <button type="button" onclick="closeGlobalAlertModal()"
                            class="w-full py-2.5 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-sm transition cursor-pointer">
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
            let globalConfirmCallback = null;

            function showGlobalConfirm(title, message, callback, btnText = '{{ __("Ya, Lanjutkan") }}', isDanger = true) {
                document.getElementById('global-confirm-title').innerText = title || '{{ __("Konfirmasi Tindakan") }}';
                document.getElementById('global-confirm-message').innerText = message || '{{ __("Apakah Anda yakin ingin melanjutkan tindakan ini?") }}';
                
                const btn = document.getElementById('global-confirm-btn');
                btn.innerText = btnText;
                if (isDanger) {
                    btn.className = 'flex-1 py-2.5 text-sm font-bold text-white bg-rose-600 hover:bg-rose-700 rounded-xl shadow-sm transition cursor-pointer';
                    document.getElementById('global-confirm-icon-bg').className = 'inline-flex items-center justify-center w-12 h-12 rounded-full bg-rose-50 text-rose-600 font-bold mb-3';
                } else {
                    btn.className = 'flex-1 py-2.5 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-sm transition cursor-pointer';
                    document.getElementById('global-confirm-icon-bg').className = 'inline-flex items-center justify-center w-12 h-12 rounded-full bg-blue-50 text-blue-600 font-bold mb-3';
                }

                globalConfirmCallback = callback;
                document.getElementById('global-confirm-modal').classList.remove('hidden');
            }

            function closeGlobalConfirmModal(confirmed) {
                document.getElementById('global-confirm-modal').classList.add('hidden');
                if (confirmed && typeof globalConfirmCallback === 'function') {
                    globalConfirmCallback();
                }
                globalConfirmCallback = null;
            }

            document.getElementById('global-confirm-modal').addEventListener('click', function(event) {
                if (event.target === this) {
                    closeGlobalConfirmModal(false);
                }
            });

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

            // Global listener for forms with data-confirm or native form confirm handler
            document.addEventListener('submit', function(e) {
                const form = e.target;
                const confirmMsg = form.getAttribute('data-confirm');
                if (confirmMsg && !form.dataset.confirmed) {
                    e.preventDefault();
                    showGlobalConfirm(
                        form.getAttribute('data-confirm-title') || '{{ __("Konfirmasi Hapus") }}',
                        confirmMsg,
                        function() {
                            form.dataset.confirmed = 'true';
                            form.submit();
                        },
                        form.getAttribute('data-confirm-btn') || '{{ __("Ya, Hapus") }}',
                        true
                    );
                }
            }, true);
        </script>
    </body>
</html>
