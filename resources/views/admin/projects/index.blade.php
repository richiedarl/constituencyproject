@extends('layouts.admin')

@section('content')
<style>
/* Table responsiveness */
.table-responsive {
    display: block;
    width: 100%;
    overflow-x: auto;
}

.table-responsive table {
    min-width: 800px; /* ensures horizontal scroll on small screens */
}

/* Modal full width on mobile */
@media (max-width: 768px) {
    .modal-dialog {
        max-width: 95%;
        margin: 1.75rem auto;
    }

    td .btn {
        display: block;
        margin-bottom: 5px;
        width: 100%;
    }

    .badge {
        white-space: normal;
    }
}
</style>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">All Projects</h1>
        <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Project
        </a>
    </div>

    @if($projects->count() > 0)
    <!-- Projects Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Project List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Candidate</th>
                            <th>Status</th>
                            <th>Desc</th>
                            <th>Phase/Mode</th>
                            <th>Start Date</th>
                            <th>Completion Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($projects as $project)
                        @php
                            $latestPhase = $project->phases()
                                ->whereNull('ended_at')
                                ->latest('started_at')
                                ->first();
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $project->title }}</td>
                            <td>{{ $project->candidate->name ?? 'N/A' }}</td>
                            <td>
                                @if($project->currentPhase)
                                    <span class="badge {{ $project->currentPhase->badge_class }}">
                                        {{ $project->currentPhase->status }}
                                    </span>
                                @else
                                    <span class="badge badge-light">-</span>
                                @endif
                            </td>
                            <td>
                                @if($project->currentPhase->description)
                                    
                                        {{ $project->currentPhase->description }}
                                    
                                @else
                                    <span class="badge badge-light">-</span>
                                @endif
                            </td>
                            <td>{{ $latestPhase->phase ?? '-' }}</td>
                            <td>{{ $project->start_date ? \Carbon\Carbon::parse($project->start_date)->format('d M Y') : '-' }}</td>
                            <td>{{ $project->completion_date ? \Carbon\Carbon::parse($project->completion_date)->format('d M Y') : '-' }}</td>
                            <td>
                                <a href="{{ route('admin.projects.show', $project->id) }}" class="btn btn-sm btn-info" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.projects.edit', $project->id) }}" class="btn btn-sm btn-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                            <button class="btn btn-sm btn-warning change-phase-btn"
                                    data-id="{{ $project->id }}"
                                    data-phase="{{ $latestPhase->phase ?? '' }}"
                                    data-description="{{ $latestPhase->description ?? '' }}">
                                <i class="fas fa-exchange-alt"></i> Change Phase
                            </button>

                                <a class="btn btn-sm btn-success add-media-btn" 
                                        href="{{ route('admin.mediaPage', ['phase' => $project->currentPhase]) }}">
                                    <i class="fas fa-upload"></i> Add Media
                                </a>
                                <button class="btn btn-sm btn-danger delete-project-btn" 
                                        data-id="{{ $project->id }}" 
                                        title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @else
    <div class="alert alert-info text-center">
        No projects found. <a href="{{ route('admin.projects.create') }}">Add a new project</a>.
    </div>
    @endif
</div>

<!-- Modals -->

<!-- Change Phase Modal -->
<div class="modal fade" id="changePhaseModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="changePhaseForm" method="POST" action="">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Change Project Phase</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="project_id" id="phaseProjectId">
                    <div class="form-group">
                        <label>New Phase</label>
                        <select name="phase" id="phaseSelect" class="form-control" required>
                            <option value="executing">Executing</option>
                            <option value="documenting">Documenting</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Phase Status</label>
                        <input type="text" name="status" id="phaseStatusInput" class="form-control" autocomplete="off" required>
                        <div id="phaseStatusSuggestions" class="list-group position-absolute w-100 d-none"></div>
                        <small class="text-muted">Select from common statuses or type your own.</small>
                    </div>
                    <div class="form-group">
                        <label>Short Description</label>
                        <textarea name="description" id="phaseDescription" class="form-control" 
                        rows="5">

                        </textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning">Update Phase</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>



<script>
document.addEventListener('DOMContentLoaded', function () {
    // Status autocomplete
    const phaseStatuses = [
        "Site Surveyed","Groundbreaking","Foundation Laid","Walls Erected",
        "Roofing Started","Roofing Completed","Tiling Started","Tilling Started",
        "Tilling Completed","Tiling Completed","Electrical Wiring Started",
        "Electrical Wiring Completed","Plumbing Started","Plumbing Completed",
        "Painting Started","Painting Completed","Windows Installed","Doors Installed",
        "Flooring Started","Flooring Completed","Furnishing Started","Furnishing Completed",
        "Landscaping Started","Landscaping Completed","Inspection Passed","Permit Approved",
        "Construction Completed","Final Review","Handover Started","Handover Completed",
        "Project Archived","Other"
    ];

    const statusInput = document.getElementById('phaseStatusInput');
    const statusSuggestions = document.getElementById('phaseStatusSuggestions');

    statusInput.addEventListener('input', () => {
        const query = statusInput.value.toLowerCase();
        statusSuggestions.innerHTML = '';
        if (!query) { statusSuggestions.classList.add('d-none'); return; }
        const matches = phaseStatuses.filter(s => s.toLowerCase().includes(query));
        matches.forEach(status => {
            const item = document.createElement('button');
            item.type = 'button';
            item.className = 'list-group-item list-group-item-action';
            item.textContent = status;
            item.onclick = () => { statusInput.value = status; statusSuggestions.classList.add('d-none'); };
            statusSuggestions.appendChild(item);
        });
        statusSuggestions.classList.remove('d-none');
    });

    document.addEventListener('click', e => {
        if (!statusInput.contains(e.target)) statusSuggestions.classList.add('d-none');
    });

    // Delete project
    document.querySelectorAll('.delete-project-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const projectId = this.dataset.id;
            Swal.fire({
                title: 'Are you sure?',
                text: "This will permanently delete the project!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/admin/projects/${projectId}/destroy`;
                    form.innerHTML = `@csrf<input type="hidden" name="_method" value="POST">`;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });

    // Change phase modal
    document.querySelectorAll('.change-phase-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const projectId = this.dataset.id;
            const currentPhase = this.dataset.phase;
            const currentDescription = this.dataset.description ?? ''; // optional: pass description in data-attribute
            
            const form = document.getElementById('changePhaseForm');
            form.action = `/projects/${projectId}/change-phase`;

            document.getElementById('phaseSelect').value = currentPhase;

            document.getElementById('phaseDescription').value = currentDescription; // fill description
    
            $('#changePhaseModal').modal('show');
        });
    });


});
</script>

@endsection
