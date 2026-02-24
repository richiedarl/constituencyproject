@php
    use App\Models\Application;
    use App\Models\Contact;
    use App\Models\ChangeRole;
    use App\Models\Update;
    use App\Models\ReportKey;
    use App\Models\PendingFundingRequest;
    use App\Models\Transaction;
    use Illuminate\Support\Str;

    // Get counts for various pending items
    $pendingApplications = class_exists(Application::class)
        ? Application::where('status', 'pending')->count()
        : 0;

    $pendingRoleRequests = class_exists(ChangeRole::class)
        ? ChangeRole::where('status', 'pending')->count()
        : 0;

    $pendingReports = class_exists(Update::class)
        ? Update::where('status', 'pending')->count()
        : 0;

    $pendingKeyRequests = class_exists(Contact::class)
        ? Contact::where('type', 'license_request')->where('status', 'pending')->count()
        : 0;

    $pendingFunding = class_exists(PendingFundingRequest::class)
        ? PendingFundingRequest::where('status', 'pending')->count()
        : 0;

    $pendingWithdrawals = class_exists(Transaction::class)
        ? Transaction::where('type', 'withdrawal')->where('status', 'pending')->count()
        : 0;

    $unreadContacts = class_exists(Contact::class)
        ? Contact::where('is_read', false)->count()
        : 0;

    $user = auth()->user();
    $userName = $user->name ?? 'Admin User';
    $userInitials = $user ? Str::of($user->name)->explode(' ')->map(fn($n) => strtoupper($n[0] ?? ''))->take(2)->join('') : 'A';

    // Get user photo if exists - supports multiple user types
    $userPhoto = null;
    if ($user) {
        // Check for contractor/candidate/contributor photo column
        if (!empty($user->photo)) {
            $userPhoto = asset('storage/' . $user->photo);
        } elseif (method_exists($user, 'getFirstMediaUrl') && $user->getFirstMediaUrl('photo')) {
            $userPhoto = $user->getFirstMediaUrl('photo');
        } elseif (!empty($user->profile_photo_url)) {
            $userPhoto = $user->profile_photo_url;
        }
    }
@endphp

<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow-sm border-bottom"
     aria-label="Main navigation"
     role="navigation">

    <!-- Sidebar Toggle (Mobile Only) -->
    <button id="sidebarToggleTop"
            class="btn btn-link d-md-none rounded-circle mr-3"
            aria-label="Toggle sidebar menu"
            title="Toggle navigation menu">
        <i class="fa fa-bars" aria-hidden="true"></i>
        <span class="sr-only">Menu</span>
    </button>

    <!-- Government Branding -->
    <div class="navbar-brand d-none d-md-block mr-4">
        <span class="text-primary font-weight-bold">GOV</span>
        <span class="text-muted small ml-1">| Official Portal</span>
    </div>

    <!-- Spacer -->
    <div class="ml-auto"></div>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav align-items-center">

        <!-- Applications -->
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link" href="{{ route('admin.applications.index') }}" aria-label="Applications" title="View pending applications">
                <i class="fas fa-file-alt fa-fw" aria-hidden="true"></i>
                @if($pendingApplications > 0)
                    <span class="badge badge-warning badge-counter"
                          aria-label="{{ $pendingApplications }} pending applications">
                        {{ $pendingApplications }}
                    </span>
                @endif
            </a>
        </li>

        <!-- Role Change Requests -->
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link" href="{{ route('checks.role-requests.pending') }}" aria-label="Role change requests" title="View pending role requests">
                <i class="fas fa-user-tag fa-fw" aria-hidden="true"></i>
                @if($pendingRoleRequests > 0)
                    <span class="badge badge-info badge-counter"
                          aria-label="{{ $pendingRoleRequests }} pending role requests">
                        {{ $pendingRoleRequests }}
                    </span>
                @endif
            </a>
        </li>

        <!-- Reports -->
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link" href="{{ route('submitted.reports.pending') }}" aria-label="Pending reports" title="View pending reports">
                <i class="fas fa-file-alt fa-fw" aria-hidden="true"></i>
                @if($pendingReports > 0)
                    <span class="badge badge-primary badge-counter"
                          aria-label="{{ $pendingReports }} pending reports">
                        {{ $pendingReports }}
                    </span>
                @endif
            </a>
        </li>

        <!-- Report Key Requests -->
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link" href="{{ route('keyrequests') }}" aria-label="Key requests" title="View pending key requests">
                <i class="fas fa-key fa-fw" aria-hidden="true"></i>
                @if($pendingKeyRequests > 0)
                    <span class="badge badge-secondary badge-counter"
                          aria-label="{{ $pendingKeyRequests }} pending key requests">
                        {{ $pendingKeyRequests }}
                    </span>
                @endif
            </a>
        </li>

        <!-- Pending Funding -->
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link" href="{{ route('pendingFundingRequests') }}" aria-label="Pending funding" title="View pending funding requests">
                <i class="fas fa-money-bill-wave fa-fw" aria-hidden="true"></i>
                @if($pendingFunding > 0)
                    <span class="badge badge-success badge-counter"
                          aria-label="{{ $pendingFunding }} pending funding requests">
                        {{ $pendingFunding }}
                    </span>
                @endif
            </a>
        </li>

        <!-- Pending Withdrawals -->
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link" href="{{ route('pendingWithdrawals') }}" aria-label="Pending withdrawals" title="View pending withdrawals">
                <i class="fas fa-arrow-up fa-fw" aria-hidden="true"></i>
                @if($pendingWithdrawals > 0)
                    <span class="badge badge-danger badge-counter"
                          aria-label="{{ $pendingWithdrawals }} pending withdrawals">
                        {{ $pendingWithdrawals }}
                    </span>
                @endif
            </a>
        </li>

        <!-- Contact Enquiries -->
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link" href="{{ route('admin.contacts.index') }}" aria-label="Contact enquiries" title="View unread contact enquiries">
                <i class="fas fa-envelope fa-fw" aria-hidden="true"></i>
                @if($unreadContacts > 0)
                    <span class="badge badge-danger badge-counter"
                          aria-label="{{ $unreadContacts }} unread enquiries">
                        {{ $unreadContacts }}
                    </span>
                @endif
            </a>
        </li>

        <!-- Divider -->
        <div class="topbar-divider d-none d-sm-block mx-2" role="separator"></div>

        <!-- User Dropdown -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle d-flex align-items-center"
               href="#"
               id="userDropdown"
               role="button"
               data-toggle="dropdown"
               aria-haspopup="true"
               aria-expanded="false"
               aria-label="User menu">

                <span class="mr-2 d-none d-lg-inline text-gray-600 small font-weight-medium">
                    {{ $userName }}
                    @if($user && $user->admin)
                        <span class="badge badge-primary ml-1">Admin</span>
                    @endif
                </span>

                <!-- User Avatar with Fallback -->
                <div class="user-avatar rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                     style="width: 32px; height: 32px; overflow: hidden;"
                     aria-hidden="true">

                    @if($userPhoto)
                        <img src="{{ $userPhoto }}"
                             alt="{{ $userName }}"
                             class="img-fluid w-100 h-100"
                             style="object-fit: cover;"
                             loading="lazy">
                    @else
                        <span class="small font-weight-bold">{{ $userInitials }}</span>
                    @endif
                </div>
            </a>

            <!-- Dropdown Menu -->
            <div class="dropdown-menu dropdown-menu-right shadow-sm py-0 mt-2 border-0"
                 aria-labelledby="userDropdown"
                 style="min-width: 240px;">

                <!-- User Info Header -->
                <div class="dropdown-header bg-light py-3 border-bottom">
                    <div class="d-flex align-items-center">
                        <div class="user-avatar rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mr-3"
                             style="width: 40px; height: 40px;">
                            @if($userPhoto)
                                <img src="{{ $userPhoto }}"
                                     alt=""
                                     class="img-fluid w-100 h-100"
                                     style="object-fit: cover;">
                            @else
                                <span class="font-weight-bold">{{ $userInitials }}</span>
                            @endif
                        </div>
                        <div>
                            <div class="font-weight-bold">{{ $userName }}</div>
                            @if($user && !empty($user->email))
                                <div class="small text-muted">{{ $user->email }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Profile Link -->
                <a class="dropdown-item py-2" href="{{ route('profile.edit') }}">
                    <i class="fas fa-user-circle fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile Settings
                </a>

                @if(Route::has('help'))
                <a class="dropdown-item py-2" href="{{ route('help') }}">
                    <i class="fas fa-question-circle fa-sm fa-fw mr-2 text-gray-400"></i>
                    Help & Support
                </a>
                @endif

                <div class="dropdown-divider"></div>

                <!-- Logout Form -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="dropdown-item py-2 text-danger"
                            onclick="event.preventDefault(); if(confirm('Are you sure you want to logout?')) this.closest('form').submit();">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Sign Out
                    </button>
                </form>

                <!-- System Info Footer -->
                <div class="bg-light py-2 px-3 small text-muted border-top">
                    <div class="d-flex justify-content-between">
                        <span>System v{{ config('app.version', '1.0') }}</span>
                        <span>© {{ date('Y') }} Govt</span>
                    </div>
                </div>
            </div>
        </li>

        <!-- Accessibility: Skip to main content link (for keyboard users) -->
        <li class="nav-item d-none">
            <a href="#main-content" class="sr-only sr-only-focusable">Skip to main content</a>
        </li>
    </ul>
</nav>

@push('styles')
<style>
    /* Custom styles for government header */
    .user-avatar {
        transition: all 0.2s ease;
        border: 2px solid transparent;
    }

    .nav-link:hover .user-avatar {
        border-color: var(--primary, #007bff);
    }

    /* Accessibility focus styles */
    .navbar .nav-link:focus-visible {
        outline: 2px solid var(--primary, #007bff);
        outline-offset: 2px;
        border-radius: 4px;
    }

    /* Government theme subtle styling */
    .border-bottom {
        border-bottom: 1px solid #e9ecef !important;
    }

    /* Better mobile experience */
    @media (max-width: 767.98px) {
        .badge-counter {
            position: relative;
            top: -8px;
            right: 5px;
        }
    }

    /* Print styles */
    @media print {
        .navbar {
            display: none !important;
        }
    }
</style>
@endpush
