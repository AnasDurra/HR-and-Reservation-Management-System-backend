<?php

namespace App\Application\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobTitleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'job_title_id' => $this['job_title_id'],
            'name' => $this['name'],
            'description' => $this['description'],
            'employees_count' => $this['employees_count'],
            'deleted_at' => $this['deleted_at'],
            'permissions' => $this['permissions']
        ];
    }
}
