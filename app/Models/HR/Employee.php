<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $primaryKey = 'emp_id';
    protected $fillable = ['user_id', 'emp_data_id', 'job_app_id', 'start_date', 'leaves_balance'];

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

    public function employee_statuses(){
        return $this->hasMany(EmployeeStatus::class, 'emp_id', 'emp_id');
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

//    public function jobApplication()
//    {
//        return $this->belongsTo(JobApplication::class, 'job_app_id', 'job_app_id');
//    }
}
