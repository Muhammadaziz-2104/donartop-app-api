<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use function Symfony\Component\Mime\attach;

class DonarsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'featured'=>$this->featured,
            'name'=>$this->name,
            'blood_id'=>$this->blood,
            'city_id'=>$this->city,
            'location_id'=>$this->location,
            'user_id' => $this->user,
            'religion'=>$this->religion,
            'email'=>$this->email,
            'phone'=>$this->phone,
            'profession'=>$this->profession,
            'details'=>$this->details,
            'image'=>$this->image,
            'address'=>$this->address,
            'total_donate'=>$this->total_donate,
            'gender'=>$this->gender,
            'status'=>$this->status,
            'birth_date'=>$this->birth_date,
            'last_donate'=>$this->last_donate,
            'socialMedia'=>$this->socialMedia
        ];
    }
}
