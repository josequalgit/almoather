<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'country_id'
    ];

    public function countries()
    {
        return $this->belongsTo(Country::class,'country_id');
    }

    public function influences()
    {
        return $this->hasMany(Influncer::class,'address_id');
    }
}
