<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

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
     */
    public function boot(): void
    {
        // Izinkan seluruh siswa dan publik (termasuk tamu tanpa login) mengakses dokumentasi API Scalar di /docs/api
        Gate::define('viewApiDocs', function ($user = null) {
            return true;
        });

        // Rate limiter dilonggarkan menjadi 1.000 req/menit untuk mencegah error 429
        // saat 30+ siswa mengakses API dari satu jaringan WiFi/IP publik yang sama.
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(1000)->by($request->ip());
        });
    }
}
