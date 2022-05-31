<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignContract extends Model
{
    use HasFactory;

    protected $fillable = [
        'ad_id',
        'content',
        'is_accepted',
        'reject_Note'
    ];

    public function ads()
    {
        return $this->belongsTo(Ad::class,'ad_id');
    }

    public function customers()
    {
        return $this->belongsTo(Customer::class,'customer_id');
    }
}
