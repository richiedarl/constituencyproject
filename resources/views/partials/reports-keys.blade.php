<div class="row">
    <div class="col-lg-3 mb-4">
        <div class="docs-sidebar position-sticky" style="top: 100px;">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Reports Guide</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#report-overview" class="text-decoration-none">Report Overview</a></li>
                        <li class="mb-2"><a href="#license-keys" class="text-decoration-none">License Keys</a></li>
                        <li class="mb-2"><a href="#requesting-keys" class="text-decoration-none">Requesting Keys</a></li>
                        <li class="mb-2"><a href="#report-format" class="text-decoration-none">Report Format</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-9">
        <div class="docs-main">
            <div class="card border-0 shadow-lg rounded-4 mb-4" id="report-overview">
                <div class="card-body p-5">
                    <h2 class="fw-bold mb-4" style="color: #29a221;">Report Overview</h2>
                    <p class="lead mb-4">Candidate reports provide comprehensive documentation of all projects, phases, updates, and media associated with a candidate.</p>
                    <p class="text-muted mb-4">Each report includes:</p>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="p-3 rounded-3 bg-light">
                                <i class="bi bi-person fs-4 mb-2" style="color: #29a221;"></i>
                                <h6 class="fw-bold">Candidate Information</h6>
                                <small class="text-muted">Bio, contact, location, and positions held</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 rounded-3 bg-light">
                                <i class="bi bi-building fs-4 mb-2" style="color: #ffc107;"></i>
                                <h6 class="fw-bold">Project Details</h6>
                                <small class="text-muted">All projects with descriptions and budgets</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 rounded-3 bg-light">
                                <i class="bi bi-diagram-3 fs-4 mb-2" style="color: #29a221;"></i>
                                <h6 class="fw-bold">Phase Breakdown</h6>
                                <small class="text-muted">Each project phase with status and progress</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 rounded-3 bg-light">
                                <i class="bi bi-camera fs-4 mb-2" style="color: #ffc107;"></i>
                                <h6 class="fw-bold">Media Gallery</h6>
                                <small class="text-muted">Photos and documents for each phase</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-lg rounded-4 mb-4" id="license-keys">
                <div class="card-body p-5">
                    <h2 class="fw-bold mb-4" style="color: #ffc107;">License Keys</h2>
                    <div class="alert alert-info border-0 mb-4">
                        <i class="bi bi-key-fill me-2" style="color: #29a221;"></i>
                        License keys are required to access full candidate reports.
                    </div>
                    <h5 class="fw-bold mb-3">How License Keys Work:</h5>
                    <ul class="list-group mb-4">
                        <li class="list-group-item border-0 bg-light mb-2 p-3 rounded-3">
                            <strong>One-Time Use:</strong> Each key can only be used once
                        </li>
                        <li class="list-group-item border-0 bg-light mb-2 p-3 rounded-3">
                            <strong>Expiration:</strong> Keys expire after a set period (usually 30 days)
                        </li>
                        <li class="list-group-item border-0 bg-light mb-2 p-3 rounded-3">
                            <strong>Candidate-Specific:</strong> Keys are tied to specific candidates
                        </li>
                        <li class="list-group-item border-0 bg-light p-3 rounded-3">
                            <strong>Admin Generated:</strong> Only administrators can create keys
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card border-0 shadow-lg rounded-4 mb-4" id="requesting-keys">
                <div class="card-body p-5">
                    <h2 class="fw-bold mb-4" style="color: #29a221;">Requesting License Keys</h2>
                    <p class="mb-4">To request a license key for a candidate's report:</p>
                    <ol class="list-group list-group-numbered mb-4">
                        <li class="list-group-item border-0 bg-light mb-2 p-3 rounded-3">
                            <strong>Navigate to Candidate Profile:</strong> Find the candidate whose report you want
                        </li>
                        <li class="list-group-item border-0 bg-light mb-2 p-3 rounded-3">
                            <strong>Click "Request Key":</strong> On the preview page, click the request button
                        </li>
                        <li class="list-group-item border-0 bg-light mb-2 p-3 rounded-3">
                            <strong>Fill Form:</strong> Provide your name, email, phone, and reason for request
                        </li>
                        <li class="list-group-item border-0 bg-light mb-2 p-3 rounded-3">
                            <strong>Submit:</strong> Your request will be sent to administrators
                        </li>
                        <li class="list-group-item border-0 bg-light p-3 rounded-3">
                            <strong>Wait for Approval:</strong> Admin will review and email you the key if approved
                        </li>
                    </ol>
                </div>
            </div>

            <div class="card border-0 shadow-lg rounded-4" id="report-format">
                <div class="card-body p-5">
                    <h2 class="fw-bold mb-4" style="color: #ffc107;">Report Format</h2>
                    <p class="mb-4">Full reports include the following sections:</p>
                    <div class="accordion" id="reportAccordion">
                        <div class="accordion-item border-0 mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed bg-light rounded-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                    Candidate Information Section
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#reportAccordion">
                                <div class="accordion-body">
                                    <ul>
                                        <li>Name and photo</li>
                                        <li>Contact details (email, phone)</li>
                                        <li>Location (district, state)</li>
                                        <li>Biography</li>
                                        <li>Positions held with dates</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item border-0 mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed bg-light rounded-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                    Projects Overview
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#reportAccordion">
                                <div class="accordion-body">
                                    <ul>
                                        <li>List of all projects with status</li>
                                        <li>Total projects count</li>
                                        <li>Active vs completed projects</li>
                                        <li>Total budget across all projects</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item border-0 mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed bg-light rounded-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                                    Detailed Project Information
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#reportAccordion">
                                <div class="accordion-body">
                                    <ul>
                                        <li>Project title and description</li>
                                        <li>Full location details</li>
                                        <li>Start and completion dates</li>
                                        <li>Estimated budget</li>
                                        <li>Progress percentage</li>
                                        <li>Phase-by-phase breakdown</li>
                                        <li>Daily updates from contractors</li>
                                        <li>Media files for each phase</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
