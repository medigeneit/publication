<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PrintingDetailCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return [
        //     'id'                    => (int) $this->id,
        //     'name'                  => (string) ($this->name ?? ''),
        //     'value'                  => (object) ($this->values ?? ''),
        //     'active'                  => (string) ($this->active ?? ''),
        // ];

        return [
            'id'            => (int) $this->id,
            'name'          => (string) ($this->name ?? ''),
            'priority'      => (int) ($this->priority ?? 0),
            'isMainParent'  => (bool) (!$this->parent_id),
            'parentId'      => (int) ($this->parent_id ?? 0),
            'active'        => (bool) ($this->active),
            'activeValue'   => (string) ($this->value_of_active ?? ''),
            'parentName'    => (string) ($this->parent->name ?? ''),
            'createdBy'     => (string) ($this->user->name ?? ''),
            'values'        => $this->values->count() ? PrintingDetailCategoryResource::collection($this->values) : [],
        ];
    }
}
