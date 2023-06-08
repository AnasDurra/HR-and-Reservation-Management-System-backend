<?php


namespace App\Application\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed job_app_id
 * @property mixed applicationStatus
 * @property mixed section_man_notes
 * @property mixed vice_man_rec
 * @property mixed empData
 * @property mixed jobVacancy
 */
class JobApplicationDetailsResource extends JsonResource
{
    public function toArray($request): array
    {
        return [

            // Job application data
            'job_application' => [
                'id' => $this->job_app_id,
                'status' => new ApplicationStatusResource($this->applicationStatus),
                'section_man_notes' => $this->section_man_notes,
                'vice_man_rec' => $this->vice_man_rec,
                'job_vacancy' => new JobVacancyResource($this->jobVacancy)
            ],

            // Employee data
            'employee_data' => new EmployeeDataResource($this->empData),

            // Application status data
            'application_status' => new ApplicationStatusResource($this->applicationStatus),
        ];
    }

}
