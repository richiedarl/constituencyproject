<div class="row">
    <div class="col-lg-3 mb-4">
        <div class="docs-sidebar position-sticky" style="top: 100px;">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Admin Topics</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#admin-dashboard" class="text-decoration-none">Dashboard Overview</a></li>
                        <li class="mb-2"><a href="#admin-applications" class="text-decoration-none">Managing Applications</a></li>
                        <li class="mb-2"><a href="#admin-keys" class="text-decoration-none">Creating License Keys</a></li>
                        <li class="mb-2"><a href="#admin-key-requests" class="text-decoration-none">Key Requests</a></li>
                        <li class="mb-2"><a href="#admin-reports" class="text-decoration-none">Report Approval</a></li>
                        <li class="mb-2"><a href="#admin-wallet" class="text-decoration-none">Wallet Management</a></li>
                        <li class="mb-2"><a href="#admin-role-changes" class="text-decoration-none">Role Change Requests</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-9">
        <div class="docs-main">
            <div class="card border-0 shadow-lg rounded-4 mb-4" id="admin-dashboard">
                <div class="card-body p-5">
                    <h2 class="fw-bold mb-4" style="color: #29a221;">Admin Dashboard Overview</h2>
                    <p class="lead mb-4">The admin dashboard provides a centralized view of all platform activities.</p>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="p-3 rounded-3" style="background: rgba(41, 162, 33, 0.05);">
                                <h6 class="fw-bold"><i class="bi bi-file-text me-2" style="color: #29a221;"></i>Applications</h6>
                                <small class="text-muted">Review candidate, contractor, and contributor applications</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 rounded-3" style="background: rgba(255, 193, 7, 0.05);">
                                <h6 class="fw-bold"><i class="bi bi-key me-2" style="color: #ffc107;"></i>License Keys</h6>
                                <small class="text-muted">Generate and manage report access keys</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 rounded-3" style="background: rgba(41, 162, 33, 0.05);">
                                <h6 class="fw-bold"><i class="bi bi-file-check me-2" style="color: #29a221;"></i>Reports</h6>
                                <small class="text-muted">Approve or reject daily contractor reports</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 rounded-3" style="background: rgba(255, 193, 7, 0.05);">
                                <h6 class="fw-bold"><i class="bi bi-wallet me-2" style="color: #ffc107;"></i>Wallet</h6>
                                <small class="text-muted">Manage funding and withdrawal requests</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-lg rounded-4 mb-4" id="admin-applications">
                <div class="card-body p-5">
                    <h2 class="fw-bold mb-4" style="color: #ffc107;">Managing Applications</h2>
                    <p class="mb-4">Review and approve user applications for different roles:</p>

                    <div class="application-types mb-4">
                        <div class="d-flex mb-3">
                            <div class="me-3">
                                <span class="badge bg-primary rounded-circle p-3">C</span>
                            </div>
                            <div>
                                <h6 class="fw-bold">Candidate Applications</h6>
                                <p class="text-muted">Review candidate credentials, position details, and application fee payment. Approve to allow project creation.</p>
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <div class="me-3">
                                <span class="badge bg-warning rounded-circle p-3">CT</span>
                            </div>
                            <div>
                                <h6 class="fw-bold">Contractor Applications</h6>
                                <p class="text-muted">Verify skills, experience, certifications, and business registration. Approve to enable project applications.</p>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="me-3">
                                <span class="badge bg-success rounded-circle p-3">CB</span>
                            </div>
                            <div>
                                <h6 class="fw-bold">Contributor Applications</h6>
                                <p class="text-muted">Verify identity and approve to enable wallet funding and project contributions.</p>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info border-0">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <strong>Approval Process:</strong> Review each application carefully. Approved users gain full access to role-specific features.
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-lg rounded-4 mb-4" id="admin-keys">
                <div class="card-body p-5">
                    <h2 class="fw-bold mb-4" style="color: #29a221;">Creating License Keys</h2>
                    <p class="mb-4">Administrators can generate license keys for candidate reports:</p>
                    <ol class="list-group list-group-numbered mb-4">
                        <li class="list-group-item border-0 bg-light mb-2 p-3 rounded-3">
                            <strong>Navigate to Report Keys:</strong> Go to Report Keys → Generate Key
                        </li>
                        <li class="list-group-item border-0 bg-light mb-2 p-3 rounded-3">
                            <strong>Select Candidate:</strong> Choose the candidate from the dropdown
                        </li>
                        <li class="list-group-item border-0 bg-light mb-2 p-3 rounded-3">
                            <strong>Set Expiry:</strong> Choose number of days until key expires (1-365)
                        </li>
                        <li class="list-group-item border-0 bg-light mb-2 p-3 rounded-3">
                            <strong>Generate:</strong> Click "Generate License Key"
                        </li>
                        <li class="list-group-item border-0 bg-light p-3 rounded-3">
                            <strong>Share Key:</strong> Copy the generated key and share with the requester
                        </li>
                    </ol>
                    <div class="alert alert-warning border-0">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <strong>Note:</strong> Keys are one-time use and will expire after the set period.
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-lg rounded-4 mb-4" id="admin-key-requests">
                <div class="card-body p-5">
                    <h2 class="fw-bold mb-4" style="color: #ffc107;">Managing Key Requests</h2>
                    <p class="mb-4">When users request license keys, they appear in the Key Requests section:</p>
                    <div class="step-guide mb-4">
                        <div class="d-flex mb-3">
                            <div class="step-number me-3">
                                <span class="badge bg-primary rounded-circle p-3">1</span>
                            </div>
                            <div>
                                <h6 class="fw-bold">Review Request</h6>
                                <p class="text-muted">Check the user's information and reason for request</p>
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <div class="step-number me-3">
                                <span class="badge bg-success rounded-circle p-3">2</span>
                            </div>
                            <div>
                                <h6 class="fw-bold">Approve or Reject</h6>
                                <p class="text-muted">Click "Approve" to generate a key, or "Reject" with a reason</p>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="step-number me-3">
                                <span class="badge bg-info rounded-circle p-3">3</span>
                            </div>
                            <div>
                                <h6 class="fw-bold">Notify User</h6>
                                <p class="text-muted">System automatically handles notification (email integration pending)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-lg rounded-4 mb-4" id="admin-reports">
                <div class="card-body p-5">
                    <h2 class="fw-bold mb-4" style="color: #29a221;">Report Approval</h2>
                    <p class="mb-4">Contractor-submitted daily reports need admin approval:</p>
                    <ul class="list-group mb-4">
                        <li class="list-group-item border-0 bg-light mb-2 p-3 rounded-3">
                            <strong>Pending Reports:</strong> View all pending reports in the Reports → Pending section
                        </li>
                        <li class="list-group-item border-0 bg-light mb-2 p-3 rounded-3">
                            <strong>Review Content:</strong> Check the comment and photos for appropriateness
                        </li>
                        <li class="list-group-item border-0 bg-light mb-2 p-3 rounded-3">
                            <strong>Approve:</strong> Click "Approve" to make the report public
                        </li>
                        <li class="list-group-item border-0 bg-light p-3 rounded-3">
                            <strong>Reject:</strong> Provide a reason and click "Reject" to return the report
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card border-0 shadow-lg rounded-4 mb-4" id="admin-wallet">
                <div class="card-body p-5">
                    <h2 class="fw-bold mb-4" style="color: #ffc107;">Wallet Management</h2>
                    <p class="mb-4">Admins manage all financial transactions:</p>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="p-4 rounded-4" style="border: 1px solid rgba(41, 162, 33, 0.2);">
                                <h6 class="fw-bold mb-3"><i class="bi bi-arrow-down-circle me-2" style="color: #29a221;"></i>Pending Funding</h6>
                                <ul class="list-unstyled">
                                    <li class="mb-2"><i class="bi bi-check-circle me-2" style="color: #29a221;"></i>Review funding requests</li>
                                    <li class="mb-2"><i class="bi bi-check-circle me-2" style="color: #29a221;"></i>Approve to credit user wallets</li>
                                    <li><i class="bi bi-check-circle me-2" style="color: #29a221;"></i>Reject with reason</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-4 rounded-4" style="border: 1px solid rgba(255, 193, 7, 0.2);">
                                <h6 class="fw-bold mb-3"><i class="bi bi-arrow-up-circle me-2" style="color: #ffc107;"></i>Pending Withdrawals</h6>
                                <ul class="list-unstyled">
                                    <li class="mb-2"><i class="bi bi-check-circle me-2" style="color: #ffc107;"></i>Review withdrawal requests</li>
                                    <li class="mb-2"><i class="bi bi-check-circle me-2" style="color: #ffc107;"></i>Approve to complete transaction</li>
                                    <li><i class="bi bi-check-circle me-2" style="color: #ffc107;"></i>Reject to refund wallet</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-lg rounded-4" id="admin-role-changes">
                <div class="card-body p-5">
                    <h2 class="fw-bold mb-4" style="color: #29a221;">Role Change Requests</h2>
                    <p class="mb-4">Users can request to change their role. As admin:</p>
                    <ol class="list-group list-group-numbered">
                        <li class="list-group-item border-0 bg-light mb-2 p-3 rounded-3">
                            View all requests in Role Requests section
                        </li>
                        <li class="list-group-item border-0 bg-light mb-2 p-3 rounded-3">
                            Review the user's current role and requested role
                        </li>
                        <li class="list-group-item border-0 bg-light mb-2 p-3 rounded-3">
                            <strong>Approve:</strong> System automatically:
                            <ul class="mt-2">
                                <li>Deletes existing role records</li>
                                <li>Creates new role with preserved data</li>
                                <li>Updates user role field</li>
                            </ul>
                        </li>
                        <li class="list-group-item border-0 bg-light p-3 rounded-3">
                            <strong>Reject:</strong> Provide a reason and request is marked as rejected
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
