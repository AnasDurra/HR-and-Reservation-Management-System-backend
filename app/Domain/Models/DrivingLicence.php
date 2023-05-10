<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrivingLicence extends Model
{
    use HasFactory;
    protected $primaryKey = 'driving_licence_id';

    protected $fillable = [
        'emp_data_id',
        'category',
        'date_of_issue',
        'place_of_issue',
        'number',
        'expiry_date',
        'blood_group',
    ];
    public function empData()
    {
        return $this->belongsTo(EmpData::class, 'emp_data_id', 'emp_data_id');
    }
}
