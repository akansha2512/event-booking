@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="text-dark mb-4"> Create New Event</h2>

    <a href="{{ route('events.index') }}" class="btn btn-secondary mb-3">
        ← Back to Events
    </a>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Please fix the errors below.
            <ul>
                @foreach ($errors->all() as $error)
                    <li> {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('events.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="title" class="form-label">Event Title</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Event Description</label>
                    <textarea name="description" class="form-control" rows="3" required>{{ old('description') }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="start_time" class="form-label">Start Time</label>
                        <input type="datetime-local" name="start_time" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="end_time" class="form-label">End Time</label>
                        <input type="datetime-local" name="end_time" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" name="location" class="form-control" value="{{ old('location') }}" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="total_seats" class="form-label">Total Seats</label>
                        <input type="number" name="total_seats" class="form-control" value="{{ old('total_seats') }}" min="1" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="available_seats" class="form-label">Available Seats</label>
                        <input type="number" name="available_seats" class="form-control" value="{{ old('available_seats') }}" min="1" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-success w-100 mt-2">
                     Create Event
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
