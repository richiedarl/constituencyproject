@extends('layouts.admin')

@section('title', 'Approved Reports')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col">
            <h1 class="h2">Approved Reports</h1>
            <p class="text-muted">Reports that have been approved</p>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Approved Reports</h5>
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
                            <th>Approved By</th>
                            <th>Approved At</th>
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
                                <td>{{ $report->approver->name ?? 'N/A' }}</td>
                                <td>{{ $report->approved_at ? $report->approved_at->format('M d, Y H:i') : 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="fas fa-info-circle fa-3x text-muted mb-3"></i>
                                    <p>No approved reports found.</p>
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
