@extends('layouts.app')

@section('title', $candidate->name . ' - Candidate Report')

@section('content')
<!-- Report Header -->
<section class="report-header py-4" style="background: linear-gradient(135deg, #29a221 0%, #ffc107 100%);">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="text-white mb-0">Candidate Report</h1>
            <button onclick="window.print()" class="btn btn-light">
                <i class="bi bi-printer"></i> Print Report
            </button>
        </div>
    </div>
</section>

<!-- Report Content -->
<section class="report-content py-5">
    <div class="container">
        <!-- Candidate Info -->
        <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
            <div class="row">
                <div class="col-md-3 text-center">
                    <img src="{{ $candidate->photo ? asset('storage/'.$candidate->photo) : asset('images/avatar.png') }}"
                         class="rounded-circle img-fluid" style="width: 150px; height: 150px; object-fit: cover;">
                </div>
                <div class="col-md-9">
                    <h2 class="fw-bold">{{ $candidate->name }}</h2>
                    <p class="text-muted">{{ $candidate->email }} | {{ $candidate->phone }}</p>
                    <p><i class="bi bi-geo-alt-fill me-1" style="color: #29a221;"></i> {{ $candidate->district }}, {{ $candidate->state }}</p>
                    <p>{{ $candidate->bio }}</p>
                </div>
            </div>
        </div>

        <!-- Projects -->
        @foreach($candidate->projects as $project)
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                <h3 class="fw-bold mb-3">{{ $project->title }}</h3>
                <p class="text-muted mb-3">{{ $project->full_location }}</p>

                @foreach($project->phases as $phase)
                    <div class="phase-section mb-4 p-3" style="background: rgba(41, 162, 33, 0.05); border-radius: 10px;">
                        <h5>{{ $phase->name }}</h5>

                        <!-- Phase Media -->
                        @if($phase->media->count() > 0)
                            <div class="row g-2 mb-3">
                                @foreach($phase->media as $media)
                                    <div class="col-md-3 col-4">
                                        <img src="{{ asset('storage/'.$media->file_path) }}" class="img-fluid rounded-3">
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <!-- Phase Updates -->
                        @if($phase->updates->count() > 0)
                            <div class="updates">
                                <h6 class="fw-bold">Daily Updates</h6>
                                @foreach($phase->updates as $update)
                                    <div class="update-item p-3 bg-white rounded-3 mb-2">
                                        <small class="text-muted">{{ $update->created_at->format('M d, Y') }}</small>
                                        <p class="mb-0">{{ $update->comment }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</section>
@endsection

@push('styles')
<style>
    @media print {
        .btn, .page-header, footer {
            display: none !important;
        }
        .card {
            border: 1px solid #ddd !important;
            box-shadow: none !important;
        }
    }
</style>
@endpush
