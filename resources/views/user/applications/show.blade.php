@extends('layouts.admin')

@section('title', 'Application Details')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col">
            <h1 class="h2">Application Details</h1>
        </div>
        <div class="col text-end">
            <a href="{{ route('user.applications.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Back to Applications
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Application Information</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th style="width: 200px;">Type:</th>
                            <td><span class="badge bg-info">{{ $application->type ?? 'Application' }}</span></td>
                        </tr>
                        <tr>
                            <th>Project:</th>
                            <td>
                                @if($application->project)
                                    <a href="{{ route('user.projects.show', $application->project) }}">
                                        {{ $application->project->title }}
                                    </a>
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td>
                                @php
                                    $statusClass = match($application->status) {
                                        'approved' => 'success',
                                        'pending' => 'warning',
                                        'rejected', 'cancelled' => 'danger',
                                        default => 'secondary'
                                    };
                                @endphp
                                <span class="badge bg-{{ $statusClass }}">{{ ucfirst($application->status) }}</span>
                            </td>
                        </tr>
                        <tr>
                            <th>Amount:</th>
                            <td>₦{{ number_format($application->amount ?? 0) }}</td>
                        </tr>
                        <tr>
                            <th>Applied On:</th>
                            <td>{{ $application->created_at->format('F d, Y h:i A') }}</td>
                        </tr>
                        @if($application->applied_at)
                        <tr>
                            <th>Application Date:</th>
                            <td>{{ \Carbon\Carbon::parse($application->applied_at)->format('F d, Y') }}</td>
                        </tr>
                        @endif
                        @if($application->approved_at)
                        <tr>
                            <th>Approved On:</th>
                            <td>{{ \Carbon\Carbon::parse($application->approved_at)->format('F d, Y') }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    @if($application->status === 'pending' && $application->type === 'Application')
                        <form action="{{ route('applications.cancel', $application->id) }}"
                              method="POST"
                              onsubmit="return confirm('Are you sure you want to cancel this application?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100 mb-2">
                                <i class="fas fa-times"></i> Cancel Application
                            </button>
                        </form>
                    @endif

                    @if($application->project)
                        <a href="{{ route('user.projects.show', $application->project) }}"
                           class="btn btn-primary w-100">
                            <i class="fas fa-eye"></i> View Project
                        </a>
                    @endif
                </div>
            </div>

            @if($application->contractor)
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Contractor Details</h5>
                </div>
                <div class="card-body">
                    <p class="mb-1"><strong>Name:</strong> {{ $application->contractor->user->name ?? 'N/A' }}</p>
                    <p class="mb-1"><strong>Email:</strong> {{ $application->contractor->user->email ?? 'N/A' }}</p>
                </div>
            </div>
            @endif

            @if($application->contributor)
            <div class="card shadow-sm mt-3">
                <div class="card-header">
                    <h5 class="mb-0">Contributor Details</h5>
                </div>
                <div class="card-body">
                    <p class="mb-1"><strong>Name:</strong> {{ $application->contributor->user->name ?? 'N/A' }}</p>
                    <p class="mb-1"><strong>Email:</strong> {{ $application->contributor->user->email ?? 'N/A' }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
