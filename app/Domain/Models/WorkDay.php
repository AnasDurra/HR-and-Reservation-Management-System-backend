<?php

namespace App\Domain\Models;

use App\app\Domain\Models\WorkingDay;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WorkDay extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $fillable = ['shift_id', 'working_day_id', 'day_date'];

    public function shift(): BelongsTo
    {
        return $this->belongsTo(Shift::class);
    }

    public function workingDay(): BelongsTo
    {
        return $this->belongsTo(WorkingDay::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}
