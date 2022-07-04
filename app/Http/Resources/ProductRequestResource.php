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


    static $YourOutlet = null;

    public function toArray($request)
    {

        RequestCirculationResource::$Requested_by = $this->storage->outlet->id;
        RequestCirculationResource::$Request_type = $this->type;
        RequestCirculationResource::$YourOutlet = self::$YourOutlet;
        RequestResponseResource::$YourOutlet = self::$YourOutlet;



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
        // $data['responses2']       = (object) $this->responses ?? [];
        $data['current_storage']       =  $this->storage->product->storages->first()->quantity ?? 0;
        // $data['currentStorage']       = (object) $this->product->storages->quantity ?? 0;
        $data['responses']       = (object) RequestResponseResource::collection($this->responses) ?? [];
        $data['total_sent']     =  abs($this->whenLoaded('circulations', function(){
            return $this->circulations->sum('quantity');
        }));

        if (($data['requested_by']['id'] ?? 0) == self::$YourOutlet){
            $data['requested_by']['name'] = 'Your Outlet';
            $data['button_access'] = ['request_edit','request_close','stock_in'];
        }else{
            $data['button_access'] = ['request_accept','request_deny','stock_out'];
        }
        if (($data['requested_to']['id'] ?? 0) == self::$YourOutlet){
            $data['requested_to']['name'] = 'Your Outlet';
        }


        $data['circulations']      = (object) (RequestCirculationResource::collection($this->circulations) ?? []);

        return $data;
    }
}
