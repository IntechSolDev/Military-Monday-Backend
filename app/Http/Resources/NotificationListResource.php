<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Setting;
class NotificationListResource extends JsonResource
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
            'id'=>$this->redirect ? $this->redirect : null,
            'notification_id'=>$this->id,
            'title'=>$this->title,
            'product'=>$this->product,
             'image'=>$this->product['image'] ? $this->product['image'] : null,
            'message'=>$this->message,
            'date'=>$this->created_at,

        ];

    }
}
