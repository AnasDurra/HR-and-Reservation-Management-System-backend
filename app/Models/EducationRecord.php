<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationRecord extends Model
{
    use HasFactory;
    protected $primaryKey = 'education_record_id';
    protected $fillable = [
        'emp_data_id',
        'education_level_id',
        'univ_name',
        'city',
        'start_date',
        'end_date',
        'specialize',
        'grade',
    ];
}
