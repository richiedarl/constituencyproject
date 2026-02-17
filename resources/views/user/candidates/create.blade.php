@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Apply as a Candidate</h4>
                </div>

                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    @if(session('show_login'))
                        <div class="alert alert-info">
                            <strong>Please login with your existing account</strong>
                        </div>
                    @endif

                    <!-- User Type Selection -->
                    <div class="mb-4" id="userTypeSelection">
                        <h5 class="mb-3">Do you have an existing account?</h5>
                        <div class="btn-group w-100" role="group">
                            <button type="button" class="btn btn-outline-primary" id="btnRegistered" onclick="showRegisteredForm()">
                                Yes, I have an account
                            </button>
                            <button type="button" class="btn btn-outline-success" id="btnNew" onclick="showNewForm()">
                                No, create new account
                            </button>
                        </div>
                    </div>

                    <!-- Application Form -->
                    <form method="POST" action="{{ route('user.candidates.store') }}" enctype="multipart/form-data" id="applicationForm">
                        @csrf
                        <input type="hidden" name="user_type" id="user_type" value="">

                        <!-- Login Form (hidden by default) -->
                        <div id="loginSection" style="display: none;" class="mb-4 p-3 border rounded bg-light">
                            <h5 class="mb-3">Login to Your Account</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="login_email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('login_email') is-invalid @enderror"
                                           id="login_email" name="login_email" value="{{ old('login_email') }}">
                                    @error('login_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="login_password" class="form-label">Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control @error('login_password') is-invalid @enderror"
                                           id="login_password" name="login_password">
                                    @error('login_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <hr>
                        </div>

                        <!-- Payment Information -->
                        <div class="alert alert-info mb-4">
                            <h5 class="alert-heading">Application Fee</h5>
                            <p>Please pay ₦5,000 to:</p>
                            <ul class="mb-2">
                                <li><strong>Bank:</strong> First Bank</li>
                                <li><strong>Account Name:</strong> Constituency Project</li>
                                <li><strong>Account Number:</strong> 1234567890</li>
                            </ul>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input @error('paid') is-invalid @enderror"
                                   name="paid" id="paid" {{ old('paid') ? 'checked' : '' }} required>
                            <label class="form-check-label" for="paid">
                                I have paid the application fee <span class="text-danger">*</span>
                            </label>
                            @error('paid')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <!-- Personal Information -->
                        <h5 class="mb-3">Personal Information</h5>

                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password field (only for new users) -->
                        <div id="passwordSection" style="display: none;">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                           id="password" name="password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                                           id="password_confirmation" name="password_confirmation">
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                       id="phone" name="phone" value="{{ old('phone') }}" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
                                <select class="form-control @error('gender') is-invalid @enderror"
                                        id="gender" name="gender" required>
                                    <option value="">Select Gender</option>
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="state" class="form-label">State <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('state') is-invalid @enderror"
                                       id="state" name="state" value="{{ old('state') }}" required>
                                @error('state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="district" class="form-label">District/Constituency <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('district') is-invalid @enderror"
                                       id="district" name="district" value="{{ old('district') }}" required>
                                @error('district')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Position Information -->
                        <h5 class="mb-3 mt-4">Current Position</h5>

                        <div class="mb-3">
                            <label for="position" class="form-label">Position/Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('position') is-invalid @enderror"
                                   id="position" name="position" value="{{ old('position') }}"
                                   placeholder="e.g., Councilor, Chairman, etc." required>
                            @error('position')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="year_from" class="form-label">Year From</label>
                                <input type="number" class="form-control @error('year_from') is-invalid @enderror"
                                       id="year_from" name="year_from" value="{{ old('year_from') }}"
                                       min="1900" max="{{ date('Y') }}" placeholder="YYYY">
                                @error('year_from')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="year_until" class="form-label">Year Until</label>
                                <input type="number" class="form-control @error('year_until') is-invalid @enderror"
                                       id="year_until" name="year_until" value="{{ old('year_until') }}"
                                       min="1900" max="{{ date('Y') }}" placeholder="YYYY (leave blank if current)">
                                @error('year_until')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="bio" class="form-label">Short Bio / Motivation</label>
                            <textarea class="form-control @error('bio') is-invalid @enderror"
                                      id="bio" name="bio" rows="4">{{ old('bio') }}</textarea>
                            <small class="text-muted">Tell us about yourself and why you want to be a candidate (max 1000 characters)</small>
                            @error('bio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="photo" class="form-label">Profile Photo</label>
                            <input type="file" class="form-control @error('photo') is-invalid @enderror"
                                   id="photo" name="photo" accept="image/*">
                            <small class="text-muted">Optional. Max 2MB. JPG, PNG, or GIF</small>
                            @error('photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg" id="submitBtn" disabled>
                                Continue to Project Details
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function showRegisteredForm() {
        document.getElementById('user_type').value = 'registered';
        document.getElementById('loginSection').style.display = 'block';
        document.getElementById('passwordSection').style.display = 'none';
        document.getElementById('btnRegistered').classList.add('active');
        document.getElementById('btnNew').classList.remove('active');

        // Make login fields required
        document.getElementById('login_email').required = true;
        document.getElementById('login_password').required = true;

        // Remove password requirements
        document.getElementById('password').required = false;
        document.getElementById('password_confirmation').required = false;

        // Enable submit button
        document.getElementById('submitBtn').disabled = false;
    }

    function showNewForm() {
        document.getElementById('user_type').value = 'new';
        document.getElementById('loginSection').style.display = 'none';
        document.getElementById('passwordSection').style.display = 'block';
        document.getElementById('btnNew').classList.add('active');
        document.getElementById('btnRegistered').classList.remove('active');

        // Remove login requirements
        document.getElementById('login_email').required = false;
        document.getElementById('login_password').required = false;

        // Make password fields required
        document.getElementById('password').required = true;
        document.getElementById('password_confirmation').required = true;

        // Enable submit button
        document.getElementById('submitBtn').disabled = false;
    }

    // Auto-select based on old input or session
    @if(old('user_type') === 'registered' || session('show_login'))
        showRegisteredForm();
    @elseif(old('user_type') === 'new')
        showNewForm();
    @endif
</script>
@endpush
@endsection
