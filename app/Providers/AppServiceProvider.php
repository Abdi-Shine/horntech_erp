<?php

namespace App\Providers;

use App\Services\FeatureService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // scoped = new instance per request, so flags are always fresh from DB
        $this->app->scoped(FeatureService::class, fn() => new FeatureService());
    }

    public function boot(): void
    {
        \Illuminate\Pagination\Paginator::useTailwind();
        Schema::defaultStringLength(191);
    }
}
