<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Event;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function store(Request $request,Event $event)
    {
        $validated=$request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|email',
            'schedule_ids'=>'required|array',
            'schedule_ids.*' => 'exists:events_schedule,id',

        ]);
        foreach($validated['schedule_ids']as $scheduleId){
            Booking::create([
                'event_id'=>$event->id,
                'event_schedule_id'=>$scheduleId,
                'name'=>$validated['name'],
                'email'=>$validated['email'],
            ]);
        }
        return back()->with('success', 'Booking successful!');
    }
}
