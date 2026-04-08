@props(['label', 'value', 'trend' => null, 'trendType' => 'up', 'icon' => null])

<div {{ $attributes->merge(['class' => 'bg-brand-surface p-6 rounded-xl shadow-sm border border-brand-border']) }}>
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-500">{{ $label }}</p>
            <p class="mt-2 text-3xl font-bold text-brand-text">{{ $value }}</p>
            
            @if($trend)
                <div class="mt-2 flex items-center text-sm">
                    @if($trendType === 'up')
                        <span class="text-accent font-semibold flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                            </svg>
                            {{ $trend }}
                        </span>
                    @else
                        <span class="text-red-500 font-semibold flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                            </svg>
                            {{ $trend }}
                        </span>
                    @endif
                    <span class="text-gray-400 ml-1">vs last month</span>
                </div>
            @endif
        </div>
        
        @if($icon)
            <div class="p-3 bg-primary/5 text-primary rounded-lg">
                {{ $icon }}
            </div>
        @else
            <div class="p-4 bg-accent/10 text-accent rounded-xl">
                 <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
            </div>
        @endif
    </div>
</div>
