<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dependent extends Model
{
    use HasFactory;
    protected $primaryKey = 'dependent_id';
    protected $fillable = [
        'emp_data_id',
        'name',
        'age',
        'relation',
        'address',
    ];

    public function empData()
    {
        return $this->belongsTo(EmpData::class, 'emp_data_id', 'emp_data_id');
    }
}
