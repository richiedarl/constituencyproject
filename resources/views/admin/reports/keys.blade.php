@extends('layouts.admin')

@section('title', 'License Keys')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col">
            <h1 class="h2">License Keys</h1>
            <p class="text-muted">Manage all license keys for candidate reports</p>
        </div>
        <div class="col text-end">
            <a href="{{ route('generatekey') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-2"></i>Generate New Key
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white shadow">
                <div class="card-body">
                    <h6>Total Keys</h6>
                    <h2>{{ $keys->total() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white shadow">
                <div class="card-body">
                    <h6>Active Keys</h6>
                    <h2>{{ \App\Models\ReportKey::where('is_used', false)->where('expires_at', '>', now())->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white shadow">
                <div class="card-body">
                    <h6>Used Keys</h6>
                    <h2>{{ \App\Models\ReportKey::where('is_used', true)->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white shadow">
                <div class="card-body">
                    <h6>Expired</h6>
                    <h2>{{ \App\Models\ReportKey::where('expires_at', '<', now())->where('is_used', false)->count() }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Keys Table -->
    <div class="card shadow">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">All License Keys</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>License Key</th>
                            <th>Candidate</th>
                            <th>Created By</th>
                            <th>Expires</th>
                            <th>Status</th>
                            <th>Used At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($keys as $key)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <code class="bg-light p-2 rounded">{{ $key->key }}</code>
                                </td>
                                <td>
                                    <a href="{{ route('candidate.report', $key->candidate->slug ?? '#') }}">
                                        {{ $key->candidate->name ?? 'N/A' }}
                                    </a>
                                </td>
                                <td>{{ $key->creator->name ?? 'System' }}</td>
                                <td>
                                    @if($key->expires_at > now())
                                        <span class="text-success">{{ $key->expires_at->format('M d, Y') }}</span>
                                    @else
                                        <span class="text-danger">{{ $key->expires_at->format('M d, Y') }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($key->is_used)
                                        <span class="badge bg-secondary">Used</span>
                                    @elseif($key->expires_at < now())
                                        <span class="badge bg-danger">Expired</span>
                                    @else
                                        <span class="badge bg-success">Active</span>
                                    @endif
                                </td>
                                <td>
                                    @if($key->used_at)
                                        {{ $key->used_at->format('M d, Y') }}
                                    @else
                                        <span class="text-muted">Not used</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary copy-key" data-key="{{ $key->key }}">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <i class="fas fa-key fa-3x text-muted mb-3"></i>
                                    <p>No license keys found.</p>
                                    <a href="{{ route('generatekey') }}" class="btn btn-primary">
                                        Generate First Key
                                    </a>
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

@push('scripts')
<script>
    document.querySelectorAll('.copy-key').forEach(button => {
        button.addEventListener('click', function() {
            const key = this.dataset.key;
            navigator.clipboard.writeText(key).then(() => {
                alert('License key copied to clipboard!');
            });
        });
    });
</script>
@endpush
