<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Overtime extends Model
{
    use HasFactory;
    protected $primaryKey = 'overtime_id';
    protected $fillable = ['emp_id', 'duration', 'overtime_date'];
    protected $timestamps = true;

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id', 'emp_id');
    }
}
