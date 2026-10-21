@props(['type' => 'success', 'message' => null, 'duration' => 3000])

@php
    $isSuccess = $type === 'success';
    $msg = $message ?? ($isSuccess ? session('success') : session('error'));
@endphp

@if ($msg)
    <div x-data="{ show: true }"
         x-show="show"
         x-init="setTimeout(() => show = false, {{ $duration }})"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="rounded-xl p-4 text-sm font-medium flex items-center justify-between gap-3 shadow-sm border transition {{ $isSuccess ? 'bg-emerald-50 border-emerald-200 text-emerald-800' : 'bg-rose-50 border-rose-200 text-rose-800' }}">
        <div class="flex items-center gap-2.5 min-w-0">
            @if ($isSuccess)
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            @else
                <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            @endif
            <span class="break-words">{{ __($msg) }}</span>
        </div>
        <button type="button" @click="show = false" class="p-1 rounded-lg transition shrink-0 cursor-pointer {{ $isSuccess ? 'text-emerald-500 hover:text-emerald-800 hover:bg-emerald-100' : 'text-rose-500 hover:text-rose-800 hover:bg-rose-100' }}" title="{{ __('Tutup') }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>
@endif
