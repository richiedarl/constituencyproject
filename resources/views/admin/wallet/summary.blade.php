@extends('layouts.admin')

@section('title', 'Wallet Summary')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col">
            <h1 class="h2">Wallet Summary</h1>
            <p class="text-muted">Overview of all wallet activity and statistics</p>
        </div>
    </div>

    {{-- Overview Cards --}}
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card bg-gradient-primary text-white shadow-lg border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50">Total Balance</h6>
                            <h2 class="text-white mb-0">₦{{ number_format($totalBalance) }}</h2>
                        </div>
                        <i class="fas fa-wallet fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card bg-gradient-success text-white shadow-lg border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50">Users with Wallets</h6>
                            <h2 class="text-white mb-0">{{ $totalUsers }}</h2>
                        </div>
                        <i class="fas fa-users fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card bg-gradient-info text-white shadow-lg border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50">Average Balance</h6>
                            <h2 class="text-white mb-0">₦{{ number_format($averageBalance) }}</h2>
                        </div>
                        <i class="fas fa-chart-line fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Top Wallets --}}
        <div class="col-lg-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Top 10 Wallets by Balance</h5>
                </div>
                <div class="card-body">
                    @if($topWallets->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>User</th>
                                        <th>Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($topWallets as $index => $wallet)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                <strong>{{ $wallet->user->name }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $wallet->user->email }}</small>
                                            </td>
                                            <td>
                                                <strong class="text-success">₦{{ number_format($wallet->balance) }}</strong>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted text-center py-3">No wallets found</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Monthly Stats --}}
        <div class="col-lg-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Monthly Activity ({{ date('Y') }})</h5>
                </div>
                <div class="card-body">
                    @if($monthlyStats->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Month</th>
                                        <th>Credits</th>
                                        <th>Withdrawals</th>
                                        <th>Net Flow</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($monthlyStats as $stat)
                                        @php
                                            $netFlow = $stat->total_credits - $stat->total_withdrawals;
                                        @endphp
                                        <tr>
                                            <td><strong>{{ DateTime::createFromFormat('!m', $stat->month)->format('F') }}</strong></td>
                                            <td class="text-success">₦{{ number_format($stat->total_credits) }}</td>
                                            <td class="text-danger">₦{{ number_format($stat->total_withdrawals) }}</td>
                                            <td class="{{ $netFlow >= 0 ? 'text-success' : 'text-danger' }}">
                                                <strong>{{ $netFlow >= 0 ? '+' : '' }}₦{{ number_format($netFlow) }}</strong>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted text-center py-3">No transaction data for {{ date('Y') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Additional Stats --}}
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Quick Insights</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="border-start border-success border-4 ps-3">
                                <small class="text-muted">Total Credits (Completed)</small>
                                <h4 class="mb-0 text-success">₦{{ number_format($monthlyStats->sum('total_credits')) }}</h4>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="border-start border-danger border-4 ps-3">
                                <small class="text-muted">Total Withdrawals (Completed)</small>
                                <h4 class="mb-0 text-danger">₦{{ number_format($monthlyStats->sum('total_withdrawals')) }}</h4>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="border-start border-info border-4 ps-3">
                                <small class="text-muted">Average Transaction</small>
                                <h4 class="mb-0 text-info">
                                    @php
                                        $totalTransactions = $monthlyStats->sum('total_credits') + $monthlyStats->sum('total_withdrawals');
                                        $transactionCount = \App\Models\Transaction::where('status', 'completed')->count();
                                        $avgTransaction = $transactionCount > 0 ? $totalTransactions / $transactionCount : 0;
                                    @endphp
                                    ₦{{ number_format($avgTransaction) }}
                                </h4>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="border-start border-primary border-4 ps-3">
                                <small class="text-muted">Wallet Utilization</small>
                                <h4 class="mb-0 text-primary">
                                    @php
                                        $activeWallets = \App\Models\Wallet::where('balance', '>', 0)->count();
                                        $utilization = $totalUsers > 0 ? round(($activeWallets / $totalUsers) * 100) : 0;
                                    @endphp
                                    {{ $utilization }}%
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
.bg-gradient-success {
    background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);
}
.bg-gradient-info {
    background: linear-gradient(135deg, #a1c4fd 0%, #c2e9fb 100%);
}
.opacity-50 {
    opacity: 0.5;
}
</style>
@endpush
