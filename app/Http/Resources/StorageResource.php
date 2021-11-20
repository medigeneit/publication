<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StorageResource extends JsonResource
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
                'outletId' => (int) ($this->outlet_id ?? 0),
                'outletName' => (string) ($this->outlet->name ?? ''),
                'productId' => (int) ($this->product_id ?? 0),
                'productName' => (string) ($this->product->name ?? ''),
                'quantity'  => (int) ($this->quantity ?? 0),
                'createdBy'  => (string) ($this->user->name ?? ''),
            ];
    }
}
