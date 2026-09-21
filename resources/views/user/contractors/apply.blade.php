@extends('layouts.app')

@section('content')

<div class="container py-5">
<div class="row justify-content-center">
<div class="col-lg-7">

<div class="card shadow border-0">
<div class="card-body p-4">

<h3 class="mb-3">Become A Contractor</h3>

{{-- PROJECT NOTICE --}}
@if($project)
<div class="alert alert-info">
    Applying for project:
    <strong>{{ $project->title }}</strong>

    @php
        $proposedPay = $project->actual_cost ?? ($project->estimated_budget * 0.55);
    @endphp
    <br>
    <small>Proposed pay: ₦{{ number_format($proposedPay, 2) }}</small>
</div>
@endif


{{-- ALREADY APPLIED STATE --}}
@if($alreadyApplied)

<div class="alert alert-success text-center">
<i class="bi bi-check-circle fs-4"></i>
<br>
You have already applied to this project.
</div>

<a href="{{ route('project.public.show', $project->slug) }}"
   class="btn btn-secondary w-100">
Return To Project
</a>

@else

@if(($project ?? false) && $contractor)
    @if(!$contractor->approved || !$contractor->verified)
        <div class="alert alert-warning" role="status">
            <strong>Verification required.</strong> Your profile is saved, but an administrator must verify it before you can submit a project application.
        </div>
        <a href="{{ route('contractor.profile') }}" class="btn btn-outline-primary w-100">Review contractor profile</a>
    @else
        <form method="POST" action="{{ route('contractor.projects.apply', $project) }}">
            @csrf
            <div class="mb-3">
                <label for="cover_letter" class="form-label">Application statement</label>
                <textarea id="cover_letter" name="cover_letter" rows="6" maxlength="2000" class="form-control @error('cover_letter') is-invalid @enderror" placeholder="Summarise your relevant experience and delivery approach.">{{ old('cover_letter') }}</textarea>
                @error('cover_letter')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label for="expected_rate" class="form-label">Proposed contract value (optional)</label>
                <div class="input-group"><span class="input-group-text">₦</span><input id="expected_rate" name="expected_rate" type="number" min="0" step="0.01" value="{{ old('expected_rate') }}" class="form-control @error('expected_rate') is-invalid @enderror"></div>
                @error('expected_rate')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
            <button class="btn btn-warning w-100" type="submit">Submit application</button>
        </form>
    @endif
@else
    <form method="POST"
                     action="{{ route('contractor.store') }}"
                     enctype="multipart/form-data">
    @csrf

    @if($project ?? false)
        <input type="hidden" name="project_id" value="{{ $project->id }}">
    @endif


    {{-- ================= ACCOUNT SECTION ================= --}}
    @guest
    <div class="border rounded p-3 mb-4 bg-light">

        <h6 class="mb-3">Account Information</h6>

        {{-- Account Selection --}}
        <div class="mb-4">
            <label class="fw-bold mb-2">Do you have an account?</label>

            <div class="form-check mb-2">
                <input class="form-check-input"
                       type="radio"
                       name="has_account"
                       id="hasAccountYes"
                       value="yes"
                       {{ old('has_account') == 'yes' ? 'checked' : '' }}
                       required>
                <label class="form-check-label fw-semibold" for="hasAccountYes">
                    Yes, I have an account
                </label>
                <div class="text-muted small ms-4">Login with your existing account</div>
            </div>

            <div class="form-check">
                <input class="form-check-input"
                       type="radio"
                       name="has_account"
                       id="hasAccountNo"
                       value="no"
                       {{ old('has_account') == 'no' ? 'checked' : '' }}
                       required>
                <label class="form-check-label fw-semibold" for="hasAccountNo">
                    No, I need to create a new account
                </label>
                <div class="text-muted small ms-4">Create a new account and contractor profile</div>
            </div>

            @error('has_account')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Login Fields (shown when "Yes" selected) --}}
        <div id="loginFields" style="display: none;">
            <div class="mb-3">
                <label class="fw-bold">Email <span class="text-danger">*</span></label>
                <input type="email"
                       name="email"
                       class="form-control"
                       value="{{ old('email') }}"
                       placeholder="Enter your email">
                <small class="text-muted">We'll check if you have an account</small>
            </div>

            <div class="mb-0">
                <label class="fw-bold">Password <span class="text-danger">*</span></label>
                <input type="password"
                       name="password"
                       class="form-control"
                       placeholder="Enter your password">
            </div>
        </div>

        {{-- Registration Fields (shown when "No" selected) --}}
        <div id="registerFields" style="display: none;">
            <div class="mb-3">
                <label class="fw-bold">Email <span class="text-danger">*</span></label>
                <input type="email"
                       name="email"
                       class="form-control"
                       value="{{ old('email') }}"
                       placeholder="Enter your email">
            </div>

            <div class="mb-3">
                <label class="fw-bold">Password <span class="text-danger">*</span></label>
                <input type="password"
                       name="password"
                       class="form-control"
                       placeholder="Create a password (minimum 6 characters)">
                <small class="text-muted">Minimum 6 characters</small>
            </div>

            <div class="mb-0">
                <label class="fw-bold">Username (Optional)</label>
                <input type="text"
                       name="username"
                       class="form-control"
                       value="{{ old('username') }}"
                       placeholder="Choose a username">
                <small class="text-muted">Will be auto-generated from email if not provided</small>
            </div>
        </div>

    </div>
    @endguest



    {{-- ================= CONTRACTOR PROFILE ================= --}}
    @if(!$contractor)

    <div class="border rounded p-3 mb-4">

        <h6 class="mb-3">Contractor Profile</h6>

        <div class="mb-3">
            <label>Company Name (Optional)</label>
            <input type="text"
                   name="company_name"
                   class="form-control"
                   value="{{ old('company_name') }}">
        </div>

        <div class="mb-3">
            <label>Photo</label>
            <input type="file"
                   name="photo"
                   class="form-control"
                   value="{{ old('photo') }}">
        </div>

        <div class="mb-3">
            <label>District </label>
            <input type="text"
                   name="district"
                   class="form-control"
                   value="{{ old('district') }}">
        </div>

        <div class="mb-3">
            <label>Phone Number</label>
            <input type="text"
                   name="phone"
                   class="form-control"
                   value="{{ old('phone') }}"
                   required>
        </div>

        <div class="mb-3">
            <label>Years of Experience</label>
            <input type="number"
                   name="experience_years"
                   class="form-control"
                   min="0"
                   value="{{ old('experience_years') }}"
                   required>
        </div>

<div class="mb-3">
    <label class="form-label">Skills</label>

    <div class="row">
        @foreach($skills as $skill)
            <div class="col-md-4">
                <div class="form-check">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        name="skills[]"
                        value="{{ $skill->id }}"
                        id="skill_{{ $skill->id }}"
                        {{ in_array($skill->id, old('skills', [])) ? 'checked' : '' }}
                    >

                    <label class="form-check-label" for="skill_{{ $skill->id }}">
                        {{ $skill->name }}
                    </label>
                </div>
            </div>
        @endforeach
    </div>

    @error('skills')
        <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
</div>

        <div class="mb-0">
            <label>Specialization</label>
            <input type="text"
                   name="specialization"
                   class="form-control"
                   placeholder="Construction, Solar, ICT, Logistics..."
                   value="{{ old('specialization') }}"
                   required>
        </div>

    </div>

    @else

        {{-- PROFILE EXISTS --}}
        <div class="alert alert-light border">
            <strong>{{ $contractor->company_name ?? 'No Company Name' }}</strong><br>
            {{ $contractor->occupation }} &bull;
            {{ $contractor->experience_years }} yrs experience
        </div>

    @endif



    {{-- ================= SUBMIT BUTTON ================= --}}
    <button class="btn btn-warning w-100" id="submitBtn">

        @if(($project ?? false) && $contractor)
            Confirm Application
        @elseif($project ?? false)
            Create Profile & Apply
        @else
            Save Contractor Profile
        @endif

    </button>

</form>
@endif



{{-- ================= TOGGLE SCRIPT ================= --}}
@guest
<script>
document.addEventListener('DOMContentLoaded', function() {
    const hasAccountYes = document.getElementById('hasAccountYes');
    const hasAccountNo = document.getElementById('hasAccountNo');
    const loginFields = document.getElementById('loginFields');
    const registerFields = document.getElementById('registerFields');

    // Find all email and password inputs
    const loginEmail = document.querySelector('#loginFields input[name="email"]');
    const loginPassword = document.querySelector('#loginFields input[name="password"]');
    const registerEmail = document.querySelector('#registerFields input[name="email"]');
    const registerPassword = document.querySelector('#registerFields input[name="password"]');
    const registerUsername = document.querySelector('#registerFields input[name="username"]');

    function toggleFields() {
        if (hasAccountYes.checked) {
            // Show login fields, hide register fields
            loginFields.style.display = 'block';
            registerFields.style.display = 'none';

            // Make login fields required
            loginEmail.required = true;
            loginPassword.required = true;

            // Make register fields not required
            registerEmail.required = false;
            registerPassword.required = false;
            registerUsername.required = false;

        } else if (hasAccountNo.checked) {
            // Show register fields, hide login fields
            loginFields.style.display = 'none';
            registerFields.style.display = 'block';

            // Make register fields required
            registerEmail.required = true;
            registerPassword.required = true;

            // Make login fields not required
            loginEmail.required = false;
            loginPassword.required = false;
        }
    }

    hasAccountYes.addEventListener('change', toggleFields);
    hasAccountNo.addEventListener('change', toggleFields);

    // Initial state - if no selection, hide both
    if (!hasAccountYes.checked && !hasAccountNo.checked) {
        loginFields.style.display = 'none';
        registerFields.style.display = 'none';
    } else {
        toggleFields();
    }

    // Form submission validation
    document.querySelector('form').addEventListener('submit', function(e) {
        if (!hasAccountYes.checked && !hasAccountNo.checked) {
            e.preventDefault();
            alert('Please select whether you have an account or need to create one.');
        }
    });
});
</script>
@endguest


@endif

</div>
</div>

</div>
</div>
</div>

@endsection
