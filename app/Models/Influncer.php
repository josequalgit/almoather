<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Influncer extends Model implements HasMedia
{
    use HasFactory , InteractsWithMedia;

    protected $fillable = [
        'full_name_en',
        'full_name_ar',
        'nick_name',
        'bank_name',
        'bank_account_number',
        'bio',
        'ads_out_country',
        'city_id',
        'country_id',
        'nationality_id',
        'influncer_category_id',
        'region_id',
        'user_id',
        'status',
        'is_vat',
        'ad_price',
        'ad_onsite_price',
        'birthday',
        'id_number',
        'phone',
        'ratting',
        'ad_with_vat',
        'ad_onsite_price_with_vat',
        'address_id'
    ];

    protected $append = [
        'video'
    ];

    public function users()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function citys()
    {
        return $this->belongsTo(City::class,'city_id');
    }
    public function countries()
    {
        return $this->belongsTo(Country::class,'country_id');
    }
    public function nationalities()
    {
        return $this->belongsTo(Country::class,'nationality_id');
    }
    public function InfluncerCategories()
    {
        return $this->belongsToMany(InfluncerCategory::class);
    }
    public function socialMedias()
    {
        return $this->belongsToMany(SocialMedia::class);
    }
    public function ads()
    {
        return $this->hasMany(Ad::class,'influncer_id');
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class,'influencer_id');
    }

    public function address()
    {
        return $this->belongsTo(Address::class,'address_id');
    }

    public function banks()
    {
        return $this->belongsTo(Banks::class,'bank_id');
    }

    public function socialMediaProfiles()
    {
        return $this->hasMany(SocialMediaProfile::class,'Influncer_id');
    }

    public function getVideoAttribute(Type $var = null)
    {
        $mediaItems = $this->getMedia('videos');
        $publicFullUrl = [];
        if(count($mediaItems) > 0) $publicFullUrl = $mediaItems[0]->getFullUrl();
        return $publicFullUrl;
    }
}
