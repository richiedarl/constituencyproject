@extends('layouts.admin')

@section('title', 'Generate License Key')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col">
            <h1 class="h2">Generate License Key</h1>
            <p class="text-muted">Create a new license key for accessing candidate reports</p>
        </div>
        <div class="col text-end">
            <a href="{{ route('allKeys') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Keys
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Create New License Key</h5>
                </div>
                <div class="card-body">
<form action="{{ route('generatekey.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label class="form-label fw-semibold">Select Candidate</label>
        <select name="candidate_id" class="form-select @error('candidate_id') is-invalid @enderror" required>
            <option value="">Choose a candidate...</option>
            @foreach($candidates as $candidate)
                <option value="{{ $candidate->id }}" {{ old('candidate_id') == $candidate->id ? 'selected' : '' }}>
                    {{ $candidate->name }} ({{ $candidate->projects_count ?? $candidate->projects->count() }} projects)
                </option>
            @endforeach
        </select>
        @error('candidate_id')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label fw-semibold">Expiry Days</label>
        <input type="number"
               name="expires_days"
               class="form-control @error('expires_days') is-invalid @enderror"
               value="{{ old('expires_days', 30) }}"
               min="1"
               max="365"
               step="1"
               required>
        @error('expires_days')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
        <small class="text-muted">Number of days until the key expires</small>
    </div>

    <div class="alert alert-info">
        <i class="fas fa-info-circle me-2"></i>
        A 16-character license key will be automatically generated.
    </div>

    <button type="submit" class="btn btn-primary">
        <i class="fas fa-key me-2"></i>Generate License Key
    </button>
</form>
                </div>
            </div>
        </div>

<div class="col-md-4">
    <div class="card shadow">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Quick Stats</h5>
        </div>
        <div class="card-body">
            <div class="mb-3">
    <label class="text-muted d-block">Pending Requests</label>
    <span class="h3">
        @php
            use App\Models\Contact;
            $pendingCount = Contact::where('type', 'license_request')
                ->where('status', 'pending')
                ->count();
        @endphp
        {{ $pendingCount }}
    </span>
</div>
            <div class="mb-3">
                <label class="text-muted d-block">Active Keys</label>
                <span class="h3">{{ \App\Models\ReportKey::where('is_used', false)->where('expires_at', '>', now())->count() }}</span>
            </div>
            <div class="mb-3">
                <label class="text-muted d-block">Pending Requests</label>
                <span class="h3">
                    @if(class_exists('App\Models\Contact'))
                        {{ \App\Models\Contact::where('type', 'license_request')->where('status', 'pending')->count() }}
                    @else
                        0
                    @endif
                </span>
            </div>
        </div>
    </div>
</div>
    </div>
</div>
@endsection
