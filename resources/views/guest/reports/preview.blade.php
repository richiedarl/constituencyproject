@extends('layouts.app')

@section('title', $candidate->name . ' - Report Preview')

@section('content')
<!-- Preview Header -->
<section class="preview-header py-5" style="background: linear-gradient(135deg, #29a221 0%, #ffc107 100%);">
    <div class="container text-center text-white">
        <h1 class="display-4 fw-bold">Candidate Report</h1>
        <p class="lead">{{ $candidate->name }}</p>
    </div>
</section>

<!-- Preview Content -->
<section class="preview-content py-5">
    <div class="container">
        @if($hasAccess)
            <!-- Full Report Access -->
            <div class="text-center mb-4">
                <div class="alert alert-success">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    You have access to the full report.
                </div>
                <a href="{{ route('candidate.report.view', $candidate->slug) }}" class="btn btn-lg px-5 py-3" style="background: linear-gradient(135deg, #29a221 0%, #ffc107 100%); color: white;">
                    View Full Report
                </a>
            </div>
        @else
            <!-- Locked Preview -->
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                        <!-- Blurred Preview -->
                        <div class="position-relative">
                            <div class="preview-blur p-4" style="filter: blur(8px); opacity: 0.3; pointer-events: none;">
                                @include('guest.reports.partials.candidate-info', ['candidate' => $candidate])
                            </div>

                            <!-- Lock Overlay -->
                            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column align-items-center justify-content-center bg-white bg-opacity-90">
                                <div class="text-center p-5" style="max-width: 500px;">
                                    <div class="display-1 text-warning mb-4">
                                        <i class="bi bi-lock-fill"></i>
                                    </div>
                                    <h2 class="fw-bold mb-3">Report Locked</h2>
                                    <p class="text-muted mb-4">
                                        This report requires a license key to access. Request one from the administrator.
                                    </p>
                                    <div class="d-grid gap-3">
                                        <a href="{{ route('candidate.report.key.form', $candidate->slug) }}" class="btn btn-lg py-3" style="background: #29a221; color: white;">
                                            <i class="bi bi-key me-2"></i> Enter License Key
                                        </a>
                                        <a href="{{ route('candidate.report.request.form', $candidate->slug) }}" class="btn btn-lg py-3" style="border: 2px solid #ffc107; color: #212529;">
                                            <i class="bi bi-envelope me-2"></i> Request License Key
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
@endsection
