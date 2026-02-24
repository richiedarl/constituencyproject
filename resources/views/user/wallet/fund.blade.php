@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Fund Wallet</h1>
        <a href="{{ route('wallet.transactions') }}" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-history fa-sm text-white-50"></i> View Transactions
        </a>
    </div>

    {{-- Dynamic Amount Badge --}}
    <div id="amountBadge" class="alert alert-success text-center fw-bold mb-4" style="display: none;">
        <i class="fas fa-check-circle me-2"></i>
        You are requesting to add <span id="displayAmount">₦0</span> to your wallet
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Current Balance</h6>
                </div>
                <div class="card-body">
                    <h2 class="font-weight-bold text-dark">₦{{ number_format($wallet->balance ?? 0, 2) }}</h2>
                </div>
            </div>

            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Request Funds</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('wallet.fund.process') }}" method="POST">
                        @csrf

                        <div class="form-group mb-3">
                            <label class="fw-semibold">Amount (₦)</label>
                            <input type="number"
                                   name="amount"
                                   id="amount"
                                   class="form-control @error('amount') is-invalid @enderror form-control-lg"
                                   min="100"
                                   step="100"
                                   value="{{ old('amount') }}"
                                   onkeyup="updateAmount()"
                                   onchange="updateAmount()"
                                   required>
                            @error('amount')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">Minimum amount: ₦100</small>
                        </div>

                        <div class="form-group mb-4">
                            <label class="fw-semibold">Payment Method</label>
                            <select name="payment_method"
                                    id="payment_method"
                                    class="form-control @error('payment_method') is-invalid @enderror form-control-lg"
                                    onchange="togglePaymentDetails()"
                                    required>
                                <option value="">Select method...</option>
                                <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>Card Payment</option>
                                <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                <option value="ussd" {{ old('payment_method') == 'ussd' ? 'selected' : '' }}>USSD</option>
                            </select>
                            @error('payment_method')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Bank Transfer Details --}}
                        <div id="bankDetails" style="display: none;">
                            @if($bankDetails)
                                <div class="alert alert-info border-2 border-primary mb-4">
                                    <h6 class="fw-bold text-primary mb-3"><i class="fas fa-university me-2"></i>Bank Transfer Details</h6>
                                    <div class="row">
                                        <div class="col-md-4 mb-2">
                                            <small class="text-muted d-block">Bank Name</small>
                                            <strong>{{ $bankDetails->bank_name }}</strong>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <small class="text-muted d-block">Account Name</small>
                                            <strong>{{ $bankDetails->account_name }}</strong>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <small class="text-muted d-block">Account Number</small>
                                            <strong class="text-primary">{{ $bankDetails->account_number }}</strong>
                                        </div>
                                    </div>
                                    <div class="mt-3 p-2 bg-light rounded">
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle me-1"></i>
                                            After transfer, your request will be pending admin approval. You'll be notified once confirmed.
                                        </small>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-warning mb-4">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    Bank details not available. Please contact support.
                                </div>
                            @endif
                        </div>

                        {{-- Card Payment Details --}}
                        <div id="cardDetails" style="display: none;">
                            <div class="alert alert-secondary mb-4">
                                <h6 class="fw-bold mb-3"><i class="fas fa-credit-card me-2"></i>Card Payment</h6>
                                <p class="mb-0">You will be redirected to our secure payment gateway. Your request will be pending admin approval after payment.</p>
                            </div>
                        </div>

                        {{-- USSD Details --}}
                        <div id="ussdDetails" style="display: none;">
                            <div class="alert alert-secondary mb-4">
                                <h6 class="fw-bold mb-3"><i class="fas fa-mobile-alt me-2"></i>USSD Payment</h6>
                                <p class="mb-1">Dial *123# on your mobile phone and follow the prompts.</p>
                                <p class="mb-0 small text-muted">Your request will be pending admin approval after payment.</p>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success btn-block btn-lg w-100">
                            <i class="fas fa-plus-circle me-2"></i> Submit Funding Request
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function updateAmount() {
        const amountInput = document.getElementById('amount');
        const amountBadge = document.getElementById('amountBadge');
        const displayAmount = document.getElementById('displayAmount');

        if (amountInput && amountInput.value > 0) {
            const formattedAmount = new Intl.NumberFormat('en-NG', {
                style: 'currency',
                currency: 'NGN',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(amountInput.value);

            displayAmount.textContent = formattedAmount;
            amountBadge.style.display = 'block';
            amountBadge.style.animation = 'fadeIn 0.5s ease-in-out';
        } else {
            amountBadge.style.display = 'none';
        }
    }

    function togglePaymentDetails() {
        const paymentMethod = document.getElementById('payment_method');
        const bankDetails = document.getElementById('bankDetails');
        const cardDetails = document.getElementById('cardDetails');
        const ussdDetails = document.getElementById('ussdDetails');

        // Hide all details first
        bankDetails.style.display = 'none';
        cardDetails.style.display = 'none';
        ussdDetails.style.display = 'none';

        // Show selected method details
        if (paymentMethod.value === 'bank_transfer') {
            bankDetails.style.display = 'block';
            bankDetails.style.animation = 'fadeIn 0.5s ease-in-out';
        } else if (paymentMethod.value === 'card') {
            cardDetails.style.display = 'block';
            cardDetails.style.animation = 'fadeIn 0.5s ease-in-out';
        } else if (paymentMethod.value === 'ussd') {
            ussdDetails.style.display = 'block';
            ussdDetails.style.animation = 'fadeIn 0.5s ease-in-out';
        }

        updateAmount();
    }

    document.addEventListener('DOMContentLoaded', function() {
        updateAmount();
        togglePaymentDetails();

        const style = document.createElement('style');
        style.textContent = `
            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(-10px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        `;
        document.head.appendChild(style);
    });
</script>
@endpush
