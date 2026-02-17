@extends('layouts.app')

@section('title', $project->title)

@section('content')
<div class="container py-5">
    {{-- Navigation --}}
    <div class="mb-4">
        <a href="{{ route('contractor.my.projects') }}" class="text-decoration-none">
            <i class="fas fa-arrow-left me-2"></i>
            Back to My Projects
        </a>
    </div>

    {{-- Project Header --}}
    <div class="row mb-5">
        <div class="col-lg-8">
            <h1 class="display-5 fw-bold mb-2">{{ $project->title }}</h1>
            <div class="d-flex flex-wrap gap-3 mb-3">
                <span class="text-muted">
                    <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                    {{ $project->full_location ?? 'Location not specified' }}
                </span>
                <span class="text-muted">
                    <i class="fas fa-calendar me-2 text-primary"></i>
                    Started {{ optional($project->start_date)->format('F Y') ?? 'TBD' }}
                </span>
                <span class="text-muted">
                    <i class="fas fa-user me-2 text-primary"></i>
                    Candidate: {{ $project->candidate->name ?? 'N/A' }}
                </span>
            </div>
        </div>
        <div class="col-lg-4 text-lg-end">
            <div class="bg-success bg-opacity-10 p-3 rounded-4">
                <span class="badge bg-success px-4 py-2 rounded-pill">
                    <i class="fas fa-check-circle me-2"></i>
                    Approved Contractor
                </span>
            </div>
        </div>
    </div>

    {{-- Project Description --}}
    @if($project->description)
        <div class="card border-0 shadow-sm mb-5">
            <div class="card-body p-4">
                <h5 class="card-title mb-3">
                    <i class="fas fa-info-circle me-2 text-primary"></i>
                    Project Description
                </h5>
                <p class="card-text text-muted lead">{{ $project->description }}</p>
            </div>
        </div>
    @endif

    {{-- Progress Overview --}}
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <div class="display-4 fw-bold text-primary mb-2">
                        {{ $project->progress_percentage }}%
                    </div>
                    <p class="text-muted mb-0">Overall Progress</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <div class="display-4 fw-bold text-success mb-2">
                        {{ $project->phases->whereNotNull('ended_at')->count() }}
                    </div>
                    <p class="text-muted mb-0">Completed Phases</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <div class="display-4 fw-bold text-info mb-2">
                        {{ $project->phases->whereNull('ended_at')->count() }}
                    </div>
                    <p class="text-muted mb-0">Active Phases</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Project Phases Timeline --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 pt-4 px-4">
            <h4 class="mb-0">
                <i class="fas fa-timeline me-2 text-primary"></i>
                Project Phases Timeline
            </h4>
            <p class="text-muted mt-2 mb-0">View the progress of each project phase</p>
        </div>

        <div class="card-body p-4">
            <div class="timeline">
                @forelse($project->timeline_phases as $index => $phase)
                    <div class="timeline-item {{ $loop->last ? 'timeline-item-last' : '' }}">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="timeline-date">
                                    <div class="fw-bold">{{ Carbon\Carbon::parse($phase->started_at)->format('M d, Y') }}</div>
                                    @if($phase->ended_at)
                                        <div class="small text-muted">
                                            to {{ Carbon\Carbon::parse($phase->ended_at)->format('M d, Y') }}
                                        </div>
                                    @else
                                        <span class="badge bg-success mt-2">Current Phase</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="timeline-content card border-0 bg-light">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <div>
                                                <h5 class="card-title mb-1">
                                                    Phase {{ $index + 1 }}: {{ ucfirst(str_replace('_', ' ', $phase->status)) }}
                                                </h5>
                                                @if($phase->description)
                                                    <p class="text-muted mb-0">{{ $phase->description }}</p>
                                                @endif
                                            </div>
                                            <span class="badge {{ $phase->ended_at ? 'bg-secondary' : 'bg-success' }} px-3 py-2 rounded-pill">
                                                {{ $phase->ended_at ? 'Completed' : 'In Progress' }}
                                            </span>
                                        </div>

                                        {{-- Phase Media Gallery --}}
                                        @if($phase->media->count() > 0)
                                            <div class="mt-4">
                                                <h6 class="mb-3">
                                                    <i class="fas fa-images me-2 text-primary"></i>
                                                    Phase Media
                                                </h6>
                                                <div class="row g-3">
                                                    @foreach($phase->media as $media)
                                                        <div class="col-md-4 col-lg-3">
                                                            <div class="media-card">
                                                                @if($media->file_type === 'image')
                                                                    <img src="{{ asset('storage/' . $media->file_path) }}"
                                                                         alt="Phase media"
                                                                         class="img-fluid rounded-3 w-100"
                                                                         style="height: 150px; object-fit: cover; cursor: pointer;"
                                                                         onclick="openMediaModal('{{ asset('storage/' . $media->file_path) }}', 'image')">
                                                                @else
                                                                    <video class="w-100 rounded-3"
                                                                           style="height: 150px; object-fit: cover; cursor: pointer;"
                                                                           onclick="openMediaModal('{{ asset('storage/' . $media->file_path) }}', 'video')">
                                                                        <source src="{{ asset('storage/' . $media->file_path) }}">
                                                                    </video>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <i class="fas fa-layer-group fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No phases have been created for this project yet.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- Media Modal (Read-only) --}}
<div class="modal fade" id="mediaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body p-0">
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                <div id="mediaContainer" class="text-center"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.timeline {
    position: relative;
    padding-left: 2rem;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 2px;
    background: linear-gradient(to bottom, #e9ecef 0%, #dee2e6 50%, #e9ecef 100%);
}

.timeline-item {
    position: relative;
    padding-bottom: 2rem;
}

.timeline-item::before {
    content: '';
    position: absolute;
    left: -2.1rem;
    top: 0;
    width: 1rem;
    height: 1rem;
    border-radius: 50%;
    background: #0d6efd;
    border: 3px solid white;
    box-shadow: 0 0 0 2px #0d6efd;
}

.timeline-item-last::before {
    background: #198754;
    box-shadow: 0 0 0 2px #198754;
}

.timeline-date {
    padding-right: 1rem;
    text-align: right;
}

.timeline-content {
    transition: transform 0.2s ease;
}

.timeline-content:hover {
    transform: translateX(5px);
}

@media (max-width: 768px) {
    .timeline {
        padding-left: 1rem;
    }

    .timeline-date {
        text-align: left;
        margin-bottom: 0.5rem;
    }

    .timeline-item::before {
        left: -1.6rem;
    }
}

.media-card {
    transition: transform 0.2s ease;
}

.media-card:hover {
    transform: scale(1.05);
}
</style>
@endpush

@push('scripts')
<script>
function openMediaModal(src, type) {
    const container = document.getElementById('mediaContainer');
    if (type === 'image') {
        container.innerHTML = `<img src="${src}" class="img-fluid rounded-3" style="max-height: 80vh;">`;
    } else {
        container.innerHTML = `
            <video class="w-100" controls style="max-height: 80vh;">
                <source src="${src}">
            </video>
        `;
    }
    new bootstrap.Modal(document.getElementById('mediaModal')).show();
}
</script>
@endpush
