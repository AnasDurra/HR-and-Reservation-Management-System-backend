<?php

namespace App\Application\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TimeSheetResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'consultant_id' => $this->consultant_id,
            'periods' => $this->intervals->map(function ($period) {
                return [
//                    'id' => $period->id,
                    'start_time' => $period->start_time,
                    'end_time' => $period->end_time,
                ];
            }),
        ];
    }
}
