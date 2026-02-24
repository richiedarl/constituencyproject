{{-- //views/user/contractors/reports/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col">
            <h1 class="h2">Submit Daily Report</h1>
            <p class="text-muted">Record your daily progress and upload photos</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">New Report</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Project Selection --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Select Project</label>
                            <select name="project_id" id="project-select" class="form-select @error('project_id') is-invalid @enderror" required>
                                <option value="">Choose a project...</option>
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                        {{ $project->title }} ({{ ucfirst($project->status) }})
                                    </option>
                                @endforeach
                            </select>
                            @error('project_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                      {{-- Phase Selection (loaded via AJAX) --}}
<div class="mb-3">
    <label class="form-label fw-semibold">Select Phase</label>
    <select name="phase_id" id="phase-select" class="form-select @error('phase_id') is-invalid @enderror" required disabled>
        <option value="">First select a project</option>
    </select>
    @error('phase_id')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
    <small class="text-muted">Select the phase you're reporting on</small>
</div>

                        {{-- Report Comment --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Daily Report</label>
                            <textarea name="comment" class="form-control @error('comment') is-invalid @enderror"
                                      rows="5" placeholder="Describe the work done today, challenges, next steps..."
                                      required>{{ old('comment') }}</textarea>
                            @error('comment')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Photo Upload --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Upload Photos (Max 5)</label>
                            <input type="file" name="photos[]" class="form-control @error('photos.*') is-invalid @enderror"
                                   multiple accept="image/*" id="photo-upload">
                            <small class="text-muted">You can select multiple photos. Max 5MB per photo.</small>

                            {{-- Preview Container --}}
                            <div id="preview-container" class="row mt-3"></div>

                            @error('photos.*')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg px-5">
                            <i class="fas fa-paper-plane me-2"></i>Submit Report
                        </button>
                    </form>
                </div>
            </div>
        </div>

{{-- Recent Reports Sidebar --}}
<div class="col-lg-4">
    <div class="card shadow">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Recent Reports</h5>
        </div>
        <div class="card-body">
            @forelse($recentUpdates as $update)
                <div class="border-bottom pb-2 mb-2">
                    <small class="text-primary">{{ $update->phase->project->title }} - {{ $update->phase->name }}</small>
                    <p class="mb-0 small">{{ Str::limit($update->comment, 60) }}</p>
                    <small class="text-muted">{{ $update->created_at->diffForHumans() }}</small>
                </div>
            @empty
                <p class="text-muted text-center mb-0">No recent reports</p>
            @endforelse
        </div>
    </div>
</div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('project-select').addEventListener('change', function() {
    const projectId = this.value;
    const phaseSelect = document.getElementById('phase-select');

    if (projectId) {
        // Disable and show loading
        phaseSelect.disabled = true;
        phaseSelect.innerHTML = '<option value="">Loading phases...</option>';

        // Fetch phases
        fetch(`/reports/phases/${projectId}`)
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw new Error(err.error || 'Failed to load phases'); });
                }
                return response.json();
            })
            .then(data => {
                // Clear current options
                phaseSelect.innerHTML = '';

                if (data.message === 'No phases found for this project' || data.length === 0) {
                    // No phases found
                    phaseSelect.innerHTML = '<option value="">No phases found for this project</option>';
                } else {
                    // Phases found
                    phaseSelect.innerHTML = '<option value="">Select a phase...</option>';

                    data.forEach(phase => {
                        // Use display_name if available, otherwise construct one
                        let displayText = phase.display_name ||
                            (phase.name + (phase.status ? ` (${phase.status})` : ''));

                        phaseSelect.innerHTML += `<option value="${phase.id}">${displayText}</option>`;
                    });
                }
                phaseSelect.disabled = false;
            })
            .catch(error => {
                console.error('Error:', error);
                phaseSelect.innerHTML = '<option value="">Error loading phases</option>';
                phaseSelect.disabled = false;

                // Show error message to user
                alert('Failed to load phases: ' + error.message);
            });
    } else {
        phaseSelect.disabled = true;
        phaseSelect.innerHTML = '<option value="">First select a project</option>';
    }
});

// Photo preview
document.getElementById('photo-upload').addEventListener('change', function(e) {
    const container = document.getElementById('preview-container');
    container.innerHTML = '';

    const files = Array.from(e.target.files);

    if (files.length > 5) {
        alert('You can only upload up to 5 photos');
        this.value = '';
        return;
    }

    files.forEach((file, index) => {
        if (!file.type.startsWith('image/')) {
            alert(`File ${file.name} is not an image`);
            return;
        }

        if (file.size > 5 * 1024 * 1024) {
            alert(`File ${file.name} is larger than 5MB`);
            return;
        }

        const reader = new FileReader();
        reader.onload = function(readerEvent) {
            const col = document.createElement('div');
            col.className = 'col-md-4 col-6 mb-2';
            col.innerHTML = `
                <div class="position-relative">
                    <img src="${readerEvent.target.result}" class="img-fluid rounded" style="height: 80px; width: 100%; object-fit: cover;">
                    <span class="position-absolute top-0 end-0 bg-primary text-white rounded-circle px-2">${index + 1}</span>
                </div>
            `;
            container.appendChild(col);
        };
        reader.readAsDataURL(file);
    });
});
</script>
@endpush
