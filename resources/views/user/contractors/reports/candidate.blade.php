@extends('layouts.admin')

@section('title', 'Candidate Report - ' . $candidate->name)

@section('content')
<div class="container-fluid py-4">
    {{-- Header with Print Button --}}
    <div class="row mb-4">
        <div class="col">
            <h1 class="h2">Candidate Report</h1>
            <p class="text-muted">Generated on {{ now()->format('F d, Y') }}</p>
        </div>
        <div class="col text-end">
            <button onclick="window.print()" class="btn btn-primary">
                <i class="fas fa-print me-2"></i>Print Report
            </button>
            <a href="{{ route('admin.candidates.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back
            </a>
        </div>
    </div>

    {{-- Candidate Info Card --}}
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-2 text-center">
                    @if($candidate->photo)
                        <img src="{{ asset('storage/' . $candidate->photo) }}"
                             class="rounded-circle img-fluid" style="width: 120px; height: 120px; object-fit: cover;">
                    @else
                        <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto"
                             style="width: 120px; height: 120px;">
                            <i class="fas fa-user fa-4x"></i>
                        </div>
                    @endif
                </div>
                <div class="col-md-10">
                    <h3>{{ $candidate->name }}</h3>
                    <p class="text-muted mb-2">{{ $candidate->email }} | {{ $candidate->phone }}</p>
                    <p class="mb-2"><strong>District:</strong> {{ $candidate->district }}, {{ $candidate->state }}</p>
                    <p class="mb-0"><strong>Bio:</strong> {{ $candidate->bio }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Projects --}}
    @forelse($candidate->projects as $project)
        <div class="card shadow mb-4">
            <div class="card-header bg-white py-3">
                <h4 class="mb-0">{{ $project->title }}</h4>
                <span class="badge bg-{{ $project->status === 'completed' ? 'success' : 'primary' }}">
                    {{ ucfirst($project->status) }}
                </span>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>Location:</strong> {{ $project->full_location }}</p>
                        <p><strong>Budget:</strong> ₦{{ number_format($project->estimated_budget ?? 0) }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Start Date:</strong> {{ $project->start_date ? $project->start_date->format('M d, Y') : 'N/A' }}</p>
                        <p><strong>Completion:</strong> {{ $project->completion_date ? $project->completion_date->format('M d, Y') : 'N/A' }}</p>
                    </div>
                </div>

                {{-- Phases --}}
                @foreach($project->phases as $phase)
                    <div class="card border mb-3">
                        <div class="card-header bg-light py-2">
                            <h5 class="mb-0">{{ $phase->name }}</h5>
                        </div>
                        <div class="card-body">
                            {{-- Phase Media --}}
                            @if($phase->media->count() > 0)
                                <h6>Project Media:</h6>
                                <div class="row mb-3">
                                    @foreach($phase->media as $media)
                                        <div class="col-md-3 col-4 mb-2">
                                            <img src="{{ asset('storage/' . $media->file_path) }}"
                                                 class="img-fluid rounded" style="height: 100px; width: 100%; object-fit: cover;">
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            {{-- Phase Updates --}}
                            @if($phase->updates->count() > 0)
                                <h6>Daily Updates:</h6>
                                @foreach($phase->updates as $update)
                                    <div class="border-start border-4 border-primary ps-3 mb-3">
                                        <small class="text-primary">{{ $update->created_at->format('M d, Y') }}</small>
                                        <p class="mb-1">{{ $update->comment }}</p>

                                        @if($update->photos->count() > 0)
                                            <div class="row mt-2">
                                                @foreach($update->photos as $photo)
                                                    <div class="col-md-2 col-3">
                                                        <img src="{{ asset('storage/' . $photo->file_path) }}"
                                                             class="img-fluid rounded" style="height: 50px; width: 100%; object-fit: cover;">
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @empty
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>
            No projects found for this candidate.
        </div>
    @endforelse
</div>
@endsection

@push('styles')
<style>
@media print {
    .btn, .sidebar, footer, nav {
        display: none !important;
    }
    .card {
        box-shadow: none !important;
        border: 1px solid #ddd;
    }
}
</style>
@endpush
