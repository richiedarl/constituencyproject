@extends('layouts.admin')

@section('title', 'Pending Reports')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col">
            <h1 class="h2">Pending Reports</h1>
            <p class="text-muted">Reports waiting for approval</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card bg-warning text-white shadow">
                <div class="card-body">
                    <h6>Pending Reports</h6>
                    <h2>{{ $stats['pending'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-info text-white shadow">
                <div class="card-body">
                    <h6>Total</h6>
                    <h2>{{ $stats['total'] }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Reports Table -->
    <div class="card shadow">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Pending Reports</h5>
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
                                    <a href="{{ route('submitted.reports.show', $report) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i> Review
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                                    <p>No pending reports found.</p>
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
