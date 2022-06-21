<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\InfluencerContract;

class AdsInfluencerMatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'ad_id',
        'influencer_id',
        'match',
        'chosen',
        'AOAF',
        'scenario'
    ];

    protected $append = [
        'contract'
    ];


    public function ads()
    {
        return $this->belongsTo(Ad::class,'ad_id');
    }

    public function influencers()
    {
        return $this->belongsTo(Influncer::class,'influencer_id');
    }



    public function getContractAttribute()
    {
         
         $contract = InfluencerContract::where(['influencer_id'=>$this->influencer_id])
         ->where(['ad_id'=>$this->ad_id])
         ->first();

         if(!$contract) return null;

         return $contract;
    }
    
}
