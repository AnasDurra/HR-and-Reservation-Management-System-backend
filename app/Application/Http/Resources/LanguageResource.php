<?php


namespace App\Application\Http\Resources;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed language_id
 * @property mixed name
 * @property mixed pivot
 * @property mixed speaking_level
 * @property mixed writing_level
 * @property mixed reading_level
 */
class LanguageResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->language_id,
            'name' => $this->name,
            'speaking_level' => $this->pivot->speaking_level,
            'writing_level' => $this->pivot->writing_level,
            'reading_level' => $this->pivot->reading_level,
        ];
    }
}
