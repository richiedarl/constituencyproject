<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>@yield('title', 'Constituency Projects | Public project information')</title>
  <meta name="description" content="Explore documented constituency development projects, their progress, evidence, and public updates across Nigeria.">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="{{ asset('fe/assets/img/logo_current.webp') }}" rel="icon">
  <link href="{{ asset('fe/assets/img/logo_current.webp') }}" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('fe/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('fe/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
  <link href="{{ asset('fe/assets/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('fe/assets/vendor/swiper/swiper-bundle.min.css') }}  " rel="stylesheet">

  <!-- Main CSS File -->
  <link href="{{ asset('fe/assets/css/main.css') }}" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- =======================================================
Constituency project
  ======================================================== -->
</head>

<body class="starter-page-page">

 <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="/" class="logo d-flex align-items-center">
        <!-- Uncomment the line below if you also wish to use an image logo -->
         <img src="{{ asset('fe/assets/img/logo.png') }}" alt="site logo">
      </a>

     <nav id="navmenu" class="navmenu">
  <ul>
    <li><a href="/" class="active">Home</a></li>
    {{-- <li><a href="/#about">About</a></li> --}}
    <!-- Dropdown Menu -->
          <li class="dropdown">
            <a href="#">
              <span>Explore</span>
              <i class="bi bi-chevron-down toggle-dropdown"></i>
            </a>
            <ul class="dropdown-menu">
              <li><a href="{{ route('about') }}">About Us</a></li>
              <li><a href="{{ route('services') }}">Services</a></li>
              <li><a href="{{ route('documentation') }}">Documentation</a></li>
            </ul>
          </li>
    <li><a href="/#personalities">Public figures</a></li>
    <li><a href="{{ route('projects.index') }}">Projects</a></li>
    @auth
      <li><a href="{{ route('notifications.index') }}">Notifications @if(auth()->user()->unreadNotifications()->count())<span class="badge bg-danger">{{ auth()->user()->unreadNotifications()->count() }}</span>@endif</a></li>
      <li><a href="{{ route('dashboard') }}">My Account</a></li>
    @else
      <li><a href="{{ route('login') }}">My Account</a></li>
    @endauth

    <!-- Dropdown Menu -->
    <li class="dropdown">
      <a href="#">
        <span>Opportunities</span>
        <i class="bi bi-chevron-down toggle-dropdown"></i>
      </a>

      <ul class="dropdown-menu">
        <li><a href="{{ route('contractor.register') }}">Become A Contractor</a></li>
        <li><a href="{{ route('contributor.apply') }}">Become A Contributor</a></li>
        {{-- <li><a href="/contributors-leaderboard">Contributor's Leaderboard</a></li> --}}
        <li><a href="{{ route('candidate.register') }}">Apply As A Candidate</a></li>
      </ul>
    </li>

    <li><a href="/contact">Contact</a></li>
  </ul>

  <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
</nav>


    </div>
  </header>


  <main class="main">
@if ($errors->any())
    <div class="alert alert-danger">
        <strong>There were errors with your submission:</strong>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('info'))
    <div class="alert alert-info">
        {{ session('info') }}
    </div>
@endif
    <!-- Page Title -->
@yield('content')

  </main>

@stack('scripts')

@if (session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success',
        text: @json(session('success')),
        timer: 2500,
        showConfirmButton: false
    });
</script>
@endif

@if (session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: @json(session('error')),
    });
</script>
@endif

    <footer id="footer" class="footer accent-background">

  <div class="container footer-top">
    <div class="row gy-4">
      <div class="col-lg-5 col-md-12 footer-about">
        <a href="/" class="logo d-flex align-items-center">
          <span class="sitename">Constituency Projects</span>
        </a>
        <p>
          Constituency Projects is a public information platform for discovering, documenting, and tracking constituency development projects.
        </p>
        <div class="social-links d-flex mt-4">
          <a href="#"><i class="bi bi-twitter-x"></i></a>
          <a href="#"><i class="bi bi-facebook"></i></a>
          <a href="#"><i class="bi bi-instagram"></i></a>
          <a href="#"><i class="bi bi-linkedin"></i></a>
        </div>
      </div>

      <div class="col-lg-2 col-6 footer-links">
        <h4>Useful Links</h4>
        <ul>
          <li><a href="{{ route('landing') }}">Home</a></li>
          <li><a href="{{ route('about') }}">About Us</a></li>
          <li><a href="{{ route('services') }}">Services</a></li>
          <li><a href="{{ route('documentation') }}">Documentation</a></li>
          <li><a href="#">Privacy Policy</a></li>
        </ul>
      </div>

      <div class="col-lg-2 col-6 footer-links">
        <h4>Our Services</h4>
        <ul>
          <li><a href="{{ route('projects.index') }}">Find projects</a></li>
          <li><a href="{{ route('documentation') }}">How information is documented</a></li>
          <li><a href="{{ route('services') }}">Platform services</a></li>
        </ul>
      </div>

      <div class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
        <h4>Contact Us</h4>
        <p>Constituency Projects</p>
        <p>Abuja, Nigeria</p>
      </div>

    </div>
  </div>

  <div class="container copyright text-center mt-4">
    <p>
      © <span>Copyright</span>
      <strong class="px-1 sitename">Constituency Projects</strong>
      <span>All Rights Reserved</span>
    </p>

  </div>

</footer>


  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="{{ asset('fe/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{ asset('fe/assets/vendor/php-email-form/validate.js')}}"></script>
  <script src="{{ asset('fe/assets/vendor/aos/aos.js')}}"></script>
  <script src="{{ asset('fe/assets/vendor/purecounter/purecounter_vanilla.js')}}"></script>
  <script src="{{ asset('fe/assets/vendor/swiper/swiper-bundle.min.js')}}"></script>

  <!-- Main JS File -->
  <script src="{{ asset('fe/assets/js/main.js')}}"></script>

</body>

</html>
