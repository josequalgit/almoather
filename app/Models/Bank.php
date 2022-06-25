<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Bank extends Model
{
    use HasFactory , HasTranslations;

    protected $fillable = [
        'name'
    ];

    public $translatable = ['name'];


    public function influncers()
    {
        return $this->hasMany(Influncer::class,'bank_id');
    }
}
