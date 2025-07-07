@extends('layouts.user') {{-- Make sure layouts/user.blade.php exists --}}

@section('content')
   <h2 class="mb-4 text-dark"> Available Events</h2>
    <!-- 🔍 Search Form -->
    <form action="{{ route('user.events') }}" method="GET" class="row mb-4">
        <div class="col-md-6">
            <input type="text" name="search" class="form-control" placeholder="Search by title or location" value="{{ request('search') }}">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">🔍 Search</button>
        </div>
        <div class="col-md-2">
            <a href="{{ route('user.events') }}" class="btn btn-secondary w-100"> Reset</a>
        </div>
    </form>
    @if ($events->count())
        <div class="row">
            @foreach ($events as $event)
                <div class="col-md-6 mb-4">
                    <div class="card shadow">
                        <div class="card-body">
                            <h5 class="card-title">{{ $event->title }}</h5>
                            <p class="card-text">{{ $event->description }}</p>
                            <p><strong>Location:</strong> {{ $event->location }}</p>
                            <p><strong>Available Seat:</strong> {{ $event->available_seats }}</p>
                            <p><strong>Total Seat:</strong> {{ $event->total_seats }}</p>

                            <p><strong>Seats Available:</strong> {{ $event->available_seats }} / {{ $event->total_seats }}</p>
                           <p><strong>Date:</strong>  
                                {{ \Carbon\Carbon::parse($event->start_time)->format('d M Y') }}
                            </p>
                            <p><strong>Time:</strong>  
                                {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }} 
                                to 
                                {{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}
                            </p>
                            {{-- Check if user has booked this event --}}
                                @if ($userBookings->has($event->id))
                                    <p><strong>Booked Seats:</strong>  {{ $userBookings[$event->id] }}</p>
                                @else
                                    <p><strong> You have not booked event yet.</strong></p>
                                @endif

                              <a href="{{ route('user.events.book', $event->id) }}" class="btn btn-success">Book Now</a>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>

       <div class="mt-4 d-flex justify-content-center">
            {{ $events->appends(['search' => request('search')])->links() }}
        </div>
    @else
        <p>No upcoming events available.</p>
    @endif
@endsection
