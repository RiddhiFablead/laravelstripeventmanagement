<?php

namespace App\Http\Controllers;

use App\Models\EventSchedule;
use Illuminate\Http\Request;

class EventscheduleController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'event_id'=>'required|exists:events,id',
            'schedule_date'=>'required|array',
            'schedule_time'=>'required|array',
             'schedule_date.*' => 'required|date',
            'schedule_time.*' => 'required'
        ]);
         foreach ($request->schedule_date as $index => $date) {
            EventSchedule::create([
                'event_id' => $request->event_id,
                'date' => $date,
                'time' => $request->schedule_time[$index]
            ]);
         }
        return response()->json([
            'message'=>'Event schedule added successfully'
        ]);
    }
    public function view()
    {
        return view('eventschedule');
    }
}
