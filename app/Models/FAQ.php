<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class FAQ extends Model
{
    use HasFactory,HasTranslations;


    public $translatable = ['answer','question'];

    protected $fillable = [
        'question',
        'answer',
    ];
}
