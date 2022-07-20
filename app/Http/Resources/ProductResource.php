<?php

namespace App\Http\Resources;

use App\Models\Package;
use App\Models\Product;
use App\Models\Version;
use App\Models\Volume;
use Illuminate\Http\Resources\Json\JsonResource;
use PhpParser\Node\Expr\Cast\Object_;

class ProductResource extends JsonResource
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

        $product_type = $this->productable_type == Volume::class ? $this->productable->version->type : ($this->productable_type == Version::class ? $this->productable->type : ($this->productable_type == Package::class ? 4 : 1));
        $type = ($product_type == 1 || $product_type == 3) ? 2 : ($product_type == 2 ? 3 : ($product_type == 4 ? 1 : 2));;
        // $type = $product_type == 3 ? 2 : ($product_type == 2 ? 3 : ($product_type == 1 ? 1: 2));

        $cost = $this->productable_type == Volume::class ? (string)($this->productable->version->last_printing->cost_per_unit ?? 0 . '/' . $this->productable->version->volumes->count()) : ($this->productable_type == Version::class ? $this->productable->last_printing->cost_per_unit ?? 0 : ($this->productable_type == Package::class ? $this->productable->total_cost : 0));
        // $cost = $this->productable_type == Volume::class ? (string)($this->productable->version->production_cost . '/' . $this->productable->version->volumes->count()) : ($this->productable_type == Version::class ? $this->productable->production_cost : 0);
        $publisher_name = $this->productable_type == Volume::class ? ($this->productable->version->production->publisher->name) : ($this->productable_type == Version::class ? $this->productable->production->publisher->name : '');

        $moderators = $this->productable_type == Volume::class ? ($this->productable->version->moderators) : ($this->productable_type == Version::class ? $this->productable->moderators : []);
        $alert_quantity = $this->productable_type == Volume::class ? ($this->productable->version->alert_quantity) : ($this->productable_type == Version::class ? $this->productable->alert_quantity : 0);

        $storage_pack = NULL;

        $package_products = $this->productable->package_products;
        $product_names = [];
        $product_ids = [];
        $pacakge_id= '';

        if ($package_products) {
            foreach ($package_products as $product) {
                $product_names[$product->product_id] = [$product->product->product_name];
                $product_ids[] = [$product->product_id];
                $pacakge_id = $product->package_id;
            }
        }

        if ($this->productable_type == Package::class) {
            $storage_pack = $this->storages->map(function ($storage) use($package_products) {
                // $storage_pack_storage = $package_products;
                $package_product_quantity = $package_products->map(function ($package_product) use($storage) {
                    return $package_product->product->storages->where('outlet_id', $storage->outlet_id )->first();
                });
                // $storage_pack_storage->quantity = 987654321;
                // return $storage_pack_storage;
                 $storage->quantity =  $package_product_quantity->min('quantity');
                //  $storage->asfafasfasfasf =  $package_product_quantity;
                return $storage;
            });
        }


        return [
            'id'                    => (int) $this->id,
            'name'                  => (string) ($this->product_name ?? ''),
            'type'                  => (int) ($type ?? 0),
            'typeName'              => (string) (Product::types[$type] ?? ''),
            'soft'                  => (int) ($this->soft ?? ''),
            'publisherId'           => (int) ($this->publisher_id ?? 0),
            'publisherName'         => (string) ($publisher_name ?? ''),
            'productionCost'        => (string) ($cost ?? 0),
            'mrp'                   => (float) ($this->mrp ?? ''),
            'prices'                => (object) ($this->prices->pluck('amount', 'price_category_id') ?? []),
            'priceCategories'       => (object) (self::$price_categories ?? []),
            'volume'                => (object) ($this->productable_type == Version::class ? $this->productable->volumes : ($this->productable_type == Version::class ? $this->productable:[])),
            'productable'           => (object) ($this->productable ?? ''),
            'active'                => (int) ($this->active),
            'activeValue'           => (string) ($this->value_of_active),
            'createdBy'             => (string) ($this->user->name ?? ''),
            'categories'            => (object) ($this->categories),
            'categoryCount'         => (int) ($this->categories->count()),
            'moderators'            => (object) ($moderators ?? []),
            'total_storage'         => (int) ($this->storages->pluck('quantity')->sum() ?? 0),
            'storage_outlets'       => (array) ($this->storages->pluck('outlet_id')->toArray() ?? []),
            'storages'              => (object) ($storage_pack ?? ($this->storages ?? [])),
            'alert_quantity'        => (int) ($alert_quantity ?? 0),
            'package_product_ids'   => (array) ($product_ids ?? []),
            'package_product_names' => (array) ($product_names ?? []),
            'pacakge_id'            => (int) ($pacakge_id ?? 0),
            'img'                   => (string) ($pacakge_id ?? 0),
            // 'wholesalePrice'        => (float) ($this->prices->amount ?? 0),
            // 'retailPrice'           => (float) ($this->retail_price ?? 0),
            // 'distributePrice'       => (float) ($this->distribute_price ?? 0),
            // 'specialPrice'          => (float) ($this->special_price ?? 0),
            // 'outsideDhakaPrice'     => (float) ($this->outside_dhaka_price ?? 0),
            // 'ecomDistributePrice'   => (float) ($this->ecom_distribute_price ?? 0),
            // 'ecomWholesalePrice'    => (float) ($this->ecom_wholesale_price ?? 0),

            // 'edition'               => (string) ($this->edition ?? ''),
            // 'isbn'                  => (string) ($this->isbn ?? ''),
            // 'crl'                   => (string) ($this->crl ?? ''),
            // 'storages'              => (int) ($this->storages->count() ?? ''),
            // 'packageProducts'       => (object) ($this->package_products),
            // 'packageProductCount'   => (int) ($this->package_products->count()),
        ];
    }
}
