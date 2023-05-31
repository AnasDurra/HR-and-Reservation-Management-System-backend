<?php


namespace App\Application\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

/**
 * @property mixed $job_app_id
 * @property mixed empData
 * @property mixed jobVacancy
 * @property mixed applicationStatus
 * @property mixed created_at
 */
class JobApplicationBriefResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array|JsonSerializable|Arrayable
     */
    public function toArray(Request $request): array|JsonSerializable|Arrayable
    {
        return [
            'id' => $this->job_app_id,
            'employee_name' => $this->empData->full_name,
            'department_name' => $this->jobVacancy->department->name,
            'job_name' => $this->jobVacancy->name,
            'status' => $this->applicationStatus->app_status_id,
            'created_at' => $this->created_at,
        ];
    }
}
