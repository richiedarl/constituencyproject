@extends('layouts.admin')

@section('title', 'Application Details')

@section('content')
<div class="container-fluid py-4">

    <div class="mb-4">
        <a href="{{ route('submissions.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i>
            Back to Applications
        </a>
    </div>

    <div class="card shadow-sm border-0">

        <div class="card-header bg-white border-0">
            <h4 class="fw-bold mb-0">
                Application #{{ $application->id }}
            </h4>
        </div>

        <div class="card-body">

            {{-- Project Info --}}

            <div class="mb-4">
                <h5 class="fw-semibold">Project</h5>
                <p class="mb-1">
                    <strong>Title:</strong>
                    {{ $application->project->title ?? 'N/A' }}
                </p>
                <p class="mb-0">
                    <strong>Estimated Budget:</strong>
                    ₦{{ number_format($application->estimated_budget ?? 0) }}
                </p>
            </div>

            <hr>
            <div class="mt-3 d-flex gap-2">
    @if($application->project)
        <a href="{{ route('admin.projects.show', $application->project->id) }}"
           class="btn btn-outline-info btn-sm">
            <i class="fas fa-eye me-1"></i>
            View Project
        </a>

        <a href="{{ route('admin.projects.edit', $application->project->id) }}"
           class="btn btn-outline-primary btn-sm">
            <i class="fas fa-edit me-1"></i>
            Edit Project
        </a>
    @endif
</div>

@php
    $candidate = $application->candidate;
    $contractor = $application->contractor;
    $contributor = $application->contributor;
@endphp

@if($candidate)

    <p><strong>Role:</strong> <span class="badge bg-primary">Candidate</span></p>
    <p><strong>Name:</strong> {{ $candidate->user->name }}</p>
    <p><strong>Email:</strong> {{ $candidate->user->email }}</p>
    <p><strong>Phone:</strong> {{ $candidate->phone }}</p>
    <p><strong>State:</strong> {{ $candidate->state }}</p>
    <p><strong>District:</strong> {{ $candidate->district }}</p>
    <p><strong>Gender:</strong> {{ ucfirst($candidate->gender) }}</p>
    <p><strong>Bio:</strong> {{ $candidate->bio }}</p>

    @if($candidate->positions->count())
        <hr>
        <h6>Political Positions</h6>
        @foreach($candidate->positions as $position)
            <p>
                {{ $position->position }}
                ({{ $position->year_from }} - {{ $position->year_until ?? 'Present' }})
            </p>
        @endforeach
    @endif

@endif


@if($contractor)

    <p><strong>Role:</strong> <span class="badge bg-success">Contractor</span></p>
    <p><strong>Name:</strong> {{ $contractor->user->name }}</p>
    <p><strong>Email:</strong> {{ $contractor->user->email }}</p>

    @if($contractor->skills->count())
        <p><strong>Skills:</strong></p>
        @foreach($contractor->skills as $skill)
            <span class="badge bg-secondary">{{ $skill->name }}</span>
        @endforeach
    @endif

@endif


@if($contributor)

    <p><strong>Role:</strong> <span class="badge bg-info">Contributor</span></p>
    <p><strong>Name:</strong> {{ $contributor->user->name }}</p>
    <p><strong>Email:</strong> {{ $contributor->user->email }}</p>

@endif


            <hr>

            {{-- Payment Info --}}
            <div class="mb-4">
                <h5 class="fw-semibold">Payment Information</h5>

                <p>
                    <strong>Status:</strong>

                    @if($application->paid)
                        <span class="badge bg-success">Paid</span>
                    @else
                        <span class="badge bg-danger">Not Paid</span>
                    @endif
                </p>

                <p>
                    <strong>Date Paid:</strong>
                    {{ $application->paid_at?->format('M d, Y H:i') ?? 'N/A' }}
                </p>

                <p>
                    <strong>Application Fee:</strong>
                    ₦{{ number_format($application->application_fee ?? 0) }}
                </p>
            </div>

            <hr>

            {{-- Status --}}
            <div class="mb-4">
                <h5 class="fw-semibold">Approval Status</h5>

                <p>
                    <strong>Status:</strong>
                    <span class="badge bg-{{
                        $application->status === 'approved' ? 'success' :
                        ($application->status === 'pending' ? 'warning' : 'danger')
                    }}">
                        {{ ucfirst($application->status) }}
                    </span>
                </p>

                <p>
                    <strong>Approved At:</strong>
                    {{ $application->approved_at?->format('M d, Y H:i') ?? 'N/A' }}
                </p>
            </div>

            {{-- Approve / Reject --}}
            @if($application->status === 'pending')

                <div class="d-flex gap-3">
                    <form method="POST"
                          action="{{ route('submissions.approve', $application->id) }}">
                        @csrf
                        <button class="btn btn-success">
                            <i class="fas fa-check me-1"></i>
                            Approve Application
                        </button>
                    </form>

                    <form method="POST"
                          action="{{ route('submissions.reject', $application->id) }}">
                        @csrf
                        <button class="btn btn-outline-danger">
                            <i class="fas fa-times me-1"></i>
                            Reject
                        </button>
                    </form>
                </div>

            @endif

        </div>
    </div>
</div>
@endsection
