<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Area extends Model
{
    use HasFactory , HasTranslations;

    protected $fillable = [
        'name',
        'country_id'
    ];

    public $translatable = ['name'];


    public function cities()
    {
        return $this->hasMany(City::class,'area_id');
    }

    public function ads()
    {
        return $this->hasMany(Ad::class,'area_id');
    }

    public function storeLocations()
    {
        return $this->hasMany(StoreLocation::class,'area_id');
    }

    public function countries()
    {
        return $this->belongsTo(Country::class,'country_id');
    }
}
