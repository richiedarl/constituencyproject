@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
<section class="py-5 bg-light min-vh-100">
    <div class="container" style="max-width: 900px;">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div><h1 class="h2 mb-1">Notifications</h1><p class="text-muted mb-0">Account, verification, application and report updates.</p></div>
            @if(auth()->user()->unreadNotifications()->exists())
                <form method="POST" action="{{ route('notifications.read-all') }}">@csrf<button class="btn btn-outline-success" type="submit">Mark all as read</button></form>
            @endif
        </div>
        <div class="list-group shadow-sm">
            @forelse($notifications as $notification)
                <a href="{{ route('notifications.read', $notification->id) }}" class="list-group-item list-group-item-action p-4 {{ $notification->read_at ? '' : 'border-start border-success border-4' }}">
                    <div class="d-flex justify-content-between gap-3"><strong>{{ $notification->data['title'] ?? 'Account update' }}</strong><small class="text-muted text-nowrap">{{ $notification->created_at->diffForHumans() }}</small></div>
                    <p class="mb-0 mt-2 text-muted">{{ $notification->data['message'] ?? '' }}</p>
                </a>
            @empty
                <div class="list-group-item text-center py-5 text-muted">No notifications yet.</div>
            @endforelse
        </div>
        <div class="mt-4">{{ $notifications->links() }}</div>
    </div>
</section>
@endsection
