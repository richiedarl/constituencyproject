<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use App\Models\Transaction;
use App\Models\PendingFundingRequest;
use App\Models\Detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{



    /**
     * Show fund wallet form (only for contributors)
     */
    public function fundForm()
    {
        $user = Auth::user();

        // Only contributors can fund wallets
        if (!$user->contributor) {
            abort(403, 'Only contributors can fund wallets');
        }

        $wallet = $user->wallet;
        $bankDetails = Detail::latest()->first();

        return view('user.wallet.fund', compact('wallet', 'bankDetails'));
    }

    /**
     * Process wallet funding request (pending admin approval)
     */
    public function fund(Request $request)
    {
        $user = Auth::user();

        if (!$user->contributor) {
            abort(403, 'Only contributors can fund wallets');
        }

        $request->validate([
            'amount' => 'required|numeric|min:100',
            'payment_method' => 'required|in:card,bank_transfer,ussd',
        ]);

        DB::beginTransaction();

        try {
            $wallet = $user->wallet;

            // Create pending funding request
            $pendingRequest = PendingFundingRequest::create([
                'user_id' => $user->id,
                'wallet_id' => $wallet->id,
                'amount' => $request->amount,
                'payment_method' => $request->payment_method,
                'reference' => 'FUND_' . uniqid() . '_' . time(),
                'status' => 'pending'
            ]);

            // Create transaction record as pending
            Transaction::create([
                'wallet_id' => $wallet->id,
                'user_id' => $user->id,
                'type' => 'credit',
                'amount' => $request->amount,
                'description' => 'Pending wallet funding via ' . str_replace('_', ' ', $request->payment_method),
                'status' => 'pending',
                'reference' => $pendingRequest->reference,
                'metadata' => json_encode([
                    'pending_request_id' => $pendingRequest->id,
                    'payment_method' => $request->payment_method
                ])
            ]);

            DB::commit();

            $message = 'Your funding request has been submitted and is pending admin approval. ';

            if ($request->payment_method === 'bank_transfer') {
                $bankDetails = Detail::latest()->first();
                if ($bankDetails) {
                    $message .= 'Please transfer to: ' . $bankDetails->bank_name . ' - ' .
                               $bankDetails->account_name . ' - ' . $bankDetails->account_number;
                }
            }

            return redirect()->route('wallet.transactions')
                ->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Funding request failed: ' . $e->getMessage()]);
        }
    }

    /**
     * Show withdrawal request form (only for contractors)
     */
    public function withdrawalForm()
    {
        $user = Auth::user();

        // Only contractors can request withdrawals
        if (!$user->contractor) {
            abort(403, 'Only contractors can request withdrawals');
        }

        $wallet = $user->wallet;

        return view('user.wallet.withdraw', compact('wallet'));
    }

    /**
     * Process withdrawal request (only for contractors)
     */
    public function withdraw(Request $request)
    {
        $user = Auth::user();

        if (!$user->contractor) {
            abort(403, 'Only contractors can request withdrawals');
        }

        $request->validate([
            'amount' => 'required|numeric|min:100',
            'bank_name' => 'required|string',
            'account_number' => 'required|string',
            'account_name' => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            $wallet = $user->wallet;

            // Check sufficient balance
            if ($wallet->balance < $request->amount) {
                throw new \Exception('Insufficient balance');
            }

            // Deduct from wallet immediately (withdrawal requests are pending)
            $wallet->balance -= $request->amount;
            $wallet->save();

            // Create pending withdrawal transaction
            Transaction::create([
                'wallet_id' => $wallet->id,
                'user_id' => $user->id,
                'type' => 'withdrawal',
                'amount' => $request->amount,
                'description' => 'Withdrawal request to ' . $request->bank_name . ' - ' . $request->account_number,
                'status' => 'pending',
                'reference' => 'WDR_' . uniqid() . '_' . time(),
                'metadata' => json_encode([
                    'bank_name' => $request->bank_name,
                    'account_number' => $request->account_number,
                    'account_name' => $request->account_name,
                ]),
            ]);

            DB::commit();

            return redirect()->route('wallet.transactions')
                ->with('success', 'Withdrawal request submitted successfully! It will be processed by admin.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Withdrawal failed: ' . $e->getMessage()]);
        }
    }

    /**
 * Show transaction history for all users
 */
public function transactions()
{
    $user = Auth::user();

    // Get or create wallet
    $wallet = $user->wallet;
    if (!$wallet) {
        $wallet = Wallet::create([
            'user_id' => $user->id,
            'balance' => 0,
            'currency' => 'NGN'
        ]);
    }

    $transactions = Transaction::where('wallet_id', $wallet->id)
        ->orderBy('created_at', 'desc')
        ->paginate(15);

    return view('user.wallet.transactions', compact('wallet', 'transactions'));
}
}
