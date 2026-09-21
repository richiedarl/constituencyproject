@extends('layouts.admin')

@section('title', 'Pending Donations')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Pending Donations</h1>
    <div class="alert alert-info">{{ $stats['total_pending'] }} pending contribution(s), worth ₦{{ number_format($stats['total_amount']) }}.</div>
    <div class="card shadow-sm"><div class="table-responsive"><table class="table mb-0"><thead><tr><th>Contributor</th><th>Project</th><th>Amount</th><th>Date</th><th>Actions</th></tr></thead><tbody>
        @forelse($donations as $donation)<tr><td>{{ $donation->contributor?->user?->name ?? 'Unknown' }}</td><td>{{ $donation->project?->title ?? 'Deleted project' }}</td><td>₦{{ number_format($donation->amount) }}</td><td>{{ $donation->created_at->format('d M Y') }}</td><td class="d-flex gap-2"><form method="POST" action="{{ route('admin.donations.approve', $donation) }}">@csrf<button class="btn btn-sm btn-success">Approve</button></form><form method="POST" action="{{ route('admin.donations.reject', $donation) }}">@csrf @method('DELETE')<input type="hidden" name="rejection_reason" value="Rejected by administrator"><button class="btn btn-sm btn-outline-danger">Reject</button></form></td></tr>@empty<tr><td colspan="5" class="text-center py-4">No pending donations.</td></tr>@endforelse
    </tbody></table></div></div>
</div>
@endsection
