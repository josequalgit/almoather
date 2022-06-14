<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Region extends Model
{
    use HasFactory,HasTranslations;

    protected $fillable = [
        'name',
        'country_id',
    ];
    public $translatable = ['name'];

    public function cities()
    {
        return $this->hasMany(City::class,'region_id');
    }

    public function countries()
    {
        return $this->belongsTo(Country::class,'country_id');
    }

    public function influences()
    {
        return $this->hasMany(Influncer::class,'region_id');
    }
    public function customers()
    {
        return $this->hasMany(Customer::class,'region_id');
    }
}
