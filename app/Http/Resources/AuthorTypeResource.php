<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthorTypeResource extends JsonResource
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
            'active'        => (int) ($this->active),
            'activeValue'   => (string) ($this->value_of_active),
        ];
    }
}
