@props([
    'variant' => 'primary', // primary, gold, secondary, outline
    'size' => 'md', // sm, md, lg
    'type' => 'button',
])

@php
    $baseClasses = 'inline-flex items-center justify-center font-semibold rounded-xl transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer';

    $sizeClasses = match ($size) {
        'sm' => 'px-3 py-1.5 text-xs',
        'lg' => 'px-6 py-3.5 text-base sm:text-lg',
        default => 'px-4 py-2.5 text-sm sm:text-base',
    };

    $variantClasses = match ($variant) {
        'primary' => 'bg-[#15803D] hover:bg-[#166534] text-white shadow-sm hover:shadow active:scale-[0.99] focus:ring-[#15803D]',
        'gold' => 'bg-[#D97706] hover:bg-[#B45309] text-white shadow-sm hover:shadow active:scale-[0.99] focus:ring-[#D97706]',
        'secondary' => 'bg-stone-100 hover:bg-stone-200 text-stone-800 active:scale-[0.99] focus:ring-stone-400',
        'outline' => 'border border-stone-300 hover:border-stone-400 bg-white text-stone-700 active:scale-[0.99] focus:ring-stone-400',
        default => 'bg-[#15803D] hover:bg-[#166534] text-white shadow-sm hover:shadow active:scale-[0.99] focus:ring-[#15803D]',
    };
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => "{$baseClasses} {$sizeClasses} {$variantClasses}"]) }}>
    {{ $slot }}
</button>
