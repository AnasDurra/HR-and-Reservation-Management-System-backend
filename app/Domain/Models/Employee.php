<?php

namespace App\Domain\Models;

use App\Models\Relative;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $primaryKey = 'emp_id';
    protected $fillable = ['user_id', 'emp_data_id', 'job_app_id', 'start_date', 'leaves_balance','cur_title','cur_dep'];

    public function leaves(){
        return $this->hasMany(Leave::class, 'emp_id', 'emp_id');
    }

    public function checks(){
        return $this->hasMany(Leave::class, 'emp_id', 'emp_id');
    }

    public function latetimes(){
        return $this->hasMany(Latetime::class, 'emp_id', 'emp_id');
    }

    public function overtimes(){
        return $this->hasMany(Overtime::class, 'emp_id', 'emp_id');
    }

    public function shiftRequests(){
        return $this->hasMany(ShiftRequest::class, 'emp_id', 'emp_id');
    }

    public function attendances(){
        return $this->hasMany(Attendance::class, 'emp_id', 'emp_id');
    }

    public function employmentStatuses(){
        return $this->belongsToMany(EmploymentStatus::class, 'employee_statuses', 'emp_id', 'emp_status_id',
            'emp_id','emp_status_id')
            ->withPivot('start_date', 'end_date');
    }


    public function staffings(){
        return $this->hasMany(Staffing::class, 'emp_id', 'emp_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function empData()
    {
        return $this->belongsTo(EmpData::class, 'emp_data_id', 'emp_data_id');
    }

    public function schedules(){
        return $this->belongsToMany(Schedule::class,'schedule_employees','emp_id','schedule_id',
            'emp_id','schedule_id');
    }


    public function relatives(){
        return $this->hasMany(Relative::class, 'emp_id', 'emp_id');
    }

}
