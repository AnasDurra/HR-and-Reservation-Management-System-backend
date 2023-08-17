<?php

namespace App\Application\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Domain\Models\CD\UnRegisteredAccount;

class UnRegisteredAccountResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this['id'],
            'name' => $this['name'],
            'phone_number' => $this['phone_number'],
            'app' => [
                'id' => $this['appointment']['id'],
                'work_day_id' => $this['appointment']['work_day_id'],
                'status_id' => $this['appointment']['status_id'],
                'start_time' => $this['appointment']['start_time'],
                'end_time' => $this['appointment']['end_time'],
                'cancellation_reason' => $this['appointment']['cancellation_reason'],
                'created_at' => $this['appointment']['created_at'],
            ],
            'created_at' => $this['created_at']->format('Y-m-d_H:i:s'),
        ];
    }
}
