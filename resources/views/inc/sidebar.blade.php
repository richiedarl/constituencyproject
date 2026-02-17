<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center"
       href="{{ route('dashboard') }}">
        <img src="{{ asset('fe/assets/img/logo.png') }}"
             alt="Constituency Project"
             class="admin-logo">
    </a>

    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Management
    </div>

    {{-- ================= ADMIN ================= --}}
    @if(Auth::user()->admin)

        <!-- Applications -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse"
               data-target="#collapseApplications">
                <i class="fas fa-fw fa-clipboard-list"></i>
                <span>Applications</span>
            </a>

            <div id="collapseApplications" class="collapse" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('admin.applications.index') }}">All Applications</a>
                    <a class="collapse-item" href="{{ route('contractors.index') }}">All Contractors</a>
                </div>
            </div>
        </li>

        <!-- Projects -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse"
               data-target="#collapseProjects">
                <i class="fas fa-fw fa-folder-open"></i>
                <span>Projects</span>
            </a>

            <div id="collapseProjects" class="collapse" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('admin.projects.active') }}">Active Projects</a>
                    <a class="collapse-item" href="">My Projects</a>
                    <a class="collapse-item" href="{{ route('admin.projects.create') }}">Add New Project</a>
                </div>
            </div>
        </li>

        <!-- Candidates -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse"
               data-target="#collapseCandidates">
                <i class="fas fa-fw fa-user-tie"></i>
                <span>Candidates</span>
            </a>

            <div id="collapseCandidates" class="collapse" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('candidates.create') }}">Add Candidate</a>
                    <a class="collapse-item" href="{{ route('candidates.index') }}">View All Candidates</a>
                </div>
            </div>
        </li>

        <!-- Portfolios -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('portfolios.index') }}">
                <i class="fas fa-fw fa-id-badge"></i>
                <span>Portfolios</span>
            </a>
        </li>

        <!-- Reports -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('reports.index') }}">
                <i class="fas fa-fw fa-chart-line"></i>
                <span>Reports</span>
            </a>
        </li>

    {{-- ================= USER ================= --}}
    @else

        <!-- Applications -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse"
               data-target="#collapseApplications">
                <i class="fas fa-fw fa-clipboard-list"></i>
                <span>Applications</span>
            </a>

            <div id="collapseApplications" class="collapse" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('applications.index') }}">My Applications</a>
                    <a class="collapse-item" href="">Approved</a>
                    <a class="collapse-item" href="">Cancelled</a>
                </div>
            </div>
        </li>

        <!-- Projects -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse"
               data-target="#collapseProjects">
                <i class="fas fa-fw fa-folder-open"></i>
                <span>Projects</span>
            </a>

            <div id="collapseProjects" class="collapse" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('contractor.my.projects') }}">My Projects</a>
                    <a class="collapse-item" href="{{ route('contractor.projects.active') }}">Active Projects</a>
                    <a class="collapse-item" href="{{ route('contractor.past.projects') }}">Past Projects</a>
                </div>
            </div>
        </li>

    @endif

    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
