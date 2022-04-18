<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PrintingResource extends JsonResource
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
            'id'                     => (int) $this->id,
            'order_date'             => (int) ($this->order_date ?? ''),
            'copy_quantity'          => (int) ($this->copy_quantity ?? ''),
            'page_amount'            => (int) ($this->page_amount ?? ''),
            'press'                  => (string) ($this->press->name ?? ''),
            'buinding_type'          => (string) ($this->buinding_type->name ?? ''),
            'version_cost'           => (string) ($this->version_cost ?? ''),
            'printing_details'       => (string) ($this->printing_details ?? ''),
            'printing_contributors'  => (string) ($this->printing_contributors ?? ''),
        ];
    }
}
