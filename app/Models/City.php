<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'country_id'
    ];

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
        return $this->hasMany(Area::class,'city_id');
    }
}
