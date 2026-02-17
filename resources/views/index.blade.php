<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Index - Constituency Project</title>
  <meta name="description" content="">
  <meta name="color-scheme" content="light only">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="{{ asset('fe/assets/img/logo_current.webp')}}" rel="icon">
  <link href="{{ asset('fe/assets/img/logo_current.webp')}}" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('fe/assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{ asset('fe/assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{ asset('fe/assets/vendor/aos/aos.css')}}" rel="stylesheet">
  <link href="{{ asset('fe/assets/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
  <link href="{{ asset('fe/assets/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="{{ asset('fe/assets/css/main.css')}}" rel="stylesheet">


</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="/" class="logo d-flex align-items-center">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <img src="{{ asset('fe/assets/img/logo_current.webp')}}" alt="">
        {{-- <h1 class="sitename">constituencyproject</h1> --}}
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
        <li><a href="{{ route('user.candidates.create') }}">Apply As A Candidate</a></li>
      </ul>
    </li>

    <li><a href="#contact">Contact</a></li>
  </ul>

  <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
</nav>


    </div>
  </header>

  <main class="main">

<section id="hero" class="hero section light-background">

  <div class="container" data-aos="fade-up" data-aos-delay="100">

    <div class="row align-items-center">
      <div class="col-lg-6">
        <div class="hero-content">
          <h1 data-aos="fade-up" data-aos-delay="200">
            The Inevitable Question Every Leader Must Answer
          </h1>

          <p data-aos="fade-up" data-aos-delay="300">
            What did you do when you were there? Constituency Project  transforms promises into
            verifiable projects, measurable impact, and a legacy that speaks for itself.
          </p>

          <div class="hero-cta" data-aos="fade-up" data-aos-delay="400">
            <a href="#portfolio" class="btn-primary">Show Your Legacy</a>
            <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8" class="btn-secondary glightbox">
              <i class="bi bi-play-circle"></i>
              Watch Impact
            </a>
          </div>

          <div class="hero-stats" data-aos="fade-up" data-aos-delay="500">
            <div class="stat-item">
              <div class="stat-number">300+</div>
              <div class="stat-label">Projects Delivered</div>
            </div>
            <div class="stat-item">
              <div class="stat-number">1M+</div>
              <div class="stat-label">Lives Impacted</div>
            </div>
            <div class="stat-item">
              <div class="stat-number">15+</div>
              <div class="stat-label">States Covered</div>
            </div>
          </div>
        </div>
      </div>

      <!-- HERO IMAGE -->
      <div class="col-lg-6">
        <div class="hero-image"
             data-aos="fade-left"
             data-aos-delay="300"
             data-aos-duration="900">

          <img src="{{ asset('fe/assets/img/about/community-led.jpg') }}"
               alt="Community Project Execution"
               class="img-fluid hero-img-hover">

          <div class="floating-card"
               data-aos="zoom-in"
               data-aos-delay="600">
            <div class="card-icon">
              <i class="bi bi-check-circle-fill"></i>
            </div>
            <div class="card-content">
              <h5>Verified Impact</h5>
              <div class="growth-percentage">100%</div>
            </div>
          </div>

        </div>
      </div>
    </div>

  </div>
</section>
<style>
  .hero-img-hover {
  transition: transform 0.6s ease, box-shadow 0.6s ease;
}

.hero-img-hover:hover {
  transform: scale(1.03) translateY(-5px);
  box-shadow: 0 20px 40px rgba(0,0,0,0.15);
}

</style>
<section id="about" class="about section">

  <div class="container section-title" data-aos="fade-up">
    <span class="subtitle">Who We Are</span>
    <h2>About Constituency Project </h2>
    <p>
      We are a public-impact and governance support company dedicated to turning constituency
      projects into visible, verifiable, and lasting legacy.
    </p>
  </div>

  <div class="container" data-aos="fade-up" data-aos-delay="100">

    <div class="row align-items-center">
      <div class="col-lg-6" data-aos="fade-right" data-aos-delay="200">
        <div class="content">
          <h2>From Promises to Proven Impact</h2>

          <p class="lead">
            We plan, execute, document, and amplify structural and capacity-building projects
            across Nigeria with transparency and accountability.
          </p>

          <p>
            Our work bridges the gap between delivery and perception—ensuring that every school,
            borehole, training programme, or intervention becomes documented evidence of service.
          </p>

          <p>
            Through technology-driven monitoring, media amplification, and ethical governance,
            we help leaders build trust and leave behind a legacy that endures.
          </p>

          {{-- <div class="stats-row">
            <div class="stat-item">
              <div class="stat-number purecounter"
                   data-purecounter-start="0"
                   data-purecounter-end="10"
                   data-purecounter-duration="1"></div>
              <div class="stat-label">Years Experience</div>
            </div>

            <div class="stat-item">
              <div class="stat-number purecounter"
                   data-purecounter-start="0"
                   data-purecounter-end="300"
                   data-purecounter-duration="1"></div>
              <div class="stat-label">Projects Executed</div>
            </div>

            <div class="stat-item">
              <div class="stat-number purecounter"
                   data-purecounter-start="0"
                   data-purecounter-end="1000000"
                   data-purecounter-duration="2"></div>
              <div class="stat-label">Beneficiaries</div>
            </div>
          </div> --}}

          <div class="cta-section">
            <a href="#team" class="btn-outline">Request Documentation</a>
          </div>
        </div>
      </div>

      <!-- ABOUT IMAGE -->
      <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
        <div class="image-wrapper">
          <img src="{{ asset('fe/assets/img/about/borehole.jpg') }}"
               alt="Project Documentation"
               class="img-fluid about-img-hover">

          <div class="floating-card"
               data-aos="zoom-in"
               data-aos-delay="500">
            <div class="card-content">
              <div class="icon">
                <i class="bi bi-shield-check"></i>
              </div>
              <div class="text">
                <h4>Transparency & Trust</h4>
                <p>Every project documented. Every impact verified.</p>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

  </div>
</section>

@if(isset($projects) && $projects->count() > 0)
<section id="top-projects" class="top-projects section bg-light">

  <div class="container section-title" data-aos="fade-up">
    <span class="subtitle">Featured Opportunities</span>
    <h2>Top Active Projects</h2>
    <p>
      Explore verified public projects. Support them financially as a donor
      or apply as a contractor to execute and deliver impact.
    </p>
  </div>

  <div class="container">
    <div class="row gy-4">

      @foreach($projects as $project)

        <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="100">
          <div class="card shadow-sm border-0 h-100 project-card">

            <!-- Project Image -->
            <img src="{{ asset('storage/'.$project->featured_image) }}"
                 class="card-img-top"
                 style="height:220px; object-fit:cover;">

            <div class="card-body d-flex flex-column">

              <!-- Title -->
              <h5 class="card-title mb-2">
                {{ $project->title }}
              </h5>

              <!-- Location -->
              <small class="text-muted mb-2">
                {{ $project->full_location }}
              </small>

              <!-- Progress -->
              <div class="progress mb-3" style="height:6px;">
                <div class="progress-bar {{ $project->progress_bar_class }}"
                     style="width: {{ $project->progress_percentage }}%">
                </div>
              </div>

              <!-- ACTION BUTTONS -->
              <div class="mt-auto d-flex justify-content-between flex-wrap gap-2">

                <!-- View Project Info -->
                <a href="{{ route('projects.show', $project->slug) }}"
                   class="btn btn-sm btn-outline-primary animated-btn"
                   data-bs-toggle="tooltip"
                   data-bs-placement="top"
                   title="View Project Info">
                  <i class="bi bi-eye"></i>
                </a>

                <!-- View Candidate Info -->
                <a href="{{ route('candidate.show', $project->candidate->slug) }}"
                   class="btn btn-sm btn-outline-dark animated-btn"
                   data-bs-toggle="tooltip"
                   data-bs-placement="top"
                   title="View Candidate Info">
                  <i class="bi bi-person"></i>
                </a>

                @if($project->is_active)

                  <!-- Contribute To Project -->
                  <a href="{{ route('contributor.project.apply', $project->id) }}"
                     class="btn btn-sm btn-success animated-btn"
                     data-bs-toggle="tooltip"
                     data-bs-placement="top"
                     title="Contribute To Project">
                    <i class="bi bi-cash-coin"></i>
                  </a>

                  <!-- Become A Contractor -->
                  <a href="{{ route('contractor.projects.form', $project->id) }}"
                     class="btn btn-sm btn-warning animated-btn"
                     data-bs-toggle="tooltip"
                     data-bs-placement="top"
                     title="Become A Contractor">
                    <i class="bi bi-tools"></i>
                  </a>

                @endif

              </div>

            </div>
          </div>
        </div>

      @endforeach

    </div>
  </div>

</section>

@endif

<section id="leaderboard" class="leaderboard section">

  <div class="container section-title" data-aos="fade-up">
    <span class="subtitle">Recognition</span>
    <h2>Top Contributors</h2>
    <p>
      Individuals and organizations leading the movement through verified
      financial support and community backing.
    </p>
  </div>

  <div class="container">
    <div class="row gy-4">

      @foreach($topContributors as $contributor)

        <div class="col-lg-4 col-md-6" data-aos="fade-up">

          <div class="card text-center shadow-sm border-0 p-4">

            <img src="{{ $contributor->photo
                ? asset('storage/'.$contributor->photo)
                : asset('images/avatar.png') }}"
                 class="rounded-circle mx-auto mb-3"
                 width="80" height="80">

            <h5 class="mb-1">{{ $contributor->name }}</h5>

            <small class="text-muted mb-2 d-block">
              Total Donated
            </small>

            <h4 class="text-success">
              ₦{{ number_format($contributor->donations_sum_amount ?? 0) }}
            </h4>

          </div>

        </div>

      @endforeach

    </div>
  </div>

</section>

<section id="platform-vision" class="services section">

  <div class="container section-title" data-aos="fade-up">
    <span class="subtitle">Our Platform</span>
    <h2>Transparency. Participation. Accountability.</h2>
    <p>
      Constituency Project connects public project owners, verified contractors,
      and community donors within one transparent digital ecosystem.
    </p>
  </div>

  <div class="container">
    <div class="row gy-5">

      <div class="col-lg-4 col-md-6">
        <div class="service-item">
          <div class="service-icon">
            <i class="bi bi-search"></i>
          </div>
          <h3>Verified Public Projects</h3>
          <p>
            Explore active and completed projects with documented phases,
            media evidence, budgets, and timelines.
          </p>
        </div>
      </div>

      <div class="col-lg-4 col-md-6">
        <div class="service-item">
          <div class="service-icon">
            <i class="bi bi-cash-stack"></i>
          </div>
          <h3>Community Funding</h3>
          <p>
            Become a contributor and financially support projects you believe in.
            Every donation is tracked and transparent.
          </p>
        </div>
      </div>

      <div class="col-lg-4 col-md-6">
        <div class="service-item">
          <div class="service-icon">
            <i class="bi bi-hammer"></i>
          </div>
          <h3>Contract Opportunities</h3>
          <p>
            Skilled contractors can apply to execute verified projects.
            All applications are reviewed and approved by project owners.
          </p>
        </div>
      </div>

      <div class="col-lg-4 col-md-6">
        <div class="service-item">
          <div class="service-icon">
            <i class="bi bi-bar-chart-line"></i>
          </div>
          <h3>Real-Time Progress Tracking</h3>
          <p>
            Track phase-by-phase execution, completion percentages,
            and project health indicators.
          </p>
        </div>
      </div>

      <div class="col-lg-4 col-md-6">
        <div class="service-item">
          <div class="service-icon">
            <i class="bi bi-award"></i>
          </div>
          <h3>Recognition & Leaderboards</h3>
          <p>
            Top contributors are publicly recognized for their support
            and impact across communities.
          </p>
        </div>
      </div>

    </div>
  </div>

</section>



<div class="container section-title" data-aos="fade-up">
  <span class="subtitle">Why We Exist</span>
  <h2>Because Public Work Should Be Publicly Proven</h2>
  <p>
    Constituency Project  is built to make public service measurable,
    discoverable, and permanently accountable — without spin or sentiment.
  </p>
</div>
<div class="container">

  <div class="row align-items-center g-5">

    <!-- CENTER ANCHOR -->
    <div class="col-lg-5" data-aos="fade-right">
      <div class="why-anchor">

        <img src="{{ asset('fe/assets/img/about/local_meet.jpeg') }}"
             alt="Documented public engagement"
             class="img-fluid">

        <div class="anchor-badge">
          <i class="bi bi-shield-check"></i>
          <span>Neutral Documentation Platform</span>
        </div>

      </div>
    </div>

    <!-- PRINCIPLES -->
    <div class="col-lg-7">

      <div class="principle" data-aos="fade-up">
        <i class="bi bi-eye-fill"></i>
        <div>
          <h3>Visibility by Default</h3>
          <p>
            Every documented project is open to citizens, media, partners,
            and institutions — not hidden behind narratives or gatekeepers.
          </p>
        </div>
      </div>

      <div class="principle" data-aos="fade-up" data-aos-delay="100">
        <i class="bi bi-shield-check"></i>
        <div>
          <h3>Evidence Over Claims</h3>
          <p>
            We publish timelines, visuals, and outcomes so impact can be
            assessed — not assumed.
          </p>
        </div>
      </div>

      <div class="principle" data-aos="fade-up" data-aos-delay="200">
        <i class="bi bi-search"></i>
        <div>
          <h3>Accessible by Design</h3>
          <p>
            Anyone can search, review, and compare public portfolios without
            registration, permissions, or bias.
          </p>
        </div>
      </div>

      <div class="principle" data-aos="fade-up" data-aos-delay="300">
        <i class="bi bi-archive-fill"></i>
        <div>
          <h3>Legacy That Outlives Office</h3>
          <p>
            Public work should not disappear with tenure. We preserve it as
            a permanent civic record.
          </p>
        </div>
      </div>

    </div>

  </div>

</div>


<!-- Personalities Section -->
<section id="personalities" class="portfolio section">

  <!-- Section Title -->
  <div class="container section-title" data-aos="fade-up">
    <span class="subtitle">Personalities</span>
    <h2>Featured Personalities</h2>
    <p>
      Explore verified portfolios of influential personalities whose public work, initiatives, leadership,
      and contributions are documented and preserved for reference.
    </p>
  </div><!-- End Section Title -->

  <div class="container" data-aos="fade-up" data-aos-delay="100">

    <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">
      <ul class="portfolio-filters isotope-filters" data-aos="fade-up" data-aos-delay="200">
        <li data-filter="*" class="filter-active">All</li>
        <li data-filter=".filter-politics">Politics</li>
        <li data-filter=".filter-governance">Governance</li>
        <li data-filter=".filter-advocacy">Advocacy</li>
        <li data-filter=".filter-activism">Activism</li>
      </ul><!-- End Filters -->

      <div class="row gy-5 isotope-container" data-aos="fade-up" data-aos-delay="300">

        <!-- Personality Item -->
        <div class="col-lg-12 portfolio-item isotope-item filter-politics">
          <article class="portfolio-card">
            <div class="row g-4">
              <div class="col-md-6">
                <div class="project-visual">
                  <img src="{{asset('fe/assets/img/person/fela_durotoye.png')}}" alt="Fela Durotoye" class="img-fluid" loading="lazy">
                  <div class="project-overlay">
                    <div class="overlay-content">
                      <a href="{{asset('fe/assets/img/person/fela_durotoye.png')}}" class="view-project glightbox" aria-label="View image">
                        <i class="bi bi-eye"></i>
                      </a>
                      <a href="/fela-durotoye" class="project-link" aria-label="View portfolio">
                        <i class="bi bi-arrow-up-right"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="project-details">
                  <div class="project-header">
                    <span class="project-category">Politics & Leadership</span>
                    <time class="project-year">2019 – Present</time>
                  </div>
                  <h3 class="project-title">Fela Durotoye</h3>
                  <p class="project-description">
                    Leadership advocate, former presidential candidate, and founder of civic and youth-focused
                    leadership initiatives.
                  </p>
                  <div class="project-meta">
                    <span class="client-name">Leadership Strategist</span>
                    <div class="project-scope">
                      <span class="scope-item">Public Policy</span>
                      <span class="scope-item">Youth Leadership</span>
                      <span class="scope-item">Governance Reform</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </article>
        </div>
        <!-- End Personality Item -->

        <!-- Duplicate this block per personality and adjust:
             - filter class
             - image
             - name
             - slug link
        -->

      </div><!-- End Items Container -->

    </div>

    <div class="portfolio-conclusion" data-aos="fade-up" data-aos-delay="400">
      <div class="conclusion-content">
        <h4>Discover more public figures</h4>
        <p>
          Browse the full directory of personalities and explore detailed portfolios documenting their public impact.
        </p>
        <div class="conclusion-actions">
          <a href="/personalities" class="primary-action">
            View All Personalities
            <i class="bi bi-arrow-right"></i>
          </a>
        </div>
      </div>
    </div>

  </div>

</section>
<!-- /Personalities Section -->

    {{-- <!-- Team Section -->
    <section id="team" class="team section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <span class="subtitle">Team</span>
        <h2>Meet Our Team</h2>
        <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium totam rem aperiam</p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-5">

          <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
            <div class="team-member">
              <div class="member-img">
                <img src="assets/img/person/person-f-8.webp" class="img-fluid" alt="Sarah Johnson" loading="lazy">
              </div>
              <div class="member-info">
                <h4>Sarah Johnson</h4>
                <span>Chief Executive Officer</span>
                <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas vestibulum tortor quam.</p>
                <div class="social">
                  <a href="#"><i class="bi bi-twitter-x"></i></a>
                  <a href="#"><i class="bi bi-linkedin"></i></a>
                  <a href="#"><i class="bi bi-instagram"></i></a>
                </div>
              </div>
            </div>
          </div><!-- End Team Member -->

          <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="250">
            <div class="team-member">
              <div class="member-img">
                <img src="assets/img/person/person-m-12.webp" class="img-fluid" alt="Michael Chen" loading="lazy">
              </div>
              <div class="member-info">
                <h4>Michael Chen</h4>
                <span>Chief Technology Officer</span>
                <p>Mauris blandit aliquet elit eget tincidunt nibh pulvinar rutrum tellus ac blandit elit eget tincidunt mauris.</p>
                <div class="social">
                  <a href="#"><i class="bi bi-twitter-x"></i></a>
                  <a href="#"><i class="bi bi-linkedin"></i></a>
                  <a href="#"><i class="bi bi-github"></i></a>
                </div>
              </div>
            </div>
          </div><!-- End Team Member -->

          <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
            <div class="team-member">
              <div class="member-img">
                <img src="assets/img/person/person-f-3.webp" class="img-fluid" alt="Emily Rodriguez" loading="lazy">
              </div>
              <div class="member-info">
                <h4>Emily Rodriguez</h4>
                <span>Creative Director</span>
                <p>Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae donec velit neque auctor.</p>
                <div class="social">
                  <a href="#"><i class="bi bi-twitter-x"></i></a>
                  <a href="#"><i class="bi bi-linkedin"></i></a>
                  <a href="#"><i class="bi bi-dribbble"></i></a>
                </div>
              </div>
            </div>
          </div><!-- End Team Member -->

          <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="350">
            <div class="team-member">
              <div class="member-img">
                <img src="assets/img/person/person-m-7.webp" class="img-fluid" alt="David Thompson" loading="lazy">
              </div>
              <div class="member-info">
                <h4>David Thompson</h4>
                <span>Head of Operations</span>
                <p>Curabitur arcu erat accumsan id imperdiet et porttitor at sem nulla facilisi mauris sit amet massa vitae tortor.</p>
                <div class="social">
                  <a href="#"><i class="bi bi-twitter-x"></i></a>
                  <a href="#"><i class="bi bi-linkedin"></i></a>
                  <a href="#"><i class="bi bi-facebook"></i></a>
                </div>
              </div>
            </div>
          </div><!-- End Team Member -->

        </div>

      </div>

    </section><!-- /Team Section --> --}}

<section id="featured-portfolios" class="portfolios section" style="background-color: #f9f9f9;">

  <div class="container section-title" data-aos="fade-up">
    <span class="subtitle">Featured Portfolios</span>
    <h2>Public Impact, Documented</h2>
    <p>
      A curated selection of leaders whose constituency projects and public
      interventions have been independently documented, verified, and archived.
    </p>
  </div>

  <div class="container">
    <div class="row g-4">

      <!-- Portfolio Card -->
      <div class="col-lg-4 col-md-6">
        <a href="/personalities/fela-durotoye" class="portfolio-card" data-aos="fade-up">

          <div class="card-top">
            <span class="badge">Verified Portfolio</span>
            <div class="stars">
              <i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i>
            </div>
          </div>

          <h3>Fela Durotoye</h3>
          <p class="role">Public Leadership & Civic Reform</p>

          <p class="excerpt">
            Documented constituency engagements, leadership programmes,
            youth capacity development, and civic accountability initiatives.
          </p>

          <div class="card-footer">
            <span>View Full Portfolio</span>
            <i class="bi bi-arrow-right"></i>
          </div>

        </a>
      </div>

      <!-- Duplicate for other leaders -->
    </div>
  </div>
</section>

<section id="contact" class="contact section" style="background-color: #f9f9f9;">

  <div class="container section-title" data-aos="fade-up">
    <span class="subtitle">Contact</span>
    <h2>Let's Connect</h2>
    <p>We're ready to discuss your vision and show how public impact can be documented effectively.</p>
  </div>

  <div class="container">
    <div class="row gy-4">

      <div class="col-lg-5">
        <div class="info-item">
          <div class="info-icon">
            <i class="bi bi-chat-dots"></i>
          </div>
          <div class="info-content">
            <h4>Let's Connect</h4>
            <p>Discuss your vision and explore how we can bring it to life together.</p>
          </div>
        </div>

        <div class="contact-details">
          <div class="detail-item">
            <div class="detail-icon">
              <i class="bi bi-envelope-open"></i>
            </div>
            <div class="detail-content">
              <span class="detail-label">Email us</span>
              <span class="detail-value">contact@example.com</span>
            </div>
          </div>
          <div class="detail-item">
            <div class="detail-icon">
              <i class="bi bi-telephone-outbound"></i>
            </div>
            <div class="detail-content">
              <span class="detail-label">Call us</span>
              <span class="detail-value">+1 (555) 432-8976</span>
            </div>
          </div>
          <div class="detail-item">
            <div class="detail-icon">
              <i class="bi bi-geo-alt-fill"></i>
            </div>
            <div class="detail-content">
              <span class="detail-label">Visit us</span>
              <span class="detail-value">547 Madison Avenue<br>FCT, Abuja 10022</span>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-7">
        <div class="form-wrapper">
          <div class="form-header">
            <h3>Send us a message</h3>
          </div>

          <form action="forms/contact.php" method="post" class="php-email-form">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Full Name</label>
                  <input type="text" name="name" required="">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Email Address</label>
                  <input type="email" name="email" required="">
                </div>
              </div>
            </div>

            <div class="form-group">
              <label>Subject</label>
              <input type="text" name="subject" required="">
            </div>

            <div class="form-group">
              <label for="projectMessage">Message</label>
              <textarea name="message" id="projectMessage" rows="5" required=""></textarea>
            </div>

            <div class="my-3">
              <div class="loading">Loading</div>
              <div class="error-message"></div>
              <div class="sent-message">Your message has been sent. Thank you!</div>
            </div>

            <button type="submit" class="submit-btn">
              <span>Send Message</span>
              <i class="bi bi-arrow-right"></i>
            </button>

          </form>
        </div>
      </div>

    </div>
  </div>
</section>


  </main>

<footer id="footer" class="footer dark-background">

  <div class="container footer-top py-5">
    <div class="row gy-4">

      <!-- About / Logo -->
      <div class="col-lg-5 col-md-12 footer-about">
        <a href="index.html" class="logo d-flex align-items-center mb-3">
          <span class="sitename" style="color: var(--accent-color); font-weight: 600;">constituencyproject</span>
        </a>
        <p style="color: color-mix(in srgb, var(--contrast-color), transparent 70%);">
          Constituency Project  is a public-impact platform dedicated to making constituency projects visible, verifiable, and preserved as a lasting legacy.
        </p>
        <div class="social-links d-flex mt-4 gap-3">
          <a href="#" class="social-icon" style="border-color: var(--secondary-color); color: var(--secondary-color);"><i class="bi bi-twitter-x"></i></a>
          <a href="#" class="social-icon" style="border-color: var(--secondary-color); color: var(--secondary-color);"><i class="bi bi-facebook"></i></a>
          <a href="#" class="social-icon" style="border-color: var(--secondary-color); color: var(--secondary-color);"><i class="bi bi-instagram"></i></a>
          <a href="#" class="social-icon" style="border-color: var(--secondary-color); color: var(--secondary-color);"><i class="bi bi-linkedin"></i></a>
        </div>
      </div>

      <!-- Useful Links -->
      <div class="col-lg-2 col-6 footer-links">
        <h4 style="color: var(--secondary-color);">Useful Links</h4>
        <ul>
          <li><a href="#">Home</a></li>
          <li><a href="#">About us</a></li>
          <li><a href="#">Services</a></li>
          <li><a href="#">Terms of Service</a></li>
          <li><a href="#">Privacy Policy</a></li>
        </ul>
      </div>

      <!-- Services Links -->
      <div class="col-lg-2 col-6 footer-links">
        <h4 style="color: var(--secondary-color);">Our Services</h4>
        <ul>
          <li><a href="#">Project Documentation</a></li>
          <li><a href="#">Monitoring & Evaluation</a></li>
          <li><a href="#">Media Amplification</a></li>
          <li><a href="#">Public Impact Reports</a></li>
          <li><a href="#">Training & Capacity Building</a></li>
        </ul>
      </div>

      <!-- Contact Info -->
      <div class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
        <h4 style="color: var(--secondary-color);">Contact Us</h4>
        <p>547 Madison Avenue<br>FCT, Abuja 10022<br>Nigeria</p>
        <p class="mt-3"><strong>Phone:</strong> <span>+234 809 000 1234</span></p>
        <p><strong>Email:</strong> <span>info@constituencyproject.org</span></p>
      </div>

    </div>
  </div>

  <div class="container copyright text-center mt-4 py-3">
    <p style="color: color-mix(in srgb, var(--contrast-color), transparent 60%);">
      © <span>Copyright</span>
      <strong class="px-1 sitename" style="color: var(--accent-color);">Constituency Project </strong>
      <span>All Rights Reserved</span>
    </p>
  </div>

</footer>


  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <script>
document.addEventListener("DOMContentLoaded", function () {
  const tooltipTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="tooltip"]')
  );

  tooltipTriggerList.map(function (el) {
    return new bootstrap.Tooltip(el);
  });
});
</script>

  <!-- Vendor JS Files -->
  <script src="{{ asset('fe/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('fe/assets/vendor/php-email-form/validate.js') }}"></script>
  <script src="{{ asset('fe/assets/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('fe/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('fe/assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
  <script src="{{ asset('fe/assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
  <script src="{{ asset('fe/assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
  <script src="{{ asset('fe/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>

  <!-- Main JS File -->
  <script src="{{asset('fe/assets/js/main.js')}}"></script>

</body>

</html>
