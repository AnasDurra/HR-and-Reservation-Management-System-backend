<?php


namespace App\Application\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed training_course_id
 * @property mixed institute_name
 * @property mixed city
 * @property mixed start_date
 * @property mixed end_date
 * @property mixed specialize
 */
class TrainingCourseResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->training_course_id,
            'institute_name' => $this->institute_name,
            'city' => $this->city,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'specialize' => $this->specialize,
        ];
    }

}
