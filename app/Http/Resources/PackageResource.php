<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PackageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $product_names = [];
        $product_ids = [];

        if ($this->package_products) {
            foreach($this->package_products as $product){
                $product_names[] = [$product->product->product_name];
                $product_ids[] = [$product->product_id];
            }
        }
        
        return [
            'id'            => (int) $this->id,
            'name'          => (string) ($this->name ?? ''),
            'products'      => (array) ($product_names ?? []),
            'product_ids'   => (array) ($product_ids ?? []),
            // 'phone'         => (int) ($this->phone ?? ''),
            // 'email'         => (string) ($this->email ?? ''),
            // 'address'       => (string) ($this->address ?? ''),
            // 'active'        => (int) ($this->active ?? 0),
        ];
    }
}
