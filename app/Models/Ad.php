<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Ad extends Model implements HasMedia
{
    use HasFactory , InteractsWithMedia;

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
        'expense_type'
    ];

    protected $append = [
        'videos',
        'image',
        'document',
    ];

    public function socialMedias()
    {
        return $this->belongsTo(SocialMedia::class,'social_media_id');
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
        $publicFullUrl = [];
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
}
