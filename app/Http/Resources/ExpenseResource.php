<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseResource extends JsonResource
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
            'id' => (int) $this->id,
            'accountableType'   => (string)($this->accountable_type ?? ''),
            'accountableId'     => (int) ($this->accountable_id ?? ''),
            'publisherName'     => (string) ($this->publisher->name ?? ''),
            'purpose'           => (string) ($this->purpose ?? ''),
            'amount'            => (int) ($this->amount ?? ''),
            'type'              => (int) ($this->type ?? 0),
            'typeName'          => (string) ($this->value_of_type ?? ''),
            'createdBy'         => (string) ($this->user->name ?? ''),
        ];
    }
}
