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

        $paid_ammount = 0;
        foreach( $this->payments as $payment){
            $paid_ammount += $payment->amount;
        }

        $due = $this->payable - $paid_ammount;


        return [
            "id"                => (int) ($this->id),
            'outletId'          => (int) ($this->outlet_id ?? ''),
            'outletName'        => (string) ($this->outlet->name ?? ''),
            'customerName'      => (string) ($this->customer->name ?? ''),
            'customerPhone'     => (int) ($this->customer->phone ?? ''),
            'customerAddress'   => (string) ($this->customer_address ?? ''),
            'payable'           => (float) ($this->payable ?? ''),
            'discount'          => (float) ($this->discount ?? ''),
            'discountPurpose'   => (string) ($this->discount_purpose ?? ''),
            'paid'              => (float) ($paid_ammount ?? 0),
            'due'               => (float) ( $due ?? 0),
            'dueCondition'      => (string) ($this->payments->sortByDesc('created_at')->first()->due_condition ?? ''),
            'amount'            => (float) ($this->amount ?? ''),
            'createdBy'         => (string) ($this->user->name ?? '')
        ];
    }
}
