@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">

    {{-- Header Section --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-5">
        <div class="d-flex align-items-center mb-3 mb-md-0">
            <div class="position-relative">
                <img
                    src="{{ $candidate->photo ? asset('storage/'.$candidate->photo) : asset('images/avatar.png') }}"
                    class="rounded-circle border border-4 border-white shadow-sm"
                    width="80"
                    height="80"
                    alt="{{ $candidate->name }}"
                >
                @if($candidate->wallet && $candidate->wallet->balance > 0)
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success">
                    ₦{{ number_format(optional($candidate->wallet)->balance ?? 0) }}
                </span>
                @endif
            </div>
            <div class="ml-4">
                <h1 class="h3 font-weight-bold text-dark mb-1">{{ $candidate->name }}</h1>
                <div class="d-flex flex-wrap gap-2">
                    @if($candidate->district)
                    <span class="badge badge-light text-dark border">
                        <i class="fas fa-map-marker-alt fa-xs mr-1"></i>
                        {{ $candidate->district }}
                    </span>
                    @endif
                    @if($candidate->gender)
                    <span class="badge badge-light text-dark border">
                        <i class="fas fa-user fa-xs mr-1"></i>
                        {{ ucfirst($candidate->gender) }}
                    </span>
                    @endif
                </div>
            </div>
        </div>

        <div class="d-flex flex-column flex-sm-row gap-2">
            <button class="btn btn-success btn-lg shadow-sm" data-toggle="modal" data-target="#fundModal">
                <i class="fas fa-coins mr-2"></i>
                Fund Candidate
            </button>
            <a href="{{ route('admin.candidates.report', $candidate->id) }}"
               class="btn btn-outline-primary btn-lg shadow-sm">
                <i class="fas fa-chart-bar mr-2"></i>
                View Report
            </a>
        </div>
    </div>

    {{-- Bio Card --}}
    @if($candidate->bio)
    <div class="card mb-5 border-0 shadow-lg">
        <div class="card-body p-4">
            <div class="d-flex align-items-center mb-3">
                <div class="bg-primary rounded p-2 mr-3">
                    <i class="fas fa-user-circle fa-lg text-white"></i>
                </div>
                <h5 class="mb-0 font-weight-bold text-dark">Bio</h5>
            </div>
            <div class="pl-5">
                <p class="text-muted mb-0 lead">{{ $candidate->bio }}</p>
            </div>
        </div>
    </div>
    @endif

    {{-- Wallet Summary --}}
    <div class="row mb-5">
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="text-uppercase text-muted small font-weight-bold mb-2">Wallet Balance</h6>
                            <h2 class="font-weight-bold text-success mb-0">
                                ₦{{ number_format(optional($candidate->wallet)->balance ?? 0) }}
                            </h2>
                        </div>
                        <div class="bg-success rounded-circle p-3">
                            <i class="fas fa-wallet fa-2x text-white"></i>
                        </div>
                    </div>
                    <div class="mt-4">
                        <small class="text-muted">
                            <i class="fas fa-info-circle mr-1"></i>
                            Total funds allocated to this candidate
                        </small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="text-uppercase text-muted small font-weight-bold mb-2">Total Projects</h6>
                            <h2 class="font-weight-bold text-primary mb-0">{{ $projects->count() }}</h2>
                        </div>
                        <div class="bg-primary rounded-circle p-3">
                            <i class="fas fa-project-diagram fa-2x text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="text-uppercase text-muted small font-weight-bold mb-2">Active Projects</h6>
                            <h2 class="font-weight-bold text-info mb-0">
                                {{ $activeProjectsCount }}
                            </h2>

                        </div>
                        <div class="bg-info rounded-circle p-3">
                            <i class="fas fa-tasks fa-2x text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Projects Section --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="font-weight-bold text-dark">
            <i class="fas fa-list-ul mr-2 text-primary"></i>
            Projects Overview
        </h3>
        <span class="badge badge-primary badge-pill py-2 px-3">
            {{ $projects->count() }} Projects
        </span>
    </div>

    @forelse($projects as $project)
    <div class="card border-0 shadow-lg mb-4 overflow-hidden">
        {{-- Project Header --}}
        <div class="card-header bg-white border-bottom-0 pb-0">
            <div class="d-flex justify-content-between align-items-start">
                <div class="flex-grow-1">
                    <div class="d-flex align-items-center mb-2">
                        <h4 class="font-weight-bold text-dark mb-0">{{ $project->title }}</h4>
                        <span class="badge {{ $project->status == 'completed' ? 'badge-success' : 'badge-warning' }} ml-3">
                            {{ ucfirst($project->status ?? 'In Progress') }}
                        </span>
                    </div>
                    <div class="d-flex flex-wrap gap-3">
                        <small class="text-muted">
                            <i class="fas fa-calendar-alt mr-1"></i>
                            Started: {{ optional($project->created_at)->format('d M Y') }}
                        </small>
                        @if($project->location)
                        <small class="text-muted">
                            <i class="fas fa-map-pin mr-1"></i>
                            {{ $project->location }}
                        </small>
                        @endif
                    </div>
                </div>
                <div class="text-right" style="min-width: 200px;">
                    <small class="text-muted d-block mb-1">Progress</small>
                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar bg-gradient-primary" role="progressbar"
                             style="width: {{ $project->progress }}%">
                        </div>
                    </div>
                    <small class="text-muted">{{ $project->progress }}% Complete</small>
                </div>
            </div>
        </div>

        <div class="card-body">
            {{-- Project Images Preview --}}
            @php
                $projectImages = collect();
                foreach($project->phases as $phase) {
                    $projectImages = $projectImages->merge($phase->media->take(4));
                }
                $projectImages = $projectImages->take(4);
            @endphp

            @if($projectImages->count())
            <div class="mb-4">
                <h6 class="font-weight-bold text-dark mb-3">
                    <i class="fas fa-images mr-2 text-info"></i>
                    Project Media
                </h6>
                <div class="row">
                    @foreach($projectImages as $image)
                    <div class="col-md-3 col-6 mb-3">
                        <div class="position-relative rounded overflow-hidden shadow-sm" style="height: 150px;">
                            <img src="{{ asset('storage/'.$image->file_path) }}"
                                 class="img-fluid w-100 h-100"
                                 style="object-fit: cover;"
                                 alt="Project Image">
                            <div class="position-absolute top-0 end-0 bg-dark bg-opacity-50 text-white p-1 small">
                                {{ $image->file_type }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Phases Section --}}
            @if($project->phases->count())
            <div class="mt-4">
                <h6 class="font-weight-bold text-dark mb-3">
                    <i class="fas fa-layer-group mr-2 text-success"></i>
                    Project Phases
                </h6>
                <div class="row">
                    @foreach($project->phases as $phase)
                    <div class="col-md-6 mb-3">
                        <div class="card border h-100">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="font-weight-bold text-dark mb-0">{{ $phase->title }}</h6>
                                    <span class="badge-secondary">
                                        {{ $phase->status }}
                                    </span>
                                </div>

                                @if($phase->description)
                                <p class="text-muted small mb-3">{{ Str::limit($phase->description, 100) }}</p>
                                @endif

                                {{-- Phase Images --}}
                                @if($phase->media->count())
                                <div class="mt-3">
                                    <small class="text-muted d-block mb-2">
                                        <i class="fas fa-camera mr-1"></i>
                                        {{ $phase->media->count() }} media files
                                    </small>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($phase->media->take(3) as $image)
                                        <a href="{{ asset('storage/'.$image->file_path) }}"
                                           target="_blank"
                                           class="position-relative"
                                           style="width: 60px; height: 60px;">
                                            <img src="{{ asset('storage/'.$image->file_path) }}"
                                                 class="img-fluid rounded border"
                                                 style="width: 100%; height: 100%; object-fit: cover;"
                                                 alt="Phase Image">
                                        </a>
                                        @endforeach
                                        @if($phase->media->count() > 3)
                                        <div class="position-relative bg-light rounded border d-flex align-items-center justify-content-center"
                                             style="width: 60px; height: 60px;">
                                            <span class="text-muted font-weight-bold">
                                                +{{ $phase->media->count() - 3 }}
                                            </span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Project Actions --}}
            <div class="mt-4 pt-3 border-top">
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.projects.show', $project->id) }}"
                       class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-eye mr-1"></i>
                        View Details
                    </a>
                    <a href="{{ route('admin.projects.edit', $project->id) }}"
                       class="btn btn-outline-info btn-sm">
                        <i class="fas fa-edit mr-1"></i>
                        Edit
                    </a>
                    @if($project->status != 'completed')
                    <button class="btn btn-outline-success btn-sm">
                        <i class="fas fa-check-circle mr-1"></i>
                        Mark Complete
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="card border-0 shadow-lg">
        <div class="card-body text-center py-5">
            <div class="mb-4">
                <i class="fas fa-project-diagram fa-4x text-muted"></i>
            </div>
            <h4 class="text-muted mb-3">No Projects Found</h4>
            <p class="text-muted mb-4">This candidate doesn't have any projects yet.</p>
            <a href="{{ route('admin.projects.create') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-plus mr-2"></i>
                Create New Project
            </a>
        </div>
    </div>
    @endforelse
</div>

{{-- Fund Modal --}}
<div class="modal fade" id="fundModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('admin.candidates.fund', $candidate->id) }}" class="modal-content border-0 shadow-lg">
            @csrf
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-coins mr-2"></i>
                    Fund Candidate
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div class="text-center mb-4">
                    <div class="bg-light rounded-circle d-inline-flex p-4 mb-3">
                        <i class="fas fa-hand-holding-usd fa-3x text-primary"></i>
                    </div>
                    <h5 class="font-weight-bold">Add Funds to {{ $candidate->name }}</h5>
                    <p class="text-muted small">Current Balance: ₦{{ number_format(optional($candidate->wallet)->balance ?? 0) }}</p>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold text-dark mb-2">Amount (₦)</label>
                    <div class="input-group input-group-lg">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-light border-right-0">
                                <i class="fas fa-naira-sign text-muted"></i>
                            </span>
                        </div>
                        <input type="number"
                               name="amount"
                               class="form-control border-left-0"
                               min="1"
                               step="1000"
                               placeholder="Enter amount"
                               required>
                    </div>
                    <small class="text-muted mt-2 d-block">
                        <i class="fas fa-info-circle mr-1"></i>
                        Minimum amount: ₦1,000
                    </small>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-light btn-lg" data-dismiss="modal">
                    Cancel
                </button>
                <button type="submit" class="btn btn-success btn-lg px-4">
                    <i class="fas fa-check mr-2"></i>
                    Confirm Fund
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('styles')
<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
.progress {
    border-radius: 10px;
    overflow: hidden;
}
.progress-bar {
    border-radius: 10px;
}
.card {
    border-radius: 15px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
}
.border-0 {
    border: 0 !important;
}
.rounded-circle {
    border-radius: 50% !important;
}
.bg-opacity-50 {
    opacity: 0.5;
}
</style>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Add hover effect to project cards
    $('.card').hover(
        function() {
            $(this).find('.card-header').css('background', 'linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%)');
        },
        function() {
            $(this).find('.card-header').css('background', '#fff');
        }
    );
});
</script>
@endsection
