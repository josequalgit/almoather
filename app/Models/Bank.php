<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function influncers()
    {
        return $this->hasMany(Influncer::class,'bank_id');
    }
}
