<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PrintingOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $vol_name = '(';
        foreach ($this->version->volumes as $volume) {
            $vol_name = $vol_name . ($vol_name == '(' ? '' : '-') . $volume->name;
        }
        $vol_name = $vol_name . ')';

        $book_name = $this->version->production->name . ', ' . $this->version->edition . ' edition' . ($vol_name != '()' ? ', Vol' . $vol_name : '') ?? 'Version';

        return [
            'id'                     => (int) $this->id,
            'book_name'              => (string)($book_name?? 'Volume'),
            'order_date'             => (int) ($this->order_date ?? ''),
            'copy_quantity'          => (int) ($this->copy_quantity ?? ''),
            'page_amount'            => (int) ($this->page_amount ?? ''),
            // 'stored_at'             => (object) ($this->stored_at ?? ''),
            'press'                  => (string) ($this->press->name ?? ''),
            // 'circulations'           => (object) ($this->circulations ?? []),
            'total_received'           => $this->circulations->sum('quantity'),
            'circulations'           => (object) (RequestCirculationResource::collection($this->circulations) ?? []),

            // 'buinding_type'          => (string) ($this->buinding_type->name ?? ''),
            // 'version_cost'           => (object) ($this->version_cost ?? ''),
            // 'version'                => (object) ($this->version->moderators ?? ''),
            // 'print_details'          => (object) ($this->print_details ?? ''),
            // 'printing_contributors'  => (object) ($this->printing_contributors ?? ''),
        ];
    }
}
