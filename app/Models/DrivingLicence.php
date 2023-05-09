<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    public function empData()
    {
        return $this->hasOne(EmpData::class, 'driving_licence_id', 'driving_licence_id');
    }
}
