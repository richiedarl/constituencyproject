@extends('layouts.admin')

@section('title', 'Pending Withdrawal Requests')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col">
            <h1 class="h2">Pending Withdrawal Requests</h1>
            <p class="text-muted">Process withdrawal requests from contractors</p>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card bg-primary text-white shadow">
                <div class="card-body">
                    <h6 class="text-white-50">Total Pending</h6>
                    <h2 class="text-white mb-0">{{ $stats['total_pending'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card bg-success text-white shadow">
                <div class="card-body">
                    <h6 class="text-white-50">Total Amount</h6>
                    <h2 class="text-white mb-0">₦{{ number_format($stats['total_amount']) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card bg-info text-white shadow">
                <div class="card-body">
                    <h6 class="text-white-50">Average Amount</h6>
                    <h2 class="text-white mb-0">₦{{ number_format($stats['avg_amount']) }}</h2>
                </div>
            </div>
        </div>
    </div>

    {{-- Withdrawals Table --}}
    <div class="card shadow">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Withdrawal Requests</h5>
        </div>
        <div class="card-body">
            @if($withdrawals->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>User</th>
                                <th>Amount</th>
                                <th>Bank Details</th>
                                <th>Reference</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($withdrawals as $withdrawal)
                                @php
                                    $metadata = is_string($withdrawal->metadata)
                                        ? json_decode($withdrawal->metadata, true)
                                        : $withdrawal->metadata;
                                @endphp
                                <tr>
                                    <td>{{ $withdrawal->created_at->format('M d, Y H:i') }}</td>
                                    <td>
                                        <strong>{{ $withdrawal->wallet->user->name }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $withdrawal->wallet->user->email }}</small>
                                    </td>
                                    <td>
                                        <strong class="text-danger">₦{{ number_format($withdrawal->amount) }}</strong>
                                    </td>
                                    <td>
                                        @if($metadata)
                                            <small>
                                                <strong>{{ $metadata['bank_name'] ?? 'N/A' }}</strong><br>
                                                {{ $metadata['account_name'] ?? 'N/A' }}<br>
                                                {{ $metadata['account_number'] ?? 'N/A' }}
                                            </small>
                                        @else
                                            <span class="text-muted">No details</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $withdrawal->reference }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button"
                                                    class="btn btn-success btn-sm"
                                                    onclick="approveWithdrawal({{ $withdrawal->id }})">
                                                <i class="fas fa-check"></i> Approve
                                            </button>
                                            <button type="button"
                                                    class="btn btn-danger btn-sm"
                                                    onclick="showRejectModal({{ $withdrawal->id }})">
                                                <i class="fas fa-times"></i> Reject
                                            </button>
                                        </div>

                                        <form id="approve-withdrawal-{{ $withdrawal->id }}"
                                            action="{{ route('approveWithdrawal') }}"
                                            method="POST"
                                            style="display: none;">
                                            @csrf
                                            <input type="hidden" name="transaction_id" value="{{ $withdrawal->id }}">
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
                    <h5>No Pending Withdrawals</h5>
                    <p class="text-muted">All withdrawal requests have been processed.</p>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Reject Modal --}}
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="reject-form" method="POST" action="{{ route('rejectWithdrawal') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Reject Withdrawal Request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="transaction_id" id="reject-transaction-id">
                    <div class="mb-3">
                        <label class="form-label">Reason for Rejection</label>
                        <textarea name="admin_notes" class="form-control" rows="4" required
                                  placeholder="Please provide a detailed reason for rejection..."></textarea>
                    </div>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        The funds will be automatically refunded to the user's wallet.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject & Refund</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function approveWithdrawal(id) {
    if (confirm('Are you sure you want to approve this withdrawal request?')) {
        document.getElementById('approve-withdrawal-' + id).submit();
    }
}

function showRejectModal(id) {
    document.getElementById('reject-transaction-id').value = id;
    new bootstrap.Modal(document.getElementById('rejectModal')).show();
}
</script>
@endpush
