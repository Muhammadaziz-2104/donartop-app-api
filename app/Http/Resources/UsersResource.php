<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UsersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'donar_id' => $this->donar,
            'city_id' => $this->city,
            'location_id' => $this->location,
            'blood_id' => $this->blood,
            'email' => $this->email,
            'birth_date' => $this->birth_date,
            'profession' => $this->profession,
            'phone' => $this->phone,
            'image' => $this->image,
            'status' => $this->status,
        ];


    }
}
