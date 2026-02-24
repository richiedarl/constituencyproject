@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Transaction History</h1>
        <div>
            @if(auth()->user()->contributor)
                <a href="{{ route('wallet.fund') }}" class="btn btn-sm btn-success shadow-sm">
                    <i class="fas fa-plus-circle fa-sm text-white-50"></i> Fund Wallet
                </a>
            @endif
            @if(auth()->user()->contractor)
                <a href="{{ route('wallet.withdraw') }}" class="btn btn-sm btn-warning shadow-sm">
                    <i class="fas fa-money-bill-wave fa-sm text-white-50"></i> Withdraw
                </a>
            @endif
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Current Balance: ₦{{ number_format($wallet->balance ?? 0, 2) }}</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Reference</th>
                            <th>Type</th>
                            <th>Description</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->created_at->format('M d, Y H:i') }}</td>
                                <td>{{ $transaction->reference }}</td>
                                <td>
                                    @if($transaction->type == 'credit')
                                        <span class="badge badge-success">Credit</span>
                                    @elseif($transaction->type == 'withdrawal')
                                        <span class="badge badge-warning">Withdrawal</span>
                                    @else
                                        <span class="badge badge-secondary">{{ ucfirst($transaction->type) }}</span>
                                    @endif
                                </td>
                                <td>{{ $transaction->description }}</td>
                                <td class="{{ $transaction->type == 'credit' ? 'text-success' : 'text-danger' }}">
                                    {{ $transaction->type == 'credit' ? '+' : '-' }}₦{{ number_format($transaction->amount, 2) }}
                                </td>
                                <td>
                                    @if($transaction->status == 'completed')
                                        <span class="badge badge-success">Completed</span>
                                    @elseif($transaction->status == 'pending')
                                        <span class="badge badge-warning">Pending</span>
                                    @else
                                        <span class="badge badge-danger">Failed</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No transactions found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center">
                {{ $transactions->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
