@extends('layouts.admin')

@section('title', 'Role Change Requests')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col">
            <h1 class="h2">Role Change Requests</h1>
            <p class="text-muted">Manage all user role change requests</p>
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

    <!-- Filter Tabs -->
    <div class="row mb-4">
        <div class="col">
            <div class="btn-group">
                <a href="{{ route('checks.role-requests.index') }}" class="btn btn-outline-primary {{ request()->routeIs('checks.role-requests.index') ? 'active' : '' }}">All</a>
                <a href="{{ route('checks.role-requests.pending') }}" class="btn btn-outline-warning {{ request()->routeIs('checks.role-requests.pending') ? 'active' : '' }}">Pending</a>
                <a href="{{ route('checks.role-requests.approved') }}" class="btn btn-outline-success {{ request()->routeIs('checks.role-requests.approved') ? 'active' : '' }}">Approved</a>
                <a href="{{ route('checks.role-requests.rejected') }}" class="btn btn-outline-danger {{ request()->routeIs('checks.role-requests.rejected') ? 'active' : '' }}">Rejected</a>
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
                            <th>User</th>
                            <th>Current Role</th>
                            <th>Requested Role</th>
                            <th>Status</th>
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
                                    @if($request->status === 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif($request->status === 'approved')
                                        <span class="badge bg-success">Approved</span>
                                    @else
                                        <span class="badge bg-danger">Rejected</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#viewRequestModal{{ $request->id }}">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>

                            <!-- View Modal -->
                            <div class="modal fade" id="viewRequestModal{{ $request->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Request Details</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>User:</strong> {{ $request->user->name }}</p>
                                            <p><strong>Email:</strong> {{ $request->user->email }}</p>
                                            <p><strong>Current Role:</strong> {{ $request->current_role ?? 'None' }}</p>
                                            <p><strong>Requested Role:</strong> {{ $request->requested_role }}</p>
                                            <p><strong>Submitted:</strong> {{ $request->created_at->format('M d, Y h:i A') }}</p>
                                            @if($request->status !== 'pending')
                                                <p><strong>Processed:</strong> {{ $request->approved_at?->format('M d, Y h:i A') }}</p>
                                                @if($request->admin_notes)
                                                    <p><strong>Admin Notes:</strong> {{ $request->admin_notes }}</p>
                                                @endif
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            @if($request->status === 'pending')
                                                <form action="{{ route('checks.role-requests.approve', $request) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success" onclick="return confirm('Approve this request?')">
                                                        Approve
                                                    </button>
                                                </form>
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $request->id }}">
                                                    Reject
                                                </button>
                                            @endif
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Reject Modal -->
                            <div class="modal fade" id="rejectModal{{ $request->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('checks.role-requests.reject', $request) }}" method="POST">
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
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
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
@endsection
