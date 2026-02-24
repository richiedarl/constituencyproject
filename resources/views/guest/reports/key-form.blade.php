@extends('layouts.app')

@section('title', 'Enter License Key')

@section('content')
<!-- Page Header -->
<section class="page-header py-5" style="background: linear-gradient(135deg, #29a221 0%, #ffc107 100%);">
    <div class="container text-center text-white">
        <h1 class="display-4 fw-bold">Enter License Key</h1>
        <p class="lead">For {{ $candidate->name }}</p>
    </div>
</section>

<!-- Key Form -->
<section class="key-form py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-0 shadow-lg rounded-4 p-5">
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('candidate.report.validate', $candidate->slug) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label fw-bold">License Key</label>
                            <input type="text" name="license_key" class="form-control form-control-lg" placeholder="Enter your 16-digit key" required>
                            <small class="text-muted">Format: XXXX-XXXX-XXXX-XXXX</small>
                        </div>
                        <button type="submit" class="btn btn-lg w-100 py-3" style="background: linear-gradient(135deg, #29a221 0%, #ffc107 100%); color: white;">
                            <i class="bi bi-unlock me-2"></i> Unlock Report
                        </button>
                    </form>

                    <hr class="my-4">

                    <p class="text-center mb-0">
                        Don't have a key?
                        <a href="{{ route('candidate.report.request.form', $candidate->slug) }}" style="color: #29a221;">
                            Request one here
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
