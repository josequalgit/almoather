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



class User extends Authenticatable implements JWTSubject , HasMedia
{
    use HasApiTokens, HasFactory, Notifiable , HasRoles , InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
        'infulncerImage'
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

    public function getImageAttribute() {
        $mediaItems = $this->getMedia('customers');
        $publicFullUrl = null;
        if($mediaItems)
        {
            $publicFullUrl = $mediaItems[0]->getFullUrl();
        }
        return $publicFullUrl;
   }

    public function getInfulncerImageAttribute() {
        $mediaItems = $this->getMedia('influncers');
        $publicFullUrl = null;
        if($mediaItems)
        {
            $publicFullUrl = $mediaItems[0]->getFullUrl();
        }
        return $publicFullUrl;
   }

}
