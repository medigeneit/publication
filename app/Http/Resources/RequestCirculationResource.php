<?php

namespace App\Http\Resources;

use App\Models\ProductRequest;
use App\Models\RequestResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class RequestCirculationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */

    static $Requested_by = null;
    static $Request_type = null;
    static $YourOutlet = null;


    public function toArray($request)
    {
        $data =    [

            'id'  => (int) $this->id,
            'circulation_of_id' => (int)  ($this->storage->outlet->id  ?? ''),
            'circulation_of' => (string)  ($this->storage->outlet->name  ?? ''),
            'destination_id' => (int) ($this->destinationable_id ?? 0),
            'destination' => (string) ($this->destinationable->name ?? ''),
            // 'productId' => (int) ($this->storage->product->id ?? 0),
            // 'productName' => (string) ($this->storage->product->product_name ?? ''),
            'quantity'  => (int) ($this->quantity ?? 0),
            'circulationDate'  => (string) ($this->created_at->format('d-M-Y') ?? 0),
            'total_received' => $this->whenLoaded('circulations', function(){
                return $this->circulations->sum('quantity');
            }),
            // 'total_received' => $this->whenLoaded('circulations')->sum('quantity'),
            'circulations' => $this->whenLoaded('circulations', function(){
                return RequestCirculationResource::collection($this->whenLoaded('circulations'));
            }),
            // 'circulations' => ,

        ];

        if (($data['circulation_of_id'] ?? 0) == self::$YourOutlet){
            $data['circulation_of'] = 'Your Outlet';
        }

        if (($data['destination_id'] ?? 0) == self::$YourOutlet){
            $data['destination'] = 'Your Outlet';
        }
        return $data;
    }
}
