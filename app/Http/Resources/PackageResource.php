<?php

namespace App\Http\Resources;

use App\Models\PriceCategory;
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

        $prices = $this->product->prices->pluck('amount', 'price_category_id');
        $package_prices = [];
        $price_categories = PriceCategory::pluck('name', 'id');

        foreach ($prices as $key => $value) {
            $package_prices[$price_categories[$key]] = $value;
        }
        
        if ($this->package_products) {
            foreach($this->package_products as $product){
                $product_names[] = [$product->product->product_name];
                $product_ids[] = [$product->product_id];
            }
        }
        $products = [];
        $product_prices = [];
        foreach($this->package_products as $package_product) {
            $package_product_prices =  $package_product->product->prices->pluck('amount', 'price_category_id');
            foreach ($package_product_prices as $key => $value) {
                $product_prices[$price_categories[$key]] = $value;
            }
            $products[$package_product->product->product_name] = $product_prices;
        }

        return [
            'id'                => (int) $this->id,
            'name'              => (string) ($this->name ?? ''),
            'products'          => (array) ($product_names ?? []),
            'product_ids'       => (array) ($product_ids ?? []),
            'package_products'  => (object) ($this->package_products ?? []),
            'total_cost'        => (float) ($this->total_cost ?? 0),
            'package_prices'    => (array) ($package_prices ?? []),
            'products'          => (array) ($products ?? []),
            'activeValue'       => (string) ($this->value_of_active),
        ];
    }
}
