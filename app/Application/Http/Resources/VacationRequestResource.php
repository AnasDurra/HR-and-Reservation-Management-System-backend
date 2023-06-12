<?php

namespace App\Application\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Domain\Models\VacationRequest;

class VacationRequestResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'vacation_req_id' => $this->vacation_req_id,
            'emp_id' => $this->emp_id,
            'req_stat' => $this->req_stat,
            'description' => $this->description,
            'start_date' => $this->start_date,
            'duration' => $this->duration,
            'current_job_title' => new JobTitleResource($this->employee->current_job_title),
            'current_department' => new DepartmentResource($this->employee->current_department),
            'first_name' => $this->employee->first_name,
            'last_name' => $this->employee->last_name,
        ];
    }
}
