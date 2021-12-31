<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductionResource extends JsonResource
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
            'publisherId'   => (int) ($this->publisher_id ?? 0),
            'publisherName' => (string) ($this->publisher->name ?? ''),
            'createdBy'     => (string) ($this->user->name ?? '')
        ];
    }
}
