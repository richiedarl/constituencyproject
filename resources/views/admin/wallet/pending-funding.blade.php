@extends('layouts.admin')

@section('title', 'Pending Funding Requests')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col">
            <h1 class="h2">Pending Funding Requests</h1>
            <p class="text-muted">Review and approve wallet funding requests from contributors</p>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card bg-primary text-white shadow">
                <div class="card-body">
                    <h6 class="text-white-50">Total Pending</h6>
                    <h2 class="text-white mb-0">{{ $stats['total_pending'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-success text-white shadow">
                <div class="card-body">
                    <h6 class="text-white-50">Total Amount</h6>
                    <h2 class="text-white mb-0">₦{{ number_format($stats['total_amount']) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-info text-white shadow">
                <div class="card-body">
                    <h6 class="text-white-50">Average Amount</h6>
                    <h2 class="text-white mb-0">₦{{ number_format($stats['avg_amount']) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-secondary text-white shadow">
                <div class="card-body">
                    <h6 class="text-white-50">Payment Methods</h6>
                    <div class="small">
                        <div>Bank: {{ $stats['bank_transfers'] }}</div>
                        <div>Card: {{ $stats['card_payments'] }}</div>
                        <div>USSD: {{ $stats['ussd_payments'] }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Requests Table --}}
    <div class="card shadow">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Funding Requests</h5>
        </div>
        <div class="card-body">
            @if($requests->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>User</th>
                                <th>Amount</th>
                                <th>Payment Method</th>
                                <th>Reference</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($requests as $fundingRequest)
                                <tr>
                                    <td>{{ $fundingRequest->created_at->format('M d, Y H:i') }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <strong>{{ $fundingRequest->user->name }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $fundingRequest->user->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <strong class="text-success">₦{{ number_format($fundingRequest->amount) }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">
                                            {{ str_replace('_', ' ', ucfirst($fundingRequest->payment_method)) }}
                                        </span>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $fundingRequest->reference }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button"
                                                    class="btn btn-success btn-sm"
                                                    onclick="approveRequest({{ $fundingRequest->id }})">
                                                <i class="fas fa-check"></i> Approve
                                            </button>
                                            <button type="button"
                                                    class="btn btn-danger btn-sm"
                                                    onclick="showRejectModal({{ $fundingRequest->id }})">
                                                <i class="fas fa-times"></i> Reject
                                            </button>
                                        </div>

                                        {{-- Approve Form --}}
                                        <form id="approve-form-{{ $fundingRequest->id }}"
                                              action="{{ route('approveFundingRequest') }}"
                                              method="POST"
                                              style="display: none;">
                                            @csrf
                                            <input type="hidden" name="request_id" value="{{ $fundingRequest->id }}">
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-check-circle fa-4x text-success mb-3"></i>
                    <h5>No Pending Requests</h5>
                    <p class="text-muted">All funding requests have been processed.</p>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Reject Modal --}}
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="reject-form" method="POST" action="{{ route('rejectFundingRequest') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Reject Funding Request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="request_id" id="reject-request-id">
                    <div class="mb-3">
                        <label class="form-label">Reason for Rejection</label>
                        <textarea name="admin_notes" class="form-control" rows="4" required
                                  placeholder="Please provide a detailed reason for rejection..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject Request</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function approveRequest(id) {
    if (confirm('Are you sure you want to approve this funding request?')) {
        document.getElementById('approve-form-' + id).submit();
    }
}

function showRejectModal(id) {
    document.getElementById('reject-request-id').value = id;
    new bootstrap.Modal(document.getElementById('rejectModal')).show();
}
</script>
@endpush
