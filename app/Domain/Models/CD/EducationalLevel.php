<?php

namespace App\Domain\Models\CD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EducationalLevel extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $fillable = ['name'];

    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class);
    }
}
