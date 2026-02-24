@extends('layouts.app')

@section('title', 'Request License Key')

@section('content')
<!-- Page Header -->
<section class="page-header py-5" style="background: linear-gradient(135deg, #29a221 0%, #ffc107 100%);">
    <div class="container text-center text-white">
        <h1 class="display-4 fw-bold">Request License Key</h1>
        <p class="lead">For {{ $candidate->name }}</p>
    </div>
</section>

<!-- Request Form -->
<section class="request-form py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-lg rounded-4 p-5">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('candidate.report.request', $candidate->slug) }}" method="POST">
                        @csrf
                        <input type="hidden" name="candidate_id" value="{{ $candidate->id }}">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Full Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Email Address</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Phone Number</label>
                                <input type="text" name="phone" class="form-control" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Reason for Request</label>
                                <textarea name="message" rows="4" class="form-control" required placeholder="Please explain why you need access to this report..."></textarea>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-lg w-100 py-3" style="background: #29a221; color: white;">
                                    <i class="bi bi-send me-2"></i> Submit Request
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
