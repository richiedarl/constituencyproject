@extends('layouts.admin')

@section('title', 'Approved Role Change Requests')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col">
            <h1 class="h2">Approved Role Change Requests</h1>
            <p class="text-muted">Requests that have been approved</p>
        </div>
        <div class="col text-end">
            <a href="{{ route('checks.role-requests.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to All
            </a>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Approved Requests</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>User</th>
                            <th>Previous Role</th>
                            <th>New Role</th>
                            <th>Approved By</th>
                            <th>Approved At</th>
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
                                    <span class="badge bg-success">{{ ucfirst($request->requested_role) }}</span>
                                </td>
                                <td>{{ $request->approver->name ?? 'N/A' }}</td>
                                <td>{{ $request->approved_at ? $request->approved_at->format('M d, Y H:i') : 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="fas fa-info-circle fa-3x text-muted mb-3"></i>
                                    <p>No approved requests found.</p>
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
