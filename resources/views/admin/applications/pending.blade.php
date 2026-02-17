@extends('layouts.admin')

@section('title', 'Pending Applications')

@section('content')
<div class="container-fluid py-4">
    {{-- Animated Header with Priority Indicators --}}
    <div class="pending-header mb-4">
        <div class="row align-items-center">
            <div class="col-md-7">
                <div class="d-flex align-items-center">
                    <div class="header-icon-wrapper me-3">
                        <i class="fas fa-hourglass-half fa-3x text-warning"></i>
                    </div>
                    <div>
                        <h1 class="display-5 fw-bold text-white mb-2 animate__animated animate__fadeInLeft">
                            Pending Applications
                        </h1>
                        <p class="text-white-50 mb-0 animate__animated animate__fadeInLeft animate__delay-1s">
                            Review and approve contractor applications waiting for your decision
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="priority-stats-grid">
                    <div class="priority-stat-card warning animate__animated animate__fadeInRight">
                        <div class="priority-stat-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="priority-stat-info">
                            <span class="priority-stat-label">Total Pending</span>
                            <span class="priority-stat-value">{{ $stats['total_pending'] }}</span>
                        </div>
                    </div>
                    <div class="priority-stat-card danger animate__animated animate__fadeInRight animate__delay-1s">
                        <div class="priority-stat-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="priority-stat-info">
                            <span class="priority-stat-label">High Priority</span>
                            <span class="priority-stat-value">{{ $stats['high_priority'] }}</span>
                        </div>
                    </div>
                    <div class="priority-stat-card info animate__animated animate__fadeInRight animate__delay-2s">
                        <div class="priority-stat-icon">
                            <i class="fas fa-calendar-week"></i>
                        </div>
                        <div class="priority-stat-info">
                            <span class="priority-stat-label">Avg. Wait</span>
                            <span class="priority-stat-value">{{ $stats['avg_waiting_days'] }} days</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Stats Row --}}
    <div class="row mb-4 g-3">
        <div class="col-md-3">
            <div class="stat-card hover-lift">
                <div class="stat-card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="stat-title">Unique Contractors</span>
                            <h3 class="stat-value mt-2">{{ $stats['unique_contractors'] }}</h3>
                        </div>
                        <div class="stat-icon bg-warning bg-opacity-10">
                            <i class="fas fa-users text-warning fa-2x"></i>
                        </div>
                    </div>
                    <div class="stat-footer mt-3">
                        <small class="text-muted">
                            <i class="fas fa-user-clock me-1"></i>
                            Waiting for review
                        </small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card hover-lift">
                <div class="stat-card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="stat-title">Unique Projects</span>
                            <h3 class="stat-value mt-2">{{ $stats['unique_projects'] }}</h3>
                        </div>
                        <div class="stat-icon bg-info bg-opacity-10">
                            <i class="fas fa-hard-hat text-info fa-2x"></i>
                        </div>
                    </div>
                    <div class="stat-footer mt-3">
                        <small class="text-muted">
                            <i class="fas fa-building me-1"></i>
                            Projects needing contractors
                        </small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card hover-lift">
                <div class="stat-card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="stat-title">Oldest Pending</span>
                            <h3 class="stat-value mt-2">{{ $stats['oldest_pending'] }} days</h3>
                        </div>
                        <div class="stat-icon bg-danger bg-opacity-10">
                            <i class="fas fa-calendar-times text-danger fa-2x"></i>
                        </div>
                    </div>
                    <div class="stat-footer mt-3">
                        <small class="text-muted">
                            <i class="fas fa-hourglass-end me-1"></i>
                            Waiting since
                        </small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card hover-lift">
                <div class="stat-card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="stat-title">Response Rate</span>
                            <h3 class="stat-value mt-2">
                                {{ $stats['total_pending'] > 0 ? round(($stats['high_priority'] / $stats['total_pending']) * 100, 1) : 0 }}%
                            </h3>
                        </div>
                        <div class="stat-icon bg-success bg-opacity-10">
                            <i class="fas fa-chart-line text-success fa-2x"></i>
                        </div>
                    </div>
                    <div class="stat-footer mt-3">
                        <small class="text-muted">
                            <i class="fas fa-clock me-1"></i>
                            High priority ratio
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Action Bar --}}
    <div class="action-bar mb-4 animate__animated animate__fadeInUp">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-success" id="bulkApproveBtn" disabled>
                        <i class="fas fa-check-double me-2"></i>
                        Bulk Approve
                    </button>
                    <button type="button" class="btn btn-outline-secondary" id="selectAllBtn">
                        <i class="fas fa-check-square me-2"></i>
                        Select All
                    </button>
                    <button type="button" class="btn btn-outline-primary" id="exportBtn">
                        <i class="fas fa-download me-2"></i>
                        Export
                    </button>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-end gap-2">
                    <div class="sort-dropdown">
                        <select class="form-select" id="sortSelect">
                            <option value="newest">Newest First</option>
                            <option value="oldest">Oldest First</option>
                            <option value="longest_wait">Longest Wait</option>
                            <option value="contractor">Contractor Name</option>
                        </select>
                    </div>
                    <div class="search-box">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text"
                               class="form-control"
                               id="searchInput"
                               placeholder="Search contractors or projects...">
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Pending Applications Grid --}}
    <div class="row g-4" id="applicationsGrid">
        @forelse($applications as $application)
            <div class="col-xl-4 col-lg-6 application-card"
                 data-id="{{ $application->id }}"
                 data-waiting="{{ $application->waiting_days }}"
                 data-contractor="{{ strtolower($application->contractor->user->name) }}"
                 data-project="{{ strtolower($application->project->title) }}"
                 data-created="{{ $application->created_at->timestamp }}">

                <div class="card h-100 border-0 shadow-sm hover-lift
                    {{ $application->waiting_days > 7 ? 'border-warning border-2' : '' }}">

                    {{-- Priority Badge for Long Waiting --}}
                    @if($application->waiting_days > 7)
                        <div class="priority-ribbon">
                            <span><i class="fas fa-exclamation-circle me-1"></i> {{ $application->waiting_days }} days</span>
                        </div>
                    @endif

                    <div class="card-body">
                        {{-- Header with Select Checkbox --}}
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="d-flex align-items-center">
                                <div class="form-check me-3">
                                    <input class="form-check-input application-select"
                                           type="checkbox"
                                           value="{{ $application->id }}"
                                           id="app-{{ $application->id }}">
                                </div>
                                <div class="avatar-circle {{ $application->waiting_days > 5 ? 'pulse-animation' : '' }}">
                                    {{ strtoupper(substr($application->contractor->user->name, 0, 1)) }}
                                </div>
                                <div class="ms-3">
                                    <h5 class="card-title mb-0">{{ $application->contractor->user->name }}</h5>
                                    <p class="text-muted small mb-0">
                                        <i class="fas fa-envelope me-1"></i>
                                        {{ $application->contractor->user->email }}
                                    </p>
                                </div>
                            </div>
                            <span class="waiting-badge {{ $application->waiting_days > 7 ? 'bg-danger' : ($application->waiting_days > 3 ? 'bg-warning' : 'bg-info') }}">
                                <i class="fas fa-hourglass-half me-1"></i>
                                {{ $application->waiting_days }}d
                            </span>
                        </div>

                        {{-- Project Info --}}
                        <div class="project-info bg-light rounded-3 p-3 mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0">
                                    <i class="fas fa-hard-hat me-2 text-primary"></i>
                                    {{ $application->project->title }}
                                </h6>
                                <span class="badge bg-primary">Project</span>
                            </div>
                            <p class="small text-muted mb-0">
                                <i class="fas fa-map-marker-alt me-1"></i>
                                {{ $application->project->full_location ?? 'Location not specified' }}
                            </p>
                            @if($application->project->estimated_budget)
                                <p class="small text-muted mb-0 mt-2">
                                    <i class="fas fa-coins me-1 text-warning"></i>
                                    Budget: ₦{{ number_format($application->project->estimated_budget) }}
                                </p>
                            @endif
                        </div>

                        {{-- Contractor Details --}}
                        <div class="contractor-details mb-3">
                            <div class="row g-2">
                                <div class="col-6">
                                    <div class="detail-item">
                                        <span class="detail-label">Applied</span>
                                        <span class="detail-value">
                                            {{ $application->created_at->format('M d, Y') }}
                                        </span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="detail-item">
                                        <span class="detail-label">Completion Rate</span>
                                        <span class="detail-value">
                                            <div class="progress progress-sm">
                                                <div class="progress-bar bg-success"
                                                     style="width: {{ $application->contractor->completion_rate ?? 0 }}%">
                                                </div>
                                            </div>
                                            <small>{{ $application->contractor->completion_rate ?? 0 }}%</small>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Skills --}}
                        @if($application->contractor->skills->count() > 0)
                            <div class="skills-wrapper mb-3">
                                @foreach($application->contractor->skills->take(3) as $skill)
                                    <span class="skill-badge">{{ $skill->name }}</span>
                                @endforeach
                                @if($application->contractor->skills->count() > 3)
                                    <span class="skill-badge more">+{{ $application->contractor->skills->count() - 3 }}</span>
                                @endif
                            </div>
                        @endif

                        {{-- Action Buttons --}}
                        <div class="action-buttons d-flex gap-2 mt-3">
                            <button type="button"
                                    class="btn btn-success btn-sm flex-grow-1 approve-btn"
                                    data-application-id="{{ $application->id }}"
                                    data-contractor-name="{{ $application->contractor->user->name }}">
                                <i class="fas fa-check-circle me-1"></i>
                                Approve
                            </button>

                            <a href="{{ route('admin.applications.view-contractor', $application) }}"
                               class="btn btn-info btn-sm"
                               data-bs-toggle="tooltip"
                               title="View Contractor Details">
                                <i class="fas fa-eye"></i>
                            </a>

                            <button type="button"
                                    class="btn btn-danger btn-sm cancel-btn"
                                    data-application-id="{{ $application->id }}"
                                    data-contractor-name="{{ $application->contractor->user->name }}"
                                    data-project-title="{{ $application->project->title }}">
                                <i class="fas fa-ban"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Footer with Meta --}}
                    <div class="card-footer bg-transparent border-0 pt-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="fas fa-hashtag me-1"></i>
                                App #{{ $application->id }}
                            </small>
                            @if($application->waiting_days > 5)
                                <small class="text-danger">
                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                    Urgent review needed
                                </small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="empty-state text-center py-5">
                    <div class="empty-state-icon mb-4">
                        <i class="fas fa-check-circle fa-4x text-success"></i>
                    </div>
                    <h4 class="text-muted mb-3">No Pending Applications</h4>
                    <p class="text-muted mb-4">All caught up! There are no applications waiting for review.</p>
                    <a href="{{ route('admin.applications.index') }}" class="btn btn-primary">
                        <i class="fas fa-list me-2"></i>
                        View All Applications
                    </a>
                </div>
            </div>
        @endforelse
    </div>
</div>

{{-- Cancel Modal --}}
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
                    <p>Are you sure you want to cancel the application from <strong id="cancelContractorName"></strong>?</p>

                    <div class="mb-3">
                        <label for="cancelReason" class="form-label">Reason for cancellation</label>
                        <textarea class="form-control" id="cancelReason" name="reason" rows="3"
                                  placeholder="Please provide a reason for cancellation..."></textarea>
                    </div>

                    <div class="alert alert-warning">
                        <i class="fas fa-info-circle me-2"></i>
                        This action cannot be undone. The contractor will be notified.
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

{{-- Bulk Approve Modal --}}
<div class="modal fade" id="bulkApproveModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="fas fa-check-double me-2"></i>
                    Bulk Approve Applications
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>You are about to approve <span id="selectedCount" class="fw-bold">0</span> selected application(s).</p>
                <p class="text-muted small">This will notify the contractors and mark them as approved for their respective projects.</p>

                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    This action can be reversed individually if needed.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="confirmBulkApprove">
                    <i class="fas fa-check-double me-2"></i>
                    Approve Selected
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.pending-header {
    background: linear-gradient(135deg, #f39c12 0%, #e67e22 50%, #d35400 100%);
    padding: 2rem;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(243, 156, 18, 0.3);
    animation: gradientShift 10s ease infinite;
    background-size: 200% 200%;
}

@keyframes gradientShift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

.header-icon-wrapper {
    width: 70px;
    height: 70px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.priority-stats-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
}

.priority-stat-card {
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    border-radius: 10px;
    padding: 1rem;
    border: 1px solid rgba(255, 255, 255, 0.3);
    display: flex;
    align-items: center;
    gap: 1rem;
}

.priority-stat-card.warning .priority-stat-icon {
    background: rgba(255, 193, 7, 0.3);
}

.priority-stat-card.danger .priority-stat-icon {
    background: rgba(220, 53, 69, 0.3);
}

.priority-stat-card.info .priority-stat-icon {
    background: rgba(23, 162, 184, 0.3);
}

.priority-stat-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
}

.priority-stat-info {
    flex: 1;
}

.priority-stat-label {
    display: block;
    font-size: 0.7rem;
    color: rgba(255, 255, 255, 0.8);
}

.priority-stat-value {
    display: block;
    font-size: 1.2rem;
    font-weight: bold;
    color: white;
    line-height: 1.2;
}

.stat-card {
    background: white;
    border-radius: 12px;
    padding: 1.25rem;
    transition: all 0.3s ease;
}

.stat-card.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

.stat-title {
    font-size: 0.85rem;
    color: #6c757d;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.stat-value {
    font-size: 1.8rem;
    font-weight: 700;
    color: #2c3e50;
    margin: 0;
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.action-bar {
    background: white;
    padding: 1rem 1.5rem;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,.05);
}

.search-box {
    position: relative;
    min-width: 250px;
}

.search-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #adb5bd;
}

.search-box input {
    padding-left: 2.5rem;
}

.avatar-circle {
    width: 45px;
    height: 45px;
    background: linear-gradient(135deg, #f39c12, #e67e22);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
    font-size: 1.2rem;
}

.pulse-animation {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { box-shadow: 0 0 0 0 rgba(243, 156, 18, 0.7); }
    70% { box-shadow: 0 0 0 10px rgba(243, 156, 18, 0); }
    100% { box-shadow: 0 0 0 0 rgba(243, 156, 18, 0); }
}

.waiting-badge {
    padding: 0.35rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    color: white;
}

.waiting-badge.bg-info { background: linear-gradient(135deg, #17a2b8, #0dcaf0); }
.waiting-badge.bg-warning { background: linear-gradient(135deg, #ffc107, #fd7e14); }
.waiting-badge.bg-danger { background: linear-gradient(135deg, #dc3545, #c82333); }

.priority-ribbon {
    position: absolute;
    top: -5px;
    right: 10px;
    background: linear-gradient(135deg, #dc3545, #c82333);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 0 0 10px 10px;
    font-size: 0.8rem;
    font-weight: 600;
    box-shadow: 0 3px 10px rgba(220, 53, 69, 0.3);
    z-index: 10;
}

.priority-ribbon::before {
    content: '';
    position: absolute;
    top: 0;
    left: -10px;
    width: 0;
    height: 0;
    border-left: 10px solid transparent;
    border-right: 0 solid transparent;
    border-top: 5px solid #c82333;
}

.detail-item {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 0.5rem;
}

.detail-label {
    display: block;
    font-size: 0.7rem;
    color: #6c757d;
    margin-bottom: 0.25rem;
}

.detail-value {
    display: block;
    font-weight: 600;
    font-size: 0.9rem;
}

.progress-sm {
    height: 4px;
    margin-top: 0.25rem;
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
    background: #f39c12;
    color: white;
    transform: scale(1.05);
}

.application-card {
    animation: fadeInUp 0.5s ease forwards;
    opacity: 0;
