<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMediaProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'link',
        'social_media_id',
        'Influncer_id',
        'views'
    ];

    public function socialMedias()
    {
        return $this->belongsTo(SocialMedia::class,'social_media_id');
    }

    public function influences()
    {
        return $this->belongsTo(Influncer::class,'Influncer_id');
    }
}
