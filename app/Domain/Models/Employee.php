<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'emp_id';
    protected $fillable = [
        'user_id',
        'emp_data_id',
        'job_app_id',
        'start_date',
        'leaves_balance',
        'schedule_id',
        'cur_title',
        'cur_dep'
    ];

    public function leaves(): HasMany
    {
        return $this->hasMany(Leave::class, 'emp_id', 'emp_id');
    }

    public function lateTimes(): HasMany
    {
        return $this->hasMany(Latetime::class, 'emp_id', 'emp_id');
    }

    public function overtimes(): HasMany
    {
        return $this->hasMany(Overtime::class, 'emp_id', 'emp_id');
    }

    public function shiftRequests(): HasMany
    {
        return $this->hasMany(ShiftRequest::class, 'emp_id', 'emp_id');
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class, 'emp_id', 'emp_id');
    }

    public function employmentStatuses(): BelongsToMany
    {
        return $this->belongsToMany(
            EmploymentStatus::class,
            'employee_statuses',
            'emp_id',
            'emp_status_id',
            'emp_id',
            'emp_status_id'
        )->withPivot('start_date', 'end_date');
    }


    public function schedule(): BelongsTo
    {
        return $this->belongsTo(
            Schedule::class,
            'schedule_id',
            'schedule_id'
        )->withTrashed();
    }

    public function staffings(): HasMany
    {
        return $this->hasMany(Staffing::class, 'emp_id', 'emp_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function jobApplication(): BelongsTo
    {
        return $this->belongsTo(JobApplication::class, 'job_app_id', 'job_app_id');
    }

    /**
     * Get Current Employment Status Mutator.
     *
     * the employment status is the current status of the employee
     * is the record in the pivot table employee_statuses, where the end_date is null
     * and the start_date is the max start_date.
     */
    public function getCurrentEmploymentStatusAttribute(): Model|BelongsTo|null
    {
        return $this->employmentStatuses()->whereNull('end_date')->orderByDesc('start_date')->first();
    }

    /**
     * Get Current Department Mutator.
     * this function is used to get the current department of the employee
     * by checking the end_date of the staffing record
     */
    public function getCurrentDepartmentAttribute(): Model|BelongsTo|null
    {
        // if there is no staffing record with null end_date
        // then the employee is not working in any department
        if (!$this->staffings()->whereNull('end_date')->exists()) {
            return null;
        }

        return $this->staffings()->whereNull('end_date')->first()->department;
    }

    /**
     * Get Current Job Title Mutator.
     * this function is used to get the current job title of the employee
     * by checking the end_date of the staffing record
     */
    public function getCurrentJobTitleAttribute(): Model|BelongsTo|null
    {
        // if there is no staffing record with null end_date
        // then the employee does not have a job title
        if (!$this->staffings()->whereNull('end_date')->exists()) {
            return null;
        }
        return $this->staffings()->whereNull('end_date')->first()->jobTitle;
    }

    /**
     * Get Start Working date Mutator.
     *
     * this represents the start date of the first
     * staffing record of the employee
     */
    public function getStartWorkingDateAttribute(): string|null
    {
        // if employee doesn't have any staffing records
        // then he didn't start working yet
        if (!$this->staffings()->exists()) {
            return null;
        }
        return $this->staffings()->orderBy('start_date')->first()->start_date;
    }

    public function vacations(): HasMany
    {
        return $this->hasMany(EmployeeVacation::class, 'emp_id', 'emp_id');
    }

    /**
     * Get Employee Full Name Mutator.
     */
    public function getFullNameAttribute(): string
    {
        return $this->jobApplication()->first()->empData->first_name . ' ' . $this->jobApplication()->first()->empData->last_name;
    }

//    /**
//     * Get Schedule Name Mutator.
//     */
//    public function getScheduleNameAttribute(): string
//    {
//        return $this->schedule()->first()->schedule_name;
//    }
}
