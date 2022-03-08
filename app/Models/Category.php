<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Category extends Model implements HasMedia
{
    use HasFactory , InteractsWithMedia;

    protected $fillable = [
        'name',
        'type',
        'influncer_category_id'
    ];

    protected $append = [
        'image'
    ];

   
    public function influncerCategories()
    {
        return $this->belongsTo(InfluncerCategory::class,'influncer_category_id');
    }

    public function ads()
    {
        return $this->hasMany(Ad::class,'category_id');
    }

    public function getImageAttribute() {
        $mediaItems = $this->getMedia('categories');
        $publicFullUrl = $mediaItems[0]->getFullUrl();
        return $publicFullUrl;
   }


}
