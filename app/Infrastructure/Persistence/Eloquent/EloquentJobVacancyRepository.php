<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Repositories\JobVacancyRepositoryInterface;
use App\Domain\Models\JobVacancy;
use Illuminate\Database\Eloquent\Builder;

class EloquentJobVacancyRepository implements JobVacancyRepositoryInterface
{
    public function getJobVacancyList(): array
    {
        return JobVacancy::whereHas('vacancyStatus', function ($query) {
            $query->where('vacancy_status_id', '!=', 3);
        })->with('department','vacancyStatus')->get()->toArray();
    }

    public function getJobVacancyById(int $id): JobVacancy|Builder|null
    {
        $jobVacancy=JobVacancy::whereHas('vacancyStatus', function ($query) {
            $query->where('vacancy_status_id', '!=', 3);
        })->with('department', 'vacancyStatus')->find($id);
        return $jobVacancy;
    }

    public function createJobVacancy(array $data): JobVacancy|Builder
    {
        $jobVacancy= JobVacancy::create([
            'dep_id' => $data['dep_id'],
            'name' => $data['name'],
            'description' => $data['description'],
            'count' => $data['count'],
            'vacancy_status_id' => 1,
        ]);
        return $jobVacancy->load('department', 'vacancyStatus');;
    }

    public function updateJobVacancy(int $id, array $data): JobVacancy|Builder
    {
        $jobVacancy = JobVacancy::find($id);
        $jobVacancy->name = $data['name'] ?? $jobVacancy->name;
        $jobVacancy->dep_id = $data['dep_id'] ?? $jobVacancy->dep_id;
        $jobVacancy->description = $data['description'] ?? $jobVacancy->description;
        $jobVacancy->count = $data['count'] ?? $jobVacancy->count;
        $jobVacancy->vacancy_status_id = $data['vacancy_status_id'] ?? $jobVacancy->vacancy_status_id;
        $jobVacancy->save();
        return $jobVacancy->load('department', 'vacancyStatus');
    }

    public function deleteJobVacancy($id): JobVacancy|Builder
    {
        $jobVacancy =JobVacancy::with('jobApplications')->find($id);
        if($jobVacancy['jobApplications']->isEmpty()){
            $jobVacancy::find($id)->delete();
        }
        else{
            foreach ($jobVacancy['jobApplications'] as $jobApplication) {
                if($jobApplication->applicationStatus->app_status_id==1) {
                    $jobVacancy['status'] = 400;
                    return $jobVacancy;
                }
            }
            foreach ($jobVacancy['jobApplications'] as $jobApplication) {
                $jobApplication->app_status_id=3;
                $jobApplication->save();
            }
            $jobVacancy['vacancy_status_id'] =3;
            $jobVacancy->save();
            $jobVacancy['status'] = 200;
        }
        return $jobVacancy;
    }
}
