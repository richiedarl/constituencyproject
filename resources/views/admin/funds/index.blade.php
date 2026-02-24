@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <h4 class="mb-4">Payment & Wallet Settings</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Account Details -->
    <div class="card mb-4">
        <div class="card-header">Payment Account Details</div>
        <div class="card-body">
            <form method="POST" action="{{ route('personal.funds.details') }}">
                @csrf

                <div class="mb-3">
                    <label>Bank Name</label>
                    <input type="text" name="bank_name"
                           value="{{ $details->bank_name ?? '' }}"
                           class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Account Name</label>
                    <input type="text" name="account_name"
                           value="{{ $details->account_name ?? '' }}"
                           class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Account Number</label>
                    <input type="text" name="account_number"
                           value="{{ $details->account_number ?? '' }}"
                           class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Application Fee <small class="text-muted">(What will applicants pay to apply for a project?)</small></label>
                    <input type="number" name="application_fee"
                           value="{{ $details->application_fee ?? '' }}"
                           class="form-control" min="0" step="0.01"
                           placeholder="Enter application fee in NGN">
                </div>

                <button class="btn btn-primary">Save Details</button>
            </form>
        </div>
    </div>

    <!-- Wallet -->
    <div class="card">
        <div class="card-header">Admin Wallet</div>
        <div class="card-body">
            <h5>Balance: ₦{{ number_format($wallet->balance, 2) }}</h5>

            <form method="POST" action="{{ route('personal.funds.add') }}" class="mt-3">
                @csrf
                <input type="number" name="amount" class="form-control mb-2" placeholder="Amount to add">
                <button class="btn btn-success">Add Funds</button>
            </form>

            <form method="POST" action="{{ route('personal.funds.withdraw') }}" class="mt-3">
                @csrf
                <input type="number" name="amount" max="2000"
                       class="form-control mb-2"
                       placeholder="Withdraw (max ₦2,000)">
                <button class="btn btn-danger">Withdraw</button>
            </form>
        </div>
    </div>

</div>
@endsection
