<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Interval extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $fillable = ['start_time', 'end_time'];

    public function shiftIntervals(): HasMany
    {
        return $this->hasMany(ShiftInterval::class);
    }
}
