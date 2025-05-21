<?php

namespace App\Providers;

use App\Models\HospitalInformation;
use App\Services\AuthService;
use App\Services\Contracts\AuthServiceInterface;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
        // Share footer data to all views
        View::composer('landing-page.layouts.footer', function ($view) {
            $hospitalInformation = HospitalInformation::first(); // Mengambil data pertama dari tabel
            $view->with('hospitalInformation', $hospitalInformation);
        });
    }
}
