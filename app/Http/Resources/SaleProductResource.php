<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SaleProductResource extends JsonResource
{

    public $preserveKeys = true;

    public function toArray($request)
    {
        $data = [];
        $unit_price = (object )[
            1 => (float) ($this->wholesale_price ?? 0),
            2 => (float) ($this->retail_price ?? 0),
            3 => (float) ($this->distribute_price ?? 0),
            4 => (float) ($this->special_price ?? 0),
        ];

        $property = (object)[
            'name'          => (string) ($this->name ?? ''),
            'maxQuantity'   => (int) rand(10,20),
            'unitPrice'     => (object) $unit_price,

        ];

        // $data  = (object) [$this->id => $property];
        $data[$this->id]['id'] = $this->id;
        $data[$this->id]['name'] = $this->name;
        return $data;
        
    }
}
