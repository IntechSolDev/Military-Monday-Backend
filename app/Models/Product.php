<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'name',
        'final_price',
        'price',
        'discount_price',
        'discount_percent',
        'quantity',
        'url',
        'type',
        'user_id',
        'description',
        'image',
        'start_time',
        'end_time',
        'str_start_time',
        'str_end_time',
        'date',
        'store',
        'store_url',
        'product_status',
    ];
       protected $casts = [
        'final_price'=>'float',
        'price'=>'float',
        'discount_price'=>'float',
        'discount_percent'=>'float'
    ];
    

    public function getImageAttribute($value)
    {
        if($value == null)
        {
            return null;
        }
        else
        {
            return asset('/public/assets/images/product/' . $value);
        }

    }

    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }


}
