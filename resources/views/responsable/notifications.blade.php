@extends('templates.navbar3')


@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-primary">
            <i class="fas fa-bell me-2"></i>Mes notifications
        </h3>
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i>Retour
        </a>
    </div>

    @if ($notifications->count())
        <div class="list-group shadow-sm rounded-3">
            @foreach ($notifications as $notification)
                @php
                    $isUnread = $notification->read_at === null;
                @endphp
                <a href="#" 
                   class="list-group-item list-group-item-action d-flex align-items-start {{ $isUnread ? 'bg-light' : '' }}">
                    <div class="flex-shrink-0 mt-1">
                        <i class="fas {{ $isUnread ? 'fa-exclamation-circle text-warning' : 'fa-check-circle text-success' }} fa-lg"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-1 fw-semibold">Nouveau sinistre assigné</h6>
                            <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                        </div>
                        <p class="mb-0 text-muted small">
                            Sinistre : <span class="fw-semibold text-dark">{{ $notification->data['data']['num_sin'] ?? '-' }}</span>
                        </p>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-3">
            {{ $notifications->links('pagination::bootstrap-5') }}
        </div>
    @else
        <div class="text-center text-muted py-5">
            <i class="fas fa-inbox fa-3x mb-3"></i>
            <p class="fs-5">Aucune notification pour le moment.</p>
        </div>
    @endif
</div>
@endsection
