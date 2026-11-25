@props([
    'variant' => 'green', // green, gold, neutral, outline
    'size' => 'md', // sm, md
])

@php
    $baseClasses = 'inline-flex items-center gap-1.5 font-medium rounded-full transition-colors';
    
    $sizeClasses = match ($size) {
        'sm' => 'px-2.5 py-0.5 text-xs',
        default => 'px-3 py-1 text-xs sm:text-sm',
    };

    $variantClasses = match ($variant) {
        'green' => 'bg-emerald-50 text-emerald-800 border border-emerald-200/80',
        'gold' => 'bg-amber-50 text-amber-800 border border-amber-200/80',
        'neutral' => 'bg-stone-100 text-stone-700 border border-stone-200/80',
        'outline' => 'bg-transparent text-stone-600 border border-stone-300',
        default => 'bg-emerald-50 text-emerald-800 border border-emerald-200/80',
    };
@endphp

<span {{ $attributes->merge(['class' => "{$baseClasses} {$sizeClasses} {$variantClasses}"]) }}>
    {{ $slot }}
</span>
