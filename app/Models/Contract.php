<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'is_accepted',
        'influencer_id',
        'customer_id',
        'influencer_status',
        'admin_status',
        'is_completed',
        'ad_id',
        'date'
    ];

    public function ads()
    {
        return $this->belongsTo(Ad::class,'ad_id');
    }

    public function influencers()
    {
        return $this->belongsTo(Influncer::class,'influencer_id');
    }

    public function customer()
    {
        return $this->belongsTo(Contract::class,'customer_id');
    }
    
}
