<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use HasFactory;

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

    public function checks(): HasMany
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
        return $this->belongsToMany(EmploymentStatus::class, 'employee_statuses', 'emp_id', 'emp_status_id',
            'emp_id', 'emp_status_id')
            ->withPivot('start_date', 'end_date');
    }


    public function staffings(): HasMany
    {
        return $this->hasMany(Staffing::class, 'emp_id', 'emp_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function empData(): BelongsTo
    {
        return $this->belongsTo(EmpData::class, 'emp_data_id', 'emp_data_id');
    }

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class, 'schedule_id', 'schedule_id');
    }


    public function relatives(): HasMany
    {
        return $this->hasMany(Relative::class, 'emp_id', 'emp_id');
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

    public function vacations(): HasMany
    {
        return $this->hasMany(EmployeeVacation::class, 'emp_id', 'emp_id');
    }
}
