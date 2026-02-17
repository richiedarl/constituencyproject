<?php

namespace App\Traits;

use App\Models\Wallet;
use App\Services\WalletCreationService;

trait HasWallet
{
    /**
     * Get the user's wallet
     */
    public function wallet()
    {
        return $this->hasOne(Wallet::class, 'user_id');
    }

    /**
     * Get or create wallet
     */
    public function getOrCreateWallet()
    {
        $service = app(WalletCreationService::class);
        return $service->getOrCreateWallet($this);
    }

    /**
     * Check if user has wallet
     */
    public function hasWallet(): bool
    {
        return $this->wallet()->exists();
    }

    /**
     * Get wallet balance
     */
    public function getWalletBalanceAttribute()
    {
        return $this->wallet ? $this->wallet->balance : 0;
    }

    /**
     * Credit wallet
     */
    public function creditWallet(float $amount, string $description = null)
    {
        $wallet = $this->getOrCreateWallet();
        return $wallet->credit($amount, $description);
    }

    /**
     * Debit wallet
     */
    public function debitWallet(float $amount, string $description = null)
    {
        $wallet = $this->getOrCreateWallet();
        return $wallet->debit($amount, $description);
    }
}
