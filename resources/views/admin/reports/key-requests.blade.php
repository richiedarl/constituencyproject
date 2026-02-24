@extends('layouts.admin')

@section('title', 'License Key Requests')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col">
            <h1 class="h2">License Key Requests</h1>
            <p class="text-muted">Manage requests from users wanting access to candidate reports</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-warning text-white shadow">
                <div class="card-body">
                    <h6>Pending</h6>
                    <h2>{{ $stats['pending'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white shadow">
                <div class="card-body">
                    <h6>Approved</h6>
                    <h2>{{ $stats['approved'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-danger text-white shadow">
                <div class="card-body">
                    <h6>Rejected</h6>
                    <h2>{{ $stats['rejected'] }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Requests Table -->
    <div class="card shadow">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">All Requests</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Contact</th>
                            <th>Candidate</th>
                            <th>Message</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($requests as $request)
                            <tr>
                                <td>{{ $request->created_at->format('M d, Y') }}</td>
                                <td>
                                    <strong>{{ $request->name }}</strong>
                                </td>
                                <td>
                                    <div>{{ $request->email }}</div>
                                    <small class="text-muted">{{ $request->phone }}</small>
                                </td>
                                <td>
                                    <a href="{{ route('candidate.report', $request->candidate->slug ?? '#') }}">
                                        {{ $request->candidate->name ?? 'N/A' }}
                                    </a>
                                </td>
                                <td>
                                    <span class="text-muted" title="{{ $request->message }}">
                                        {{ Str::limit($request->message, 30) }}
                                    </span>
                                </td>
                                <td>
                                    @if($request->status === 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif($request->status === 'approved')
                                        <span class="badge bg-success">Approved</span>
                                    @else
                                        <span class="badge bg-danger">Rejected</span>
                                    @endif
                                </td>
                                <td>
                                    @if($request->status === 'pending')
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-success" onclick="approveRequest({{ $request->id }})">
                                                <i class="fas fa-check"></i> Approve
                                            </button>
                                            <button class="btn btn-sm btn-danger" onclick="showRejectModal({{ $request->id }})">
                                                <i class="fas fa-times"></i> Reject
                                            </button>
                                        </div>

                                        <form id="approve-form-{{ $request->id }}"
                                              action="{{ route('keyrequests.approve', $request->id) }}"
                                              method="POST"
                                              style="display: none;">
                                            @csrf
                                        </form>
                                    @else
                                        <button class="btn btn-sm btn-outline-secondary" disabled>
                                            {{ ucfirst($request->status) }}
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <p>No requests found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $requests->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="reject-form" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Reject Request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Reason for Rejection</label>
                        <textarea name="rejection_reason" class="form-control" rows="4" required
                                  placeholder="Please provide a reason for rejecting this request..."></textarea>
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
    if (confirm('Are you sure you want to approve this request? A license key will be generated.')) {
        document.getElementById('approve-form-' + id).submit();
    }
}

function showRejectModal(id) {
    const form = document.getElementById('reject-form');
    form.action = "{{ url('reports/keyrequests') }}/" + id + "/reject";
    new bootstrap.Modal(document.getElementById('rejectModal')).show();
}
</script>
@endpush
