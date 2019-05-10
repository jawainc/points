<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PointResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'course_id' => $this->course_id,
            'student_id' => $this->student_id,
            'point_id' => $this->id,
            'points' => $this->points,
            'hours' => $this->total_hours,
            'notes' => $this->notes,
            'date' => $this->created_at->format('m/d/Y')
        ];
    }
}
