<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class City extends Model
{
    use HasFactory ,SoftDeletes,HasTranslations;

    protected $fillable = [
        'name',
        'country_id',
        'region_id'
    ];

    public $translatable = ['name'];
    
    protected $table = 'cities';



    public function customers()
    {
        return $this->hasMany(Customer::class,'city_id');
    }

    public function countries()
    {
        return $this->belongsTo(Country::class,'country_id');
    }

    public function ads()
    {
        return $this->hasMany(Ad::class,'city_id');
    }

    public function areas()
    {
        return $this->belongsTo(Area::class,'city_id');
    }

    public function regions()
    {
        return $this->belongsTo(Region::class,'region_id');
    } 

    public function storeLocations()
    {
        return $this->hasMany(StoreLocation::class,'city_id');
    }
}
