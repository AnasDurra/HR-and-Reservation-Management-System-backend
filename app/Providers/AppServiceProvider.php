<?php

namespace App\Providers;
use App\Domain\Models\JobTitlePermission;
use App\Domain\Repositories\DepartmentRepositoryInterface;
use App\Domain\Repositories\EmployeeRepositoryInterface;
use App\Domain\Repositories\JobTitlePermissionRepositoryInterface;
use App\Domain\Repositories\JobTitleRepositoryInterface;
use App\Domain\Repositories\JobVacancyRepositoryInterface;
use App\Domain\Repositories\PermissionRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\EloquentDepartmentRepository;
use App\Infrastructure\Persistence\Eloquent\EloquentEmployeeRepository;
use App\Domain\Repositories\JobApplicationRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\EloquentJobApplicationRepository;
use App\Infrastructure\Persistence\Eloquent\EloquentJobTitleRepository;
use App\Infrastructure\Persistence\Eloquent\EloquentJobVacancyRepository;
use App\Infrastructure\Persistence\Eloquent\EloquentPermissionRepository;
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
        $this->app->bind(JobTitleRepositoryInterface::class, EloquentJobTitleRepository::class);
        //$this->app->bind(JobTitlePermissionRepositoryInterface::class, EloquentJobTitleRepository::class);

        $this->app->bind(PermissionRepositoryInterface::class, EloquentPermissionRepository::class);
    }


    public function boot(): void
    {
        //
    }
}
