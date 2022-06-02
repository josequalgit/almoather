<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class CampaignGoal extends Model
{
    use HasFactory,HasTranslations;

    public $translatable = ['title'];

    protected $fillable = [
        'title',
        'profitable'
    ];

    public function ads()
    {
        return $this->hasMany(Ad::class,'campaign_goals_id');
    }

}
