@extends('layouts.app')

@section('title', 'All Contributors - Constituency Project')

@section('content')
<!-- Page Header -->
<section class="page-header py-5" style="background: linear-gradient(135deg, #29a221 0%, #ffc107 100%);">
    <div class="container text-center text-white">
        <h1 class="display-4 fw-bold">Our Contributors</h1>
        <p class="lead">Meet the generous citizens supporting constituency projects</p>
    </div>
</section>

<!-- Contributors Grid -->
<section class="contributors-section py-5">
    <div class="container">
        <div class="row g-4">
            @forelse($contributors as $index => $contributor)
                <div class="col-lg-4 col-md-6">
                    <div class="card contributor-card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="card-body text-center p-4">
                            <!-- Rank -->
                            <div class="position-relative">
                                <div class="rounded-circle mx-auto mb-3 overflow-hidden border-3" style="width: 100px; height: 100px; border: 3px solid {{ $index < 3 ? ($index == 0 ? '#ffc107' : ($index == 1 ? '#29a221' : '#cd7f32')) : '#e9ecef' }};">
                                    <img src="{{ $contributor->photo ? asset('storage/'.$contributor->photo) : asset('images/avatar.png') }}"
                                         class="w-100 h-100" style="object-fit: cover;">
                                </div>
                                @if($index < 3)
                                    <span class="position-absolute top-0 end-0 translate-middle badge rounded-pill bg-warning">
                                        #{{ $index + 1 }}
                                    </span>
                                @endif
                            </div>

                            <h4 class="fw-bold">{{ $contributor->name ?? $contributor->user->name }}</h4>

                            <div class="mb-3">
                                <span class="badge px-3 py-2" style="background: #29a221; color: white;">
                                    ₦{{ number_format($contributor->donations_sum_amount ?? 0) }}
                                </span>
                            </div>

                            <p class="small text-muted mb-3">
                                <i class="bi bi-geo-alt me-1"></i>
                                {{ $contributor->district ?? 'Contributor' }}
                            </p>

                            <a href="{{ route('contributor.profile', ['id' => $contributor->id]) }}"
                               class="btn w-100 py-2 rounded-3"
                               style="border: 1px solid #29a221; color: #29a221;">
                                View Profile
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="alert alert-info">No contributors found.</div>
                </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center mt-5">
            {{ $contributors->links() }}
        </div>
    </div>
</section>
@endsection
