<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SaleResource extends JsonResource
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
            "id"                => (int) ($this->id),
            'outletId'          => (int) ($this->outlet_id ?? ''),
            'customerName'      => (string) ($this->customer_name ?? ''),
            'customerPhone'     => (int) ($this->customer_phone ?? ''),
            'customerAddress'   => (string) ($this->customer_address ?? ''),
            'subTotal'          => (float) ($this->subtotal ?? ''),
            'discount'          => (float) ($this->discount ?? ''),
            'discountPurpose'  => (string) ($this->discount_purpose ?? ''),
            'amount'            => (float) ($this->amount ?? ''),
        ];
    }
}
