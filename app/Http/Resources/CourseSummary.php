<?php

namespace App\Http\Resources;

use App\Point;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseSummary extends JsonResource
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
            'course_id' => $this->id,
            'course_name' => $this->name,
            'quota' => $this->quota,
            'points' => CourseSummaryPoints::collection(Point::select(array(
                DB::Raw('sum(points) as sum_points'),
                DB::Raw('Date(created_at) as date')
            ))
                ->where('course_id', $this->id)
                ->whereRaw('DATE(created_at) >= ?', [$this->last_thursday->format('Y-m-d')])
                ->groupBy('date')
                ->orderBy('date', 'ASC')
                ->get()
            )
        ];
    }
}
