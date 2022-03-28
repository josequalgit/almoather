<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ad extends Model implements HasMedia
{
    use HasFactory , InteractsWithMedia,SoftDeletes;

    protected $fillable = [
        'type',
        'store',
        'budget',
        'auth_number',
        'onSite',
        'about',
        'status',
        'social_media_id',
        'country_id',
        'city_id',
        'area_id',
        'customer_id',
        'influncer_id',
        'category_id',
        'website_link',
        'ad_script',
        'reject_note',
        'date',
        'expense_type',
        'is_verified',
        'media_account_id',
        'delivery_man_name',
        'delivery_phone_number',
        'nearest_location',
        'delivery_city_name',
        'delivery_area_name',
        'delivery_street_name',
        'discount_code'

    ];

    protected $append = 
    [
        'videos',
        'image',
        'document',
        'logo'
    ];

    public function socialMedias()
    {
        return $this->belongsTo(SocialMedia::class,'social_media_id');
    }


    public function socialMediasAccount()
    {
        return $this->belongsTo(SocialMedia::class,'media_account_id');
    }

    public function countries()
    {
        return $this->belongsTo(Country::class,'country_id');
    }

    public function cities()
    {
        return $this->belongsTo(City::class,'city_id');
    }

    public function areas()
    {
        return $this->belongsTo(Area::class,'area_id');
    }

    public function customers()
    {
        return $this->belongsTo(Customer::class,'customer_id');
    }

    public function influncers()
    {
        return $this->belongsTo(Influncer::class,'influncer_id');
    }

    public function categories()
    {
        return $this->belongsTo(Category::class,'category_id');
    }

    public function contacts()
    {
        return $this->hasOne(Contract::class,'ad_id');
    }

    public function customerAdRateings()
    {
        return $this->hasMany(CustomerAdRating::class,'ad_id');
    }

    public function influencerRatting()
    {
        return $this->hasMany(InfluencerRateing::class,'ad_id');
    }

    public function marketingAdRatings()
    {
        return $this->hasMany(MarketingAdRating::class,'ad_id');
    }

    public function adSuccess()
    {
        return $this->hasMany(AdSuccess::class,'ad_id');
    }

    public function matches()
    {
        return $this->hasMany(AdsInfluencerMatch::class,'ad_id');
    }

    public function getImageAttribute() {
        $mediaItems = $this->getMedia('adImage');
        $publicFullUrl = null;
        if(count($mediaItems) > 0)
        {
            $publicFullUrl = $mediaItems[0]->getFullUrl();
        }
        return $publicFullUrl;
   }
    public function getVideosAttribute() {
        $mediaItems = $this->getMedia('adVideos');
        $publicFullUrl = null;
        if(count($mediaItems) > 0)
        {
            $publicFullUrl = $mediaItems[0]->getFullUrl();
        }
        return $publicFullUrl;
   }
    public function getDocumentAttribute() {
        $mediaItems = $this->getMedia('documnet');
        $publicFullUrl = null;
        if(count($mediaItems) > 0)
        {
            $publicFullUrl = $mediaItems[0]->getFullUrl();
        }
        return $publicFullUrl;
   }
    public function getLogoAttribute() {
        $mediaItems = $this->getMedia('logos');
        $publicFullUrl = null;
        if(count($mediaItems) > 0)
        {
            $publicFullUrl = $mediaItems[0]->getFullUrl();
        }
        return $publicFullUrl;
   }
}
