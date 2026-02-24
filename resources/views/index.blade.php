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
        <img src="{{ asset('fe/assets/img/logo_current.webp')}}" alt="">
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
              <li><a href="{{ route('contributor.apply') }}">Become A Contributor</a></li>
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

    <!-- Hero Section -->
    <section id="hero" class="hero section light-background">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row align-items-center">
          <div class="col-lg-6">
            <div class="hero-content">
              <h1 data-aos="fade-up" data-aos-delay="200">The Inevitable Question Every Leader Must Answer</h1>
              <p data-aos="fade-up" data-aos-delay="300">What did you do when you were there? Constituency Project transforms promises into verifiable projects, measurable impact, and a legacy that speaks for itself.</p>
              <div class="hero-cta" data-aos="fade-up" data-aos-delay="400">
                <a href="#portfolio" class="btn-primary">Show Your Legacy</a>
                <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8" class="btn-secondary glightbox">
                  <i class="bi bi-play-circle"></i> Watch Impact
                </a>
              </div>
              <div class="hero-stats" data-aos="fade-up" data-aos-delay="500">
                <div class="stat-item"><div class="stat-number">300+</div><div class="stat-label">Projects Delivered</div></div>
                <div class="stat-item"><div class="stat-number">1M+</div><div class="stat-label">Lives Impacted</div></div>
                <div class="stat-item"><div class="stat-number">15+</div><div class="stat-label">States Covered</div></div>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="hero-image" data-aos="fade-left" data-aos-delay="300" data-aos-duration="900">
              <img src="{{ asset('fe/assets/img/about/community-led.jpg') }}" alt="Community Project Execution" class="img-fluid hero-img-hover">
              <div class="floating-card" data-aos="zoom-in" data-aos-delay="600">
                <div class="card-icon"><i class="bi bi-check-circle-fill"></i></div>
                <div class="card-content"><h5>Verified Impact</h5><div class="growth-percentage">100%</div></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about section">
      <div class="container section-title" data-aos="fade-up">
        <span class="subtitle">Who We Are</span>
        <h2>About Constituency Project</h2>
        <p>We are a public-impact and governance support company dedicated to turning constituency projects into visible, verifiable, and lasting legacy.</p>
      </div>
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row align-items-center">
          <div class="col-lg-6" data-aos="fade-right" data-aos-delay="200">
            <div class="content">
              <h2>From Promises to Proven Impact</h2>
              <p class="lead">We plan, execute, document, and amplify structural and capacity-building projects across Nigeria with transparency and accountability.</p>
              <p>Our work bridges the gap between delivery and perception—ensuring that every school, borehole, training programme, or intervention becomes documented evidence of service.</p>
              <p>Through technology-driven monitoring, media amplification, and ethical governance, we help leaders build trust and leave behind a legacy that endures.</p>
              <div class="stats-row">
                <div class="stat-item"><div class="stat-number purecounter" data-purecounter-start="0" data-purecounter-end="10" data-purecounter-duration="1"></div><div class="stat-label">Years Experience</div></div>
                <div class="stat-item"><div class="stat-number purecounter" data-purecounter-start="0" data-purecounter-end="300" data-purecounter-duration="1"></div><div class="stat-label">Projects Executed</div></div>
                <div class="stat-item"><div class="stat-number purecounter" data-purecounter-start="0" data-purecounter-end="1000000" data-purecounter-duration="2"></div><div class="stat-label">Beneficiaries</div></div>
              </div>
              <div class="cta-section"><a href="#team" class="btn-outline">Request Report</a></div>
            </div>
          </div>
          <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
            <div class="image-wrapper">
              <img src="{{ asset('fe/assets/img/about/borehole.jpg') }}" alt="Project Documentation" class="img-fluid about-img-hover">
              <div class="floating-card" data-aos="zoom-in" data-aos-delay="500">
                <div class="card-content">
                  <div class="icon"><i class="bi bi-shield-check"></i></div>
                  <div class="text"><h4>Transparency & Trust</h4><p>Every project documented. Every impact verified.</p></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Projects Section -->
    @if(isset($projects) && $projects->count() > 0)
    <section id="top-projects" class="top-projects section bg-light">
      <div class="container section-title" data-aos="fade-up">
        <span class="subtitle">Featured Opportunities</span>
        <h2>Top Active Projects</h2>
        <p>Explore verified public projects. Support them financially as a donor or apply as a contractor to execute and deliver impact.</p>
      </div>
      <div class="container">
        <div class="row gy-4">
          @foreach($projects as $project)
            <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="100">
              <div class="card shadow-sm border-0 h-100 project-card">
                <img src="{{ asset('storage/'.$project->featured_image) }}" class="card-img-top" style="height:220px; object-fit:cover;">
                <div class="card-body d-flex flex-column">
                  <h5 class="card-title mb-2">{{ $project->title }}</h5>
                  <small class="text-muted mb-2">{{ $project->full_location }}</small>
                  <div class="progress mb-3" style="height:6px;"><div class="progress-bar {{ $project->progress_bar_class }}" style="width: {{ $project->progress_percentage }}%"></div></div>
                  <div class="mt-auto d-flex justify-content-between flex-wrap gap-2">
                    <a href="{{ route('user.projects.show', $project->slug) }}" class="btn btn-sm btn-outline-primary animated-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="View Project Info"><i class="bi bi-eye"></i></a>
                    <a href="{{ route('candidates.show', $project->candidate->slug) }}" class="btn btn-sm btn-outline-dark animated-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="View Candidate Info"><i class="bi bi-person"></i></a>
                    @if($project->is_active)
                      <a href="{{ route('contributor.project.apply', $project->id) }}" class="btn btn-sm btn-success animated-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Contribute To Project"><i class="bi bi-cash-coin"></i></a>
                      <a href="{{ route('contractor.projects.form', $project->id) }}" class="btn btn-sm btn-warning animated-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Become A Contractor"><i class="bi bi-tools"></i></a>
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

    <!-- Leaderboard Section -->
    <section id="leaderboard" class="leaderboard section py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
      <div class="container">
        <div class="section-title text-center mb-5" data-aos="fade-up">
          <span class="badge px-4 py-2 mb-3" style="background-color: rgba(41, 162, 33, 0.1); color: #29a221; font-weight: 500; letter-spacing: 1px; border-radius: 50px;">
            <i class="bi bi-trophy-fill me-1" style="color: #ffc107;"></i> HONOUR ROLL
          </span>
          <h2 class="display-5 fw-bold mb-3" style="color: #212529;">Distinguished Contributors</h2>
          <p class="text-muted mx-auto" style="max-width: 700px; font-size: 1.1rem;">Recognising exceptional citizens whose financial contributions are driving transparent development across constituencies.</p>
        </div>

        <div class="row g-4 justify-content-center">
          @foreach($topContributors as $index => $contributor)
            @php
              $totalDonated = $contributor->donations_sum_amount ?? $contributor->totalDonated() ?? 0;
              $rank = $index + 1;
              $contributorName = $contributor->name ?? $contributor->user->name ?? 'Anonymous Citizen';
              $photoUrl = $contributor->photo ? asset('storage/' . $contributor->photo) : asset('images/contributor-placeholder.jpg');
            @endphp

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $index * 50 }}">
              <div class="card contributor-card h-100 border-0 rounded-4 overflow-hidden position-relative" style="background: white; box-shadow: 0 10px 30px rgba(0,0,0,0.05); transition: all 0.3s ease;">
                <div class="position-relative" style="height: 8px; background: linear-gradient(90deg, #29a221, #ffc107);"></div>
                <div class="position-absolute top-0 start-0 m-3" style="z-index: 5;">
                  <div class="d-flex align-items-center justify-content-center rounded-circle bg-white shadow-sm" style="width: 45px; height: 45px; border: 2px solid {{ $rank == 1 ? '#ffc107' : ($rank == 2 ? '#29a221' : '#dee2e6') }};">
                    <span class="fw-bold" style="color: {{ $rank == 1 ? '#ffc107' : ($rank == 2 ? '#29a221' : '#6c757d') }}; font-size: 1.2rem;">{{ $rank }}</span>
                  </div>
                </div>
                <div class="card-body text-center p-4 pt-5">
                  <div class="position-relative d-inline-block mb-4">
                    <div class="rounded-circle overflow-hidden border-3 shadow-sm" style="width: 120px; height: 120px; border: 3px solid {{ $rank == 1 ? '#ffc107' : ($rank == 2 ? '#29a221' : '#e9ecef') }}; margin: 0 auto;">
                      <img src="{{ $photoUrl }}" alt="{{ $contributorName }}" class="w-100 h-100" style="object-fit: cover;" loading="lazy" onerror="this.src='{{ asset('images/avatar.png') }}'">
                    </div>
                    @if($rank == 1)
                      <div class="position-absolute top-0 end-0" style="transform: translate(10px, -10px);">
                        <span class="d-flex align-items-center justify-content-center rounded-circle bg-warning shadow" style="width: 32px; height: 32px;">
                          <i class="bi bi-crown-fill text-white" style="font-size: 1rem;"></i>
                        </span>
                      </div>
                    @endif
                  </div>

                  <h4 class="fw-bold mb-1" style="color: #212529; font-size: 1.3rem;">{{ $contributorName }}</h4>

                  @if(!empty($contributor->district) || !empty($contributor->lga))
                    <p class="text-muted small mb-3"><i class="bi bi-geo-alt-fill me-1" style="color: #29a221;"></i> {{ $contributor->district ?? $contributor->lga ?? 'Constituency' }}</p>
                  @endif

                  <div class="mb-3 p-3 rounded-3" style="background: rgba(41, 162, 33, 0.03); border: 1px solid rgba(41, 162, 33, 0.1);">
                    <small class="text-uppercase" style="color: #6c757d; letter-spacing: 1px; font-size: 0.7rem;">Total Contribution</small>
                    <div class="d-flex align-items-center justify-content-center">
                      <span style="color: #6c757d; font-size: 1.2rem; margin-right: 2px;">₦</span>
                      <span class="fw-bold" style="color: #29a221; font-size: 1.8rem;">{{ number_format($totalDonated) }}</span>
                    </div>
                  </div>

                  <div class="mb-4">
                    @if($totalDonated >= 1000000)
                      <span class="badge px-3 py-2" style="background: linear-gradient(135deg, #ffc107 0%, #29a221 100%); color: white; border-radius: 50px;"><i class="bi bi-gem me-1"></i> Platinum Patron</span>
                    @elseif($totalDonated >= 500000)
                      <span class="badge px-3 py-2" style="background: linear-gradient(135deg, #ffc107 0%, #ffc107 100%); color: #212529; border-radius: 50px;"><i class="bi bi-star-fill me-1"></i> Gold Supporter</span>
                    @elseif($totalDonated >= 100000)
                      <span class="badge px-3 py-2" style="background: linear-gradient(135deg, #29a221 0%, #29a221 100%); color: white; border-radius: 50px;"><i class="bi bi-award-fill me-1"></i> Silver Contributor</span>
                    @else
                      <span class="badge px-3 py-2" style="background: #e9ecef; color: #495057; border-radius: 50px;"><i class="bi bi-heart-fill me-1" style="color: #29a221;"></i> Community Patron</span>
                    @endif
                  </div>

                  <a href="{{ route('contributor.profile', ['slug' => $contributor->slug ?? null, 'id' => $contributor->id]) }}" class="btn w-100 py-2 rounded-3" style="border: 1px solid #29a221; color: #29a221; background: white; transition: all 0.3s ease;" onmouseover="this.style.background='#29a221'; this.style.color='white'; this.style.borderColor='#29a221';" onmouseout="this.style.background='white'; this.style.color='#29a221'; this.style.borderColor='#29a221';">View Profile <i class="bi bi-arrow-right ms-1"></i></a>
                </div>
              </div>
            </div>
          @endforeach
        </div>

        <div class="text-center mt-5" data-aos="fade-up">
          <div class="d-inline-flex align-items-center mb-4">
            <div class="vr me-3" style="height: 30px; background: #29a221; opacity: 0.3;"></div>
            <p class="text-muted mb-0"><i class="bi bi-patch-check-fill me-1" style="color: #29a221;"></i> All contributions are verified and publicly traceable</p>
            <div class="vr ms-3" style="height: 30px; background: #29a221; opacity: 0.3;"></div>
          </div>
          <a href="{{ route('contributors.index') }}" class="btn btn-lg px-5 py-3" style="background: linear-gradient(135deg, #29a221 0%, #ffc107 100%); color: white; border: none; border-radius: 50px; box-shadow: 0 10px 20px rgba(41, 162, 33, 0.2); transition: all 0.3s ease;">View Complete Honour Roll <i class="bi bi-arrow-right ms-2"></i></a>
        </div>
      </div>
    </section>

    <!-- Personalities Section -->
    <section id="personalities" class="portfolio section py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);">
      <div class="container section-title text-center mb-5" data-aos="fade-up">
        <span class="subtitle d-inline-block px-4 py-2 mb-3 rounded-pill" style="background: rgba(41, 162, 33, 0.1); color: #29a221; font-weight: 500; letter-spacing: 1px;">
          <i class="bi bi-people-fill me-2" style="color: #ffc107;"></i> FEATURED PERSONALITIES
        </span>
        <h2 class="display-5 fw-bold mb-3" style="color: #212529;">Distinguished Leaders</h2>
        <p class="text-muted mx-auto" style="max-width: 800px; font-size: 1.1rem;">Explore verified portfolios of influential personalities whose public work, initiatives, leadership, and contributions are documented and preserved for reference.</p>
      </div>

      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">
          <ul class="portfolio-filters isotope-filters d-flex flex-wrap justify-content-center gap-2 mb-5" data-aos="fade-up" data-aos-delay="200">
            <li data-filter="*" class="filter-active px-4 py-2 rounded-pill cursor-pointer" style="background: #29a221; color: white; list-style: none; transition: all 0.3s ease; cursor: pointer;">All Personalities</li>
            <li data-filter=".filter-politics" class="px-4 py-2 rounded-pill cursor-pointer" style="background: white; color: #212529; border: 1px solid #dee2e6; list-style: none; transition: all 0.3s ease; cursor: pointer;" onmouseover="this.style.background='#ffc107'; this.style.color='#212529'; this.style.borderColor='#ffc107';" onmouseout="this.style.background='white'; this.style.color='#212529'; this.style.borderColor='#dee2e6';">Politics</li>
            <li data-filter=".filter-governance" class="px-4 py-2 rounded-pill cursor-pointer" style="background: white; color: #212529; border: 1px solid #dee2e6; list-style: none; transition: all 0.3s ease; cursor: pointer;" onmouseover="this.style.background='#ffc107'; this.style.color='#212529'; this.style.borderColor='#ffc107';" onmouseout="this.style.background='white'; this.style.color='#212529'; this.style.borderColor='#dee2e6';">Governance</li>
            <li data-filter=".filter-advocacy" class="px-4 py-2 rounded-pill cursor-pointer" style="background: white; color: #212529; border: 1px solid #dee2e6; list-style: none; transition: all 0.3s ease; cursor: pointer;" onmouseover="this.style.background='#ffc107'; this.style.color='#212529'; this.style.borderColor='#ffc107';" onmouseout="this.style.background='white'; this.style.color='#212529'; this.style.borderColor='#dee2e6';">Advocacy</li>
            <li data-filter=".filter-activism" class="px-4 py-2 rounded-pill cursor-pointer" style="background: white; color: #212529; border: 1px solid #dee2e6; list-style: none; transition: all 0.3s ease; cursor: pointer;" onmouseover="this.style.background='#ffc107'; this.style.color='#212529'; this.style.borderColor='#ffc107';" onmouseout="this.style.background='white'; this.style.color='#212529'; this.style.borderColor='#dee2e6';">Activism</li>
          </ul>

          <div class="row gy-5 isotope-container" data-aos="fade-up" data-aos-delay="300">
            @forelse($featuredCandidates ?? [] as $index => $candidate)
              @php
                $totalPhases = 0;
                $totalUpdates = 0;
                foreach($candidate->projects as $project) {
                  $totalPhases += $project->phases->count();
                  foreach($project->phases as $phase) {
                    $totalUpdates += $phase->updates->count();
                  }
                }
                $categories = ['politics', 'governance', 'advocacy', 'activism'];
                $category = $categories[$index % 4];
              @endphp

              <div class="col-lg-12 portfolio-item isotope-item filter-{{ $category }}">
                <article class="portfolio-card bg-white rounded-4 shadow-lg overflow-hidden mb-4">
                  <div class="row g-0">
                    <div class="col-md-5">
                      <div class="project-visual position-relative h-100">
                        <img src="{{ $candidate->photo ? asset('storage/'.$candidate->photo) : asset('fe/assets/img/person/default.jpg') }}" alt="{{ $candidate->name }}" class="img-fluid w-100 h-100" style="object-fit: cover; min-height: 350px;" loading="lazy">
                        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, rgba(41, 162, 33, 0.3) 0%, rgba(255, 193, 7, 0.3) 100%);"></div>
                        <div class="position-absolute top-0 end-0 m-4"><span class="badge px-4 py-2 rounded-pill shadow" style="background: #ffc107; color: #212529; font-weight: 500;"><i class="bi bi-file-text me-1"></i> Report Available</span></div>
                        <div class="project-overlay position-absolute bottom-0 start-0 w-100 p-4" style="background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);">
                          <div class="overlay-content d-flex gap-2">
                            <a href="{{ $candidate->photo ? asset('storage/'.$candidate->photo) : asset('fe/assets/img/person/default.jpg') }}" class="btn btn-sm rounded-circle glightbox" style="background: #29a221; color: white; width: 45px; height: 45px; display: inline-flex; align-items: center; justify-content: center;"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('candidate.report.preview', $candidate->slug ?? $candidate->id) }}" class="btn btn-sm rounded-circle" style="background: #ffc107; color: #212529; width: 45px; height: 45px; display: inline-flex; align-items: center; justify-content: center;"><i class="bi bi-file-text"></i></a>
                            <a href="{{ route('candidate.public.show', $candidate->slug ?? $candidate->id) }}" class="btn btn-sm rounded-circle" style="background: white; color: #29a221; width: 45px; height: 45px; display: inline-flex; align-items: center; justify-content: center;"><i class="bi bi-arrow-up-right"></i></a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-7">
                      <div class="project-details p-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                          <span class="project-category px-3 py-1 rounded-pill" style="background: rgba(41, 162, 33, 0.1); color: #29a221; font-weight: 500;"><i class="bi bi-tag me-1"></i> {{ ucfirst($category) }}</span>
                          <time class="project-year" style="color: #ffc107; font-weight: 500;"><i class="bi bi-calendar3 me-1"></i> {{ $candidate->created_at->format('Y') }} – Present</time>
                        </div>
                        <h3 class="project-title fw-bold mb-3" style="color: #212529; font-size: 2rem;">
                          @if($index < 3)<span class="honorific d-block" style="color: #ffc107; font-size: 1.2rem; font-weight: normal;">{{ ['Distinguished', 'Eminent', 'Notable'][$index] }}</span>@endif
                          {{ $candidate->name }}
                        </h3>
                        <p class="project-description text-muted mb-4" style="line-height: 1.8;">{{ Str::limit($candidate->bio ?? 'Public figure with documented constituency projects and verified public service record.', 200) }}</p>
                        <div class="row g-3 mb-4">
                          <div class="col-4"><div class="text-center p-3 rounded-3" style="background: rgba(41, 162, 33, 0.05);"><div class="small text-uppercase mb-1" style="color: #6c757d; font-size: 0.7rem;">Projects</div><div class="fw-bold" style="color: #29a221; font-size: 1.5rem;">{{ $candidate->projects->count() }}</div></div></div>
                          <div class="col-4"><div class="text-center p-3 rounded-3" style="background: rgba(255, 193, 7, 0.05);"><div class="small text-uppercase mb-1" style="color: #6c757d; font-size: 0.7rem;">Phases</div><div class="fw-bold" style="color: #ffc107; font-size: 1.5rem;">{{ $totalPhases }}</div></div></div>
                          <div class="col-4"><div class="text-center p-3 rounded-3" style="background: rgba(41, 162, 33, 0.05);"><div class="small text-uppercase mb-1" style="color: #6c757d; font-size: 0.7rem;">Updates</div><div class="fw-bold" style="color: #29a221; font-size: 1.5rem;">{{ $totalUpdates }}</div></div></div>
                        </div>
                        <div class="d-flex gap-3">
                          <a href="{{ route('candidate.report.preview', $candidate->slug ?? $candidate->id) }}" class="btn flex-fill py-3 rounded-3 text-center text-decoration-none" style="background: linear-gradient(135deg, #29a221 0%, #ffc107 100%); color: white; border: none; transition: all 0.3s ease; font-weight: 500;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 10px 20px rgba(41,162,33,0.3)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';"><i class="bi bi-file-text me-2"></i> Access Full Report</a>
                          <a href="{{ route('candidate.public.show', $candidate->slug ?? $candidate->id) }}" class="btn flex-fill py-3 rounded-3 text-center text-decoration-none" style="border: 2px solid #29a221; color: #29a221; background: white; transition: all 0.3s ease; font-weight: 500;" onmouseover="this.style.background='#29a221'; this.style.color='white';" onmouseout="this.style.background='white'; this.style.color='#29a221';"><i class="bi bi-person me-2"></i> View Profile</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </article>
              </div>
            @empty
              <div class="col-12 text-center py-5"><div class="alert alert-info"><i class="bi bi-info-circle me-2"></i> No featured personalities available at the moment.</div></div>
            @endforelse
          </div>
        </div>

        <div class="portfolio-conclusion mt-5" data-aos="fade-up" data-aos-delay="400">
          <div class="conclusion-content text-center p-5 rounded-4 shadow-lg" style="background: linear-gradient(135deg, #29a221 0%, #ffc107 100%);">
            <h4 class="text-white mb-3" style="font-size: 2rem;">Discover More Public Figures</h4>
            <p class="text-white opacity-90 mb-4" style="max-width: 600px; margin: 0 auto; font-size: 1.1rem;">Browse the full directory of personalities and explore detailed portfolios documenting their public impact.</p>
            <div class="conclusion-actions"><a href="{{ route('candidates.index') }}" class="btn btn-lg px-5 py-3 rounded-pill text-decoration-none" style="background: white; color: #29a221; border: none; font-weight: 500; transition: all 0.3s ease; display: inline-block;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 10px 20px rgba(0,0,0,0.2)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">View All Personalities <i class="bi bi-arrow-right ms-2"></i></a></div>
          </div>
        </div>
      </div>
    </section>

    <!-- Featured Portfolios Section -->
    <section id="featured-portfolios" class="portfolios section py-5" style="background: #f8f9fa;">
      <div class="container section-title text-center mb-5" data-aos="fade-up">
        <span class="subtitle d-inline-block px-4 py-2 mb-3 rounded-pill" style="background: rgba(255, 193, 7, 0.1); color: #ffc107; font-weight: 500;">
          <i class="bi bi-award-fill me-2" style="color: #29a221;"></i> Verified Portfolios
        </span>
        <h2 class="display-5 fw-bold mb-3" style="color: #212529;">Public Impact, Documented</h2>
        <p class="text-muted mx-auto" style="max-width: 800px; font-size: 1.1rem;">A curated selection of leaders whose constituency projects and public interventions have been independently documented, verified, and archived.</p>
      </div>

      <div class="container">
        <div class="row g-4">
          @foreach($featuredPortfolios ?? [] as $portfolio)
            @php
              $totalUpdates = 0;
              foreach($portfolio->projects as $project) {
                foreach($project->phases as $phase) {
                  $totalUpdates += $phase->updates->count();
                }
              }
            @endphp
            <div class="col-lg-4 col-md-6">
              <a href="{{ route('candidate.report.preview', $portfolio->slug) }}" class="portfolio-card d-block bg-white rounded-4 shadow-lg overflow-hidden text-decoration-none" data-aos="fade-up" style="transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 20px 30px rgba(41,162,33,0.2)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 20px rgba(0,0,0,0.05)';">
                <div class="position-relative" style="height: 250px; overflow: hidden;">
                  <img src="{{ $portfolio->photo ? asset('storage/'.$portfolio->photo) : asset('fe/assets/img/person/default.jpg') }}" alt="{{ $portfolio->name }}" class="w-100 h-100" style="object-fit: cover; transition: all 0.5s ease;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                  <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);"></div>
                  <div class="position-absolute top-0 start-0 w-100 p-4 d-flex justify-content-between">
                    <span class="badge px-4 py-2 rounded-pill" style="background: #29a221; color: white;"><i class="bi bi-patch-check-fill me-1"></i> Verified Portfolio</span>
                    <div class="stars d-flex gap-1">@for($i = 0; $i < 5; $i++)<i class="bi bi-star-fill" style="color: #ffc107;"></i>@endfor</div>
                  </div>
                  <div class="position-absolute bottom-0 start-0 w-100 p-4">
                    <h3 class="text-white fw-bold mb-1" style="font-size: 1.5rem;">{{ $portfolio->name }}</h3>
                    <p class="text-white-50 mb-2">@if($portfolio->positions->first()){{ $portfolio->positions->first()->position }}@else Public Leadership @endif</p>
                  </div>
                </div>
                <div class="p-4">
                  <p class="text-muted mb-4" style="color: #6c757d; min-height: 60px;">{{ Str::limit($portfolio->bio ?? 'Documented constituency engagements, leadership programmes, and civic accountability initiatives.', 100) }}</p>
                  <div class="d-flex justify-content-between align-items-center pt-3 border-top" style="border-color: rgba(41, 162, 33, 0.2) !important;">
                    <div class="d-flex gap-3">
                      <div class="text-center"><div class="small text-muted">Projects</div><div class="fw-bold" style="color: #29a221;">{{ $portfolio->projects->count() }}</div></div>
                      <div class="text-center"><div class="small text-muted">Updates</div><div class="fw-bold" style="color: #ffc107;">{{ $totalUpdates }}</div></div>
                    </div>
                    <span class="btn btn-sm rounded-pill px-4 py-2" style="background: #29a221; color: white;">View Full Portfolio <i class="bi bi-arrow-right ms-1"></i></span>
                  </div>
                </div>
              </a>
            </div>
          @endforeach
        </div>
      </div>
    </section>

    <!-- Platform Vision Section -->
    <section id="platform-vision" class="services section">
      <div class="container section-title" data-aos="fade-up">
        <span class="subtitle">Our Platform</span>
        <h2>Transparency. Participation. Accountability.</h2>
        <p>Constituency Project connects public project owners, verified contractors, and community donors within one transparent digital ecosystem.</p>
      </div>
      <div class="container">
        <div class="row gy-5">
          <div class="col-lg-4 col-md-6"><div class="service-item"><div class="service-icon"><i class="bi bi-search"></i></div><h3>Verified Public Projects</h3><p>Explore active and completed projects with documented phases, media evidence, budgets, and timelines.</p></div></div>
          <div class="col-lg-4 col-md-6"><div class="service-item"><div class="service-icon"><i class="bi bi-cash-stack"></i></div><h3>Community Funding</h3><p>Become a contributor and financially support projects you believe in. Every donation is tracked and transparent.</p></div></div>
          <div class="col-lg-4 col-md-6"><div class="service-item"><div class="service-icon"><i class="bi bi-hammer"></i></div><h3>Contract Opportunities</h3><p>Skilled contractors can apply to execute verified projects. All applications are reviewed and approved by project owners.</p></div></div>
          <div class="col-lg-4 col-md-6"><div class="service-item"><div class="service-icon"><i class="bi bi-bar-chart-line"></i></div><h3>Real-Time Progress Tracking</h3><p>Track phase-by-phase execution, completion percentages, and project health indicators.</p></div></div>
          <div class="col-lg-4 col-md-6"><div class="service-item"><div class="service-icon"><i class="bi bi-award"></i></div><h3>Recognition & Leaderboards</h3><p>Top contributors are publicly recognized for their support and impact across communities.</p></div></div>
        </div>
      </div>
    </section>

    <!-- Why We Exist Section -->
    <div class="container section-title" data-aos="fade-up">
      <span class="subtitle">Why We Exist</span>
      <h2>Because Public Work Should Be Publicly Proven</h2>
      <p>Constituency Project is built to make public service measurable, discoverable, and permanently accountable — without spin or sentiment.</p>
    </div>
    <div class="container">
      <div class="row align-items-center g-5">
        <div class="col-lg-5" data-aos="fade-right">
          <div class="why-anchor">
            <img src="{{ asset('fe/assets/img/about/local_meet.jpeg') }}" alt="Documented public engagement" class="img-fluid">
            <div class="anchor-badge"><i class="bi bi-shield-check"></i><span>Neutral Documentation Platform</span></div>
          </div>
        </div>
        <div class="col-lg-7">
          <div class="principle" data-aos="fade-up"><i class="bi bi-eye-fill"></i><div><h3>Visibility by Default</h3><p>Every documented project is open to citizens, media, partners, and institutions — not hidden behind narratives or gatekeepers.</p></div></div>
          <div class="principle" data-aos="fade-up" data-aos-delay="100"><i class="bi bi-shield-check"></i><div><h3>Evidence Over Claims</h3><p>We publish timelines, visuals, and outcomes so impact can be assessed — not assumed.</p></div></div>
          <div class="principle" data-aos="fade-up" data-aos-delay="200"><i class="bi bi-search"></i><div><h3>Accessible by Design</h3><p>Anyone can search, review, and compare public portfolios without registration, permissions, or bias.</p></div></div>
          <div class="principle" data-aos="fade-up" data-aos-delay="300"><i class="bi bi-archive-fill"></i><div><h3>Legacy That Outlives Office</h3><p>Public work should not disappear with tenure. We preserve it as a permanent civic record.</p></div></div>
        </div>
      </div>
    </div>

    <!-- Contact Section -->
    <section id="contact" class="contact section" style="background-color: #f9f9f9;">
      <div class="container section-title" data-aos="fade-up">
        <span class="subtitle">Contact</span>
        <h2>Let's Connect</h2>
        <p>We're ready to discuss your vision and show how public impact can be documented effectively.</p>
      </div>
      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-5">
            <div class="info-item"><div class="info-icon"><i class="bi bi-chat-dots"></i></div><div class="info-content"><h4>Let's Connect</h4><p>Discuss your vision and explore how we can bring it to life together.</p></div></div>
            <div class="contact-details">
              <div class="detail-item"><div class="detail-icon"><i class="bi bi-envelope-open"></i></div><div class="detail-content"><span class="detail-label">Email us</span><span class="detail-value">contact@example.com</span></div></div>
              <div class="detail-item"><div class="detail-icon"><i class="bi bi-telephone-outbound"></i></div><div class="detail-content"><span class="detail-label">Call us</span><span class="detail-value">+1 (555) 432-8976</span></div></div>
              <div class="detail-item"><div class="detail-icon"><i class="bi bi-geo-alt-fill"></i></div><div class="detail-content"><span class="detail-label">Visit us</span><span class="detail-value">547 Madison Avenue<br>FCT, Abuja 10022</span></div></div>
            </div>
          </div>
          <div class="col-lg-7">
            <div class="form-wrapper">
              <div class="form-header"><h3>Send us a message</h3></div>
              <form action="forms/contact.php" method="post" class="php-email-form">
                <div class="row">
                  <div class="col-md-6"><div class="form-group"><label>Full Name</label><input type="text" name="name" required=""></div></div>
                  <div class="col-md-6"><div class="form-group"><label>Email Address</label><input type="email" name="email" required=""></div></div>
                </div>
                <div class="form-group"><label>Subject</label><input type="text" name="subject" required=""></div>
                <div class="form-group"><label for="projectMessage">Message</label><textarea name="message" id="projectMessage" rows="5" required=""></textarea></div>
                <div class="my-3"><div class="loading">Loading</div><div class="error-message"></div><div class="sent-message">Your message has been sent. Thank you!</div></div>
                <button type="submit" class="submit-btn"><span>Send Message</span><i class="bi bi-arrow-right"></i></button>
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
        <div class="col-lg-5 col-md-12 footer-about">
          <a href="index.html" class="logo d-flex align-items-center mb-3"><span class="sitename" style="color: var(--accent-color); font-weight: 600;">constituencyproject</span></a>
          <p style="color: color-mix(in srgb, var(--contrast-color), transparent 70%);">Constituency Project is a public-impact platform dedicated to making constituency projects visible, verifiable, and preserved as a lasting legacy.</p>
          <div class="social-links d-flex mt-4 gap-3">
            <a href="#" class="social-icon" style="border-color: var(--secondary-color); color: var(--secondary-color);"><i class="bi bi-twitter-x"></i></a>
            <a href="#" class="social-icon" style="border-color: var(--secondary-color); color: var(--secondary-color);"><i class="bi bi-facebook"></i></a>
            <a href="#" class="social-icon" style="border-color: var(--secondary-color); color: var(--secondary-color);"><i class="bi bi-instagram"></i></a>
            <a href="#" class="social-icon" style="border-color: var(--secondary-color); color: var(--secondary-color);"><i class="bi bi-linkedin"></i></a>
          </div>
        </div>
        <div class="col-lg-2 col-6 footer-links">
          <h4 style="color: var(--secondary-color);">Useful Links</h4>
          <ul><li><a href="#">Home</a></li><li><a href="#">About us</a></li><li><a href="#">Services</a></li><li><a href="#">Terms of Service</a></li><li><a href="#">Privacy Policy</a></li></ul>
        </div>
        <div class="col-lg-2 col-6 footer-links">
          <h4 style="color: var(--secondary-color);">Our Services</h4>
          <ul><li><a href="#">Project Documentation</a></li><li><a href="#">Monitoring & Evaluation</a></li><li><a href="#">Media Amplification</a></li><li><a href="#">Public Impact Reports</a></li><li><a href="#">Training & Capacity Building</a></li></ul>
        </div>
        <div class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
          <h4 style="color: var(--secondary-color);">Contact Us</h4>
          <p>547 Madison Avenue<br>FCT, Abuja 10022<br>Nigeria</p>
          <p class="mt-3"><strong>Phone:</strong> <span>+234 809 000 1234</span></p>
          <p><strong>Email:</strong> <span>info@constituencyproject.org</span></p>
        </div>
      </div>
    </div>
    <div class="container copyright text-center mt-4 py-3">
      <p style="color: color-mix(in srgb, var(--contrast-color), transparent 60%);">© <span>Copyright</span> <strong class="px-1 sitename" style="color: var(--accent-color);">Constituency Project </strong> <span>All Rights Reserved</span></p>
    </div>
  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
      tooltipTriggerList.map(function (el) { return new bootstrap.Tooltip(el); });
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
  <script src="{{asset('fe/assets/js/main.js')}}"></script>

  @push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      if (typeof Isotope !== 'undefined') {
        var iso = new Isotope('.isotope-container', { itemSelector: '.isotope-item', layoutMode: 'masonry' });
        var filterButtons = document.querySelectorAll('.portfolio-filters li');
        filterButtons.forEach(function(button) {
          button.addEventListener('click', function() {
            filterButtons.forEach(function(btn) {
              btn.classList.remove('filter-active');
              btn.style.background = 'white';
              btn.style.color = '#212529';
            });
            this.classList.add('filter-active');
            this.style.background = '#29a221';
            this.style.color = 'white';
            var filterValue = this.getAttribute('data-filter');
            iso.arrange({ filter: filterValue });
          });
        });
      }
    });
  </script>
  @endpush
</body>
</html>
