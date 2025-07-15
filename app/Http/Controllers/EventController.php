<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventSchedule;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function create()
    {
        return view('event.create');
    }
    public function store(Request $request)
    {
        // Validate inputs
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'location' => 'required|string',
            'img' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'schedule_date' => 'required|array',
            'schedule_date.*' => 'date',
            'schedule_time' => 'required|array',
            'schedule_time.*' => 'date_format:H:i',
        ]);

        // Handle image upload
        if ($request->hasFile('img')) {
            $path = $request->file('img')->store('events', 'public');
            $validated['img'] = $path;
        }

        // Create the main event
        $event = Event::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'location' => $validated['location'],
            'img' => $validated['img'] ?? null,
        ]);

        // Save schedule entries
        foreach ($request->schedule_date as $index => $date) {
            EventSchedule::create([
                'event_id' => $event->id,
                'date' => $date,
                'time' => $request->schedule_time[$index],
            ]);
        }

        return response()->json(['message' => 'Event created successfully.'], 200);
    }


  
public function index()
{
    $events = Event::with('schedules')->get(); 
    return view('events.index', compact('events')); 
}

   
}
