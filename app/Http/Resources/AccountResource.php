<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
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
            'purpose'           => (string) ($this->purpose ?? ''),
            'amount'            => (int) ($this->amount ?? ''),
            'type'              => (int) ($this->type ?? ''),
        ];
    }
}
