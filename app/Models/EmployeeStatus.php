<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeStatus extends Model
{
    use HasFactory;
    protected $primaryKey = 'status_id';
    protected $fillable = ['emp_id', 'emp_status_id', 'start_date', 'end_date'];
    protected $timestamps = true;

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id', 'emp_id');
    }

    public function employmentStatus()
    {
        return $this->belongsTo(EmploymentStatus::class, 'emp_status_id', 'emp_status_id');
    }
}
