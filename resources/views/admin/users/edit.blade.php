@section('topbar_title', 'Edit Pengguna')

<x-app-layout>
    <div class="max-w-2xl mx-auto space-y-6">
        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-sm text-slate-400" aria-label="Breadcrumb">
            <a href="{{ route('admin.users.index') }}" class="font-semibold hover:text-slate-600 transition">Kelola Pengguna</a>
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            <span class="text-slate-600 font-semibold truncate max-w-[200px]">{{ $user->name }}</span>
        </nav>

        {{-- Page Header --}}
        <section class="relative rounded-2xl overflow-hidden bg-gradient-to-r from-slate-900 via-slate-800 to-indigo-950 p-7 shadow-sm border border-slate-800">
            <div class="absolute inset-0 opacity-15 bg-[radial-gradient(#4f46e5_1px,transparent_1px)] [background-size:16px_16px] pointer-events-none"></div>
            <div class="relative z-10 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl {{ $user->role === 'admin' ? 'bg-rose-500' : ($user->role === 'instruktur' ? 'bg-amber-500' : 'bg-blue-500') }} flex items-center justify-center text-white text-lg font-black shadow-sm shrink-0">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div>
                    <span class="inline-flex items-center rounded-full bg-indigo-500/10 px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider text-indigo-400 border border-indigo-500/20 mb-1">
                        Edit Pengguna
                    </span>
                    <h1 class="text-xl font-extrabold tracking-tight text-white">{{ $user->name }}</h1>
                    <p class="text-sm text-slate-400 mt-0.5">{{ $user->email }} · Terdaftar {{ $user->created_at->format('d M Y') }}</p>
                </div>
            </div>
        </section>

        {{-- Edit Form --}}
        <section class="rounded-2xl border border-[#f0f0f0] bg-white shadow-sm overflow-hidden">
            <div class="border-b border-[#f0f0f0] px-6 py-4">
                <h2 class="text-base font-bold text-slate-800">Informasi Pengguna</h2>
                <p class="text-[10px] text-slate-400 mt-0.5">Perbarui nama, email, dan peran pengguna.</p>
            </div>

            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="px-6 py-5 space-y-5 text-sm text-slate-700">
                @csrf
                @method('PUT')

                {{-- Name --}}
                <div class="space-y-1.5">
                    <label for="edit_name" class="block text-sm font-bold text-slate-700">
                        Nama Lengkap
                        <span class="font-medium text-slate-400">(opsional)</span>
                    </label>
                    <input
                        type="text"
                        name="name"
                        id="edit_name"
                        value="{{ old('name', $user->name) }}"
                        placeholder="Masukkan nama lengkap"
                        class="block w-full rounded-lg border-slate-200 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('name') border-rose-300 focus:border-rose-500 focus:ring-rose-500 @enderror"
                    >
                    @error('name')
                        <p class="text-[10px] font-semibold text-rose-600 flex items-center gap-1">
                            <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="space-y-1.5">
                    <label for="edit_email" class="block text-sm font-bold text-slate-700">Alamat Email</label>
                    <input
                        type="email"
                        name="email"
                        id="edit_email"
                        value="{{ old('email', $user->email) }}"
                        required
                        placeholder="nama@contoh.com"
                        class="block w-full rounded-lg border-slate-200 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('email') border-rose-300 focus:border-rose-500 focus:ring-rose-500 @enderror"
                    >
                    @error('email')
                        <p class="text-[10px] font-semibold text-rose-600 flex items-center gap-1">
                            <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Role --}}
                <div class="space-y-1.5">
                    <label for="edit_role" class="block text-sm font-bold text-slate-700">Peran</label>
                    <select
                        name="role"
                        id="edit_role"
                        required
                        class="block w-full rounded-lg border-slate-200 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('role') border-rose-300 @enderror"
                    >
                        <option value="peserta"    @selected(old('role', $user->role) === 'peserta')>Peserta</option>
                        <option value="instruktur" @selected(old('role', $user->role) === 'instruktur')>Instruktur</option>
                        <option value="admin"      @selected(old('role', $user->role) === 'admin')>Admin</option>
                    </select>
                    @error('role')
                        <p class="text-[10px] font-semibold text-rose-600 flex items-center gap-1">
                            <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Divider --}}
                <div class="border-t border-[#f0f0f0] pt-5 space-y-1">
                    <h3 class="text-sm font-bold text-slate-800">Ganti Password</h3>
                    <p class="text-[10px] text-slate-400">Kosongkan jika tidak ingin mengubah password.</p>
                </div>

                {{-- New Password --}}
                <div class="space-y-1.5" x-data="{ showPwd: false }">
                    <label for="edit_password" class="block text-sm font-bold text-slate-700">Password Baru</label>
                    <div class="relative">
                        <input
                            :type="showPwd ? 'text' : 'password'"
                            name="password"
                            id="edit_password"
                            placeholder="Minimal 8 karakter"
                            autocomplete="new-password"
                            class="block w-full rounded-lg border-slate-200 pr-10 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('password') border-rose-300 focus:border-rose-500 focus:ring-rose-500 @enderror"
                        >
                        <button
                            type="button"
                            @click="showPwd = !showPwd"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition"
                            tabindex="-1"
                        >
                            <svg x-show="!showPwd" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg x-show="showPwd" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-[10px] font-semibold text-rose-600 flex items-center gap-1">
                            <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div class="space-y-1.5" x-data="{ showConfirm: false }">
                    <label for="edit_password_confirmation" class="block text-sm font-bold text-slate-700">Konfirmasi Password Baru</label>
                    <div class="relative">
                        <input
                            :type="showConfirm ? 'text' : 'password'"
                            name="password_confirmation"
                            id="edit_password_confirmation"
                            placeholder="Ulangi password baru"
                            autocomplete="new-password"
                            class="block w-full rounded-lg border-slate-200 pr-10 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        >
                        <button
                            type="button"
                            @click="showConfirm = !showConfirm"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition"
                            tabindex="-1"
                        >
                            <svg x-show="!showConfirm" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg x-show="showConfirm" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                        </button>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex flex-col-reverse gap-3 border-t border-[#f0f0f0] pt-5 sm:flex-row sm:justify-between">
                    <a
                        href="{{ route('admin.users.index') }}"
                        class="inline-flex items-center justify-center gap-1.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 px-5 py-2.5 text-sm font-bold text-slate-600 transition"
                    >
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Kembali
                    </a>
                    <button
                        type="submit"
                        class="inline-flex items-center justify-center gap-1.5 rounded-xl bg-blue-600 hover:bg-blue-700 px-6 py-2.5 text-sm font-bold text-white transition shadow-sm"
                    >
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </section>
    </div>
</x-app-layout>
