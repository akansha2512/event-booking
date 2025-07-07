<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
class BookingController extends Controller
{
   




    public function bookForm($id)
    {
        $event = Event::findOrFail($id);
        return view('user.events.book', compact('event'));
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'seats_booked' => 'required|integer|min:1',
        ]);

        $event = Event::findOrFail($id);

        // if (now() > $event->end_time) {
        //     return back()->with('error', 'Cannot book a past event.');
        // }

        // if ($request->seats_booked > $event->available_seats) {
        //     return back()->with('error', 'Not enough available seats.');
        // }

        // Prevent booking if event has already started
            if (now()->greaterThanOrEqualTo($event->start_time)) {
                return back()->with('error', 'Booking not allowed. The event has already started.');
            }

            // Prevent booking past event
            if (now() > $event->end_time) {
                return back()->with('error', 'Cannot book a past event.');
            }

            // Prevent overbooking
            if ($request->seats_booked > $event->available_seats) {
                return back()->with('error', 'Not enough available seats.');
            }

        Booking::create([
            'user_id' => Auth::id(),
            'event_id' => $event->id,
            'seats_booked' => $request->seats_booked
        ]);

        $event->available_seats -= $request->seats_booked;
        $event->save();

        return redirect()->route('user.bookings')->with('success', 'Booking successful!');
    }

    public function myBookings()
    {
        $bookings = Booking::with('event')
                        ->where('user_id', Auth::id())
                        ->latest()
                        ->paginate(10);

        return view('user.events.my_bookings', compact('bookings'));
    }
}
