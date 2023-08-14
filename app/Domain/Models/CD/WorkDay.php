<?php

namespace App\Domain\Models\CD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkDay extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $fillable = ['shift_id', 'working_day_id', 'day_date'];

    public function shift(): BelongsTo
    {
        return $this->belongsTo(Shift::class);
    }


    public function appointments(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }
}
