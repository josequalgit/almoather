<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'country_id',
        'user_id',
        'region_id',
        'city_id',
        'nationality_id',
        'gender',
        'status',
        'id_number'
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
    public function regions()
    {
        return $this->belongsTo(Region::class,'region_id');
    }

    public function nationalities()
    {
        return $this->belongsTo(Country::class,'nationality_id');
    }

    public function ads()
    {
        return $this->hasMany(Ad::class,'customer_id');
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class,'customer_id');
    }

    public function campaignContract()
    {
        return $this->hasMany(CampaignContract::class,'customer_id');
    }


}
