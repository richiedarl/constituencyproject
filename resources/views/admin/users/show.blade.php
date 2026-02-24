@extends('layouts.admin')

@section('title', 'User Details - ' . $user->name)

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col">
            <h1 class="h2">User Details</h1>
        </div>
        <div class="col text-end">
            <a href="{{ route('checks.users.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Users
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <!-- User Info Card -->
            <div class="card shadow mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">User Information</h5>
                </div>
                <div class="card-body text-center">
                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-3"
                         style="width: 80px; height: 80px; font-size: 2rem;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <h4>{{ $user->name }}</h4>
                    <p class="text-muted">{{ '@' . $user->username }}</p>
                    <p><i class="fas fa-envelope me-2"></i>{{ $user->email }}</p>
                    <p><i class="fas fa-calendar me-2"></i>Joined {{ $user->created_at->format('M d, Y') }}</p>

                    <hr>

                    <h6 class="fw-bold">Current Role</h6>
                    @if($user->candidate)
                        <span class="badge bg-primary p-2">Candidate</span>
                    @elseif($user->contractor)
                        <span class="badge bg-success p-2">Contractor</span>
                    @elseif($user->contributor)
                        <span class="badge bg-info p-2">Contributor</span>
                    @else
                        <span class="badge bg-secondary p-2">No Role</span>
                    @endif

                    <hr>

                    <h6 class="fw-bold">Wallet Balance</h6>
                    <h3 class="text-success">₦{{ number_format($user->wallet->balance ?? 0, 2) }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <!-- Change Role Form -->
            <div class="card shadow mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Change User Role</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('checks.users.change-role', $user) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-8">
                                <select name="new_role" class="form-select @error('new_role') is-invalid @enderror" required>
                                    <option value="">Select new role...</option>
                                    <option value="candidate" {{ $user->candidate ? 'selected' : '' }}>Candidate</option>
                                    <option value="contractor" {{ $user->contractor ? 'selected' : '' }}>Contractor</option>
                                    <option value="contributor" {{ $user->contributor ? 'selected' : '' }}>Contributor</option>
                                    <option value="none" {{ !$user->candidate && !$user->contractor && !$user->contributor ? 'selected' : '' }}>No Role</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-warning w-100" onclick="return confirm('Are you sure you want to change this user\'s role?')">
                                    Update Role
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Role Details -->
            <div class="card shadow">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Role Details</h5>
                </div>
                <div class="card-body">
                    @if($user->candidate)
                        <h6 class="fw-bold">Candidate Information</h6>
                        <table class="table">
                            <tr>
                                <th>Name:</th>
                                <td>{{ $user->candidate->name }}</td>
                            </tr>
                            <tr>
                                <th>Phone:</th>
                                <td>{{ $user->candidate->phone ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>District:</th>
                                <td>{{ $user->candidate->district ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>State:</th>
                                <td>{{ $user->candidate->state ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Gender:</th>
                                <td>{{ $user->candidate->gender ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Approved:</th>
                                <td>
                                    @if($user->candidate->approved)
                                        <span class="badge bg-success">Yes</span>
                                    @else
                                        <span class="badge bg-warning">No</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    @elseif($user->contractor)
                        <h6 class="fw-bold">Contractor Information</h6>
                        <table class="table">
                            <tr>
                                <th>Name:</th>
                                <td>{{ $user->contractor->name }}</td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td>{{ $user->contractor->email }}</td>
                            </tr>
                            <tr>
                                <th>Phone:</th>
                                <td>{{ $user->contractor->phone ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>District:</th>
                                <td>{{ $user->contractor->district ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Occupation:</th>
                                <td>{{ $user->contractor->occupation ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Approved:</th>
                                <td>
                                    @if($user->contractor->approved)
                                        <span class="badge bg-success">Yes</span>
                                    @else
                                        <span class="badge bg-warning">No</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    @elseif($user->contributor)
                        <h6 class="fw-bold">Contributor Information</h6>
                        <table class="table">
                            <tr>
                                <th>District:</th>
                                <td>{{ $user->contributor->district ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Gender:</th>
                                <td>{{ $user->contributor->gender ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Bio:</th>
                                <td>{{ $user->contributor->bio ?? 'N/A' }}</td>
                            </tr>
                        </table>
                    @else
                        <p class="text-muted">This user has no role assigned.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
