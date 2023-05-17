<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relative extends Model
{
    use HasFactory;
    protected $primaryKey = 'relative_id';

    protected $fillable = [
        'emp_data_id',
        'emp_id',
    ];

    public function empData()
    {
        return $this->hasOne(EmpData::class, 'emp_data_id', 'emp_data_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id', 'emp_id');
    }
}
