@extends('layouts.admin')

@section('title', 'Active Projects')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-play-circle text-success"></i> Active Projects
        </h1>
        <a href="{{ route('admin.projects.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> New Project
        </a>
    </div>

    <!-- Active Projects Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Currently Running Projects
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Project</th>
                            <th>Candidate</th>
                            <th>Progress</th>
                            <th>Start Date</th>
                            <th>Est. Completion</th>
                            <th>Budget</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($projects as $project)
                        <tr>
                            <td>
                                <div>
                                    <strong>{{ Str::limit($project->title, 40) }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $project->type }}</small>
                                </div>
                            </td>
                            <td>
                                @if($project->candidate)
                                    {{ $project->candidate->name }}
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>
                                <div class="progress" style="height: 20px;">
                                    <div class="progress-bar" role="progressbar"
                                         style="width: {{ $project->progress_percentage }}%"
                                         aria-valuenow="{{ $project->progress_percentage }}"
                                         aria-valuemin="0" aria-valuemax="100">
                                        {{ $project->progress_percentage }}%
                                    </div>
                                </div>
                            </td>
                            <td>{{ $project->start_date?->format('M d, Y') ?? 'N/A' }}</td>
                            <td>
                                @if($project->completion_date)
                                    {{ $project->completion_date->format('M d, Y') }}
                                @else
                                    <span class="text-muted">Not set</span>
                                @endif
                            </td>
                            <td>₦{{ number_format($project->estimated_budget ?? 0) }}</td>
                            <td>
                                <a href="{{ route('admin.projects.show', $project) }}"
                                   class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.projects.edit', $project) }}"
                                   class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <p class="text-muted">No active projects found.</p>
                                <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Create New Project
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $projects->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
