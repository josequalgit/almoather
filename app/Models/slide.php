<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;

class slide extends Model implements HasMedia
{
    use HasFactory,InteractsWithMedia,HasTranslations,SoftDeletes;

    public $translatable = ['description','title'];

    protected $fillable = [
        'title',
        'description',
    ];
    protected $append = [
        'image',
    ];

    public function getImageAttribute() {
        $mediaItems = $this->getMedia('slideImages')->first();
        $publicFullUrl = null;
        if($mediaItems)
        {
            return $mediaItems->getFullUrl();
        }
        return $publicFullUrl;
   }



}
