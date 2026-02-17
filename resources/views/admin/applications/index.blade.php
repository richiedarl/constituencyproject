@extends('layouts.admin')

@section('title', 'Applications Management')

@section('content')
<div class="container-fluid py-4">
    {{-- Header with Animated Gradient --}}
    <div class="animated-header mb-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="display-5 fw-bold text-white mb-2 animate__animated animate__fadeInLeft">
                    <i class="fas fa-clipboard-list me-3"></i>
                    Applications
                </h1>
                <p class="text-white-50 mb-0 animate__animated animate__fadeInLeft animate__delay-1s">
                    Manage contractor applications and approvals
                </p>
            </div>
            <div class="col-md-6 text-end">
                <div class="header-stats d-inline-flex gap-3">
                    <div class="stat-badge animate__animated animate__fadeInRight">
                        <span class="stat-label">Total</span>
                        <span class="stat-value">{{ $stats['total'] }}</span>
                    </div>
                    <div class="stat-badge animate__animated animate__fadeInRight animate__delay-1s">
                        <span class="stat-label">Pending</span>
                        <span class="stat-value text-warning">{{ $stats['pending'] }}</span>
                    </div>
                    <div class="stat-badge animate__animated animate__fadeInRight animate__delay-2s">
                        <span class="stat-label">Approved</span>
                        <span class="stat-value text-success">{{ $stats['approved'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- Applications Grid --}}
    <div class="row g-4" id="applicationsGrid">
        @forelse($applications as $application)
            <div class="col-md-6 col-xl-4 application-card" data-id="{{ $application->id }}">
                <div class="card h-100 border-0 shadow-sm hover-lift">
                    <div class="card-body">
                        {{-- Header with Status Toggle --}}
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h5 class="card-title mb-1">{{ $application->project->title ?? 'Unknown Project' }}</h5>
                                <p class="text-muted small mb-0">
                                    <i class="fas fa-user me-1"></i>
                                    {{ $application->contractor?->user?->name ?? 'Contractor Not Available' }}
                                </p>
                            </div>
                            <div class="status-toggle">
                                <div class="form-check form-switch">
                                    <input class="form-check-input status-switch"
                                           type="checkbox"
                                           role="switch"
                                           data-application-id="{{ $application->id }}"
                                           {{ $application->status === 'approved' ? 'checked' : '' }}
                                           {{ $application->status === 'cancelled' || !$application->contractor ? 'disabled' : '' }}>
                                </div>
                            </div>
                        </div>

                        {{-- Contractor Info --}}
                        <div class="contractor-info mb-3">
                            @if($application->contractor && $application->contractor->user)
                                <div class="d-flex align-items-center mb-2">
                                    <div class="avatar-circle me-2">
                                        {{ strtoupper(substr($application->contractor->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <span class="fw-semibold">{{ $application->contractor->user->email }}</span>
                                        <br>
                                        <span class="small text-muted">Since {{ $application->created_at->format('M d, Y') }}</span>
                                    </div>
                                </div>

                                {{-- Skills --}}
                                @if($application->contractor->skills && $application->contractor->skills->count() > 0)
                                    <div class="skills-wrapper mb-2">
                                        @foreach($application->contractor->skills->take(3) as $skill)
                                            <span class="skill-badge">{{ $skill->name }}</span>
                                        @endforeach
                                        @if($application->contractor->skills->count() > 3)
                                            <span class="skill-badge more">+{{ $application->contractor->skills->count() - 3 }}</span>
                                        @endif
                                    </div>
                                @else
                                    <p class="text-muted small mb-2">No skills listed</p>
                                @endif
                            @else
                                <div class="d-flex align-items-center mb-2">
                                    <div class="avatar-circle bg-secondary me-2">
                                        <i class="fas fa-user-slash text-white"></i>
                                    </div>
                                    <div>
                                        <span class="fw-semibold text-muted">Contractor Not Available</span>
                                        <br>
                                        <span class="small text-muted">Since {{ $application->created_at->format('M d, Y') }}</span>
                                    </div>
                                </div>
                                <p class="text-muted small mb-2">
                                    <i class="fas fa-exclamation-triangle text-warning me-1"></i>
                                    Contractor information is missing
                                </p>
                            @endif
                        </div>

                        {{-- Application Details --}}
                        <div class="application-details bg-light rounded-3 p-3 mb-3">
                            <div class="row g-2">
                                <div class="col-6">
                                    <small class="text-muted d-block">Application ID</small>
                                    <span class="fw-semibold">#{{ $application->id }}</span>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted d-block">Status</small>
                                    <span class="badge bg-{{ $application->status_badge ?? 'secondary' }} status-badge">
                                        {{ ucfirst($application->status) }}
                                    </span>
                                </div>
                                <div class="col-12 mt-2">
                                    <small class="text-muted d-block">Project Location</small>
                                    <span class="small">
                                        <i class="fas fa-map-marker-alt me-1 text-primary"></i>
                                        {{ $application->project?->full_location ?? 'Not specified' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="action-buttons d-flex gap-2">
                            @if($application->contractor)
                                <a href="{{ route('admin.applications.view-contractor', $application) }}"
                                   class="btn btn-outline-info btn-sm flex-grow-1 view-contractor-btn"
                                   data-contractor-id="{{ $application->contractor->id }}">
                                    <i class="fas fa-eye me-1"></i>
                                    View Contractor
                                </a>
                            @else
                                <button class="btn btn-outline-secondary btn-sm flex-grow-1" disabled>
                                    <i class="fas fa-eye-slash me-1"></i>
                                    Contractor Unavailable
                                </button>
                            @endif

                            @if($application->status !== 'cancelled' && $application->contractor)
                                <button type="button"
                                        class="btn btn-outline-danger btn-sm cancel-application"
                                        data-application-id="{{ $application->id }}"
                                        data-contractor-name="{{ $application->contractor->user->name ?? 'Unknown Contractor' }}"
                                        data-project-title="{{ $application->project->title ?? 'Unknown Project' }}">
                                    <i class="fas fa-ban me-1"></i>
                                    Cancel
                                </button>
                            @endif
                        </div>
                    </div>

                    {{-- Progress Indicator for Pending --}}
                    @if($application->status === 'pending' && $application->contractor)
                        <div class="card-footer bg-transparent border-0 pt-0">
                            <div class="pending-indicator">
                                <div class="progress" style="height: 3px;">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning"
                                         style="width: 100%"></div>
                                </div>
                                <small class="text-muted d-block text-center mt-2">
                                    <i class="fas fa-clock me-1"></i>
                                    Awaiting approval
                                </small>
                            </div>
                        </div>
                    @endif

                    {{-- Warning for applications with missing contractor --}}
                    @if(!$application->contractor)
                        <div class="card-footer bg-transparent border-0 pt-0">
                            <div class="alert alert-warning py-2 mb-0 small">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                This application has an orphaned contractor record
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="empty-state text-center py-5">
                    <div class="empty-state-icon mb-4">
                        <i class="fas fa-clipboard-list fa-4x text-muted"></i>
                    </div>
                    <h4 class="text-muted mb-3">No Applications Found</h4>
                    <p class="text-muted mb-4">There are no applications to display at this time.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>

{{-- Cancel Application Modal --}}
<div class="modal fade" id="cancelModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Cancel Application
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="cancelForm" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Are you sure you want to cancel the application from <strong id="contractorName"></strong> for project <strong id="projectTitle"></strong>?</p>

                    <div class="mb-3">
                        <label for="reason" class="form-label">Reason for cancellation (optional)</label>
                        <textarea class="form-control" id="reason" name="reason" rows="3" placeholder="Enter cancellation reason..."></textarea>
                    </div>

                    <div class="alert alert-warning">
                        <i class="fas fa-info-circle me-2"></i>
                        This action cannot be undone. The contractor will be notified of this cancellation.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-ban me-2"></i>
                        Cancel Application
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.animated-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 2rem;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    animation: gradientShift 10s ease infinite;
    background-size: 200% 200%;
}

@keyframes gradientShift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

.stat-badge {
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.stat-label {
    display: block;
    font-size: 0.75rem;
    color: rgba(255, 255, 255, 0.8);
}

.stat-value {
    display: block;
    font-size: 1.5rem;
    font-weight: bold;
    color: white;
    line-height: 1.2;
}

.hover-lift {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: 0 1rem 3rem rgba(0,0,0,.1)!important;
}

.avatar-circle {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
    font-size: 1.1rem;
}

.avatar-circle.bg-secondary {
    background: #6c757d;
}

.skills-wrapper {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.skill-badge {
    background: #e9ecef;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    color: #495057;
    transition: all 0.3s ease;
}

.skill-badge:hover {
    background: #667eea;
    color: white;
    transform: scale(1.05);
}

.skill-badge.more {
    background: #dee2e6;
    font-weight: 600;
}

.status-switch {
    width: 3rem;
    height: 1.5rem;
    cursor: pointer;
}

.status-switch:checked {
    background-color: #28a745;
    border-color: #28a745;
}

.status-badge {
    padding: 0.5rem 1rem;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.filter-tabs .btn-group {
    box-shadow: 0 2px 5px rgba(0,0,0,.1);
    border-radius: 10px;
    overflow: hidden;
}

.filter-tabs .btn {
    padding: 0.75rem 1.5rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.filter-tabs .btn:hover {
    transform: translateY(-2px);
}

/* Animations */
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

.application-card {
    animation: fadeInUp 0.5s ease forwards;
    opacity: 0;
}

.application-card:nth-child(1) { animation-delay: 0.1s; }
.application-card:nth-child(2) { animation-delay: 0.2s; }
.application-card:nth-child(3) { animation-delay: 0.3s; }
.application-card:nth-child(4) { animation-delay: 0.4s; }
.application-card:nth-child(5) { animation-delay: 0.5s; }
.application-card:nth-child(6) { animation-delay: 0.6s; }

.empty-state-icon {
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
    100% { transform: translateY(0px); }
}

/* Loading state for status switch */
.status-switch:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

/* Alert styles */
.alert-warning {
    background-color: #fff3cd;
    border-color: #ffecb5;
    color: #856404;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Status Switch Toggle (Approve/Unapprove)
    document.querySelectorAll('.status-switch').forEach(switch_ => {
        switch_.addEventListener('change', function(e) {
            const applicationId = this.dataset.applicationId;
            const isApproved = this.checked;
            const originalState = this.checked;
            const card = this.closest('.application-card');

            // Disable switch during request
            this.disabled = true;

            // Show loading state
            this.classList.add('switch-loading');

            fetch(`/admin/applications/${applicationId}/approve`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ approved: isApproved })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update status badge
                    const statusBadge = card.querySelector('.status-badge');
                    if (statusBadge) {
                        statusBadge.textContent = isApproved ? 'Approved' : 'Pending';
                        statusBadge.className = `badge bg-${isApproved ? 'success' : 'warning'} status-badge`;
                    }

                    // Show success message
                    showNotification('success', data.message);

                    // Optional: Reload if needed
                    if (isApproved) {
                        // Remove pending indicator if exists
                        const pendingIndicator = card.querySelector('.pending-indicator');
                        if (pendingIndicator) {
                            pendingIndicator.remove();
                        }
                    }
                } else {
                    // Revert switch if failed
                    this.checked = originalState;
                    showNotification('error', 'Failed to update status');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                this.checked = originalState;
                showNotification('error', 'An error occurred');
            })
            .finally(() => {
                this.disabled = false;
                this.classList.remove('switch-loading');
            });
        });
    });

    // Cancel Application Button
    document.querySelectorAll('.cancel-application').forEach(btn => {
        btn.addEventListener('click', function(e) {
            const applicationId = this.dataset.applicationId;
            const contractorName = this.dataset.contractorName;
            const projectTitle = this.dataset.projectTitle;

            // Update modal content
            document.getElementById('contractorName').textContent = contractorName;
            document.getElementById('projectTitle').textContent = projectTitle;

            // Set form action
            const form = document.getElementById('cancelForm');
            form.action = `/admin/applications/${applicationId}/cancel`;

            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('cancelModal'));
            modal.show();
        });
    });

    // Handle cancel form submission
    document.getElementById('cancelForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const form = this;
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;

        // Show loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Cancelling...';

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: new FormData(form)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Close modal
                bootstrap.Modal.getInstance(document.getElementById('cancelModal')).hide();

                // Remove or update the application card
                const applicationId = form.action.split('/').slice(-2, -1)[0];
                const card = document.querySelector(`.application-card[data-id="${applicationId}"]`);

                if (card) {
                    // Animate card removal
                    card.style.transition = 'all 0.5s ease';
                    card.style.opacity = '0';
                    card.style.transform = 'translateX(100px)';

                    setTimeout(() => {
                        card.remove();

                        // Check if grid is empty
                        const grid = document.getElementById('applicationsGrid');
                        if (grid.children.length === 0) {
                            location.reload(); // Reload to show empty state
                        }
                    }, 500);
                }

                showNotification('success', data.message);
            } else {
                showNotification('error', data.message || 'Failed to cancel application');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('error', 'An error occurred');
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        });
    });

    // Notification function
    function showNotification(type, message) {
        const toast = document.createElement('div');
        toast.className = `toast-notification toast-${type} animate__animated animate__fadeInRight`;
        toast.innerHTML = `
            <div class="toast-content">
                <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} me-2"></i>
                <span>${message}</span>
            </div>
        `;

        document.body.appendChild(toast);

        setTimeout(() => {
            toast.classList.add('animate__fadeOutRight');
            setTimeout(() => toast.remove(), 500);
        }, 3000);
    }
});
</script>

<style>
.toast-notification {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9999;
    padding: 1rem 2rem;
    border-radius: 10px;
    color: white;
    font-weight: 500;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    animation-duration: 0.5s;
}

.toast-success {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
}

.toast-error {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
}

.switch-loading {
    opacity: 0.5;
    cursor: wait;
}
</style>
@endpush
