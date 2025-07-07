<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
class UserEventController extends Controller
{
//    public function index()
//     {
//         $events = Event::where('start_time', '>', now())
//                         ->orderBy('start_time')
//                         ->paginate(6);

//         return view('user.events.index', compact('events'));
//     }

// public function index(Request $request)
// {
//     $search = $request->input('search');

//     $events = Event::where('start_time', '>', now())
//         ->when($search, function ($query, $search) {
//             return $query->where(function($q) use ($search) {
//                 $q->where('title', 'like', '%' . $search . '%')
//                   ->orWhere('location', 'like', '%' . $search . '%');
//             });
//         })
//         ->orderBy('start_time')
//         ->paginate(6);

//     return view('user.events.index', compact('events', 'search'));
// }





public function index(Request $request)
{
    // $query = Event::where('start_time', '>', now());
    $query = Event::where('end_time', '>', now());

    if ($request->has('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('location', 'like', "%{$search}%");
        });
    }

    $events = $query->orderBy('start_time')->paginate(6);

    // Get current user's bookings
    $userBookings = Booking::where('user_id', Auth::id())
        ->pluck('seats_booked', 'event_id'); // [event_id => seats_booked]

    return view('user.events.index', compact('events', 'userBookings'));
}

}
