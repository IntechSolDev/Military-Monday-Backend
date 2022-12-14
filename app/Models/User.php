<?php

namespace App\Models;

use App\Notifications\VerifyApiEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Cache;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'phoneno',
        'address',
        'image',
        'type',
        'is_notify',
        'is_email',
        'business_type',
        'status',
        'fcm_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_notify' => 'boolean',
        'is_email' => 'boolean'
    ];

    public function getImageAttribute($value)
    {
        if($value == null)
        {
           return null;
        }
        else
        {
            return asset('/public/assets/images/user/' . $value);
        }

    }
        public function isOnline()
    {
        return Cache::has('user-is-online-' . $this->id);
    }

  public function sendNotification($user_id,$data_array,$message)
    {
        $userdata = User::find($user_id);
        $firebaseToken = [$userdata->fcm_token];
        $SERVER_API_KEY = env('FIRE_BASE_SERVER_API_KEY');
        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => $data_array['title'],
                "body" => $data_array['body'],
            ],
            "data"=> ['description'=>$data_array['description'],'type'=>$data_array['type']]
        ];
        $dataString = json_encode($data);
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        $response = curl_exec($ch);

        return response()->json(['success' =>$response]);
    }
}
