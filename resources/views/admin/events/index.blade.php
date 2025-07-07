@extends('layouts.admin')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
       <h2 class="text-dark">Events</h2> 
        <a href="{{ route('events.create') }}" class="btn btn-success">
            ➕ Add Event
        </a>
    </div>

    @if($events->count())
    <div class="table-responsive shadow">
        <table class="table table-hover table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Location</th>
                    <th>Total Seats</th>
                    <th>Available Seats</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($events as $index => $event)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $event->title }}</td>
                    <td>{{ \Carbon\Carbon::parse($event->start_time)->format('d M Y h:i A') }}</td>
                    <td>{{ \Carbon\Carbon::parse($event->end_time)->format('d M Y h:i A') }}</td>
                    <td>{{ $event->location }}</td>
                    <td>{{ $event->total_seats }}</td>
                    <td>{{ $event->available_seats }}</td>
                    <td>
                        <a href="{{ route('events.edit', $event->id) }}" class="btn btn-sm btn-primary">
                             Edit
                        </a>
                        <!-- <form action="{{ route('events.destroy', $event->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure to delete?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                🗑️ Delete
                            </button>
                        </form> -->

                        <form action="{{ route('events.destroy', $event->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                 Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $events->links() }} <!-- Pagination -->
    </div>
    @else
        <p>No events available.</p>
    @endif
</div>
@endsection
