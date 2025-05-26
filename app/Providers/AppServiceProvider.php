<?php

namespace App\Providers;

use App\Models\HospitalInformation;
use App\Services\AuthService;
use App\Services\Contracts\AuthServiceInterface;
use App\Services\Contracts\DoctorPolyclinicInterface;
use App\Services\Contracts\DoctorServiceInterface;
use App\Services\DoctorPolyclinicService;
use App\Services\DoctorService;
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
        $this->app->bind(DoctorPolyclinicInterface::class, DoctorPolyclinicService::class);
        $this->app->bind(DoctorServiceInterface::class, DoctorService::class);
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
