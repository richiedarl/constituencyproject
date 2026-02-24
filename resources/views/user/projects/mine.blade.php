@extends('layouts.admin')

@section('title', 'Past Projects')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Past Projects</h2>
            <p class="text-muted mb-0">Rejected or cancelled projects</p>
        
        </div>
    </div>

    <div class="row">
        @forelse($projects as $project)

            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card border-0 shadow-sm h-100 project-card">

                    <div class="card-body d-flex flex-column">

                        <div class="d-flex justify-content-between mb-2">
                            <h5 class="fw-bold mb-0">{{ $project->title }}</h5>

                            <span class="badge bg-{{
                                $project->status === 'completed' ? 'success' :
                                ($project->status === 'approved' ? 'primary' :
                                ($project->status === 'rejected' ? 'danger' :
                                ($project->status === 'cancelled' ? 'secondary' : 'warning')))
                            }}">
                                {{ ucfirst($project->status) }}
                            </span>
                        </div>

                        <p class="text-muted small mb-2">
                            <i class="fas fa-map-marker-alt me-1"></i>
                            {{ $project->full_location ?? 'Location not specified' }}
                        </p>

                        <p class="text-muted flex-grow-1">
                            {{ Str::limit($project->description, 100) }}
                        </p>

                        <div class="mt-3">
                            <div class="progress mb-2" style="height: 6px;">
                                <div class="progress-bar"
                                     style="width: {{ $project->progress_percentage }}%">
                                </div>
                            </div>

                            <small class="text-muted">
                                {{ $project->progress_percentage }}% completed
                            </small>
                        </div>

                        <div class="mt-3 d-flex justify-content-between align-items-center">

                            <small class="text-muted">
                                {{ $project->created_at->format('M d, Y') }}
                            </small>

                            <a href="{{ route('user.projects.show', $project) }}"
                               class="btn btn-sm btn-outline-dark">
                                View
                            </a>
                        </div>

                    </div>
                </div>
            </div>

        @empty

            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                    <h5 class="fw-bold">No Projects Found</h5>
                    <p class="text-muted mb-0">
                        You do not have any projects in this category.
                    </p>
                </div>
            </div>

        @endforelse
    </div>

</div>
@endsection

@push('styles')
<style>
.project-card {
    transition: all 0.25s ease;
    border-radius: 12px;
}
.project-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.08);
}
</style>
@endpush
