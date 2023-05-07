<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationStatus extends Model
{
    use HasFactory;
    protected $primaryKey = 'app_status_id';
    protected $fillable = ['name', 'description'];
    protected $timestamps = true;

    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class, 'app_status_id', 'app_status_id');
    }
}
