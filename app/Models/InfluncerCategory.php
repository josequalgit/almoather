<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;

class InfluncerCategory extends Model implements HasMedia
{
    use HasFactory , InteractsWithMedia , HasTranslations,SoftDeletes;

    protected $fillable = [
        'name'
    ];

    protected $append = [
        'image'
    ];

    public $translatable = ['name'];


    // public function categories()
    // {
    //     return $this->belongsToMany(Category::class,'influncer_category_id');
    // }

    public function influncers()
    {
        return $this->belongsToMany(Influncer::class);
    }

    public function preferredCategories()
    {
        return $this->belongsToMany(Category::class,'preferred_categories','influncer_category_id','category_id');
    }


    public function getImageAttribute() {
        $mediaItems = $this->getMedia('influncerCategories');
        $publicFullUrl = $mediaItems[0]->getFullUrl();
        return $publicFullUrl;
   }
}
