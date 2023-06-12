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
 * @property Staffing[] staffings
 * @property integer leaves_balance
 * @property EmploymentStatus employmentStatus
 * @property mixed current_employment_status
 * @property mixed current_department
 * @property mixed current_job_title
 * @property mixed start_working_date
 * @property mixed full_name
 * @property mixed schedule
 */
class EmployeeDetailsResource extends JsonResource
{
    #[Pure] public function toArray($request): array
    {
        return [


            // employee data
            'emp_id' => $this->emp_id,

            // user data
            'email' => $this->user->email,
            'username' => $this->user->username,
            'start_working_date' => $this->start_working_date,
            'leaves_balance' => $this->leaves_balance,

            // job application data
            'job_app_id' => $this->jobApplication->job_app_id,

            // schedule data
            'schedule' => new ScheduleResource($this->schedule),

            // job title data
            'current_job_title' => $this->current_job_title
                ? new JobTitleResource($this->current_job_title)
                : null,

            //  attendance (full information) (for later)
            // TODO: add attendance information
        ];
    }

}
