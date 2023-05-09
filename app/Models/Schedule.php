<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;
    protected $primaryKey = 'schedule_id';
    protected $fillable = ['name', 'time_in', 'time_out'];

    public function employees(){
        return $this->belongsToMany(Employee::class,'schedule_employees','schedule_id','emp_id',
            'schedule_id','emp_id');
    }
}
