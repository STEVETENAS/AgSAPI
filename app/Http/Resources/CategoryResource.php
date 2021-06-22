<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "Category's Name" => $this->name,
            'Registered Date' => substr($this->registeredDate,0,21),
        ];
    }
}
