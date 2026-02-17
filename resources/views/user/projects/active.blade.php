@extends('layouts.admin')

@section('title', 'My Active Projects')

@section('content')
<div class="container py-5">
    {{-- Hero Section with Gradient Background --}}
    <div class="position-relative overflow-hidden mb-5">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="mb-4">
                    <span class="badge bg-primary bg-opacity-10 text-primary px-4 py-2 rounded-pill mb-3">
                        <i class="fas fa-hard-hat me-2"></i>
                        Your Active Projects
                    </span>
                    <h1 class="display-4 fw-bold mb-3">
                        Projects You're <span class="text-primary">Making a Difference</span> In
                    </h1>
                    <p class="lead text-muted">
                        Track the progress of projects where you're involved as a contractor or contributor.
                        Watch communities transform through your participation.
                    </p>
                </div>
            </div>
            <div class="col-lg-4">
                {{-- Stats Cards --}}
                <div class="row g-3">
                    <div class="col-6">
                        <div class="card border-0 bg-primary bg-opacity-10 h-100">
                            <div class="card-body text-center">
                                <h3 class="display-6 fw-bold text-primary mb-1">{{ $stats['total_projects'] }}</h3>
                                <p class="small text-muted mb-0">Active Projects</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card border-0 bg-success bg-opacity-10 h-100">
                            <div class="card-body text-center">
                                <h3 class="display-6 fw-bold text-success mb-1">{{ $stats['contractor_projects'] }}</h3>
                                <p class="small text-muted mb-0">As Contractor</p>
                            </div>
                        </div>
                    </div>
                    @if($stats['contributor_projects'] > 0)
                    <div class="col-12">
                        <div class="card border-0 bg-info bg-opacity-10">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="small text-muted mb-1">Total Donated</p>
                                        <h4 class="fw-bold text-info mb-0">₦{{ number_format($stats['total_donated']) }}</h4>
                                    </div>
                                    <div class="bg-white rounded-circle p-3">
                                        <i class="fas fa-hand-holding-heart text-info fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if($projects->isEmpty())
        {{-- Empty State --}}
        <div class="text-center py-5">
            <div class="mb-4 position-relative">
                <div class="empty-state-icon mx-auto">
                    <i class="fas fa-tasks fa-4x text-primary opacity-25"></i>
                    <div class="empty-state-ring"></div>
                </div>
            </div>
            <h3 class="h2 mb-3">No Active Projects Yet</h3>
            <p class="text-muted mb-4" style="max-width: 500px; margin: 0 auto;">
                You're not currently involved in any active projects.
                Browse available projects and apply as a contractor or make a contribution to get started.
            </p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('project.index') }}" class="btn btn-primary btn-lg px-5">
                    <i class="fas fa-search me-2"></i>
                    Browse Projects
                </a>
                @if(!auth()->user()->contractor)
                <a href="{{ route('contractor.register') }}" class="btn btn-outline-primary btn-lg px-5">
                    <i class="fas fa-user-plus me-2"></i>
                    Register as Contractor
                </a>
                @endif
            </div>
        </div>
    @else
        {{-- Projects Grid --}}
        <div class="row g-4">
            @foreach($projects as $project)
                <div class="col-md-6 col-lg-4">
                    <div class="project-card h-100" data-role="{{ $project->user_role }}">
                        <div class="card border-0 shadow-sm h-100">
                            {{-- Card Header with Role Badge --}}
                            <div class="card-header bg-transparent border-0 pt-4 px-4">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        @if($project->user_role === 'contractor')
                                            <span class="badge bg-success px-3 py-2 rounded-pill mb-2">
                                                <i class="fas fa-hard-hat me-1"></i>
                                                Contractor
                                            </span>
                                        @else
                                            <span class="badge bg-info px-3 py-2 rounded-pill mb-2">
                                                <i class="fas fa-hand-holding-heart me-1"></i>
                                                Contributor
                                            </span>
                                        @endif
                                        <h5 class="card-title mb-1">{{ $project->title }}</h5>
                                        <p class="text-muted small mb-0">
                                            <i class="fas fa-map-marker-alt me-1 text-primary"></i>
                                            {{ $project->full_location ?? 'Location TBD' }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- Project Image --}}
                            @if($project->featured_image)
                                <div class="px-4">
                                    <div class="project-image-wrapper rounded-4 overflow-hidden">
                                        <img src="{{ asset('storage/' . $project->featured_image) }}"
                                             alt="{{ $project->title }}"
                                             class="project-image w-100">
                                    </div>
                                </div>
                            @endif

                            <div class="card-body px-4">
                                {{-- Progress Section --}}
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="small fw-semibold">Project Progress</span>
                                        <span class="small fw-bold text-primary">{{ $project->progress_percentage }}%</span>
                                    </div>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated
                                            {{ $project->health_status === 'healthy' ? 'bg-success' :
                                               ($project->health_status === 'warning' ? 'bg-warning' : 'bg-danger') }}"
                                             role="progressbar"
                                             style="width: {{ $project->progress_percentage }}%">
                                        </div>
                                    </div>
                                </div>

                                {{-- Phase Stats --}}
                                <div class="d-flex gap-3 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="phase-indicator total"></div>
                                        <span class="small text-muted">
                                            {{ $project->phases->count() }} Total Phases
                                        </span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="phase-indicator completed"></div>
                                        <span class="small text-muted">
                                            {{ $project->phases->whereNotNull('ended_at')->count() }} Completed
                                        </span>
                                    </div>
                                </div>

                                {{-- Current Phase --}}
                                @if($project->current_phase)
                                    <div class="current-phase bg-light rounded-3 p-3 mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="small text-muted">Current Phase</span>
                                            <span class="badge bg-primary bg-opacity-10 text-primary">
                                                {{ ucfirst(str_replace('_', ' ', $project->current_phase->status)) }}
                                            </span>
                                        </div>
                                        <p class="small mb-0 text-truncate-2">
                                            {{ $project->current_phase->description ?? 'No description' }}
                                        </p>
                                    </div>
                                @endif

                                {{-- Contributor-specific info --}}
                                @if($project->user_role === 'contributor' && isset($project->total_donated))
                                    <div class="donation-info bg-info bg-opacity-10 rounded-3 p-3 mb-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <i class="fas fa-hand-holding-heart text-info fa-2x"></i>
                                            <div>
                                                <span class="small text-muted d-block">Your Contribution</span>
                                                <span class="fw-bold text-info">₦{{ number_format($project->total_donated) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                {{-- Project Stats Grid --}}
                                <div class="row g-2 mb-3">
                                    <div class="col-6">
                                        <div class="stat-item">
                                            <span class="stat-label">Candidate</span>
                                            <span class="stat-value">{{ $project->candidate->name ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="stat-item">
                                            <span class="stat-label">Started</span>
                                            <span class="stat-value">{{ optional($project->start_date)->format('M Y') ?? 'TBD' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Card Footer --}}
                            <div class="card-footer bg-transparent border-0 px-4 pb-4 pt-0">
                                <a href="{{ $project->user_role === 'contractor' ?
                                    route('contractor.my.projects.show', $project) :
                                    route('projects.show', $project) }}"
                                   class="btn btn-outline-primary w-100">
                                    <i class="fas fa-eye me-2"></i>
                                    View Project Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Project Timeline Overview --}}
        @if($projects->count() > 1)
        <div class="mt-5 pt-4">
            <div class="d-flex align-items-center gap-3 mb-4">
                <div class="bg-primary bg-opacity-10 rounded-3 p-3">
                    <i class="fas fa-chart-line text-primary fa-2x"></i>
                </div>
                <div>
                    <h4 class="mb-1">Your Impact Timeline</h4>
                    <p class="text-muted mb-0">When you joined each project</p>
                </div>
            </div>

            <div class="timeline-horizontal">
                @foreach($projects->take(5) as $project)
                    <div class="timeline-horizontal-item">
                        <div class="timeline-dot {{ $project->user_role }}"></div>
                        <div class="timeline-content-wrapper">
                            <span class="small text-muted">{{ $project->involvement_date->format('M Y') }}</span>
                            <h6 class="mb-1">{{ Str::limit($project->title, 30) }}</h6>
                            <span class="badge {{ $project->user_role === 'contractor' ? 'bg-success' : 'bg-info' }} badge-sm">
                                {{ $project->user_role }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    @endif
</div>
@endsection

@push('styles')
<style>
:root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --success-gradient: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);
    --info-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.empty-state-icon {
    position: relative;
    width: 120px;
    height: 120px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: center;
}

.empty-state-ring {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    border: 3px dashed #0d6efd;
    border-radius: 50%;
    animation: spin 20s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.project-card {
    transition: all 0.3s ease;
}

.project-card:hover {
    transform: translateY(-5px);
}

.project-card:hover .project-image {
    transform: scale(1.1);
}

.project-image-wrapper {
    height: 160px;
    background: linear-gradient(45deg, #f3f4f6, #e5e7eb);
}

.project-image {
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.phase-indicator {
    width: 8px;
    height: 8px;
    border-radius: 4px;
    margin-right: 6px;
}

.phase-indicator.total {
    background: #e9ecef;
}

.phase-indicator.completed {
    background: #28a745;
}

.stat-item {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 8px;
    text-align: center;
}

.stat-label {
    display: block;
    font-size: 0.75rem;
    color: #6c757d;
    margin-bottom: 2px;
}

.stat-value {
    display: block;
    font-weight: 600;
    font-size: 0.9rem;
    color: #212529;
}

.text-truncate-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.current-phase {
    border-left: 3px solid #0d6efd;
}

.timeline-horizontal {
    display: flex;
    gap: 2rem;
    overflow-x: auto;
    padding: 1rem 0;
    scrollbar-width: thin;
}

.timeline-horizontal::-webkit-scrollbar {
    height: 6px;
}

.timeline-horizontal::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.timeline-horizontal::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 10px;
}

.timeline-horizontal-item {
    flex: 0 0 200px;
    position: relative;
}

.timeline-horizontal-item::before {
    content: '';
    position: absolute;
    top: 20px;
    left: 0;
    right: -2rem;
    height: 2px;
    background: #e9ecef;
    z-index: 0;
}

.timeline-horizontal-item:last-child::before {
    display: none;
}

.timeline-dot {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    margin-bottom: 1rem;
    position: relative;
    z-index: 1;
}

.timeline-dot.contractor {
    background: linear-gradient(135deg, #28a745, #20c997);
    box-shadow: 0 4px 10px rgba(40, 167, 69, 0.3);
}

.timeline-dot.contributor {
    background: linear-gradient(135deg, #17a2b8, #0dcaf0);
    box-shadow: 0 4px 10px rgba(23, 162, 184, 0.3);
}

.timeline-content-wrapper {
    position: relative;
    z-index: 1;
}

.badge-sm {
    font-size: 0.7rem;
    padding: 0.25rem 0.5rem;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .display-4 {
        font-size: 2.5rem;
    }

    .timeline-horizontal-item {
        flex: 0 0 160px;
    }
}
</style>
@endpush
