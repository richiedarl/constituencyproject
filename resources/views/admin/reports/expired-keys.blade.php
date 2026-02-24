@extends('layouts.admin')

@section('title', 'Expired & Used Keys')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col">
            <h1 class="h2">Expired & Used Keys</h1>
            <p class="text-muted">View all expired and used license keys</p>
        </div>
        <div class="col text-end">
            <a href="{{ route('allKeys') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to All Keys
            </a>
        </div>
    </div>

    <!-- Keys Table -->
    <div class="card shadow">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Expired & Used Keys</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>License Key</th>
                            <th>Candidate</th>
                            <th>Created</th>
                            <th>Expired</th>
                            <th>Status</th>
                            <th>Used By</th>
                            <th>Used At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($keys as $key)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <code class="bg-light p-2 rounded">{{ $key->key }}</code>
                                </td>
                                <td>{{ $key->candidate->name ?? 'N/A' }}</td>
                                <td>{{ $key->created_at->format('M d, Y') }}</td>
                                <td>{{ $key->expires_at->format('M d, Y') }}</td>
                                <td>
                                    @if($key->is_used)
                                        <span class="badge bg-secondary">Used</span>
                                    @else
                                        <span class="badge bg-danger">Expired</span>
                                    @endif
                                </td>
                                <td>
                                    @if($key->used_by_ip)
                                        <small>{{ $key->used_by_ip }}</small>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($key->used_at)
                                        {{ $key->used_at->format('M d, Y H:i') }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                                    <p>No expired or used keys found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $keys->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
