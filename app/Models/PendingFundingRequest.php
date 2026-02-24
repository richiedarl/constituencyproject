<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendingFundingRequest extends Model
{
    protected $fillable = [
        'user_id',
        'wallet_id',
        'amount',
        'payment_method',
        'reference',
        'status',
        'admin_notes',
        'approved_at',
        'approved_by'
    ];

    protected $casts = [
        'amount' => 'float',
        'approved_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
