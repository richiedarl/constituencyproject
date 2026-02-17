@extends('layouts.admin')

@section('title', 'My Projects')

@section('content')
<div class="container py-5">
    {{-- Header Section with Gradient --}}
    <div class="mb-5">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="display-5 fw-bold text-dark mb-2">
                    <i class="fas fa-hard-hat me-3 text-primary"></i>
                    My Projects
                </h1>
                <p class="text-muted lead">
                    Projects where you're an approved contractor
                </p>
            </div>
            <a href="{{ route('project.index') }}" class="btn btn-outline-primary btn-lg">
                <i class="fas fa-search me-2"></i>
                Browse More Projects
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($projects->isEmpty())
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="fas fa-tasks fa-4x text-muted opacity-50"></i>
            </div>
            <h3 class="h4 text-muted mb-3">No Approved Projects Yet</h3>
            <p class="text-muted mb-4">You haven't been approved for any projects yet.</p>
            <a href="{{ route('project.index') }}" class="btn btn-primary">
                <i class="fas fa-search me-2"></i>
                Browse Available Projects
            </a>
        </div>
    @else
        <div class="row g-4">
            @foreach($projects as $project)
                <div class="col-lg-6">
                    <div class="card h-100 border-0 shadow-sm hover-lift">
                        {{-- Project Header with Status --}}
                        <div class="card-header bg-white border-0 pt-4 px-4">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h5 class="card-title mb-1">
                                        <a href="{{ route('contractor.my.projects.show', $project) }}"
                                           class="text-decoration-none text-dark stretched-link">
                                            {{ $project->title }}
                                        </a>
                                    </h5>
                                    <p class="text-muted small mb-2">
                                        <i class="fas fa-map-marker-alt me-1 text-primary"></i>
                                        {{ $project->full_location ?? 'Location not specified' }}
                                    </p>
                                </div>
                                <span class="badge bg-success px-3 py-2 rounded-pill">
                                    <i class="fas fa-check-circle me-1"></i>
                                    Approved
                                </span>
                            </div>
                        </div>

                        <div class="card-body pt-0 px-4">
                            {{-- Project Image/Placeholder --}}
                            @if($project->featured_image)
                                <div class="rounded-3 overflow-hidden mb-3" style="height: 180px;">
                                    <img src="{{ asset('storage/' . $project->featured_image) }}"
                                         alt="{{ $project->title }}"
                                         class="w-100 h-100 object-fit-cover">
                                </div>
                            @endif

                            {{-- Project Description --}}
                            <p class="text-muted mb-3">
                                {{ Str::limit($project->short_description ?? $project->description, 120) }}
                            </p>

                            {{-- Progress Bar --}}
                            <div class="mb-3">
                                <div class="d-flex justify-content-between small mb-1">
                                    <span class="text-muted">Overall Progress</span>
                                    <span class="fw-bold text-primary">{{ $project->progress_percentage }}%</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-success"
                                         role="progressbar"
                                         style="width: {{ $project->progress_percentage }}%"
                                         aria-valuenow="{{ $project->progress_percentage }}"
                                         aria-valuemin="0"
                                         aria-valuemax="100">
                                    </div>
                                </div>
                            </div>

                            {{-- Project Meta --}}
                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <div class="bg-light rounded-3 p-2 text-center">
                                        <small class="text-muted d-block">Candidate</small>
                                        <span class="fw-semibold">{{ $project->candidate->name ?? 'N/A' }}</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="bg-light rounded-3 p-2 text-center">
                                        <small class="text-muted d-block">Start Date</small>
                                        <span class="fw-semibold">{{ optional($project->start_date)->format('M Y') ?? 'TBD' }}</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Phase Stats --}}
                            <div class="d-flex gap-3 small text-muted mb-2">
                                <span>
                                    <i class="fas fa-layer-group me-1 text-primary"></i>
                                    {{ $project->phases->count() }} Total Phases
                                </span>
                                <span>
                                    <i class="fas fa-check-circle me-1 text-success"></i>
                                    {{ $project->phases->whereNotNull('ended_at')->count() }} Completed
                                </span>
                            </div>
                        </div>

                        <div class="card-footer bg-white border-0 px-4 pb-4 pt-0">
                            <a href="{{ route('contractor.my.projects.show', $project) }}"
                               class="btn btn-outline-primary w-100">
                                <i class="fas fa-eye me-2"></i>
                                View Project Details
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
.hover-lift {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: 0 1rem 3rem rgba(0,0,0,.1)!important;
}
.object-fit-cover {
    object-fit: cover;
}
</style>
@endpush
