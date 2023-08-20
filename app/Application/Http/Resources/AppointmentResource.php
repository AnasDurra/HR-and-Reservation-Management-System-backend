<?php

namespace App\Application\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Transform the resource into an array.
 *
 * @return array<string, mixed>
 */
class AppointmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'status_id' => $this->status_id,
            'customer_id' => $this->customer_id,
            //get customer name
            'customer_name' => $this->customer ? $this->customer->getFullNameAttribute() : null,
            'phone_number' => $this->customer ? $this->customer->phone_number : null,
            'cancellation_reason' => $this->cancellation_reason,
            'date' => $this->workDay->day_date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'status' => [
                'id' => $this->status ? $this->status->id : null,
                'name' => $this->status ? $this->status->name : null,
                'customer_name' => $this->unRegisteredAccount ? $this->unRegisteredAccount->name : null,
                'phone_number' => $this->unRegisteredAccount ? $this->unRegisteredAccount->phone_number : null,
            ],
        ];
    }
}
