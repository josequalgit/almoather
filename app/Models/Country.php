<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code'
    ];

    public function customers()
    {
        return $this->hasMany(Customer::class,'country_id');
    }

    public function areas()
    {
        return $this->hasMany(Area::class,'country_id');
    }

    public function citizens()
    {
        return $this->hasMany(City::class,'nationality_id');
    }

    public function ads()
    {
        return $this->hasMany(Ad::class,'country_id');
    }

    public function regions()
    {
        return $this->hasMany(Region::class,'country_id');
    }

    public function address()
    {
        return $this->hasMany(Address::class,'country_id');
    }

    public function storeLocations()
    {
        return $this->hasMany(Country::class,'country_id');
    }

}
