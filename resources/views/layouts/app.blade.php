<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Constituency project</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="{{ asset('logo.png') }}" rel="icon">
  <link href="{{ asset('logo.png') }}" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('fe/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('fe/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
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
        {{-- <svg class="my-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <g id="bgCarrier" stroke-width="0"></g>
          <g id="tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
          <g id="iconCarrier">
            <path d="M22 22L2 22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
            <path d="M2 11L6.06296 7.74968M22 11L13.8741 4.49931C12.7784 3.62279 11.2216 3.62279 10.1259 4.49931L9.34398 5.12486" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
            <path d="M15.5 5.5V3.5C15.5 3.22386 15.7239 3 16 3H18.5C18.7761 3 19 3.22386 19 3.5V8.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
            <path d="M4 22V9.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
            <path d="M20 9.5V13.5M20 22V17.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
            <path d="M15 22V17C15 15.5858 15 14.8787 14.5607 14.4393C14.1213 14 13.4142 14 12 14C10.5858 14 9.87868 14 9.43934 14.4393M9 22V17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
            <path d="M14 9.5C14 10.6046 13.1046 11.5 12 11.5C10.8954 11.5 10 10.6046 10 9.5C10 8.39543 10.8954 7.5 12 7.5C13.1046 7.5 14 8.39543 14 9.5Z" stroke="currentColor" stroke-width="1.5"></path>
          </g>
        </svg> --}}
        {{-- <h1 class="sitename">onstituencyproject</h1> --}}
      </a>

     <nav id="navmenu" class="navmenu">
  <ul>
    <li><a href="#hero" class="active">Home</a></li>
    <li><a href="#about">About</a></li>
    <li><a href="#personalities">Personalities</a></li>
    <li><a href="#portfolio">Portfolios</a></li>
    <li><a href="#team">Team</a></li>

    <!-- Dropdown Menu -->
    <li class="dropdown">
      <a href="#">
        <span>Opportunities</span>
        <i class="bi bi-chevron-down toggle-dropdown"></i>
      </a>

      <ul class="dropdown-menu">
        <li><a href="{{ route('contractor.register') }}">Become A Contractor</a></li>
        <li><a href="{{ route('contributor.register') }}">Become A Contributor</a></li>
        <li><a href="/contributors-leaderboard">Contributor's Leaderboard</a></li>
        <li><a href="{{ route('candidate.register') }}">Apply As A Candidate</a></li>
      </ul>
    </li>

    <li><a href="#contact">Contact</a></li>
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
          <span class="sitename">Constituency project Solutions</span>
        </a>
        <p>
          Constituency project Solutions is committed to providing compassionate, reliable, and professional healthcare staffing and support services tailored to individuals, families, and healthcare providers.
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
          <li><a href="#">Home</a></li>
          <li><a href="#">About Us</a></li>
          <li><a href="#">Services</a></li>
          <li><a href="#">Careers</a></li>
          <li><a href="#">Privacy Policy</a></li>
        </ul>
      </div>

      <div class="col-lg-2 col-6 footer-links">
        <h4>Our Services</h4>
        <ul>
          <li><a href="#">Healthcare Staffing</a></li>
          <li><a href="#">Home Care Support</a></li>
          <li><a href="#">Hospital Assistance</a></li>
          <li><a href="#">Caregiver Placement</a></li>
          <li><a href="#">24/7 Care Services</a></li>
        </ul>
      </div>

      <div class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
        <h4>Contact Us</h4>
        <p>Constituency project Solutions</p>
        <p>Abuja, Nigeria</p>
        <p class="mt-4">
          <strong>Phone:</strong> <span>03301331162</span>
        </p>
        <p>
          <strong>Email:</strong> <span>info@onstituencyprojectsolutions.com</span>
        </p>
      </div>

    </div>
  </div>

  <div class="container copyright text-center mt-4">
    <p>
      © <span>Copyright</span>
      <strong class="px-1 sitename">Constituency project Solutions</strong>
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
