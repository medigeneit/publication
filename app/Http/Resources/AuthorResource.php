<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthorResource extends JsonResource
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
            'phone'         => (string) ($this->phone ?? ''),
            'email'         => (string) ($this->email ?? ''),
            'address'       => (string) ($this->address ?? ''),
            'honorarium'    => (float) ($this->honorarium ?? 0.00),
            'active'        => (bool) ($this->active ?? ''),
            'activeValue'   => (string) ($this->value_of_active ?? ''),
            'createdBy'     => (string) ($this->user->name ?? '')
        ];
    }
}
