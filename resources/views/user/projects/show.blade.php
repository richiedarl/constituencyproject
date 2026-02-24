@extends('layouts.admin')
@section('content')

<div class="container py-5">

    {{-- HERO --}}
    <div class="p-5 rounded-4 shadow-lg mb-5 position-relative overflow-hidden"
         style="background: linear-gradient(135deg, #0f172a, #1e293b);">

        <div class="position-absolute top-0 end-0 opacity-10"
             style="font-size: 8rem; transform: rotate(-15deg);">
            <i class="fas fa-hard-hat text-white"></i>
        </div>

        <div class="position-relative text-white">
            <h1 class="fw-bold mb-3 display-6">{{ $project->title }}</h1>

            <div class="d-flex flex-wrap gap-3 align-items-center mb-3">
                <span class="badge px-3 py-2 {{ $project->getStatusBadgeClass() }}">
                    {{ ucfirst($project->status) }}
                </span>

                <span class="text-light opacity-75">
                    <i class="fas fa-map-marker-alt me-2"></i>
                    {{ $project->full_location ?: 'Location not specified' }}
                </span>

                <span class="text-light opacity-75">
                    <i class="fas fa-chart-line me-2"></i>
                    {{ $project->progress_percentage }}% Complete
                </span>
            </div>

            <div class="progress bg-dark bg-opacity-25" style="height: 6px;">
                <div class="progress-bar"
                     style="width: {{ $project->progress_percentage }}%;
                            background: linear-gradient(90deg, #22c55e, #16a34a);">
                </div>
            </div>
        </div>
    </div>


    {{-- DESCRIPTION --}}
    <div class="card border-0 shadow-sm rounded-4 mb-5">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-3">Project Overview</h5>
            <p class="text-muted mb-0" style="line-height: 1.8;">
                {{ $project->description }}
            </p>
        </div>
    </div>


    {{-- PHASES --}}
    <h4 class="fw-bold mb-4">Project Phases</h4>

    @foreach($project->timeline_phases as $index => $phase)

        <div class="card border-0 shadow-sm rounded-4 mb-4 phase-card">
            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <div>
                        <small class="text-muted text-uppercase">Phase {{ $index + 1 }}</small>
                        <h5 class="fw-bold mb-0">{{ ucfirst($phase->status) }}</h5>
                    </div>

                    <span class="badge
                        {{ $phase->status === 'completed' ? 'bg-success' :
                           ($phase->status === 'in_progress' ? 'bg-warning text-dark' :
                           'bg-secondary') }}">
                        {{ ucfirst($phase->status) }}
                    </span>
                </div>

                <p class="text-muted">{{ $phase->description }}</p>

                @if($phase->started_at)
                    <small class="text-muted d-block mb-3">
                        <i class="far fa-calendar-alt me-2"></i>
                        Started {{ $phase->started_at->format('M d, Y') }}
                    </small>
                @endif


                {{-- MEDIA GRID --}}
                @if($phase->media->count())
                    <div class="row g-3 mt-2">
                        @foreach($phase->media as $media)
                            <div class="col-lg-3 col-md-4 col-6">
                                <div class="media-wrapper">
                                    <img src="{{ $media->url }}"
                                         class="img-fluid rounded-3 shadow-sm">
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif


                {{-- UPLOAD (ONLY FOR LATEST PHASE + CONTRACTOR) --}}
                @php
                    $latestPhase = $project->current_phase;
                @endphp

                @if($latestPhase && $phase->id === $latestPhase->id && auth()->check() && auth()->user()->contractor)

                    <div class="mt-4 pt-3 border-top">

                        <form method="POST"
                              action="{{ route('projects.uploadMedia', $project->id) }}"
                              enctype="multipart/form-data">

                            @csrf

                            <div class="row g-3 align-items-end">
                                <div class="col-md-8">
                                    <label class="form-label small text-muted">
                                        Upload Progress Photos
                                    </label>
                                    <input type="file"
                                           name="media[]"
                                           multiple
                                           class="form-control form-control-lg"
                                           required>
                                </div>

                                <div class="col-md-4">
                                    <button class="btn btn-success btn-lg w-100 shadow-sm">
                                        <i class="fas fa-upload me-2"></i>
                                        Upload
                                    </button>
                                </div>
                            </div>

                        </form>

                    </div>

                @endif

            </div>
        </div>

    @endforeach

</div>


{{-- STYLES --}}
@push('styles')
<style>

.phase-card {
    transition: all 0.3s ease;
}

.phase-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 1.5rem 3rem rgba(0,0,0,.1) !important;
}

.media-wrapper {
    overflow: hidden;
    border-radius: 1rem;
}

.media-wrapper img {
    transition: transform 0.4s ease;
}

.media-wrapper:hover img {
    transform: scale(1.08);
}

</style>
@endpush

@endsection
