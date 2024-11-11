<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\DoctorRepository;
use App\Repositories\DoctorRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(DoctorRepositoryInterface::class, DoctorRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
