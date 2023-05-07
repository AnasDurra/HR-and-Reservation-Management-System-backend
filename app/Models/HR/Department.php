<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $primaryKey = 'dep_id';
    protected $fillable = ['name', 'description'];
    protected $timestamps = true;

    public function staffings()
    {
        return $this->hasMany(Staffing::class, 'dep_id', 'dep_id');
    }

    public function jobVacancies()
    {
        return $this->hasMany(JobVacancy::class, 'dep_id', 'dep_id');
    }
}
