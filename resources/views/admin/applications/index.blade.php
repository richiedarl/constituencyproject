@extends('layouts.admin')

@section('title', 'Applications Management')

@section('content')
<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="fas fa-clipboard-check text-primary me-2"></i>
                Application Management
            </h2>
            <p class="text-muted mb-0">
                Review and manage submitted applications
            </p>
        </div>

        <div class="d-flex gap-4 mt-3 mt-md-0">
            <div class="text-center">
                <small class="text-muted d-block">Total</small>
                <span class="fw-bold fs-5">{{ $stats['total'] }}</span>
            </div>
            <div class="text-center">
                <small class="text-muted d-block">Pending</small>
                <span class="fw-bold fs-5 text-warning">{{ $stats['pending'] }}</span>
            </div>
            <div class="text-center">
                <small class="text-muted d-block">Approved</small>
                <span class="fw-bold fs-5 text-success">{{ $stats['approved'] }}</span>
            </div>
        </div>
    </div>

    {{-- Applications --}}
    <div class="row g-4">

        @forelse($applications as $application)
            <div class="col-md-6 col-xl-4">
                <div class="card border-0 shadow-sm h-100 application-card">

                    <div class="card-body d-flex flex-column">

                        {{-- Project --}}
                        <div class="mb-3">
                            <h5 class="fw-semibold mb-1">
                                {{ $application->project->title ?? 'No Project Attached' }}
                            </h5>

                            <span class="badge rounded-pill bg-{{
                                $application->type === 'candidate' ? 'primary' :
                                ($application->type === 'contractor' ? 'success' :
                                ($application->type === 'contributor' ? 'info' : 'secondary'))
                            }}">
                                {{ ucfirst($application->type) }}
                            </span>
                        </div>

                        {{-- Applicant --}}
                        <div class="mb-3">
                            <small class="text-muted d-block">Applicant</small>
                            <span class="fw-semibold">
                                {{ $application->candidate?->user?->name
                                    ?? $application->contractor?->user?->name
                                    ?? $application->contributor?->user?->name
                                    ?? 'N/A' }}
                            </span>
                            <div class="small text-muted">
                                Applied {{ $application->created_at->format('M d, Y') }}
                            </div>
                        </div>

                        {{-- Payment --}}
                        <div class="mb-3">
                            <small class="text-muted d-block">Payment</small>
                            @if($application->paid)
                                <span class="badge bg-success">
                                    <i class="fas fa-check-circle me-1"></i> Paid
                                </span>
                                <div class="small text-muted">
                                    {{ optional($application->paid_at)->format('M d, Y') }}
                                </div>
                            @else
                                <span class="badge bg-danger">
                                    <i class="fas fa-times-circle me-1"></i> Not Paid
                                </span>
                            @endif
                        </div>

                        {{-- Budget --}}
                        <div class="mb-3">
                            <small class="text-muted d-block">Estimated Budget</small>
                            <span class="fw-semibold">
                                ₦{{ number_format($application->project->estimated_budget ?? 0) }}
                            </span>
                        </div>

                        {{-- Status --}}
                        <div class="mb-4">
                            <small class="text-muted d-block">Status</small>
                            <span class="badge rounded-pill bg-{{
                                $application->status === 'approved' ? 'success' :
                                ($application->status === 'pending' ? 'warning' :
                                ($application->status === 'rejected' ? 'danger' : 'secondary'))
                            }}">
                                {{ ucfirst($application->status) }}
                            </span>
                        </div>

                        {{-- Actions --}}
                        <div class="mt-auto d-flex gap-2">

                            <a href="{{ route('submissions.show', $application) }}"
                               class="btn btn-outline-primary btn-sm flex-fill">
                                <i class="fas fa-eye me-1"></i> View
                            </a>

                            @if($application->status === 'pending')

                                {{-- APPROVE (POST) --}}
                                <form method="POST"
                                      action="{{ route('submissions.approve', $application) }}"
                                      class="flex-fill">
                                    {{ csrf_field() }}
                                    <button type="submit"
                                            class="btn btn-success btn-sm w-100">
                                        <i class="fas fa-check me-1"></i> Approve
                                    </button>
                                </form>

                                {{-- REJECT --}}
                                <form method="POST"
                                      action="{{ route('submissions.reject', $application) }}"
                                      class="flex-fill reject-form">
                                    @csrf
                                    <button type="submit"
                                            class="btn btn-outline-danger btn-sm w-100">
                                        <i class="fas fa-times me-1"></i> Reject
                                    </button>
                                </form>

                            @endif

                        </div>

                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No applications found</h5>
            </div>
        @endforelse

    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $applications->links() }}
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.reject-form').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            Swal.fire({
                title: 'Reject Application?',
                text: 'This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, reject it',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

});
</script>
@endpush
