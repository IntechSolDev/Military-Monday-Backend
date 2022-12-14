<?php

namespace App\Http\Resources;
use App\Models\User;
use App\Models\Rate;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $sale_price = 0;
        $sale_percent = 0;
        $discount_price = 0;
        
        if($this->product->discount_price !=null )    // Price Discount Calculate
        {
          $sale_price =  $this->product->price - $this->product->discount_price;
          $sale_percent = (($sale_price / $this->product->price )  *  100);
          $sale_percent =  ceil(100-$sale_percent);
          $discount_price = $this->product->discount_price;
        }
        
         elseif($this->product->discount !=null )        // Percent Price Discount Calculate
        {
            $sale_price = $this->product->price - ($this->product->price * $this->product->discount / 100);
            $sale_percent = $this->product->discount;
            $discount_price = $this->product->price - $sale_price;
        }
        
        else
        {
             $sale_price = $this->product->price;
             $sale_percent = null;
             $discount_price = null;
        }
        
        
       $user_data =  User::find($this->user_id);
       $business_data =  User::find($this->business_id);
       
       $delivery_day = explode('to',$this->delivery_days,2);
       $delivery_end_day = explode(' ',$delivery_day[1],-1);
       $total_delivery = (int)$delivery_end_day[0];
       
       
       $derliver_start = $this->created_at->format('D d M');
       
       $startDate = $this->created_at->format('Y-m-d');
       
       $derliver_end =  date('D d M', strtotime($startDate. "+$total_delivery days" ));
       
       $rate = Rate::where('product_id',$this->product->id);
       $avg_rate = $rate->avg('rate');
       $user_rate_count = $rate->count();
     
        return[
            'id'=>$this->id,
            'order_id'=>$this->order_id,
            'career_id'=>$user_data->id,
            'career_name'=>$user_data->firstname .' '.$user_data->lastname,
            'business_id'=>$business_data->id,
            'business_name'=>$business_data->firstname .' '.$business_data->lastname,
            'product_id'=>$this->product->id,
            'category_id'=>$this->product->category_id,
            'title'=>$this->product->title,
            'subtitle'=>$this->product->subtitle,
            'description'=>$this->product->description,
            'quantity'=>$this->product->quantity,
            'rating' => (int)$avg_rate,
            'rate_count' => $user_rate_count,
            'thumbnail'=>$this->product->images ? $this->product->images[0] : null,
            'images'=>$this->product->images,
            'price'=>$this->product->price,
            'delivery_end'=>$derliver_end,
            'discount_price'=>ceil($discount_price),
            'discount'=>$this->product->discount,
            'rating'=>$this->product->rating,
            'final_price'=>ceil($sale_price),
            'final_percent'=>$sale_percent,
            'website'=>$this->product->website,
            'services'=>$this->product->services,
            'order_subtotal'=>$this->price_subtotal,
            'order_quantity'=>$this->quantity,
            'order_shipping_fee'=>$this->shipping_fee,
            'order_total'=>$this->total,
            'order_delivery_mode'=>$this->delivery_type,
            'order_is_confirm'=>$this->is_confirm,
            'order_is_prepare'=>$this->is_prepare,
            'order_is_pick'=>$this->is_pick,
            'order_getBy'=>"Get by $derliver_start,- $derliver_end, Standard",
            'business_status'=> $this->business_status,
            'career_status'=> $this->career_status,
            'status'=>$this->product->status,
            'date'=>ucwords($this->created_at->format('d M Y h:i:s')),
        ];
    }
}
