@extends('layouts.app')

@section('title', 'Contributors Honour Roll | Constituency Project')

@section('content')
<!-- Page Header -->
<section class="page-header bg-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-3">Contributors Honour Roll</h1>
                <p class="lead mb-0">
                    Recognising citizens who are driving transparent development
                    through financial contributions to public projects.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                <div class="stats-badge bg-white bg-opacity-20 rounded-3 p-3 d-inline-block">
                    <span class="d-block text-white-50 small">Total Contributors</span>
                    <span class="display-6 text-white fw-bold">{{ $contributors->total() }}</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contributors Grid -->
<section class="contributors-grid py-5">
    <div class="container">
        <div class="row g-4">
            @forelse($contributors as $contributor)
                @php
                    $totalDonated = $contributor->donations_sum_amount ?? 0;
                    $photoUrl = $contributor->photo
                        ? asset('storage/'.$contributor->photo)
                        : asset('images/avatar.png');
                @endphp

                <div class="col-lg-4 col-md-6">
                    <div class="contributor-card bg-white rounded-4 shadow-sm h-100 p-4 text-center position-relative">

                        <!-- Rank Indicator -->
                        <div class="position-absolute top-0 end-0 mt-3 me-3">
                            <span class="badge bg-light text-dark rounded-pill px-3 py-2">
                                <i class="bi bi-trophy-fill text-warning me-1"></i>
                                Rank #{{ $loop->iteration + ($contributors->currentPage() - 1) * $contributors->perPage() }}
                            </span>
                        </div>

                        <!-- Avatar -->
                        <div class="avatar-wrapper mx-auto mb-3">
                            <div class="rounded-circle border border-3 border-primary border-opacity-25 p-1 d-inline-block">
                                <div class="rounded-circle overflow-hidden" style="width: 100px; height: 100px;">
                                    <img src="{{ $photoUrl }}"
                                         alt="{{ $contributor->name }}"
                                         class="w-100 h-100 object-fit-cover"
                                         loading="lazy">
                                </div>
                            </div>
                        </div>

                        <!-- Name -->
                        <h4 class="fw-bold mb-1">{{ $contributor->name }}</h4>

                        <!-- Location -->
                        @if($contributor->district || $contributor->lga)
                            <p class="text-muted small mb-2">
                                <i class="bi bi-geo-alt-fill me-1"></i>
                                {{ $contributor->district ?? $contributor->lga }}
                            </p>
                        @endif

                        <!-- Total Donated -->
                        <div class="donation-amount mb-3">
                            <span class="amount-label d-block small text-muted">Total Contribution</span>
                            <span class="amount-value fw-bold text-primary fs-4">
                                ₦{{ number_format($totalDonated) }}
                            </span>
                        </div>

                        <!-- Stats -->
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <div class="stat-item bg-light rounded-3 p-2">
                                    <span class="small text-muted d-block">Projects</span>
                                    <span class="fw-bold">{{ $contributor->donations_count ?? 0 }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stat-item bg-light rounded-3 p-2">
                                    <span class="small text-muted d-block">Since</span>
                                    <span class="fw-bold">{{ $contributor->created_at->format('Y') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- View Profile Button -->
                        <a href="{{ route('contributor.profile', ['slug' => $contributor->slug ?? null, 'id' => $contributor->id]) }}"
                           class="btn btn-outline-primary rounded-pill w-100">
                            View Full Profile
                            <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center py-5">
                        <i class="bi bi-emoji-neutral fs-1 d-block mb-3"></i>
                        <h4>No Contributors Found</h4>
                        <p>Be the first to contribute to a project and get featured here!</p>
                        <a href="{{ route('projects.index') }}" class="btn btn-primary mt-3">
                            Browse Projects
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-5">
            {{ $contributors->links() }}
        </div>
    </div>
</section>
@endsection
