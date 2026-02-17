@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>My Applications</h2>

    @foreach($applications as $application)
        <div class="card mb-3">
            <div class="card-body">
                <h5>{{ $application->project->title }}</h5>
                <p>Status: {{ ucfirst($application->status) }}</p>
                <a href="{{ route('projects.show', $application->project) }}">
                    View Project
                </a>
            </div>
        </div>
    @endforeach
</div>
@endsection
