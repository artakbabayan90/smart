<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    protected $fillable = [
        'user_id',
        'amount',
        'reason',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
