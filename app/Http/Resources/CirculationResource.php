<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CirculationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return
            [
                'id'  => (int) $this->id,
                'destinationable_id' => (int) ($this->destinationable_id ?? 0),
                'destination' => (string) ($this->destinationable->name ?? ''),
                'productId' => (int) ($this->storage->product->id ?? 0),
                'productName' => (string) ($this->storage->product->product_name ?? ''),
                'quantity'  => (int) ($this->quantity ?? 0),
                'circulationDate'  => (string) ($this->created_at->format('d-M-Y') ?? 0),
            ];
    }
}
