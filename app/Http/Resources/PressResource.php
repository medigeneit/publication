<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'            => (int) $this->id,
            'name'          => (string) ($this->name ?? ''),
            'phone'         => (int) ($this->phone ?? ''),
            'email'         => (string) ($this->email ?? ''),
            'address'       => (string) ($this->address ?? ''),
            'active'        => (int) ($this->active ?? 0),
        ];
    }
}
