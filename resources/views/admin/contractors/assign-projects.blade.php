@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    {{-- Contractor Header --}}
    <div class="card mb-4">
        <div class="card-body d-flex align-items-center">
            @if($contractor->photo)
                <img src="{{ asset('storage/' . $contractor->photo) }}"
                     alt="{{ $contractor->name }}"
                     class="rounded-circle me-3"
                     style="width: 60px; height: 60px; object-fit: cover;">
            @else
                <div class="rounded-circle bg-secondary me-3"
                     style="width: 60px; height: 60px;"></div>
            @endif

            <div>
                <h5 class="mb-0">{{ $contractor->user->name ?? $contractor->name }}</h5>
                <small class="text-muted">{{ $contractor->occupation ?? '—' }}</small>
            </div>
        </div>
    </div>

    <a href="{{ route('contractors.index') }}" class="btn btn-light mb-3">
        ← Back
    </a>

    <div class="card">
        <div class="list-group list-group-flush">

            @forelse($projects as $project)
                @php
                    $approvedCount = $project->applications
                        ->where('status', \App\Models\Application::STATUS_APPROVED)
                        ->count();

                    $isFull = $approvedCount >= $project->contractor_count;
                @endphp

                <div class="list-group-item d-flex justify-content-between align-items-center
                    {{ $isFull ? 'bg-light text-muted' : '' }}">
                    <div>
                        <strong>{{ $project->title }}</strong><br>
                        <small>
                            Approved: {{ $approvedCount }}
                            / {{ $project->contractor_count }}
                        </small>
                    </div>

                    @if($isFull)
                        <span class="badge bg-secondary text-white">Quota Already Filled</span>
                    @else
                        <form method="POST"
                              action="{{ route('professionals.assign-project', $contractor) }}">
                            @csrf
                            <input type="hidden" name="project_id" value="{{ $project->id }}">
                            <button class="btn btn-primary btn-sm">Assign</button>
                        </form>
                    @endif
                </div>
            @empty
                <div class="list-group-item text-center text-muted">
                    No projects found.
                </div>
            @endforelse

        </div>
    </div>

</div>
@endsection
