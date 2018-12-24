<?php

namespace App\Http\Resources;

use App\Course;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentSearchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $today = new Carbon('today');
        $enrollments = $this->enrollments()->where("start_date", "<=", $today->format('Y-m-d'))->pluck('course_id')->toArray();
        $courses = Course::whereIn('id', $enrollments)->get();
        return [
            'text' => $this->full_name,
            'value' => [
                'id' => $this->id,
                'name' => $this->full_name,
                'courses' => $courses,
                'group_id' => $this->student_group_id
            ]
        ];
    }
}
