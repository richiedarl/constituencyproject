@extends('layouts.app')

@section('title', 'About Us - Constituency Project')

@section('content')
<!-- Hero Section -->
<section class="about-hero py-5" style="background: linear-gradient(135deg, #29a221 0%, #ffc107 100%);">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center text-white">
                <h1 class="display-3 fw-bold mb-4" data-aos="fade-up">About Constituency Project</h1>
                <p class="lead mb-4" data-aos="fade-up" data-aos-delay="100">
                    Bridging the gap between public promises and documented impact through transparency,
                    accountability, and citizen engagement.
                </p>
                <div data-aos="fade-up" data-aos-delay="200">
                    <a href="#mission" class="btn btn-outline-light btn-lg px-5 py-3 rounded-pill me-3">
                        <i class="bi bi-arrow-down me-2"></i>Explore Our Story
                    </a>
                    <a href="{{ route('contact') }}" class="btn btn-light btn-lg px-5 py-3 rounded-pill">
                        <i class="bi bi-chat-dots me-2"></i>Get in Touch
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mission & Vision Section -->
<section id="mission" class="mission-vision py-5" style="background: #f8f9fa;">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-6" data-aos="fade-right">
                <div class="card border-0 shadow-lg rounded-4 h-100 overflow-hidden">
                    <div class="card-header bg-white py-4 px-4 border-0">
                        <div class="d-flex align-items-center">
                            <div class="icon-wrapper me-3" style="width: 60px; height: 60px; background: rgba(41, 162, 33, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-bullseye" style="color: #29a221; font-size: 2rem;"></i>
                            </div>
                            <h2 class="fw-bold mb-0" style="color: #212529;">Our Mission</h2>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <p class="lead mb-4" style="color: #29a221; font-weight: 500;">
                            "To transform constituency projects from political promises into verifiable,
                            documented, and lasting community impact."
                        </p>
                        <p class="text-muted mb-3">
                            We believe that every public project should be visible, every resource should be
                            accounted for, and every citizen should have access to information about developments
                            in their community.
                        </p>
                        <div class="mission-points mt-4">
                            <div class="d-flex mb-3">
                                <div class="me-3">
                                    <i class="bi bi-check-circle-fill" style="color: #29a221; font-size: 1.5rem;"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold">Document Everything</h5>
                                    <p class="text-muted">Every phase of every project is documented with photos, updates, and verification.</p>
                                </div>
                            </div>
                            <div class="d-flex mb-3">
                                <div class="me-3">
                                    <i class="bi bi-check-circle-fill" style="color: #29a221; font-size: 1.5rem;"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold">Ensure Accountability</h5>
                                    <p class="text-muted">Track project progress, budgets, and completion rates in real-time.</p>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="me-3">
                                    <i class="bi bi-check-circle-fill" style="color: #29a221; font-size: 1.5rem;"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold">Empower Citizens</h5>
                                    <p class="text-muted">Give citizens the tools to monitor, contribute to, and verify public projects.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6" data-aos="fade-left">
                <div class="card border-0 shadow-lg rounded-4 h-100 overflow-hidden">
                    <div class="card-header bg-white py-4 px-4 border-0">
                        <div class="d-flex align-items-center">
                            <div class="icon-wrapper me-3" style="width: 60px; height: 60px; background: rgba(255, 193, 7, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-eye" style="color: #ffc107; font-size: 2rem;"></i>
                            </div>
                            <h2 class="fw-bold mb-0" style="color: #212529;">Our Vision</h2>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <p class="lead mb-4" style="color: #ffc107; font-weight: 500;">
                            "A Nigeria where every public project is transparent, every leader is accountable,
                            and every citizen is an active participant in community development."
                        </p>
                        <p class="text-muted mb-3">
                            We envision a future where project documentation is the norm, not the exception.
                            Where citizens can easily access information about developments in their constituencies
                            and hold their leaders accountable.
                        </p>
                        <div class="vision-stats row g-3 mt-4">
                            <div class="col-6">
                                <div class="stat-card text-center p-3 rounded-3" style="background: rgba(41, 162, 33, 0.05);">
                                    <div class="h2 fw-bold" style="color: #29a221;">300+</div>
                                    <small class="text-muted">Projects Documented</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stat-card text-center p-3 rounded-3" style="background: rgba(255, 193, 7, 0.05);">
                                    <div class="h2 fw-bold" style="color: #ffc107;">1M+</div>
                                    <small class="text-muted">Lives Impacted</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stat-card text-center p-3 rounded-3" style="background: rgba(41, 162, 33, 0.05);">
                                    <div class="h2 fw-bold" style="color: #29a221;">15+</div>
                                    <small class="text-muted">States Covered</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stat-card text-center p-3 rounded-3" style="background: rgba(255, 193, 7, 0.05);">
                                    <div class="h2 fw-bold" style="color: #ffc107;">50+</div>
                                    <small class="text-muted">Active Contractors</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our Story Section -->
<section class="our-story py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="story-content">
                    <span class="badge px-4 py-2 mb-3 rounded-pill" style="background: rgba(41, 162, 33, 0.1); color: #29a221; font-weight: 500;">
                        <i class="bi bi-book me-2"></i>Our Journey
                    </span>
                    <h2 class="display-5 fw-bold mb-4" style="color: #212529;">How We Started</h2>
                    <p class="lead mb-4" style="color: #29a221;">
                        From a simple idea to a powerful platform for transparency.
                    </p>
                    <p class="text-muted mb-4">
                        Constituency Project was born out of a simple observation: despite billions of naira
                        being allocated to constituency projects annually, there was no centralized system to
                        track, verify, or showcase the impact of these investments.
                    </p>
                    <p class="text-muted mb-4">
                        In 2020, a group of civic technologists, developers, and transparency advocates came
                        together to build a solution. What started as a simple database of projects has evolved
                        into a comprehensive platform that connects citizens, contractors, contributors, and
                        project owners in a transparent ecosystem.
                    </p>
                    <div class="story-timeline mt-5">
                        <div class="timeline-item d-flex mb-4">
                            <div class="timeline-marker me-4">
                                <div class="rounded-circle bg-success d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="bi bi-calendar-check text-white"></i>
                                </div>
                            </div>
                            <div>
                                <h5 class="fw-bold">2020 - The Beginning</h5>
                                <p class="text-muted">Platform conceptualized and initial development begins</p>
                            </div>
                        </div>
                        <div class="timeline-item d-flex mb-4">
                            <div class="timeline-marker me-4">
                                <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="bi bi-rocket text-white"></i>
                                </div>
                            </div>
                            <div>
                                <h5 class="fw-bold">2022 - Public Launch</h5>
                                <p class="text-muted">First 50 projects documented and verified</p>
                            </div>
                        </div>
                        <div class="timeline-item d-flex">
                            <div class="timeline-marker me-4">
                                <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="bi bi-graph-up text-white"></i>
                                </div>
                            </div>
                            <div>
                                <h5 class="fw-bold">2024 - Today</h5>
                                <p class="text-muted">Over 300 projects, 1 million lives impacted across 15 states</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="story-image position-relative">
                    <img src="{{ asset('fe/assets/img/about/community-led.jpg') }}" alt="Our Story" class="img-fluid rounded-4 shadow-lg">
                    <div class="floating-card position-absolute bottom-0 start-0 p-4 bg-white rounded-4 shadow-lg m-4" style="max-width: 250px;">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="bi bi-patch-check-fill" style="color: #29a221; font-size: 2rem;"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Verified Impact</h6>
                                <small class="text-muted">100% of projects documented</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our Values Section -->
<section class="our-values py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="badge px-4 py-2 mb-3 rounded-pill" style="background: rgba(255, 193, 7, 0.1); color: #ffc107; font-weight: 500;">
                <i class="bi bi-heart me-2"></i>Our Core Values
            </span>
            <h2 class="display-5 fw-bold mb-3" style="color: #212529;">What We Stand For</h2>
            <p class="text-muted mx-auto" style="max-width: 700px;">These principles guide everything we do</p>
        </div>

        <div class="row g-4">
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
                <div class="value-card h-100 p-4 rounded-4 border-0 shadow-sm text-center">
                    <div class="value-icon mb-3 mx-auto" style="width: 80px; height: 80px; background: rgba(41, 162, 33, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-shield-check" style="color: #29a221; font-size: 2.5rem;"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Transparency</h4>
                    <p class="text-muted">Every project, every phase, every update is documented and accessible to all.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
                <div class="value-card h-100 p-4 rounded-4 border-0 shadow-sm text-center">
                    <div class="value-icon mb-3 mx-auto" style="width: 80px; height: 80px; background: rgba(255, 193, 7, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-person-check" style="color: #ffc107; font-size: 2.5rem;"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Accountability</h4>
                    <p class="text-muted">Project owners and contractors are held accountable through public documentation.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
                <div class="value-card h-100 p-4 rounded-4 border-0 shadow-sm text-center">
                    <div class="value-icon mb-3 mx-auto" style="width: 80px; height: 80px; background: rgba(41, 162, 33, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-people" style="color: #29a221; font-size: 2.5rem;"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Participation</h4>
                    <p class="text-muted">Citizens can contribute, comment, and track projects in their communities.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="400">
                <div class="value-card h-100 p-4 rounded-4 border-0 shadow-sm text-center">
                    <div class="value-icon mb-3 mx-auto" style="width: 80px; height: 80px; background: rgba(255, 193, 7, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-award" style="color: #ffc107; font-size: 2.5rem;"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Excellence</h4>
                    <p class="text-muted">We strive for the highest quality in documentation and project delivery.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="our-team py-5">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="badge px-4 py-2 mb-3 rounded-pill" style="background: rgba(41, 162, 33, 0.1); color: #29a221; font-weight: 500;">
                <i class="bi bi-people-fill me-2"></i>The Team
            </span>
            <h2 class="display-5 fw-bold mb-3" style="color: #212529;">Behind the Platform</h2>
            <p class="text-muted mx-auto" style="max-width: 700px;">Passionate individuals working to make public projects transparent</p>
        </div>

        {{-- <div class="row g-4 justify-content-center">
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="team-card text-center p-4 rounded-4 shadow-sm bg-white">
                    <div class="team-image mx-auto mb-3 position-relative">
                        <div class="rounded-circle overflow-hidden" style="width: 120px; height: 120px; border: 3px solid #29a221;">
                            <img src="{{ asset('fe/assets/img/team/team-1.jpg') }}" alt="Team Member" class="w-100 h-100" style="object-fit: cover;">
                        </div>
                    </div>
                    <h4 class="fw-bold mb-1">Dr. Adewale Ogunleye</h4>
                    <p class="text-muted small mb-2">Founder & Executive Director</p>
                    <div class="social-links">
                        <a href="#" class="text-decoration-none me-2"><i class="bi bi-linkedin" style="color: #29a221;"></i></a>
                        <a href="#" class="text-decoration-none me-2"><i class="bi bi-twitter-x" style="color: #ffc107;"></i></a>
                        <a href="#" class="text-decoration-none"><i class="bi bi-envelope" style="color: #29a221;"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="team-card text-center p-4 rounded-4 shadow-sm bg-white">
                    <div class="team-image mx-auto mb-3 position-relative">
                        <div class="rounded-circle overflow-hidden" style="width: 120px; height: 120px; border: 3px solid #ffc107;">
                            <img src="{{ asset('fe/assets/img/team/team-2.jpg') }}" alt="Team Member" class="w-100 h-100" style="object-fit: cover;">
                        </div>
                    </div>
                    <h4 class="fw-bold mb-1">Chioma Nwachukwu</h4>
                    <p class="text-muted small mb-2">Head of Operations</p>
                    <div class="social-links">
                        <a href="#" class="text-decoration-none me-2"><i class="bi bi-linkedin" style="color: #29a221;"></i></a>
                        <a href="#" class="text-decoration-none me-2"><i class="bi bi-twitter-x" style="color: #ffc107;"></i></a>
                        <a href="#" class="text-decoration-none"><i class="bi bi-envelope" style="color: #29a221;"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="team-card text-center p-4 rounded-4 shadow-sm bg-white">
                    <div class="team-image mx-auto mb-3 position-relative">
                        <div class="rounded-circle overflow-hidden" style="width: 120px; height: 120px; border: 3px solid #29a221;">
                            <img src="{{ asset('fe/assets/img/team/team-3.jpg') }}" alt="Team Member" class="w-100 h-100" style="object-fit: cover;">
                        </div>
                    </div>
                    <h4 class="fw-bold mb-1">Musa Ibrahim</h4>
                    <p class="text-muted small mb-2">Technical Lead</p>
                    <div class="social-links">
                        <a href="#" class="text-decoration-none me-2"><i class="bi bi-linkedin" style="color: #29a221;"></i></a>
                        <a href="#" class="text-decoration-none me-2"><i class="bi bi-twitter-x" style="color: #ffc107;"></i></a>
                        <a href="#" class="text-decoration-none"><i class="bi bi-envelope" style="color: #29a221;"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                <div class="team-card text-center p-4 rounded-4 shadow-sm bg-white">
                    <div class="team-image mx-auto mb-3 position-relative">
                        <div class="rounded-circle overflow-hidden" style="width: 120px; height: 120px; border: 3px solid #ffc107;">
                            <img src="{{ asset('fe/assets/img/team/team-4.jpg') }}" alt="Team Member" class="w-100 h-100" style="object-fit: cover;">
                        </div>
                    </div>
                    <h4 class="fw-bold mb-1">Funke Adepoju</h4>
                    <p class="text-muted small mb-2">Community Manager</p>
                    <div class="social-links">
                        <a href="#" class="text-decoration-none me-2"><i class="bi bi-linkedin" style="color: #29a221;"></i></a>
                        <a href="#" class="text-decoration-none me-2"><i class="bi bi-twitter-x" style="color: #ffc107;"></i></a>
                        <a href="#" class="text-decoration-none"><i class="bi bi-envelope" style="color: #29a221;"></i></a>
                    </div>
                </div>
            </div>
        </div> --}}
        <small>To be updated</small>
    </div>
</section>

<!-- Call to Action -->
<section class="cta-section py-5" style="background: linear-gradient(135deg, #29a221 0%, #ffc107 100%);">
    <div class="container py-4">
        <div class="row align-items-center">
            <div class="col-lg-8 text-white" data-aos="fade-right">
                <h2 class="display-5 fw-bold mb-3">Join Us in Building Transparency</h2>
                <p class="lead mb-0">Whether you're a project owner, contractor, contributor, or concerned citizen, there's a place for you on Constituency Project.</p>
            </div>
            <div class="col-lg-4 text-lg-end mt-4 mt-lg-0" data-aos="fade-left">
                <a href="{{ route('register') }}" class="btn btn-light btn-lg px-5 py-3 rounded-pill shadow-lg">
                    <i class="bi bi-person-plus me-2"></i>Get Started Today
                </a>
            </div>
        </div>
    </div>
</section>

<style>
    .value-card {
        transition: all 0.3s ease;
        background: white;
    }

    .value-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 30px rgba(41, 162, 33, 0.1) !important;
    }

    .team-card {
        transition: all 0.3s ease;
    }

    .team-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 30px rgba(41, 162, 33, 0.15) !important;
    }

    .story-image img {
        transition: all 0.5s ease;
    }

    .story-image:hover img {
        transform: scale(1.02);
    }

    .floating-card {
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    @media (max-width: 768px) {
        .display-3 {
            font-size: 2.5rem;
        }
    }
</style>
@endsection
