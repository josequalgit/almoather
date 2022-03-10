<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'country_id',
        'user_id',
        'region_id',
        'city_id',
        'nationality_id',
        'status'
    ];

    public function users()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    
    public function citys()
    {
        return $this->belongsTo(City::class,'city_id');
    }

    public function countrys()
    {
        return $this->belongsTo(Country::class,'country_id');
    }

    public function nationalities()
    {
        return $this->belongsTo(Country::class,'nationality_id');
    }

    public function ads()
    {
        return $this->hasMany(Ad::class,'customer_id');
    }

}
