@extends('layouts.admin')

@section('title', 'Access Logs')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col">
            <h1 class="h2">License Access Logs</h1>
            <p class="text-muted">Track when and how license keys are being used</p>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Access History</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Date & Time</th>
                            <th>License Key</th>
                            <th>Candidate</th>
                            <th>IP Address</th>
                            <th>User Agent</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                            <tr>
                                <td>{{ $log->used_at->format('M d, Y H:i:s') }}</td>
                                <td>
                                    <code class="bg-light p-1 rounded">{{ $log->key }}</code>
                                </td>
                                <td>{{ $log->candidate->name ?? 'N/A' }}</td>
                                <td>
                                    <small>{{ $log->used_by_ip }}</small>
                                </td>
                                <td>
                                    <small class="text-muted" title="{{ $log->used_by_user_agent }}">
                                        {{ Str::limit($log->used_by_user_agent, 30) }}
                                    </small>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <i class="fas fa-history fa-3x text-muted mb-3"></i>
                                    <p>No access logs found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $logs->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
