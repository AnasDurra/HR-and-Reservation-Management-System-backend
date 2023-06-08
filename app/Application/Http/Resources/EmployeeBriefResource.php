<?php


namespace App\Application\Http\Resources;

use App\Domain\Models\EmploymentStatus;
use App\Domain\Models\JobApplication;
use App\Domain\Models\Schedule;
use App\Domain\Models\Staffing;
use App\Domain\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\Pure;

/**
 * @property User user
 * @property integer emp_id
 * @property JobApplication jobApplication
 * @property Schedule schedule
 * @property Staffing[] staffings
 * @property integer leaves_balance
 * @property EmploymentStatus employmentStatus
 * @property mixed current_employment_status
 * @property mixed current_department
 * @property mixed current_job_title
 * @property mixed start_working_date
 * @property mixed full_name
 */
class EmployeeBriefResource extends JsonResource
{
    #[Pure] public function toArray($request): array
    {
        return [

            // user data
            'email' => $this->user->email,
            'username' => $this->user->username,
            'user_type' => [
                'user_type_id' => $this->user->usertype->user_type_id,
                'name' => $this->user->usertype->name,
            ],

            // employee data
            'emp_id' => $this->emp_id,
            'first_name' => $this->jobApplication->empData->first_name,
            'last_name' => $this->jobApplication->empData->last_name,
            'full_name' => $this->full_name,
            'start_working_date' => $this->start_working_date,

            // job application data
            'job_app_id' => $this->jobApplication->job_app_id,
            'app_status' => [
                'app_status_id' => $this->jobApplication->applicationStatus->app_status_id,
                'name' => $this->jobApplication->applicationStatus->name,
            ],

            // schedule data
            'schedule' => new ScheduleResource($this->schedule),

            // staffing data
            'leaves_balance' => $this->leaves_balance,

            // department data
            'current_department' => $this->current_department
                ? new DepartmentResource($this->current_department)
                : null,

            // employment status data
            'current_employment_status' => $this->current_employment_status
                ? new EmploymentStatusResource($this->current_employment_status)
                : null,

            // job title data
            'current_job_title' => $this->current_job_title
                ? new JobTitleResource($this->current_job_title)
                : null,
        ];
    }

}
