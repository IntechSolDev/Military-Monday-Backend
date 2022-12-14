<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailResource extends JsonResource
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
                    "order_id"=>$this->order_id,
                    "order_product_price"=>$this->price,
                    "order_product_quantity"=>$this->quantity,
                    "product_id"=>$this->product->id,
                    "sku"=>$this->product->sku,
                    "name"=>$this->product->name,
                    "unitPrice"=>$this->product->unitPrice,
                    "minQty"=>$this->product->minQty,
                    "multQty"=>$this-> product->multQty,
                    "barcode"=>$this-> product->barcode,
                    "longDesc"=>$this->product->longDesc,
                    "category"=>$this->product->category,
                    "status"=>$this->product->status,
                    "date"=>$this->product->created_at->format('H:i')

        ];
    }
}
