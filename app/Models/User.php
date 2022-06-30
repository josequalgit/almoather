<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\GetVerifiedUsers;


class User extends Authenticatable implements JWTSubject , HasMedia
{
    use HasApiTokens, HasFactory, Notifiable , HasRoles , InteractsWithMedia,SoftDeletes,GetVerifiedUsers;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'lang',
        'fcm_token',
        'phone',
        'country_code',
        'dial_code',
        'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $append = [
        'image',
        'infulncerImage',
        'snapChatVideo',
        'adminImage'
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

     /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function customers()
    {
        return $this->hasOne(Customer::class,'user_id');
    }

    public function influncers()
    {
        return $this->hasOne(Influncer::class,'user_id');
    }

    public function senders_messages()
    {
        return $this->hasMany(Message::class,'sender_id');
    }
    public function receivers_messages()
    {
        return $this->hasMany(Message::class,'receiver_id');
    }

    public function getImageAttribute() {
        $mediaItems = $this->getMedia('customers')->first();
        $publicFullUrl = [
            'id' => 0,
            'url' => 'https://cdn5.vectorstock.com/i/1000x1000/51/99/icon-of-user-avatar-for-web-site-or-mobile-app-vector-3125199.jpg'
        ];

        
        if($mediaItems)
        {
            $publicFullUrl = [
                'id' => $mediaItems->id,
                'url' => $mediaItems->getFullUrl()
            ];
        }
        return $publicFullUrl;
   }

    public function getInfulncerImageAttribute() {
        $mediaItems = $this->getMedia('influncers')->first();

        $publicFullUrl = [
            'id' => 0,
            'url' => 'https://cdn5.vectorstock.com/i/1000x1000/51/99/icon-of-user-avatar-for-web-site-or-mobile-app-vector-3125199.jpg'
        ];

        if($mediaItems)
        {
            $publicFullUrl = [
                'id' => $mediaItems->id,
                'url' => $mediaItems->getFullUrl()
            ];
        }
        return $publicFullUrl;
   }

   public function getAdminImageAttribute() {
        $mediaItems = $this->getMedia('admin')->first();

        $publicFullUrl = [
            'id' => 0,
            'url' => 'https://cdn5.vectorstock.com/i/1000x1000/51/99/icon-of-user-avatar-for-web-site-or-mobile-app-vector-3125199.jpg'
        ];
        if($mediaItems)
        {
            $publicFullUrl = [
                'id'=>$mediaItems->id,
                'url'=>$mediaItems->getFullUrl()
            ];
        }
        return $publicFullUrl;
    }

    public function getSnapChatVideoAttribute() {
        $mediaItems = $this->getMedia('snapchat_videos');
        $publicFullUrl = null;
        $array_of_links = [];
        if(count($mediaItems) > 0)
        {
            foreach ($mediaItems as $key => $value) {
                //$publicFullUrl = $mediaItems[$key]->getFullUrl();
                $publicFullUrl = $mediaItems[$key];
                $data = [
                    'id'=>$publicFullUrl->id,
                    'url'=>$publicFullUrl->getFullUrl()
                ];
                array_push($array_of_links,$data);
            }
           ;
        }
        return $array_of_links;
   }

}
