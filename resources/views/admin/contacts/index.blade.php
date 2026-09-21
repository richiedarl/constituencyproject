@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <div>
            <h1 class="h3 mb-1">Contact enquiries</h1>
            <p class="text-muted mb-0">Messages submitted through the public contact form.</p>
        </div>
        <form method="GET" class="form-inline mt-3 mt-md-0">
            <select name="status" class="form-control mr-2" aria-label="Filter by status">
                <option value="">All statuses</option>
                @foreach(['pending', 'approved', 'rejected'] as $status)
                    <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
            <button class="btn btn-primary" type="submit">Filter</button>
        </form>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead><tr><th>From</th><th>Subject</th><th>Type</th><th>Candidate</th><th>Status</th><th>Received</th></tr></thead>
                <tbody>
                    @forelse($contacts as $contact)
                        <tr>
                            <td><strong>{{ $contact->name }}</strong><br><small>{{ $contact->email }}</small></td>
                            <td>{{ $contact->subject }}<br><small class="text-muted">{{ \Illuminate\Support\Str::limit($contact->content, 90) }}</small></td>
                            <td>{{ str($contact->type)->replace('_', ' ')->title() }}</td>
                            <td>{{ $contact->candidate?->name ?? '—' }}</td>
                            <td><span class="badge badge-{{ $contact->status === 'approved' ? 'success' : ($contact->status === 'rejected' ? 'danger' : 'warning') }}">{{ ucfirst($contact->status) }}</span></td>
                            <td>{{ $contact->created_at?->format('d M Y, H:i') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-5 text-muted">No contact enquiries found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">{{ $contacts->links() }}</div>
</div>
@endsection
