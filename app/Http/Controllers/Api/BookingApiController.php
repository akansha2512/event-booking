<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class BookingApiController extends Controller
{
    public function store(Request $request, $id)
    {
        $request->validate([
            'seats_booked' => 'required|integer|min:1'
        ]);

        $event = Event::findOrFail($id);

        // Validation
        if (now() > $event->end_time) {
            return response()->json(['error' => 'Cannot book past event'], 400);
        }

        if ($request->seats_booked > $event->available_seats) {
            return response()->json(['error' => 'Not enough available seats'], 400);
        }

        if (now() > $event->end_time) {
            return response()->json(['message' => 'You cannot book a past event.'], 422);
        }
        // Create Booking
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'event_id' => $event->id,
            'seats_booked' => $request->seats_booked,
        ]);

        // Update event seats
        $event->available_seats -= $request->seats_booked;
        $event->save();

        return response()->json([
            'message' => 'Booking successful!',
            'booking' => $booking
        ]);
    }

    public function myBookings()
    {
        $bookings = Booking::with('event')
                        ->where('user_id', Auth::id())
                        ->latest()
                        ->get();

        return response()->json($bookings);
    }

    public function cancel($id)
    {
    $booking = Booking::where('id', $id)
                ->where('user_id', auth()->id()) 
                ->first();

    if (!$booking) {
        return response()->json(['message' => 'Booking not found or unauthorized'], 404);
    }

    // Restore seats to the event
    $event = $booking->event;
    $event->available_seats += $booking->seats_booked;
    $event->save();

    // Soft delete
    $booking->delete();

    return response()->json(['message' => 'Booking cancelled successfully (soft deleted)']);
}
}
