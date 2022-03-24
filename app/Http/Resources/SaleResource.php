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

    static $show = false;

    public function toArray($request)
    {

        $paid_ammount = 0;
        foreach ($this->payments as $payment) {
            $paid_ammount += $payment->amount;
        }

        $due = $this->payable - $paid_ammount;

        if (self::$show) {
            $product_details = [];
            foreach ($this->sale_details as $sold_product) {
                $product_details[] = [
                    'saleDetailsId' => $sold_product->id,
                    'productId' => $sold_product->product_id,
                    'name' => $sold_product->product->product_name,
                    'quantity' => $sold_product->quantity,
                    'priceType' => $sold_product->price_category->name,
                    'unitPrice' => $sold_product->unit_price,
                ];
            }
        }

        $data = [
            "id"                => (int) ($this->id),
            'outletId'          => (int) ($this->outlet_id ?? ''),
            'outletName'        => (string) ($this->outlet->name ?? ''),
            'customerName'      => (string) ($this->customer->name ?? ''),
            'customerPhone'     => (int) ($this->customer->phone ?? ''),
            'payable'           => (float) ($this->payable ?? ''),
            'discount'          => (float) ($this->discount ?? ''),
            'discountPurpose'   => (string) ($this->discount_purpose ?? ''),
            'paid'              => (float) ($paid_ammount ?? 0),
            'due'               => (float) ($due ?? 0),
            'dueCondition'      => (string) ($this->payments->sortByDesc('created_at')->first()->due_condition ?? ''),
            'amount'            => (float) ($this->amount ?? ''),
            'createdBy'         => (string) ($this->user->name ?? '')
        ];

        if (self::$show) {

            $data = array_merge($data ,[
                'outletPhone'        => (string) ($this->outlet->phone ?? ''),
                'outletEmail'        => (string) ($this->outlet->email ?? ''),
                'outletAddress'        => (string) ($this->outlet->address ?? ''),
                'customerAddress'   => (string) ($this->customer->address->address  ?? ''),
                'customerArea'   => (string) ($this->customer->address->area->name  ?? ''),
                'customerDistrict'   => (string) ($this->customer->address->area->district->name  ?? ''),
                'productDetails'   => (object) ($product_details),
            ]);
        }

        // // ];
        return $data;
    }
}
