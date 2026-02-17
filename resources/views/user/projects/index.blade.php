@extends('layouts.admin')

@section('title', 'Available Projects')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col">
            <h1 class="h2">Available Projects</h1>
            <p class="text-muted">Browse and apply to projects that match your expertise</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        @forelse($projects as $project)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 shadow-sm hover-shadow-lg transition">
                    @if($project->featured_image)
                        <img src="{{ asset('storage/' . $project->featured_image) }}"
                             class="card-img-top"
                             alt="{{ $project->title }}"
                             style="height: 200px; object-fit: cover;">
                    @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                             style="height: 200px;">
                            <i class="fas fa-hard-hat fa-3x text-secondary"></i>
                        </div>
                    @endif

                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title mb-0">{{ $project->title }}</h5>
                            <span class="badge bg-{{ $project->status === 'ongoing' ? 'success' : ($project->status === 'planning' ? 'info' : 'secondary') }}">
                                {{ ucfirst($project->status) }}
                            </span>
                        </div>

                        <p class="card-text text-muted small mb-2">
                            <i class="fas fa-map-marker-alt me-1"></i>
                            {{ $project->full_location ?: 'Location not specified' }}
                        </p>

                        <p class="card-text">
                            {{ Str::limit($project->short_description ?: $project->description, 120) }}
                        </p>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between small mb-1">
                                <span>Progress</span>
                                <span>{{ $project->progress_percentage }}%</span>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar {{ $project->progress_bar_class }}"
                                     role="progressbar"
                                     style="width: {{ $project->progress_percentage }}%"
                                     aria-valuenow="{{ $project->progress_percentage }}"
                                     aria-valuemin="0"
                                     aria-valuemax="100">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted">
                                    <i class="far fa-calendar-alt me-1"></i>
                                    {{ $project->start_date ? $project->start_date->format('M Y') : 'TBD' }}
                                </small>
                            </div>

                            @auth
                                @if(auth()->user()->contractor)
                                    @if($project->user_applied)
                                        @if($project->user_application_status === 'applied' || $project->user_application_status === 'pending')
                                            <div class="d-flex gap-2">
                                                <span class="badge bg-warning text-dark py-2 px-3">
                                                    <i class="fas fa-hourglass-half me-1"></i>
                                                    Applied
                                                </span>
                                                <form action="{{ route('applications.cancel', $project->user_application_id) }}"
                                                      method="POST"
                                                      class="d-inline"
                                                      onsubmit="return confirm('Are you sure you want to cancel your application?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="fas fa-times me-1"></i>
                                                        Cancel
                                                    </button>
                                                </form>
                                            </div>
                                        @elseif($project->user_application_status === 'approved')
                                            <span class="badge bg-success py-2 px-3">
                                                <i class="fas fa-check-circle me-1"></i>
                                                Approved
                                            </span>
                                        @elseif($project->user_application_status === 'rejected')
                                            <span class="badge bg-danger py-2 px-3">
                                                <i class="fas fa-times-circle me-1"></i>
                                                Rejected
                                            </span>
                                        @elseif($project->user_application_status === 'cancelled')
                                            <span class="badge bg-secondary py-2 px-3">
                                                <i class="fas fa-ban me-1"></i>
                                                Cancelled
                                            </span>
                                        @endif
                                    @else
                                        <a href="{{ route('contractor.projects.form', $project) }}"
                                           class="btn btn-primary btn-sm">
                                            <i class="fas fa-paper-plane me-1"></i>
                                            Apply as Contractor
                                        </a>
                                    @endif
                                @else
                                    <a href="{{ route('contractor.register') }}"
                                       class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-user-plus me-1"></i>
                                        Register as Contractor
                                    </a>
                                @endif
                            @endauth
                        </div>
                    </div>

                    <div class="card-footer bg-transparent border-top-0">
                        <a href="{{ route('projects.show', $project) }}"
                           class="btn btn-link text-decoration-none p-0">
                            View Details <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center py-5">
                    <i class="fas fa-hard-hat fa-3x mb-3"></i>
                    <h4>No Projects Available</h4>
                    <p class="mb-0">There are currently no active projects available for application.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection

@push('styles')
<style>
.hover-shadow-lg:hover {
    transform: translateY(-5px);
    box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important;
    transition: all 0.3s ease;
}
</style>
@endpush
