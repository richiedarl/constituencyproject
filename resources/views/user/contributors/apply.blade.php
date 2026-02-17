@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    Apply to Contribute to Project
                </div>

                <div class="card-body">

                    <h5>{{ $project->title }}</h5>
                    <p class="text-muted">{{ $project->short_description }}</p>

                    <ul class="list-group mb-3">
                        <li class="list-group-item"><strong>Location:</strong> {{ $project->full_location }}</li>
                        <li class="list-group-item"><strong>Status:</strong> {{ ucfirst($project->status) }}</li>
                        <li class="list-group-item"><strong>Candidate:</strong> {{ $project->candidate->name ?? '—' }}</li>
                        <li class="list-group-item"><strong>Estimated Budget:</strong> ₦{{ number_format($project->estimated_budget ?? 0) }}</li>
                    </ul>

                    <form action="{{ route('contributors.apply.submit', $project->id) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="motivation">Why do you want to contribute?</label>
                            <textarea name="motivation" id="motivation" class="form-control" rows="4" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-success">Submit Application</button>
                        <a href="{{ route('welcome') }}" class="btn btn-secondary">Cancel</a>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
