@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4">

                    @if($project)
                        {{-- Contributing to a specific project --}}
                        <h4 class="fw-bold mb-3">Contribute to: {{ $project->title }}</h4>
                        <p class="text-muted mb-4">{{ $project->short_description }}</p>

                        <div class="bg-light p-3 rounded-3 mb-4">
                            <p class="mb-1"><strong>Location:</strong> {{ $project->full_location }}</p>
                            <p class="mb-1"><strong>Status:</strong> {{ ucfirst($project->status) }}</p>
                            <p class="mb-0"><strong>Budget:</strong> ₦{{ number_format($project->estimated_budget ?? 0) }}</p>
                        </div>

                        {{-- Dynamic Thank You Badge --}}
                        <div id="donationBadge" class="alert alert-success text-center fw-bold mb-4" style="display: none;">
                            Thank you! You are donating <span id="donationAmount">₦0</span>
                        </div>

                        <form action="{{ route('contributor.project.apply.save', $project->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            @if(!$contributor)
                                {{-- New contributor - need additional info --}}
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i>
                                    You're new here! Please complete your contributor profile to continue.
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Bio</label>
                                    <textarea name="bio" class="form-control @error('bio') is-invalid @enderror" rows="3" required>{{ old('bio') }}</textarea>
                                    @error('bio') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">District</label>
                                        <input type="text" name="district" class="form-control @error('district') is-invalid @enderror" value="{{ old('district') }}" required>
                                        @error('district') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">Gender</label>
                                        <select name="gender" class="form-select @error('gender') is-invalid @enderror" required>
                                            <option value="">Select gender</option>
                                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                            <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                        @error('gender') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Profile Photo</label>
                                    <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror" accept="image/*">
                                    @error('photo') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            @endif

                            {{-- Always show contribution fields --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Amount (₦)</label>
                                <input type="number"
                                       id="amount"
                                       name="amount"
                                       class="form-control @error('amount') is-invalid @enderror"
                                       min="100"
                                       step="0.01"
                                       value="{{ old('amount') }}"
                                       onkeyup="updateDonationAmount()"
                                       onchange="updateDonationAmount()"
                                       required>
                                @error('amount') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Payment Method</label>
                                <select name="payment_method" id="payment_method" class="form-select @error('payment_method') is-invalid @enderror" onchange="toggleBankDetails()" required>
                                    <option value="">Select Payment Method</option>
                                    <option value="wallet" {{ old('payment_method') == 'wallet' ? 'selected' : '' }}>Pay from Wallet</option>
                                    <option value="bank" {{ old('payment_method') == 'bank' ? 'selected' : '' }}>Bank Transfer</option>
                                </select>
                                @error('payment_method') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>

                            {{-- Bank Details - Hidden by default, shows when Bank Transfer is selected --}}
                            <div id="bankDetails" style="display: none;">
                                @if($bankDetails)
                                    <div class="alert alert-info border-2 border-primary">
                                        <h6 class="fw-bold text-primary mb-2"><i class="fas fa-university"></i> Bank Transfer Details</h6>
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
                                        <div class="mt-2 p-2 bg-light rounded">
                                            <small class="text-muted">
                                                <i class="fas fa-info-circle"></i>
                                                After transfer, your donation will be pending approval. You'll be notified once confirmed.
                                            </small>
                                        </div>
                                    </div>
                                @else
                                    <div class="alert alert-warning">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        Bank details not available. Please contact support.
                                    </div>
                                @endif
                            </div>

                            <button type="submit" class="btn btn-success w-100 rounded-pill py-2">
                                <i class="fas fa-heart"></i> Confirm Contribution
                            </button>
                        </form>

                    @else
                        {{-- Registration only (no project) --}}
                        <h4 class="fw-bold mb-3">Become a Contributor</h4>
                        <p class="text-muted mb-4">Complete your profile to start supporting projects.</p>

                        @if($contributor)
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle"></i>
                                You're already registered as a contributor!
                                <a href="{{ route('wallet.fund') }}" class="alert-link">Fund your wallet</a> to start supporting projects.
                            </div>
                        @else
                            <form action="{{ route('contributor.apply.save') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Bio</label>
                                    <textarea name="bio" class="form-control @error('bio') is-invalid @enderror" rows="3" required>{{ old('bio') }}</textarea>
                                    @error('bio') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">District</label>
                                        <input type="text" name="district" class="form-control @error('district') is-invalid @enderror" value="{{ old('district') }}" required>
                                        @error('district') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">Gender</label>
                                        <select name="gender" class="form-select @error('gender') is-invalid @enderror" required>
                                            <option value="">Select gender</option>
                                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                            <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                        @error('gender') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Profile Photo</label>
                                    <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror" accept="image/*">
                                    @error('photo') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>

                                <button type="submit" class="btn btn-success w-100 rounded-pill py-2">
                                    <i class="fas fa-user-plus"></i> Register as Contributor
                                </button>
                            </form>
                        @endif
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Update donation amount badge in real-time
    function updateDonationAmount() {
        const amountInput = document.getElementById('amount');
        const donationBadge = document.getElementById('donationBadge');
        const donationAmount = document.getElementById('donationAmount');

        if (amountInput && amountInput.value > 0) {
            const formattedAmount = new Intl.NumberFormat('en-NG', {
                style: 'currency',
                currency: 'NGN',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(amountInput.value);

            donationAmount.textContent = formattedAmount;
            donationBadge.style.display = 'block';
        } else {
            donationBadge.style.display = 'none';
        }
    }

    // Toggle bank details visibility based on payment method
    function toggleBankDetails() {
        const paymentMethod = document.getElementById('payment_method');
        const bankDetails = document.getElementById('bankDetails');

        if (paymentMethod.value === 'bank') {
            bankDetails.style.display = 'block';
            // Also show donation badge if amount is entered
            updateDonationAmount();
        } else {
            bankDetails.style.display = 'none';
        }
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        // Check if there's an existing amount value
        updateDonationAmount();

        // Check if bank transfer was previously selected
        toggleBankDetails();
    });
</script>
@endpush

@push('styles')
<style>
    #donationBadge {
        animation: fadeIn 0.5s ease-in-out;
    }

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

    .alert-info.border-2 {
        border-width: 2px !important;
    }

    #bankDetails {
        transition: all 0.3s ease-in-out;
    }
</style>
@endpush
