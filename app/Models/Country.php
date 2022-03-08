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

    public function cities()
    {
        return $this->hasMany(City::class,'country_id');
    }

    public function citizens()
    {
        return $this->hasMany(City::class,'nationality_id');
    }

    public function ads()
    {
        return $this->hasMany(Ad::class,'country_id');
    }

}
