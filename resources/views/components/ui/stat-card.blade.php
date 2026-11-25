@props([
    'label',
    'value',
    'unit' => null,
    'subtext' => null,
    'accent' => 'green', // green or gold
])

@php
    $accentBorder = $accent === 'gold' 
        ? 'border-l-4 border-l-[#D97706]' 
        : 'border-l-4 border-l-[#15803D]';
@endphp

<div {{ $attributes->merge(['class' => "bg-white rounded-2xl p-5 sm:p-6 border border-stone-200/80 shadow-sm {$accentBorder}"]) }}>
    <div class="text-xs sm:text-sm font-medium text-stone-500 uppercase tracking-wider mb-1">
        {{ $label }}
    </div>
    <div class="flex items-baseline gap-1.5 my-1">
        <span class="text-3xl sm:text-4xl font-extrabold text-stone-900 tracking-tight tabular-nums">
            {{ $value }}
        </span>
        @if($unit)
            <span class="text-base sm:text-lg font-semibold text-stone-600">
                {{ $unit }}
            </span>
        @endif
    </div>
    @if($subtext)
        <p class="text-xs text-stone-500 mt-1 leading-relaxed">
            {{ $subtext }}
        </p>
    @endif
</div>
