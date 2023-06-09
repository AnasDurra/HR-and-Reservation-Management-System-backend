<?php

namespace App\Application\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Domain\Models\Absence;

/**
 * @property mixed $absence_id
 * @property mixed $emp_id
 * @property mixed $employee
 * @property mixed $absence_date
 * @property mixed $absenceStatus
 */
class AbsenceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'absence_id' => $this->absence_id,
            'absence_status' =>[
                'absence_status_id' => $this->absenceStatus->absence_status_id,
                'name' => $this->absenceStatus->name,
                'description' => $this->absenceStatus->description,
                ],
            'emp_id' => $this->emp_id,
            'full_name' => $this->employee->full_name,
            'absence_date' => $this->absence_date,
            'cur_dep' => $this->employee->cur_dep,
            'cur_title' => $this->employee->cur_title,
        ];
    }
}
