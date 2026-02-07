{{-- @php
    use App\Models\Offer;
    use App\Models\Staff;
    use App\Models\Application;
    use Carbon\Carbon;

    $totalOffers = class_exists(Offer::class) ? Offer::count() : 0;
    $totalStaffs = class_exists(Staff::class) ? Staff::count() : 0;
    $totalApplications = class_exists(Application::class) ? Application::count() : 0;

    $todaysApplications = class_exists(Application::class)
        ? Application::whereDate('created_at', Carbon::today())->count()
        : 0;
@endphp --}}

@extends('layouts.admin')

@section('content')
<div class="container-fluid">
<!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                            <i
                                class="fas fa-download fa-sm text-white-50"></i> 
                                Generate Report</a>
                    </div>


<!-- Stats Row -->
<div class="row">

    <!-- Total Projects -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Projects
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            12
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-project-diagram fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ongoing Projects -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Ongoing Projects
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            5
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-tasks fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Applications -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Total Applications
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            48
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-file-signature fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Today's Applications -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Today’s Applications
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            6
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Payments -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-dark shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                            Total Payments
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            ₦12,450,000
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-wallet fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Today's Payments -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            Today’s Payments
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            ₦320,000
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


</div>
@endsection
