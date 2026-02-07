{{-- Only show sidebar if admin --}}
@if(Auth::user()->admin)

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center"
   href="{{ route('dashboard') }}">

    <img
        src="{{ asset('fe/assets/img/logo.png') }}"
        alt="Constituency Project"
        class="admin-logo"
    >

</a>

    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Management
    </div>

    <!-- Projects -->
    <li class="nav-item {{ request()->is('admin/projects*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse"
           data-target="#collapseProjects" aria-expanded="true">
            <i class="fas fa-fw fa-folder-open"></i>
            <span>Projects</span>
        </a>

        <div id="collapseProjects"
             class="collapse {{ request()->is('admin/projects*') ? 'show' : '' }}"
             data-parent="#accordionSidebar">

            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('projects.active') }}">
                    Active Projects
                </a>

                <a class="collapse-item" href="{{ route('admin.projects.index') }}">
                    View All Projects
                </a>

                <a class="collapse-item" href="{{ route('admin.projects.create') }}">
                    Add New Project
                </a>
            </div>
        </div>
    </li>

    <!-- Candidates / Personalities -->
    <li class="nav-item {{ request()->is('admin/candidates*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse"
           data-target="#collapseCandidates" aria-expanded="true">
            <i class="fas fa-fw fa-user-tie"></i>
            <span>Candidates</span>
        </a>

        <div id="collapseCandidates"
             class="collapse {{ request()->is('admin/candidates*') ? 'show' : '' }}"
             data-parent="#accordionSidebar">

            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('candidates.create') }}">
                    Add Candidate
                </a>

                <a class="collapse-item" href="{{ route('candidates.index') }}">
                    View All Candidates
                </a>
            </div>
        </div>
    </li>

    <!-- Portfolios -->
    <li class="nav-item {{ request()->is('admin/portfolios*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('portfolios.index') }}">
            <i class="fas fa-fw fa-id-badge"></i>
            <span>Portfolios</span>
        </a>
    </li>

    <!-- Reports -->
    <li class="nav-item {{ request()->is('admin/reports*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('reports.index') }}">
            <i class="fas fa-fw fa-chart-line"></i>
            <span>Reports</span>
        </a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>

@endif
