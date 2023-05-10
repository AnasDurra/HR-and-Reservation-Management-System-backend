<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conviction extends Model
{
    use HasFactory;
    protected $primaryKey = 'conviction_id';

    protected $fillable = [
        'emp_data_id',
        'description',
    ];

    public function empData()
    {
        return $this->belongsTo(EmpData::class, 'emp_data_id', 'emp_data_id');
    }
}
