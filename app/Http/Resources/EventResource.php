<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'Event Title' => $this->title,
            'Event Details' => $this->details,
            "Event Category's ID" => $this->idCategory,
            "Event publisher's ID"  => $this->idUser,
            'Event Start Date' => $this->dateDebut,
            'Event End Date' => $this->dateFin,
            'Is public?' => $this->public,
            'Registered Date' => substr($this->registeredDate,0,21),
        ];
    }
}
