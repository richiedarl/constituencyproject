@extends('layouts.app')

@section('title', $candidate->name . ' - Full Report | Constituency Project')

@section('content')
<!-- Report Header with Print Options -->
<section class="report-header py-4" style="background: linear-gradient(135deg, #29a221 0%, #ffc107 100%);">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-center">
            <div>
                <h1 class="text-white fw-bold mb-1">Candidate Report</h1>
                <p class="text-white opacity-90 mb-0">{{ $candidate->name }}</p>
            </div>
            <div class="mt-3 mt-md-0">
                <button onclick="window.print()" class="btn btn-light me-2">
                    <i class="bi bi-printer me-2"></i>Print Report
                </button>
                <a href="{{ route('candidate.report.preview', $candidate->slug) }}" class="btn btn-outline-light">
                    <i class="bi bi-arrow-left me-2"></i>Back to Preview
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Report Content -->
<section class="report-content py-5" style="background: #f8f9fa;">
    <div class="container">
        <!-- Watermark for Printed Version -->
        <div class="print-watermark">CONSTITUENCY PROJECT</div>

        <!-- Candidate Info Card -->
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-4" data-aos="fade-up">
            <div class="card-body p-5">
                <div class="row">
                    <div class="col-md-3 text-center mb-4 mb-md-0">
                        <div class="position-relative d-inline-block">
                            <div class="rounded-circle p-1" style="border: 3px solid #29a221;">
                                <div class="rounded-circle overflow-hidden" style="width: 150px; height: 150px; border: 3px solid #ffc107;">
                                    <img src="{{ $candidate->photo ? asset('storage/'.$candidate->photo) : asset('images/avatar.png') }}"
                                         alt="{{ $candidate->name }}"
                                         class="w-100 h-100"
                                         style="object-fit: cover;">
                                </div>
                            </div>
                            @if($candidate->approved)
                                <div class="position-absolute bottom-0 end-0">
                                    <span class="d-flex align-items-center justify-content-center rounded-circle bg-success shadow"
                                          style="width: 35px; height: 35px; border: 3px solid white;">
                                        <i class="bi bi-patch-check-fill text-white"></i>
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-9">
                        <h2 class="fw-bold mb-3" style="color: #212529;">{{ $candidate->name }}</h2>

                        <div class="row g-3 mb-3">
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center">
                                    <div class="me-3" style="color: #29a221;"><i class="bi bi-envelope-fill"></i></div>
                                    <div>
                                        <small class="text-muted d-block">Email</small>
                                        <span>{{ $candidate->email }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center">
                                    <div class="me-3" style="color: #ffc107;"><i class="bi bi-telephone-fill"></i></div>
                                    <div>
                                        <small class="text-muted d-block">Phone</small>
                                        <span>{{ $candidate->phone }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center">
                                    <div class="me-3" style="color: #29a221;"><i class="bi bi-geo-alt-fill"></i></div>
                                    <div>
                                        <small class="text-muted d-block">Location</small>
                                        <span>{{ $candidate->district ?? '' }} {{ $candidate->state ? ', ' . $candidate->state : '' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center">
                                    <div class="me-3" style="color: #ffc107;"><i class="bi bi-calendar-check"></i></div>
                                    <div>
                                        <small class="text-muted d-block">Member Since</small>
                                        <span>{{ $candidate->created_at->format('F Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($candidate->bio)
                            <div class="mt-3 p-3 rounded-3" style="background: rgba(41, 162, 33, 0.05); border-left: 4px solid #29a221;">
                                <p class="mb-0">{{ $candidate->bio }}</p>
                            </div>
                        @endif

                        @if($candidate->positions->count() > 0)
                            <div class="mt-3">
                                @foreach($candidate->positions as $position)
                                    <span class="badge px-3 py-2 me-2 mb-2" style="background: rgba(255, 193, 7, 0.1); color: #212529; border: 1px solid #ffc107;">
                                        <i class="bi bi-tag me-1" style="color: #29a221;"></i>
                                        {{ $position->position }}
                                        @if($position->year_from)
                                            ({{ $position->year_from }} - {{ $position->year_until ?? 'Present' }})
                                        @endif
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="row g-4 mb-4">
            @php
                $totalProjects = $candidate->projects->count();
                $totalPhases = 0;
                $totalUpdates = 0;
                $totalMedia = 0;

                foreach($candidate->projects as $project) {
                    $totalPhases += $project->phases->count();
                    foreach($project->phases as $phase) {
                        $totalUpdates += $phase->updates->count();
                        $totalMedia += $phase->media->count();
                    }
                }
            @endphp

            <div class="col-md-3 col-6">
                <div class="card border-0 shadow-sm rounded-4 p-4 text-center h-100" style="border-bottom: 4px solid #29a221;">
                    <div class="display-4 fw-bold" style="color: #29a221;">{{ $totalProjects }}</div>
                    <div class="text-muted">Total Projects</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card border-0 shadow-sm rounded-4 p-4 text-center h-100" style="border-bottom: 4px solid #ffc107;">
                    <div class="display-4 fw-bold" style="color: #ffc107;">{{ $totalPhases }}</div>
                    <div class="text-muted">Project Phases</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card border-0 shadow-sm rounded-4 p-4 text-center h-100" style="border-bottom: 4px solid #29a221;">
                    <div class="display-4 fw-bold" style="color: #29a221;">{{ $totalUpdates }}</div>
                    <div class="text-muted">Daily Updates</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card border-0 shadow-sm rounded-4 p-4 text-center h-100" style="border-bottom: 4px solid linear-gradient(90deg, #29a221, #ffc107);">
                    <div class="display-4 fw-bold" style="color: #29a221;">{{ $totalMedia }}</div>
                    <div class="text-muted">Media Files</div>
                </div>
            </div>
        </div>

        <!-- Projects Section -->
        @forelse($candidate->projects as $projectIndex => $project)
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-5" data-aos="fade-up">
                <!-- Project Header -->
                <div class="card-header bg-white py-4 px-5 border-0" style="border-bottom: 2px solid rgba(41, 162, 33, 0.2);">
                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                        <div>
                            <h3 class="fw-bold mb-2" style="color: #212529;">{{ $project->title }}</h3>
                            <p class="text-muted mb-0">
                                <i class="bi bi-geo-alt-fill me-1" style="color: #29a221;"></i>
                                {{ $project->full_location }}
                            </p>
                        </div>
                        <span class="badge px-4 py-2 mt-2 mt-md-0 rounded-pill"
                              style="background: {{ $project->status === 'completed' ? '#29a221' : ($project->status === 'ongoing' ? '#ffc107' : '#6c757d') }};
                                     color: {{ $project->status === 'ongoing' ? '#212529' : 'white' }};
                                     font-size: 1rem;">
                            <i class="bi bi-{{ $project->status === 'completed' ? 'check-circle' : ($project->status === 'ongoing' ? 'play-circle' : 'clock') }} me-1"></i>
                            {{ ucfirst($project->status) }}
                        </span>
                    </div>
                </div>

                <div class="card-body p-5">
                    <!-- Project Description -->
                    @if($project->description)
                        <div class="mb-4">
                            <h5 class="fw-bold mb-3" style="color: #29a221;">Project Description</h5>
                            <p class="text-muted">{{ $project->description }}</p>
                        </div>
                    @endif

                    <!-- Project Meta Info -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-3 col-6">
                            <small class="text-muted d-block">Start Date</small>
                            <span class="fw-bold">{{ $project->start_date ? $project->start_date->format('M Y') : 'N/A' }}</span>
                        </div>
                        <div class="col-md-3 col-6">
                            <small class="text-muted d-block">End Date</small>
                            <span class="fw-bold">{{ $project->completion_date ? $project->completion_date->format('M Y') : 'Ongoing' }}</span>
                        </div>
                        <div class="col-md-3 col-6">
                            <small class="text-muted d-block">Budget</small>
                            <span class="fw-bold" style="color: #29a221;">₦{{ number_format($project->estimated_budget ?? 0) }}</span>
                        </div>
                        <div class="col-md-3 col-6">
                            <small class="text-muted d-block">Progress</small>
                            <span class="fw-bold" style="color: #ffc107;">{{ $project->progress_percentage }}%</span>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div class="progress mb-5" style="height: 8px;">
                        <div class="progress-bar" style="width: {{ $project->progress_percentage }}%; background: linear-gradient(90deg, #29a221, #ffc107);"></div>
                    </div>

                    <!-- Project Phases -->
                    <h5 class="fw-bold mb-4" style="color: #29a221;">
                        <i class="bi bi-diagram-3 me-2"></i>
                        Project Phases & Updates
                    </h5>

                    @forelse($project->phases as $phaseIndex => $phase)
                        <div class="phase-section mb-4 pb-4 {{ !$loop->last ? 'border-bottom' : '' }}" style="border-color: rgba(41, 162, 33, 0.1) !important;">
                            <div class="d-flex align-items-center mb-3">
                                <span class="badge me-3" style="background: #29a221; color: white; width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                    {{ $phaseIndex + 1 }}
                                </span>
                                <h5 class="fw-bold mb-0">{{ $phase->name }}</h5>
                                @if($phase->status)
                                    <span class="badge ms-3 px-3 py-1 rounded-pill" style="background: {{ $phase->status === 'completed' ? '#29a221' : ($phase->status === 'in_progress' ? '#ffc107' : '#6c757d') }}; color: white; font-size: 0.7rem;">
                                        {{ ucfirst($phase->status) }}
                                    </span>
                                @endif
                            </div>

                            @if($phase->description)
                                <p class="text-muted mb-3 ms-5">{{ $phase->description }}</p>
                            @endif

                            <!-- Phase Media -->
                            @if($phase->media->count() > 0)
                                <div class="ms-5 mb-4">
                                    <small class="text-muted d-block mb-2">Phase Media:</small>
                                    <div class="row g-2">
                                        @foreach($phase->media as $media)
                                            <div class="col-md-3 col-4">
                                                <a href="{{ asset('storage/'.$media->file_path) }}" class="glightbox" data-gallery="phase-{{ $phase->id }}">
                                                    <img src="{{ asset('storage/'.$media->file_path) }}"
                                                         class="img-fluid rounded-3"
                                                         style="height: 80px; width: 100%; object-fit: cover; border: 2px solid rgba(41, 162, 33, 0.2);">
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Phase Updates -->
                            @if($phase->updates->count() > 0)
                                <div class="ms-5">
                                    <small class="text-muted d-block mb-2">Daily Updates:</small>
                                    @foreach($phase->updates as $update)
                                        <div class="update-item p-3 mb-2 rounded-3" style="background: rgba(41, 162, 33, 0.03); border-left: 3px solid #ffc107;">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <small class="text-primary">{{ $update->created_at->format('M d, Y - h:i A') }}</small>
                                                @if($update->contractor)
                                                    <small class="text-muted">
                                                        <i class="bi bi-person-circle me-1"></i>
                                                        {{ $update->contractor->user->name ?? 'Contractor' }}
                                                    </small>
                                                @endif
                                            </div>
                                            <p class="mb-2">{{ $update->comment }}</p>

                                            @if($update->photos->count() > 0)
                                                <div class="row g-1 mt-2">
                                                    @foreach($update->photos as $photo)
                                                        <div class="col-md-2 col-3">
                                                            <img src="{{ asset('storage/'.$photo->file_path) }}"
                                                                 class="img-fluid rounded-2"
                                                                 style="height: 50px; width: 100%; object-fit: cover;">
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @empty
                        <p class="text-muted">No phases documented for this project.</p>
                    @endforelse
                </div>
            </div>
        @empty
            <div class="alert alert-info text-center py-5">
                <i class="bi bi-folder-x display-1 d-block mb-3"></i>
                <h4>No Projects Found</h4>
                <p class="mb-0">This candidate has no documented projects yet.</p>
            </div>
        @endforelse

        <!-- Report Footer -->
        <div class="report-footer text-center mt-5 pt-4 border-top" style="border-color: rgba(41, 162, 33, 0.2) !important;">
            <img src="{{ asset('fe/assets/img/logo_current.webp') }}" alt="Logo" style="height: 40px; opacity: 0.5;">
            <p class="text-muted small mt-3">
                <i class="bi bi-patch-check-fill me-1" style="color: #29a221;"></i>
                This report is generated from Constituency Project - Verified Public Impact Documentation
            </p>
            <p class="text-muted small">
                Report generated on {{ now()->format('F d, Y \a\t h:i A') }}
            </p>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    @media print {
        .report-header, .btn, footer, .page-header {
            display: none !important;
        }

        .print-watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 80px;
            font-weight: bold;
            color: rgba(41, 162, 33, 0.1);
            white-space: nowrap;
            z-index: 1000;
            pointer-events: none;
        }

        .card {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
            page-break-inside: avoid;
        }

        .phase-section {
            page-break-inside: avoid;
        }

        .progress {
            border: 1px solid #ddd;
        }

        a {
            text-decoration: none !important;
            color: #000 !important;
        }
    }

    .update-item {
        transition: all 0.3s ease;
    }

    .update-item:hover {
        transform: translateX(5px);
        background: rgba(41, 162, 33, 0.08) !important;
    }

    .phase-section {
        transition: all 0.3s ease;
    }

    .phase-section:hover {
        padding-left: 10px;
    }

    @media (max-width: 768px) {
        .display-4 {
            font-size: 2rem;
        }
        .card-body {
            padding: 1.5rem !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize glightbox for media gallery
        if (typeof GLightbox !== 'undefined') {
            GLightbox({
                selector: '.glightbox',
                touchNavigation: true,
                loop: true
            });
        }

        // Add print optimization
        window.addEventListener('beforeprint', function() {
            document.body.classList.add('printing');
        });

        window.addEventListener('afterprint', function() {
            document.body.classList.remove('printing');
        });
    });
</script>
@endpush
