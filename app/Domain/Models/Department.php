<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $primaryKey = 'dep_id';
    protected $fillable = ['name', 'description'];

    public function staffings()
    {
        return $this->hasMany(Staffing::class, 'dep_id', 'dep_id');
    }

    public function jobVacancies()
    {
        return $this->hasMany(JobVacancy::class, 'dep_id', 'dep_id');
    }
}
