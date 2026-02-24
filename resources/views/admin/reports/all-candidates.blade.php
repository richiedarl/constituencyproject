@extends('layouts.admin')

@section('title', 'All Candidates')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col">
            <h1 class="h2">All Candidates</h1>
            <p class="text-muted">Browse all candidates and their projects</p>
        </div>
    </div>

    <!-- Candidates Grid -->
    <div class="row g-4">
        @forelse($candidates as $candidate)
            <div class="col-md-6 col-lg-4">
                <div class="card shadow h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-3">
                                <div class="rounded-circle bg-light overflow-hidden" style="width: 60px; height: 60px;">
                                    <img src="{{ $candidate->photo ? asset('storage/'.$candidate->photo) : asset('images/avatar.png') }}"
                                         class="w-100 h-100" style="object-fit: cover;">
                                </div>
                            </div>
                            <div>
                                <h5 class="mb-1">{{ $candidate->name }}</h5>
                                <small class="text-muted">
                                    <i class="fas fa-map-marker-alt me-1"></i>
                                    {{ $candidate->district ?? 'N/A' }}
                                </small>
                            </div>
                        </div>

                        <div class="row text-center mb-3">
                            <div class="col-4">
                                <div class="small text-muted">Projects</div>
                                <div class="h5 mb-0">{{ $candidate->projects_count }}</div>
                            </div>
                            <div class="col-4">
                                <div class="small text-muted">Phases</div>
                                <div class="h5 mb-0">{{ $candidate->projects->sum('phases.count') }}</div>
                            </div>
                            <div class="col-4">
                                <div class="small text-muted">Updates</div>
                                <div class="h5 mb-0">{{ $candidate->projects->sum('phases.sum.updates.count') }}</div>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="{{ route('candidate.report', $candidate->id) }}" class="btn btn-sm btn-primary flex-fill">
                                <i class="fas fa-file-alt me-1"></i> View Report
                            </a>
                            <a href="{{ route('generatekey') }}?candidate_id={{ $candidate->id }}" class="btn btn-sm btn-warning flex-fill">
                                <i class="fas fa-key me-1"></i> Generate Key
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center py-5">
                    <i class="fas fa-users fa-3x mb-3"></i>
                    <h4>No Candidates Found</h4>
                    <p>There are no approved candidates yet.</p>
                </div>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $candidates->links() }}
    </div>
</div>
@endsection
