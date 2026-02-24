@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Contractor Details</h4>
        <a href="{{ route('contractors.index') }}" class="btn btn-light">← Back</a>
    </div>

    {{-- Contractor Info --}}
    <div class="card mb-4">
        <div class="card-body d-flex align-items-center">
            <div class="me-4">
                <img src="{{ $contractor->photo ? asset('storage/' . $contractor->photo) : asset('images/default-avatar.png') }}"
                     alt="{{ $contractor->name ?? $contractor->user->name }}"
                     class="rounded-circle"
                     width="120" height="120">
            </div>
            <div>
                <h5>{{ $contractor->user->name ?? $contractor->name }}</h5>
                <p class="mb-1"><strong>Email:</strong> {{ $contractor->email }}</p>
                <p class="mb-1"><strong>Phone:</strong> {{ $contractor->phone }}</p>
                <p class="mb-1"><strong>Occupation:</strong> {{ $contractor->occupation ?? '—' }}</p>
                <p class="mb-1"><strong>Status:</strong>
                    @if($contractor->approved)
                        <span class="badge bg-success">Approved</span>
                    @else
                        <span class="badge bg-warning">Pending</span>
                    @endif
                </p>
                @if($contractor->bio)
                    <p><strong>Bio:</strong> {{ $contractor->bio }}</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Approved Projects --}}
    <div class="card mb-4">
        <div class="card-header">
            <h6 class="mb-0">Approved Projects ({{ $contractor->approvedProjectsCount }})</h6>
        </div>
        <div class="list-group list-group-flush">
            @forelse($contractor->projects as $project)
                @if($project->pivot->status === \App\Models\Application::STATUS_APPROVED)
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <span>{{ $project->title }}</span>
                        <small class="text-muted">{{ $project->full_location ?? '' }}</small>
                    </div>
                @endif
            @empty
                <div class="list-group-item text-muted text-center">
                    No approved projects yet.
                </div>
            @endforelse
        </div>
    </div>

    {{-- Assign Project Button --}}
    <div class="text-end">
    <a href="{{ route('professionals.available-projects', $contractor) }}"
    class="btn btn-success">
        <i class="fas fa-link me-2"></i>Assign project
    </a>

    </div>

</div>
@endsection
