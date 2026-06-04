<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     * ✅ PERFORMANCE OPTIMIZATIONS
     */
    public function boot(): void
    {
        // Enable query logging in development for debugging
        if (config('app.debug')) {
            DB::listen(function ($query) {
                // Log queries that take longer than 100ms
                if ($query->time > 100) {
                    \Log::warning('Slow Query (' . $query->time . 'ms): ' . $query->sql, $query->bindings);
                }
            });
        }

        // Lazy loading prevention - helps catch N+1 queries during development
        if (config('app.debug')) {
            Model::preventLazyLoading();
        }

        // Strict mode - safer queries in development
        if (config('app.debug')) {
            Model::preventSilentlyDiscardingAttributes();
        }
    }
}
