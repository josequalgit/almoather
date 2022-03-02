<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMedia extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'active'
    ];

    public function ads()
    {
        return $this->hasMany(Ad::class,'social_media_id');
    }

    public function influncers()
    {
        return $this->belongsToMany(Influncer::class);
    }
    
}
