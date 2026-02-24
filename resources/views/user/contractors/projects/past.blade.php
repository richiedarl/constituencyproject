@extends('layouts.app')

@section('title', 'My Past Projects')

@section('content')
<!-- Page Header with Gradient -->
<section class="page-header py-4" style="background: linear-gradient(135deg, #29a221 0%, #ffc107 100%);">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="text-white fw-bold mb-1">Past Projects</h1>
                <p class="text-white opacity-90 mb-0">Projects you've successfully completed</p>
            </div>
            <div>
                <a href="{{ route('contractor.dashboard') }}" class="btn btn-outline-light">
                    <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
                </a>
            </div>
        </div>
    </div>
</section>

<section class="past-projects py-5" style="background: #f8f9fa; min-height: calc(100vh - 200px);">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="row mb-5">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 text-center h-100" style="border-bottom: 4px solid #29a221;">
                    <div class="stat-icon mb-3">
                        <i class="bi bi-building" style="color: #29a221; font-size: 2.5rem;"></i>
                    </div>
                    <h2 class="fw-bold mb-2" style="color: #212529;">{{ $pastProjects->count() }}</h2>
                    <p class="text-muted mb-0">Total Completed Projects</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 text-center h-100" style="border-bottom: 4px solid #ffc107;">
                    <div class="stat-icon mb-3">
                        <i class="bi bi-trophy" style="color: #ffc107; font-size: 2.5rem;"></i>
                    </div>
                    @php
                        $totalValue = $pastProjects->sum('estimated_budget');
                    @endphp
                    <h2 class="fw-bold mb-2" style="color: #212529;">₦{{ number_format($totalValue) }}</h2>
                    <p class="text-muted mb-0">Total Project Value</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 text-center h-100" style="border-bottom: 4px solid linear-gradient(90deg, #29a221, #ffc107);">
                    <div class="stat-icon mb-3">
                        <i class="bi bi-star" style="color: #29a221; font-size: 2.5rem;"></i>
                    </div>
                    <h2 class="fw-bold mb-2" style="color: #212529;">{{ $pastProjects->count() }}</h2>
                    <p class="text-muted mb-0">Projects Delivered</p>
                </div>
            </div>
        </div>

        @if($pastProjects->isEmpty())
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card border-0 shadow-lg rounded-4 p-5 text-center">
                        <div class="empty-state">
                            <div class="mb-4">
                                <i class="bi bi-folder-check" style="font-size: 5rem; color: #29a221; opacity: 0.3;"></i>
                            </div>
                            <h3 class="fw-bold mb-3">No Past Projects Yet</h3>
                            <p class="text-muted mb-4">You haven't completed any projects yet. Once you complete projects, they'll appear here.</p>
                            <a href="{{ route('contractor.projects.active') }}" class="btn btn-primary px-5 py-3 rounded-3" style="background: linear-gradient(135deg, #29a221 0%, #ffc107 100%); border: none;">
                                <i class="bi bi-briefcase me-2"></i>View Active Projects
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row g-4">
                @foreach($pastProjects as $project)
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-lg rounded-4 overflow-hidden h-100 project-card"
                             data-aos="fade-up"
                             style="transition: all 0.3s ease;"
                             onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 20px 30px rgba(41,162,33,0.15)';"
                             onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 20px rgba(0,0,0,0.05)';">

                            <div class="row g-0">
                                <!-- Project Image -->
                                <div class="col-md-4">
                                    <div class="position-relative h-100">
                                        @if($project->featured_image)
                                            <img src="{{ asset('storage/'.$project->featured_image) }}"
                                                 class="img-fluid h-100 w-100"
                                                 style="object-fit: cover; min-height: 100%;"
                                                 alt="{{ $project->title }}">
                                        @else
                                            <div class="bg-light h-100 w-100 d-flex align-items-center justify-content-center"
                                                 style="min-height: 200px;">
                                                <i class="bi bi-image" style="font-size: 3rem; color: #dee2e6;"></i>
                                            </div>
                                        @endif

                                        <!-- Completed Badge -->
                                        <div class="position-absolute top-0 start-0 m-3">
                                            <span class="badge bg-success py-2 px-3 rounded-pill">
                                                <i class="bi bi-check-circle me-1"></i>Completed
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Project Details -->
                                <div class="col-md-8">
                                    <div class="card-body p-4">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h4 class="fw-bold mb-0" style="color: #212529;">{{ $project->title }}</h4>
                                        </div>

                                        <!-- Location -->
                                        <p class="text-muted small mb-3">
                                            <i class="bi bi-geo-alt-fill me-1" style="color: #29a221;"></i>
                                            {{ $project->full_location }}
                                        </p>

                                        <!-- Description -->
                                        <p class="text-muted mb-3">
                                            {{ Str::limit($project->description ?? $project->short_description, 100) }}
                                        </p>

                                        <!-- Project Meta -->
                                        <div class="row g-2 mb-3">
                                            <div class="col-6">
                                                <div class="d-flex align-items-center">
                                                    <div class="me-2 p-2 rounded-circle" style="background: rgba(41, 162, 33, 0.1);">
                                                        <i class="bi bi-calendar-check" style="color: #29a221; font-size: 0.9rem;"></i>
                                                    </div>
                                                    <div>
                                                        <small class="text-muted d-block">Completed</small>
                                                        <span class="fw-bold small">{{ $project->completed_at ? $project->completed_at->format('M d, Y') : $project->completion_date?->format('M d, Y') ?? 'N/A' }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="d-flex align-items-center">
                                                    <div class="me-2 p-2 rounded-circle" style="background: rgba(255, 193, 7, 0.1);">
                                                        <i class="bi bi-currency-dollar" style="color: #ffc107; font-size: 0.9rem;"></i>
                                                    </div>
                                                    <div>
                                                        <small class="text-muted d-block">Budget</small>
                                                        <span class="fw-bold small" style="color: #29a221;">₦{{ number_format($project->estimated_budget ?? 0) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Candidate Info -->
                                        <div class="d-flex align-items-center mb-3 p-2 rounded-3" style="background: rgba(41, 162, 33, 0.03);">
                                            <div class="me-2">
                                                @if($project->candidate && $project->candidate->photo)
                                                    <img src="{{ asset('storage/'.$project->candidate->photo) }}"
                                                         class="rounded-circle"
                                                         style="width: 30px; height: 30px; object-fit: cover;">
                                                @else
                                                    <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center"
                                                         style="width: 30px; height: 30px;">
                                                        <i class="bi bi-person" style="font-size: 0.8rem;"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <small class="text-muted d-block">Project Owner</small>
                                                <span class="small fw-bold">{{ $project->candidate->name ?? 'Unknown' }}</span>
                                            </div>
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('user.projects.show', $project->slug) }}"
                                               class="btn flex-fill py-2 rounded-3"
                                               style="border: 1px solid #29a221; color: #29a221; background: white; transition: all 0.3s ease;"
                                               onmouseover="this.style.background='#29a221'; this.style.color='white';"
                                               onmouseout="this.style.background='white'; this.style.color='#29a221';">
                                                <i class="bi bi-eye me-1"></i>View Details
                                            </a>
                                            <a href="#"
                                               class="btn flex-fill py-2 rounded-3"
                                               style="border: 1px solid #ffc107; color: #212529; background: white; transition: all 0.3s ease;"
                                               onmouseover="this.style.background='#ffc107'; this.style.color='#212529';"
                                               onmouseout="this.style.background='white'; this.style.color='#212529';"
                                               data-bs-toggle="modal"
                                               data-bs-target="#certificateModal{{ $project->id }}">
                                                <i class="bi bi-award me-1"></i>Certificate
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Certificate Modal -->
                    <div class="modal fade" id="certificateModal{{ $project->id }}" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header border-0">
                                    <h5 class="modal-title fw-bold">Certificate of Completion</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body p-5 text-center">
                                    <div class="certificate-wrapper p-5 rounded-4" style="border: 3px double #29a221; background: #fff9e6;">
                                        <div class="mb-4">
                                            <img src="{{ asset('fe/assets/img/logo_current.webp') }}" alt="Logo" style="height: 60px;">
                                        </div>
                                        <h2 class="display-6 fw-bold mb-3" style="color: #29a221;">CERTIFICATE OF COMPLETION</h2>
                                        <p class="text-muted mb-4">This is to certify that</p>
                                        <h3 class="fw-bold mb-3" style="color: #212529;">{{ Auth::user()->name }}</h3>
                                        <p class="text-muted mb-2">has successfully completed the project</p>
                                        <h4 class="fw-bold mb-4" style="color: #ffc107;">{{ $project->title }}</h4>
                                        <div class="row mb-4">
                                            <div class="col-6">
                                                <small class="text-muted d-block">Project Location</small>
                                                <span class="fw-bold">{{ $project->full_location }}</span>
                                            </div>
                                            <div class="col-6">
                                                <small class="text-muted d-block">Completion Date</small>
                                                <span class="fw-bold">{{ $project->completed_at ? $project->completed_at->format('F d, Y') : $project->completion_date?->format('F d, Y') ?? now()->format('F d, Y') }}</span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6 text-start">
                                                <p class="mb-0">_________________________</p>
                                                <small class="text-muted">Project Owner</small>
                                            </div>
                                            <div class="col-6 text-end">
                                                <p class="mb-0">_________________________</p>
                                                <small class="text-muted">Contractor</small>
                                            </div>
                                        </div>
                                    </div>
                                    <button onclick="window.print()" class="btn btn-primary mt-4 px-5 py-2 rounded-3">
                                        <i class="bi bi-printer me-2"></i>Print Certificate
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Summary Section -->
            <div class="row mt-5">
                <div class="col-12">
                    <div class="card border-0 shadow-lg rounded-4 p-4" style="background: linear-gradient(135deg, #29a221 0%, #ffc107 100%);">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h4 class="text-white mb-2">Project Completion Summary</h4>
                                <p class="text-white opacity-90 mb-0">
                                    You have successfully completed <strong class="fw-bold">{{ $pastProjects->count() }}</strong> projects
                                    with a total value of <strong class="fw-bold">₦{{ number_format($totalValue) }}</strong>.
                                </p>
                            </div>
                            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                                <span class="badge bg-white text-dark p-3 rounded-pill">
                                    <i class="bi bi-star-fill me-2" style="color: #ffc107;"></i>
                                    Excellent Performance
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>

<style>
    /* Animation for project cards */
    .project-card {
        transition: all 0.3s ease;
    }

    /* Certificate styling for print */
    @media print {
        .modal {
            position: relative;
            display: block !important;
            opacity: 1 !important;
            visibility: visible !important;
        }

        .modal-content {
            border: 2px solid #29a221 !important;
            box-shadow: none !important;
        }

        .btn-close, .btn, .page-header, footer, nav {
            display: none !important;
        }

        body {
            background: white !important;
        }

        .certificate-wrapper {
            border: 3px double #000 !important;
            background: white !important;
        }
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .certificate-wrapper {
            padding: 2rem !important;
        }

        .certificate-wrapper h2 {
            font-size: 1.5rem !important;
        }

        .certificate-wrapper h4 {
            font-size: 1.2rem !important;
        }
    }

    /* Empty state animation */
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    .empty-state i {
        animation: float 3s ease-in-out infinite;
    }
</style>
@endsection
