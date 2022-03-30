<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class SocialMedia extends Model implements HasMedia
{
    use HasFactory , InteractsWithMedia;

    protected $fillable = [
        'name',
        'active'
    ];

    protected $append = [
        'image'
    ];

    public function ads()
    {
        return $this->belongsToMany(Ad::class,'social_media_id');
    }

    public function influncers()
    {
        return $this->belongsToMany(Influncer::class);
    }

    public function SocialMediaProfiles()
    {
        return $this->hasMany(SocialMediaProfile::class,'social_media_id');
    }

    public function accountMedias()
    {
        return $this->hasMany(SocialMedia::class,'media_account_id');
    }

    public function getImageAttribute()
    {
        $mediaItems = $this->getMedia('logos');
        $publicFullUrl = null;
        if(count($mediaItems) > 0) $publicFullUrl = $mediaItems[0]->getFullUrl();
       
        return $publicFullUrl;
    }
    
}
