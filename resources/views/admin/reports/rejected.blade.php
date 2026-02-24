@extends('layouts.admin')

@section('title', 'Rejected Reports')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col">
            <h1 class="h2">Rejected Reports</h1>
            <p class="text-muted">Reports that have been rejected</p>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Rejected Reports</h5>
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
                            <th>Rejection Reason</th>
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
                                <td>{{ $report->admin_notes ?? 'No reason provided' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                                    <p>No rejected reports found.</p>
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
