<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use willvincent\Rateable\Rateable;

class InfluencerRateing extends Model
{
    use HasFactory , Rateable;

    protected $fillable = [
        'question_id',
        'ad_id',
        'influencer_id',
        'rate'
    ];


    public function questions()
    {
        return $this->belongsTo(Question::class,'question_id');
    }
    public function ads()
    {
        return $this->belongsTo(Ad::class,'ad_id');
    }
}
