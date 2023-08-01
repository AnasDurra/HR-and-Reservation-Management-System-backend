<?php

namespace App\Domain\Models\CD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Clinic extends Model
{
    use HasFactory;
    protected $primaryKey = 'clinic_id';
    protected $fillable = [
        'name'
    ];

    public function consultant(): HasOne
    {
        return $this->hasOne(Consultant::class, 'clinic_id', 'clinic_id');
    }

}
