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
                    <a class="collapse-item" href="{{ route('submissions.index') }}">All Applications</a>
                    <a class="collapse-item" href="{{ route('submissions.pending') }}">Pending Applications</a>
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
                    <a class="collapse-item" href="{{ route('admin.projects.index') }}">All Projects</a>
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
                    <a class="collapse-item" href="{{ route('candidates.index.all') }}">View All Candidates</a>
                </div>
            </div>
        </li>
     <!-- ================= REPORT KEYS ================= -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse"
       data-target="#collapseReportKeys">
        <i class="fas fa-fw fa-key"></i>
        <span>Report Keys</span>
    </a>

    <div id="collapseReportKeys" class="collapse" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">

            <a class="collapse-item" href="{{ route('allKeys') }}">
                All License Keys
            </a>

            <a class="collapse-item" href="{{ route('keyrequests') }}">
                Key Requests
            </a>

            <a class="collapse-item" href="{{ route('generatekey') }}">
                Generate New Key
            </a>

            <a class="collapse-item" href="{{ route('expiredkeys') }}">
                Expired Keys
            </a>

        </div>
    </div>
</li>

<!-- Role Change Requests -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseRoleRequests">
        <i class="fas fa-fw fa-user-tag"></i>
        <span>Role Requests</span>
    </a>

    <div id="collapseRoleRequests" class="collapse" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{ route('checks.role-requests.index') }}">
                <i class="fas fa-list me-2"></i>All Requests
            </a>
            <a class="collapse-item" href="{{ route('checks.role-requests.pending') }}">
                <i class="fas fa-clock me-2 text-warning"></i>Pending
            </a>
            <a class="collapse-item" href="{{ route('checks.role-requests.approved') }}">
                <i class="fas fa-check-circle me-2 text-success"></i>Approved
            </a>
            <a class="collapse-item" href="{{ route('checks.role-requests.rejected') }}">
                <i class="fas fa-times-circle me-2 text-danger"></i>Rejected
            </a>
        </div>
    </div>
</li>

<!-- User Management -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsers">
        <i class="fas fa-fw fa-users"></i>
        <span>User Management</span>
    </a>

    <div id="collapseUsers" class="collapse" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{ route('checks.users.index') }}">
                <i class="fas fa-user me-2"></i>All Users
            </a>
        </div>
    </div>
</li>

<!-- ================= CANDIDATE REPORTS ================= -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse"
       data-target="#collapseReports">
        <i class="fas fa-fw fa-file-alt"></i>
        <span>Candidate Reports</span>
    </a>

    <div id="collapseReports" class="collapse" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">

            <a class="collapse-item" href="{{ route('candidatesReports') }}">
                All Candidates
            </a>

            <a class="collapse-item" href="{{ route('generatereport') }}">
                Generate Report
            </a>

        </div>
    </div>
</li>


<!-- ================= LICENSE SETTINGS ================= -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse"
       data-target="#collapseLicense">
        <i class="fas fa-fw fa-cog"></i>
        <span>License Settings</span>
    </a>

    <div id="collapseLicense" class="collapse" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">

            <a class="collapse-item" href="{{ route('license.settings') }}">
                General Settings
            </a>

            <a class="collapse-item" href="{{ route('license.logs') }}">
                Access Logs
            </a>

        </div>
    </div>
</li>
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseWallet">
        <i class="fas fa-fw fa-wallet"></i>
        <span>Wallet Management</span>
    </a>

    <div id="collapseWallet" class="collapse" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{ route('pendingFundingRequests') }}">
                <i class="fas fa-clock me-2"></i>Pending Funding
            </a>
            <a class="collapse-item" href="{{ route('pendingWithdrawals') }}">
                <i class="fas fa-arrow-up me-2"></i>Pending Withdrawals
            </a>
            <a class="collapse-item" href="{{ route('allTransactions') }}">
                <i class="fas fa-history me-2"></i>All Transactions
            </a>
            <a class="collapse-item" href="{{ route('walletSummary') }}">
                <i class="fas fa-chart-pie me-2"></i>Wallet Summary
            </a>
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
        <li class="nav-item">
            <a class="nav-link" href="{{ route('personal.funds.index') }}">
                <i class="fas fa-wallet"></i>
                <span>Payment Settings</span>
            </a>
        </li>

        <!-- Reports Management -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse"
       data-target="#collapseReportNormal">
        <i class="fas fa-fw fa-file-alt"></i>
        <span>Reports</span>
    </a>

    <div id="collapseReportNormal" class="collapse" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">

            <a class="collapse-item d-flex justify-content-between align-items-center"
               href="{{ route('submitted.reports.index') }}">
                <span>
                    <i class="fas fa-list me-2"></i>
                    All Reports
                </span>
            </a>

            <a class="collapse-item d-flex justify-content-between align-items-center"
               href="{{ route('submitted.reports.pending') }}">
                <span>
                    <i class="fas fa-clock me-2" style="color: #ffc107;"></i>
                    Pending
                </span>
            </a>

            <a class="collapse-item" href="{{ route('submitted.reports.approved') }}">
                <i class="fas fa-check-circle me-2 text-success"></i>
                Approved
            </a>

            <a class="collapse-item" href="{{ route('submitted.reports.rejected') }}">
                <i class="fas fa-times-circle me-2 text-danger"></i>
                Rejected
            </a>

        </div>
    </div>
</li>

        {{-- <!-- Reports -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('reports.index') }}">
                <i class="fas fa-fw fa-chart-line"></i>
                <span>Reports</span>
            </a>
        </li> --}}

{{-- ================= USER ================= --}}
@else

    {{-- ================= APPLICATIONS ================= --}}
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseApplications">
            <i class="fas fa-fw fa-clipboard-list"></i>
            <span>Applications</span>
        </a>

        <div id="collapseApplications" class="collapse" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">

                <a class="collapse-item" href="{{ route('user.applications.index') }}">
                    <i class="fas fa-list me-2"></i>All Applications
                </a>

                <a class="collapse-item" href="{{ route('applications.pending') }}">
                    <i class="fas fa-hourglass-half me-2 text-warning"></i>Pending
                </a>

                <a class="collapse-item" href="{{ route('applications.approved') }}">
                    <i class="fas fa-check-circle me-2 text-success"></i>Approved
                </a>

                <a class="collapse-item" href="{{ route('applications.cancelled') }}">
                    <i class="fas fa-times-circle me-2 text-danger"></i>Cancelled
                </a>

            </div>
        </div>
    </li>


    {{-- ================= PROJECTS ================= --}}
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUserProjects">
            <i class="fas fa-fw fa-folder-open"></i>
            <span>Projects</span>
        </a>

        <div id="collapseUserProjects" class="collapse" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">

                {{-- Contractors --}}
                @if(Auth::user()->contractor)

                    <a class="collapse-item" href="{{ route('contractor.my.projects') }}">
                        My Projects
                    </a>

                    <a class="collapse-item" href="{{ route('contractor.projects.active') }}">
                        Active Projects
                    </a>

                    <a class="collapse-item" href="{{ route('contractor.past.projects') }}">
                        Past Projects
                    </a>

                    <a class="collapse-item" href="#">
                        Submit Daily Report
                    </a>

                    <a class="collapse-item" href="{{ route('user.projects.index') }}">
                        All Projects
                    </a>

                {{-- Candidates & Contributors --}}
                @else

                    <a class="collapse-item" href="{{ route('user.projects.index') }}">
                        Browse All Projects
                    </a>

                    <a class="collapse-item" href="{{ route('user.mine.projects') }}">
                        My Projects
                    </a>

                    <a class="collapse-item" href="{{ route('user.projects.completed') }}">
                        Completed Projects
                    </a>

                    <a class="collapse-item" href="{{ route('user.projects.past-projects') }}">
                        Past Projects
                    </a>

                @endif

            </div>
        </div>
    </li>


    {{-- ================= FINANCES ================= --}}
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFinances">
            <i class="fas fa-fw fa-wallet"></i>
            <span>Finances</span>
        </a>

        <div id="collapseFinances" class="collapse" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">

                {{-- Contractors --}}
                @if(Auth::user()->contractor)

                    <a class="collapse-item" href="{{ route('wallet.withdraw') }}">
                        Request Withdrawal
                    </a>

                    <a class="collapse-item" href="#">
                        Pending Withdrawals
                    </a>

                    <a class="collapse-item" href="{{ route('wallet.transactions') }}">
                        My Transactions
                    </a>

                    <a class="collapse-item" href="{{ route('reports.index') }}">
                        Submit Daily Report
                    </a>

                {{-- Candidates & Contributors --}}
                @else

                    <a class="collapse-item" href="{{ route('wallet.fund') }}">
                        Fund Wallet
                    </a>

                    <a class="collapse-item" href="{{ route('wallet.transactions') }}">
                        My Transactions
                    </a>

                @endif

            </div>
        </div>
    </li>


@endif
<hr class="sidebar-divider d-none d-md-block">
<!-- Profile -->
<li class="nav-item">
    <a class="nav-link" href="{{ route('profile.edit') }}">
        <i class="fas fa-fw fa-chart-area"></i>
        <span>Profile</span></a>
</li>

<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

</ul>
