@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Profile</h5>
                </div>
                <div class="card-body text-center">
                    @if($candidate->photo)
                        <img src="{{ asset('storage/' . $candidate->photo) }}"
                             alt="{{ $candidate->name }}"
                             class="rounded-circle mb-3"
                             style="width: 150px; height: 150px; object-fit: cover;">
                    @else
                        <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                             style="width: 150px; height: 150px; font-size: 3rem;">
                            {{ substr($candidate->name, 0, 1) }}
                        </div>
                    @endif

                    <h5>{{ $candidate->name }}</h5>
                    <p class="text-muted">{{ $candidate->email }}</p>

                    <a href="{{ route('candidates.edit', $candidate->id) }}" class="btn btn-outline-primary btn-sm">
                        Edit Profile
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <!-- Applications Status -->
            <div class="card shadow mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Application Status</h5>
                </div>
                <div class="card-body">
                    @if($applications->isEmpty())
                        <p class="text-muted">You haven't submitted any applications yet.</p>
                        <a href="{{ route('candidates.projects.create', $candidate->id) }}" class="btn btn-success">
                            Start New Application
                        </a>
                    @else
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Project</th>
                                        <th>Status</th>
                                        <th>Submitted</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($applications as $application)
                                        <tr>
                                            <td>{{ $application->project->title }}</td>
                                            <td>
                                                @if($application->status == 'approved')
                                                    <span class="badge bg-success">Approved</span>
                                                @elseif($application->status == 'rejected')
                                                    <span class="badge bg-danger">Rejected</span>
                                                @elseif($application->status == 'pending')
                                                    <span class="badge bg-warning">Pending Review</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ $application->status }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $application->created_at->format('M d, Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <!-- My Projects -->
            @if($projects->isNotEmpty())
                <div class="card shadow">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">My Projects</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($projects as $project)
                                <div class="col-md-6 mb-3">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h6>{{ $project->title }}</h6>
                                            <p class="small text-muted">{{ $project->short_description }}</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="badge bg-{{ $project->status == 'completed' ? 'success' : 'primary' }}">
                                                    {{ ucfirst($project->status) }}
                                                </span>
                                                <small>₦{{ number_format($project->estimated_budget) }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
