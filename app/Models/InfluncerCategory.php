<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class InfluncerCategory extends Model implements HasMedia
{
    use HasFactory , InteractsWithMedia;

    protected $fillable = [
        'name'
    ];

    protected $append = [
        'image'
    ];

    public function categories()
    {
        return $this->hasMany(Category::class,'influncer_category_id');
    }

    public function influncers()
    {
        return $this->belongsToMany(Influncer::class);
    }

    public function getImageAttribute() {
        $mediaItems = $this->getMedia('influncerCategories');
        $publicFullUrl = $mediaItems[0]->getFullUrl();
        return $publicFullUrl;
   }
}
