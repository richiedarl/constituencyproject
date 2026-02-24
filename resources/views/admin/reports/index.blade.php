@extends('layouts.admin')

@section('title', 'All Reports')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col">
            <h1 class="h2">All Reports</h1>
            <p class="text-muted">Manage all daily reports submitted by contractors</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white shadow">
                <div class="card-body">
                    <h6>Total Reports</h6>
                    <h2>{{ $stats['total'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white shadow">
                <div class="card-body">
                    <h6>Pending</h6>
                    <h2>{{ $stats['pending'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white shadow">
                <div class="card-body">
                    <h6>Approved</h6>
                    <h2>{{ $stats['approved'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
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
                <a href="{{ route('submitted.reports.index') }}" class="btn btn-outline-primary {{ request()->routeIs('submitted.reports.index') ? 'active' : '' }}">All</a>
                <a href="{{ route('submitted.reports.pending') }}" class="btn btn-outline-warning {{ request()->routeIs('submitted.reports.pending') ? 'active' : '' }}">Pending</a>
                <a href="{{ route('submitted.reports.approved') }}" class="btn btn-outline-success {{ request()->routeIs('submitted.reports.approved') ? 'active' : '' }}">Approved</a>
                <a href="{{ route('submitted.reports.rejected') }}" class="btn btn-outline-danger {{ request()->routeIs('submitted.reports.rejected') ? 'active' : '' }}">Rejected</a>
            </div>
        </div>
    </div>

    <!-- Reports Table -->
    <div class="card shadow">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Reports</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Contractor</th>
                            <th>Project</th>
                            <th>Phase</th>
                            <th>Comment</th>
                            <th>Photos</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reports as $report)
                            <tr>
                                <td>{{ $report->created_at->format('M d, Y') }}</td>
                                <td>{{ $report->contractor->user->name ?? 'N/A' }}</td>
                                <td>{{ $report->phase->project->title ?? 'N/A' }}</td>
                                <td>{{ $report->phase->phase ?? 'N/A' }}</td>
                                <td>{{ Str::limit($report->comment, 30) }}</td>
                                <td>
                                    @if($report->photos->count() > 0)
                                        <span class="badge bg-info">{{ $report->photos->count() }} photos</span>
                                    @else
                                        <span class="badge bg-secondary">No photos</span>
                                    @endif
                                </td>
                                <td>
                                    @if($report->status === 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif($report->status === 'approved')
                                        <span class="badge bg-success">Approved</span>
                                    @elseif($report->status === 'rejected')
                                        <span class="badge bg-danger">Rejected</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('submitted.reports.show', $report) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                                    <p>No reports found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $reports->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
