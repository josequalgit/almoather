<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Page extends Model implements HasMedia
{
    use HasFactory,HasTranslations,InteractsWithMedia;

    protected $fillable = [
        'title',
        'description',
        'slug',
        'content',
    ];

    public $translatable = ['title','description'];

    protected $append = [
        'image',
        'aboutUsHeader',
        'aboutUsSectionOneImage',
        'aboutUsSectionTwoImage',
        'contentData'
    ];

    public function getImageAttribute()
    {

        $mediaItems = $this->getMedia('image')->first();
        

        $publicFullUrl = 'https://cdn5.vectorstock.com/i/1000x1000/51/99/icon-of-user-avatar-for-web-site-or-mobile-app-vector-3125199.jpg';
           
        if($mediaItems)
        {
            $publicFullUrl = $mediaItems->getFullUrl();
        }
        return $publicFullUrl;
    }

    public function getAboutUsHeaderAttribute()
    {
        $mediaItems = $this->getMedia('aboutUsHeader')->first();
        

        $publicFullUrl = 'https://cdn5.vectorstock.com/i/1000x1000/51/99/icon-of-user-avatar-for-web-site-or-mobile-app-vector-3125199.jpg';
           
        if($mediaItems)
        {
            $publicFullUrl = $mediaItems->getFullUrl();
        }
        return $publicFullUrl;
    }

    public function getAboutUsSectionOneImageAttribute()
    {
        $mediaItems = $this->getMedia('aboutUsSectionOneImage')->first();
        $publicFullUrl = 'https://cdn5.vectorstock.com/i/1000x1000/51/99/icon-of-user-avatar-for-web-site-or-mobile-app-vector-3125199.jpg';
           
        if($mediaItems)
        {
            $publicFullUrl = $mediaItems->getFullUrl();
        }
        return $publicFullUrl;
    }

    public function getAboutUsSectionTwoImageAttribute()
    {
        $mediaItems = $this->getMedia('aboutUsSectionTwoImage')->first();
        $publicFullUrl = 'https://cdn5.vectorstock.com/i/1000x1000/51/99/icon-of-user-avatar-for-web-site-or-mobile-app-vector-3125199.jpg';
           
        if($mediaItems)
        {
            $publicFullUrl = $mediaItems->getFullUrl();
        }
        return $publicFullUrl;
    }

    public function getContentDataAttribute()
    {
        $data = json_decode($this->content);
        return $data;
    }


}
