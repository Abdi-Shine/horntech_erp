<?php

use App\Services\FeatureService;

if (!function_exists('feature_enabled')) {
    /**
     * Check if a feature is enabled for the current tenant company.
     * Returns true by default if the feature key is unknown (fail-open).
     *
     * Usage: @if(feature_enabled('pos')) ... @endif
     */
    function feature_enabled(string $key): bool
    {
        return app(FeatureService::class)->isEnabled($key);
    }
}
