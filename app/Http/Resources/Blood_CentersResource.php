<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Blood_CentersResource extends JsonResource
{

    public static $wrap = 'blood_centers';
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'address'=>$this->address,
            'director' => $this->director,
            'work_time' => $this->work_time,
            'phone' => $this->phone,
            'phone2' => $this->phone2,
            'email' => $this->email,
            'location' => $this->location,
        ];
    }
}
