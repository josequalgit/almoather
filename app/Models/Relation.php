<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Relation extends Model
{
    use HasFactory,HasTranslations;

    protected $fillable = [
        'title',
        'app_profit',
    ];

    public $translatable = ['title'];

    public function ads()
    {
        return $this->hasMany(Relation::class,'relation_id');
    }
}
