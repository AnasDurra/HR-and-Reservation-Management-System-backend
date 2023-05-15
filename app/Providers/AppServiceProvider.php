<?php

namespace App\Providers;

use App\Domain\Repositories\DepartmentRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\EloquentDepartmentRepository;
use App\Infrastructure\Persistence\Eloquent\EloquentEmployeeRepository;
use App\Domain\Repositories\JobApplicationRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\EloquentJobApplicationRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register the repository interface with its implementation
        $this->app->bind(JobApplicationRepositoryInterface::class, EloquentJobApplicationRepository::class);
        $this->app->bind(DepartmentRepositoryInterface::class, EloquentDepartmentRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
