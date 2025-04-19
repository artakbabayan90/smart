<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WithdrawalRequest extends Model
{
    protected $fillable = [
        'user_id',
        'amount',
        'paypal_email',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
