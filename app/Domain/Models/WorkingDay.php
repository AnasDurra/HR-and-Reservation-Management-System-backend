<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class workingDay extends Model
{

    use HasFactory;
    protected $primaryKey = 'working_day_id';
    protected $fillable = ['name', 'status'];

}
