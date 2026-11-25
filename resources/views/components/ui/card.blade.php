@props([
    'hover' => true,
])

@php
    $classes = 'bg-white rounded-2xl border border-stone-200/80 shadow-[0_1px_3px_rgba(0,0,0,0.05)]';
    if ($hover) {
        $classes .= ' transition-all duration-200 hover:shadow-md hover:border-stone-300';
    }
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>
