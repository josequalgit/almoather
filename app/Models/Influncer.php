<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Influncer extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name_en',
        'full_name_ar',
        'nick_name',
        'bank_name',
        'bank_account_number',
        'bio',
        'ads_out_country',
        'city_id',
        'country_id',
        'nationality_id',
        'influncer_category_id',
        'user_id',
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
    public function countries()
    {
        return $this->belongsTo(Country::class,'country_id');
    }
    public function nationalities()
    {
        return $this->belongsTo(Country::class,'nationality_id');
    }
    public function InfluncerCategories()
    {
        return $this->belongsToMany(InfluncerCategory::class);
    }
    public function socialMedias()
    {
        return $this->belongsToMany(SocialMedia::class);
    }
    public function ads()
    {
        return $this->hasMany(Ad::class,'influncer_id');
    }
}
