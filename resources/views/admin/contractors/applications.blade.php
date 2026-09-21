@extends('layouts.admin')

@section('title', 'Contractor Applications')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4"><div><h1 class="h3 mb-1">Contractor Applications</h1><p class="text-muted mb-0">{{ $contractor->user?->name }}</p></div><a href="{{ route('contractors.show', $contractor) }}" class="btn btn-outline-secondary">Back</a></div>
    <div class="card shadow-sm"><div class="table-responsive"><table class="table mb-0"><thead><tr><th>Project</th><th>Status</th><th>Applied</th></tr></thead><tbody>@forelse($applications as $application)<tr><td>{{ $application->project?->title ?? 'Deleted project' }}</td><td>{{ ucfirst($application->status) }}</td><td>{{ $application->created_at->format('d M Y') }}</td></tr>@empty<tr><td colspan="3" class="text-center py-4">No applications found.</td></tr>@endforelse</tbody></table></div></div>
</div>
@endsection
