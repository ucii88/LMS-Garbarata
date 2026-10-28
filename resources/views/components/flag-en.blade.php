@props(['class' => 'w-4 h-2.5'])
@php
    $uniqueId = 'uk-' . \Illuminate\Support\Str::random(8);
    $clipId = 'clip-' . $uniqueId;
    $pinwheelId = 'pin-' . $uniqueId;
@endphp

<span {{ $attributes->merge(['class' => $class . ' inline-flex items-center justify-center shrink-0 rounded-[2px] overflow-hidden ring-1 ring-black/10 shadow-[0_1px_2px_rgba(0,0,0,0.04)]']) }}>
    <svg class="w-full h-full block" viewBox="0 0 60 30" preserveAspectRatio="none" aria-hidden="true">
        <defs>
            <clipPath id="{{ $clipId }}">
                <rect width="60" height="30" />
            </clipPath>
            <clipPath id="{{ $pinwheelId }}">
                <path d="M30,15 L60,15 L60,30 Z M30,15 L30,30 L0,30 Z M30,15 L0,15 L0,0 Z M30,15 L30,0 L60,0 Z"/>
            </clipPath>
        </defs>
        <g clip-path="url(#{{ $clipId }})">
            <path d="M0,0 v30 h60 v-30 z" fill="#012169"/>
            <path d="M0,0 L60,30 M60,0 L0,30" stroke="#FFFFFF" stroke-width="6"/>
            <path d="M0,0 L60,30 M60,0 L0,30" clip-path="url(#{{ $pinwheelId }})" stroke="#C8102E" stroke-width="4"/>
            <path d="M30,0 v30 M0,15 h60" stroke="#FFFFFF" stroke-width="10"/>
            <path d="M30,0 v30 M0,15 h60" stroke="#C8102E" stroke-width="6"/>
        </g>
    </svg>
</span>
