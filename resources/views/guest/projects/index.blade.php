@extends('layouts.app')

@section('title', 'All Projects - Constituency Project')

@section('content')
<!-- Page Header -->
<section class="page-header py-5" style="background: linear-gradient(135deg, #29a221 0%, #ffc107 100%);">
    <div class="container text-center text-white">
        <h1 class="display-4 fw-bold">All Projects</h1>
        <p class="lead">Browse and support verified constituency projects</p>
    </div>
</section>

<!-- Projects Grid -->
<section class="projects-section py-5">
    <div class="container">
        <div class="row g-4">
            @forelse($projects as $project)
                <div class="col-lg-4 col-md-6">
                    <div class="card project-card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <img src="{{ asset('storage/'.$project->featured_image) }}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="{{ $project->title }}">
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
                                <a href="{{ route('user.projects.show', $project->slug) }}" class="btn flex-fill" style="border: 1px solid #29a221; color: #29a221;">
                                    View Details
                                </a>
                                <a href="{{ route('contributor.project.apply', $project->id) }}" class="btn flex-fill" style="background: linear-gradient(135deg, #29a221 0%, #ffc107 100%); color: white;">
                                    Support
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="alert alert-info">No projects available.</div>
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
