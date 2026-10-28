@props(['class' => 'w-4 h-2.5'])

<span {{ $attributes->merge(['class' => $class . ' inline-flex items-center justify-center shrink-0 rounded-[2px] overflow-hidden ring-1 ring-black/10 shadow-[0_1px_2px_rgba(0,0,0,0.04)]']) }}>
    <svg class="w-full h-full block" viewBox="0 0 3 2" preserveAspectRatio="none" aria-hidden="true">
        <rect width="3" height="1" fill="#CE1126"/>
        <rect y="1" width="3" height="1" fill="#FFFFFF"/>
    </svg>
</span>
