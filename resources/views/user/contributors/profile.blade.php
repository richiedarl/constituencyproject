@extends('layouts.app')

@section('title', $contributor->name . ' - Contributor Profile | Constituency Project')

@section('content')
<!-- Page Header with Gradient -->
<section class="page-header py-4" style="background: linear-gradient(135deg, #29a221 0%, #ffc107 100%);">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 bg-transparent p-3">
                <li class="breadcrumb-item"><a href="{{ route('landing') }}" class="text-white opacity-75">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('contributors.index') }}" class="text-white opacity-75">Contributors</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Profile</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Contributor Profile Section -->
<section class="contributor-profile py-5" style="background: #f8f9fa;">
    <div class="container">
        <!-- Profile Header -->
        <div class="row g-4">
            <!-- Left Column - Profile Card -->
            <div class="col-lg-4">
                <div class="profile-card bg-white rounded-4 shadow-lg p-4 text-center position-relative overflow-hidden"
                     style="border-top: 5px solid #29a221;">

                    <!-- Decorative Corner -->
                    <div class="position-absolute top-0 end-0" style="width: 100px; height: 100px; background: linear-gradient(135deg, transparent 50%, rgba(41, 162, 33, 0.1) 50%);"></div>

                    <!-- Profile Image with Brand Border -->
                    <div class="profile-image-wrapper mx-auto mb-4 position-relative">
                        <div class="rounded-circle p-1 d-inline-block" style="border: 3px solid #29a221;">
                            <div class="rounded-circle overflow-hidden" style="width: 150px; height: 150px; border: 3px solid #ffc107;">
                                <img src="{{ $contributor->photo ? asset('storage/'.$contributor->photo) : asset('images/avatar.png') }}"
                                     alt="{{ $contributor->name }}"
                                     class="w-100 h-100"
                                     style="object-fit: cover;">
                            </div>
                        </div>

                        <!-- Rank Badge -->
                        @if(isset($rank) && $rank <= 10)
                            <div class="position-absolute bottom-0 end-0">
                                <span class="d-flex align-items-center justify-content-center rounded-circle shadow"
                                      style="width: 45px; height: 45px; background: #ffc107; color: #212529; border: 3px solid white; font-weight: bold; font-size: 1.2rem;">
                                    #{{ $rank }}
                                </span>
                            </div>
                        @endif
                    </div>

                    <!-- Contributor Name -->
                    <h2 class="fw-bold mb-2" style="color: #212529;">{{ $contributor->name }}</h2>

<!-- Tier Badge with Brand Colors -->
<div class="mb-3">
    @php
        $tierColors = [
            'platinum' => ['bg' => 'linear-gradient(135deg, #ffc107, #29a221)', 'text' => 'white'],
            'gold' => ['bg' => '#ffc107', 'text' => '#212529'],
            'silver' => ['bg' => '#29a221', 'text' => 'white'],
            'bronze' => ['bg' => '#cd7f32', 'text' => 'white'],
            'community' => ['bg' => '#e9ecef', 'text' => '#495057']
        ];
        $tierStyle = $tierColors[$tierLevel] ?? $tierColors['community'];
    @endphp
    <span class="badge px-4 py-2 rounded-pill"
          style="background: {{ $tierStyle['bg'] }}; color: {{ $tierStyle['text'] }}; font-weight: 500;">
        <i class="bi {{ $tierIcon }} me-1"></i>
        {{ $tierName }}
    </span>
</div>
                    <!-- Location with Brand Icon -->
                    @if($contributor->district || $contributor->lga || $contributor->state)
                        <p class="mb-2" style="color: #6c757d;">
                            <i class="bi bi-geo-alt-fill me-1" style="color: #29a221;"></i>
                            {{ $contributor->district ?? $contributor->lga ?? '' }}
                            {{ $contributor->state ? ', ' . $contributor->state : '' }}
                        </p>
                    @endif

                    <!-- Join Date -->
                    <p class="small mb-3" style="color: #6c757d;">
                        <i class="bi bi-calendar-check me-1" style="color: #ffc107;"></i>
                        Contributor since {{ $contributor->created_at->format('F Y') }}
                    </p>

                    <!-- Bio -->
                    @if($contributor->bio)
                        <div class="bio-text text-start p-3 rounded-3 mb-3" style="background: rgba(41, 162, 33, 0.05); border-left: 3px solid #29a221;">
                            <p class="mb-0" style="color: #495057;">{{ $contributor->bio }}</p>
                        </div>
                    @endif

                    <!-- Contact Button -->
                    @if($contributor->user && $contributor->user->email)
                        <div class="mb-4">
                            <a href="mailto:{{ $contributor->user->email }}"
                               class="btn w-100 py-2 rounded-3"
                               style="border: 2px solid #29a221; color: #29a221; background: white; transition: all 0.3s ease;"
                               onmouseover="this.style.background='#29a221'; this.style.color='white';"
                               onmouseout="this.style.background='white'; this.style.color='#29a221';">
                                <i class="bi bi-envelope me-2"></i>
                                Contact Contributor
                            </a>
                        </div>
                    @endif

                    <!-- Share Profile -->
                    <div class="pt-3 border-top" style="border-color: rgba(41, 162, 33, 0.2) !important;">
                        <p class="small mb-2" style="color: #6c757d;">Share this profile</p>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                               target="_blank"
                               class="btn btn-sm rounded-circle"
                               style="background: #1877f2; color: white; width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center;">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode('Check out ' . $contributor->name . '\'s contributions') }}"
                               target="_blank"
                               class="btn btn-sm rounded-circle"
                               style="background: #1da1f2; color: white; width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center;">
                                <i class="bi bi-twitter-x"></i>
                            </a>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->url()) }}"
                               target="_blank"
                               class="btn btn-sm rounded-circle"
                               style="background: #0077b5; color: white; width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center;">
                                <i class="bi bi-linkedin"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Stats and Activity -->
            <div class="col-lg-8">
                <!-- Stats Cards with Brand Colors -->
                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <div class="stat-card bg-white rounded-4 shadow-lg p-4 text-center h-100"
                             style="border-bottom: 4px solid #29a221;">
                            <div class="stat-icon mb-2">
                                <i class="bi bi-cash-stack" style="color: #29a221; font-size: 2.5rem;"></i>
                            </div>
                            <h3 class="fw-bold mb-1" style="color: #212529; font-size: 1.8rem;">₦{{ number_format($totalDonated) }}</h3>
                            <p class="mb-0" style="color: #6c757d;">Total Donated</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="stat-card bg-white rounded-4 shadow-lg p-4 text-center h-100"
                             style="border-bottom: 4px solid #ffc107;">
                            <div class="stat-icon mb-2">
                                <i class="bi bi-heart-fill" style="color: #ffc107; font-size: 2.5rem;"></i>
                            </div>
                            <h3 class="fw-bold mb-1" style="color: #212529; font-size: 1.8rem;">{{ $donationCount }}</h3>
                            <p class="mb-0" style="color: #6c757d;">Donations Made</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="stat-card bg-white rounded-4 shadow-lg p-4 text-center h-100"
                             style="border-bottom: 4px solid linear-gradient(90deg, #29a221, #ffc107);">
                            <div class="stat-icon mb-2">
                                <i class="bi bi-building" style="color: #29a221; font-size: 2.5rem;"></i>
                            </div>
                            <h3 class="fw-bold mb-1" style="color: #212529; font-size: 1.8rem;">{{ $supportedProjects->count() }}</h3>
                            <p class="mb-0" style="color: #6c757d;">Projects Supported</p>
                        </div>
                    </div>
                </div>

                <!-- Recent Donations -->
                @if($recentDonations->count() > 0)
                <div class="recent-donations bg-white rounded-4 shadow-lg p-4 mb-4">
                    <h4 class="fw-bold mb-4" style="color: #212529;">
                        <i class="bi bi-clock-history me-2" style="color: #29a221;"></i>
                        Recent Donations
                    </h4>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead style="background: rgba(41, 162, 33, 0.05);">
                                <tr>
                                    <th style="color: #29a221;">Project</th>
                                    <th style="color: #29a221;">Amount</th>
                                    <th style="color: #29a221;">Date</th>
                                    <th style="color: #29a221;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentDonations as $donation)
                                <tr>
                                    <td>
                                        @if($donation->project)
                                            <a href="{{ route('user.projects.show', $donation->project->slug) }}"
                                               class="text-decoration-none" style="color: #212529;">
                                                {{ $donation->project->title }}
                                            </a>
                                        @else
                                            <span style="color: #6c757d;">Project Unavailable</span>
                                        @endif
                                    </td>
                                    <td class="fw-bold" style="color: #29a221;">₦{{ number_format($donation->amount) }}</td>
                                    <td style="color: #6c757d;">{{ $donation->created_at->format('M d, Y') }}</td>
                                    <td>
                                        @if($donation->approved)
                                            <span class="badge px-3 py-2" style="background: #29a221; color: white;">Verified</span>
                                        @else
                                            <span class="badge px-3 py-2" style="background: #ffc107; color: #212529;">Pending</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

                <!-- Supported Projects -->
                @if($supportedProjects->count() > 0)
                <div class="supported-projects bg-white rounded-4 shadow-lg p-4">
                    <h4 class="fw-bold mb-4" style="color: #212529;">
                        <i class="bi bi-folder-check me-2" style="color: #29a221;"></i>
                        Projects Supported
                    </h4>

                    <div class="row g-4">
                        @foreach($supportedProjects as $project)
                        <div class="col-md-6">
                            <div class="project-card border rounded-3 p-3 h-100"
                                 style="border-color: rgba(41, 162, 33, 0.2) !important; transition: all 0.3s ease;"
                                 onmouseover="this.style.borderColor='#29a221'; this.style.boxShadow='0 10px 20px rgba(41, 162, 33, 0.1)';"
                                 onmouseout="this.style.borderColor='rgba(41, 162, 33, 0.2)'; this.style.boxShadow='none';">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="project-icon me-2">
                                        <i class="bi bi-building" style="color: #29a221;"></i>
                                    </div>
                                    <h5 class="mb-0">
                                        <a href="{{ route('user.projects.show', $project->slug) }}"
                                           class="text-decoration-none" style="color: #212529;">
                                            {{ $project->title }}
                                        </a>
                                    </h5>
                                </div>

                                <p class="small mb-2" style="color: #6c757d;">
                                    <i class="bi bi-person me-1" style="color: #ffc107;"></i>
                                    {{ $project->candidate->name ?? 'Unknown Candidate' }}
                                </p>

                                <p class="small mb-2" style="color: #6c757d;">
                                    <i class="bi bi-geo-alt me-1" style="color: #29a221;"></i>
                                    {{ $project->full_location }}
                                </p>

                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <span class="badge px-3 py-2"
                                          style="background: {{ $project->status === 'completed' ? '#29a221' : ($project->status === 'ongoing' ? '#ffc107' : '#6c757d') }};
                                                 color: {{ $project->status === 'ongoing' ? '#212529' : 'white' }};">
                                        {{ ucfirst($project->status) }}
                                    </span>
                                    <span class="small" style="color: #6c757d;">
                                        {{ $project->donations()->where('contributor_id', $contributor->id)->count() }} donations
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
    .profile-card, .stat-card, .recent-donations, .supported-projects {
        transition: all 0.3s ease;
    }

    .profile-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 30px rgba(41, 162, 33, 0.15) !important;
    }

    .stat-card:hover {
        transform: translateY(-5px);
    }

    .table-hover tbody tr:hover {
        background: rgba(41, 162, 33, 0.03) !important;
    }

    @keyframes softPulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    .rank-badge {
        animation: softPulse 2s infinite;
    }

    @media (max-width: 768px) {
        .stat-card h3 {
            font-size: 1.5rem !important;
        }
    }
</style>
@endpush
@endsection
