@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Request Withdrawal</h1>
        <a href="{{ route('wallet.transactions') }}" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-history fa-sm text-white-50"></i> View Transactions
        </a>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Available Balance</h6>
                </div>
                <div class="card-body">
                    <h2 class="font-weight-bold text-dark">₦{{ number_format($wallet->balance ?? 0, 2) }}</h2>
                </div>
            </div>

            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Withdrawal Details</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('wallet.withdraw.process') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label>Amount (₦)</label>
                            <input type="number" name="amount" class="form-control @error('amount') is-invalid @enderror"
                                   min="100" max="{{ $wallet->balance }}" step="100" required>
                            @error('amount')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">Maximum: ₦{{ number_format($wallet->balance, 2) }}</small>
                        </div>

                        <div class="form-group">
                            <label>Bank Name</label>
                            <input type="text" name="bank_name" class="form-control @error('bank_name') is-invalid @enderror" required>
                            @error('bank_name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Account Number</label>
                            <input type="text" name="account_number" class="form-control @error('account_number') is-invalid @enderror" required>
                            @error('account_number')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Account Name</label>
                            <input type="text" name="account_name" class="form-control @error('account_name') is-invalid @enderror" required>
                            @error('account_name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-warning btn-block">
                            <i class="fas fa-money-bill-wave"></i> Request Withdrawal
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
