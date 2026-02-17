@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Step 2: Project Information</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('candidates.projects.store', $candidate->id) }}">
                        @csrf

                        <h5 class="mb-3">Project Details</h5>

                        <div class="mb-3">
                            <label for="title" class="form-label">Project Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                   id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="short_description" class="form-label">Short Description <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('short_description') is-invalid @enderror"
                                   id="short_description" name="short_description" value="{{ old('short_description') }}"
                                   maxlength="200" required>
                            <small class="text-muted">Brief summary (max 200 characters)</small>
                            @error('short_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Full Description <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <h5 class="mb-3 mt-4">Location</h5>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="state" class="form-label">State <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('state') is-invalid @enderror"
                                       id="state" name="state" value="{{ old('state') }}" required>
                                @error('state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="lga" class="form-label">LGA <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('lga') is-invalid @enderror"
                                       id="lga" name="lga" value="{{ old('lga') }}" required>
                                @error('lga')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="ward" class="form-label">Ward</label>
                                <input type="text" class="form-control @error('ward') is-invalid @enderror"
                                       id="ward" name="ward" value="{{ old('ward') }}">
                                @error('ward')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="community" class="form-label">Community</label>
                                <input type="text" class="form-control @error('community') is-invalid @enderror"
                                       id="community" name="community" value="{{ old('community') }}">
                                @error('community')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Full Address</label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror"
                                   id="address" name="address" value="{{ old('address') }}">
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <h5 class="mb-3 mt-4">Budget & Timeline</h5>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="estimated_budget" class="form-label">Estimated Budget (₦) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('estimated_budget') is-invalid @enderror"
                                       id="estimated_budget" name="estimated_budget" value="{{ old('estimated_budget') }}"
                                       min="0" step="0.01" required>
                                @error('estimated_budget')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                                       id="start_date" name="start_date" value="{{ old('start_date') }}"
                                       min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="completion_date" class="form-label">Expected Completion Date</label>
                                <input type="date" class="form-control @error('completion_date') is-invalid @enderror"
                                       id="completion_date" name="completion_date" value="{{ old('completion_date') }}"
                                       min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                @error('completion_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <small>
                                <i class="fas fa-info-circle"></i>
                                Next step: You'll break down this project into phases and upload photos for each phase.
                            </small>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-lg">Continue to Project Phases</button>
                            <a href="{{ route('candidates.dashboard') }}" class="btn btn-outline-secondary">Save and Continue Later</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
