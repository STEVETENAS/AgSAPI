<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "User's Id" => $this->studId,
            'First Name' => $this->fName,
            'Last Name' => $this->lName,
            'Email' => $this->email,
            'Tel' => $this->tel,
            'User Course ID' => $this->idCourse,
            'is Admin?' => $this->admin,
            'Registered Date' => substr($this->registeredDate,0,21),
        ];
    }
}
