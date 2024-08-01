<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BloodNeedsResource extends JsonResource
{
    public static $wrap = 'blood_needs';
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'featured'=>$this->featured,
            'name'=>$this->name,
            'blood_id'=>$this->blood,
            'city_id'=>$this->city,
            'location_id'=>$this->location,
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
