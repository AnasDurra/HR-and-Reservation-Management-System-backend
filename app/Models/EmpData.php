<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpData extends Model
{
    use HasFactory;
    protected $primaryKey = 'emp_data_id';
    protected $fillable = ['fields'];
    protected $timestamps = true;

    public function jobApplication()
    {
        return $this->hasOne(JobApplication::class, 'emp_data_id', 'emp_data_id');
    }

    public function employee()
    {
        return $this->hasOne(Employee::class, 'emp_data_id', 'emp_data_id');
    }
}
