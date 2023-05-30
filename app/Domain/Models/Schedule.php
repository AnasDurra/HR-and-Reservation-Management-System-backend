<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $primaryKey = 'schedule_id';
    protected $fillable = ['name', 'time_in', 'time_out'];

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class,'schedule_id','schedule_id');
    }
}
