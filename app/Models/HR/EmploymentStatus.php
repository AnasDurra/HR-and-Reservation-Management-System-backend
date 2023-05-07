<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmploymentStatus extends Model
{
    use HasFactory;
    protected $primaryKey = 'emp_status_id';
    protected $fillable = ['name', 'description'];
    protected $timestamps = true;

    public function employeeStatuses()
    {
        return $this->hasMany(EmployeeStatus::class, 'emp_status_id', 'emp_status_id');
    }
}
