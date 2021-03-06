<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfluencerContract extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_url',
        'voluum_id',
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
        'last_notification_time',
        'contract_send_at'
    ];

    protected $casts = [
        'date' => 'datetime:Y-m-d',
        'contract_send_at' => 'datetime:Y-m-d',
        'last_notification_time' => 'datetime:Y-m-d',
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
