<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'ad_id',
        'trans_id',
        'amount',
        'status_code',
        'type',
    ];


    public function ads()
    {
        return $this->belongsTo(Ad::class,'ad_id');
    }
}
