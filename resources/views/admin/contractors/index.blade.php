@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Contractors</h4>
    </div>

    {{-- Filters --}}
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET">
                <div class="row g-2">
                    <div class="col-md-3">
                        <select name="occupation" class="form-select">
                            <option value="">All Occupations</option>
                            @foreach($occupations as $occupation)
                                <option value="{{ $occupation }}"
                                    {{ request('occupation') === $occupation ? 'selected' : '' }}>
                                    {{ ucfirst($occupation) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <button class="btn btn-primary w-100">
                            Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Contractors Table --}}
    <div class="card shadow mb-4">
        <div class="card-body table-responsive">

            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Occupation</th>
                        <th>Approved Projects</th>
                        <th>Status</th>
                        <th width="220">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($contractors as $contractor)
                        <tr>
                            <td>{{ $contractor->user->name ?? '—' }}</td>

                            <td>{{ $contractor->phone ?? '—' }}</td>

                            <td>{{ $contractor->occupation ?? '—' }}</td>

                            <td>
                                <span class="badge bg-info">
                                    {{ $contractor->approved_projects_count }}
                                </span>
                            </td>

                            <td>
                                @if($contractor->approved)
                                    <span class="badge bg-success">Approved</span>
                                @else
                                    <span class="badge bg-warning">Pending</span>
                                @endif
                            </td>

                            <td>
                                <a href="{{ route('contractors.show', $contractor) }}"
                                   class="btn btn-sm btn-primary">
                                    View
                                </a>

                                <a href="{{ route('contractors.edit', $contractor) }}"
                                   class="btn btn-sm btn-info">
                                    Edit
                                </a>

                                <a href="{{ route('professionals.available-projects', $contractor) }}"
                                class="btn btn-success">
                                    <i class="fas fa-link me-2"></i>Assign project
                                </a>
                                <form action="{{ route('professionals.toggle-approval', $contractor) }}"
                                      method="POST"
                                      class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-outline-dark">
                                        Toggle Approval
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                No contractors found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $contractors->links() }}

        </div>
    </div>

</div>

@include('admin.contractors.partials.assign-project-modal')
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
let contractorId = null;

document.querySelectorAll('.assign-project-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        contractorId = this.dataset.id;
        loadAvailableProjects(contractorId);
    });
});

function loadAvailableProjects(id) {
    const modal = new bootstrap.Modal(
        document.getElementById('assignProjectModal')
    );
    modal.show();

    const loader = document.getElementById('available-projects-loader');
    const list = document.getElementById('available-projects-list');

    loader.classList.remove('d-none');
    list.innerHTML = '';

    fetch(`/admin/professionals/${id}/available-projects`)
        .then(res => res.json())
        .then(projects => {
            loader.classList.add('d-none');

            if (!projects.length) {
                list.innerHTML =
                    '<p class="text-muted text-center">No available projects.</p>';
                return;
            }

            projects.forEach(project => {
                list.insertAdjacentHTML('beforeend', `
                    <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                        <div>
                            <strong>${project.title}</strong><br>
                            <small class="text-muted">${project.location ?? ''}</small>
                        </div>
                        <button class="btn btn-sm btn-primary"
                            onclick="assignProject(${project.id})">
                            Assign
                        </button>
                    </div>
                `);
            });
        });
}

function assignProject(projectId) {
    fetch(`/admin/professionals/${contractorId}/assign-project`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ project_id: projectId })
    })
    .then(() => location.reload());
}
</script>
@endpush
