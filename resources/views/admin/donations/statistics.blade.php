@extends('layouts.admin')

@section('title', 'Donation Statistics')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Donation Statistics</h1>
    <div class="row mb-4">
        <div class="col-md-4"><div class="card"><div class="card-body"><small>Approved donations</small><h3>₦{{ number_format($totalDonations) }}</h3></div></div></div>
        <div class="col-md-4"><div class="card"><div class="card-body"><small>Contributors</small><h3>{{ $totalContributors }}</h3></div></div></div>
        <div class="col-md-4"><div class="card"><div class="card-body"><small>Supported projects</small><h3>{{ $totalProjects }}</h3></div></div></div>
    </div>
    <div class="card shadow-sm"><div class="card-header">Top Projects</div><div class="table-responsive"><table class="table mb-0"><thead><tr><th>Project</th><th>Donated</th></tr></thead><tbody>@forelse($topProjects as $project)<tr><td>{{ $project->title }}</td><td>₦{{ number_format($project->donations_sum_amount ?? 0) }}</td></tr>@empty<tr><td colspan="2" class="text-center py-4">No donation data.</td></tr>@endforelse</tbody></table></div></div>
</div>
@endsection
