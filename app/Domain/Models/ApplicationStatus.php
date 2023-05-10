<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ApplicationStatus extends Model
{
    use HasFactory;
    protected $primaryKey = 'app_status_id';
    protected $fillable = ['name', 'description'];

    public function jobApplications(): HasMany
    {
        return $this->hasMany(JobApplication::class, 'app_status_id', 'app_status_id');
    }
}
