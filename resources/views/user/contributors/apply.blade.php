@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <!-- Card Header with Project Summary -->
                @if($project)
                <div class="card-header bg-gradient text-white p-4" style="background: linear-gradient(135deg, #29a221 0%, #ffc107 100%);">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="fw-bold mb-1">{{ $project->title }}</h4>
                            <p class="mb-0 opacity-90">
                                <i class="bi bi-geo-alt-fill me-1"></i>
                                {{ $project->full_location }}
                            </p>
                        </div>
                        <span class="badge bg-light text-dark px-3 py-2 rounded-pill">
                            <i class="bi bi-tag me-1"></i>
                            {{ ucfirst($project->status) }}
                        </span>
                    </div>
                </div>
                @endif

                <div class="card-body p-4">
                    @if($project)
                        {{-- Project Progress Summary (Optional) --}}
                        @if($project->progress_percentage)
                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-1">
                                <small class="text-muted">Project Progress</small>
                                <small class="fw-bold">{{ $project->progress_percentage }}%</small>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-success" style="width: {{ $project->progress_percentage }}%"></div>
                            </div>
                        </div>
                        @endif

                        {{-- Dynamic Thank You Badge --}}
                        <div id="donationBadge" class="alert alert-success text-center fw-bold mb-4 animate__animated animate__fadeIn" style="display: none; border-left: 4px solid #29a221;">
                            <i class="bi bi-heart-fill me-2" style="color: #ffc107;"></i>
                            Thank you! You are donating <span id="donationAmount" class="text-success">₦0</span>
                        </div>

                        <form action="{{ route('contributor.project.apply.save', $project->id) }}" method="POST" enctype="multipart/form-data" id="contributionForm">
                            @csrf

                            @if(!$contributor)
                                {{-- New contributor - need additional info --}}
                                <div class="alert alert-info bg-light border-0">
                                    <i class="bi bi-info-circle-fill me-2" style="color: #29a221;"></i>
                                    Welcome! Please complete your profile to continue.
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label fw-semibold">Bio <span class="text-danger">*</span></label>
                                        <textarea name="bio" class="form-control @error('bio') is-invalid @enderror" rows="3" placeholder="Tell us a bit about yourself..." required>{{ old('bio') }}</textarea>
                                        @error('bio') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">District <span class="text-danger">*</span></label>
                                        <input type="text" name="district" class="form-control @error('district') is-invalid @enderror" value="{{ old('district') }}" placeholder="e.g., Oshodi" required>
                                        @error('district') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">Gender <span class="text-danger">*</span></label>
                                        <select name="gender" class="form-select @error('gender') is-invalid @enderror" required>
                                            <option value="">Select gender</option>
                                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                            <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                        @error('gender') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-md-12 mb-4">
                                        <label class="form-label fw-semibold">Profile Photo</label>
                                        <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror" accept="image/*">
                                        <small class="text-muted">Optional. Max 2MB.</small>
                                        @error('photo') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            @endif

                            {{-- Contribution Section --}}
                            <div class="contribution-section p-4 rounded-3 mb-4" style="background: rgba(41, 162, 33, 0.03);">
                                <h5 class="fw-bold mb-3" style="color: #29a221;">
                                    <i class="bi bi-cash-stack me-2"></i>
                                    Make Your Contribution
                                </h5>

                                {{-- Amount Input with Quick Select --}}
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Amount (₦) <span class="text-danger">*</span></label>
                                    <div class="row g-2 mb-2">
                                        <div class="col-4">
                                            <button type="button" class="btn btn-outline-success w-100 quick-amount" data-amount="1000">₦1,000</button>
                                        </div>
                                        <div class="col-4">
                                            <button type="button" class="btn btn-outline-success w-100 quick-amount" data-amount="5000">₦5,000</button>
                                        </div>
                                        <div class="col-4">
                                            <button type="button" class="btn btn-outline-success w-100 quick-amount" data-amount="10000">₦10,000</button>
                                        </div>
                                    </div>
                                    <input type="number"
                                           id="amount"
                                           name="amount"
                                           class="form-control form-control-lg @error('amount') is-invalid @enderror"
                                           min="100"
                                           step="100"
                                           placeholder="Enter amount (min ₦100)"
                                           value="{{ old('amount') }}"
                                           onkeyup="updateDonationAmount()"
                                           onchange="updateDonationAmount()"
                                           required>
                                    @error('amount') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>

                                {{-- Payment Method Selection --}}
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Payment Method <span class="text-danger">*</span></label>
                                    <div class="row g-2">
                                        <div class="col-md-6">
                                            <input type="radio" class="btn-check" name="payment_method" id="wallet-payment" value="wallet" autocomplete="off" {{ old('payment_method') == 'wallet' ? 'checked' : '' }} onchange="togglePaymentMethod()">
                                            <label class="btn btn-outline-success w-100 py-3" for="wallet-payment">
                                                <i class="bi bi-wallet2 fs-4 d-block mb-1"></i>
                                                <span class="small">Pay from Wallet</span>
                                            </label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="radio" class="btn-check" name="payment_method" id="bank-payment" value="bank" autocomplete="off" {{ old('payment_method') == 'bank' ? 'checked' : '' }} onchange="togglePaymentMethod()">
                                            <label class="btn btn-outline-warning w-100 py-3" for="bank-payment">
                                                <i class="bi bi-bank2 fs-4 d-block mb-1"></i>
                                                <span class="small">Bank Transfer</span>
                                            </label>
                                        </div>
                                    </div>
                                    @error('payment_method') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                                {{-- Wallet Details --}}
                                <div id="walletDetails" style="display: none;">
                                    <div class="alert alert-success border-0">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <i class="bi bi-info-circle-fill me-2"></i>
                                                <strong>Your Wallet Balance:</strong>
                                            </div>
                                            <span class="fw-bold fs-5" style="color: #29a221;">
                                                ₦{{ number_format($contributor->wallet->balance ?? 0, 2) }}
                                            </span>
                                        </div>
                                        @if(($contributor->wallet->balance ?? 0) < old('amount', 100))
                                            <div class="alert alert-warning mt-2 mb-0 small">
                                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                                Insufficient balance. Please <a href="{{ route('wallet.fund') }}" class="alert-link">fund your wallet</a> first.
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                {{-- Bank Details --}}
                                <div id="bankDetails" style="display: none;">
                                    @if($bankDetails)
                                        <div class="alert alert-info border-0" style="background: rgba(41, 162, 33, 0.05);">
                                            <h6 class="fw-bold mb-3" style="color: #29a221;">
                                                <i class="bi bi-university me-2"></i>
                                                Bank Transfer Instructions
                                            </h6>
                                            <div class="row g-3 mb-3">
                                                <div class="col-md-4">
                                                    <small class="text-muted d-block">Bank Name</small>
                                                    <strong>{{ $bankDetails->bank_name }}</strong>
                                                </div>
                                                <div class="col-md-4">
                                                    <small class="text-muted d-block">Account Name</small>
                                                    <strong>{{ $bankDetails->account_name }}</strong>
                                                </div>
                                                <div class="col-md-4">
                                                    <small class="text-muted d-block">Account Number</small>
                                                    <strong class="text-primary">{{ $bankDetails->account_number }}</strong>
                                                    <button type="button" class="btn btn-sm btn-link p-0" onclick="copyToClipboard('{{ $bankDetails->account_number }}')">
                                                        <i class="bi bi-files"></i> Copy
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="alert alert-warning mb-0 small">
                                                <i class="bi bi-clock-history me-2"></i>
                                                After transfer, your donation will be pending admin approval. You'll be notified once confirmed.
                                                Please include your name as reference.
                                            </div>
                                        </div>
                                    @else
                                        <div class="alert alert-warning">
                                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                            Bank details not available. Please contact support.
                                        </div>
                                    @endif
                                </div>

                                {{-- Confirmation Checkbox --}}
                                <div class="form-check mt-3">
                                    <input class="form-check-input" type="checkbox" id="confirmCheck" required>
                                    <label class="form-check-label small text-muted" for="confirmCheck">
                                        I confirm that the information provided is accurate and I understand that donations are non-refundable once approved.
                                    </label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-lg w-100 py-3 rounded-3" id="submitBtn" disabled
                                    style="background: linear-gradient(135deg, #29a221 0%, #ffc107 100%); color: white; border: none; transition: all 0.3s ease;">
                                <i class="bi bi-heart-fill me-2"></i>
                                Confirm Contribution
                            </button>
                        </form>

                        {{-- Trust Indicators --}}
                        <div class="text-center mt-4">
                            <div class="d-flex justify-content-center gap-3">
                                <small class="text-muted">
                                    <i class="bi bi-shield-check me-1" style="color: #29a221;"></i>
                                    Secured Payment
                                </small>
                                <small class="text-muted">
                                    <i class="bi bi-clock-history me-1" style="color: #ffc107;"></i>
                                    24/7 Support
                                </small>
                                <small class="text-muted">
                                    <i class="bi bi-award me-1" style="color: #29a221;"></i>
                                    Verified Projects
                                </small>
                            </div>
                        </div>

                    @else
                        {{-- Registration only (no project) --}}
                        <div class="text-center mb-4">
                            <div class="display-1 text-success mb-3">
                                <i class="bi bi-person-plus-fill"></i>
                            </div>
                            <h4 class="fw-bold mb-2">Become a Contributor</h4>
                            <p class="text-muted">Join our community of supporters making a difference.</p>
                        </div>

                        @if($contributor)
                            <div class="alert alert-success border-0">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                You're already registered as a contributor!
                                <div class="mt-3">
                                    <a href="{{ route('wallet.fund') }}" class="btn btn-success">
                                        <i class="bi bi-wallet2 me-2"></i>Fund Your Wallet
                                    </a>
                                    <a href="{{ route('user.projects.index') }}" class="btn btn-outline-success ms-2">
                                        <i class="bi bi-search me-2"></i>Browse Projects
                                    </a>
                                </div>
                            </div>
                        @else
                            <form action="{{ route('contributor.apply.save') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                {{-- Registration form (same as before) --}}
                                <!-- ... -->
                            </form>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Success Modal for Bank Transfer --}}
<div class="modal fade" id="bankTransferModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    Transfer Instructions
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <p>Please transfer the amount to the following account:</p>
                <div class="bg-light p-3 rounded-3 mb-3">
                    <div class="row mb-2">
                        <div class="col-4"><strong>Bank:</strong></div>
                        <div class="col-8">{{ $bankDetails->bank_name ?? 'N/A' }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><strong>Account:</strong></div>
                        <div class="col-8">{{ $bankDetails->account_name ?? 'N/A' }}</div>
                    </div>
                    <div class="row">
                        <div class="col-4"><strong>Number:</strong></div>
                        <div class="col-8">
                            <strong>{{ $bankDetails->account_number ?? 'N/A' }}</strong>
                            <button class="btn btn-sm btn-link" onclick="copyToClipboard('{{ $bankDetails->account_number ?? '' }}')">
                                Copy
                            </button>
                        </div>
                    </div>
                </div>
                <p class="small text-muted mb-0">
                    <i class="bi bi-info-circle me-2"></i>
                    After transfer, your donation will be pending approval. You'll receive a confirmation email once verified.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" onclick="submitForm()">
                    <i class="bi bi-check-lg me-2"></i>I've Made the Transfer
                </button>
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

    // Toggle payment method details
    function togglePaymentMethod() {
        const walletPayment = document.getElementById('wallet-payment');
        const bankPayment = document.getElementById('bank-payment');
        const walletDetails = document.getElementById('walletDetails');
        const bankDetails = document.getElementById('bankDetails');
        const submitBtn = document.getElementById('submitBtn');

        if (walletPayment.checked) {
            walletDetails.style.display = 'block';
            bankDetails.style.display = 'none';
        } else if (bankPayment.checked) {
            walletDetails.style.display = 'none';
            bankDetails.style.display = 'block';
        } else {
            walletDetails.style.display = 'none';
            bankDetails.style.display = 'none';
        }

        // Update donation amount
        updateDonationAmount();
    }

    // Quick amount selection
    document.querySelectorAll('.quick-amount').forEach(button => {
        button.addEventListener('click', function() {
            const amount = this.dataset.amount;
            document.getElementById('amount').value = amount;
            updateDonationAmount();
        });
    });

    // Confirmation checkbox
    document.getElementById('confirmCheck').addEventListener('change', function() {
        document.getElementById('submitBtn').disabled = !this.checked;
    });

    // Copy to clipboard function
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            alert('Account number copied to clipboard!');
        });
    }

    // Form submission handling for bank transfer
    function submitForm() {
        document.getElementById('contributionForm').submit();
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateDonationAmount();
        togglePaymentMethod();

        // Check if payment method was previously selected
        const selectedMethod = document.querySelector('input[name="payment_method"]:checked');
        if (selectedMethod) {
            togglePaymentMethod();
        }
    });
</script>
@endpush

@push('styles')
<style>
    #donationBadge {
        animation: slideDown 0.5s ease-out;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .btn-check:checked + .btn-outline-success {
        background: #29a221;
        color: white;
        border-color: #29a221;
    }

    .btn-check:checked + .btn-outline-warning {
        background: #ffc107;
        color: #212529;
        border-color: #ffc107;
    }

    .quick-amount {
        transition: all 0.2s ease;
    }

    .quick-amount:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(41, 162, 33, 0.2);
    }

    .contribution-section {
        transition: all 0.3s ease;
    }

    .contribution-section:hover {
        box-shadow: 0 10px 30px rgba(41, 162, 33, 0.1);
    }

    @media (max-width: 768px) {
        .quick-amount {
            font-size: 0.9rem;
        }
    }
</style>
@endpush
