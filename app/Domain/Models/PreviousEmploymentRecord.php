<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreviousEmploymentRecord extends Model
{
    use HasFactory;
    protected $primaryKey = 'prev_emp_record_id';

    protected $fillable = [
        'emp_data_id',
        'start_date',
        'end_date',
        'address',
        'telephone',
        'job_title',
        'job_description',
        'salary',
        'allowance',
        'quit_reason',
    ];
    public function empData()
    {
        return $this->belongsTo(EmpData::class, 'emp_data_id', 'emp_data_id');
    }
}
