<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'Course Name' => $this->name,
            'Registered Date' => substr($this->registeredDate,0,21)
        ];
    }
}
