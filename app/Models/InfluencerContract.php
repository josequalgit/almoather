<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfluencerContract extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'is_accepted',
        'influencer_id',
        'ad_id',
        'status',
        'admin_status',
        'date',
        'rejectNote',
        'link',
        'scenario',
    ];

    protected $casts = [
        'date' => 'datetime:Y-m-d',
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
