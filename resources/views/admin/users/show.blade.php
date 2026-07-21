@section('topbar_title', 'Detail Pengguna')

<x-app-layout>
    <div class="space-y-6">
        {{-- Page Header --}}
        <section class="relative rounded-2xl overflow-hidden bg-gradient-to-r from-slate-900 via-slate-800 to-indigo-950 p-8 shadow-sm border border-slate-800">
            <div class="absolute inset-0 opacity-15 bg-[radial-gradient(#4f46e5_1px,transparent_1px)] [background-size:16px_16px] pointer-events-none"></div>
            <div class="relative z-10 flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                <div class="space-y-2">
                    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1 text-[10px] font-bold tracking-wider text-white border border-white/20 hover:bg-white/20 transition">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Kembali ke Daftar
                    </a>
                    <h1 class="text-2xl font-extrabold tracking-tight text-white mt-3">Detail Pengguna: {{ $user->name }}</h1>
                    <h1 class="text-2xl font-extrabold tracking-tight text-white mt-3">{{ __('Detail Pengguna') }}: {{ $user->name }}</h1>
                    <p class="text-sm text-slate-300 leading-relaxed">{{ $user->email }} &bull; {{ __('Peran') }}: <span class="capitalize font-bold">{{ $user->role }}</span></p>
                </div>
            </div>
        </section>

        {{-- Quiz & Exam History --}}
        <section class="rounded-2xl border border-[#f0f0f0] bg-white shadow-sm overflow-hidden">
            <div class="border-b border-[#f0f0f0] px-6 py-4">
                <h2 class="text-base font-bold text-slate-800">{{ __('Riwayat Quiz & Ujian') }}</h2>
                <p class="text-[10px] text-slate-400 mt-0.5">{{ __('Daftar semua quiz dan ujian akhir yang pernah diikuti.') }}</p>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-[#f0f0f0] text-left text-sm">
                    <thead class="bg-gray-50">
                        <tr class="text-[10px] font-bold uppercase tracking-wider text-slate-500">
                            <th class="px-5 py-3">{{ __('Course / Chapter') }}</th>
                            <th class="px-5 py-3">{{ __('Tipe') }}</th>
                            <th class="px-5 py-3">{{ __('Tanggal') }}</th>
                            <th class="px-5 py-3 text-center">{{ __('Skor') }}</th>
                            <th class="px-5 py-3 text-center">{{ __('Status') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#f0f0f0] bg-white text-slate-700">
                        @forelse ($quizAttempts as $attempt)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="px-5 py-3.5">
                                    <div class="font-bold text-slate-800">{{ $attempt->quiz->course->title ?? '-' }}</div>
                                    <div class="text-[11px] text-slate-500">{{ $attempt->quiz->chapter ? $attempt->quiz->chapter->title : __('Ujian Akhir Course') }}</div>
                                </td>
                                <td class="px-5 py-3.5">
                                    <span class="inline-flex rounded-full border px-2.5 py-0.5 text-[10px] font-bold capitalize {{ $attempt->quiz->activity_type === 'quiz' && is_null($attempt->quiz->chapter_id) ? 'bg-purple-50 text-purple-600 border-purple-100' : 'bg-blue-50 text-blue-600 border-blue-100' }}">
                                        {{ $attempt->quiz->activity_type === 'quiz' && is_null($attempt->quiz->chapter_id) ? __('Ujian Akhir') : __('Quiz Chapter') }}
                                    </span>
                                </td>
                                <td class="px-5 py-3.5 text-slate-500">
                                    {{ $attempt->submitted_at ? $attempt->submitted_at->format('d M Y, H:i') : '-' }}
                                </td>
                                <td class="px-5 py-3.5 text-center">
                                    <span class="font-bold text-slate-800">{{ round($attempt->score, 2) }}</span>
                                </td>
                                <td class="px-5 py-3.5 text-center">
                                    @if($attempt->is_passed)
                                        <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2 py-0.5 text-[10px] font-bold text-emerald-600 border border-emerald-200">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>{{ __('Lulus') }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 rounded-full bg-rose-50 px-2 py-0.5 text-[10px] font-bold text-rose-600 border border-rose-200">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>{{ __('Gagal') }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-10 text-center text-sm text-slate-400">
                                    {{ __('Tidak ada riwayat quiz atau ujian.') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        {{-- Certificates --}}
        <section class="rounded-2xl border border-[#f0f0f0] bg-white shadow-sm overflow-hidden">
            <div class="border-b border-[#f0f0f0] px-6 py-4">
                <h2 class="text-base font-bold text-slate-800">Sertifikat</h2>
                <p class="text-[10px] text-slate-400 mt-0.5">Sertifikat yang berhasil diperoleh pengguna ini.</p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 p-5">
                @forelse ($certificates as $cert)
                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 shadow-sm flex flex-col items-center text-center">
                        <svg class="w-12 h-12 text-amber-500 mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        <h3 class="font-bold text-slate-800 text-sm mb-1">{{ $cert->course->title ?? 'Course' }}</h3>
                        <p class="text-[10px] text-slate-500 mb-3">Kode: {{ $cert->certificate_code }}<br>Diterbitkan: {{ $cert->issued_at->format('d M Y') }}</p>
                        <a href="{{ route('admin.certificates.download', $cert->id) }}" target="_blank" class="w-full inline-flex items-center justify-center gap-1 rounded-lg bg-indigo-600 hover:bg-indigo-700 px-3 py-1.5 text-xs font-bold text-white transition shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            Download Sertifikat
                        </a>
                    </div>
                @empty
                    <div class="col-span-full py-10 text-center text-sm text-slate-400">
                        Belum ada sertifikat.
                    </div>
                @endforelse
            </div>
        </section>
    </div>
</x-app-layout>
