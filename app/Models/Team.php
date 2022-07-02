<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Team;
use Spatie\Translatable\HasTranslations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Team extends Model implements HasMedia
{
    use HasFactory,HasTranslations,InteractsWithMedia;
    protected $fillable = [
        'name',
        'description',
        'social_media',
        'show'
    ];

    protected $append = [
        'image',
        'accounts'
    ];

    public $translatable = ['name' ,'description'];



    public function getImageAttribute()
    {
        $mediaItems = $this->getMedia('image')->first();

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

    public function getAccountsAttribute()
    {
        return json_decode($this->social_media);
    }

}
