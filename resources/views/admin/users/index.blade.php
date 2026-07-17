@section('topbar_title', 'Kelola Pengguna')

<x-app-layout>
    @php
        $toneMap = [
            'admin'      => ['badge' => 'bg-rose-50 text-rose-600 border-rose-100'],
            'instruktur' => ['badge' => 'bg-amber-50 text-amber-600 border-amber-100'],
            'peserta'    => ['badge' => 'bg-blue-50 text-blue-600 border-blue-100'],
        ];
    @endphp

    <div
        class="space-y-6"
        x-data="{
            showModal: {{ session('showModal') || $errors->any() ? 'true' : 'false' }},
            deleteUserId: null,
            deleteUserName: ''
        }"
    >
        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="rounded-xl border border-emerald-100 bg-emerald-50/60 p-4 text-sm font-semibold text-emerald-800 shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="rounded-xl border border-rose-100 bg-rose-50/60 p-4 text-sm font-semibold text-rose-800 shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4 text-rose-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        {{-- Page Header --}}
        <section class="relative rounded-2xl overflow-hidden bg-gradient-to-r from-slate-900 via-slate-800 to-indigo-950 p-8 shadow-sm border border-slate-800">
            <div class="absolute inset-0 opacity-15 bg-[radial-gradient(#4f46e5_1px,transparent_1px)] [background-size:16px_16px] pointer-events-none"></div>
            <div class="relative z-10 flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                <div class="space-y-2">
                    <span class="inline-flex items-center rounded-full bg-indigo-500/10 px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-indigo-400 border border-indigo-500/20">
                        Admin Panel
                    </span>
                    <h1 class="text-2xl font-extrabold tracking-tight text-white">Kelola Pengguna</h1>
                    <p class="text-sm text-slate-300 leading-relaxed">Tambah, edit, dan hapus akun pengguna sistem LMS Garbarata.</p>
                </div>
                <button
                    @click="showModal = true"
                    class="shrink-0 inline-flex items-center justify-center gap-2 rounded-xl bg-white hover:bg-slate-100 text-slate-900 px-5 py-3 text-sm font-bold transition-all shadow-sm border border-slate-200"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    Tambah Pengguna
                </button>
            </div>
        </section>

        {{-- Stats Cards --}}
        <section class="grid grid-cols-2 gap-4 lg:grid-cols-4">
            @foreach ([
                ['label' => 'Total Pengguna', 'value' => $counts['total'],      'color' => 'border-l-slate-400',   'icon' => 'text-slate-500',   'bg' => 'bg-slate-50'],
                ['label' => 'Admin',           'value' => $counts['admin'],      'color' => 'border-l-rose-500',    'icon' => 'text-rose-600',    'bg' => 'bg-rose-50'],
                ['label' => 'Instruktur',      'value' => $counts['instruktur'], 'color' => 'border-l-amber-500',   'icon' => 'text-amber-600',   'bg' => 'bg-amber-50'],
                ['label' => 'Peserta',         'value' => $counts['peserta'],    'color' => 'border-l-blue-500',    'icon' => 'text-blue-600',    'bg' => 'bg-blue-50'],
            ] as $card)
                <article class="rounded-xl border border-[#f0f0f0] border-l-4 {{ $card['color'] }} bg-white p-5 shadow-sm hover:shadow-md transition duration-200">
                    <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400">{{ $card['label'] }}</p>
                    <p class="text-2xl font-extrabold text-slate-800 mt-1">{{ $card['value'] }}</p>
                </article>
            @endforeach
        </section>

        {{-- Filter & Search --}}
        <section class="rounded-2xl border border-[#f0f0f0] bg-white p-5 shadow-sm">
            <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-col gap-3 sm:flex-row sm:items-center">
                <div class="relative flex-1">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input
                        type="text"
                        name="search"
                        value="{{ $search }}"
                        placeholder="Cari nama atau email..."
                        class="block w-full rounded-lg border-slate-200 pl-9 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    >
                </div>
                <select name="role" class="rounded-lg border-slate-200 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500 w-full sm:w-44">
                    <option value="">Semua Peran</option>
                    <option value="admin"      @selected($roleFilter === 'admin')>Admin</option>
                    <option value="instruktur" @selected($roleFilter === 'instruktur')>Instruktur</option>
                    <option value="peserta"    @selected($roleFilter === 'peserta')>Peserta</option>
                </select>
                <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-slate-900 hover:bg-slate-800 px-4 py-2 text-sm font-bold text-white transition shadow-sm w-full sm:w-auto">
                    Filter
                </button>
                @if($search || $roleFilter)
                    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center justify-center rounded-lg border border-slate-200 bg-white hover:bg-slate-50 px-4 py-2 text-sm font-bold text-slate-600 transition w-full sm:w-auto">
                        Reset
                    </a>
                @endif
                
                <a href="{{ route('admin.users.export', request()->query()) }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-emerald-500 hover:bg-emerald-600 px-4 py-2 text-sm font-bold text-white transition shadow-sm w-full sm:w-auto ml-auto">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                    Export Excel
                </a>
            </form>
        </section>

        {{-- Users Table --}}
        <section class="rounded-2xl border border-[#f0f0f0] bg-white shadow-sm overflow-hidden">
            <div class="flex items-center justify-between border-b border-[#f0f0f0] px-6 py-4">
                <div>
                    <h2 class="text-base font-bold text-slate-800">Daftar Pengguna</h2>
                    <p class="text-[10px] text-slate-400 mt-0.5">
                        Menampilkan {{ $users->firstItem() ?? 0 }}–{{ $users->lastItem() ?? 0 }} dari {{ $users->total() }} pengguna
                    </p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-[#f0f0f0] text-left text-sm">
                    <thead class="bg-gray-50">
                        <tr class="text-[10px] font-bold uppercase tracking-wider text-slate-500">
                            <th class="px-5 py-3">Nama</th>
                            <th class="px-5 py-3">Email</th>
                            <th class="px-5 py-3">Peran</th>
                            <th class="px-5 py-3">Terdaftar</th>
                            <th class="px-5 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#f0f0f0] bg-white text-slate-700">
                        @forelse ($users as $item)
                            @php
                                $badgeStyle = $toneMap[$item->role]['badge'] ?? 'bg-slate-100 text-slate-600 border-slate-200';
                                $isMe = $item->id === auth()->id();
                            @endphp
                            <tr class="transition hover:bg-slate-50/50 {{ $isMe ? 'bg-indigo-50/30' : '' }}">
                                <td class="px-5 py-3.5 font-bold text-slate-800">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-7 h-7 rounded-full {{ $item->role === 'admin' ? 'bg-rose-500' : ($item->role === 'instruktur' ? 'bg-amber-500' : 'bg-blue-500') }} flex items-center justify-center text-white text-[10px] font-black shrink-0">
                                            {{ strtoupper(substr($item->name, 0, 1)) }}
                                        </div>
                                        <span>{{ $item->name }}</span>
                                        @if($isMe)
                                            <span class="rounded-full bg-indigo-50 text-indigo-500 border border-indigo-100 px-1.5 py-0.5 text-[9px] font-bold">Anda</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-5 py-3.5 text-slate-500">{{ $item->email }}</td>
                                <td class="px-5 py-3.5">
                                    <span class="inline-flex rounded-full border px-2.5 py-0.5 text-[10px] font-bold capitalize {{ $badgeStyle }}">
                                        {{ $item->role }}
                                    </span>
                                </td>
                                <td class="px-5 py-3.5 text-slate-400">{{ $item->created_at->format('d M Y') }}</td>
                                <td class="px-5 py-3.5 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        {{-- Detail Button --}}
                                        @if($item->isPeserta())
                                            <a
                                                href="{{ route('admin.users.show', $item->id) }}"
                                                class="inline-flex items-center gap-1 rounded-lg border border-indigo-200 bg-white hover:bg-indigo-50 px-2.5 py-1 text-[10px] font-bold text-indigo-600 transition"
                                            >
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                Detail
                                            </a>
                                        @endif
                                        {{-- Edit Button --}}
                                        <a
                                            href="{{ route('admin.users.edit', $item->id) }}"
                                            class="inline-flex items-center gap-1 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 px-2.5 py-1 text-[10px] font-bold text-slate-600 transition"
                                        >
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            Edit
                                        </a>
                                        {{-- Delete Button --}}
                                        @if (!$isMe)
                                            <button
                                                type="button"
                                                @click="deleteUserId = {{ $item->id }}; deleteUserName = '{{ addslashes($item->name) }}'"
                                                class="inline-flex items-center gap-1 rounded-lg border border-rose-100 bg-rose-50 hover:bg-rose-100 px-2.5 py-1 text-[10px] font-bold text-rose-600 transition"
                                            >
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                Hapus
                                            </button>
                                        @else
                                            <span class="text-[10px] italic text-slate-400">—</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-10 text-center text-sm text-slate-400">
                                    <div class="flex flex-col items-center gap-2">
                                        <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                        <span>Tidak ada pengguna ditemukan.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($users->hasPages())
                <div class="border-t border-[#f0f0f0] px-5 py-4">
                    {{ $users->links() }}
                </div>
            @endif
        </section>

        {{-- Delete Confirmation Modal --}}
        <div
            x-show="deleteUserId !== null"
            class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm"
            style="display: none;"
            @keydown.escape.window="deleteUserId = null"
        >
            <div class="relative w-full max-w-sm mx-4 rounded-2xl bg-white border border-slate-200 shadow-2xl overflow-hidden">
                <div class="p-6 text-center space-y-3">
                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-rose-50 text-rose-500 mx-auto">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-900">Hapus Pengguna</h3>
                    <p class="text-sm text-slate-500">Anda akan menghapus akun <span class="font-bold text-slate-700" x-text="deleteUserName"></span>. Tindakan ini tidak dapat dibatalkan.</p>
                </div>
                <div class="flex gap-3 border-t border-slate-100 bg-slate-50 px-6 py-4">
                    <button
                        type="button"
                        @click="deleteUserId = null"
                        class="flex-1 py-2 text-sm font-bold text-slate-600 border border-slate-200 rounded-xl hover:bg-slate-100 transition"
                    >
                        Batal
                    </button>
                    <form :action="`/admin/users/${deleteUserId}`" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full py-2 text-sm font-bold text-white bg-rose-600 hover:bg-rose-700 rounded-xl shadow-sm transition">
                            Ya, Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Add User Modal --}}
        <div
            x-show="showModal"
            class="fixed inset-0 z-50 overflow-y-auto"
            aria-labelledby="add-user-modal-title"
            role="dialog"
            aria-modal="true"
            style="display: none;"
        >
            <div class="flex min-h-screen items-center justify-center px-4 py-10 text-center sm:block sm:p-0">
                <div
                    x-show="showModal"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="fixed inset-0 z-0 bg-slate-900/60"
                    @click="showModal = false"
                ></div>

                <span class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</span>

                <div
                    x-show="showModal"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="relative z-10 inline-block w-full max-w-md align-middle overflow-hidden rounded-2xl border border-slate-200 bg-white text-left shadow-2xl transition-all"
                >
                    <div class="border-b border-slate-100 px-6 py-5 flex items-center justify-between">
                        <div>
                            <h3 class="text-base font-bold text-slate-900" id="add-user-modal-title">Tambah Pengguna Baru</h3>
                            <p class="text-[10px] text-slate-400 mt-0.5">Buat akun admin, instruktur, atau peserta baru.</p>
                        </div>
                        <button type="button" @click="showModal = false" class="rounded-lg p-1 text-slate-400 hover:bg-slate-100 hover:text-slate-700 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <form id="addUserForm" action="{{ route('admin.users.store') }}" method="POST" class="space-y-4 px-6 py-5 text-sm text-slate-700">
                        @csrf

                        <div class="space-y-1">
                            <label for="name" class="block font-bold text-slate-700">Nama Lengkap <span class="font-medium text-slate-400">(opsional)</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" class="block w-full rounded-lg border-slate-200 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('name')
                                <p class="text-[10px] font-semibold text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1">
                            <label for="email" class="block font-bold text-slate-700">Alamat Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder="nama@contoh.com" class="block w-full rounded-lg border-slate-200 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('email')
                                <p class="text-[10px] font-semibold text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1">
                            <label for="password" class="block font-bold text-slate-700">Password</label>
                            <input type="password" name="password" id="password" required placeholder="Minimal 8 karakter" class="block w-full rounded-lg border-slate-200 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('password')
                                <p class="text-[10px] font-semibold text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1">
                            <label for="role" class="block font-bold text-slate-700">Peran</label>
                            <select name="role" id="role" required class="block w-full rounded-lg border-slate-200 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="peserta"    @selected(old('role') === 'peserta')>Peserta</option>
                                <option value="instruktur" @selected(old('role') === 'instruktur')>Instruktur</option>
                                <option value="admin"      @selected(old('role') === 'admin')>Admin</option>
                            </select>
                            @error('role')
                                <p class="text-[10px] font-semibold text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </form>

                    <div class="flex flex-col-reverse gap-2 border-t border-slate-100 bg-slate-50 px-6 py-4 sm:flex-row sm:justify-end text-sm">
                        <button type="button" @click="showModal = false" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2 font-bold text-slate-700 transition hover:bg-slate-50">
                            Batal
                        </button>
                        <button type="submit" form="addUserForm" class="inline-flex items-center justify-center rounded-lg bg-blue-600 hover:bg-blue-700 px-4 py-2 font-bold text-white transition shadow-sm">
                            Simpan Pengguna
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
