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
            'categoryName'          => (string) ($this->category_product->category->name ?? ''),
            'publisherId'           => (int) ($this->publisher_id ?? 0),
            'publisherName'         => (string) ($this->publisher->name ?? ''),
            'productionCost'        => (float) ($this->production_cost ?? 0),
            'mrp'                   => (float) ($this->mrp ?? ''),
            'wholesalePrice'        => (float) ($this->wholesale_price ?? 0),
            'retailPrice'           => (float) ($this->retail_price ?? 0),
            'distributePrice'       => (float) ($this->distribute_price ?? 0),
            'specialPrice'          => (float) ($this->special_price ?? 0),
            'outsideDhakaPrice'     => (float) ($this->outside_dhaka_price ?? 0),
            'ecomDistributePrice'   => (float) ($this->ecom_distribute_price ?? 0),
            'ecomWholesalePrice'    => (float) ($this->ecom_wholesale_price ?? 0),
            'edition'               => (string) ($this->edition ?? ''),
            'isbn'                  => (string) ($this->isbn ?? ''),
            'crl'                   => (string) ($this->crl ?? ''),
            'alertQuantity'         => (int) ($this->alert_quantity ?? 0),
            'active'                => (int) ($this->active),
            'activeValue'           => (string) ($this->value_of_active),
            'createdBy'             => (string) ($this->user->name ?? ''),
            'storages'              => (int) ($this->storages->count() ?? '')
        ];
    }
}
