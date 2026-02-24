@extends('layouts.app')

@section('title', $project->title . ' - Project Details')

@section('content')
<!-- Page Header -->
<section class="page-header py-4" style="background: linear-gradient(135deg, #29a221 0%, #ffc107 100%);">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 bg-transparent p-3">
                <li class="breadcrumb-item"><a href="{{ route('landing') }}" class="text-white opacity-75">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('projects.index') }}" class="text-white opacity-75">Projects</a></li>
                <li class="breadcrumb-item active text-white">{{ $project->title }}</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Project Details -->
<section class="project-details py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <!-- Main Image -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <img src="{{ asset('storage/'.$project->featured_image) }}" class="card-img-top rounded-4" alt="{{ $project->title }}">
                </div>

                <!-- Project Info -->
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                    <h2 class="fw-bold mb-3">{{ $project->title }}</h2>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p><i class="bi bi-geo-alt-fill me-2" style="color: #29a221;"></i> {{ $project->full_location }}</p>
                            <p><i class="bi bi-calendar me-2" style="color: #ffc107;"></i> Started: {{ $project->start_date?->format('M Y') ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><i class="bi bi-person-circle me-2" style="color: #29a221;"></i> Candidate: {{ $project->candidate->name }}</p>
                            <p><i class="bi bi-tag me-2" style="color: #ffc107;"></i> Status: <span class="badge bg-success">{{ ucfirst($project->status) }}</span></p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h5>Description</h5>
                        <p>{{ $project->description }}</p>
                    </div>

                    <!-- Progress -->
                    <div class="mb-4">
                        <h5>Overall Progress</h5>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar bg-success" style="width: {{ $project->progress_percentage }}%"></div>
                        </div>
                        <p class="text-end mt-1">{{ $project->progress_percentage }}% Complete</p>
                    </div>
                </div>

                <!-- Phases -->
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <h4 class="fw-bold mb-4">Project Phases</h4>
                    @foreach($project->phases as $phase)
                        <div class="phase-item mb-4 pb-4 border-bottom">
                            <h5>{{ $phase->name }}</h5>
                            <p class="text-muted">{{ $phase->description }}</p>

                            @if($phase->media->count() > 0)
                                <div class="row g-2 mt-2">
                                    @foreach($phase->media as $media)
                                        <div class="col-md-3 col-4">
                                            <img src="{{ asset('storage/'.$media->file_path) }}" class="img-fluid rounded-3" style="height: 80px; object-fit: cover;">
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Stats Card -->
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                    <h5 class="fw-bold mb-3">Project Stats</h5>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Total Donations:</span>
                        <span class="fw-bold" style="color: #29a221;">₦{{ number_format($totalDonations) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Donors:</span>
                        <span class="fw-bold">{{ $donationCount }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Contributors:</span>
                        <span class="fw-bold">{{ $contributorsCount }}</span>
                    </div>

                    @if($project->is_active)
                        <a href="{{ route('contributor.project.apply', $project->id) }}" class="btn btn-lg w-100 py-3 rounded-3" style="background: linear-gradient(135deg, #29a221 0%, #ffc107 100%); color: white;">
                            Support This Project
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
