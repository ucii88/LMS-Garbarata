<x-guest-layout>
    <div class="text-center space-y-4">
        <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-600 mx-auto flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <h2 class="font-outfit text-xl font-bold text-slate-900 tracking-tight">{{ __('Lupa Kata Sandi?') }}</h2>
        <p class="text-sm text-slate-500 leading-relaxed">
            {{ __('Pengaturan ulang kata sandi akun LMS Garbarata dilakukan secara terpusat oleh sistem. Silakan hubungi atau konfirmasi langsung ke Administrator kelas LMS untuk mereset kata sandi Anda.') }}
        </p>
        <div class="pt-3">
            <a href="{{ route('login') }}" 
               class="inline-flex items-center justify-center w-full py-2.5 px-4 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl transition shadow-sm">
                &larr; {{ __('Kembali ke Halaman Masuk') }}
            </a>
        </div>
    </div>
</x-guest-layout>
