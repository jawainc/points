<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CourseStudents as CourseStudentsResource;

class CourseStudentPoints extends JsonResource
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
            'course_id' => $this->id,
            'course_name' => $this->name,
            'students' => CourseStudentsResource::collection($this->enrollments)
        ];
    }
}
