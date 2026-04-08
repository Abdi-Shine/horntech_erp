@extends('admin.admin_master')
@section('page_title', 'Plans & Pricing')

@section('admin')

@php
    $currentSubscription = $currentSubscription ?? null;
    $company             = $company ?? null;
    $currency            = $company->currency ?? '$';
    $currentPlanId       = $currentSubscription?->subscription_plan_id;
    $isExpired           = $currentSubscription && !$currentSubscription->isActive();
    $isAuthenticated     = auth()->check();
@endphp

<div class="px-4 py-10 md:px-10 md:py-14 bg-background min-h-screen">
    <div class="max-w-5xl mx-auto">

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="mb-6 flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 rounded-xl px-5 py-4 text-sm font-semibold">
                <i class="bi bi-check-circle-fill text-green-500 text-base"></i>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 rounded-xl px-5 py-4 text-sm font-semibold">
                <i class="bi bi-exclamation-circle-fill text-red-500 text-base"></i>
                {{ session('error') }}
            </div>
        @endif

        {{-- Page Header --}}
        <div class="mb-10">
            <h1 class="text-3xl font-black text-primary tracking-tight uppercase">Plans & Pricing</h1>
            <p class="mt-2 text-sm text-gray-500 font-medium">
                @if($isAuthenticated && $currentSubscription && !$isExpired)
                    You are on the <span class="text-accent font-bold">{{ $currentSubscription->plan->name }}</span> plan,
                    active until <span class="font-bold text-primary">{{ \Carbon\Carbon::parse($currentSubscription->expiry_date)->format('d M Y') }}</span>.
                    Renew below or switch to another plan.
                @elseif($isAuthenticated && $isExpired)
                    Your subscription expired on <span class="font-bold text-red-500">{{ \Carbon\Carbon::parse($currentSubscription->expiry_date)->format('d M Y') }}</span>.
                    Renew a plan below to restore access.
                @elseif($isAuthenticated)
                    Choose a plan to activate your subscription.
                @else
                    Choose a plan and <a href="{{ route('register') }}" class="text-accent underline">create an account</a> to get started.
                @endif
            </p>
        </div>

        {{-- Expired Warning Banner --}}
        @if($isExpired)
            <div class="mb-8 flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 rounded-xl px-5 py-4 text-sm font-semibold">
                <i class="bi bi-exclamation-triangle-fill text-red-500 text-base"></i>
                Your subscription has expired. Renew now to restore full system access.
            </div>
        @endif

        {{-- Plan Cards --}}
        @if($plans->isEmpty())
            <div class="py-24 text-center">
                <i class="bi bi-box text-5xl text-gray-200 block mb-4"></i>
                <p class="text-lg font-black text-primary uppercase">No plans available</p>
                <p class="text-sm text-gray-400 mt-1">Contact support for assistance.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($plans as $plan)
                    @php
                        $isCurrent  = $currentPlanId === $plan->id;
                        $isPopular  = $plan->is_popular;
                        $features   = is_array($plan->features) ? $plan->features : [];
                        $cycleLabel = match($plan->billing_cycle) {
                            'yearly'    => 'per year',
                            'quarterly' => 'per quarter',
                            default     => 'per month',
                        };
                        $monthlyEquiv = match($plan->billing_cycle) {
                            'yearly'    => floatval($plan->price) / 12,
                            'quarterly' => floatval($plan->price) / 3,
                            default     => floatval($plan->price),
                        };
                    @endphp

                    <div class="relative flex flex-col rounded-2xl bg-white border {{ $isCurrent ? 'border-accent ring-2 ring-accent/20' : ($isPopular ? 'border-accent/40' : 'border-gray-200') }} shadow-sm overflow-hidden">

                        {{-- Badges --}}
                        @if($isCurrent)
                            <div class="absolute top-4 right-4 bg-accent text-white text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full">
                                Current Plan
                            </div>
                        @elseif($isPopular)
                            <div class="absolute top-4 right-4 bg-primary text-white text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full">
                                Most Popular
                            </div>
                        @endif

                        {{-- Card Header --}}
                        <div class="p-6 pb-4 border-b border-gray-100">
                            <h3 class="text-xl font-black text-primary uppercase tracking-tight mb-4">{{ $plan->name }}</h3>

                            <div class="flex items-baseline gap-1 mb-1">
                                <span class="text-3xl font-black text-primary">{{ $currency }}{{ number_format($plan->price, 2) }}</span>
                                <span class="text-sm text-gray-400 font-semibold">/ {{ $plan->billing_cycle }}</span>
                            </div>

                            @if($plan->billing_cycle !== 'monthly')
                                <p class="text-xs text-gray-400 font-semibold">
                                    {{ $currency }}{{ number_format($monthlyEquiv, 2) }} / month billed {{ $plan->billing_cycle }}
                                </p>
                            @endif

                            @if($plan->description)
                                <p class="mt-3 text-xs text-gray-500 leading-relaxed">{{ $plan->description }}</p>
                            @endif
                        </div>

                        {{-- Features --}}
                        <div class="p-6 flex-grow">
                            <ul class="space-y-3">
                                <li class="flex items-center gap-3">
                                    <i class="bi bi-check-lg text-accent text-base flex-shrink-0"></i>
                                    <span class="text-sm font-semibold text-primary">
                                        {{ $plan->max_users >= 9999 ? 'Unlimited' : $plan->max_users }} Users
                                    </span>
                                </li>
                                <li class="flex items-center gap-3">
                                    <i class="bi bi-check-lg text-accent text-base flex-shrink-0"></i>
                                    <span class="text-sm font-semibold text-primary">{{ $plan->storage_limit_gb }} GB Storage</span>
                                </li>
                                @foreach($features as $feature)
                                    <li class="flex items-center gap-3">
                                        <i class="bi bi-check-lg text-accent text-base flex-shrink-0"></i>
                                        <span class="text-sm font-semibold text-primary">{{ $feature }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        {{-- CTA --}}
                        <div class="px-6 pb-6">
                            @if($isAuthenticated)
                                <a href="{{ route('subscribers.checkout', $plan->id) }}"
                                   class="w-full py-3 rounded-xl font-black text-xs uppercase tracking-widest block text-center transition-all
                                   {{ $isCurrent ? 'bg-accent text-white hover:bg-accent/90' : 'bg-primary text-white hover:bg-primary/90' }}">
                                    @if($isCurrent)
                                        Renew {{ $plan->name }}
                                    @elseif($currentSubscription)
                                        Switch to {{ $plan->name }}
                                    @else
                                        Subscribe &mdash; {{ $currency }}{{ number_format($plan->price, 2) }}
                                    @endif
                                </a>
                            @else
                                <a href="{{ route('register') }}"
                                   class="w-full py-3 rounded-xl font-black text-xs uppercase tracking-widest block text-center transition-all bg-primary text-white hover:bg-primary/90">
                                    Get Started
                                </a>
                            @endif
                        </div>

                    </div>
                @endforeach
            </div>
        @endif

        {{-- Billing Note --}}
        <p class="mt-10 text-center text-xs text-gray-400 font-medium">
            Prices are billed in {{ $currency === '$' ? 'USD' : $currency }}.
            Subscriptions renew automatically unless cancelled. Contact support to cancel or downgrade.
        </p>

    </div>
</div>

@endsection
