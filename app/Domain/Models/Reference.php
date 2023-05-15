<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    use HasFactory;
    protected $primaryKey = 'reference_id';

    protected $fillable = [
        'emp_data_id',
        'name',
        'job',
        'company',
        'telephone',
        'address',
    ];

    public function empData()
    {
        return $this->belongsTo(EmpData::class, 'emp_data_id', 'emp_data_id');
    }
}
