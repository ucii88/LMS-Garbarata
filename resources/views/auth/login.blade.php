<x-guest-layout>
    <!-- Welcome Header Inside Form -->
    <div class="text-center mb-2">
        <h2 class="font-outfit text-2xl font-bold text-slate-900 tracking-tight">Selamat Datang</h2>
        <p class="text-sm text-slate-500">Masukkan email & kata sandi untuk masuk ke kelas LMS</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4 text-sm font-semibold text-emerald-600 bg-emerald-50 border border-emerald-200 px-3 py-2.5 rounded-xl" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-4">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">Alamat Email</label>
            <div class="relative">
                <input id="email" 
                       class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-4 py-3 text-base text-slate-950 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200" 
                       type="email" 
                       name="email" 
                       value="{{ old('email') }}" 
                       placeholder="nama@email.com"
                       required 
                       autofocus 
                       autocomplete="username" />
            </div>
            @if ($errors->has('email'))
                <p class="text-[11px] text-rose-600 mt-1 font-medium">{{ $errors->first('email') }}</p>
            @endif
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="block text-sm font-semibold text-slate-700">Kata Sandi</label>
                @if (Route::has('password.request'))
                    <a class="text-[11px] text-blue-600 hover:text-blue-500 transition duration-200 font-medium" 
                       href="{{ route('password.request') }}">
                        Lupa sandi?
                    </a>
                @endif
            </div>
            <div class="relative">
                <input id="password" 
                       class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-4 py-3 text-base text-slate-950 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200" 
                       type="password" 
                       name="password" 
                       placeholder="••••••••"
                       required 
                       autocomplete="current-password" />
            </div>
            @if ($errors->has('password'))
                <p class="text-[11px] text-rose-600 mt-1 font-medium">{{ $errors->first('password') }}</p>
            @endif
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between mt-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer select-none">
                <input id="remember_me" 
                       type="checkbox" 
                       class="rounded border-slate-300 bg-white text-blue-600 focus:ring-blue-500 w-4 h-4 cursor-pointer" 
                       name="remember">
                <span class="ms-2.5 text-sm text-slate-500 hover:text-slate-700 transition duration-200">Ingat saya di perangkat ini</span>
            </label>
        </div>

        <!-- Submit Action -->
        <div class="mt-2">
            <button type="submit"
                    style="background: linear-gradient(to right, #2563eb, #4f46e5); color: #fff; width: 100%; padding: 0.75rem 1.25rem; border-radius: 0.75rem; font-size: 1rem; font-weight: 600; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.5rem; box-shadow: 0 4px 14px rgba(37,99,235,0.25); transition: box-shadow 0.3s, opacity 0.3s;"
                    onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                <span>Masuk Sekarang</span>
                <svg style="width:1rem;height:1rem;flex-shrink:0;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </button>
        </div>
        
        <!-- Registration Route Link -->
        @if (Route::has('register'))
            <p class="text-sm text-slate-500 text-center mt-3">
                Belum terdaftar? 
                <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-500 font-semibold transition duration-200">Buat akun baru</a>
            </p>
        @endif
    </form>
</x-guest-layout>
