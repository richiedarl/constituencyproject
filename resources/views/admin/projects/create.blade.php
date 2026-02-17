@extends('layouts.admin')

@section('content')
{{-- Dropzone --}}
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>


<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Add New Project</h1>
    </div>

    {{-- CSV Upload (Optional) --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Optional: Populate From CSV
            </h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.projects.create') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-row align-items-end">
                    <div class="col-md-6">
                        <label>CSV File</label>
                        <input type="file"
                               name="csv_file"
                               class="form-control-file"
                               accept=".csv">
                        <small class="text-muted">
                            Upload a CSV to prefill project fields. This will NOT save the project.
                        </small>
                    </div>

                    <div class="col-md-3">
                        <button type="submit" class="btn btn-outline-primary mt-3">
                            Populate Form
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Project Form --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Project Details
            </h6>
        </div>

        <div class="card-body">
            <form method="POST"
                  action="{{ route('admin.projects.store') }}"
                  enctype="multipart/form-data">

                @csrf

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Project Title</label>
                        <input type="text"
                               name="title"
                               class="form-control"
                               value="{{ old('title', $csvData['title'] ?? '') }}"
                               required>
                    </div>

                    <div class="form-group col-md-6">
                <label>Candidate</label>

                <div class="d-flex">
                    <select name="candidate_id"
                            id="candidateSelect"
                            class="form-control mr-2"
                            required>
                        <option value="">Select Candidate</option>
                        @foreach($candidates as $candidate)
                            <option value="{{ $candidate->id }}">
                                {{ $candidate->name }}
                            </option>
                        @endforeach
                    </select>

                    <button type="button"
                            class="btn btn-outline-primary"
                            data-toggle="modal"
                            data-target="#addCandidateModal">
                        +
                    </button>
                </div>

                <small class="text-muted">
                    Can’t find candidate? Add one instantly.
                </small>
            </div>

                </div>

                <div class="form-group">
                    <label>Short Description</label>
                    <textarea name="short_description"
                              class="form-control"
                              rows="2">{{ old('short_description', $csvData['short_description'] ?? '') }}</textarea>
                </div>

                <div class="form-group">
                    <label>Full Description</label>
                    <textarea name="description"
                              class="form-control"
                              rows="4">{{ old('description', $csvData['description'] ?? '') }}</textarea>
                </div>
                    <div class="form-group col-md-4">
                    <label>Project Mode</label>
                    <select name="project_mode" class="form-control" required>
                        <option value="executing">Executing (We ran this project)</option>
                        <option value="documenting">Documenting (We verified & archived)</option>
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Status</label>
                        <select name="status" class="form-control" required>
                            @foreach(['planning','ongoing','completed','cancelled'] as $status)
                                <option value="{{ $status }}"
                                    {{ old('status', $csvData['status'] ?? '') === $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label>Start Date</label>
                        <input type="date"
                               name="start_date"
                               class="form-control"
                               value="{{ old('start_date', $csvData['start_date'] ?? '') }}">
                    </div>

                    <div class="form-group col-md-4">
                        <label>Completion Date</label>
                        <input type="date"
                               name="completion_date"
                               class="form-control"
                               value="{{ old('completion_date', $csvData['completion_date'] ?? '') }}">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>State</label>
                        <input type="text"
                               name="state"
                               class="form-control"
                               value="{{ old('state', $csvData['state'] ?? '') }}">
                    </div>

                    <div class="form-group col-md-6">
                        <label>LGA</label>
                        <input type="text"
                               name="lga"
                               class="form-control"
                               value="{{ old('lga', $csvData['lga'] ?? '') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label>Estimated Budget</label>
                    <input type="number"
                           name="estimated_budget"
                           class="form-control"
                           step="0.01"
                           value="{{ old('estimated_budget', $csvData['estimated_budget'] ?? '') }}">
                </div>

                <div class="form-group">
                    <label>Contractor Fee</label>
                    <input type="number"
                           name="actual_cos"
                           class="form-control"
                           step="0.01"
                           value="{{ old('actual_cost', $csvData['actual_cost'] ?? '') }}">
                </div>

                <hr>
                                {{-- Featured Image --}}
                <div class="form-group">
                    <label>Featured Image</label>
                    <input type="file"
                        name="featured_image"
                        class="form-control-file"
                        accept="image/*">
                </div>

                {{-- Initial Project Media --}}
               <hr>

                <h6 class="text-muted mb-2">Project Media (Evidence)</h6>

                <div class="form-group">
                    <div id="projectMediaDropzone"
                        class="dropzone border rounded p-3 text-center">
                        <div class="dz-message text-muted">
                            <strong>Drag & drop images/videos here</strong><br>
                            <small>or click to browse (Max 20 files)</small>
                        </div>
                    </div>

                    {{-- fallback input for submission --}}
                    <input type="file"
                        name="media[]"
                        id="projectMediaInput"
                        class="d-none"
                        multiple
                        accept="image/*,video/*">

                    <small class="text-muted">
                        You can upload multiple files. These will be attached to the initial project phase.
                    </small>
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-primary">
                        Save Project
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>
<!-- Add Candidate Modal -->
<!-- Add Candidate Modal -->
<div class="modal fade" id="addCandidateModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add New Candidate</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
    <form action="{{ route('project_candidate_store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <h6 class="text-muted mb-3">Basic Information</h6>

    <div class="form-row">
        <div class="form-group col-md-3">
            <label>Title</label>
            <select name="title" class="form-control">
                <option value="">—</option>
                <option>Mr</option>
                <option>Mrs</option>
                <option>Miss</option>
                <option>Dr</option>
                <option>Hon</option>
                <option>Chief</option>
                <option>Engr</option>
                <option>Prof</option>
            </select>
        </div>

        <div class="form-group col-md-5">
            <label>Full Name *</label>
            <input type="text" name="name" class="form-control" required>
            <small class="text-muted">This will appear on the public profile</small>
        </div>

        <div class="form-group col-md-4">
            <label>Email</label>
            <input type="email" name="email" class="form-control">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control">
        </div>

        <div class="form-group col-md-6">
            <label>Gender</label>
            <select name="gender" class="form-control">
                <option value="">—</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label>District / Constituency</label>
        <input type="text" name="district" class="form-control">
    </div>

    <div class="form-group">
        <label>Community</label>
        <input type="text" name="community" class="form-control">
    </div>

    <div class="form-group">
        <label>Address</label>
        <input type="text" name="address" class="form-control">
    </div>
    
    <div class="form-group">
        <label>State</label>
        <input type="text" name="state" class="form-control">
    </div>

    <div class="form-group">
        <label>Candidate Photo</label>
        <input type="file" name="photo" class="form-control-file" accept="image/*">
    </div>

    <hr>

    <h6 class="text-muted mb-3">Current Position</h6>

    <div class="form-row">
        <div class="form-group col-md-6 position-relative">
            <label>Position *</label>
            <input type="text" name="position" id="positionInput" class="form-control" autocomplete="off" required>
            <div id="positionSuggestions" class="list-group position-absolute w-100 d-none"></div>
            <small class="text-muted">Start typing to see common positions</small>
        </div>

        <div class="form-group col-md-3">
            <label>From</label>
            <input type="number" name="year_from" id="yearFrom" class="form-control" placeholder="2023">
        </div>

        <div class="form-group col-md-3">
            <label>To</label>
            <input type="number" name="year_until" id="yearUntil" class="form-control" placeholder="Present">
        </div>
    </div>

    <div id="positionPreview" class="alert alert-light small d-none"></div>

    <div class="text-right mt-4">
        <button type="submit" class="btn btn-primary">
            Save Candidate
        </button>
    </div>
</form>


            </div>

        </div>
    </div>
</div>
@if(session('candidate_created'))
<script>
    (function () {
        const select = document.getElementById('candidateSelect');
        if (select) {
            select.value = "{{ session('candidate_created') }}";
        }
    })();
</script>
@endif
@if(session('candidate_created'))
<script>
    (function () {
        const select = document.getElementById('candidateSelect');
        if (select) {
            select.value = "{{ session('candidate_created') }}";
        }

        Swal.fire({
            icon: 'success',
            title: 'Candidate added',
            text: 'Candidate created successfully and selected',
            timer: 2500,
            showConfirmButton: false
        });
    })();
</script>
@endif


<script>
Dropzone.autoDiscover = false;

const mediaInput = document.getElementById('projectMediaInput');

const myDropzone = new Dropzone("#projectMediaDropzone", {
    url: "#", // not used
    autoProcessQueue: false,
    uploadMultiple: true,
    parallelUploads: 20,
    maxFiles: 20,
    maxFilesize: 20, // MB
    acceptedFiles: "image/*,video/*",
    addRemoveLinks: true,

    init: function () {
        this.on("addedfile", syncFiles);
        this.on("removedfile", syncFiles);
    }
});

function syncFiles() {
    const dataTransfer = new DataTransfer();

    myDropzone.files.forEach(file => {
        // Only add files that are fully uploaded/valid
        if (file.status !== "removed" && file.upload && file.upload.bytesSent !== 0) {
            dataTransfer.items.add(file);
        } else if (file.status === "added") {
            dataTransfer.items.add(file); // new files just added
        }
    });

    mediaInput.files = dataTransfer.files;
}

</script>

<script>
document.getElementById('addCandidateForm')
    .addEventListener('submit', function (e) {

    e.preventDefault();

fetch("{{ route('admin.candidates.store.ajax') }}", {
    method: "POST",
    headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Accept': 'application/json'
    },
    body: new FormData(this)
})
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            let select = document.getElementById('candidateSelect');
            let option = document.createElement('option');

            option.value = data.candidate.id;
            option.text  = data.candidate.name;
            option.selected = true;

            select.appendChild(option);

            $('#addCandidateModal').modal('hide');
            this.reset();
        }
    });
});
</script>

<script>
    const positions = [
        "Member, House of Representatives",
        "Senator",
        "Governor",
        "Deputy Governor",
        "Commissioner",
        "Local Government Chairman",
        "Councillor",
        "Special Adviser",
        "Special Assistant",
        "Minister",
        "Permanent Secretary"
    ];

    const positionInput = document.getElementById('positionInput');
    const suggestionsBox = document.getElementById('positionSuggestions');
    const previewBox = document.getElementById('positionPreview');

    positionInput.addEventListener('input', () => {
        const query = positionInput.value.toLowerCase();
        suggestionsBox.innerHTML = '';

        if (!query) {
            suggestionsBox.classList.add('d-none');
            return;
        }

        const matches = positions.filter(p => p.toLowerCase().includes(query));

        if (!matches.length) {
            suggestionsBox.classList.add('d-none');
            return;
        }

        matches.forEach(position => {
            const item = document.createElement('button');
            item.type = 'button';
            item.className = 'list-group-item list-group-item-action';
            item.textContent = position;

            item.onclick = () => {
                positionInput.value = position;
                suggestionsBox.classList.add('d-none');
                updatePreview();
            };

            suggestionsBox.appendChild(item);
        });

        suggestionsBox.classList.remove('d-none');
    });

    document.getElementById('yearFrom').addEventListener('input', updatePreview);
    document.getElementById('yearUntil').addEventListener('input', updatePreview);

    function updatePreview() {
        const position = positionInput.value;
        const from = document.getElementById('yearFrom').value;
        const until = document.getElementById('yearUntil').value || 'Present';

        if (!position || !from) {
            previewBox.classList.add('d-none');
            return;
        }

        previewBox.textContent = `Current Position: ${position} (${from} – ${until})`;
        previewBox.classList.remove('d-none');
    }

    document.addEventListener('click', (e) => {
        if (!positionInput.contains(e.target)) {
            suggestionsBox.classList.add('d-none');
        }
    });
</script>




@endsection
