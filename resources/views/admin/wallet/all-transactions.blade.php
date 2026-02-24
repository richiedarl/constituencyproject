@extends('layouts.admin')

@section('title', 'All Transactions')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col">
            <h1 class="h2">All Transactions</h1>
            <p class="text-muted">Complete transaction history across all wallets</p>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card bg-primary text-white shadow">
                <div class="card-body">
                    <h6 class="text-white-50">Total Volume</h6>
                    <h3 class="text-white mb-0">₦{{ number_format($summary['total_volume']) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-success text-white shadow">
                <div class="card-body">
                    <h6 class="text-white-50">Total Credits</h6>
                    <h3 class="text-white mb-0">₦{{ number_format($summary['total_credits']) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-danger text-white shadow">
                <div class="card-body">
                    <h6 class="text-white-50">Total Withdrawals</h6>
                    <h3 class="text-white mb-0">₦{{ number_format($summary['total_withdrawals']) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-warning text-white shadow">
                <div class="card-body">
                    <h6 class="text-white-50">Pending Withdrawals</h6>
                    <h3 class="text-white mb-0">₦{{ number_format($summary['pending_withdrawals']) }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Transactions Table --}}
    <div class="card shadow">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Transaction History</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>User</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Reference</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->created_at->format('M d, Y H:i') }}</td>
                                <td>
                                    <strong>{{ $transaction->wallet->user->name ?? 'N/A' }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $transaction->wallet->user->email ?? '' }}</small>
                                </td>
                                <td>
                                    @if($transaction->type === 'credit')
                                        <span class="badge bg-success">Credit</span>
                                    @elseif($transaction->type === 'withdrawal')
                                        <span class="badge bg-warning text-dark">Withdrawal</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($transaction->type) }}</span>
                                    @endif
                                </td>
                                <td>
                                    <strong class="{{ $transaction->type === 'credit' ? 'text-success' : 'text-danger' }}">
                                        {{ $transaction->type === 'credit' ? '+' : '-' }}₦{{ number_format($transaction->amount) }}
                                    </strong>
                                </td>
                                <td>
                                    @if($transaction->status === 'completed')
                                        <span class="badge bg-success">Completed</span>
                                    @elseif($transaction->status === 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif($transaction->status === 'failed')
                                        <span class="badge bg-danger">Failed</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($transaction->status) }}</span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">{{ $transaction->reference }}</small>
                                </td>
                                <td>
                                    <small>{{ Str::limit($transaction->description, 40) }}</small>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $transactions->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
