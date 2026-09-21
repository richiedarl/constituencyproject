@extends('layouts.app')

@section('title', 'Contact Us - Constituency Project Ltd')

@section('meta')
<meta name="description" content="Get in touch with Constituency Project Ltd. Let's discuss how we can help turn your vision into documented, verifiable, and lasting impact.">
@endsection

@section('content')
<!-- Hero Section -->
<section class="contact-hero py-5" style="background: linear-gradient(135deg, #1a2b4c 0%, #2a3f66 100%);">
    <div class="container py-4">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center text-white">
                <h1 class="display-4 fw-bold mb-4" data-aos="fade-up">Let's Bring Your Work To Endless Limelight</h1>
                <p class="lead mb-0" data-aos="fade-up" data-aos-delay="100">
                    Have a project in mind? Want to discuss how we can help document your legacy?
                    Reach out to us today.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="contact-section py-5">
    <div class="container">
        <div class="row g-5">
            <!-- Contact Information -->
            <div class="col-lg-5" data-aos="fade-right">
                <div class="contact-info pe-lg-4">
                    <div class="section-header mb-4">
                        <span class="badge bg-gold px-4 py-2 mb-3 rounded-pill" style="background: #ffc107; color: #1a2b4c;">
                            <i class="bi bi-chat-dots me-2"></i>Get In Touch
                        </span>
                        <h2 class="display-6 fw-bold mb-3" style="color: #1a2b4c;">We'd Love to Hear From You</h2>
                        <p class="text-muted">
                            Whether you're a political leader looking to document your legacy, a contractor seeking opportunities,
                            or a citizen wanting to support projects, we're here to help.
                        </p>
                    </div>

                    <!-- Office Address -->
                    <div class="info-card p-4 rounded-4 shadow-sm mb-4" style="background: white; border-left: 4px solid #29a221;">
                        <div class="d-flex">
                            <div class="icon me-3">
                                <i class="bi bi-geo-alt-fill fs-2" style="color: #29a221;"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-2">Head Office</h5>
                                <p class="text-muted mb-1">547 Madison Avenue</p>
                                <p class="text-muted mb-1">Central Business District</p>
                                <p class="text-muted">FCT, Abuja, Nigeria</p>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Details -->
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <div class="info-card p-4 rounded-4 shadow-sm h-100" style="background: white;">
                                <div class="text-center">
                                    <i class="bi bi-telephone-fill fs-2 mb-3" style="color: #ffc107;"></i>
                                    <h6 class="fw-bold mb-2">Phone Numbers</h6>
                                    <p class="text-muted small mb-1">+234 (0) 809 000 1234</p>
                                    <p class="text-muted small">+234 (0) 809 000 5678</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-card p-4 rounded-4 shadow-sm h-100" style="background: white;">
                                <div class="text-center">
                                    <i class="bi bi-envelope-fill fs-2 mb-3" style="color: #29a221;"></i>
                                    <h6 class="fw-bold mb-2">Email Addresses</h6>
                                    <p class="text-muted small mb-1">info@constituencyproject.org</p>
                                    <p class="text-muted small">projects@constituencyproject.org</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Business Hours -->
                    <div class="info-card p-4 rounded-4 shadow-sm mb-4" style="background: white; border-left: 4px solid #ffc107;">
                        <div class="d-flex">
                            <div class="icon me-3">
                                <i class="bi bi-clock-history fs-2" style="color: #ffc107;"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-2">Business Hours</h5>
                                <p class="text-muted mb-1"><strong>Monday - Friday:</strong> 8:00 AM - 6:00 PM</p>
                                <p class="text-muted mb-1"><strong>Saturday:</strong> 9:00 AM - 2:00 PM</p>
                                <p class="text-muted"><strong>Sunday:</strong> Closed</p>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div class="social-links">
                        <h5 class="fw-bold mb-3">Connect With Us</h5>
                        <div class="d-flex gap-3">
                            <a href="#" class="social-icon" style="background: #1877f2; color: white; width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; border-radius: 50%; transition: all 0.3s ease;">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="#" class="social-icon" style="background: #1da1f2; color: white; width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; border-radius: 50%; transition: all 0.3s ease;">
                                <i class="bi bi-twitter-x"></i>
                            </a>
                            <a href="#" class="social-icon" style="background: #0077b5; color: white; width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; border-radius: 50%; transition: all 0.3s ease;">
                                <i class="bi bi-linkedin"></i>
                            </a>
                            <a href="#" class="social-icon" style="background: #e4405f; color: white; width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; border-radius: 50%; transition: all 0.3s ease;">
                                <i class="bi bi-instagram"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="col-lg-7" data-aos="fade-left">
                <div class="contact-form-wrapper bg-white rounded-4 shadow-lg p-5">
                    <h3 class="fw-bold mb-4" style="color: #1a2b4c;">Send Us a Message</h3>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show border-0" style="background: rgba(41, 162, 33, 0.1); border-left: 4px solid #29a221;">
                            <i class="bi bi-check-circle-fill me-2" style="color: #29a221;"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('contact.store') }}" method="POST" id="contactForm">
                        @csrf

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control form-control-lg @error('name') is-invalid @enderror"
                                   id="name"
                                   name="name"
                                   value="{{ old('name') }}"
                                   placeholder="Enter your full name"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email & Phone Row -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                                <input type="email"
                                       class="form-control form-control-lg @error('email') is-invalid @enderror"
                                       id="email"
                                       name="email"
                                       value="{{ old('email') }}"
                                       placeholder="you@example.com"
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label fw-semibold">Phone Number</label>
                                <input type="tel"
                                       class="form-control form-control-lg @error('phone') is-invalid @enderror"
                                       id="phone"
                                       name="phone"
                                       value="{{ old('phone') }}"
                                       placeholder="+234 XXX XXX XXXX">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Subject -->
                        <div class="mb-3">
                            <label for="subject" class="form-label fw-semibold">Subject <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control form-control-lg @error('subject') is-invalid @enderror"
                                   id="subject"
                                   name="subject"
                                   value="{{ old('subject') }}"
                                   placeholder="What is this regarding?"
                                   required>
                            @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Inquiry Type -->
                        <div class="mb-3">
                            <label for="type" class="form-label fw-semibold">Inquiry Type <span class="text-danger">*</span></label>
                            <select class="form-select form-select-lg @error('type') is-invalid @enderror"
                                    id="type"
                                    name="type"
                                    required
                                    onchange="toggleCandidateField()">
                                <option value="">Select inquiry type</option>
                                <option value="general" {{ old('type') == 'general' ? 'selected' : '' }}>General Inquiry</option>
                                <option value="candidate_inquiry" {{ old('type') == 'candidate_inquiry' ? 'selected' : '' }}>Candidate/Project Inquiry</option>
                                <option value="partnership" {{ old('type') == 'partnership' ? 'selected' : '' }}>Partnership Opportunity</option>
                                <option value="technical_support" {{ old('type') == 'technical_support' ? 'selected' : '' }}>Technical Support</option>
                                <option value="license_request" {{ old('type') == 'license_request' ? 'selected' : '' }}>License Key Request</option>
                                <option value="media" {{ old('type') == 'media' ? 'selected' : '' }}>Media/Press Inquiry</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Candidate Selection (shown only for candidate inquiries) -->
                        <div class="mb-3" id="candidate-field" style="display: none;">
                            <label for="candidate_id" class="form-label fw-semibold">Select Candidate <span class="text-danger">*</span></label>
                            <select class="form-select form-select-lg @error('candidate_id')
                             is-invalid @enderror"
                                    id="candidate_id"
                                    name="candidate_id">
                                <option value="">Choose a candidate</option>
                                @foreach($candidates as $candidate)
                                    <option value="{{ $candidate->id }}" {{ old('candidate_id') == $candidate->id ? 'selected' : '' }}>
                                        {{ $candidate->name }} - {{ $candidate->district ?? 'No district' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('candidate_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Select the candidate your inquiry relates to</small>
                        </div>

                        <!-- Message -->
                        <div class="mb-4">
                            <label for="content" class="form-label fw-semibold">Message <span class="text-danger">*</span></label>
                            <textarea class="form-control form-control-lg @error('content') is-invalid @enderror"
                                      id="content"
                                      name="content"
                                      rows="6"
                                      placeholder="Please provide details about your inquiry..."
                                      required>{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-gold btn-lg w-100 py-3 rounded-3" id="submitBtn">
                            <i class="bi bi-send me-2"></i>Send Message
                        </button>

                        <!-- Form Footer -->
                        <p class="text-center text-muted small mt-3">
                            <i class="bi bi-shield-check me-1" style="color: #29a221;"></i>
                            Your information is secure and will only be used to respond to your inquiry.
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="map-section py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="map-container rounded-4 overflow-hidden shadow-lg">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3939.876543210123!2d7.495!3d9.083!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zOcKwMDUnMjAuMCJOIDfCsDI5JzQwLjAiRQ!5e0!3m2!1sen!2sng!4v1234567890"
                        width="100%"
                        height="450"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="faq-section py-5">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="badge bg-gold px-4 py-2 mb-3 rounded-pill" style="background: #ffc107; color: #1a2b4c;">
                <i class="bi bi-question-circle me-2"></i>FAQs
            </span>
            <h2 class="display-5 fw-bold mb-3" style="color: #1a2b4c;">Frequently Asked Questions</h2>
            <p class="text-muted mx-auto" style="max-width: 700px;">
                Quick answers to common questions. If you don't see your question here, feel free to contact us.
            </p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item border-0 mb-3 rounded-3 shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed bg-white rounded-3" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                <i class="bi bi-question-circle-fill me-3" style="color: #29a221;"></i>
                                How quickly do you respond to inquiries?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted">
                                We typically respond to all inquiries within 24-48 hours during business days. For urgent matters, we recommend calling our phone lines directly.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-3 rounded-3 shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed bg-white rounded-3" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                <i class="bi bi-question-circle-fill me-3" style="color: #29a221;"></i>
                                How can I request a license key for candidate reports?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted">
                                You can request a license key by selecting "License Key Request" from the inquiry type dropdown. Please provide details about which candidate's report you need access to and your reason for request. Admin will review and respond with the key if approved.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-3 rounded-3 shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed bg-white rounded-3" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                <i class="bi bi-question-circle-fill me-3" style="color: #29a221;"></i>
                                Can I partner with Constituency Project?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted">
                                Yes! We're always open to partnerships with organizations, government agencies, and private sector entities. Select "Partnership Opportunity" from the inquiry type dropdown, and our team will reach out to discuss potential collaboration.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-3 rounded-3 shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed bg-white rounded-3" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                <i class="bi bi-question-circle-fill me-3" style="color: #29a221;"></i>
                                Do you have offices in other states?
                            </button>
                        </h2>
                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted">
                                Our headquarters is in Abuja, but we have project teams working across Nigeria. We operate in all 36 states through our network of partners and field staff. Contact us to discuss projects in your area.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    /* Contact Info Cards */
    .info-card {
        transition: all 0.3s ease;
    }

    .info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(26, 43, 76, 0.1) !important;
    }

    /* Social Icons */
    .social-icon:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }

    /* Form Styles */
    .form-control-lg, .form-select-lg {
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
        font-size: 1rem;
    }

    .form-control-lg:focus, .form-select-lg:focus {
        border-color: #29a221;
        box-shadow: 0 0 0 0.2rem rgba(41, 162, 33, 0.25);
    }

    .btn-gold {
        background: #ffc107;
        color: #1a2b4c;
        border: none;
        transition: all 0.3s ease;
        font-weight: 600;
    }

    .btn-gold:hover {
        background: #e6b006;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(255, 193, 7, 0.3);
    }

    .btn-gold:active {
        transform: translateY(0);
    }

    /* Accordion Styles */
    .accordion-item {
        overflow: hidden;
    }

    .accordion-button:not(.collapsed) {
        background: rgba(41, 162, 33, 0.05);
        color: #29a221;
        box-shadow: none;
    }

    .accordion-button:focus {
        box-shadow: none;
        border-color: rgba(41, 162, 33, 0.1);
    }

    /* Map Container */
    .map-container {
        height: 450px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .display-4 {
            font-size: 2.5rem;
        }
        .contact-form-wrapper {
            padding: 2rem !important;
        }
        .map-container {
            height: 300px;
        }
    }

    /* Loading State */
    .btn-gold.loading {
        position: relative;
        pointer-events: none;
        opacity: 0.8;
    }

    .btn-gold.loading::after {
        content: '';
        position: absolute;
        width: 20px;
        height: 20px;
        border: 2px solid transparent;
        border-top-color: #1a2b4c;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
    }

    @keyframes spin {
        to { transform: translateY(-50%) rotate(360deg); }
    }

    /* Success Animation */
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .alert-success {
        animation: slideIn 0.5s ease-out;
    }
</style>

@push('scripts')
<script>
    // Toggle candidate field based on inquiry type
    function toggleCandidateField() {
        const type = document.getElementById('type').value;
        const candidateField = document.getElementById('candidate-field');
        const candidateSelect = document.getElementById('candidate_id');

        if (type === 'candidate_inquiry' || type === 'license_request') {
            candidateField.style.display = 'block';
            candidateSelect.required = true;
        } else {
            candidateField.style.display = 'none';
            candidateSelect.required = false;
            candidateSelect.value = '';
        }
    }

    // Form submission animation
    document.getElementById('contactForm').addEventListener('submit', function(e) {
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.classList.add('loading');
        submitBtn.innerHTML = 'Sending... <i class="bi bi-hourglass-split ms-2"></i>';
    });

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        toggleCandidateField();

        // Smooth scroll to form if there's an error
        if (document.querySelector('.is-invalid')) {
            document.querySelector('.contact-form-wrapper').scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });
</script>
@endpush
@endsection
