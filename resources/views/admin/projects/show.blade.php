@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 text-gray-800">{{ $project->title }}</h1>
            <p class="text-muted mb-0">{{ $project->full_location ?? 'No location provided' }}</p>
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
                    {{ ucfirst($project->current_phase->status ?? 'N/A') }}
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
            <h6 class="m-0 font-weight-bold text-primary">Project Phases Timeline</h6>
        </div>
        <div class="card-body">

            @forelse($project->timeline_phases as $phase)
                <div class="mb-4 p-3 border rounded {{ $project->current_phase && $phase->id === $project->current_phase->id ? 'border-primary bg-light' : '' }}">

                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h6 class="mb-1">
                                {{ ucfirst($phase->status) }}
                                @if(is_null($phase->ended_at))
                                    <span class="badge badge-success ml-2">Active</span>
                                @else
                                    <span class="badge badge-secondary ml-2">Closed</span>
                                @endif
                            </h6>

                            <small class="text-muted d-block">
                                Started {{ \Carbon\Carbon::parse($phase->started_at)->format('d M Y') }}
                                @if($phase->ended_at)
                                    · Ended {{ \Carbon\Carbon::parse($phase->ended_at)->format('d M Y') }}
                                @endif
                            </small>

                            @if($phase->description)
                                <p class="mt-2 mb-0">{{ $phase->description }}</p>
                            @endif
                        </div>

                        {{-- Add Media (ACTIVE PHASE ONLY) --}}
                        @if($project->current_phase && $phase->id === $project->current_phase->id)
                            <button
                                type="button"
                                class="btn btn-sm btn-success add-media-btn"
                                data-phase-id="{{ $phase->id }}"
                                data-toggle="modal"
                                data-target="#addMediaModal"
                            >
                                <i class="fas fa-plus"></i> Add Media
                            </button>
                        @endif
                    </div>

                    {{-- MEDIA GRID --}}
                    @if($phase->media->count())
                        <div class="row">
                            @foreach($phase->media as $media)
                                <div class="col-md-3 mb-3">
                                    <div class="card">

                                        @if($media->file_type === 'image')
                                            <img
                                                src="{{ asset('storage/' . $media->file_path) }}"
                                                class="card-img-top"
                                                style="height:180px;object-fit:cover;"
                                            >
                                        @else
                                            <video class="w-100" height="180" controls>
                                                <source src="{{ asset('storage/' . $media->file_path) }}">
                                            </video>
                                        @endif

                                        <div class="card-body p-2 text-center">
                                            <form
                                                method="POST"
                                                action="{{ route('admin.projects.media.delete', $media->id) }}"
                                                onsubmit="return confirm('Delete this media?')"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
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
        <form method="POST" enctype="multipart/form-data" action="{{ route('admin.projects.addMedia') }}">
            @csrf
            <input type="hidden" name="phase_id" id="mediaPhaseId">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Media to Phase</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div id="mediaInputs">
                <!-- In your blade file, update the file input -->
                <input type="file" name="media[]" class="form-control mb-2" 
                    accept="image/*,video/*" required>
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

{{-- PURE VANILLA JS --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const phaseInput = document.getElementById('mediaPhaseId');
    const mediaInputs = document.getElementById('mediaInputs');

    document.querySelectorAll('.add-media-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            phaseInput.value = btn.dataset.phaseId;
        });
    });

    document.getElementById('addMoreMedia').addEventListener('click', () => {
    const input = document.createElement('input');
    input.type = 'file';
    input.name = 'media[]';
    input.className = 'form-control mb-2';
    input.accept = 'image/*,video/*'; // Add this line
    mediaInputs.appendChild(input);
});

    // Reset modal on close
    $('#addMediaModal').on('hidden.bs.modal', () => {
        mediaInputs.innerHTML = '<input type="file" name="media[]" class="form-control mb-2" required>';
        phaseInput.value = '';
    });

});
</script>

@endsection
