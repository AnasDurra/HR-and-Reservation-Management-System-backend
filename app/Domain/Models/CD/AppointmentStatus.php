<?php

namespace App\Domain\Models\CD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AppointmentStatus extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $fillable = ['name'];

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}
