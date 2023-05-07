<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Check extends Model
{
    use HasFactory;
    protected $primaryKey = 'check_id';
    protected $fillable = ['emp_id', 'attendance_time', 'leave_time'];
    protected $timestamps = true;

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id', 'emp_id');
    }


}
