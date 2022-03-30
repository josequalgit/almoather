<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdSuccess extends Model
{
    use HasFactory;

    public function ads()
    {
        return $this->belongsTo(Ad::class,'ad_id');
    }
}
