<?php

namespace App\Http\Resources;

use App\Models\Product;
use App\Models\Version;
use App\Models\Volume;
use Illuminate\Http\Resources\Json\JsonResource;

class PackageProductListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */

    static $price_categories = Null;

    public function toArray($request)
    {

        $product_type = $this->productable_type == Volume::class ? $this->productable->version->type : ($this->productable_type == Version::class ? $this->productable->type : 1);
        $type = ($product_type == 1 || $product_type == 3) ? 2 : ($product_type == 2 ? 3 : 2);

        $cost = $this->productable_type == Volume::class ? (string)($this->productable->version->last_printing->cost_per_unit??0 . '/' . $this->productable->version->volumes->count()) : ($this->productable_type == Version::class ? $this->productable->last_printing->cost_per_unit??0 : 0);

        return [
            'id'                    => (int) $this->id,
            'name'                  => (string) ($this->product_name ?? ''),
            'type'                  => (int) ($type ?? 0),
            'typeName'              => (string) (Product::types[$type] ?? ''),
            'productionCost'        => (string) ($cost ?? 0),
            'mrp'                   => (float) ($this->mrp ?? ''),
            'prices'                => (object) ($this->prices->pluck('amount', 'price_category_id') ?? []),
            'priceCategories'       => (object) (self::$price_categories ?? []),
        ];
    }
}
