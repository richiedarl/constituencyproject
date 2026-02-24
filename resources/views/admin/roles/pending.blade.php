@extends('layouts.admin')

@section('title', 'Pending Role Change Requests')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col">
            <h1 class="h2">Pending Role Change Requests</h1>
            <p class="text-muted">Requests waiting for approval</p>
        </div>
        <div class="col text-end">
            <a href="{{ route('checks.role-requests.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to All
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card bg-warning text-white shadow">
                <div class="card-body">
                    <h6>Pending Requests</h6>
                    <h2>{{ $stats['pending'] }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Requests Table -->
    <div class="card shadow">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Pending Requests</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>User</th>
                            <th>Current Role</th>
                            <th>Requested Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($requests as $request)
                            <tr>
                                <td>{{ $request->created_at->format('M d, Y') }}</td>
                                <td>
                                    <strong>{{ $request->user->name }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $request->user->email }}</small>
                                </td>
                                <td>
                                    @if($request->current_role)
                                        <span class="badge bg-secondary">{{ ucfirst($request->current_role) }}</span>
                                    @else
                                        <span class="badge bg-light text-dark">None</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-primary">{{ ucfirst($request->requested_role) }}</span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-success" onclick="approveRequest({{ $request->id }})">
                                        <i class="fas fa-check"></i> Approve
                                    </button>
                                    <button class="btn btn-sm btn-danger" onclick="showRejectModal({{ $request->id }})">
                                        <i class="fas fa-times"></i> Reject
                                    </button>

                                    <form id="approve-form-{{ $request->id }}" action="{{ route('checks.role-requests.approve', $request) }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                                    <p>No pending requests found.</p>
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
                        <textarea name="admin_notes" class="form-control" rows="4" required></textarea>
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

@push('scripts')
<script>
function approveRequest(id) {
    if (confirm('Are you sure you want to approve this request?')) {
        document.getElementById('approve-form-' + id).submit();
    }
}

function showRejectModal(id) {
    const form = document.getElementById('reject-form');
    form.action = "{{ url('checks/role-requests') }}/" + id + "/reject";
    new bootstrap.Modal(document.getElementById('rejectModal')).show();
}
</script>
@endpush
