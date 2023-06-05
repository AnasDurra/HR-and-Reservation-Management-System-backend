<?php

namespace App\Providers;

use App\Domain\Repositories\DepartmentRepositoryInterface;
use App\Domain\Repositories\JobVacancyRepositoryInterface;
use App\Domain\Repositories\ShiftRequestRepositoryInterface;
use App\Domain\Repositories\VacationRequestRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\EloquentDepartmentRepository;
use App\Domain\Repositories\JobApplicationRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\EloquentJobApplicationRepository;
use App\Infrastructure\Persistence\Eloquent\EloquentJobVacancyRepository;
use App\Infrastructure\Persistence\Eloquent\EloquentShiftRequestRepository;
use App\Infrastructure\Persistence\Eloquent\EloquentVacationRequestRepository;
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
        $this->app->bind(JobVacancyRepositoryInterface::class, EloquentJobVacancyRepository::class);
        $this->app->bind(ShiftRequestRepositoryInterface::class, EloquentShiftRequestRepository::class);
        $this->app->bind(VacationRequestRepositoryInterface::class, EloquentVacationRequestRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
