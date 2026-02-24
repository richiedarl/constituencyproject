@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Apply as a Candidate</h4>
                </div>

                <div class="card-body">

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    {{-- Authenticated User Info --}}
                    <div class="mb-4 p-3 bg-light border rounded">
                        <strong>Name:</strong> {{ auth()->user()->name }} <br>
                        <strong>Email:</strong> {{ auth()->user()->email }}
                    </div>

                    @php
                        $details = \App\Models\Detail::first();
                    @endphp

                    @if(
                        $details &&
                        $details->bank_name &&
                        $details->account_name &&
                        $details->account_number
                    )
                        <div class="alert alert-info">
                            <strong>Bank:</strong> {{ $details->bank_name }} <br>
                            <strong>Account Name:</strong> {{ $details->account_name }} <br>
                            <strong>Account Number:</strong> {{ $details->account_number }} <br>
                            <strong>Amount to pay::</strong> {{ $details->application_fee ?? "N500000"}}
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <strong>Payment details not yet configured.</strong><br>
                            Please contact the administrator.
                        </div>
                    @endif

                    <form method="POST" action="{{ route('user.candidates.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3 form-check">
                            <input type="checkbox"
                                   class="form-check-input @error('paid') is-invalid @enderror"
                                   name="paid"
                                   id="paid"
                                   required>

                            <label class="form-check-label" for="paid">
                                I confirm that I have paid the application fee
                                <small>You pay per project</small>
                            </label>

                            @error('paid')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <h5 class="mb-3">Personal Information</h5>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">
                                    Phone Number <span class="text-danger">*</span>
                                </label>
                                <input type="tel"
                                       class="form-control @error('phone') is-invalid @enderror"
                                       name="phone"
                                       value="{{ old('phone') }}"
                                       required>

                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="gender" class="form-label">
                                    Gender <span class="text-danger">*</span>
                                </label>
                                <select class="form-control @error('gender') is-invalid @enderror"
                                        name="gender"
                                        required>
                                    <option value="">Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>

                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    State <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       class="form-control @error('state') is-invalid @enderror"
                                       name="state"
                                       value="{{ old('state') }}"
                                       required>

                                @error('state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    District/Constituency <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       class="form-control @error('district') is-invalid @enderror"
                                       name="district"
                                       value="{{ old('district') }}"
                                       required>

                                @error('district')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <h5 class="mb-3 mt-4">Current Position</h5>
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


                        <div class="mb-3">
                            <label class="form-label">Short Bio / Motivation</label>
                            <textarea class="form-control @error('bio') is-invalid @enderror"
                                      name="bio"
                                      rows="4">{{ old('bio') }}</textarea>

                            @error('bio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Profile Photo</label>
                            <input type="file"
                                   class="form-control @error('photo') is-invalid @enderror"
                                   name="photo"
                                   accept="image/*">

                            @error('photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                      <div class="alert alert-info">
                            <small>
                                <i class="fas fa-info-circle"></i>
                                Your project has been submitted. You’ll be notified once the administrator reviews and approves it.
                            </small>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-lg">Submit Project</button>
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">Save and Continue Later</a>
                        </div>


                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

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
