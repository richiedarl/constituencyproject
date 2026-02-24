@extends('layouts.app')

@section('title', $candidate->name . ' - Candidate Profile | Constituency Project')

@section('content')
<!-- Page Header with Gradient -->
<section class="page-header py-4" style="background: linear-gradient(135deg, #29a221 0%, #ffc107 100%);">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 bg-transparent p-3">
                <li class="breadcrumb-item"><a href="{{ route('landing') }}" class="text-white opacity-75">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('candidates.index') }}" class="text-white opacity-75">Candidates</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Profile</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Candidate Profile Section -->
<section class="candidate-profile py-5" style="background: #f8f9fa;">
    <div class="container">
        <div class="row g-4">
            <!-- Left Column - Profile Card -->
            <div class="col-lg-4">
                <div class="profile-card bg-white rounded-4 shadow-lg p-4 text-center position-relative overflow-hidden"
                     style="border-top: 5px solid #29a221;">

                    <!-- Decorative Corner -->
                    <div class="position-absolute top-0 end-0" style="width: 100px; height: 100px; background: linear-gradient(135deg, transparent 50%, rgba(41, 162, 33, 0.1) 50%);"></div>

                    <!-- Profile Image -->
                    <div class="profile-image-wrapper mx-auto mb-4">
                        <div class="rounded-circle p-1 d-inline-block" style="border: 3px solid #29a221;">
                            <div class="rounded-circle overflow-hidden" style="width: 150px; height: 150px; border: 3px solid #ffc107;">
                                <img src="{{ $candidate->photo ? asset('storage/'.$candidate->photo) : asset('images/avatar.png') }}"
                                     alt="{{ $candidate->name }}"
                                     class="w-100 h-100"
                                     style="object-fit: cover;">
                            </div>
                        </div>

                        <!-- Verified Badge -->
                        @if($candidate->approved)
                            <div class="position-absolute bottom-0 end-0">
                                <span class="d-flex align-items-center justify-content-center rounded-circle bg-success shadow"
                                      style="width: 35px; height: 35px; border: 3px solid white;">
                                    <i class="bi bi-patch-check-fill text-white"></i>
                                </span>
                            </div>
                        @endif
                    </div>

                    <h2 class="fw-bold mb-2">{{ $candidate->name }}</h2>

                    @if($candidate->positions->count() > 0)
                        <p class="text-muted mb-2">{{ $candidate->positions->first()->position }}</p>
                    @endif

                    <!-- Location -->
                    @if($candidate->district || $candidate->state)
                        <p class="mb-2" style="color: #6c757d;">
                            <i class="bi bi-geo-alt-fill me-1" style="color: #29a221;"></i>
                            {{ $candidate->district ?? '' }} {{ $candidate->state ? ', ' . $candidate->state : '' }}
                        </p>
                    @endif

                    <!-- Contact Info -->
                    <p class="small mb-3">
                        <i class="bi bi-envelope me-1" style="color: #ffc107;"></i>
                        {{ $candidate->email }}
                    </p>
                    <p class="small mb-3">
                        <i class="bi bi-telephone me-1" style="color: #29a221;"></i>
                        {{ $candidate->phone }}
                    </p>

                    <!-- Bio -->
                    @if($candidate->bio)
                        <div class="bio-text text-start p-3 rounded-3 mb-3" style="background: rgba(41, 162, 33, 0.05); border-left: 3px solid #29a221;">
                            <p class="mb-0">{{ $candidate->bio }}</p>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="d-grid gap-2 mt-3">
                        <a href="{{ route('candidate.report.preview', $candidate->slug) }}"
                           class="btn py-2 rounded-3"
                           style="background: linear-gradient(135deg, #29a221 0%, #ffc107 100%); color: white; border: none;">
                            <i class="bi bi-file-text me-2"></i> View Full Report
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Column - Projects -->
            <div class="col-lg-8">
                <!-- Stats Cards -->
                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <div class="stat-card bg-white rounded-4 shadow-lg p-4 text-center h-100"
                             style="border-bottom: 4px solid #29a221;">
                            <div class="stat-icon mb-2">
                                <i class="bi bi-building" style="color: #29a221; font-size: 2.5rem;"></i>
                            </div>
                            <h3 class="fw-bold mb-1">{{ $candidate->projects->count() }}</h3>
                            <p class="mb-0">Total Projects</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card bg-white rounded-4 shadow-lg p-4 text-center h-100"
                             style="border-bottom: 4px solid #ffc107;">
                            <div class="stat-icon mb-2">
                                <i class="bi bi-play-circle" style="color: #ffc107; font-size: 2.5rem;"></i>
                            </div>
                            <h3 class="fw-bold mb-1">{{ $activeProjects->count() }}</h3>
                            <p class="mb-0">Active Projects</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card bg-white rounded-4 shadow-lg p-4 text-center h-100"
                             style="border-bottom: 4px solid linear-gradient(90deg, #29a221, #ffc107);">
                            <div class="stat-icon mb-2">
                                <i class="bi bi-check-circle" style="color: #29a221; font-size: 2.5rem;"></i>
                            </div>
                            <h3 class="fw-bold mb-1">{{ $completedProjects->count() }}</h3>
                            <p class="mb-0">Completed</p>
                        </div>
                    </div>
                </div>

                <!-- Active Projects -->
                @if($activeProjects->count() > 0)
                <div class="active-projects bg-white rounded-4 shadow-lg p-4 mb-4">
                    <h4 class="fw-bold mb-4">
                        <i class="bi bi-play-circle-fill me-2" style="color: #29a221;"></i>
                        Active Projects
                    </h4>

                    <div class="row g-4">
                        @foreach($activeProjects as $project)
                            <div class="col-md-6">
                                <div class="project-card border rounded-3 p-3 h-100"
                                     style="border-color: rgba(41, 162, 33, 0.2) !important;"
                                     onmouseover="this.style.borderColor='#29a221'; this.style.boxShadow='0 10px 20px rgba(41,162,33,0.1)';"
                                     onmouseout="this.style.borderColor='rgba(41,162,33,0.2)'; this.style.boxShadow='none';">
                                    <h5 class="fw-bold mb-2">{{ $project->title }}</h5>
                                    <p class="small text-muted mb-2">
                                        <i class="bi bi-geo-alt me-1" style="color: #ffc107;"></i>
                                        {{ $project->full_location }}
                                    </p>
                                    <div class="progress mb-2" style="height: 6px;">
                                        <div class="progress-bar bg-success" style="width: {{ $project->progress_percentage }}%"></div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <span class="small">{{ $project->phases->count() }} phases</span>
                                        <a href="{{ route('user.projects.show', $project->slug) }}" class="btn btn-sm" style="color: #29a221;">
                                            View <i class="bi bi-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Completed Projects -->
                @if($completedProjects->count() > 0)
                <div class="completed-projects bg-white rounded-4 shadow-lg p-4">
                    <h4 class="fw-bold mb-4">
                        <i class="bi bi-check-circle-fill me-2" style="color: #ffc107;"></i>
                        Completed Projects
                    </h4>

                    <div class="list-group">
                        @foreach($completedProjects as $project)
                            <div class="list-group-item border-0 border-bottom">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="fw-bold mb-1">{{ $project->title }}</h6>
                                        <small class="text-muted">{{ $project->full_location }}</small>
                                    </div>
                                    <a href="{{ route('user.projects.show', $project->slug) }}" class="btn btn-sm btn-outline-success">
                                        View
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
