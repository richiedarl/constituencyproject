<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Detail;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\WalletCreationService;


class AdminFundController extends Controller
{
    protected $walletService;

    public function __construct(WalletCreationService $walletService)
    {
        $this->walletService = $walletService;
    }

    public function index()
{
    $details = Detail::first();
    $wallet = Wallet::firstOrCreate(
        ['user_id' => Auth::id()],
        ['balance' => 0, 'currency' => 'NGN']
    );

    return view('admin.funds.index', compact('details', 'wallet'));
}

public function saveDetails(Request $request)
{
    $validated = $request->validate([
        'bank_name' => 'required|string|max:100',
        'account_name' => 'required|string|max:100',
        'account_number' => 'required|string|max:20',
        'application_fee' => 'nullable|numeric|min:0', // <-- added validation for application fee
    ]);

    // Ensure a default application fee if none is provided
    if (empty($validated['application_fee'])) {
        $validated['application_fee'] = 1000000; // 1 million NGN hardcoded default
    }

    Detail::updateOrCreate(['id' => 1], $validated);

    return back()->with('success', 'Account details and application fee saved successfully.');
}

public function fundWallet(Request $request)
{
    $request->validate([
        'amount' => 'required|numeric|min:1',
    ]);

    $wallet = Wallet::firstOrCreate(
        ['user_id' => Auth::id()],
        ['balance' => 0, 'currency' => 'NGN']
    );

    $wallet->increment('balance', $request->amount);

    return back()->with('success', 'Wallet funded successfully.');
}

public function withdraw(Request $request)
{
    $request->validate([
        'amount' => 'required|numeric|min:1|max:2000',
    ]);

    $wallet = Wallet::where('user_id', Auth::id())->firstOrFail();

    if ($wallet->balance < $request->amount) {
        return back()->with('error', 'Insufficient wallet balance.');
    }

    $wallet->decrement('balance', $request->amount);

    return back()->with('success', 'Amount withdrawn successfully.');
}

}
