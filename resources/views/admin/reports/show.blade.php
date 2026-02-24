@extends('layouts.admin')

@section('title', 'Report Details')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col">
            <h1 class="h2">Report Details</h1>
        </div>
        <div class="col text-end">
            <a href="{{ route('submitted.reports.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Reports
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <!-- Report Card -->
            <div class="card shadow mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Report Information</h5>
                    <span class="badge px-3 py-2
                        @if($update->status === 'pending') bg-warning text-dark
                        @elseif($update->status === 'approved') bg-success
                        @else bg-danger @endif">
                        {{ ucfirst($update->status) }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p><strong>Contractor:</strong> {{ $update->contractor->user->name ?? 'N/A' }}</p>
                            <p><strong>Project:</strong> {{ $update->phase->project->title ?? 'N/A' }}</p>
                            <p><strong>Phase:</strong> {{ $update->phase->phase ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Report Date:</strong> {{ $update->report_date ? $update->report_date->format('M d, Y') : 'N/A' }}</p>
                            <p><strong>Submitted:</strong> {{ $update->created_at->format('M d, Y h:i A') }}</p>
                            @if($update->approved_at)
                                <p><strong>Approved:</strong> {{ $update->approved_at->format('M d, Y h:i A') }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 class="fw-bold">Comment</h6>
                        <div class="p-3 rounded-3 bg-light">
                            {{ $update->comment }}
                        </div>
                    </div>

@if($update->photos->count() > 0)
    <div>
        <h6 class="fw-bold mb-3">Photos ({{ $update->photos->count() }})</h6>
        <div class="row g-3">
            @foreach($update->photos as $photo)
                <div class="col-md-3 col-6">
                    <a href="{{ asset('storage/'.$photo->file_path) }}" target="_blank">
                        <img src="{{ asset('storage/'.$photo->file_path) }}"
                             class="img-fluid rounded-3 shadow-sm"
                             style="height: 120px; width: 100%; object-fit: cover;">
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Actions Card -->
            <div class="card shadow mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Actions</h5>
                </div>
                <div class="card-body">
                    @if($update->status === 'pending')
                        <form action="{{ route('submitted.reports.approve', $update) }}" method="POST" class="mb-3">
                            @csrf
                            <button type="submit" class="btn btn-success w-100 py-2" onclick="return confirm('Approve this report?')">
                                <i class="fas fa-check me-2"></i>Approve Report
                            </button>
                        </form>

                        <button type="button" class="btn btn-danger w-100 py-2" data-bs-toggle="modal" data-bs-target="#rejectModal">
                            <i class="fas fa-times me-2"></i>Reject Report
                        </button>
                    @else
                        <div class="alert alert-info">
                            This report has been {{ $update->status }}.
                        </div>
                        @if($update->status === 'rejected' && $update->admin_notes)
                            <div class="mt-3 p-3 bg-light rounded-3">
                                <strong>Rejection Reason:</strong>
                                <p class="mb-0 mt-2">{{ $update->admin_notes }}</p>
                            </div>
                        @endif
                    @endif
                </div>
            </div>

            <!-- Contractor Info -->
            <div class="card shadow">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Contractor Information</h5>
                </div>
                <div class="card-body">
                    <p><strong>Name:</strong> {{ $update->contractor->user->name ?? 'N/A' }}</p>
                    <p><strong>Email:</strong> {{ $update->contractor->user->email ?? 'N/A' }}</p>
                    @if($update->contractor->company_name)
                        <p><strong>Company:</strong> {{ $update->contractor->company_name }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('submitted.reports.reject', $update) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Reject Report</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Reason for Rejection</label>
                        <textarea name="rejection_reason" class="form-control" rows="4" required
                                  placeholder="Please provide a reason for rejecting this report..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject Report</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
