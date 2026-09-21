@extends('layouts.app')

@section('title', 'Documentation - Constituency Project')

@section('content')
<!-- Hero Section -->
<section class="docs-hero py-5" style="background: linear-gradient(135deg, #29a221 0%, #ffc107 100%);">
    <div class="container py-4">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center text-white">
                <h1 class="display-4 fw-bold mb-4" data-aos="fade-up">Platform Documentation</h1>
                <p class="lead mb-4" data-aos="fade-up" data-aos-delay="100">
                    Everything you need to know about Constituency Project - roles, features, and how to make the most of the platform.
                </p>
                <div class="d-flex justify-content-center gap-3" data-aos="fade-up" data-aos-delay="200">
                    <button onclick="downloadDocumentation()" class="btn btn-light btn-lg px-5 py-3 rounded-pill">
                        <i class="bi bi-download me-2"></i>Download PDF
                    </button>
                    <a href="#docs-content" class="btn btn-outline-light btn-lg px-5 py-3 rounded-pill">
                        <i class="bi bi-arrow-down me-2"></i>Browse Online
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Documentation Navigation -->
<section class="docs-nav py-4 bg-white shadow-sm" id="docs-content">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="nav nav-pills justify-content-center gap-2 flex-wrap" id="docsTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="getting-started-tab" data-bs-toggle="pill" data-bs-target="#getting-started" type="button" role="tab">Getting Started</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="roles-tab" data-bs-toggle="pill" data-bs-target="#roles" type="button" role="tab">Roles Overview</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="candidates-tab" data-bs-toggle="pill" data-bs-target="#candidates" type="button" role="tab">For Candidates</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="contractors-tab" data-bs-toggle="pill" data-bs-target="#contractors" type="button" role="tab">For Contractors</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="contributors-tab" data-bs-toggle="pill" data-bs-target="#contributors" type="button" role="tab">For Contributors</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="reports-tab" data-bs-toggle="pill" data-bs-target="#reports" type="button" role="tab">Reports & Keys</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="admin-tab" data-bs-toggle="pill" data-bs-target="#admin" type="button" role="tab">Admin Guide</button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Documentation Content -->
<section class="docs-content py-5" style="background: #f8f9fa;">
    <div class="container">
        <div class="tab-content" id="docsTabContent">
            <!-- Getting Started -->
            <div class="tab-pane fade show active" id="getting-started" role="tabpanel">
                @include('partials.getting-started')
            </div>

            <!-- Roles Overview -->
            <div class="tab-pane fade" id="roles" role="tabpanel">
                @include('partials.roles-overview')
            </div>

            <!-- For Candidates -->
            <div class="tab-pane fade" id="candidates" role="tabpanel">
                @include('partials.for-candidates')
            </div>

            <!-- For Contractors -->
            <div class="tab-pane fade" id="contractors" role="tabpanel">
                @include('partials.for-contractors')
            </div>

            <!-- For Contributors -->
            <div class="tab-pane fade" id="contributors" role="tabpanel">
                @include('partials.for-contributors')
            </div>

            <!-- Reports & Keys -->
            <div class="tab-pane fade" id="reports" role="tabpanel">
                @include('partials.reports-keys')
            </div>

            <!-- Admin Guide -->
            <div class="tab-pane fade" id="admin" role="tabpanel">
                @include('partials.admin-guide')
            </div>
        </div>
    </div>
</section>

<!-- Download Script -->
<script>
function downloadDocumentation() {
    // Create a hidden div with all documentation content
    const content = document.createElement('div');
    content.innerHTML = `
        <!DOCTYPE html>
        <html>
        <head>
            <title>Constituency Project Documentation</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 40px; }
                h1 { color: #29a221; }
                h2 { color: #ffc107; margin-top: 30px; }
                h3 { color: #29a221; }
                .section { margin-bottom: 40px; }
                .role-box {
                    background: #f8f9fa;
                    padding: 20px;
                    border-radius: 10px;
                    border-left: 4px solid #29a221;
                    margin-bottom: 20px;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 20px 0;
                }
                th, td {
                    border: 1px solid #ddd;
                    padding: 12px;
                    text-align: left;
                }
                th { background: #f2f2f2; }
                .badge {
                    display: inline-block;
                    padding: 5px 10px;
                    border-radius: 20px;
                    font-size: 12px;
                }
                .badge-success { background: #29a221; color: white; }
                .badge-warning { background: #ffc107; color: black; }
                .footer { margin-top: 50px; text-align: center; color: #666; }
            </style>
        </head>
        <body>
            <h1>Constituency Project Documentation</h1>
            <p>Generated on ${new Date().toLocaleDateString()}</p>

            <div class="section">
                <h2>Getting Started</h2>
                <p><strong>What is Constituency Project?</strong> A digital platform designed to bring transparency, accountability, and citizen participation to constituency projects across Nigeria.</p>
                <p>Constituency Project serves as a bridge between project owners (candidates), executors (contractors), and supporters (contributors). Every project is documented phase-by-phase with photos, updates, and verifiable progress tracking.</p>

                <h3>Platform Overview</h3>
                <ul>
                    <li><strong>Three Core Roles:</strong> Candidates, Contractors, and Contributors each have specific functions within the ecosystem.</li>
                    <li><strong>Documentation System:</strong> Every project is broken into phases with media, updates, and progress tracking.</li>
                    <li><strong>Wallet System:</strong> Contributors have wallets for funding, contractors can request withdrawals.</li>
                    <li><strong>Report Keys:</strong> Secure access to detailed candidate reports via license keys.</li>
                </ul>

                <h3>Registration Process</h3>
                <ol>
                    <li><strong>Step 1:</strong> Create Account - Provide name, email, username, and password. Select your desired role.</li>
                    <li><strong>Step 2:</strong> Email Verification - Verify your email through the link sent.</li>
                    <li><strong>Step 3:</strong> Complete Profile - Fill in role-specific details (bio, location, skills).</li>
                    <li><strong>Step 4:</strong> Admin Approval - Your application will be reviewed and approved.</li>
                </ol>
            </div>

            <div class="section">
                <h2>Role Comparison</h2>
                <table>
                    <tr>
                        <th>Feature</th>
                        <th>Candidate</th>
                        <th>Contractor</th>
                        <th>Contributor</th>
                    </tr>
                    <tr><td>Create Projects</td><td>✓</td><td>✗</td><td>✗</td></tr>
                    <tr><td>Apply for Projects</td><td>✗</td><td>✓</td><td>✗</td></tr>
                    <tr><td>Fund Projects</td><td>✗</td><td>✗</td><td>✓</td></tr>
                    <tr><td>Submit Daily Reports</td><td>✗</td><td>✓</td><td>✗</td></tr>
                    <tr><td>Access Candidate Reports</td><td>✓</td><td>✓</td><td>✓</td></tr>
                    <tr><td>Wallet (Receive Funds)</td><td>✓</td><td>✓</td><td>✓</td></tr>
                    <tr><td>Wallet (Send/Withdraw)</td><td>✗</td><td>✓</td><td>✓</td></tr>
                </table>
            </div>

            <div class="section">
                <h2>For Candidates</h2>
                <div class="role-box">
                    <h3>What Candidates Can Do:</h3>
                    <ul>
                        <li><strong>Create Projects:</strong> Initiate new projects with detailed descriptions, budgets, and timelines</li>
                        <li><strong>Manage Phases:</strong> Break down projects into manageable phases with weights and statuses</li>
                        <li><strong>Review Applications:</strong> Review and approve contractor applications</li>
                        <li><strong>Track Progress:</strong> Monitor project completion through contractor updates</li>
                        <li><strong>Generate Reports:</strong> Access detailed reports of all projects and phases</li>
                    </ul>
                    <h3>How to Register as a Candidate:</h3>
                    <ol>
                        <li>Select "Candidate" during registration</li>
                        <li>Complete profile with bio, district, state, and contact information</li>
                        <li>Upload a profile photo and provide your position details</li>
                        <li>Pay the application fee (if applicable)</li>
                        <li>Wait for admin approval to start creating projects</li>
                    </ol>
                </div>
            </div>

            <div class="section">
                <h2>For Contractors</h2>
                <div class="role-box">
                    <h3>What Contractors Can Do:</h3>
                    <ul>
                        <li><strong>Browse Projects:</strong> View available projects and apply to work on them</li>
                        <li><strong>Submit Applications:</strong> Apply for projects that match your skills</li>
                        <li><strong>Daily Reports:</strong> Submit daily progress reports with photos and comments</li>
                        <li><strong>Track Earnings:</strong> Monitor payments and request withdrawals</li>
                        <li><strong>Portfolio Building:</strong> Build a portfolio of completed projects</li>
                    </ul>
                    <h3>How to Register as a Contractor:</h3>
                    <ol>
                        <li>Select "Contractor" during registration</li>
                        <li>Complete profile with skills, occupation, and experience</li>
                        <li>Upload credentials and certifications</li>
                        <li>Wait for admin approval to start applying</li>
                        <li>Once approved, browse and apply for projects</li>
                    </ol>
                </div>
            </div>

            <div class="section">
                <h2>For Contributors</h2>
                <div class="role-box">
                    <h3>What Contributors Can Do:</h3>
                    <ul>
                        <li><strong>Fund Wallet:</strong> Add funds to your wallet via card, bank transfer, or USSD</li>
                        <li><strong>Support Projects:</strong> Donate to projects you believe in</li>
                        <li><strong>Track Impact:</strong> Monitor how your contributions are being used</li>
                        <li><strong>Leaderboard Recognition:</strong> Get recognized as a top contributor</li>
                        <li><strong>View Reports:</strong> Access candidate reports with valid license keys</li>
                    </ul>
                    <h3>How to Register as a Contributor:</h3>
                    <ol>
                        <li>Select "Contributor" during registration</li>
                        <li>Complete profile with location and bio</li>
                        <li>Fund your wallet to start contributing</li>
                        <li>Browse projects and support those you care about</li>
                        <li>Track your impact and climb the leaderboard</li>
                    </ol>
                </div>
            </div>

            <div class="section">
                <h2>Reports & License Keys</h2>
                <h3>License Keys</h3>
                <p>License keys are required to access full candidate reports.</p>
                <ul>
                    <li><strong>One-Time Use:</strong> Each key can only be used once</li>
                    <li><strong>Expiration:</strong> Keys expire after a set period (usually 30 days)</li>
                    <li><strong>Candidate-Specific:</strong> Keys are tied to specific candidates</li>
                    <li><strong>Admin Generated:</strong> Only administrators can create keys</li>
                </ul>

                <h3>Requesting License Keys</h3>
                <ol>
                    <li>Navigate to Candidate Profile</li>
                    <li>Click "Request Key" on the preview page</li>
                    <li>Fill form with name, email, phone, and reason</li>
                    <li>Submit - request sent to administrators</li>
                    <li>Wait for approval - admin will email you the key</li>
                </ol>
            </div>

            <div class="section">
                <h2>Admin Guide</h2>
                <h3>Creating License Keys</h3>
                <ol>
                    <li>Go to Report Keys → Generate Key</li>
                    <li>Select Candidate from dropdown</li>
                    <li>Set Expiry days (1-365)</li>
                    <li>Click "Generate License Key"</li>
                    <li>Share the generated key with requester</li>
                </ol>

                <h3>Managing Key Requests</h3>
                <ul>
                    <li>Review user information and reason</li>
                    <li>Approve to generate a key</li>
                    <li>Reject with reason if inappropriate</li>
                </ul>

                <h3>Report Approval</h3>
                <ul>
                    <li>View pending reports in Reports → Pending</li>
                    <li>Review comments and photos</li>
                    <li>Approve to make public</li>
                    <li>Reject with reason to return to contractor</li>
                </ul>

                <h3>Wallet Management</h3>
                <ul>
                    <li><strong>Pending Funding:</strong> Review and approve funding requests</li>
                    <li><strong>Pending Withdrawals:</strong> Review and approve withdrawal requests</li>
                </ul>

                <h3>Role Change Requests</h3>
                <ul>
                    <li>View all requests in Role Requests section</li>
                    <li>Review current and requested role</li>
                    <li>Approve to transfer data and create new role</li>
                    <li>Reject with reason if not appropriate</li>
                </ul>
            </div>

            <div class="footer">
                <p>© {{ date('Y') }} Constituency Project. All rights reserved.</p>
                <p>For more information, visit our website or contact support.</p>
            </div>
        </body>
        </html>
    `;

    // Create blob and download
    const blob = new Blob([content.innerHTML], { type: 'text/html' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'constituency-project-documentation.html';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    window.URL.revokeObjectURL(url);
}
</script>

<style>
.nav-pills .nav-link {
    color: #212529;
    border-radius: 50px;
    padding: 10px 20px;
    font-weight: 500;
}

.nav-pills .nav-link:hover {
    background: rgba(41, 162, 33, 0.1);
}

.nav-pills .nav-link.active {
    background: linear-gradient(135deg, #29a221 0%, #ffc107 100%);
    color: white;
}

.docs-sidebar {
    top: 100px;
}

.docs-sidebar .nav-link {
    padding: 8px 16px;
    color: #6c757d;
    border-left: 3px solid transparent;
}

.docs-sidebar .nav-link:hover {
    color: #29a221;
    border-left-color: #29a221;
    background: rgba(41, 162, 33, 0.05);
}

.role-icon {
    transition: all 0.3s ease;
}

.step-number .badge {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
}

.feature-box {
    transition: all 0.3s ease;
}

.feature-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(41, 162, 33, 0.1);
}

@media print {
    .docs-hero, .docs-nav, .btn, footer {
        display: none !important;
    }
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.tab-pane {
    animation: fadeIn 0.5s ease-out;
}
</style>

@push('scripts')
<script>
// Smooth scroll for anchor links
document.querySelectorAll('.docs-sidebar a').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        const targetId = this.getAttribute('href');
        const targetElement = document.querySelector(targetId);
        if (targetElement) {
            targetElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });
});

// Add active state to sidebar links based on scroll
window.addEventListener('scroll', function() {
    const sections = document.querySelectorAll('.docs-main .card');
    const navLinks = document.querySelectorAll('.docs-sidebar .nav-link');

    let current = '';
    sections.forEach(section => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.clientHeight;
        if (pageYOffset >= sectionTop - 200) {
            current = section.getAttribute('id');
        }
    });

    navLinks.forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href') === '#' + current) {
            link.classList.add('active');
        }
    });
});
</script>
@endpush
@endsection
