@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-base text-green-600']) }}>
        {{ __($status) }}
    </div>
@endif
