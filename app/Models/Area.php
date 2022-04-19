<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'city_id'
    ];

    public function cities()
    {
        return $this->belongs(City::class,'city_id');
    }

    public function ads()
    {
        return $this->hasMany(Ad::class,'area_id');
    }

    public function storeLocations()
    {
        return $this->hasMany(Area::class,'area_id');
    }
}
