<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $primaryKey = 'attendance_id';
    protected $fillable = ['emp_id', 'uid', 'state', 'attendance_time', 'attendance_date', 'status', 'type'];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id', 'emp_id');
    }
}
