<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdsInfluencerMatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'ad_id',
        'influencer_id',
        'match',
        'chosen'
    ];


    public function ads()
    {
        return $this->belongsTo(Ad::class,'ad_id');
    }

    public function influencers()
    {
        return $this->belongsTo(Influncer::class,'influencer_id');
    }
    
}
