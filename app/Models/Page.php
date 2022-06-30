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
        'contentData',
        'servicePageFiles'
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

    public function getServicePageFilesAttribute()
    {
        $service_header_image = $this->getMedia('service_header_image')->first();
        $service_second_section_image_one = $this->getMedia('service_second_section_image_one')->first();
        $second_section_image_two = $this->getMedia('second_section_image_two')->first();
        $main_video_video_section = $this->getMedia('main_video_video_section')->first();
        $background_video_image = $this->getMedia('back_ground_video_image')->first();
        return (object)[
            'header'=>$service_header_image?$service_header_image->getFullUrl():null,
            'second_image_one'=>$service_second_section_image_one?$service_second_section_image_one->getFullUrl():null,
            'second_image_two'=>$second_section_image_two?$second_section_image_two->getFullUrl():null,
            'video'=>$main_video_video_section?$main_video_video_section->getFullUrl():null,
            'video_backgroundImage'=>$background_video_image?$background_video_image->getFullUrl():null,
        ];
    }


}
