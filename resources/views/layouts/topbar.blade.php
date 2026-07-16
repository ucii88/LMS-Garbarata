<header class="bg-white border-b border-[#f0f0f0] h-16 flex items-center justify-between px-8 sticky top-0 z-40 select-none">
    <!-- Left Section: Dynamic Page Title -->
    <div class="flex items-center space-x-3">
        <h1 class="text-base font-bold text-slate-800 tracking-tight">
            @yield('topbar_title', 'Dashboard')
        </h1>
    </div>

    <!-- Right Section: Notification & User Menu -->
    <div class="flex items-center space-x-6">

        <!-- ── Notification Bell ─────────────────────────────── -->
        <div
            class="relative"
            x-data="notificationPanel()"
            x-init="init()"
            @click.outside="open = false"
        >
            <!-- Bell Button -->
            <button
                @click="toggleOpen()"
                class="relative text-gray-400 hover:text-gray-600 transition focus:outline-none"
                aria-label="Notifikasi"
            >
                <!-- Unread badge -->
                <span
                    x-show="unreadCount > 0"
                    x-text="unreadCount > 9 ? '9+' : unreadCount"
                    class="absolute -top-1.5 -right-1.5 min-w-[18px] h-[18px] px-0.5 rounded-full bg-red-500 text-white text-[9px] font-black flex items-center justify-center ring-2 ring-white leading-none"
                ></span>
                <!-- Red dot when no count yet loaded -->
                <span x-show="unreadCount === null" class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span>

                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
                </svg>
            </button>

            <!-- Dropdown Panel -->
            <div
                x-show="open"
                x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 scale-95 translate-y-1"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="absolute right-0 mt-3 w-80 rounded-2xl bg-white border border-[#f0f0f0] shadow-xl overflow-hidden z-50"
                style="display:none;"
            >
                <!-- Header -->
                <div class="flex items-center justify-between px-4 py-3 border-b border-[#f0f0f0] bg-slate-50/60">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold text-slate-800">Notifikasi</span>
                        <span x-show="unreadCount > 0" x-text="unreadCount" class="inline-flex items-center justify-center min-w-[18px] h-[18px] px-1 rounded-full bg-red-500 text-white text-[9px] font-black leading-none"></span>
                    </div>
                    <button
                        x-show="unreadCount > 0"
                        @click="markAllRead()"
                        class="text-[10px] font-bold text-blue-500 hover:text-blue-700 transition"
                    >
                        Tandai semua dibaca
                    </button>
                </div>

                <!-- List -->
                <div class="max-h-80 overflow-y-auto divide-y divide-[#f5f5f5]">
                    <!-- Loading state -->
                    <template x-if="loading">
                        <div class="flex items-center justify-center py-10">
                            <svg class="w-5 h-5 animate-spin text-slate-400" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                            </svg>
                        </div>
                    </template>

                    <!-- Empty state -->
                    <template x-if="!loading && notifications.length === 0">
                        <div class="flex flex-col items-center justify-center py-10 gap-2 text-slate-400">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
                            </svg>
                            <p class="text-xs font-semibold">Tidak ada notifikasi</p>
                        </div>
                    </template>

                    <!-- Notification items -->
                    <template x-for="notif in notifications" :key="notif.id">
                        <div
                            @click="clickNotif(notif)"
                            class="flex items-start gap-3 px-4 py-3 cursor-pointer transition hover:bg-slate-50"
                            :class="!notif.is_read ? 'bg-blue-50/40' : ''"
                        >
                            <!-- Icon -->
                            <div class="shrink-0 mt-0.5 w-7 h-7 rounded-lg flex items-center justify-center text-sm"
                                :class="{
                                    'bg-blue-100 text-blue-600':   notif.type === 'quiz_published',
                                    'bg-violet-100 text-violet-600': notif.type === 'practice_published',
                                    'bg-amber-100 text-amber-600': notif.type === 'exam_published',
                                    'bg-emerald-100 text-emerald-600': notif.type === 'submission',
                                    'bg-rose-100 text-rose-600':   notif.type === 'user_created',
                                }"
                            >
                                <!-- quiz_published -->
                                <template x-if="notif.type === 'quiz_published'">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                </template>
                                <!-- practice_published -->
                                <template x-if="notif.type === 'practice_published'">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m5-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </template>
                                <!-- exam_published -->
                                <template x-if="notif.type === 'exam_published'">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                </template>
                                <!-- submission -->
                                <template x-if="notif.type === 'submission'">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </template>
                                <!-- user_created -->
                                <template x-if="notif.type === 'user_created'">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                                </template>
                            </div>

                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-bold text-slate-800 leading-snug truncate" x-text="notif.title"></p>
                                <p class="text-[10px] text-slate-500 leading-relaxed mt-0.5 line-clamp-2" x-text="notif.body"></p>
                                <p class="text-[9px] font-semibold text-slate-400 mt-1" x-text="notif.time_ago"></p>
                            </div>

                            <!-- Unread dot -->
                            <span x-show="!notif.is_read" class="shrink-0 mt-1.5 w-2 h-2 rounded-full bg-blue-500"></span>
                        </div>
                    </template>
                </div>
            </div>
        </div>
        <!-- ── End Notification Bell ─────────────────────────── -->

        <!-- Profile Edit Link -->
        <a href="{{ route('profile.edit') }}" class="text-xs font-semibold text-gray-700 hover:text-blue-600 transition flex items-center space-x-2">
            @if(auth()->user()->avatar)
                <img src="{{ Storage::url(auth()->user()->avatar) }}" class="w-8 h-8 rounded-full object-cover border border-slate-200 shadow-sm" alt="Avatar">
            @else
                <div class="w-8 h-8 rounded-full bg-blue-100 border border-blue-200 flex items-center justify-center text-blue-600 font-bold shadow-sm">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
            @endif
            <span class="hidden md:inline">{{ auth()->user()->name }}</span>
        </a>
    </div>
</header>

<script>
function notificationPanel() {
    return {
        open: false,
        loading: false,
        notifications: [],
        unreadCount: null,
        pollingInterval: null,
        csrfToken: document.querySelector('meta[name="csrf-token"]')?.content ?? '',

        init() {
            this.fetch();
            // Polling setiap 30 detik
            this.pollingInterval = setInterval(() => this.fetch(), 30000);
        },

        async fetch() {
            try {
                const res = await window.fetch('{{ route("notifications.index") }}', {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                if (!res.ok) return;
                const data = await res.json();
                this.unreadCount   = data.unread_count;
                this.notifications = data.notifications;
            } catch (e) {
                // Gagal fetch — abaikan, coba lagi di polling berikutnya
            }
        },

        toggleOpen() {
            this.open = !this.open;
            if (this.open && this.notifications.length === 0) {
                this.loading = true;
                this.fetch().finally(() => { this.loading = false; });
            }
        },

        async clickNotif(notif) {
            if (!notif.is_read) {
                notif.is_read = true;
                this.unreadCount = Math.max(0, (this.unreadCount ?? 1) - 1);
                try {
                    await window.fetch(`/notifications/${notif.id}/read`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': this.csrfToken,
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                    });
                } catch (e) {}
            }
            if (notif.url && notif.url !== '#') {
                window.location.href = notif.url;
            }
            this.open = false;
        },

        async markAllRead() {
            this.notifications.forEach(n => n.is_read = true);
            this.unreadCount = 0;
            try {
                await window.fetch('{{ route("notifications.read-all") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': this.csrfToken,
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                });
            } catch (e) {}
        },
    };
}
</script>
