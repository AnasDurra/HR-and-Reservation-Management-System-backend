<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DrivingLicence extends Model
{
    use HasFactory;

    protected $primaryKey = 'driving_licence_id';

    protected $fillable = [
        'category',
        'date_of_issue',
        'place_of_issue',
        'number',
        'expiry_date',
        'blood_group',
    ];

    public function empData(): BelongsTo
    {
        return $this->belongsTo(EmpData::class, 'driving_licence_id', 'driving_licence_id');
    }
}
