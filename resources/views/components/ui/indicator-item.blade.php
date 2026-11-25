@props([
    'title',
    'description',
    'achieved' => true,
    'badgeText' => 'Terpenuhi',
    'number' => null,
])

<div {{ $attributes->merge(['class' => 'flex items-start gap-3.5 sm:gap-4 p-4 rounded-xl border transition-all ' . ($achieved ? 'bg-white border-emerald-100 hover:border-emerald-200' : 'bg-stone-50 border-stone-200 opacity-75')]) }}>
    <div class="shrink-0 mt-0.5">
        @if($achieved)
            <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-emerald-100 text-[#15803D] flex items-center justify-center shadow-xs">
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                </svg>
            </div>
        @else
            <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-stone-200 text-stone-500 flex items-center justify-center">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </div>
        @endif
    </div>
    
    <div class="flex-1 min-w-0">
        <div class="flex items-center justify-between gap-2 flex-wrap">
            <h4 class="text-sm sm:text-base font-bold text-stone-900">
                @if($number)<span class="text-[#15803D] mr-1.5 tabular-nums">#{{ $number }}</span>@endif{{ $title }}
            </h4>
            <span class="inline-flex items-center text-xs font-semibold px-2.5 py-0.5 rounded-full {{ $achieved ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : 'bg-stone-100 text-stone-600' }}">
                {{ $badgeText }}
            </span>
        </div>
        <p class="text-xs sm:text-sm text-stone-600 mt-1 leading-relaxed">
            {{ $description }}
        </p>
    </div>
</div>
