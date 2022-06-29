<?php

namespace App\Http\Resources;

use App\Models\ProductRequest;
use App\Models\RequestResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */



    public function toArray($request)
    {

        RequestCirculationResource::$Requested_by = $this->storage->outlet->id;
        RequestCirculationResource::$Request_type = $this->type;



        // $status = ($this->responses ? 1 : $this->responses->sortByDesc('created_at')->first()->status);
        $status = $this->is_closed ?? 0;
        $data = [];

        $data['id']                = (int) $this->id ?? '';
        $data['requested_by']      = (array) ($this->storage->outlet->only(['id', 'name']) ?? []);
        $data['requested_to']      = (array)  ($this->outlet ? $this->outlet->only(['id', 'name']) : []);
        $data['product_info']      = (array) ($this->storage->product->only(['id', 'product_name']) ?? []);
        $data['product_quantity']  = (string) ($this->request_quantity ?? '');
        $data['expected_date']     = (string) ($this->expected_date ?? 0);
        $data['type']              = (int) ($this->type ?? 1);
        $data['type_name']         = (string) ProductRequest::$Type[($this->type ?? 1)];
        $data['status']            = (int)  $status;
        $data['status_name']       = (string)  $status == 1 ? 'Closed' : 'Pending';
        // $data['responses']       = (object) $this->responses ?? [];
        $data['responses']       = (object) RequestResponseResource::collection($this->responses) ?? [];
        // 'storage'           => (object) ($this->storage ?? ''),
        // 'user'              => (object) ($this->user ?? ''),
        // 'created_by'        => (object) ($this->user->only(['id','name']) ?? NULl),

        $data['circulations']      = (object) (RequestCirculationResource::collection($this->circulations) ?? []);

        return $data;
    }
}
