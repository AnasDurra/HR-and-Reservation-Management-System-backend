<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Latetime extends Model
{
    use HasFactory;
    protected $primaryKey = 'latetime_id';
    protected $fillable = ['emp_id', 'duration', 'latetime_date'];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id', 'emp_id');
    }
}
