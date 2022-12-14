<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use App\Models\FavProduct;
class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $user = Auth::user();
        $is_creator = $this->user_id == $user->id ?  true : false ;
        $product_status = 'pending';
            if($this->product_status == 'active')
                {
                       if($request->time > $this->end_time) {
                          $product_status = 'expired';
                        }
                        else
                        {
                            $product_status = 'approved';
                        }
                    
                }
        
            if($request->date == $this->date)
            {
                if (($request->time >= $this->start_time )&& ($request->time <= $this->end_time)) {
                   $product_status = 'live';
                } 
                elseif ($request->time > $this->end_time) {
                   $product_status = 'expired';
                }
            }  
           if($request->date > $this->date)
            {
                $product_status = 'expired';
            }
        
        return[
            'id'=>$this->id,
            'is_creator'=>$is_creator,
            'name'=>$this->name,
            'user'=>$this->user,
            'final_price'=>$this->final_price,
            'price'=>$this->price,
            'quantity'=>$this->quantity,
            'discount_price'=>$this->discount_price,
            'discount_percent'=>$this->discount_percent,
            'description'=>$this->description,
            'type'=>$this->type,
            'url'=>$this->url,
            'store'=>$this->store,
            'store_url'=>$this->store_url,
            'phoneno'=>$this->phoneno,
            'image'=>$this->image,
            'start_time'=>$this->start_time,
            'end_time'=>$this->end_time,
            'sort'=>$product_status == "live" ? 0  : 1,
            'date'=>$this->date,
            'current_date'=>$request->date,
            'current_product'=>$product_status,
            'current_time'=>$request->time ? $request->time  : '',
        ];
    }
}
