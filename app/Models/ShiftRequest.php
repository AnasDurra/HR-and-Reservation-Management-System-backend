<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShiftRequest extends Model
{
    use HasFactory;
    protected $primaryKey = 'shift_req_id';
    protected $fillable = ['emp_id', 'req_stat_id', 'description'];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id', 'emp_id');
    }

    public function requestStatus()
    {
        return $this->belongsTo(RequestStatus::class, 'req_stat_id', 'req_stat_id');
    }
}
