<?php


namespace App\Application\Http\Resources;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed emp_id
 * @property mixed user
 * @property mixed job_app_id
 * @property mixed schedule_id
 * @property mixed leaves_balance
 * @property mixed job_title_id
 * @property mixed start_date
 * @property mixed start_working_date
 * @property mixed current_employment_status
 * @property mixed current_job_title
 */
class EmployeeBriefResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'emp_id' => $this->emp_id,
            'email' => $this->user->email,
            'username' => $this->user->username,
            'job_app_id' => $this->job_app_id,
            'schedule_id' => $this->schedule_id,
            'leaves_balance' => $this->leaves_balance,
            'job_title_id' => $this->current_job_title
                ? $this->current_job_title->job_title_id
                : null,
            'start_working_date' => $this->start_working_date,
            'current_employment_status' => $this->current_employment_status,
        ];
    }

}
