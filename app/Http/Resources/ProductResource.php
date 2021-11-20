<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'id'                    => (int) $this->id,
            'name'                  => (string) ($this->name ?? ''),
            'type'                  => (int) ($this->type ?? 0),
            'typeName'              => (string) ($this->value_of_type ?? ''),
            'publisherId'           => (int) ($this->publisher_id ?? 0),
            'publisherName'         => (string) ($this->publisher->name ?? ''),
            'productionCost'        => (float) ($this->production_cost ?? 0),
            'mrp'                   => (float) ($this->mrp ?? ''),
            'wholesaleRate'         => (float) ($this->wholesale_rate ?? 0),
            'retailRate'            => (float) ($this->retail_rate ?? 0),
            'alertQuantity'         => (int) ($this->alert_quantity ?? 0),
            'active'                => (int) ($this->active),
            'activeValue'           => (string) ($this->value_of_active),
            'createdBy'             => (string) ($this->user->name ?? '')
        ];
    }
}
