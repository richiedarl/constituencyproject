@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 text-gray-800">{{ $project->title }}</h1>
            <p class="text-muted mb-0">
                {{ $project->full_location ?? 'No location provided' }}
            </p>
        </div>
        <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Projects
        </a>
    </div>

    {{-- Project Meta --}}
    <div class="card shadow mb-4">
        <div class="card-body row">
            <div class="col-md-3">
                <strong>Status</strong><br>
                <span class="badge {{ $project->getStatusBadgeClass() }}">
                    {{ ucfirst($project->current_phase->status) }}
                </span>
            </div>
            <div class="col-md-3">
                <strong>Candidate</strong><br>
                {{ $project->candidate->name ?? 'N/A' }}
            </div>
            <div class="col-md-3">
                <strong>Start Date</strong><br>
                {{ optional($project->start_date)->format('d M Y') ?? '-' }}
            </div>
            <div class="col-md-3">
                <strong>Duration</strong><br>
                {{ $project->duration ?? '-' }}
            </div>
        </div>
    </div>

    {{-- PHASE TIMELINE --}}
    <div class="card shadow mb-4">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">
                Project Phases Timeline
            </h6>
        </div>
        <div class="card-body">

            @forelse($project->timeline_phases as $phase)
                <div class="mb-4 p-3 border rounded 
                    {{ $project->current_phase && $phase->id === $project->current_phase->id ? 'border-primary bg-light' : '' }}">

                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <h6 class="mb-0">
                                {{ ucfirst($phase->status) }}
                                @if(is_null($phase->ended_at))
                                    <span class="badge badge-success ml-2">Active</span>
                                @else
                                    <span class="badge badge-secondary ml-2">Closed</span>
                                @endif
                            </h6>
                            <small class="text-muted">
                                {{ $phase->status }}
                                · Started {{ \Carbon\Carbon::parse($phase->started_at)->format('d M Y') }}
                                @if($phase->ended_at)
                                    · Ended {{ \Carbon\Carbon::parse($phase->ended_at)->format('d M Y') }}
                                @endif
                            </small>
                        </div>

                        {{-- Add Media only to active phase --}}
                        @if($project->current_phase && $phase->id === $project->current_phase->id)
                            <button
                                class="btn btn-sm btn-success add-media-btn"
                                data-phase-id="{{ $phase->id }}">
                                <i class="fas fa-plus"></i> Add Media
                            </button>
                        @endif
                    </div>

                    {{-- MEDIA GRID --}}
                    @if($phase->media->count())
                        <div class="row">
                            @foreach($phase->media as $media)
                                <div class="col-md-3 mb-3" data-media-id="{{ $media->id }}">
                                    <div class="card">
                                        @if($media->file_type === 'image')
                                            <img src="{{ asset('storage/' . $media->file_path) }}"
                                                 class="card-img-top"
                                                 style="height: 180px; object-fit: cover;">
                                        @else
                                            <video class="w-100" height="180" controls>
                                                <source src="{{ asset('storage/' . $media->file_path) }}">
                                            </video>
                                        @endif

                                        <div class="card-body p-2 text-center">
                                            <button
                                                class="btn btn-sm btn-danger delete-media-btn"
                                                data-id="{{ $media->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mb-0">No media added for this phase.</p>
                    @endif

                </div>
            @empty
                <p class="text-muted">No phases created yet.</p>
            @endforelse

        </div>
    </div>
</div>

{{-- ADD MEDIA MODAL --}}
<div class="modal fade" id="addMediaModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="addMediaForm" method="POST" enctype="multipart/form-data"
              action="{{ route('admin.projects.addMedia') }}">
            @csrf
            <input type="hidden" name="phase_id" id="mediaPhaseId">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Media to Phase</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div id="mediaInputs">
                        <input type="file" name="media[]" class="form-control mb-2" required>
                    </div>

                    <button type="button" class="btn btn-sm btn-outline-primary" id="addMoreMedia">
                        <i class="fas fa-plus"></i> Add another
                    </button>

                    <small class="text-muted d-block mt-2">
                        Images & videos only (max 20MB each)
                    </small>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-success">Upload</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- SCRIPTS --}}
<script>
document.addEventListener('DOMContentLoaded', () => {

    // Open Add Media Modal
    document.querySelectorAll('.add-media-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.getElementById('mediaPhaseId').value = btn.dataset.phaseId;
            $('#addMediaModal').modal('show');
        });
    });

    // Add more file inputs
    document.getElementById('addMoreMedia').addEventListener('click', () => {
        const input = document.createElement('input');
        input.type = 'file';
        input.name = 'media[]';
        input.className = 'form-control mb-2';
        document.getElementById('mediaInputs').appendChild(input);
    });

    // Delete media
    document.querySelectorAll('.delete-media-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const mediaId = btn.dataset.id;

            Swal.fire({
                title: 'Delete media?',
                text: 'This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Yes, delete'
            }).then(result => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/admin/media/${mediaId}/delete`;
                    form.innerHTML = `@csrf`;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });

});
</script>
@endsection
