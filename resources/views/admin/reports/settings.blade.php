@extends('layouts.admin')

@section('title', 'License Settings')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col">
            <h1 class="h2">License Settings</h1>
            <p class="text-muted">Configure license key behaviour and pricing</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">License Configuration</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('license.settings.update') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Default Expiry Days</label>
                            <input type="number" name="default_expiry_days" class="form-control"
                                   value="{{ $settings['default_expiry_days'] }}" min="1" max="365" required>
                            <small class="text-muted">Default number of days until a license key expires</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">License Price (₦)</label>
                            <input type="number" name="price" class="form-control"
                                   value="{{ $settings['price'] }}" min="0" step="100" required>
                            <small class="text-muted">Price for license key requests</small>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="require_approval" id="requireApproval"
                                       value="1" {{ $settings['require_approval'] ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="requireApproval">
                                    Require Admin Approval
                                </label>
                                <small class="text-muted d-block">All license key requests need admin approval</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="allow_multiple_uses" id="allowMultipleUses"
                                       value="1" {{ $settings['allow_multiple_uses'] ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="allowMultipleUses">
                                    Allow Multiple Uses
                                </label>
                                <small class="text-muted d-block">Allow the same key to be used multiple times</small>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Save Settings
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Quick Info</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted d-block">Total Keys Generated</label>
                        <span class="h3">{{ \App\Models\ReportKey::count() }}</span>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted d-block">Active Keys</label>
                        <span class="h3">{{ \App\Models\ReportKey::where('is_used', false)->where('expires_at', '>', now())->count() }}</span>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted d-block">Pending Requests</label>
                        <span class="h3">{{ \App\Models\Contact::where('type', 'license_request')->where('status', 'pending')->count() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
