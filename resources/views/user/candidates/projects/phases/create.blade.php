@extends('layouts.app')

@section('title', 'Add Project Phase')

@section('content')
<section class="py-5 bg-light">
    <div class="container" style="max-width: 760px;">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4 p-md-5">
                <p class="text-muted mb-1">{{ $project->title }}</p>
                <h1 class="h3 mb-4">Add project phase</h1>
                <form method="POST" action="{{ route('user.candidates.projects.phases.store', [$candidate, $project]) }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6"><label for="phase" class="form-label">Phase</label><input id="phase" name="phase" class="form-control" value="{{ old('phase') }}" placeholder="Planning, execution, documentation…" required></div>
                        <div class="col-md-6"><label for="status" class="form-label">Status</label><input id="status" name="status" class="form-control" value="{{ old('status') }}"></div>
                        <div class="col-12"><label for="description" class="form-label">Description</label><textarea id="description" name="description" class="form-control" rows="4">{{ old('description') }}</textarea></div>
                        <div class="col-md-4"><label for="weight" class="form-label">Progress weight (%)</label><input id="weight" type="number" name="weight" class="form-control" min="1" max="100" value="{{ old('weight', 10) }}" required></div>
                        <div class="col-md-4"><label for="started_at" class="form-label">Started</label><input id="started_at" type="date" name="started_at" class="form-control" value="{{ old('started_at') }}"></div>
                        <div class="col-md-4"><label for="ended_at" class="form-label">Ended</label><input id="ended_at" type="date" name="ended_at" class="form-control" value="{{ old('ended_at') }}"></div>
                    </div>
                    <div class="d-flex gap-2 mt-4"><button class="btn btn-success" type="submit">Add phase</button><a class="btn btn-outline-secondary" href="{{ route('user.candidates.dashboard') }}">Cancel</a></div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
