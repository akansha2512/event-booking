<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
class EventApiController extends Controller
{
    //  public function index(Request $request)
    // {
    //     $query = Event::where('start_time', '>', now());

    //     if ($request->has('search')) {
    //         $search = $request->search;
    //         $query->where(function ($q) use ($search) {
    //             $q->where('title', 'like', "%{$search}%")
    //               ->orWhere('location', 'like', "%{$search}%");
    //         });
    //     }

    //     $events = $query->orderBy('start_time')->paginate(6);

    //     return response()->json($events);
    // }

    public function index(Request $request)
    {
        $query = Event::where('start_time', '>', now());

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $events = $query->orderBy('start_time', 'asc')->paginate(6);

        return response()->json($events);
    }
}
