@extends('layouts.user')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-dark">Available Events</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @forelse($events as $event)
        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">{{ $event->title }}</h5>
                <p class="card-text">{{ $event->description }}</p>
                <p class="card-text"><strong>Start:</strong> {{ $event->start_time }}</p>
                <p class="card-text"><strong>End:</strong> {{ $event->end_time }}</p>
                <p class="card-text"><strong>Available Seats:</strong> {{ $event->available_seats }}</p>

                <form action="{{ route('book.event') }}" method="POST">
                    @csrf
                    <input type="hidden" name="event_id" value="{{ $event->id }}">
                    <div class="row mb-2">
                        <div class="col-md-3">
                            <input type="number" name="seats_booked" class="form-control" placeholder="Seats" min="1" max="{{ $event->available_seats }}" required>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary">Book</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @empty
        <p>No upcoming events found.</p>
    @endforelse
</div>
@endsection
