@extends('layouts.admin')

@section('title', 'Available Projects')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col">
            <h1 class="h2">Available Projects</h1>
            <p class="text-muted">
                @auth
                    @if(auth()->user()->contractor)
                        Browse and apply to projects that match your expertise
                    @elseif(auth()->user()->contributor)
                        Browse and sponsor projects that align with your interests
                    @elseif(auth()->user()->candidate)
                        Manage and track your project proposals
                    @else
                        Browse available projects
                    @endif
                @endauth
            </p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        @forelse($projects as $project)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 shadow-sm hover-shadow-lg border-0 position-relative">

                    {{-- "Yours" Badge for Candidate's Own Projects --}}
                    @if($role === 'candidate' && ($project->is_owner ?? false))
                        <div class="position-absolute top-0 start-0 z-1 m-3">
                            <span class="badge bg-primary py-2 px-3 rounded-pill shadow"
                                  style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); font-size: 0.85rem; border: 2px solid white;">
                                <i class="fas fa-check-circle me-1"></i>
                                Yours
                            </span>
                        </div>
                    @endif

                    {{-- Project Image --}}
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

                    {{-- Card Body --}}
                    <div class="card-body d-flex flex-column">

                        {{-- Title + Status --}}
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title mb-0">{{ $project->title }}</h5>
                            <span class="badge bg-{{
                                $project->status === 'ongoing' ? 'success' :
                                ($project->status === 'planning' ? 'info' :
                                ($project->status === 'approved' ? 'primary' : 'secondary')) }}">
                                {{ ucfirst($project->status) }}
                            </span>
                        </div>

                        {{-- Location --}}
                        <p class="card-text text-muted small mb-2">
                            <i class="fas fa-map-marker-alt me-1"></i>
                            {{ $project->full_location ?: 'Location not specified' }}
                        </p>

                        {{-- Description --}}
                        <p class="card-text">
                            {{ Str::limit($project->short_description ?: $project->description, 120) }}
                        </p>

                        {{-- Progress --}}
                        <div class="mb-3 mt-auto">
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

                        {{-- Action Row --}}
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <small class="text-muted">
                                <i class="far fa-calendar-alt me-1"></i>
                                {{ $project->start_date ? $project->start_date->format('M Y') : 'TBD' }}
                            </small>

                            <div>
                                @auth

                                    {{-- Contractor --}}
                                    @if($project->can_apply)
                                        @if($project->user_applied)
                                            @if(in_array($project->user_application_status, ['applied','pending']))
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
                                                    Rejected
                                                </span>
                                            @elseif($project->user_application_status === 'cancelled')
                                                <span class="badge bg-secondary py-2 px-3">
                                                    Cancelled
                                                </span>
                                            @endif
                                        @else
                                            <a href="{{ route('contractor.projects.form', $project) }}"
                                               class="btn btn-primary btn-sm">
                                                <i class="fas fa-paper-plane me-1"></i>
                                                Apply
                                            </a>
                                        @endif
                                    @endif

                                    {{-- Contributor --}}
                                    @if($project->can_sponsor)
                                        <a href="{{ route('contributor.sponsor.form', $project) }}"
                                           class="btn btn-success btn-sm">
                                            <i class="fas fa-hand-holding-usd me-1"></i>
                                            Sponsor
                                        </a>
                                    @endif

{{-- Candidate Actions --}}
@if($role === 'candidate')
    @if($project->is_owner)
        @if(!$project->is_active)
            {{-- Project not active - can edit --}}
            <a href="{{ route('admin.projects.edit', $project) }}"
               class="btn btn-warning btn-sm rounded-pill px-3 shadow-sm hover-scale transition"
               style="background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%); border: none;">
                <i class="fas fa-edit me-1"></i>
                Edit Project
            </a>
        @else
            {{-- Project is active - cannot edit --}}
            <button type="button"
                    class="btn btn-success btn-sm rounded-pill px-3 shadow-sm"
                    style="background: linear-gradient(135deg, #34d399 0%, #10b981 100%); border: none; opacity: 0.9; cursor: not-allowed;"
                    data-bs-toggle="tooltip"
                    data-bs-placement="top"
                    title="This project is active and cannot be edited. Contact admin for changes."
                    disabled>
                <i class="fas fa-check-circle me-1"></i>
                Active - Cannot Edit
            </button>
        @endif
    @else
        {{-- Not owner - view only badge --}}
        <span class="badge bg-light text-dark py-2 px-3 rounded-pill shadow-sm"
              data-bs-toggle="tooltip"
              data-bs-placement="top"
              title="You can view but not edit this project">
            <i class="fas fa-eye me-1"></i>
            View Only
        </span>
    @endif
@endif
                                @endauth
                            </div>
                        </div>
                    </div>

                    {{-- Footer --}}
                    <div class="card-footer bg-transparent border-top-0">
                        <a href="{{ route('user.projects.show', $project) }}"
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
                    <p class="mb-0">There are currently no active projects available.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection

@push('styles')
<style>
.hover-shadow-lg:hover {
    transform: translateY(-6px);
    box-shadow: 0 1rem 3rem rgba(0,0,0,.15)!important;
    transition: all 0.3s ease;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
});
</script>
@endpush
