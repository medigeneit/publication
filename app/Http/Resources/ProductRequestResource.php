<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductRequestResource extends JsonResource
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
            'id'               => (int) $this->id ?? '',
            'productQuantity'  => (string) ($this->request_quantity ?? ''),
            'expectedDate'     => (string) ($this->expected_date ?? 0),
            'pending'          => (int) ($this->pending ?? 0),
            'storage'          => (object) ($this->storage ?? ''),
            'circulations'     => (object) ($this->circulations ?? ''),
        ];
    }
}
