<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //

    protected $fillable = [
        'user_id',
        'amount',
        'type',
        'reference',
        'description',
        'status',
        'wallet_id',
        'metadata',
        'status',
        ];

        public function user(){
            return $this->belongsTo(User::class);
        }

         protected $casts = [
        'metadata' => 'array',
        'amount' => 'float',
    ];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }
}
