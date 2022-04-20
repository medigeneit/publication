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
            'stored_at'        => (object) ($this->stored_at ?? ''),
            'press'                  => (string) ($this->press->name ?? ''),
            'buinding_type'          => (string) ($this->buinding_type->name ?? ''),
            'version_cost'           => (object) ($this->version_cost ?? ''),
            'print_details'          => (object) ($this->print_details ?? ''),
            'print_details'          => (object) ($this->print_details ?? ''),
            'printing_contributors'  => (object) ($this->printing_contributors ?? ''),
            'book_name'              => (object)($this->version->production ?? '')
        ];
    }
}
