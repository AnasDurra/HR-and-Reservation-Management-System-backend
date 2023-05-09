<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobTitle extends Model
{
    use HasFactory;
    protected $primaryKey = 'job_title_id';
    protected $fillable = ['name', 'description'];

    public function staffings()
    {
        return $this->hasMany(Staffing::class, 'job_title_id', 'job_title_id');
    }

    public function permissions(){
        return $this->belongsToMany(Permission::class,'job_title_permissions','job_title_id','perm_id',
            'job_title_id','perm_id');
    }
}
