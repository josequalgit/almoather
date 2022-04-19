<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'city_id',
        'area_id',
        'ad_id',
    ];

    public function areas()
    {
        return $this->belongsTo(Area::class,'area_id');
    }

    public function cities()
    {
        return $this->belongsTo(City::class,'city_id');
    }

    public function ads()
    {
        return $this->belongsTo(Ad::class,'ad_id');
    }
}
