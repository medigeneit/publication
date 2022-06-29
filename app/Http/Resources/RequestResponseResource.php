<?php

namespace App\Http\Resources;

use App\Models\RequestResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class RequestResponseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = [];
        $data['status'] = (int) $this->status ?? 1;
        $data['status_name'] = (string) RequestResponse::$Status[$this->status] ?? 1;
        $data['note'] = (string) $this->note ?? '';
        $data['quantity'] = (string) $this->quantity ?? '';
        $data['user_id'] = (int) $this->user->id ?? 0;
        $data['user_name'] = (string) $this->user->name ?? 0;
        $data['outlet_id'] = (int) $this->outlet->id ?? 0;
        $data['outlet_name'] = (string) $this->outlet->name ?? 0;

        return $data;
    }
}
