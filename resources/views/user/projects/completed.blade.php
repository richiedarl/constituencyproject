@extends('layouts.admin')

@section('title', 'Completed Projects')

@section('content')
<div class="container py-5">

    <div class="mb-5">
        <h2 class="fw-bold mb-1">Completed Projects</h2>
        <p class="text-muted mb-0">
            Successfully executed and finalized projects
        </p>
    </div>

    @forelse($projects as $project)

        <div class="card border-0 shadow-lg rounded-4 mb-5 overflow-hidden">

            {{-- Project Header --}}
            <div class="bg-dark text-white p-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <h4 class="fw-bold mb-1">{{ $project->title }}</h4>
                        <small class="text-light">
                            <i class="fas fa-map-marker-alt me-1"></i>
                            {{ $project->full_location ?? 'Location not specified' }}
                        </small>
                        <div class="mt-2">
                            <small>
                                <i class="far fa-calendar-alt me-1"></i>
                                {{ $project->created_at->format('M d, Y') }}
                            </small>
                        </div>
                    </div>

                    <span class="badge bg-success px-4 py-2 fs-6">
                        <i class="fas fa-check-circle me-1"></i>
                        Completed
                    </span>
                </div>

                <div class="mt-4">
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-success"
                             style="width: 100%">
                        </div>
                    </div>
                    <small class="text-light">
                        100% Project Completed
                    </small>
                </div>
            </div>

            {{-- Project Body --}}
            <div class="card-body p-5">

                <p class="text-muted mb-5">
                    {{ $project->description }}
                </p>

                <h5 class="fw-bold mb-4">Project Timeline</h5>

                <div class="timeline">

                    @foreach($project->timeline_phases->sortBy('started_at') as $phase)

                        <div class="timeline-item">

                            <div class="timeline-marker"></div>

                            <div class="timeline-content">

                                <h6 class="fw-bold text-capitalize">
                                    {{ $phase->status }}
                                </h6>

                                <small class="text-muted d-block mb-2">
                                    {{ optional($phase->started_at)->format('M d, Y') }}
                                </small>

                                <p class="text-muted">
                                    {{ $phase->description }}
                                </p>

                                {{-- Phase Media --}}
                                @if($phase->media->count())
                                    <div class="row g-3 mt-2">
                                        @foreach($phase->media as $media)
                                            <div class="col-lg-3 col-md-4 col-6">
                                                <div class="media-wrapper">
                                                    <img src="{{ $media->url }}"
                                                         class="img-fluid rounded-3 shadow-sm phase-image">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                            </div>

                        </div>

                    @endforeach

                </div>

            </div>

        </div>

    @empty

        <div class="text-center py-5">
            <i class="fas fa-check-circle fa-3x text-muted mb-3"></i>
            <h5 class="fw-bold">No Completed Projects</h5>
            <p class="text-muted mb-0">
                You do not have any completed projects yet.
            </p>
        </div>

    @endforelse

</div>
@endsection


@push('styles')
<style>

/* Timeline Container */
.timeline {
    position: relative;
    padding-left: 40px;
}

/* Vertical Line */
.timeline::before {
    content: '';
    position: absolute;
    top: 0;
    left: 18px;
    width: 3px;
    height: 100%;
    background: #dee2e6;
}

/* Timeline Item */
.timeline-item {
    position: relative;
    margin-bottom: 50px;
}

/* Marker */
.timeline-marker {
    position: absolute;
    left: -22px;
    top: 5px;
    width: 16px;
    height: 16px;
    background: #198754;
    border-radius: 50%;
    border: 3px solid white;
    box-shadow: 0 0 0 3px #19875430;
}

/* Content */
.timeline-content {
    background: #f8f9fa;
    padding: 25px;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.timeline-content:hover {
    transform: translateY(-4px);
    box-shadow: 0 1rem 2rem rgba(0,0,0,.08);
}

/* Images */
.media-wrapper {
    overflow: hidden;
    border-radius: 10px;
}

.phase-image {
    transition: transform 0.4s ease;
}

.phase-image:hover {
    transform: scale(1.08);
}

</style>
@endpush
