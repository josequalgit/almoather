<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Category extends Model implements HasMedia
{
    use HasFactory , InteractsWithMedia , HasTranslations;

    protected $fillable = [
        'name',
        'type',
    ];

    protected $append = [
        'image'
    ];

    public $translatable = ['name'];


    public function ads()
    {
        return $this->hasMany(Ad::class,'category_id');
    }


    public function excludeCategories()
    {
        return $this->belongsToMany(InfluncerCategory::class,'exclude_categories','category_id','influncer_category_id');
    }

    public function getImageAttribute() {
        $mediaItems = $this->getMedia('categories')->first();
        if($mediaItems){
            return $mediaItems->getFullUrl();
        }
        return asset('img/no-image.jpg');
   }


}
