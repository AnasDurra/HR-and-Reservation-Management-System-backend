<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;
    protected $primaryKey = 'job_app_id';
    protected $fillable = ['app_status_id', 'job_vacancy_id', 'emp_data_id'];

    public function applicationStatus()
    {
        return $this->belongsTo(ApplicationStatus::class, 'app_status_id', 'app_status_id');
    }

    public function jobVacancy()
    {
        return $this->belongsTo(JobVacancy::class, 'job_vacancy_id', 'job_vacancy_id');
    }

    public function empData()
    {
        return $this->belongsTo(EmpData::class, 'emp_data_id', 'emp_data_id');
    }
}
