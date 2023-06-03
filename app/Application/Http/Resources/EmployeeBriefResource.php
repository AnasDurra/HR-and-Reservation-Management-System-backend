<?php


namespace App\Application\Http\Resources;

use App\Domain\Models\Department;
use App\Domain\Models\EmpData;
use App\Domain\Models\EmploymentStatus;
use App\Domain\Models\Staffing;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property integer emp_id
 * @property EmpData empData
 * @property Department current_department
 * @property Staffing staffings
 * @property EmploymentStatus current_employment_status
 *
 */
class EmployeeBriefResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'emp_id' => $this->emp_id,
            'name' => $this->empData->full_name,
            'department' => new DepartmentResource($this->staffings->current_department),
            'job_title' => new JobTitleResource($this->staffings->current_job_title),
            'status' => $this->current_employment_status->getAttribute('name'),
        ];
    }

}
