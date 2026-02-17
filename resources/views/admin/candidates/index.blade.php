@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Candidates</h1>
            <p class="text-muted mb-0">Manage all registered candidates</p>
        </div>

        <a href="{{ route('candidates.create') }}" class="btn btn-primary">
            <i class="fas fa-user-plus mr-1"></i>
            Add Candidate
        </a>
    </div>

    {{-- Search --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET">
                <div class="input-group">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        class="form-control"
                        placeholder="Search by name, email or phone">

                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="card shadow-sm border-0">

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover mb-0">

                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Candidate</th>
                            <th>District</th>
                            <th>Gender</th>
                            <th>Phone</th>
                            <th>Wallet</th>
                            <th>Created</th>
                            <th width="160">Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($candidates as $candidate)

                            <tr>

                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    <div class="d-flex align-items-center">

                                        <img
                                            src="{{ $candidate->photo
                                                ? asset('storage/'.$candidate->photo)
                                                : asset('images/avatar.png') }}"
                                            width="40"
                                            height="40"
                                            class="rounded-circle mr-2"
                                        >

                                        <div>
                                            <strong>{{ $candidate->name }}</strong><br>
                                            <small class="text-muted">
                                                {{ $candidate->email }}
                                            </small>
                                        </div>

                                    </div>
                                </td>

                                <td>{{ $candidate->district ?? '-' }}</td>

                                <td>{{ ucfirst($candidate->gender) ?? '-' }}</td>

                                <td>{{ $candidate->phone ?? '-' }}</td>

                                <td>
                                    ₦{{ number_format(optional($candidate->wallet)->balance ?? 0) }}
                                </td>

                                <td>
                                    {{ $candidate->created_at->format('d M Y') }}
                                </td>

                                <td>

                                    <a
                                        href="{{ route('candidates.show', $candidate->id) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        View
                                    </a>
                                    <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#fundWalletModal">
                                        <i class="fas fa-coins mr-1"></i> Fund Wallet
                                    </button>

                                    <a
                                        href="{{ route('candidates.edit', $candidate->id) }}"
                                        class="btn btn-sm btn-outline-secondary">
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('candidates.destroy', $candidate->id) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Delete candidate?')">

                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-sm btn-outline-danger">
                                            Delete
                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">
                                    No candidates found
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $candidates->links() }}
    </div>

</div>
<div class="modal fade" id="fundWalletModal">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('admin.candidates.fund', $candidate) }}">
            @csrf

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Fund Candidate Wallet</h5>
                    <small>This is assuming that the user has sent money to our bank account. Note that without funding a user, a user cannot have projects started for them. When the project is marked as ended, The full amount is removed from the user account and moved into admin wallet.</small>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Amount (₦)</label>
                        <input type="number" name="amount" class="form-control" min="1" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">Fund Wallet</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
