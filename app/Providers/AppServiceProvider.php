<?php

namespace App\Providers;
use App\Domain\Models\JobTitlePermission;
use App\Domain\Repositories\AttendanceRepositoryInterface;

use App\Domain\Repositories\DepartmentRepositoryInterface;
use App\Domain\Repositories\EmployeeRepositoryInterface;
use App\Domain\Repositories\EmployeeVacationRepositoryInterface;
use App\Domain\Repositories\FingerDeviceRepositoryInterface;
use App\Domain\Repositories\HolidayRepositoryInterface;
use App\Domain\Repositories\JobTitleRepositoryInterface;
use App\Domain\Repositories\JobApplicationRepositoryInterface;
use App\Domain\Repositories\JobVacancyRepositoryInterface;
use App\Domain\Repositories\LeaveRepositoryInterface;
use App\Domain\Repositories\PermissionRepositoryInterface;
use App\Domain\Repositories\ScheduleRepositoryInterface;
use App\Domain\Repositories\WorkingDayRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\EloquentAttendanceRepository;
use App\Domain\Repositories\ShiftRequestRepositoryInterface;
use App\Domain\Repositories\VacationRequestRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\EloquentDepartmentRepository;
use App\Infrastructure\Persistence\Eloquent\EloquentEmployeeRepository;
use App\Infrastructure\Persistence\Eloquent\EloquentEmployeeVacationRepository;
use App\Infrastructure\Persistence\Eloquent\EloquentFingerDeviceRepository;
use App\Infrastructure\Persistence\Eloquent\EloquentHolidayRepository;
use App\Infrastructure\Persistence\Eloquent\EloquentJobApplicationRepository;
use App\Infrastructure\Persistence\Eloquent\EloquentJobTitleRepository;
use App\Infrastructure\Persistence\Eloquent\EloquentJobVacancyRepository;
use App\Infrastructure\Persistence\Eloquent\EloquentLeaveRepository;
use App\Infrastructure\Persistence\Eloquent\EloquentPermissionRepository;
use App\Infrastructure\Persistence\Eloquent\EloquentScheduleRepository;
use App\Infrastructure\Persistence\Eloquent\EloquentWorkingDayRepository;
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
        $this->app->bind(JobTitleRepositoryInterface::class, EloquentJobTitleRepository::class);
        $this->app->bind(PermissionRepositoryInterface::class, EloquentPermissionRepository::class);
        $this->app->bind(EmployeeRepositoryInterface::class, EloquentEmployeeRepository::class);
        $this->app->bind(ScheduleRepositoryInterface::class, EloquentScheduleRepository::class);
        $this->app->bind(EmployeeRepositoryInterface::class, EloquentEmployeeRepository::class);
        $this->app->bind(FingerDeviceRepositoryInterface::class, EloquentFingerDeviceRepository::class);
        $this->app->bind(AttendanceRepositoryInterface::class, EloquentAttendanceRepository::class);
        $this->app->bind(LeaveRepositoryInterface::class, EloquentLeaveRepository::class);
        $this->app->bind(WorkingDayRepositoryInterface::class, EloquentWorkingDayRepository::class);
        $this->app->bind(HolidayRepositoryInterface::class, EloquentHolidayRepository::class);
        $this->app->bind(EmployeeVacationRepositoryInterface::class, EloquentEmployeeVacationRepository::class);

    }


    public function boot(): void
    {
        //
    }
}
