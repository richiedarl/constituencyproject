<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PendingFundingRequest;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminWalletController extends Controller
{

    /**
     * Show pending funding requests
     */
    public function pendingFundingRequests()
    {
        $requests = PendingFundingRequest::with(['user', 'wallet'])
            ->where('status', 'pending')
            ->latest()
            ->get();

        $stats = [
            'total_pending' => $requests->count(),
            'total_amount' => $requests->sum('amount'),
            'avg_amount' => $requests->avg('amount'),
            'bank_transfers' => $requests->where('payment_method', 'bank_transfer')->count(),
            'card_payments' => $requests->where('payment_method', 'card')->count(),
            'ussd_payments' => $requests->where('payment_method', 'ussd')->count(),
        ];

        return view('admin.wallet.pending-funding', compact('requests', 'stats'));
    }

 /**
 * Approve a funding request
 */
public function approveFundingRequest(Request $request)
{
    $request->validate([
        'request_id' => 'required|exists:pending_funding_requests,id'
    ]);

    $fundingRequest = PendingFundingRequest::findOrFail($request->request_id);

    DB::beginTransaction();

    try {
        // Update request status
        $fundingRequest->status = 'approved';
        $fundingRequest->approved_by = Auth::id();
        $fundingRequest->approved_at = now();
        $fundingRequest->save();

        // Credit the wallet
        $wallet = $fundingRequest->wallet;
        $wallet->balance += $fundingRequest->amount;
        $wallet->save();

        // Update transaction
        Transaction::where('reference', $fundingRequest->reference)
            ->update([
                'status' => 'completed',
                'description' => 'Wallet funding via ' . str_replace('_', ' ', $fundingRequest->payment_method) . ' (Approved)'
            ]);

        DB::commit();

        return back()->with('success', 'Funding request of ₦' . number_format($fundingRequest->amount) . ' approved successfully!');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withErrors(['error' => 'Approval failed: ' . $e->getMessage()]);
    }
}
    /**
     * Reject a funding request
     */
    public function rejectFundingRequest(Request $request, PendingFundingRequest $fundingRequest)
    {
        $request->validate([
            'admin_notes' => 'required|string|min:10'
        ]);

        DB::beginTransaction();

        try {
            $fundingRequest->status = 'rejected';
            $fundingRequest->admin_notes = $request->admin_notes;
            $fundingRequest->approved_by = Auth::id();
            $fundingRequest->approved_at = now();
            $fundingRequest->save();

            // Update transaction
            Transaction::where('reference', $fundingRequest->reference)
                ->update([
                    'status' => 'failed',
                    'description' => 'Wallet funding rejected: ' . $request->admin_notes
                ]);

            DB::commit();

            return back()->with('success', 'Funding request rejected.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to reject: ' . $e->getMessage()]);
        }
    }

    /**
     * Show pending withdrawal requests
     */
    public function pendingWithdrawals()
    {
        $withdrawals = Transaction::with(['wallet.user'])
            ->where('type', 'withdrawal')
            ->where('status', 'pending')
            ->latest()
            ->get();

        $stats = [
            'total_pending' => $withdrawals->count(),
            'total_amount' => $withdrawals->sum('amount'),
            'avg_amount' => $withdrawals->avg('amount'),
        ];

        return view('admin.wallet.pending-withdrawals', compact('withdrawals', 'stats'));
    }

/**
 * Approve a withdrawal request
 */
public function approveWithdrawal(Request $request)
{
    $request->validate([
        'transaction_id' => 'required|exists:transactions,id'
    ]);

    $transaction = Transaction::findOrFail($request->transaction_id);

    if ($transaction->type !== 'withdrawal' || $transaction->status !== 'pending') {
        return back()->with('error', 'Invalid withdrawal request.');
    }

    DB::beginTransaction();

    try {
        // Mark transaction as completed
        $transaction->status = 'completed';
        $transaction->description .= ' (Approved by admin)';
        $transaction->save();

        DB::commit();

        return back()->with('success', 'Withdrawal of ₦' . number_format($transaction->amount) . ' approved successfully!');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withErrors(['error' => 'Approval failed: ' . $e->getMessage()]);
    }
}

/**
 * Reject a withdrawal request
 */
public function rejectWithdrawal(Request $request)
{
    $request->validate([
        'transaction_id' => 'required|exists:transactions,id',
        'admin_notes' => 'required|string|min:10'
    ]);

    $transaction = Transaction::findOrFail($request->transaction_id);

    if ($transaction->type !== 'withdrawal' || $transaction->status !== 'pending') {
        return back()->with('error', 'Invalid withdrawal request.');
    }

    DB::beginTransaction();

    try {
        // Refund the money back to wallet
        $wallet = $transaction->wallet;
        $wallet->balance += $transaction->amount;
        $wallet->save();

        // Update transaction
        $transaction->status = 'failed';
        $transaction->description = 'Withdrawal rejected: ' . $request->admin_notes;
        $transaction->save();

        DB::commit();

        return back()->with('success', 'Withdrawal request rejected and funds refunded.');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withErrors(['error' => 'Failed to reject: ' . $e->getMessage()]);
    }
}

    /**
     * Show all transactions
     */
    public function allTransactions()
    {
        $transactions = Transaction::with(['wallet.user'])
            ->latest()
            ->paginate(20);

        $summary = [
            'total_volume' => Transaction::sum('amount'),
            'total_credits' => Transaction::where('type', 'credit')->where('status', 'completed')->sum('amount'),
            'total_withdrawals' => Transaction::where('type', 'withdrawal')->where('status', 'completed')->sum('amount'),
            'pending_withdrawals' => Transaction::where('type', 'withdrawal')->where('status', 'pending')->sum('amount'),
        ];

        return view('admin.wallet.all-transactions', compact('transactions', 'summary'));
    }

    /**
     * Show wallet summary
     */
    public function walletSummary()
    {
        $totalBalance = Wallet::sum('balance');
        $totalUsers = Wallet::count();
        $averageBalance = Wallet::avg('balance');

        $topWallets = Wallet::with('user')
            ->orderBy('balance', 'desc')
            ->limit(10)
            ->get();

        $monthlyStats = Transaction::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('YEAR(created_at) as year'),
            DB::raw('SUM(CASE WHEN type = "credit" AND status = "completed" THEN amount ELSE 0 END) as total_credits'),
            DB::raw('SUM(CASE WHEN type = "withdrawal" AND status = "completed" THEN amount ELSE 0 END) as total_withdrawals')
        )
        ->whereYear('created_at', date('Y'))
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->orderBy('month', 'desc')
        ->get();

        return view('admin.wallet.summary', compact('totalBalance', 'totalUsers', 'averageBalance', 'topWallets', 'monthlyStats'));
    }
}
