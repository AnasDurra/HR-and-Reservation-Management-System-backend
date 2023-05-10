<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalCard extends Model
{
    use HasFactory;
    protected $primaryKey = 'personal_card_id';

    protected $fillable = [
        'card_number',
        'place_of_issue',
        'date_of_issue',
    ];

    public function empData()
    {
        return $this->hasOne(EmpData::class, 'personal_card_id', 'personal_card_id');
    }
}
