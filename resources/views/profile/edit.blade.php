@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-white py-3">
                    <h4 class="mb-0">Edit Profile</h4>
                </div>
                <div class="card-body p-4">

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <!-- Current Role Info -->
                    <div class="mb-4 p-3 rounded-3" style="background: rgba(41, 162, 33, 0.05);">
                        <h5 class="fw-bold mb-3">Current Role</h5>
                        @if($currentRole)
                            <div class="d-flex align-items-center">
                                <span class="badge px-3 py-2 me-2" style="background: #29a221; color: white;">
                                    {{ ucfirst($currentRole) }}
                                </span>
                                @if($pendingRequest)
                                    <span class="badge bg-warning text-dark">Change Pending</span>
                                @endif
                            </div>
                            @if($roleData)
                                <div class="mt-3">
                                    <p><strong>Bio:</strong> {{ $roleData->bio ?? 'Not provided' }}</p>
                                    <p><strong>Location:</strong> {{ $roleData->district ?? 'Not provided' }}</p>
                                </div>
                            @endif
                        @else
                            <p class="text-muted">You haven't selected a role yet.</p>
                        @endif
                    </div>

                    <!-- Profile Update Form -->
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', $user->name) }}" required>
                                @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
                                       value="{{ old('username', $user->username) }}" required>
                                @error('username') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', $user->email) }}" required>
                            @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <hr class="my-4">

                        <h5 class="mb-3">Change Password (Optional)</h5>

                        <div class="mb-3">
                            <label class="form-label">Current Password</label>
                            <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror">
                            @error('current_password') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">New Password</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                                @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary px-5">
                            Update Profile
                        </button>
                    </form>

                    <hr class="my-4">

                    <!-- Role Change Request -->
                    <h5 class="mb-3">Change Role</h5>

                    @if($pendingRequest)
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            You have a pending request to change your role to
                            <strong>{{ ucfirst($pendingRequest->requested_role) }}</strong>.
                            Submitted on {{ $pendingRequest->created_at->format('M d, Y') }}.
                        </div>
                    @else
                        <form action="{{ route('profile.change-role') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-8">
                                    <select name="requested_role" class="form-select @error('requested_role') is-invalid @enderror" required>
                                        <option value="">Select new role...</option>
                                        <option value="candidate" {{ $currentRole === 'candidate' ? 'disabled' : '' }}>Candidate</option>
                                        <option value="contractor" {{ $currentRole === 'contractor' ? 'disabled' : '' }}>Contractor</option>
                                        <option value="contributor" {{ $currentRole === 'contributor' ? 'disabled' : '' }}>Contributor</option>
                                    </select>
                                    @error('requested_role') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-warning w-100">
                                        Submit Request
                                    </button>
                                </div>
                            </div>
                            <small class="text-muted">
                                Your request will be reviewed by an administrator. You'll be notified once it's approved.
                            </small>
                        </form>
                    @endif

                    <hr class="my-4">

                    <!-- Delete Account -->
                    <div class="alert alert-danger">
                        <h5 class="alert-heading">Delete Account</h5>
                        <p>Once you delete your account, there is no going back. Please be certain.</p>
                        <form method="POST" action="{{ route('profile.destroy') }}"
                              onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-danger">Delete Account</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
