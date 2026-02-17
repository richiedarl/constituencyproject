<?php

namespace App\Services;

use App\Models\Wallet;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class WalletCreationService
{
    /**
     * Create a wallet for a user
     *
     * @param int $userId
     * @param string $currency
     * @return Wallet|null
     */
    public function createWallet(int $userId, string $currency = 'NGN'): ?Wallet
    {
        try {
            // Check if wallet already exists
            $existingWallet = Wallet::where('user_id', $userId)->first();

            if ($existingWallet) {
                return $existingWallet;
            }

            // Get user to check for roles
            $user = User::find($userId);

            if (!$user) {
                Log::error("Cannot create wallet: User not found", ['user_id' => $userId]);
                return null;
            }

            // Prepare wallet data
            $walletData = [
                'user_id' => $userId,
                'balance' => 0,
                'currency' => $currency,
            ];

            // Add role-specific foreign keys if they exist (optional)
            if ($user->candidate) {
                $walletData['candidate_id'] = $user->candidate->id;
            }

            if ($user->contractor) {
                $walletData['contractor_id'] = $user->contractor->id;
            }

            if ($user->contributor) {
                $walletData['contributor_id'] = $user->contributor->id;
            }

            if ($user->admin) {
                $walletData['admin_id'] = $userId;
            }

            // Create and return wallet
            return Wallet::create($walletData);

        } catch (\Exception $e) {
            Log::error("Failed to create wallet for user {$userId}: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Create wallet for multiple users
     *
     * @param array $userIds
     * @param string $currency
     * @return array
     */
    public function createWalletsForUsers(array $userIds, string $currency = 'NGN'): array
    {
        $results = [];

        foreach ($userIds as $userId) {
            $results[$userId] = $this->createWallet($userId, $currency);
        }

        return $results;
    }

    /**
     * Ensure user has a wallet (create if not exists)
     *
     * @param int $userId
     * @param string $currency
     * @return Wallet|null
     */
    public function ensureWalletExists(int $userId, string $currency = 'NGN'): ?Wallet
    {
        $wallet = Wallet::where('user_id', $userId)->first();

        if (!$wallet) {
            $wallet = $this->createWallet($userId, $currency);
        }

        return $wallet;
    }
}
