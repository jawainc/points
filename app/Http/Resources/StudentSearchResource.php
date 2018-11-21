<?php

namespace App\Http\Resources;

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
        return [
            'text' => $this->full_name,
            'value' => [
                'id' => $this->id,
                'name' => $this->full_name,
                'courses' => $this->courses
            ]
        ];
    }
}
