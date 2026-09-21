@extends('layouts.admin')

@section('title', 'Donations')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h1 class="h3 mb-1">Donations</h1><p class="text-muted mb-0">Review all project contributions.</p></div>
        <a href="{{ route('admin.donations.statistics') }}" class="btn btn-outline-primary">Statistics</a>
    </div>
    <div class="row mb-4">
        <div class="col-md-3"><div class="card"><div class="card-body"><small>Total volume</small><h4>₦{{ number_format($stats['total']) }}</h4></div></div></div>
        <div class="col-md-3"><div class="card"><div class="card-body"><small>Approved</small><h4>₦{{ number_format($stats['approved']) }}</h4></div></div></div>
        <div class="col-md-3"><div class="card"><div class="card-body"><small>Pending</small><h4>₦{{ number_format($stats['pending']) }}</h4></div></div></div>
        <div class="col-md-3"><div class="card"><div class="card-body"><small>Records</small><h4>{{ $stats['count'] }}</h4></div></div></div>
    </div>
    <div class="card shadow-sm"><div class="table-responsive"><table class="table mb-0"><thead><tr><th>Contributor</th><th>Project</th><th>Amount</th><th>Status</th><th>Date</th></tr></thead><tbody>
        @forelse($donations as $donation)<tr><td>{{ $donation->contributor?->user?->name ?? 'Unknown' }}</td><td>{{ $donation->project?->title ?? 'Deleted project' }}</td><td>₦{{ number_format($donation->amount) }}</td><td><span class="badge badge-{{ $donation->approved ? 'success' : 'warning' }}">{{ $donation->approved ? 'Approved' : 'Pending' }}</span></td><td>{{ $donation->created_at->format('d M Y') }}</td></tr>@empty<tr><td colspan="5" class="text-center py-4">No donations found.</td></tr>@endforelse
    </tbody></table></div></div>
    <div class="mt-4">{{ $donations->links() }}</div>
</div>
@endsection
