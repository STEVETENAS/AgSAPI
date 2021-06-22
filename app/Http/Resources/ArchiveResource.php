<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class ArchiveResource extends JsonResource{

    public function toArray($request){
        return [
            'Archive Name' => $this->name,
            "Archive's Event ID" => $this->idEvent,
            'Registered Date' => substr($this->registeredDate,0,21),
        ];
    }
}
