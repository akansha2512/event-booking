@extends('layouts.user')

@section('content')
<div class="container">
    <h3 class="mb-4">My Bookings</h3>

    <!-- @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif -->

    @if ($bookings->count())
        <ul class="list-group">
            @foreach($bookings as $booking)
                <li class="list-group-item">
                    <strong>{{ $booking->event->title }}</strong> <br>
                    Seats Booked: {{ $booking->seats_booked }} <br>
                    Date: {{ \Carbon\Carbon::parse($booking->created_at)->format('d M Y') }}<br>
                    Time: {{ \Carbon\Carbon::parse($booking->created_at)->format('h:i A') }}
                </li>
            @endforeach
        </ul>
        <div class="mt-3">
            {{ $bookings->links() }}
        </div>
    @else
        <p>No bookings yet.</p>
    @endif
</div>
@endsection
