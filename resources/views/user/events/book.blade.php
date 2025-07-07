@extends('layouts.user')

@section('content')
<div class="container">
    <h3>Book Event: {{ $event->title }}</h3>

    <!-- @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif -->

   <!-- <form method="POST" action="{{ route('user.events.book.store', $event->id) }}">

        @csrf
        <div class="mb-3">
            <label for="seats_booked" class="form-label">Seats to Book</label>
            <input type="number" name="seats_booked" min="1" max="{{ $event->available_seats }}" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">🎫 Confirm Booking</button>
    </form> -->

    <form action="{{ route('user.events.book.store', $event->id) }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="seats_booked" class="form-label">Number of Seats</label>
        <input type="number" class="form-control" name="seats_booked" min="1" required>
    </div>
    <!-- <button type="submit" class="btn btn-primary">Confirm Booking</button> -->
     @if (now() < $event->start_time)
    <button type="submit" class="btn btn-primary"> Confirm Booking</button>
@elseif (now() >= $event->start_time && now() <= $event->end_time)
    <div class="alert alert-warning">Booking closed. Event has already started.</div>
@else
    <div class="alert alert-danger">Booking not allowed. Event has already ended.</div>
@endif
</form>
</div>
@endsection
