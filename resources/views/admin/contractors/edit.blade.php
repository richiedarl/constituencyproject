@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Edit Contractor → {{ $contractor->name }}</h4>

        <a href="{{ route('contractors.index') }}" class="btn btn-light">
            ← Back
        </a>
    </div>

    <form method="POST"
          action="{{ route('contractors.update', $contractor) }}"
          enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="row">

            {{-- LEFT --}}
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-body">

                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text"
                                   name="name"
                                   class="form-control"
                                   value="{{ old('name', $contractor->name) }}"
                                   required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Email</label>
                                <input type="email"
                                       name="email"
                                       class="form-control"
                                       value="{{ old('email', $contractor->email) }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Phone</label>
                                <input type="text"
                                       name="phone"
                                       class="form-control"
                                       value="{{ old('phone', $contractor->phone) }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Gender</label>
                                <select name="gender" class="form-control">
                                    <option value="">— Select —</option>
                                    <option value="male" {{ $contractor->gender === 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ $contractor->gender === 'female' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Occupation</label>
                                <input type="text"
                                       name="occupation"
                                       class="form-control"
                                       value="{{ old('occupation', $contractor->occupation) }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>District</label>
                            <input type="text"
                                   name="district"
                                   class="form-control"
                                   value="{{ old('district', $contractor->district) }}">
                        </div>

                        <div class="mb-3">
                            <label>Bio</label>
                            <textarea name="bio"
                                      class="form-control"
                                      rows="4">{{ old('bio', $contractor->bio) }}</textarea>
                        </div>

                    </div>
                </div>
            </div>

            {{-- RIGHT --}}
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body text-center">

                        @if($contractor->photo)
                            <img src="{{ asset('storage/'.$contractor->photo) }}"
                                 class="img-fluid rounded mb-3"
                                 style="max-height: 200px;">
                        @endif

                        <div class="mb-3">
                            <label>Profile Photo</label>
                            <input type="file"
                                   name="photo"
                                   class="form-control">
                        </div>

                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input"
                                   type="checkbox"
                                   name="approved"
                                   value="1"
                                   {{ $contractor->approved ? 'checked' : '' }}>
                            <label class="form-check-label">
                                Approved Contractor
                            </label>
                        </div>

                        <hr>

                        <p class="text-muted mb-1">
                            Approved Projects
                        </p>
                        <h5>{{ $contractor->approved_projects_count }}</h5>

                    </div>
                </div>
            </div>

        </div>

        <div class="text-end">
            <button class="btn btn-primary">
                Update Contractor
            </button>
        </div>

    </form>

</div>
@endsection
