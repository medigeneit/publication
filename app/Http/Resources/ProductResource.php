<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'id'                => (int) $this->id,
            'name'              => (string) ($this->name ?? ''),
            'type'              => (int) ($this->type ?? ''),
            'publisherId'      => (int) ($this->publisher_id ?? ''),
            'authorPercentage' => (float) ($this->author_percentage ?? ''),
            'mrp'               => (float) ($this->mrp ?? ''),
            'wholesalePrice'   => (float) ($this->wholesale_price ?? ''),
            'retailPrice'    => (float) ($this->retail_price ?? ''),
        ];
    }
}
