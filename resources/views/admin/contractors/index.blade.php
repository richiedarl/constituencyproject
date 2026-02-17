@extends('layouts.admin')

@section('title', 'All Contractors')

@section('styles')
<style>
    .contractor-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #fff;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .avatar-placeholder {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 1.2rem;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .skill-badge {
        display: inline-block;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
        margin: 2px;
        box-shadow: 0 2px 4px rgba(102, 126, 234, 0.2);
    }

    .approval-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.8rem;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .approval-badge.approved {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
    }

    .approval-badge.pending {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
        box-shadow: 0 2px 8px rgba(245, 158, 11, 0.3);
    }

    .approval-badge.rejected {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
    }

    .projects-count {
        background: #f3f4f6;
        padding: 4px 10px;
        border-radius: 20px;
        font-weight: 600;
        color: #4b5563;
        display: inline-block;
    }

    .action-btn {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin: 0 3px;
        transition: all 0.2s;
        border: none;
        color: white;
    }

    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }

    .action-btn.view {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    }

    .action-btn.edit {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    .action-btn.delete {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    }

    .action-btn.assign {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
    }

    .table-hover tbody tr:hover {
        background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
        cursor: pointer;
    }

    .project-assign-modal .modal-content {
        border: none;
        border-radius: 20px;
        overflow: hidden;
    }

    .project-assign-modal .modal-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 1.5rem;
    }

    .project-assign-modal .modal-header .btn-close {
        filter: brightness(0) invert(1);
    }

    .project-assign-modal .modal-body {
        padding: 2rem;
    }

    .project-assign-modal .modal-footer {
        padding: 1.5rem;
        background: #f9fafb;
    }

    .project-card {
        border: 2px solid #e5e7eb;
        border-radius: 15px;
        padding: 1rem;
        transition: all 0.2s;
        cursor: pointer;
        margin-bottom: 1rem;
    }

    .project-card:hover {
        border-color: #667eea;
        transform: translateX(5px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.1);
    }

    .project-card.selected {
        border-color: #10b981;
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
    }

    .project-card .project-title {
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 0.5rem;
    }

    .project-card .project-meta {
        display: flex;
        align-items: center;
        gap: 1rem;
        font-size: 0.9rem;
        color: #6b7280;
    }

    .project-card .project-status {
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .project-card .project-status.ongoing {
        background: #dbeafe;
        color: #1e40af;
    }

    .project-card .project-status.planning {
        background: #fef3c7;
        color: #92400e;
    }

    .project-card .project-status.completed {
        background: #d1fae5;
        color: #065f46;
    }

    .slots-available {
        display: inline-block;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .slots-available.available {
        background: #10b981;
        color: white;
    }

    .slots-available.full {
        background: #ef4444;
        color: white;
    }

    .search-box {
        position: relative;
        margin-bottom: 1rem;
    }

    .search-box i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
    }

    .search-box input {
        padding-left: 45px;
        border-radius: 30px;
        border: 2px solid #e5e7eb;
        height: 50px;
        transition: all 0.2s;
    }

    .search-box input:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .filter-badge {
        display: inline-block;
        padding: 6px 16px;
        border-radius: 30px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        margin-right: 0.5rem;
        margin-bottom: 0.5rem;
    }

    .filter-badge.all {
        background: #f3f4f6;
        color: #4b5563;
    }

    .filter-badge.approved {
        background: #d1fae5;
        color: #065f46;
    }

    .filter-badge.pending {
        background: #fef3c7;
        color: #92400e;
    }

    .filter-badge:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .filter-badge.active {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .pagination {
        gap: 5px;
    }

    .pagination .page-item .page-link {
        border-radius: 10px;
        border: none;
        padding: 8px 16px;
        color: #4b5563;
        font-weight: 500;
        transition: all 0.2s;
    }

    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .pagination .page-item .page-link:hover {
        background: #f3f4f6;
        transform: translateY(-2px);
    }

    .table > :not(caption) > * > * {
        padding: 1rem 0.75rem;
        vertical-align: middle;
    }

    .badge-info {
        background: #dbeafe;
        color: #1e40af;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">All Contractors</h1>
            <p class="mb-0 text-muted">Manage and assign contractors to projects</p>
        </div>
        <div>
            <span class="badge bg-primary p-3 rounded-pill">
                <i class="fas fa-users me-2"></i>Total: {{ $contractors->total() }}
            </span>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Search and Filter -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text"
                       class="form-control"
                       id="searchInput"
                       placeholder="Search contractors by name, skills, occupation...">
            </div>
        </div>
        <div class="col-md-4">
            <select class="form-select" id="occupationFilter" style="height: 50px; border-radius: 30px;">
                <option value="">All Occupations</option>
                @foreach($occupations ?? [] as $occupation)
                    <option value="{{ $occupation }}">{{ $occupation }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Filter Badges -->
    <div class="mb-4">
        <span class="filter-badge all active" data-filter="all">All</span>
        <span class="filter-badge approved" data-filter="approved">Approved</span>
        <span class="filter-badge pending" data-filter="pending">Pending</span>
    </div>

    <!-- Contractors Table Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-list me-2"></i>Contractors List
            </h6>
            <a href="{{ route('admin.contractors.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i> Add New Contractor
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="contractorsTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Skills</th>
                            <th>Phone</th>
                            <th>District</th>
                            <th>Occupation</th>
                            <th>Status</th>
                            <th>Projects</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($contractors as $contractor)
                        <tr>
                            <td><span class="fw-bold">#{{ $contractor->id }}</span></td>
                            <td>
                                @if($contractor->photo)
                                    <img src="{{ asset('storage/' . $contractor->photo) }}"
                                         alt="{{ $contractor->name }}"
                                         class="contractor-avatar">
                                @else
                                    <div class="avatar-placeholder">
                                        {{ strtoupper(substr($contractor->user->name ?? 'NA', 0, 2)) }}
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="fw-bold">{{ $contractor->user->name ?? 'N/A' }}</div>
                                <small class="text-muted">{{ $contractor->user->email ?? '' }}</small>
                            </td>
                            <td>
                                @if($contractor->skills && count($contractor->skills) > 0)
                                    @foreach($contractor->skills as $skill)
                                        <span class="skill-badge">{{ $skill }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted">No skills listed</span>
                                @endif
                            </td>
                            <td>{{ $contractor->phone ?? 'N/A' }}</td>
                            <td>{{ $contractor->district ?? 'N/A' }}</td>
                            <td>
                                <span class="badge bg-info text-white p-2">
                                    {{ $contractor->occupation ?? 'N/A' }}
                                </span>
                            </td>
                            <td>
                                @if($contractor->approved)
                                    <span class="approval-badge approved">
                                        <i class="fas fa-check-circle"></i> Approved
                                    </span>
                                @else
                                    <span class="approval-badge pending">
                                        <i class="fas fa-clock"></i> Pending
                                    </span>
                                @endif
                            </td>
                            <td>
                                <span class="projects-count">
                                    <i class="fas fa-tasks me-1"></i>
                                    {{ $contractor->projects_count ?? $contractor->projects->count() }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.contractors.show', $contractor->id) }}"
                                       class="action-btn view" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.contractors.edit', $contractor->id) }}"
                                       class="action-btn edit" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($contractor->approved)
                                        <button type="button"
                                                class="action-btn assign"
                                                title="Assign to Project"
                                                onclick="openAssignModal({{ $contractor->id }}, '{{ addslashes($contractor->user->name ?? 'Contractor') }}')">
                                            <i class="fas fa-link"></i>
                                        </button>
                                    @endif
                                    <form action="{{ route('admin.contractors.destroy', $contractor->id) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this contractor?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn delete" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-users fa-3x mb-3"></i>
                                    <p class="mb-0">No contractors found.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $contractors->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Assign to Project Modal -->
<div class="modal fade project-assign-modal" id="assignModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-link me-2"></i>Assign Contractor to Project
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="assignForm" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="contractor_id" id="modalContractorId">

                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">Contractor: <span id="modalContractorName" class="text-primary"></span></h6>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Select Project</label>
                        <div id="projectsList">
                            <!-- Projects will be loaded here via AJAX -->
                            <div class="text-center py-4">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="mt-2">Loading available projects...</p>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info" role="alert">
                        <i class="fas fa-info-circle me-2"></i>
                        Only projects with available slots for contractors are shown.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-primary" id="submitAssign">
                        <i class="fas fa-check me-1"></i>Assign Contractor
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    let selectedProjectId = null;
    let currentContractorId = null;

    function openAssignModal(contractorId, contractorName) {
        currentContractorId = contractorId;
        document.getElementById('modalContractorId').value = contractorId;
        document.getElementById('modalContractorName').textContent = contractorName;
        document.getElementById('assignForm').action = `/admin/contractors/${contractorId}/assign-project`;

        // Reset selected project
        selectedProjectId = null;

        // Load available projects
        loadAvailableProjects(contractorId);

        // Show modal
        new bootstrap.Modal(document.getElementById('assignModal')).show();
    }

    function loadAvailableProjects(contractorId) {
        fetch(`/admin/contractors/${contractorId}/available-projects`)
            .then(response => response.json())
            .then(data => {
                const projectsList = document.getElementById('projectsList');

                if (data.projects && data.projects.length > 0) {
                    let html = '';
                    data.projects.forEach(project => {
                        const slotsAvailable = project.contractor_count - (project.approved_contractors_count || 0);
                        const isFull = slotsAvailable <= 0;

                        html += `
                            <div class="project-card ${selectedProjectId === project.id ? 'selected' : ''}"
                                 onclick="selectProject(${project.id})"
                                 data-project-id="${project.id}">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <div class="project-title">
                                            ${project.title}
                                            <span class="ms-2 project-status ${project.status}">${project.status}</span>
                                        </div>
                                        <div class="project-meta">
                                            <span><i class="fas fa-map-marker-alt me-1"></i>${project.full_location || 'Location N/A'}</span>
                                            <span><i class="fas fa-calendar me-1"></i>${project.start_date || 'Start date N/A'}</span>
                                        </div>
                                    </div>
                                    <div>
                                        <span class="slots-available ${isFull ? 'full' : 'available'}">
                                            ${isFull ? 'No slots' : slotsAvailable + ' slot(s) available'}
                                        </span>
                                    </div>
                                </div>
                                ${project.description ? `<div class="mt-2 text-muted small">${project.description.substring(0, 100)}...</div>` : ''}
                                <input type="radio" name="project_id" value="${project.id}" style="display: none;">
                            </div>
                        `;
                    });
                    projectsList.innerHTML = html;
                } else {
                    projectsList.innerHTML = `
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            No projects available for assignment at this time.
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error('Error loading projects:', error);
                document.getElementById('projectsList').innerHTML = `
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        Error loading projects. Please try again.
                    </div>
                `;
            });
    }

    function selectProject(projectId) {
        // Remove selected class from all cards
        document.querySelectorAll('.project-card').forEach(card => {
            card.classList.remove('selected');
        });

        // Add selected class to clicked card
        const selectedCard = document.querySelector(`[data-project-id="${projectId}"]`);
        if (selectedCard) {
            selectedCard.classList.add('selected');
        }

        // Update hidden radio
        const radio = document.querySelector(`input[name="project_id"][value="${projectId}"]`);
        if (radio) {
            radio.checked = true;
        }

        selectedProjectId = projectId;
    }

    // Form submission
    document.getElementById('assignForm').addEventListener('submit', function(e) {
        if (!selectedProjectId) {
            e.preventDefault();
            alert('Please select a project to assign the contractor to.');
            return;
        }
    });

    // Search functionality
    document.getElementById('searchInput').addEventListener('keyup', function() {
        filterTable();
    });

    document.getElementById('occupationFilter').addEventListener('change', function() {
        filterTable();
    });

    // Filter badges
    document.querySelectorAll('.filter-badge').forEach(badge => {
        badge.addEventListener('click', function() {
            document.querySelectorAll('.filter-badge').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            filterTable();
        });
    });

    function filterTable() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const occupation = document.getElementById('occupationFilter').value;
        const filter = document.querySelector('.filter-badge.active')?.getAttribute('data-filter') || 'all';

        const rows = document.querySelectorAll('#contractorsTable tbody tr');

        rows.forEach(row => {
            if (row.querySelector('td[colspan]')) return; // Skip empty state row

            const name = row.cells[2]?.textContent.toLowerCase() || '';
            const skills = row.cells[3]?.textContent.toLowerCase() || '';
            const occupationText = row.cells[6]?.textContent.toLowerCase() || '';
            const statusCell = row.cells[7]?.textContent.toLowerCase() || '';
            const isApproved = statusCell.includes('approved');

            // Apply filters
            const matchesSearch = searchTerm === '' ||
                                 name.includes(searchTerm) ||
                                 skills.includes(searchTerm);

            const matchesOccupation = occupation === '' ||
                                     occupationText.includes(occupation.toLowerCase());

            const matchesFilter = filter === 'all' ||
                                 (filter === 'approved' && isApproved) ||
                                 (filter === 'pending' && !isApproved);

            if (matchesSearch && matchesOccupation && matchesFilter) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
</script>
@endsection
