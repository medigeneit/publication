<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VersionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $release_date = date("d-M-Y", strtotime($this->release_date));
        
        return [
            'id'                    => (int) $this->id,
            'name'                  => (string) ($this->production->name ?? ''),
            'edition'               => (string) ($this->edition ?? ''),
            'type'                  => (int) ($this->type ?? 0),
            'typeName'              => (string) ($this->value_of_type ?? ''),
            'releaseDate'           => (string) ($release_date ?? ''),
            'publisherName'         => (string) ($this->production->publisher->name ?? ''),
            'productionCost'        => (float) ($this->production_cost ?? ''),
            'volumes'               => (object) ($this->volumes ?? ''),
            'volumesCount'          => (int) ($this->volumes->count() ?? ''),
            'createdBy'             => (string) ($this->user->name),
            'active'                => (int) ($this->active),
            'activeValue'           => (string) ($this->value_of_active),
        ];
    }
}
