<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\Admin;
use App\Models\FavProduct;
use Illuminate\Http\Request;

use App\Traits\PaginationTrait;
use Illuminate\Support\Collection;

use Carbon\Carbon;
use DB;
use DateTime;
use DatePeriod;
use Carbon\CarbonInterval;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
     use PaginationTrait;
    //Response Status
    public $success = 200;
    public $error = 404;
    public $validate_error = 401;


// Product Create
    public function createProduct(Request $request)
    {

        $user = Auth::user();
        if(!isset($request->product_id))
        {
            $validator = Validator::make($request->all(), [
                'name'=>'required',
                'image'=>'required',
                'price'=>'required',
                'start_time'=>'required',
                'end_time'=>'required',
            ]);
            if($validator->fails()){
                return response()->json(['Field required' => $validator->errors()]);
            }
        }
        $details = [
            'user_id'=>$user->id,
            'price'=> $request->price,
            'final_price'=> $request->final_price,
            'discount_price'=> $request->discount_price,
            'discount_percent'=> $request->discount_percent,
            'quantity'=>$request->quantity,
            'type'=>$request->type,
            'name'=> $request->name,
            'description'=> $request->description,
            'url'=> $request->url,
            'store'=>$request->store,
            'store_url'=>$request->store_url,
            'phoneno'=> $request->phoneno,
            'start_time'=>$request->start_time.":00",
            'end_time'=>$request->end_time.":00",
            'str_start_time'=>strtotime($request->start_time.":00"),
            'str_end_time'=>strtotime($request->end_time.":00"),
            'date'=>$request->date,
        ];
        if ($request->hasFile('image')) {
            
            if($request->product_id)
            {
               $product =  product::find($request->product_id);
                  if ($product->image != null) {
                    $url_path = parse_url($user->image, PHP_URL_PATH);
                    $basename = pathinfo($url_path, PATHINFO_BASENAME);
                    $file_old =  public_path("assets/images/product/$basename");
                    unlink($file_old);
                }
            }
            
            $extension = $request->image->extension();
            $filename = time().rand(100,999) . "_." . $extension;
            $request->image->move(public_path('/assets/images/product'), $filename);
            $details['image'] = $filename;
        }
        
        if(isset($request->product_id))
            {
                $details['product_status'] = 'pending';
            }
        $pro = Product::updateOrCreate(['id' => $request->product_id], $details);
        if($pro)
        {
             return response()->json([
                'message' => 'Product added successfully.',
                'status'=>'success',
            ],$this->success);

        }
         return response()->json([
                'message' => 'Product not added.',
                'status'=>'error',
            ],$this->error);
    }
    
// View Product Buyer
   public function viewProductBuyer(Request $request)
    {
        $user = Auth::user();
        $product = Product::where([['type','product'],['product_status','!=','pending']])->with(['user'])->limit(5)->get();
        $service = Product::where([['type','service'],['product_status','!=','pending']])->with(['user'])->limit(5)->get();
        $active_deal = Product::where('date', $request->date)
                            ->whereTime('start_time', '<=', $request->time)
                            ->whereTime('end_time', '>=', $request->time)
                            ->first();
        if($product->isNotEmpty())
        {
           $product_data = ProductResource::collection($product);
        }
        if($service->isNotEmpty())
        {
           $service_data = ProductResource::collection($service);
        }
         if(isset($active_deal))
        {
           $active_data = ProductResource::make($active_deal);
        }
        if($product->isNotEmpty() || $service->isNotEmpty() )
        {
            return response()->json([
                'product'=>isset($product_data) ? $product_data : [],
                'service'=>isset($service_data) ? $service_data : [],
                'active'=>isset($active_data) ? [$active_data] : [],
                'message' => 'Product Data.',
                'status'=>'success',
            ],$this->success);
        }
        return response()->json([
            'data'=>['product'=>[],'service'=>[]],
            'message' => 'Product or Service  not Found.',
            'status'=>'success',
        ],$this->success);
    }

//View Upcoming Deals
public function viewUpcomingDeal(Request $request)
    {
        $user = Auth::user();
        $upcoming_deals = Product::where('product_status','!=','pending')->where('date', '>=', $request->date)
                            ->whereTime('end_time', '>=', $request->time)
                            ->with(['user'])->get();
        if($upcoming_deals->isNotEmpty())
        {
           $upcoming_deals_data = ProductResource::collection($upcoming_deals);
            return response()->json([
                'upcoming_deals'=>isset($upcoming_deals_data) ? $upcoming_deals_data : [],
                'message' => 'Upcoming Deals Data.',
                'status'=>'success',
            ],$this->success);
        }
        return response()->json([
            'data'=>['upcoming_deals'=>[]],
            'message' => 'Upcoming Deal  not Found.',
            'status'=>'success',
        ],$this->success);
    }
//All Product List
   public function viewAllProductList()
   {
        $user = Auth::user();
        $product = Product::with(['user'])->where([['type','product'],['product_status','!=','pending']])->latest()->get();
        $product_data = ProductResource::collection($product);
        if($product)
        {
            return response()->json([
                'data'=>$product_data,
                'message' => 'Product Data.',
                'status'=>'success',
            ],$this->success);
        }
        return response()->json([
            'data'=>['data'=>[]],
            'message' => 'Product Data not Found.',
            'status'=>'success',
        ],$this->success);
    }

//All Service List
    public function viewAllServiceList()
    {
        $user = Auth::user();
        $services = Product::with(['user'])->where([['type','service'],['product_status','!=','pending']])->latest()->get();
        $service_data = ProductResource::collection($services);
        if($services)
        {
            return response()->json([
                'data'=>$service_data,
                'message' => 'Service Data.',
                'status'=>'success',
            ],$this->success);
        }
        return response()->json([
            'data'=>['data'=>[]],
            'message' => 'Service Data not Found.',
            'status'=>'success',
        ],$this->success);
    }

// View Product Detail
    public function viewProductDetail($id)
    {
         $user = Auth::user();
         $product = Product::with(['user'])->where('product_status','!=','pending')->find($id);
         $product_data = ProductResource::make($product);
        if($product)
        {
            return response()->json([
                'data'=>$product_data,
                'message' => 'Product Data.',
                'status'=>'success',
            ],$this->success);
        }
       return response()->json([
                'data'=>['data'=>[]],
                'message' => 'Product Data not Found.',
                'status'=>'success',
            ],$this->success);
    }


    public function viewProductByStatus(Request $request)
    {
        $user = Auth::user();
        $today = Carbon::now();

        // It Trun All Product to Expire if date Expire by Today
        $pro = Product::where('expire_date','<=',$today)->update(['product_status'=>'expired']);

        //Pending Product
        $product_pending = Product::with(['category','location','subcategory','user'])->where([['user_id',$user->id],['product_status','pending']])->get();
        $pending_product_data = ProductResource::collection($product_pending);


        //Active Product
        $product_active = Product::with(['category','location','subcategory','user'])->where([['user_id',$user->id],['product_status','active']])->get();
        $active_product_data = ProductResource::collection($product_active);

        //Sold Product
        $product_sold = Product::with(['category','location','subcategory','user'])->where([['user_id',$user->id],['product_status','sold']])->get();
        $sold_product_data = ProductResource::collection($product_sold);


        //Expired Product
        $product_expire = Product::with(['category','location','subcategory','user'])->where([['user_id',$user->id],['product_status','expired'],['expire_date','<=',$today]])->get();
        $expire_product_data = ProductResource::collection($product_expire);


        if($product_pending->isNotEmpty() ||  $product_active->isNotEmpty() ||  $product_sold->isNotEmpty())
        {
            return response()->json([
                'pending_product'=>isset($pending_product_data) ? $pending_product_data : [] ,
                'active_product'=>isset($active_product_data) ?  $active_product_data : [],
                'sold_product'=>isset($sold_product_data) ? $sold_product_data : [],
                'expire_product'=>isset($expire_product_data) ? $expire_product_data : [],
                'message' => 'Product Data.',
                'status'=>'success',
            ],$this->success);
        }
        return response()->json([
            'pending_product'=>[],
            'active_product'=>[],
            'sold_product'=>[],
             'expire_product'=>[],
            'message' => 'Product Data not Found.',
            'status'=>'success',
        ],$this->success);
    }

    public function markAsSold(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'product_id'=>'required'
        ]);
        if($validator->fails()){
            return response()->json(['Field required' => $validator->errors()]);
        }
       $pro =  Product::find($request->product_id);
       if($pro->user_id  != $user->id)
       {
         return response()->json([
                'message' => 'Unauthorized to mark as sold',
                'status'=>'error',
            ],$this->error);
       }

        $pro_update = $pro->update( ['product_status'=>'sold']);
        if($pro_update)
        {
             return response()->json([
                'message' => 'You product mark as sold',
                'status'=>'success',
            ],$this->success);

        }
         return response()->json([
                'message' => 'Product not found.',
                'status'=>'error',
            ],$this->error);

    }

    public function viewDateTime()
    {
       $schedule = [
            'start' => '2015-11-18 09:00:00',
            'end' => '2015-11-18 17:00:00',
        ];

        $start = Carbon::instance(new DateTime($schedule['start']));
        $end = Carbon::instance(new DateTime($schedule['end']));

        $events = [
            [
                'created_at' => '2015-11-18 10:00:00',
                'updated_at' => '2015-11-18 13:00:00',
            ],
            [
                'created_at' => '2015-11-18 14:00:00',
                'updated_at' => '2015-11-18 16:00:00',
            ],
        ];

        $minSlotHours = 1;
        $minSlotMinutes = 0;
        $minInterval = CarbonInterval::hour($minSlotHours)->minutes($minSlotMinutes);

        $reqSlotHours = 1;
        $reqSlotMinutes = 0;
        $reqInterval = CarbonInterval::hour($reqSlotHours)->minutes($reqSlotMinutes);

        function slotAvailable($from, $to, $events){
            foreach($events as $event){
                $eventStart = Carbon::instance(new DateTime($event['created_at']));
                $eventEnd = Carbon::instance(new DateTime($event['updated_at']));
                
  
                if($from->between($eventStart, $eventEnd) && $to->between($eventStart, $eventEnd)){
                    return false;
                }
            }
            return true;
        }

        foreach(new DatePeriod($start, $minInterval, $end) as $slot){
            $to = $slot->copy()->add($reqInterval);

            echo $slot->toDateTimeString() . ' to ' . $to->toDateTimeString();

            if(slotAvailable($slot, $to, $events)){
                echo ' is available';
            }

            echo '<br />';
        }
    }

    public function getFreeSlot(Request $request)
    {
         $validator = Validator::make($request->all(), [
            'date'=>'required',
        ]);
        if($validator->fails()){
            return response()->json(['Date required' => $validator->errors()]);
        }
        
        $slotList = [];
        $available = [];
        $not_available = []; 
        $schedule = [
              'start' => "$request->date 00:00:00",
              'end' => "$request->date 23:59:59",
        ];

        $start = Carbon::instance(new DateTime($schedule['start']));
        $end = Carbon::instance(new DateTime($schedule['end']));


        $products =      Product::where('date',$request->date)->get();

       
        foreach($products as $product)
        {
          $events[] = ['start_at' => "$request->date $product->start_time", 'end_at' => "$request->date $product->end_time"];
        }
        
        $minSlotHours = 1;
        $minSlotMinutes = 0;
        $minInterval = CarbonInterval::minutes(1);

        $reqSlotHours = 1;
        $reqSlotMinutes = 0;
        $reqInterval = CarbonInterval::minutes(1);

        function slotAvailable($from, $to, $events){
            foreach($events as $event){
                $eventStart = Carbon::instance(new DateTime($event['start_at']));
                $eventEnd = Carbon::instance(new DateTime($event['end_at']));
                 // if($from->between($eventStart, $eventEnd) && $to->between($eventStart, $eventEnd)){
               if((($from >= $eventStart) && ($from <= $eventEnd)) && (($to >= $eventStart) && ($to <= $eventEnd))){
                    return false;
                }
            }
            return true;
        }

        foreach(new DatePeriod($start, $minInterval, $end) as $slot){
          //   return $slot;
             $to = (clone $slot)->add($reqInterval);
             
         //  $to = $slot->copy()->add($reqInterval);
           
            $timeslot =  $slot->format("Y-m-d H:i:s");
            $time = explode(" ",$timeslot);
            $time_min = explode(":",$time[1]);
            if(!isset($events))
            {
                $slotList[] = ['slot'=>"$time_min[0]:$time_min[1]",'is_avaliable'=>true];
            }
            else if(slotAvailable($slot, $to, $events))
            {
             
                $slotList[] = ['slot'=>"$time_min[0]:$time_min[1]",'is_avaliable'=>true];
            }
            else
            {
                 $slotList[]= ['slot'=>"$time_min[0]:$time_min[1]",'is_avaliable'=>false];
            }
        }
        
        
         $data = $this->paginate($slotList,100);
       
           return response()->json([
                'slot_list'=>$data,
                'message' => 'Slot List',
                'status'=>'success',
            ],$this->success);
       
    }

    public function viewSellerOffers(Request $request)
    {
         $validator = Validator::make($request->all(), [
                'time'=>'required',
            ]);
            if($validator->fails()){
                return response()->json(['Current Time is required' => $validator->errors()]);
            }
           $user = Auth::user();
           $pro =  Product::where('user_id',$user->id)->get();
           $product_data = ProductResource::collection($pro);
           
           $statisticCollection = collect($product_data);
           $sorted = $statisticCollection->sortBy('sort');
    
           $sort_product=[];
                foreach($sorted as $sorting)
                {
                $sort_product[]=$sorting;
                }
            if($pro)
            {
                 return response()->json([
                    'data'=>$sort_product,
                    'message' => 'Product Data.',
                    'status'=>'success',
                ],$this->success);
            }
             return response()->json([
                    'message' => 'Product not found.',
                    'status'=>'error',
                ],$this->error);
}




}
