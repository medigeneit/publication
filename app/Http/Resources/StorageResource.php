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

        $press_quantity = ($this->product->productable->printings ? $this->product->productable->printings->groupBy('press_id')
        ->map(function ($row) {
            $due = $row->sum('copy_quantity') - $row->sum('received_quantity');
            return $due;
        }) : '');

        return
            [
                'id'                => (int) $this->id,
                'outletId'          => (int) ($this->outlet_id ?? 0),
                'outletName'        => (string) ($this->outlet->name ?? ''),
                'productId'         => (int) ($this->product_id ?? 0),
                'productName'       => (string) ($this->product->product_name ?? ''),
                'quantity'          => (int) ($this->quantity ?? 0),
                'alert_quantity'    => (int) ($this->alert_quantity ?? 0),
                'createdBy'         => (string) ($this->user->name ?? ''),
                'press_due_quantity'=> $press_quantity,
                // 'press'             => (object) ($this->product->productable->printings ? $this->product->productable->printings->groupBy('press_id')->sum('copy_quantity') : ''),
            ];
    }
}
