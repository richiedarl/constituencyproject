@extends('layouts.app')

@section('title', 'Our Services - Constituency Project Ltd')

@section('meta')
<meta name="description" content="From promise to proven impact. We offer comprehensive project execution, documentation, visibility, and legacy management services for leaders and organizations.">
<meta name="keywords" content="constituency projects, project execution, impact documentation, legacy management, capacity building, Nigeria">
@endsection

@section('content')
<!-- Hero Section -->
<section class="services-hero py-5" style="background: linear-gradient(135deg, #1a2b4c 0%, #2a3f66 100%);">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center text-white">
                <h1 class="display-4 fw-bold mb-4 text-white" data-aos="fade-up">From Promise to Proven Impact</h1>
                <p class="lead mb-4" data-aos="fade-up" data-aos-delay="100">
                    We transform your vision into visible, verifiable, and lasting legacy.
                    Every project executed, documented, and amplified for maximum impact.
                </p>
                <div class="d-flex justify-content-center gap-3" data-aos="fade-up" data-aos-delay="200">
                    <a href="#services-grid" class="btn btn-gold btn-lg px-5 py-3 rounded-pill">
                        <i class="bi bi-arrow-down me-2"></i>Explore Services
                    </a>
                    <a href="{{ route('contact') }}" class="btn btn-outline-light btn-lg px-5 py-3 rounded-pill">
                        <i class="bi bi-chat-dots me-2"></i>Discuss Your Project
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Counter Section -->
<section class="stats-section py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-card text-center">
                    <div class="stat-number display-4 fw-bold" style="color: #1a2b4c;">300+</div>
                    <div class="stat-label text-muted">Projects Completed</div>
                </div>
            </div>
            <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-card text-center">
                    <div class="stat-number display-4 fw-bold" style="color: #1a2b4c;">1M+</div>
                    <div class="stat-label text-muted">Lives Impacted</div>
                </div>
            </div>
            <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-card text-center">
                    <div class="stat-number display-4 fw-bold" style="color: #1a2b4c;">27+</div>
                    <div class="stat-label text-muted">States Covered</div>
                </div>
            </div>
            <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="400">
                <div class="stat-card text-center">
                    <div class="stat-number display-4 fw-bold" style="color: #1a2b4c;">100%</div>
                    <div class="stat-label text-muted">Documentation Rate</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Grid -->
<section id="services-grid" class="services-grid py-5">
    <div class="container">
        <!-- Section Header -->
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="badge bg-gold px-4 py-2 mb-3 rounded-pill" style="background: #ffc107; color: #1a2b4c;">
                <i class="bi bi-grid-3x3-gap-fill me-2"></i>Our Expertise
            </span>
            <h2 class="display-5 fw-bold mb-3" style="color: #1a2b4c;">Comprehensive Project Solutions</h2>
            <p class="text-muted mx-auto" style="max-width: 800px;">
                From concept to completion and beyond—we handle every aspect of your constituency projects
                with professionalism, transparency, and measurable impact.
            </p>
        </div>

        <!-- Service Categories Tabs -->
        <ul class="nav nav-pills justify-content-center mb-5" id="serviceTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="all-tab" data-bs-toggle="pill" data-bs-target="#all" type="button" role="tab">
                    <i class="bi bi-grid-fill me-2"></i>All Services
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="execution-tab" data-bs-toggle="pill" data-bs-target="#execution" type="button" role="tab">
                    <i class="bi bi-building me-2"></i>Project Execution
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="documentation-tab" data-bs-toggle="pill" data-bs-target="#documentation" type="button" role="tab">
                    <i class="bi bi-file-text me-2"></i>Documentation
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="visibility-tab" data-bs-toggle="pill" data-bs-target="#visibility" type="button" role="tab">
                    <i class="bi bi-broadcast me-2"></i>Visibility
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="advisory-tab" data-bs-toggle="pill" data-bs-target="#advisory" type="button" role="tab">
                    <i class="bi bi-chat-dots me-2"></i>Advisory
                </button>
            </li>
        </ul>

        <!-- Services Grid Content -->
        <div class="tab-content" id="serviceTabsContent">
            <!-- All Services Tab -->
            <div class="tab-pane fade show active" id="all" role="tabpanel">
                <div class="row g-4">
                    <!-- Service Card 1: Structural Projects -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-card h-100 p-4 rounded-4 border-0 shadow-sm">
                            <div class="service-icon mb-4">
                                <i class="bi bi-building fs-1" style="color: #29a221;"></i>
                            </div>
                            <h4 class="fw-bold mb-3" style="color: #1a2b4c;">Structural (Physical) Projects</h4>
                            <p class="text-muted mb-4">End-to-end execution of community infrastructure including schools, boreholes, health posts, roads, and ICT hubs.</p>
                            <ul class="list-unstyled mb-4">
                                <li class="mb-2"><i class="bi bi-check-circle-fill me-2" style="color: #29a221;"></i>Schools & Educational Facilities</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill me-2" style="color: #29a221;"></i>Boreholes & Water Systems</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill me-2" style="color: #29a221;"></i>Health Posts & Clinics</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill me-2" style="color: #29a221;"></i>Roads & Infrastructure</li>
                                <li><i class="bi bi-check-circle-fill me-2" style="color: #29a221;"></i>ICT Hubs & Digital Centers</li>
                            </ul>
                            <a href="#" class="btn btn-outline-gold w-100">Learn More <i class="bi bi-arrow-right ms-2"></i></a>
                        </div>
                    </div>

                    <!-- Service Card 2: Capacity Building -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                        <div class="service-card h-100 p-4 rounded-4 border-0 shadow-sm">
                            <div class="service-icon mb-4">
                                <i class="bi bi-people fs-1" style="color: #29a221;"></i>
                            </div>
                            <h4 class="fw-bold mb-3" style="color: #1a2b4c;">Capacity-Building & Empowerment</h4>
                            <p class="text-muted mb-4">Skills development programs that empower youth, women, and communities for sustainable economic growth.</p>
                            <ul class="list-unstyled mb-4">
                                <li class="mb-2"><i class="bi bi-check-circle-fill me-2" style="color: #29a221;"></i>Youth Skills Development</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill me-2" style="color: #29a221;"></i>Women Empowerment Programs</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill me-2" style="color: #29a221;"></i>Entrepreneurship Training</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill me-2" style="color: #29a221;"></i>Agricultural Extension</li>
                                <li><i class="bi bi-check-circle-fill me-2" style="color: #29a221;"></i>Vocational & Technical Skills</li>
                            </ul>
                            <a href="#" class="btn btn-outline-gold w-100">Learn More <i class="bi bi-arrow-right ms-2"></i></a>
                        </div>
                    </div>

                    <!-- Service Card 3: Needs Assessment -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                        <div class="service-card h-100 p-4 rounded-4 border-0 shadow-sm">
                            <div class="service-icon mb-4">
                                <i class="bi bi-clipboard-data fs-1" style="color: #29a221;"></i>
                            </div>
                            <h4 class="fw-bold mb-3" style="color: #1a2b4c;">Constituency Needs Assessment</h4>
                            <p class="text-muted mb-4">Data-driven identification of community priorities and development intelligence for targeted interventions.</p>
                            <ul class="list-unstyled mb-4">
                                <li class="mb-2"><i class="bi bi-check-circle-fill me-2" style="color: #29a221;"></i>Community Surveys & Mapping</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill me-2" style="color: #29a221;"></i>Priority Identification</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill me-2" style="color: #29a221;"></i>Stakeholder Consultations</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill me-2" style="color: #29a221;"></i>Development Intelligence</li>
                                <li><i class="bi bi-check-circle-fill me-2" style="color: #29a221;"></i>Feasibility Studies</li>
                            </ul>
                            <a href="#" class="btn btn-outline-gold w-100">Learn More <i class="bi bi-arrow-right ms-2"></i></a>
                        </div>
                    </div>

                    <!-- Service Card 4: Monitoring & Evaluation -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                        <div class="service-card h-100 p-4 rounded-4 border-0 shadow-sm">
                            <div class="service-icon mb-4">
                                <i class="bi bi-graph-up-arrow fs-1" style="color: #29a221;"></i>
                            </div>
                            <h4 class="fw-bold mb-3" style="color: #1a2b4c;">Project Monitoring, Evaluation & Audit</h4>
                            <p class="text-muted mb-4">Rigorous tracking and assessment to ensure projects deliver intended outcomes and value for money.</p>
                            <ul class="list-unstyled mb-4">
                                <li class="mb-2"><i class="bi bi-check-circle-fill me-2" style="color: #29a221;"></i>Real-time Progress Tracking</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill me-2" style="color: #29a221;"></i>Performance Evaluation</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill me-2" style="color: #29a221;"></i>Impact Assessment</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill me-2" style="color: #29a221;"></i>Value-for-Money Audit</li>
                                <li><i class="bi bi-check-circle-fill me-2" style="color: #29a221;"></i>Compliance Verification</li>
                            </ul>
                            <a href="#" class="btn btn-outline-gold w-100">Learn More <i class="bi bi-arrow-right ms-2"></i></a>
                        </div>
                    </div>

                    <!-- Service Card 5: Beneficiary Management -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                        <div class="service-card h-100 p-4 rounded-4 border-0 shadow-sm">
                            <div class="service-icon mb-4">
                                <i class="bi bi-person-badge fs-1" style="color: #29a221;"></i>
                            </div>
                            <h4 class="fw-bold mb-3" style="color: #1a2b4c;">Beneficiary Management & Verification</h4>
                            <p class="text-muted mb-4">Systems to identify, register, and verify project beneficiaries with tamper-proof documentation.</p>
                            <ul class="list-unstyled mb-4">
                                <li class="mb-2"><i class="bi bi-check-circle-fill me-2" style="color: #29a221;"></i>Beneficiary Registration</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill me-2" style="color: #29a221;"></i>Biometric Verification</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill me-2" style="color: #29a221;"></i>Digital Certification</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill me-2" style="color: #29a221;"></i>Impact Tracking</li>
                                <li><i class="bi bi-check-circle-fill me-2" style="color: #29a221;"></i>Feedback Mechanisms</li>
                            </ul>
                            <a href="#" class="btn btn-outline-gold w-100">Learn More <i class="bi bi-arrow-right ms-2"></i></a>
                        </div>
                    </div>

                    <!-- Service Card 6: Launch & Commissioning -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
                        <div class="service-card h-100 p-4 rounded-4 border-0 shadow-sm">
                            <div class="service-icon mb-4">
                                <i class="bi bi-megaphone fs-1" style="color: #29a221;"></i>
                            </div>
                            <h4 class="fw-bold mb-3" style="color: #1a2b4c;">Project Launch & Stakeholder Engagement</h4>
                            <p class="text-muted mb-4">Professional organization of groundbreaking ceremonies, commissioning events, and community engagement.</p>
                            <ul class="list-unstyled mb-4">
                                <li class="mb-2"><i class="bi bi-check-circle-fill me-2" style="color: #29a221;"></i>Groundbreaking Ceremonies</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill me-2" style="color: #29a221;"></i>Commissioning Events</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill me-2" style="color: #29a221;"></i>Stakeholder Engagement</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill me-2" style="color: #29a221;"></i>Media Coverage</li>
                                <li><i class="bi bi-check-circle-fill me-2" style="color: #29a221;"></i>Community Town Halls</li>
                            </ul>
                            <a href="#" class="btn btn-outline-gold w-100">Learn More <i class="bi bi-arrow-right ms-2"></i></a>
                        </div>
                    </div>

                    <!-- Service Card 7: Digital Documentation -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="700">
                        <div class="service-card h-100 p-4 rounded-4 border-0 shadow-sm">
                            <div class="service-icon mb-4">
                                <i class="bi bi-files fs-1" style="color: #29a221;"></i>
                            </div>
                            <h4 class="fw-bold mb-3" style="color: #1a2b4c;">Digital Documentation & Dashboards</h4>
                            <p class="text-muted mb-4">Comprehensive digital documentation with real-time dashboards for project tracking and reporting.</p>
                            <ul class="list-unstyled mb-4">
                                <li class="mb-2"><i class="bi bi-check-circle-fill me-2" style="color: #29a221;"></i>Project Photography & Video</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill me-2" style="color: #29a221;"></i>Drone Footage & Surveys</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill me-2" style="color: #29a221;"></i>Interactive Dashboards</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill me-2" style="color: #29a221;"></i>Progress Tracking Systems</li>
                                <li><i class="bi bi-check-circle-fill me-2" style="color: #29a221;"></i>Digital Archives</li>
                            </ul>
                            <a href="#" class="btn btn-outline-gold w-100">Learn More <i class="bi bi-arrow-right ms-2"></i></a>
                        </div>
                    </div>

                    <!-- Service Card 8: Media Amplification -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="800">
                        <div class="service-card h-100 p-4 rounded-4 border-0 shadow-sm">
                            <div class="service-icon mb-4">
                                <i class="bi bi-broadcast fs-1" style="color: #29a221;"></i>
                            </div>
                            <h4 class="fw-bold mb-3" style="color: #1a2b4c;">Digital Visibility & Media Amplification</h4>
                            <p class="text-muted mb-4">Strategic media placement and digital campaigns to showcase project impact to wider audiences.</p>
                            <ul class="list-unstyled mb-4">
                                <li class="mb-2"><i class="bi bi-check-circle-fill me-2" style="color: #29a221;"></i>Press Releases & Coverage</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill me-2" style="color: #29a221;"></i>Social Media Campaigns</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill me-2" style="color: #29a221;"></i>Documentary Production</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill me-2" style="color: #29a221;"></i>Digital Advertising</li>
                                <li><i class="bi bi-check-circle-fill me-2" style="color: #29a221;"></i>Influencer Engagement</li>
                            </ul>
                            <a href="#" class="btn btn-outline-gold w-100">Learn More <i class="bi bi-arrow-right ms-2"></i></a>
                        </div>
                    </div>

                    <!-- Service Card 9: Annual Reports -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="900">
                        <div class="service-card h-100 p-4 rounded-4 border-0 shadow-sm">
                            <div class="service-icon mb-4">
                                <i class="bi bi-file-pdf fs-1" style="color: #29a221;"></i>
                            </div>
                            <h4 class="fw-bold mb-3" style="color: #1a2b4c;">Annual Impact Reports & Legacy Books</h4>
                            <p class="text-muted mb-4">Professionally designed publications documenting project achievements and lasting community impact.</p>
                            <ul class="list-unstyled mb-4">
                                <li class="mb-2"><i class="bi bi-check-circle-fill me-2" style="color: #29a221;"></i>Annual Impact Reports</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill me-2" style="color: #29a221;"></i>Legacy Books & Publications</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill me-2" style="color: #29a221;"></i>Photo Books & Archives</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill me-2" style="color: #29a221;"></i>Case Study Compilations</li>
                                <li><i class="bi bi-check-circle-fill me-2" style="color: #29a221;"></i>Digital Publications</li>
                            </ul>
                            <a href="#" class="btn btn-outline-gold w-100">Learn More <i class="bi bi-arrow-right ms-2"></i></a>
                        </div>
                    </div>

                    <!-- Service Card 10: Post-Project Maintenance -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="1000">
                        <div class="service-card h-100 p-4 rounded-4 border-0 shadow-sm">
                            <div class="service-icon mb-4">
                                <i class="bi bi-tools fs-1" style="color: #29a221;"></i>
                            </div>
                            <h4 class="fw-bold mb-3" style="color: #1a2b4c;">Post-Project Maintenance & Sustainability</h4>
                            <p class="text-muted mb-4">Ensuring project longevity through maintenance planning and sustainability strategies.</p>
                            <ul class="list-unstyled mb-4">
                                <li class="mb-2"><i class="bi bi-check-circle-fill me-2" style="color: #29a221;"></i>Maintenance Planning</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill me-2" style="color: #29a221;"></i>Sustainability Strategies</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill me-2" style="color: #29a221;"></i>Community Handover</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill me-2" style="color: #29a221;"></i>Long-term Monitoring</li>
                                <li><i class="bi bi-check-circle-fill me-2" style="color: #29a221;"></i>Capacity Building for Locals</li>
                            </ul>
                            <a href="#" class="btn btn-outline-gold w-100">Learn More <i class="bi bi-arrow-right ms-2"></i></a>
                        </div>
                    </div>

                    <!-- Service Card 11: Advisory Services -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="1100">
                        <div class="service-card h-100 p-4 rounded-4 border-0 shadow-sm">
                            <div class="service-icon mb-4">
                                <i class="bi bi-chat-square-text fs-1" style="color: #29a221;"></i>
                            </div>
                            <h4 class="fw-bold mb-3" style="color: #1a2b4c;">Advisory, Risk & Governance Consultancy</h4>
                            <p class="text-muted mb-4">Strategic guidance on project governance, risk management, and compliance for optimal outcomes.</p>
                            <ul class="list-unstyled mb-4">
                                <li class="mb-2"><i class="bi bi-check-circle-fill me-2" style="color: #29a221;"></i>Project Governance</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill me-2" style="color: #29a221;"></i>Risk Assessment & Mitigation</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill me-2" style="color: #29a221;"></i>Compliance Advisory</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill me-2" style="color: #29a221;"></i>Policy Development</li>
                                <li><i class="bi bi-check-circle-fill me-2" style="color: #29a221;"></i>Stakeholder Management</li>
                            </ul>
                            <a href="#" class="btn btn-outline-gold w-100">Learn More <i class="bi bi-arrow-right ms-2"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Project Execution Tab -->
            <div class="tab-pane fade" id="execution" role="tabpanel">
                <div class="row g-4">
                    @php
                        $executionServices = [
                            ['icon' => 'building', 'title' => 'Structural Projects', 'desc' => 'End-to-end execution of physical infrastructure including schools, boreholes, health posts, and roads.'],
                            ['icon' => 'people', 'title' => 'Capacity Building', 'desc' => 'Skills development and empowerment programs for sustainable community growth.'],
                            ['icon' => 'clipboard-data', 'title' => 'Needs Assessment', 'desc' => 'Data-driven community needs identification and development planning.'],
                            ['icon' => 'graph-up-arrow', 'title' => 'Monitoring & Evaluation', 'desc' => 'Rigorous tracking and evaluation ensuring project accountability and impact.']
                        ];
                    @endphp

                    @foreach($executionServices as $index => $service)
                    <div class="col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                        <div class="service-card h-100 p-4 rounded-4 border-0 shadow-sm">
                            <div class="d-flex align-items-center mb-4">
                                <div class="service-icon me-3">
                                    <i class="bi bi-{{ $service['icon'] }} fs-1" style="color: #29a221;"></i>
                                </div>
                                <h4 class="fw-bold mb-0" style="color: #1a2b4c;">{{ $service['title'] }}</h4>
                            </div>
                            <p class="text-muted mb-3">{{ $service['desc'] }}</p>
                            <a href="#" class="btn btn-link p-0" style="color: #29a221;">Learn more <i class="bi bi-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Documentation Tab -->
            <div class="tab-pane fade" id="documentation" role="tabpanel">
                <div class="row g-4">
                    @php
                        $documentationServices = [
                            ['icon' => 'files', 'title' => 'Digital Documentation', 'desc' => 'Comprehensive digital documentation with real-time dashboards.'],
                            ['icon' => 'person-badge', 'title' => 'Beneficiary Verification', 'desc' => 'Tamper-proof beneficiary registration and verification systems.'],
                            ['icon' => 'file-pdf', 'title' => 'Annual Reports', 'desc' => 'Professionally designed impact publications and legacy books.']
                        ];
                    @endphp

                    @foreach($documentationServices as $service)
                    <div class="col-md-4" data-aos="fade-up">
                        <div class="service-card h-100 p-4 rounded-4 border-0 shadow-sm text-center">
                            <div class="service-icon mb-3">
                                <i class="bi bi-{{ $service['icon'] }} fs-1" style="color: #29a221;"></i>
                            </div>
                            <h5 class="fw-bold mb-3" style="color: #1a2b4c;">{{ $service['title'] }}</h5>
                            <p class="text-muted small">{{ $service['desc'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Visibility Tab -->
            <div class="tab-pane fade" id="visibility" role="tabpanel">
                <div class="row">
                    <div class="col-12">
                        <div class="service-card p-5 rounded-4 border-0 shadow-sm">
                            <div class="row align-items-center">
                                <div class="col-lg-4 text-center mb-4 mb-lg-0">
                                    <div class="service-icon mb-3">
                                        <i class="bi bi-broadcast display-1" style="color: #29a221;"></i>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <h3 class="fw-bold mb-4" style="color: #1a2b4c;">Digital Visibility & Media Amplification</h3>
                                    <div class="row g-4">
                                        <div class="col-md-4">
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-newspaper fs-2 me-3" style="color: #29a221;"></i>
                                                <div>
                                                    <h6 class="fw-bold mb-1">Press Coverage</h6>
                                                    <small class="text-muted">Strategic media placement</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-camera-reels fs-2 me-3" style="color: #29a221;"></i>
                                                <div>
                                                    <h6 class="fw-bold mb-1">Documentary Production</h6>
                                                    <small class="text-muted">Professional video documentation</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-share fs-2 me-3" style="color: #29a221;"></i>
                                                <div>
                                                    <h6 class="fw-bold mb-1">Social Media Campaigns</h6>
                                                    <small class="text-muted">Targeted digital reach</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Advisory Tab -->
            <div class="tab-pane fade" id="advisory" role="tabpanel">
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <div class="service-card h-100 p-4 rounded-4 border-0 shadow-sm">
                            <div class="d-flex align-items-center mb-4">
                                <i class="bi bi-chat-square-text fs-1 me-3" style="color: #29a221;"></i>
                                <h4 class="fw-bold mb-0" style="color: #1a2b4c;">Advisory Services</h4>
                            </div>
                            <p class="text-muted mb-3">Strategic guidance for optimal project outcomes and governance.</p>
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="bi bi-check-lg me-2" style="color: #29a221;"></i>Project Governance Frameworks</li>
                                <li class="mb-2"><i class="bi bi-check-lg me-2" style="color: #29a221;"></i>Risk Assessment & Mitigation</li>
                                <li class="mb-2"><i class="bi bi-check-lg me-2" style="color: #29a221;"></i>Compliance Advisory</li>
                                <li class="mb-2"><i class="bi bi-check-lg me-2" style="color: #29a221;"></i>Policy Development Support</li>
                                <li><i class="bi bi-check-lg me-2" style="color: #29a221;"></i>Stakeholder Management</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="service-card h-100 p-4 rounded-4 border-0 shadow-sm">
                            <div class="d-flex align-items-center mb-4">
                                <i class="bi bi-shield-check fs-1 me-3" style="color: #29a221;"></i>
                                <h4 class="fw-bold mb-0" style="color: #1a2b4c;">Risk & Governance</h4>
                            </div>
                            <p class="text-muted mb-3">Ensuring projects are delivered with integrity and accountability.</p>
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="bi bi-check-lg me-2" style="color: #29a221;"></i>Risk Management Plans</li>
                                <li class="mb-2"><i class="bi bi-check-lg me-2" style="color: #29a221;"></i>Governance Structures</li>
                                <li class="mb-2"><i class="bi bi-check-lg me-2" style="color: #29a221;"></i>Compliance Monitoring</li>
                                <li class="mb-2"><i class="bi bi-check-lg me-2" style="color: #29a221;"></i>Internal Controls</li>
                                <li><i class="bi bi-check-lg me-2" style="color: #29a221;"></i>Audit Preparation</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our Process Section -->
<section class="process-section py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="badge bg-gold px-4 py-2 mb-3 rounded-pill" style="background: #ffc107; color: #1a2b4c;">
                <i class="bi bi-diagram-3 me-2"></i>Our Approach
            </span>
            <h2 class="display-5 fw-bold mb-3" style="color: #1a2b4c;">How We Deliver Impact</h2>
            <p class="text-muted mx-auto" style="max-width: 700px;">
                A systematic approach that ensures every project is executed, documented, and amplified for maximum visibility.
            </p>
        </div>

        <div class="row g-4">
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="process-card text-center p-4">
                    <div class="process-number mb-3">01</div>
                    <i class="bi bi-clipboard-check fs-1 mb-3" style="color: #29a221;"></i>
                    <h5 class="fw-bold">Assess & Plan</h5>
                    <p class="text-muted small">Community needs assessment and strategic project planning</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="process-card text-center p-4">
                    <div class="process-number mb-3">02</div>
                    <i class="bi bi-tools fs-1 mb-3" style="color: #29a221;"></i>
                    <h5 class="fw-bold">Execute & Document</h5>
                    <p class="text-muted small">Professional project execution with comprehensive documentation</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="process-card text-center p-4">
                    <div class="process-number mb-3">03</div>
                    <i class="bi bi-graph-up fs-1 mb-3" style="color: #29a221;"></i>
                    <h5 class="fw-bold">Monitor & Evaluate</h5>
                    <p class="text-muted small">Real-time tracking and impact assessment</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                <div class="process-card text-center p-4">
                    <div class="process-number mb-3">04</div>
                    <i class="bi bi-broadcast fs-1 mb-3" style="color: #29a221;"></i>
                    <h5 class="fw-bold">Amplify & Sustain</h5>
                    <p class="text-muted small">Media amplification and long-term sustainability planning</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="cta-section py-5" style="background: linear-gradient(135deg, #1a2b4c 0%, #2a3f66 100%);">
    <div class="container py-4">
        <div class="row align-items-center">
            <div class="col-lg-8 text-white" data-aos="fade-right">
                <h2 class="display-5 fw-bold mb-3">Ready to Build Your Legacy?</h2>
                <p class="lead mb-0">Let's turn your vision into documented, verifiable, and lasting impact.</p>
            </div>
            <div class="col-lg-4 text-lg-end mt-4 mt-lg-0" data-aos="fade-left">
                <a href="{{ route('contact') }}" class="btn btn-gold btn-lg px-5 py-3 rounded-pill">
                    <i class="bi bi-chat-dots me-2"></i>Discuss Your Project
                </a>
            </div>
        </div>
    </div>
</section>

<style>
    /* Service Card Styles */
    .service-card {
        transition: all 0.3s ease;
        background: white;
        border: 1px solid rgba(0,0,0,0.05);
    }

    .service-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(26, 43, 76, 0.1) !important;
        border-color: #ffc107;
    }

    .service-icon {
        transition: all 0.3s ease;
    }

    .service-card:hover .service-icon i {
        transform: scale(1.1);
        color: #ffc107 !important;
    }

    /* Process Card */
    .process-card {
        background: white;
        border-radius: 16px;
        transition: all 0.3s ease;
        border: 1px solid rgba(0,0,0,0.05);
    }

    .process-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(41, 162, 33, 0.1);
        border-color: #29a221;
    }

    .process-number {
        font-size: 3rem;
        font-weight: 800;
        color: rgba(26, 43, 76, 0.1);
        line-height: 1;
    }

    /* Custom Button Styles */
    .btn-gold {
        background: #ffc107;
        color: #1a2b4c;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-gold:hover {
        background: #e6b006;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(255, 193, 7, 0.3);
    }

    .btn-outline-gold {
        border: 2px solid #ffc107;
        color: #1a2b4c;
        background: transparent;
        transition: all 0.3s ease;
    }

    .btn-outline-gold:hover {
        background: #ffc107;
        color: #1a2b4c;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(255, 193, 7, 0.2);
    }

    /* Tab Styles */
    .nav-pills .nav-link {
        color: #1a2b4c;
        border-radius: 50px;
        padding: 10px 20px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .nav-pills .nav-link:hover {
        background: rgba(255, 193, 7, 0.1);
    }

    .nav-pills .nav-link.active {
        background: #ffc107;
        color: #1a2b4c;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .display-4 {
            font-size: 2.5rem;
        }
        .stat-number {
            font-size: 2rem !important;
        }
        .nav-pills .nav-link {
            font-size: 0.9rem;
            padding: 8px 12px;
        }
    }

    /* Animation */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .service-card {
        animation: fadeInUp 0.6s ease-out;
    }
</style>
@endsection
