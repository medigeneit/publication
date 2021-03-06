<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'id'            => (int) $this->id,
            'name'          => (string) ($this->name ?? ''),
            'priority'      => (int) ($this->priority ?? 0),
            'isMainParent'  => (boolean) (! $this->parent_id),
            'parentId'      => (int) ($this->parent_id ?? 0),
            'active'        => (boolean) ($this->active),
            'activeValue'   => (string) ($this->value_of_active ?? ''),
            'parentName'    => (string) ($this->parent->name ?? ''),
            'createdBy'     => (string) ($this->user->name ?? ''),
            'subcategories' => $this->subcategories->count() ? CategoryResource::collection($this->subcategories) : [],
        ];
    }
}
