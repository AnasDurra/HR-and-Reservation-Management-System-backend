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
                'status' => $this->applicationStatus->app_status_id,
                'section_man_notes' => $this->section_man_notes,
                'vice_man_rec' => $this->vice_man_rec,
            ],

            // Employee data
            'employee_data' => new EmployeeDataResource($this->empData),

            // Job vacancy data
            'job_vacancy' => new JobVacancyResource($this->jobVacancy),

            // Application status data
            'application_status' => [
                'id' => $this->applicationStatus->app_status_id,
                'name' => $this->applicationStatus->name,
            ],
        ];
    }

}
