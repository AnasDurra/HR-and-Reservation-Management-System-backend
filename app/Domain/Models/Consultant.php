<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Consultant extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $fillable = ['user_id', 'first_name', 'last_name', 'birth_date', 'phone_number', 'address'];

    public function shifts(): HasMany
    {
        return $this->hasMany(Shift::class);
    }
}
