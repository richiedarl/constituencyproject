@extends('layouts.app')

@section('title', 'All Candidates - Constituency Project')

@section('content')
<!-- Page Header with Gradient -->
<section class="page-header py-5" style="background: linear-gradient(135deg, #29a221 0%, #ffc107 100%);">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center text-white">
                <h1 class="display-4 fw-bold">All Candidates</h1>
                <p class="lead">Explore verified portfolios of candidates and their constituency projects</p>
            </div>
        </div>
    </div>
</section>

<!-- Candidates Grid Section -->
<section class="candidates-section py-5">
    <div class="container">
        <div class="row g-4">
            @forelse($candidates as $candidate)
                <div class="col-lg-4 col-md-6" data-aos="fade-up">
                    <div class="card candidate-card h-100 border-0 shadow-sm rounded-4 overflow-hidden"
                         style="transition: all 0.3s ease;"
                         onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 20px 30px rgba(41,162,33,0.2)';"
                         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 20px rgba(0,0,0,0.05)';">

                        <!-- Candidate Image -->
                        <div class="position-relative" style="height: 250px; overflow: hidden;">
                            <img src="{{ $candidate->photo ? asset('storage/'.$candidate->photo) : asset('images/avatar.png') }}"
                                 alt="{{ $candidate->name }}"
                                 class="w-100 h-100"
                                 style="object-fit: cover;">

                            <!-- Verified Badge for Approved Candidates -->
                            @if($candidate->approved)
                                <div class="position-absolute top-0 end-0 m-3">
                                    <span class="badge bg-success px-3 py-2 rounded-pill">
                                        <i class="bi bi-patch-check-fill me-1"></i> Verified
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- Candidate Info -->
                        <div class="card-body p-4">
                            <h3 class="fw-bold mb-2">{{ $candidate->name }}</h3>

                            @if($candidate->district || $candidate->state)
                                <p class="text-muted small mb-3">
                                    <i class="bi bi-geo-alt-fill me-1" style="color: #29a221;"></i>
                                    {{ $candidate->district ?? '' }} {{ $candidate->state ? ', ' . $candidate->state : '' }}
                                </p>
                            @endif

                            <!-- Stats -->
                            <div class="d-flex gap-3 mb-3">
                                <div class="text-center">
                                    <div class="small text-muted">Projects</div>
                                    <div class="fw-bold" style="color: #29a221;">{{ $candidate->projects_count ?? $candidate->projects->count() }}</div>
                                </div>
                                <div class="text-center">
                                    <div class="small text-muted">Since</div>
                                    <div class="fw-bold" style="color: #ffc107;">{{ $candidate->created_at->format('Y') }}</div>
                                </div>
                            </div>

                            <!-- Bio Preview -->
                            <p class="text-muted mb-4">{{ Str::limit($candidate->bio ?? 'No bio available', 100) }}</p>

                            <!-- Action Buttons -->
                            <div class="d-flex gap-2">
                                <a href="{{ route('candidate.public.show', $candidate->slug) }}"
                                   class="btn flex-fill py-2 rounded-3"
                                   style="border: 1px solid #29a221; color: #29a221; background: white; transition: all 0.3s ease;"
                                   onmouseover="this.style.background='#29a221'; this.style.color='white';"
                                   onmouseout="this.style.background='white'; this.style.color='#29a221';">
                                    View Profile
                                </a>
                                <a href="{{ route('candidate.report.preview', $candidate->slug) }}"
                                   class="btn flex-fill py-2 rounded-3"
                                   style="background: linear-gradient(135deg, #29a221 0%, #ffc107 100%); color: white; border: none;"
                                   onmouseover="this.style.transform='translateY(-2px)';"
                                   onmouseout="this.style.transform='translateY(0)';">
                                    View Report
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        No candidates found.
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-5">
            {{ $candidates->links() }}
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .candidate-card:hover img {
        transform: scale(1.1);
        transition: transform 0.5s ease;
    }
    .candidate-card img {
        transition: transform 0.5s ease;
    }
</style>
@endpush
