<?php


namespace App\Application\Http\Resources;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReferenceResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->reference_id,
            'name' => $this->name,
            'job_title' => $this->job_title,
            'company_name' => $this->company_name,
            'phone' => $this->phone,
            'email' => $this->email,
        ];
    }
}
