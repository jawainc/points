<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseStudents extends JsonResource
{
    protected  $last_thursday;

    public function __construct($resource)
    {
        parent::__construct($resource);
        $this->last_thursday = Carbon::parse('last Thursday');
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request)
    {
        return [
            'student_id' => $this->student_id,
            'student_name' => $this->student->full_name,
            'points' => PointResource::collection($this->points()
                ->whereRaw('DATE(created_at) >= ?', [$this->last_thursday->format('Y-m-d')])
                ->orderBy('created_at', 'ASC')
                ->get()
            )
        ];
    }
}
