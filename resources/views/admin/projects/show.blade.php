@extends('layouts.admin')

@section('title', $project->title)

@section('content')
<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1">{{ $project->title }}</h1>
            <p class="text-muted mb-0">
                <i class="fas fa-map-marker-alt me-1"></i>
                {{ $project->full_location ?? 'No location provided' }}
            </p>
        </div>

        <div class="d-flex gap-2 mt-3 mt-md-0">
            <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-list"></i> View All Projects
            </a>

            <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit Project
            </a>
        </div>
    </div>

    {{-- CANDIDATE PROFILE --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-light fw-semibold">
            <i class="fas fa-user me-1"></i> Candidate Information
        </div>

        <div class="card-body d-flex gap-4 align-items-start">

            <img
                src="{{ $project->candidate?->photo
                    ? asset('storage/'.$project->candidate->photo)
                    : asset('images/avatar.png') }}"
                class="rounded-circle"
                width="90"
                height="90"
                style="object-fit:cover"
            >

            <div>
                <h5 class="mb-1">
                    {{ $project->candidate?->user?->name ?? 'N/A' }}
                </h5>

                <div class="text-muted mb-2">
                    <i class="fas fa-envelope me-1"></i>
                    {{ $project->candidate?->user?->email ?? 'N/A' }}
                </div>

                @if($project->candidate?->bio)
                    <p class="mb-0 text-muted">
                        {{ $project->candidate->bio }}
                    </p>
                @endif
            </div>
        </div>
    </div>

    {{-- PROJECT META --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body row text-center gy-3">

            <div class="col-md-3">
                <small class="text-muted d-block">Project Status</small>
                <span class="badge {{ $project->getStatusBadgeClass() }}">
                    {{ ucfirst($project->status) }}
                </span>
            </div>

            <div class="col-md-3">
                <small class="text-muted d-block">Current Phase</small>
                {{ ucfirst($project->current_phase?->status ?? 'N/A') }}
            </div>

            <div class="col-md-3">
                <small class="text-muted d-block">Start Date</small>
                {{ optional($project->start_date)->format('d M Y') ?? '-' }}
            </div>

            <div class="col-md-3">
                <small class="text-muted d-block">Duration</small>
                {{ $project->duration ?? '-' }}
            </div>

        </div>
    </div>

    {{-- PHASES HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold mb-0">Project Phases</h5>

<button class="btn btn-sm btn-warning change-phase-btn"
                                    data-id="{{ $project->id }}"
                                    data-phase="{{ $latestPhase->phase ?? '' }}"
                                    data-description="{{ $latestPhase->description ?? '' }}">
                                <i class="fas fa-exchange-alt"></i> Change Phase
                            </button>
    </div>

    {{-- PHASE CARDS --}}
    <div class="row g-3 mb-4">
        @forelse($project->timeline_phases as $phase)
            <div class="col-md-6 col-xl-4">
                <div class="card h-100 border-0 shadow-sm
                    {{ $project->current_phase?->id === $phase->id ? 'border border-primary' : '' }}">

                    <div class="card-body">
                        <h6 class="fw-semibold mb-1">
                            {{ ucfirst($phase->status) }}
                        </h6>

                        <span class="badge {{ $phase->badge_class }}">
                            {{ ucfirst($phase->phase) }}
                        </span>

                        <p class="text-muted small mt-2 mb-2">
                            {{ $phase->description ?? 'No description provided.' }}
                        </p>

                        <small class="text-muted d-block">
                            Started: {{ $phase->started_at->format('d M Y') }}
                        </small>

                        @if($phase->ended_at)
                            <small class="text-muted d-block">
                                Ended: {{ $phase->ended_at->format('d M Y') }}
                            </small>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-muted">No phases created yet.</div>
        @endforelse
    </div>



</div>
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
