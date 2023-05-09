<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmploymentStatus extends Model
{
    use HasFactory;
    protected $primaryKey = 'emp_status_id';
    protected $fillable = ['name', 'description'];


    public function employees(){
        return $this->belongsToMany(Employee::class, 'employee_statuses', 'emp_status_id', 'emp_id',
            'emp_status_id','emp_id')
            ->withPivot('start_date', 'end_date');
    }


}
