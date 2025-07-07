<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
class EventController extends Controller
{
     // Show all events
    public function index()
    {
        $events = Event::latest()->paginate(10);
        return view('admin.events.index', compact('events'));
    }

    // Show form to create new event
    public function create()
    {
        return view('admin.events.create');
    }

    // Store new event to DB
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'location' => 'required',
            'total_seats' => 'required|integer|min:1',
            'available_seats' => 'required|integer|min:1|lte:total_seats',
        ]);

        Event::create($validated);
        return redirect('/admin/events')->with('success', 'Event created!');
    }

    // Show form to edit existing event
    public function edit($id)
    {
        $event = Event::findOrFail($id);
        return view('admin.events.edit', compact('event'));
    }

    // Update existing event
    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'location' => 'required',
            'total_seats' => 'required|integer|min:1',
            'available_seats' => 'required|integer|min:1|lte:total_seats',
        ]);

        $event->update($validated);
        return redirect('/admin/events')->with('success', 'Event updated!');
    }

    // Delete event
    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete(); // soft delete
        // return redirect('/admin/events')->with('success', 'Event deleted!');
        // return redirect('/admin/events');
        return redirect('/admin/events')->with('danger', 'Event deleted!');

    }
}
