<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobVacancy extends Model
{
    use HasFactory;
    protected $primaryKey = 'job_vacancy_id';
    protected $fillable = ['dep_id', 'name', 'description', 'count','vacancy_status_id'];
    public function department()
    {
        return $this->belongsTo(Department::class, 'dep_id', 'dep_id');
    }

    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class, 'job_vacancy_id', 'job_vacancy_id');
    }

    public function vacancyStatus()
    {
        return $this->belongsTo(VacancyStatus::class, 'vacancy_status_id', 'vacancy_status_id');
    }
}
