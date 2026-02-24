<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Register</title>

    <!-- Custom fonts -->
    <link href="{{ asset('admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles -->
    <link href="{{ asset('admin/css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>

<body class="bg-gradient-primary">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-register-image"></div>

                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                                </div>

                                {{-- Session Status --}}
                                @if (session('status'))
                                    <div class="alert alert-success small">
                                        {{ session('status') }}
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('register.store') }}" class="user">
                                    @csrf

                                    {{-- Name --}}
                                    <div class="form-group">
                                        <input
                                            type="text"
                                            name="name"
                                            value="{{ old('name') }}"
                                            class="form-control form-control-user @error('name') is-invalid @enderror"
                                            placeholder="Full Name"
                                            required
                                            autofocus
                                        >

                                        @error('name')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    {{-- Username --}}
                                    <div class="form-group">
                                        <input
                                            type="text"
                                            name="username"
                                            value="{{ old('username') }}"
                                            class="form-control form-control-user
                                             @error('username') is-invalid @enderror"
                                            placeholder="Username"
                                            required
                                        >

                                        @error('username')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    {{-- Email --}}
                                    <div class="form-group">
                                        <input
                                            type="email"
                                            name="email"
                                            value="{{ old('email') }}"
                                            class="form-control form-control-user @error('email') is-invalid @enderror"
                                            placeholder="Email Address"
                                            required
                                        >

                                        @error('email')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    {{-- Role Selection --}}
                                    <div class="form-group">
                                        <select
                                            name="role"
                                            class="form-control @error('role') is-invalid @enderror"
                                            required
                                        >
                                            <option value="" disabled selected>Select Role</option>
                                            <option value="contractor" {{ old('role') == 'contractor' ? 'selected' : '' }}>Contractor</option>
                                            <option value="contributor" {{ old('role') == 'contributor' ? 'selected' : '' }}>Contributor</option>
                                            <option value="candidate" {{ old('role') == 'candidate' ? 'selected' : '' }}>Candidate</option>
                                        </select>

                                        @error('role')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    {{-- Password --}}
                                    <div class="form-group">
                                        <input
                                            type="password"
                                            name="password"
                                            class="form-control form-control-user @error('password') is-invalid @enderror"
                                            placeholder="Password"
                                            required
                                        >

                                        @error('password')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    {{-- Confirm Password --}}
                                    <div class="form-group">
                                        <input
                                            type="password"
                                            name="password_confirmation"
                                            class="form-control form-control-user"
                                            placeholder="Confirm Password"
                                            required
                                        >
                                    </div>

                                    {{-- Terms and Conditions --}}
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox small">
                                            <input
                                                type="checkbox"
                                                name="terms"
                                                class="custom-control-input @error('terms') is-invalid @enderror"
                                                id="terms"
                                                {{ old('terms') ? 'checked' : '' }}
                                                required
                                            >
                                            <label class="custom-control-label" for="terms">
                                                I agree to the <a href="#" target="_blank">Terms & Conditions</a>
                                            </label>

                                            @error('terms')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Submit --}}
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Register Account
                                    </button>

                                    <hr>
                                </form>

                                <div class="text-center">
                                    <a class="small" href="{{ route('password.request') }}">
                                        Forgot Password?
                                    </a>
                                </div>

                                <div class="text-center">
                                    <a class="small" href="{{ route('login') }}">
                                        Already have an account? Login!
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript -->
<script src="{{ asset('admin/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Core plugin JavaScript -->
<script src="{{ asset('admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

<!-- Custom scripts -->
<script src="{{ asset('admin/js/sb-admin-2.min.js') }}"></script>

</body>
</html>
