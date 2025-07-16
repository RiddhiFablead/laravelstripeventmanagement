<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Console\Scheduling\Event as SchedulingEvent;
use Illuminate\Http\Request;

class CalenderController extends Controller
{
    
   
    public function view()
    {
        return view('dashboard');
    }
      public function getEvents()
    {
        $events = Event::all();

        $formattedEvents = [];

        foreach ($events as $event) {
            $formattedEvents[] = [
                'title' => $event->name,
                'start' => $event->date,
                'url' => route('events.show', $event->id),
            ];
        }

        return response()->json($formattedEvents);
    }

}
