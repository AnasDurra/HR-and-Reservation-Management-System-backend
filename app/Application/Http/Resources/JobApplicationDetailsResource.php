<?php


namespace App\Application\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class JobApplicationDetailsResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'job-application_id' => $this->job_app_id,
            'employee_first-name'=> $this->empData->first_name,
            'employee_last-name'=> $this->empData->last_name,
            'department_name' => $this->jobVacancy->department->name,
            'job_name' => $this->jobVacancy->name,
            'status' => $this->applicationStatus->name,
//            'job_vacancy' => new JobVacancyResource($this->jobVacancy),
//            'application_status' => new ApplicationStatusResource($this->applicationStatus),
//            'created_at' => $this->created_at,
        ];
    }

}
