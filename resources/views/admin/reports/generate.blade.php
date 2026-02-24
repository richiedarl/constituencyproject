@extends('layouts.admin')

@section('title', 'Generate Report')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col">
            <h1 class="h2">Generate Candidate Report</h1>
            <p class="text-muted">Select a candidate to generate their full report</p>
        </div>
    </div>

    <div class="row">
        @foreach($candidates as $candidate)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card shadow h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0">
                                <div class="rounded-circle bg-light overflow-hidden" style="width: 50px; height: 50px;">
                                    <img src="{{ $candidate->photo ? asset('storage/'.$candidate->photo) : asset('images/avatar.png') }}"
                                         class="w-100 h-100" style="object-fit: cover;">
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="mb-0">{{ $candidate->name }}</h5>
                                <small class="text-muted">{{ $candidate->projects_count ?? $candidate->projects->count() }} projects</small>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.reports.candidate', $candidate->id) }}" class="btn btn-primary">
                                <i class="fas fa-file-pdf me-2"></i>Generate Full Report
                            </a>
                            <a href="{{ route('guest.reports.preview', $candidate->slug) }}" class="btn btn-outline-secondary" target="_blank">
                                <i class="fas fa-eye me-2"></i>Preview Public View
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
