{{--
    Stats Card Component
    Usage:
        <x-stats-card
            label="Today's Sales"
            :value="$symbol . ' ' . number_format($todaySales, 2)"
            sub="Daily total"
            icon="bi-receipt"
            icon-class="premium-stats-icon-primary"
        />

    Props:
        label      — card title (string)
        value      — main displayed number/value (string)
        sub        — small subtext below the value (string, optional)
        icon       — Bootstrap Icon class e.g. "bi-receipt" (string)
        icon-class — color variant class from app.css e.g. "premium-stats-icon-primary",
                     "premium-stats-icon-rose", "premium-stats-icon-emerald",
                     "premium-stats-icon-accent", "premium-stats-icon-slate" (string, optional)
--}}
@props([
    'label'     => '',
    'value'     => '',
    'sub'       => '',
    'icon'      => 'bi-bar-chart',
    'iconClass' => 'premium-stats-icon-primary',
])

<div class="premium-stats-card">
    <div>
        <p class="premium-stats-label">{{ $label }}</p>
        <h3 class="premium-stats-value">{{ $value }}</h3>
        @if($sub)
            <p class="premium-stats-subtext">{{ $sub }}</p>
        @endif
    </div>
    <div class="premium-stats-icon-box {{ $iconClass }}">
        <i class="bi {{ $icon }} text-lg" aria-hidden="true"></i>
    </div>
</div>
