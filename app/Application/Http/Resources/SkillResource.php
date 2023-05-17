<?php


namespace App\Application\Http\Resources;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed skill_id
 * @property mixed name
 */
class SkillResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->skill_id,
            'name' => $this->name,
        ];
    }
}
