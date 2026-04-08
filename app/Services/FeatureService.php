<?php

namespace App\Services;

use App\Models\FeatureSetting;
use Illuminate\Support\Facades\Auth;

class FeatureService
{
    protected ?array $flags = null;

    /**
     * Load feature flags for the authenticated user's company (once per request).
     */
    protected function load(): void
    {
        if ($this->flags !== null) {
            return;
        }

        $user = Auth::user();

        if (!$user || !$user->company_id) {
            $this->flags = [];
            return;
        }

        $this->flags = FeatureSetting::withoutGlobalScopes()
            ->where('company_id', $user->company_id)
            ->pluck('is_enabled', 'feature_key')
            ->map(fn($v) => (bool) $v)
            ->toArray();
    }

    /**
     * Check if a feature is enabled. Returns true by default if feature not found (fail open).
     */
    public function isEnabled(string $key): bool
    {
        $this->load();
        return $this->flags[$key] ?? true;
    }
}
