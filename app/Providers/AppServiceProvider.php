<?php

namespace App\Providers;

use App\Domain\Repositories\EmployeeRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\EloquentEmployeeRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register the repository interface with its implementation
        $this->app->bind(EmployeeRepositoryInterface::class, EloquentEmployeeRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
