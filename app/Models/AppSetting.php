<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value'
    ];

    protected $append = [
        'campaignGoal',
        'getAdRelation'
    ];

    public function getCampaignGoalAttribute()
    {
        return json_decode($this->value);
    }

    public function getGetAdRelation()
    {
        return json_decode($this->value);
    }
    
}
