<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CitiesResource extends JsonResource
{
    public static $wrap = 'cities';
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
            'name' => $this->name,
            'status' =>$this->status,
        ];

    }
}
