<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleEmployee extends Model
{
    use HasFactory;
    protected $primaryKey = 'sched_emp_id';
    protected $fillable = ['emp_id', 'schedule_id'];
}
