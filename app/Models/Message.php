<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'type',
        'text',
    ];

    public function senders()
    {
        return $this->belongsTo(User::class,'sender_id');
    }

    public function receivers()
    {
        return $this->belongsTo(User::class,'receiver_id');
    }
}
