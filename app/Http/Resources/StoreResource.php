<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StoreResource extends JsonResource
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
            'value'=>$this->store_name,
            'salesman_name'=>$this->salesman_name,
            'full_address'=>$this->address.', '.$this->city.' '.$this->state.' '.$this->zip_code,
            'address'=>$this->address,
            'phone_no'=>$this->phone_no,
            'city'=>$this->city,
            'state'=>$this->state,
            'zip_code'=>$this->zip_code,
            'status'=>$this->status,
            'time'=>$this->created_at->format('d-m-Y H:i:s')

        ];
    }
}
