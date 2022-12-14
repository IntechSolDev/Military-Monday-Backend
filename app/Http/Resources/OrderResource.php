<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return[
            
            'id'=>$this->id,
            'amount'=>$this->amount,
            'store_id'=>$this->store->id,
            'store_name'=>$this->store->store_name,
            'salesman_name'=>$this->store->salesman_name,
            'full_address'=>$this->store->address.', '.$this->store->city.' '.$this->store->state.' '.$this->store->zip_code,
            'date'=>$this->created_at->format('M d, Y')

        ];
    }
}
