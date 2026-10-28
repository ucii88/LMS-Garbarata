@section('topbar_title', __('Konfigurasi Sertifikat'))

<x-app-layout>
    <div class="space-y-6">

        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-3.5 text-sm text-emerald-700">
                <svg class="w-5 h-5 shrink-0 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- Page Header --}}
        <section class="relative rounded-2xl overflow-hidden bg-gradient-to-r from-slate-900 via-slate-800 to-amber-950 p-8 shadow-sm border border-slate-800">
            <div class="absolute inset-0 opacity-15 bg-[radial-gradient(#f59e0b_1px,transparent_1px)] [background-size:16px_16px] pointer-events-none"></div>
            <div class="relative z-10 flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
                <div class="space-y-2">
                    <span class="inline-flex items-center rounded-full bg-amber-500/10 px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-amber-400 border border-amber-500/20">
                        {{ __('Admin Panel') }}
                    </span>
                    <h1 class="text-2xl font-extrabold tracking-tight text-white">{{ __('Konfigurasi Sertifikat') }}</h1>
                    <p class="text-sm text-slate-300 leading-relaxed">{{ __('Atur template, tanda tangan, dan branding sertifikat untuk setiap kursus.') }}</p>
                </div>
            </div>
        </section>

        {{-- Stats --}}
        @php
            $configured = $courses->filter(fn($c) => $c->certificateConfiguration !== null)->count();
            $total = $courses->count();
        @endphp
        <section class="grid grid-cols-2 gap-4 lg:grid-cols-3">
            <article class="rounded-xl border border-[#f0f0f0] border-l-4 border-l-slate-400 bg-white p-5 shadow-sm">
                <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400">{{ __('Total Kursus') }}</p>
                <p class="text-2xl font-extrabold text-slate-800 mt-1">{{ $total }}</p>
            </article>
            <article class="rounded-xl border border-[#f0f0f0] border-l-4 border-l-emerald-500 bg-white p-5 shadow-sm">
                <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400">{{ __('Sudah Dikonfigurasi') }}</p>
                <p class="text-2xl font-extrabold text-slate-800 mt-1">{{ $configured }}</p>
            </article>
            <article class="rounded-xl border border-[#f0f0f0] border-l-4 border-l-amber-500 bg-white p-5 shadow-sm">
                <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400">{{ __('Belum Dikonfigurasi') }}</p>
                <p class="text-2xl font-extrabold text-slate-800 mt-1">{{ $total - $configured }}</p>
            </article>
        </section>

        {{-- Tabel Kursus --}}
        <section class="rounded-2xl border border-[#f0f0f0] bg-white shadow-sm overflow-hidden">
            <div class="border-b border-[#f0f0f0] px-6 py-4">
                <h2 class="text-base font-bold text-slate-800">{{ __('Daftar Kursus') }}</h2>
                <p class="text-[10px] text-slate-400 mt-0.5">{{ __('Klik "Atur Sertifikat" untuk mengkonfigurasi template dan tanda tangan.') }}</p>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-[#f0f0f0] text-left text-sm">
                    <thead class="bg-gray-50">
                        <tr class="text-[10px] font-bold uppercase tracking-wider text-slate-500">
                            <th class="px-5 py-3">{{ __('Nama Kursus') }}</th>
                            <th class="px-5 py-3">{{ __('Template') }}</th>
                            <th class="px-5 py-3">{{ __('Instruktur') }}</th>
                            <th class="px-5 py-3">{{ __('Status') }}</th>
                            <th class="px-5 py-3 text-right">{{ __('Aksi') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#f0f0f0] bg-white text-slate-700">
                        @forelse ($courses as $course)
                            @php
                                $cfg = $course->certificateConfiguration;
                                $isConfigured = $cfg !== null;
                                $templateLabels = [
                                    'garbarata_default' => 'Default Garbarata',
                                    'current_style' => 'Current Style',
                                    'elegant_classic_1' => 'Elegant Classic 1',
                                ];
                            @endphp
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        @if ($course->thumbnail && ($thumbnailData = app(\App\Services\SignatureService::class)->toDataUri($course->thumbnail)))
                                            <img src="{{ $thumbnailData }}" alt="" class="w-8 h-8 rounded-lg object-cover shrink-0">
                                        @else
                                            <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center shrink-0">
                                                <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                            </div>
                                        @endif
                                        <span class="font-semibold text-slate-800">{{ $course->title }}</span>
                                    </div>
                                </td>
                                <td class="px-5 py-4 text-slate-500">
                                    @if ($isConfigured)
                                        <span class="text-xs font-medium text-slate-700">
                                            {{ __($templateLabels[$cfg->template_preset] ?? $cfg->template_preset) }}
                                        </span>
                                    @else
                                        <span class="text-xs text-slate-400 italic">—</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-slate-500">
                                    @if ($isConfigured && $cfg->instructor)
                                        <div class="flex items-center gap-2">
                                            <div class="w-6 h-6 rounded-full bg-amber-500 flex items-center justify-center text-white text-[9px] font-black shrink-0">
                                                {{ strtoupper(substr($cfg->instructor->name, 0, 1)) }}
                                            </div>
                                            <span class="text-xs font-medium text-slate-700">{{ $cfg->instructor->name }}</span>
                                        </div>
                                    @else
                                        <span class="text-xs text-slate-400 italic">{{ __('Belum ditentukan') }}</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4">
                                    @if ($isConfigured)
                                        <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 border border-emerald-100 text-emerald-600 px-2.5 py-0.5 text-[10px] font-bold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            {{ __('Sudah Dikonfigurasi') }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 border border-amber-100 text-amber-600 px-2.5 py-0.5 text-[10px] font-bold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                                            {{ __('Belum Dikonfigurasi') }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        @if ($isConfigured)
                                            <a href="{{ route('admin.certificate-config.preview', $course) }}"
                                               target="_blank"
                                               class="inline-flex items-center gap-1 rounded-lg border border-indigo-200 bg-white hover:bg-indigo-50 px-2.5 py-1 text-[10px] font-bold text-indigo-600 transition">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                {{ __('Preview') }}
                                            </a>
                                        @endif
                                        <a href="{{ route('admin.certificate-config.show', $course) }}"
                                           class="inline-flex items-center gap-1 rounded-lg border border-amber-200 bg-amber-50 hover:bg-amber-100 px-2.5 py-1 text-[10px] font-bold text-amber-700 transition">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            {{ __('Atur Sertifikat') }}
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-10 text-center text-sm text-slate-400">
                                    <div class="flex flex-col items-center gap-2">
                                        <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                        <span>{{ __('Belum ada kursus tersedia.') }}</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</x-app-layout>
