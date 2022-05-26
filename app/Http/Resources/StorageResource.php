<?php

namespace App\Http\Resources;

use App\Models\Package;
use App\Models\Storage;
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

        $press_quantity = ($this->product->productable->printings ? $this->product->productable->printings->groupBy('press_id')
        ->map(function ($row) {
            $due = $row->sum('copy_quantity') - $row->sum('received_quantity');
            return $due;
        }) : '');

        $min_quantity = null;

        if($this->product->productable_type == Package::class) {
            $package_product_quantity = $this->product->productable->package_products
                ->map(function ($package_product) {
                    return $package_product->product->storages->where('outlet_id', $this->outlet_id)->first();
                });
            $min_quantity =  $package_product_quantity->min('quantity');

        }
        // if($this->product->productable_type == Package::class) {
        //     $min_quantity = Storage::query()
        //         ->whereIn('product_id', $this->product->productable->package_products->pluck('product_id'))
        //         ->where('outlet_id', $this->outlet_id)
        //         ->min('quantity');
        // }

        return
            [
                'id'                    => (int) $this->id,
                'outletId'              => (int) ($this->outlet_id ?? 0),
                'outletName'            => (string) ($this->outlet->name ?? ''),
                'productId'             => (int) ($this->product_id ?? 0),
                'productName'           => (string) ($this->product->product_name ?? ''),
                // 'quantity'              => (int) ($min_quantity ?? ($this->quantity ?? 0)),
                'quantity'              =>($min_quantity ?? ($this->quantity ?? 0)),
                'alert_quantity'        => (int) ($this->alert_quantity ?? 0),
                'createdBy'             => (string) ($this->user->name ?? ''),
                'press_due_quantity'    => $press_quantity,

                // 'press'             => (object) ($this->product->productable->printings ? $this->product->productable->printings->groupBy('press_id')->sum('copy_quantity') : ''),
            ];
    }
}
