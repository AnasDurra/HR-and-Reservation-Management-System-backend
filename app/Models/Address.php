<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $primaryKey = 'address_id';

    protected $fillable = [
        'state',
        'city',
        'street',
        'home_phone_no',
        'work_phone_no',
        'mobile_no',
        'email',
        'postal_code',
    ];

    public $timestamps = true;

    public function empData()
    {
        return $this->belongsTo(EmpData::class, 'address_id', 'address_id');
    }
}
