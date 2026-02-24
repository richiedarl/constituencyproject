@extends('layouts.admin')

@section('title', 'My Applications')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col">
            <h1 class="h2">My Applications & Activities</h1>
            <p class="text-muted">Track all your applications, donations, and funding requests</p>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card bg-primary text-white shadow">
                <div class="card-body">
                    <h5 class="card-title">Total</h5>
                    <h2>{{ $stats['total'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-warning text-white shadow">
                <div class="card-body">
                    <h5 class="card-title">Pending</h5>
                    <h2>{{ $stats['pending'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-success text-white shadow">
                <div class="card-body">
                    <h5 class="card-title">Approved</h5>
                    <h2>{{ $stats['approved'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-secondary text-white shadow">
                <div class="card-body">
                    <h5 class="card-title">Cancelled/Rejected</h5>
                    <h2>{{ $stats['cancelled'] }}</h2>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter Tabs --}}
    <div class="row mb-4">
        <div class="col">
            <div class="btn-group" role="group">
                <a href="{{ route('user.applications.index') }}" class="btn btn-outline-primary {{ request()->routeIs('user.applications.index') ? 'active' : '' }}">All</a>
                <a href="{{ route('applications.pending') }}" class="btn btn-outline-warning {{ request()->routeIs('applications.pending') ? 'active' : '' }}">Pending</a>
                <a href="{{ route('applications.approved') }}" class="btn btn-outline-success {{ request()->routeIs('applications.approved') ? 'active' : '' }}">Approved</a>
                <a href="{{ route('applications.cancelled') }}" class="btn btn-outline-secondary {{ request()->routeIs('applications.cancelled') ? 'active' : '' }}">Cancelled/Rejected</a>
            </div>
        </div>
    </div>

    {{-- Applications List --}}
    <div class="row">
        <div class="col-12">
            @forelse($applications as $item)
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                {{-- Type Badge --}}
                                <span class="badge bg-info mb-2">{{ $item->type ?? 'Application' }}</span>

                                {{-- Title/Project Name --}}
                                <h5 class="mb-1">
                                    @if($item->type === 'Wallet Funding')
                                        {{ $item->project_name ?? 'Wallet Funding' }}
                                    @else
                                        {{ $item->project_name ?? $item->project?->title ?? 'N/A' }}
                                    @endif
                                </h5>

                                {{-- Details --}}
                                <div class="text-muted small">
                                    @if($item->type === 'Donation' || $item->type === 'Wallet Funding')
                                        <span class="me-3"><i class="fas fa-money-bill"></i> Amount: ₦{{ number_format($item->amount) }}</span>
                                    @endif

                                    @if(isset($item->from) && $item->from)
                                        <span class="me-3"><i class="fas fa-user"></i> From: {{ $item->from }}</span>
                                    @endif

                                    <span><i class="fas fa-calendar"></i> {{ $item->created_at->format('M d, Y') }}</span>
                                </div>
                            </div>

                            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                                {{-- Status Badge --}}
                                @php
                                    $statusClass = match($item->status) {
                                        'approved' => 'success',
                                        'pending' => 'warning',
                                        'rejected', 'failed', 'cancelled' => 'danger',
                                        default => 'secondary'
                                    };
                                @endphp
                                <span class="badge bg-{{ $statusClass }} mb-2">{{ ucfirst($item->status) }}</span>

                                {{-- Action Buttons --}}
                                <div>
                                    @if($item->type !== 'Wallet Funding' && ($item->project_id ?? $item->project?->id))
                                        <a href="{{ route('user.projects.show', $item->project_id ?? $item->project->id) }}"
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i> View Project
                                        </a>
                                    @endif

                                    @if($item->type === 'Application' && $item->status === 'pending' && isset($item->id))
                                        <form action="{{ route('applications.cancel', $item->id) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Cancel this application?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-times"></i> Cancel
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-info text-center py-5">
                    <i class="fas fa-inbox fa-3x mb-3"></i>
                    <h4>No items found</h4>
                    <p class="mb-0">You don't have any applications, donations, or funding requests yet.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .btn-group .btn.active {
        font-weight: bold;
    }
    .card {
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-2px);
    }
</style>
@endpush
