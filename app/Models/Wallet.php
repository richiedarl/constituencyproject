<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Wallet extends Model
{
    protected $fillable = [
        'candidate_id',
        'user_id',
        'admin_id',
        'contributor_id',
        'contractor_id',
        'balance',
        'currency'
    ];

    protected $casts = [
        'balance' => 'decimal:2',
    ];

    public function candidate(){
        return $this->belongsTo(Candidate::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function contractor(){
        return $this->belongsTo(Contractor::class);
    }

    public function contributor(){
        return $this->belongsTo(Contributor::class);
    }

    public function admin(){
        return $this->belongsTo(User::class, 'admin_id');
    }

    /**
     * Credit wallet (add money)
     */
    public function credit(float $amount, string $description = null)
    {
        return DB::transaction(function () use ($amount, $description) {
            $this->increment('balance', $amount);

            // Record transaction if you have a transactions table
            // $this->transactions()->create([
            //     'type' => 'credit',
            //     'amount' => $amount,
            //     'description' => $description,
            //     'balance_after' => $this->balance + $amount,
            // ]);

            return $this->fresh();
        });
    }

    /**
     * Debit wallet (withdraw money)
     */
    public function debit(float $amount, string $description = null)
    {
        if ($this->balance < $amount) {
            throw new \Exception('Insufficient balance');
        }

        return DB::transaction(function () use ($amount, $description) {
            $this->decrement('balance', $amount);

            // Record transaction if you have a transactions table
            // $this->transactions()->create([
            //     'type' => 'debit',
            //     'amount' => $amount,
            //     'description' => $description,
            //     'balance_after' => $this->balance - $amount,
            // ]);

            return $this->fresh();
        });
    }

    /**
     * Check if has sufficient balance
     */
    public function hasSufficientBalance(float $amount): bool
    {
        return $this->balance >= $amount;
    }
}