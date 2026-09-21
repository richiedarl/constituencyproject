@extends('layouts.app')

@section('title', 'All Projects - Constituency Project')

@section('content')
<!-- Page Header -->
<section class="page-header py-5" style="background: #063D22;">
    <div class="container text-center text-white">
        <h1 class="display-4 fw-bold">All Projects</h1>
        <p class="lead">Browse documented constituency projects, progress updates, and available evidence.</p>
    </div>
</section>

<!-- Projects Grid -->
<section class="projects-section py-5">
    <div class="container">
        <form method="GET" action="{{ route('projects.index') }}" class="row g-3 align-items-end mb-5" aria-label="Filter projects">
            <div class="col-lg-5">
                <label for="project-search" class="form-label fw-semibold">Search projects</label>
                <input type="search" id="project-search" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by title, location, or description">
            </div>
            <div class="col-lg-3 col-md-6">
                <label for="project-state" class="form-label fw-semibold">State</label>
                <select id="project-state" name="state" class="form-select">
                    <option value="">All states</option>
                    @foreach($states as $state)
                        <option value="{{ $state }}" @selected(request('state') === $state)>{{ $state }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-2 col-md-6">
                <label for="project-status" class="form-label fw-semibold">Status</label>
                <select id="project-status" name="status" class="form-select">
                    <option value="">All statuses</option>
                    @foreach(['planning', 'ongoing', 'completed'] as $status)
                        <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-2">
                <button type="submit" class="btn w-100" style="background: #075A2A; color: white;">Filter projects</button>
            </div>
        </form>

        @if(request()->hasAny(['search', 'state', 'status']))
            <div class="d-flex justify-content-between align-items-center mb-4">
                <p class="mb-0 text-muted">{{ $projects->count() }} project{{ $projects->count() === 1 ? '' : 's' }} found</p>
                <a href="{{ route('projects.index') }}" class="small">Clear filters</a>
            </div>
        @endif

        <div class="row g-4">
            @forelse($projects as $project)
                <div class="col-lg-4 col-md-6">
                    <div class="card project-card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <img src="{{ $project->featured_image ? asset('storage/'.$project->featured_image) : asset('fe/assets/img/about/community-led.jpg') }}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="{{ $project->title }}">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">{{ $project->title }}</h5>
                            <p class="small text-muted">
                                <i class="bi bi-geo-alt-fill me-1" style="color: #29a221;"></i>
                                {{ $project->full_location }}
                            </p>
                            <p class="card-text text-muted small">{{ Str::limit($project->short_description, 100) }}</p>

                            <!-- Progress -->
                            <div class="progress mb-2" style="height: 6px;">
                                <div class="progress-bar bg-success" style="width: {{ $project->progress_percentage }}%"></div>
                            </div>

                            <!-- Candidate Info -->
                            <p class="small mb-3">
                                <i class="bi bi-person-circle me-1" style="color: #ffc107;"></i>
                                {{ $project->candidate->name ?? 'Unknown' }}
                            </p>

                            <!-- Action Buttons -->
                            <div class="d-flex gap-2">
                                <a href="{{ route('project.public.show', $project->slug) }}" class="btn flex-fill" style="border: 1px solid #29a221; color: #29a221;">
                                    View Details
                                </a>
                                <a href="{{ route('contributor.project.apply', $project->id) }}" class="btn flex-fill" style="background: #075A2A; color: white;">
                                    Support
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="border rounded-3 p-5 bg-light">
                        <i class="bi bi-search display-6 text-muted" aria-hidden="true"></i>
                        <h2 class="h4 mt-3">No projects match these filters</h2>
                        <p class="text-muted mb-0">Try a different search term or clear the filters to browse the full directory.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-5">
            {{ $projects->links() }}
        </div>
    </div>
</section>
@endsection
