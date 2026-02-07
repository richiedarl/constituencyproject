@php
    use App\Models\Application;
    use App\Models\ContactEnquiry;

    $unreadApplications = class_exists(Application::class)
        ? Application::whereNull('opened_at')->count()
        : 0;

    $unreadContacts = class_exists(ContactEnquiry::class)
        ? ContactEnquiry::whereNull('opened_at')->count()
        : 0;
@endphp


<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Mobile Only) -->
    <button id="sidebarToggleTop"
            class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Spacer -->
    <div class="ml-auto"></div>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav">

        <!-- Divider -->
        <div class="topbar-divider d-none d-sm-block"></div>
<!-- Contact Enquiries -->
<li class="nav-item dropdown no-arrow mx-1">
    <a class="nav-link" href="{{ route('admin.contacts.index') }}">
        <i class="fas fa-envelope fa-fw"></i>

        @if($unreadContacts > 0)
            <span class="badge badge-danger badge-counter">
                {{ $unreadContacts }}
            </span>
        @endif
    </a>
</li>

<!-- Applications -->
<li class="nav-item dropdown no-arrow mx-1">
    <a class="nav-link" href="{{ route('admin.applications.index') }}">
        <i class="fas fa-file-alt fa-fw"></i>

        @if($unreadApplications > 0)
            <span class="badge badge-warning badge-counter">
                {{ $unreadApplications }}
            </span>
        @endif
    </a>
</li>

<!-- Divider -->
<div class="topbar-divider d-none d-sm-block"></div>

        <!-- User Dropdown -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle"
               href="#"
               id="userDropdown"
               role="button"
               data-toggle="dropdown"
               aria-haspopup="true"
               aria-expanded="false">

                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                    {{ auth()->user()->name ?? 'Admin' }}
                </span>

                <img class="img-profile rounded-circle"
                     src="{{ asset('admin/img/undraw_profile.svg') }}">
            </a>

            <!-- Dropdown -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                 aria-labelledby="userDropdown">

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Logout
                    </button>
                </form>

            </div>
        </li>

    </ul>

</nav>
