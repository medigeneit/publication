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
                    'saleDetailsId' => $sold_product->id ?? '',
                    'productId' => $sold_product->product_id ?? '',
                    'name' => $sold_product->product->product_name ?? '',
                    'quantity' => $sold_product->quantity ?? '',
                    'priceType' => $sold_product->price_category->name ?? '',
                    'unitPrice' => $sold_product->unit_price ?? '',
                ];
            }
        }

        $data = [
            "id"                => (int) ($this->id),
            "memoType"          => (string) ($this->memo_type),
            'outletId'          => (int) ($this->outlet_id ?? ''),
            'outletName'        => (string) ($this->outlet->name ?? ''),
            'customerName'      => (string) ($this->customer->name ?? ''),
            'customerPhone'     => (string) ($this->customer->phone ?? ''),
            'customerEmail'     => (string) ($this->customer->email ?? ''),
            'payable'           => (float) ($this->payable ?? ''),
            'discount'          => (float) ($this->discount ?? ''),
            'discountPurpose'   => (string) ($this->discount_purpose ?? ''),
            'paid'              => (float) ($paid_ammount ?? 0),
            'due'               => (float) ($due ?? 0),
            'dueCondition'      => (string) ($this->payments->sortByDesc('created_at')->first()->due_condition ?? ''),
            'amount'            => (float) ($this->amount ?? ''),
            'createdBy'         => (string) ($this->user->name ?? ''),
            'createdAt'         => (string) ($this->created_at->format("d/m/Y") ?? '')
        ];

        if (self::$show) {

            $data = array_merge($data ,[
                'outletPhone'           => (string) ($this->outlet->phone ?? ''),
                'outletEmail'           => (string) ($this->outlet->email ?? ''),
                'outletAddress'         => (string) ($this->outlet->address ?? ''),
                // 'customerAddress'       => (string) ($this->customer->address->address  ?? ''),
                // 'customerArea'          => (string) ($this->customer->address->area->name  ?? ''),
                // 'customerDistrict'      => (string) ($this->customer->address->area->district->name  ?? ''),
                'customerAddress'      => (string) ($this->customer->address->address.', '. $this->customer->address->area->district->name . ', ' . $this->customer->address->area->name  ?? ''),
                'productDetails'        => (object) ($product_details),
            ]);

            
            if ($this->memo_type === 3 && $this->genesis_info){
                $data = array_merge($data ,[
                    'reg'       => (string) ($this->genesis_info->reg_no ?? ''),
                    'course'    => (string) ($this->genesis_info->course_name ?? ''),
                    'batch'     => (string) ($this->genesis_info->batch_name ?? ''),
                ]);
            }
            else{
                $data = array_merge($data ,[
                    'reg'       => (string) (''),
                    'course'    => (string) (''),
                    'batch'     => (string) (''),
                ]);
            }

        }

        // // ];
        return $data;
    }
}
